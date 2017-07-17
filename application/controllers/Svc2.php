<?php
/**
* APBDesa
* /application/controllers/Svc2.
* 
* @date 
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/
class Svc2 extends GI_Controller
{
	private function json($arr)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($arr));
	}

	public function spp_angg_rekening($tahun = null, $kode_org = null, $kode_prog = null)
	{
		$kode_org = explode('-', $kode_org);
		$kode_prog = explode('-', $kode_prog);
		if (empty($tahun) || empty($kode_org) || empty($kode_prog) || count($kode_org) !== 2 || count($kode_prog) !== 3) show_error('parameter tidak sesuai');

		$this->load->model('m_angg_belanja');
		$this->load->model('m_rekening');

		// $this->db->from("{$this->m_angg_belanja->model_table}, {$this->m_rekening->model_table}");
		$this->db->select("{$this->m_angg_belanja->model_table}.*, m_rek.URAI");

		$this->db->join("{$this->m_rekening->model_table} as m_rek", implode(" AND ",array(
			"m_rek.TAHUN = {$this->m_angg_belanja->model_table}.TAHUN",
			"m_rek.KODEAKUN = {$this->m_angg_belanja->model_table}.KODEAKUN",
			"m_rek.KODEKELOMPOK = {$this->m_angg_belanja->model_table}.KODEKELOMPOK",
			"m_rek.KODEJENIS = {$this->m_angg_belanja->model_table}.KODEJENIS",
			"m_rek.KODEOBJEK = {$this->m_angg_belanja->model_table}.KODEOBJEK"
		)), 'left',false);

		// db-ne korup, tapi seh mlaku, errore di surpress wae
		// @$this->m_angg_belanja->all($cond_both, ['no_from' => true]);
		$data = @$this->m_angg_belanja->all(array(
			'TAHUN' => $tahun,
			'KODEORGANISASI' => lzero($kode_org[0]), //!
			'KODEDESA' => lzero($kode_org[1]), //!,
			'KODEBIDANG' => unlzero($kode_prog[0]), //!
			'KODEPROGRAM' => unlzero($kode_prog[1]), //!
			'KODEKEGIATAN' => unlzero($kode_prog[2]) //!
		),0);
		debug($data);
	}

	public function get_bdhr_desa($kode = null)
	{
		if (empty($kode)) {
			$this->json(array());
		} else {
			$kode = explode('-', $kode);
			$this->db->from('PEJABAT_DESA');
			$this->db->where('TAHUN', $this->session->tahun);
			if (!empty($kode[0])) $this->db->where('KODEURUSAN', $kode[0]);
			if (!empty($kode[1])) $this->db->where('KODESUBURUSAN', $kode[1]);
			if (!empty($kode[2])) $this->db->where('KODEORGANISASI', $kode[2]);
			if (!empty($kode[3])) $this->db->where('KODEDESA', $kode[3]);
			$this->db->like("UPPER(JABATAN)", 'BENDAHARA', null);
			$this->json(utf8ize($this->db->get()->result_array()));
		}
	}

	public function spp_angg_rek2($tahun = null, $kode_org = null, $kode_prog = null)
	{
		$kode_org = explode('-', $kode_org);
		$kode_prog = explode('-', $kode_prog);
		if (empty($tahun) || empty($kode_org) || empty($kode_prog) || count($kode_org) !== 2 || count($kode_prog) !== 3) show_error('parameter tidak sesuai');

		$this->load->model('m_angg_belanja');
		$this->load->model('m_rekening');

		$a_b = $this->m_angg_belanja->model_table;
		$m_r = $this->m_rekening->model_table;

		$this->db->select("{$a_b}.*,{$m_r}.urai as urai_rekening", false);
		$this->db->from("{$a_b}", false);

		$this->db->where(array(
			"{$a_b}.KODEORGANISASI" => "'".lzero($kode_org[0])."'", //!
			"{$a_b}.KODEDESA" => "'".lzero($kode_org[1])."'", //!,
			"{$a_b}.KODEBIDANG" => "'".unlzero($kode_prog[0])."'", //!
			"{$a_b}.KODEPROGRAM" => "'".unlzero($kode_prog[1])."'", //!
			"{$a_b}.KODEKEGIATAN" => "'".unlzero($kode_prog[2])."'" //!
		), null, false);

		$this->db->join($m_r, implode(" AND ",array(
			"{$m_r}.TAHUN = {$a_b}.TAHUN",
			"{$m_r}.KODEAKUN = {$a_b}.KODEAKUN",
			"{$m_r}.KODEKELOMPOK = {$a_b}.KODEKELOMPOK",
			"{$m_r}.KODEJENIS = {$a_b}.KODEJENIS",
			"{$m_r}.KODEOBJEK = {$a_b}.KODEOBJEK"
		)), 'left',false);

		$data = @$this->db->get()->result_array();
		// debug($this->db->get_compiled_select());
		// debug(@$this->db->get()->result_array());
		// debug($data);
		$this->json(utf8ize($data));
	}

}