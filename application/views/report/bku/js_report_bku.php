
<script>
    winload(function(){
        // css select2
        $('#jenis_laporan').on('change',function () {
        if (this.value == "1" || this.value == "2" || this.value == "3" || this.value == "4" || this.value == "5" || this.value == "6" || this.value == "9" || this.value == "10" || this.value == "11" || this.value == "12" ) {
          $('#bulan').show();  
        }
        if(this.value == "7" || this.value == "8") {
          $('#bulan').hide();
        }
})
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");                 
        // select2
        $(".select2").select2({
           placeholder: "-- Pilih Desa --",
           allowClear: true
        });

        $(".selectJenisLaporan").select2({
            placeholder: "-- Pilih Jenis Laporan --",
            allowClear: true
        });
        
        $(".selectBulanCetak").select2({
            placeholder: "-- Pilih Bulan --",
            allowClear: true
        });

        $(".selectKepDesa").select2({
            placeholder: "-- Pilih --",
            allowClear: true
        });

        $(".selectBendDesa").select2({
            placeholder: "-- Pilih --",
            allowClear: true
        });

        // tanggal cetak laporan
        var currentDate = new Date();
        $("#tgl_cetak").datepicker({
            autoclose: true,
            format : 'dd MM yyyy', 
            todayBtn: "linked"           
        }).datepicker("setDate",currentDate);         

        $('#tglcetak').click(function(){
            $('#tgl_cetak').datepicker('show');
        });
        
        // tanggal awal laporan
//
//        $("#tgl_awal").datepicker({
//            autoclose: true,
//            minViewMode: 1,
//            format: 'mm/yyyy'
//        }).on('changeDate', function(selected){
//            FromEndDate = new Date(selected.date.valueOf());
//            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));        
//        });
//
//        $('#tglfrom').click(function(){
//            $('#tgl_awal').datepicker('show');
//        });
        
        // tanggal ahir laporan
//        $("#tgl_akhir").datepicker({
//            format : 'dd/mm/yyyy',
//            todayBtn: "linked"
//        }).datepicker("setDate",currentDate); 
//
//        $('#tglto').click(function(){
//            $('#tgl_akhir').datepicker('show');
//        });     
       
        //cetak laporan
        // $('#myModal').css()
        $('#print_ifrm').css('height', (document.body.offsetHeight-70) + 'px');
        $('#print_cetak_form').on('submit', function() {
            
            var jenisLaporan = $('.selectJenisLaporan option:selected').val();
            var koderekening = $('#selectDesa option:selected').val();
            var namaKepdes = $('#namaKepdes').val();
            var nipKepdes = $('#nipKepdes').val();
            var namaBendes = $('#namaBendes').val();
            var nipBendes = $('#nipBendes').val();
//            var tgl_awal = $('#tgl_awal').val();
//            var tgl_akhir = $('#tgl_akhir').val();
            var tanggal_awal = $('.selectBulanCetak option:selected').val();
//            var tanggal_ahir = tgl_akhir.replace('/','.');
            var tgl_cetak = $('#tgl_cetak').val();
            var rekening = koderekening.split('.');
            var tgl= new Date();
            var tahun = tgl.getFullYear();

            // alert(JSON.stringify($(this).serialize()));
            var parameter_url;
                parameter_url = '&tahun='+tahun;
                parameter_url += '&kodeurusan='+rekening[0];
                parameter_url += '&kodesuburusan='+rekening[1];
                parameter_url += '&kodeorganisasi='+rekening[2];
                parameter_url += '&kodedesa='+rekening[3];
                parameter_url += '&Nama_Pejabat='+namaKepdes;
                parameter_url += '&NIP_Pejabat='+nipKepdes;
                parameter_url += '&Nama_Bendahara='+namaBendes;
                parameter_url += '&NIP_Bendahara='+nipBendes;
                parameter_url += '&tgl_awal='+tanggal_awal;
                parameter_url += '&tgl_akhir='+tanggal_awal;
                parameter_url += '&tgl_cetak='+tgl_cetak;        

            if (jenisLaporan==1) {
                var path = 'BKU/BukuKasUmum.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;                    
            } else if(jenisLaporan==2){
                var path = 'BKU/BukuKasPembantuKegiatan.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==3){
                var path = 'BKU/BukuKasPembantuPajak.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==4){
                var path = 'BKU/BukuPembantuSimpananBank.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==5){
                var path = 'BKU/BukuPembantuKasTunai.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==6){
                var path = 'BKU/BukuBankDesa.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==7){
                var path = 'BKU/RealisasiPelaksanaan.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==8){
                var path = 'BKU/RealisasiPelaksanaanSmtAhir.fr3';
                 var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==9){
                var path = 'BKU/LaporanPertanggungjawabanRealisasi.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==10){
                var path = 'BKU/Lampiran1.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==11){
                var path = 'BKU/Lampiran2.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            }else if(jenisLaporan==12){
                var path = 'BKU/Lampiran3.fr3';
                var cetak_url = base_url + 'resource/report/?report_type=pdf&file='+path+parameter_url;
            };

            $('#print_ifrm')[0].src = cetak_url;
            $('#myModal').modal('show');
        });
        $('#myModal').on('hidden.bs.modal', function (e) {
            $('#print_ifrm')[0].src = 'javascript:void(0)';
        }); 

        // css select2
        // $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");

        // services desa
        var $inp_des = $('#selectDesa').select2fluid(),
        $inp_kepdes = $('#KepalaDesa').select2fluid(),
        $inp_bendes = $('#BendaharaDesa').select2fluid(), 
        $inp_nama_kepdes = $('#namaKepdes'),
        $inp_nip_kepdes = $('#nipKepdes'),
        $inp_nama_bendes = $('#namaBendes'),
        $inp_nip_bendes = $('#nipBendes'),
        inp_des_hold = $inp_des.html(),
        inp_kepdes_hold = $inp_kepdes.html(),        
        inp_bendes_hold = $inp_bendes.html(),
        inp_nama_kepdes_hold = $inp_nama_kepdes.html(),
        inp_nip_kepdes_hold = $inp_nip_kepdes.html(),
        inp_nama_bendes_hold = $inp_nama_bendes.html(),
        inp_nip_bendes_hold = $inp_nip_bendes.html(),
        ajx_url = base_url + 'svc/org_desa/',
        ajx_kepdes_url = base_url + 'laporan/laporan_bku/all_pejabat/',        
        ajx_nama_kepdes_url = base_url + 'laporan/laporan_bku/pejabat_by_id/';        
        
        
        // seko kene
        // desa onchange
        $inp_des.on('change', function(ev) { 

            // jaga2, menawa nek di disabled
            if ($(this).prop('disabled')) return;

            // default: 0. jaga2 menawa attr:value-ne dikosongi
            var v = $(this).val();
            var res = v.split('.');
            var param = res[0]+'/'+res[1]+'/'+res[2]+'/'+res[3];
            
            //alert(v);
            if (v === '' || v === '0') {
                $inp_kepdes.html(inp_kepdes_hold).trigger('change');
                return;
            }

            // disabled sek
            $inp_des.prop('disabled',true);
            $inp_kepdes.prop('disabled',true);

            $.get(ajx_kepdes_url + param, function(dat) {

                var opt_inp_kepdes = inp_kepdes_hold;  
                var opt_inp_nama_pejabat = inp_nama_kepdes_hold;              
                var opt_inp_nip_pejabat = inp_nip_kepdes_hold;  
                var opt_inp_bendes = inp_bendes_hold;
                var opt_inp_nama_bendahara = inp_nama_bendes_hold;              
                var opt_inp_nip_bendahara = inp_nip_bendes_hold;             
                var idUrusan = <?php echo $idUrusan; ?>;     
                var idSuburusan = <?php echo $idSuburusan; ?>;     
                var idKec = <?php echo $idKec; ?>;     
                var idDes = <?php echo $idDes; ?>;  
                var idKepala = <?php echo $idKepala; ?>; 
                var idBendahara = <?php echo $idBendahara; ?>; 

                for (var i = 0; i < dat.length;i++) {
                    // cek kepala desa
                    var cekIDes = (dat[i].KODEURUSAN==idUrusan && dat[i].KODESUBURUSAN==idSuburusan && dat[i].KODEORGANISASI==idKec && dat[i].KODEDESA==idDes && dat[i].ID==idKepala) ? 'selected' : '';
                    opt_inp_kepdes += "<option name='kepala_desa' value='"+dat[i].KODEURUSAN+"."+dat[i].KODESUBURUSAN+"."+dat[i].KODEORGANISASI+"."+dat[i].KODEDESA+"."+dat[i].ID+"'"+cekIDes+">"+dat[i].JABATAN+"</option>";   
                    // cek bendahara desa
                    var cekIDBend = (dat[i].KODEURUSAN==idUrusan && dat[i].KODESUBURUSAN==idSuburusan && dat[i].KODEORGANISASI==idKec && dat[i].KODEDESA==idDes && dat[i].ID==idBendahara) ? 'selected' : '';
                    opt_inp_bendes += "<option name='bendahara_desa' value='"+dat[i].KODEURUSAN+"."+dat[i].KODESUBURUSAN+"."+dat[i].KODEORGANISASI+"."+dat[i].KODEDESA+"."+dat[i].ID+"'"+cekIDBend+">"+dat[i].JABATAN+"</option>";                                     
                    opt_inp_nama_pejabat +=  $("#namaKepdes").val('');   
                    opt_inp_nip_pejabat +=  $("#nipKepdes").val(''); 
                    opt_inp_nama_bendahara +=  $("#namaBendes").val('');   
                    opt_inp_nip_bendahara +=  $("#nipBendes").val('');    
                }

                $inp_des.prop('disabled',false);
                $inp_kepdes.prop('disabled',false).html(opt_inp_kepdes).trigger('change'); //update select2
                $inp_bendes.prop('disabled',false).html(opt_inp_bendes).trigger('change'); //update select2

            });

        }).trigger('change');
        //

        // pejabat onchange
        $inp_kepdes.on('change', function(ev) {            
            // jaga2, menawa nek di disabled
            if ($(this).prop('disabled')) return;

            // default: 0. jaga2 menawa attr:value-ne dikosongi
            var v = $(this).val();
            var res = v.split('.');
            var param = res[0]+'/'+res[1]+'/'+res[2]+'/'+res[3]+'/'+res[4];
            // alert(param);

            if (v === '' || v === '0') {
                $inp_nama_kepdes.html(inp_nama_kepdes_hold).trigger('change');
                $inp_nip_kepdes.html(inp_nip_kepdes_hold).trigger('change');
                return;
            }

             // disabled sek            
            $inp_kepdes.prop('disabled',true);
            
            $.get(ajx_nama_kepdes_url + param, function(dat) {

                var opt_inp_nama_pejabat = inp_nama_kepdes_hold;               
                var opt_inp_nip_pejabat = inp_nip_kepdes_hold;                               
                var idUrusan = <?php echo $idUrusan; ?>;     
                var idSuburusan = <?php echo $idSuburusan; ?>;     
                var idKec = <?php echo $idKec; ?>;     
                var idDes = <?php echo $idDes; ?>;                         

                for (var i = 0; i < dat.length;i++) {
                    // console.log(dat[i]);
                    var cekIDes = (dat[i].KODEURUSAN==idUrusan && dat[i].KODESUBURUSAN==idSuburusan && dat[i].KODEORGANISASI==idKec && dat[i].KODEDESA==idDes) ? 'selected' : '';
                    opt_inp_nama_pejabat +=  $("#namaKepdes").val(dat[i].NAMA);                    
                    opt_inp_nip_pejabat +=  $("#nipKepdes").val(dat[i].NIP); 
                }

                $inp_kepdes.prop('disabled',false);
                $inp_nama_kepdes.prop('disabled',false).html(opt_inp_nama_pejabat).trigger('change'); //update select2
                $inp_nip_kepdes.prop('disabled',false).html(opt_inp_nip_pejabat).trigger('change'); //update select2
               

            });

        }).trigger('change');

        //bendahara onchange        
        $inp_bendes.on('change', function(ev) {            
            // jaga2, menawa nek di disabled
            if ($(this).prop('disabled')) return;

            // default: 0. jaga2 menawa attr:value-ne dikosongi
            var v = $(this).val();
            var res = v.split('.');
            var param = res[0]+'/'+res[1]+'/'+res[2]+'/'+res[3]+'/'+res[4];
            // alert(param);

            if (v === '' || v === '0') {
                $inp_nama_bendes.html(inp_nama_bendes_hold).trigger('change');
                $inp_nip_bendes.html(inp_nip_bendes_hold).trigger('change');
                return;
            }

             // disabled sek            
            $inp_bendes.prop('disabled',true);
            
            $.get(ajx_nama_kepdes_url + param, function(dat) {

                var opt_inp_nama_bendahara = inp_nama_bendes_hold;              
                var opt_inp_nip_bendahara = inp_nip_bendes_hold;               
                var idUrusan = <?php echo $idUrusan; ?>;     
                var idSuburusan = <?php echo $idSuburusan; ?>;     
                var idKec = <?php echo $idKec; ?>;     
                var idDes = <?php echo $idDes; ?>;                         

                for (var i = 0; i < dat.length;i++) {
                    // console.log(dat[i]);
                    var cekIDes = (dat[i].KODEURUSAN==idUrusan && dat[i].KODESUBURUSAN==idSuburusan && dat[i].KODEORGANISASI==idKec && dat[i].KODEDESA==idDes) ? 'selected' : '';
                    opt_inp_nama_bendahara +=  $("#namaBendes").val(dat[i].NAMA);   
                    opt_inp_nip_bendahara +=  $("#nipBendes").val(dat[i].NIP);                                           
                }

                $inp_bendes.prop('disabled',false);
                $inp_nama_bendes.prop('disabled',false).html(opt_inp_nama_bendahara).trigger('change'); //update select2
                $inp_nip_bendes.prop('disabled',false).html(opt_inp_nip_bendahara).trigger('change'); //update select2
               

            });

        }).trigger('change');

    
    });
</script>
<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }

    .modal-lg{
        width: 90% !important; 
        /*height: 700px;       */
    }
</style>
<!-- pencarian -->


