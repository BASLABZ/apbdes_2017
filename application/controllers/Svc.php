<?php
/**
* APBDesa
* /application/controllers/Svc.
* 
* @date 201605302039, 201606071000
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
* 
* @uses penamaan method: [perihal]_[detail].
* 		jika tidak tahu perihalnya, gunakan [data].
* 		awalnya ingin dikosongi, tapi CI tidak support.
*/
class Svc extends GI_Controller
{
	private function json($arr)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($arr));
	}
	public function org_desa($id_kec = null, $id_desa = null)
	{
		$this->load->model('m_organisasi');
		// $this->output->set_content_type('application/json')->set_output(json_encode($this->m_organisasi->all_desa($id_kec, $id_desa)));
		$this->json($this->m_organisasi->all_desa($id_kec, $id_desa));
	}
	public function data_prog($id_bid = null, $id_prog = null, $id_keg = null)
	{
		$this->load->model('m_program');

		$cond = array();
		$cond['TAHUN'] = date('Y'); //!
		if (!empty($id_bid)) $cond['KODEBIDANG'] = $id_bid;
		if (!empty($id_prog)) $cond['KODEPROGRAM'] = $id_prog;
		// harus
		if (isset($id_keg)) {
			$cond['KODEKEGIATAN'] = $id_keg;
		} else {
			$cond['KODEKEGIATAN !='] = '0';
		}

		// masalah iki.
		$prog = app::utf8ize($this->m_program->all($cond));
		$this->json($prog);
	}
	public function slc2_kegiatan2($kata = null)
	{
		$data = array();

		if (!empty($kata)) {
			$this->load->model('m_program');

			$data = $this->m_program->search('URAI', implode(' ', explode('-', $kata)), array(
				// 'KODEBIDANG !=' => 0,
				// 'KODEPROGRAM !=' => 0,
				'KODEKEGIATAN !=' => 0
			));
			// app::debug($data);

			/*
			foreach ($res as $v) {
				// $strkode = app::strkode([$v['KODEBIDANG'],$v['KODEPROGRAM'],$v['KODEKEGIATAN']],',');
				$strkode = [$v['KODEBIDANG'],$v['KODEPROGRAM'],$v['KODEKEGIATAN']];
				$data[] = [
					'kode' => $strkode,
					'text' => $v['URAI']
				];
			}
			// app::debug($data);
			*/
		}

		$this->json(app::utf8ize($data));
	}

	/* @deprecated */
	public function slc2_kegiatan($kode = null)
	{
		$data = array();
		$kolom = array('KODEBIDANG','KODEPROGRAM','KODEKEGIATAN');
		$kode = array_filter(explode(".", $kode));
		if(count($kode) > 0 || count($kode) < count($kolom)) {
			$kondisi = array();
			for ($i=0; $i < 3; $i++) {
				$kon = '=';
				if (empty($kode[$i])) {
					$kon = '!=';
					$kode[$i] = 0;
				}
				$kode[$i] = (int)$kode[$i];
				$kondisi[$kolom[$i]." ".$kon] = $kode[$i];
			}
			$this->load->model('m_program');
			$res = $this->m_program->all($kondisi, 10);
			foreach ($res as $v) {
				$kd = str_pad($v['KODEBIDANG'], 2, '0', STR_PAD_LEFT).'.'.str_pad($v['KODEKEGIATAN'], 2, '0', STR_PAD_LEFT).'.'.str_pad($v['KODEPROGRAM'], 2, '0', STR_PAD_LEFT);
				$per = array(
					'id' => $kd,
					'text' => ($kd.' - '.$v['URAI'])
				);
				$data[] = $per;
			}
		}

		// app::debug($data);
		// app::debug($kode);
		// app::debug($kondisi);

		$this->json(app::utf8ize($data));
	}

	public function slc2_kegiatan3($kode = null, $str = null)
	{
		if (empty($kode)) return $this->json(array());

		$kode = array_filter(explode('-', $kode));
		if (count($kode) !== 4) return $this->json(array());

		$field = 'KEGIATAN';
		array_unshift($kode, $this->session->tahun);
		$kode = "'" . implode("','", $kode) . "'";
		$arr_str = array_filter(explode('-', $str));

		$this->db->from("VIEW_KEGIATAN_DESA({$kode})");
		if (count($arr_str) > 0) {
			$this->db->like("UPPER({$field})", strtoupper($arr_str[0]), null);
			for ($i=1; $i < count($arr_str); $i++) {
				$this->db->or_like("UPPER({$field})", strtoupper($arr_str[$i]), null); // param sama-dengan like() pertama
			}
		}

		// debug($this->db->get_compiled_select());
		// $q = $this->db->query("SELECT * FROM VIEW_KEGIATAN_DESA({$kode})");
		$this->json(utf8ize($this->db->get()->result_array()));
	}

	public function spp_angg($org = null, $keg = null)
	{
		$spp = $this->input->get('nomor');
		$tgl = $this->input->get('tanggal');
		if (empty($org) || empty($keg) || empty($spp) || empty($tgl)) return $this->json(array());
		$tahun = $this->session->tahun;
		$org = explode('-', $org);
		$keg = explode('-', $keg);
		if (count($org) !== 4 && count($keg) !== 4) return $this->json(array());

		// $this->m_angg->model_debug = true;
		$rinci = $this->db->query("SELECT * FROM view_spp_rincian('{$tahun}',{$org[0]},{$org[1]},'{$org[2]}','{$org[3]}','{$keg[0]}',{$keg[1]},{$keg[2]},'{$spp}','{$tgl}')");
		$res = $rinci->result_array();
		// $sppr = $q_sppr->result_array();
		// debug($angg);
		return $this->json(utf8ize($res));
	}

}
