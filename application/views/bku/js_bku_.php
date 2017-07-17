<!-- khusus untuk js/css -->
<script>
    winload(function() {      

        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="modal"]').tooltip();
        // css select2
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");                 
        //select 
        $(".select2").select2({
            placeholder: "-- Pilih Kecamatan/Desa --",           
        });

        $(".selectJurnal").select2({
            placeholder: "-- Pilih Junal --",          
        });

        $(".selectBulan").select2({
            placeholder: "-- Pilih Bulan --",          
        });

        // nospp
        $(".nospp").select2({
            placeholder:"-- Pilih SPP --",
        });
        // nospp
        $(".nosppedit").select2({
            // placeholder:"-- Pilih SPP --",
        });

        //read only penerimaan / pengeluaran pada add pergeseran
        var x = document.getElementById("simpananBank").value;
        if(x==1){
            document.getElementById("add_penerimaan").readOnly = true;
            document.getElementById("add_pengeluaran").readOnly = false;
        }else{
            document.getElementById("add_penerimaan").readOnly = false;
            document.getElementById("add_pengeluaran").readOnly = true;
        }
        $('#simpananBank').on('change',function(){  
            var x = document.getElementById("simpananBank").value;
            if(x==1){
                document.getElementById("add_penerimaan").readOnly = true;
                document.getElementById("add_pengeluaran").readOnly = false;
            }else{
                document.getElementById("add_penerimaan").readOnly = false;
                document.getElementById("add_pengeluaran").readOnly = true;
            }
        });        
        
        $('#edit_jenis_pergeseran').on('change',function(){  
            var x = document.getElementById("edit_jenis_pergeseran").value;
            if(x==1){
                document.getElementById("edit_penerimaan").readOnly = true;
                document.getElementById("edit_pengeluaran").readOnly = false;
            }else{
                document.getElementById("edit_penerimaan").readOnly = false;
                document.getElementById("edit_pengeluaran").readOnly = true;
            }
        });

        function toAngka(rp){
            return parseInt(rp.replace(/,.*|\D/g,''),10)
        }

        //penjumlahan penerimaan
        function calculateSum() {            
            var sum = 0;
            //iterate through each textboxes and add the values
            $(".input-fake").each(function () {                
                //add only if the value is number
                var nilai = toAngka(this.value);                
                // console.log(nilai);
                if (!isNaN(nilai) && nilai.length != 0) {
                    sum += parseFloat(nilai);
                    
                }

            });
            //.toFixed() method will roundoff the final sum to 2 decimal places
            $("#jumlah_all").text(format_rupiah(sum));
            $("#jumlah_all_terima").val(sum); 
        }

        //penjumlahan edit penerimaan
         function calculateEditSum() {            
            var sum = 0;
            //iterate through each textboxes and add the values
            $(".input-fake").each(function () {                
                //add only if the value is number
                var nilai = toAngka(this.value);                
                // console.log(nilai);
                if (!isNaN(nilai) && nilai.length != 0) {
                    sum += parseFloat(nilai);
                    
                }

            });
            //.toFixed() method will roundoff the final sum to 2 decimal places
            $("#jumlah_all_edit").text(format_rupiah(sum));
            $("#jumlah_all_terima_edit").val(sum); 
        }

        $("#table_trans").on("keyup", ".input-fake", function () {
            calculateSum();
        });

        $("#table_edit_trans").on("keyup", ".input-fake", function () {
            calculateEditSum();
        });

        //datepicker
        //input spj
        <?php if (empty($id_bulan)) {$id_bulan = 0;} else{$id_bulan=$id_bulan;}; ?>
        var _hari = <?php echo date('d'); ?>;
        var _bulan = <?php echo $id_bulan; ?>;
        var _tahun  =<?php echo date('Y') ?>;
        $(".tanggal_modal").datepicker({
            format : 'dd/mm/yyyy',
        }).datepicker("setDate",_hari+"/"+_bulan+"/"+_tahun);            
        
        //autonumeric
        $(".amount_format").autoNumeric({
            vMax: '999999999999999',            
            aSep: ".", aDec: ",", aPad: false
        }); 

        // tabel rekening scroll
        $('.tableRekening').DataTable({
            "language": {
                // "lengthMenu": "_MENU_ item per halaman",
                "lengthMenu": "",
                "zeroRecords": "Data tidak ditemukan",
                "info": "",
                "infoEmpty": "Tidak ada data",
                "sSearch": "Pencarian",
                "infoFiltered": "(Filter dari _MAX_ total item)",                
            },
            scrollY:        250,
            scrollX:        false,
            scrollCollapse: true,
            paging:         false
        });

        // select row tabel rekening
        var table = $('.tableRekening').DataTable();
        $('.tableRekening tbody').on('click','tr',function(){
            // console.log(table.row(this).data());
            if($(this).hasClass('selected')){
                $(this).removeClass('selected');
            }else{
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        //datatable bku
        $('#datatablebku').DataTable( {
            "language": {
                // "lengthMenu": "_MENU_ item per halaman",
                "lengthMenu": "",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data",
                "sSearch": "Pencarian",
                "infoFiltered": "(Filter dari _MAX_ total item)"
            },

            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data; 
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                }; 

                // Total over this page
                totalPenerimaan = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                totalPengeluaran = api
                    .column( 4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                totalBulanan = parseFloat(totalPenerimaan) - parseFloat(totalPengeluaran);
                totalBulanan = totalBulanan.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
                totalBulanan = totalBulanan.bold();
                totalPenerimaan = totalPenerimaan.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
                totalPenerimaan = totalPenerimaan.bold();
                totalPengeluaran = totalPengeluaran.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
                totalPengeluaran = totalPengeluaran.bold();

                // Update footer
                $( api.column( 3 ).footer() ).html(
                    ''+this.fnSettings().fnFormatNumber(totalPenerimaan)
                );
                $( api.column( 4 ).footer() ).html(
                    ''+this.fnSettings().fnFormatNumber(totalPengeluaran)
                );
                $( api.column( 5 ).footer() ).html(
                    ''+this.fnSettings().fnFormatNumber(totalBulanan)
                );
            }            
        } );    
        // add pajak   
        var max_fields      = 5; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $("#add_field_button"); //Add button ID  
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var tahun = <?php echo date('Y'); ?>;                
                $.ajax({
                    type :'POST',
                    url  :'<?php echo base_url()?>bku/buku_kas_umum/getPajak',
                    data : {tahun:tahun},
                    dataType : 'json',
                    cache : 'false',
                    success:function(data){ 
                        if(data != 'fail'){ 
                            $('.count_pajak').val(x);                                                        
                            // console.log(data[i]);                            
                            $('.input_fields_wrap').append('<div class="input-group">'+    
                                '<select class="form-control" style="width:60%;" id="select_pajak_db_'+x+'" name="select_name_'+x+'">'+                                 
                                '<input type="text" name="select_pajak_'+x+'" class="form-control amount_format sum_amount" style="width:40%; text-align:right;" placeholder="0,00" id="pajak_input" />'+                                
                                '<span class="input-group-btn"><button class="btn btn-danger" id="remove_field"><i class="fa fa-times"></i></button></span></div>'); //add input box
                            for (var i = 0; i < data.length; i++) { 
                                $('#select_pajak_db_'+x).append('<option value="'+data[i].KODEAKUN+'.'+data[i].KODEKELOMPOK+'.'+data[i].KODEJENIS+'.'+data[i].KODEOBJEK+'">'+data[i].SINGKAT+'</option>');
                            }                           
                          
                        }

                    }

                });
                
            }
        });
        //delete input
        $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parents('.input-group').remove(); x--;
        });

        $(".input_fields_wrap").on("keyup", function () {
            calculateSumPajak();
        });

        //penjumlahan penerimaan
        function calculateSumPajak() {            
            var sum = 0;
            //iterate through each textboxes and add the values
            $(".sum_amount").each(function () {                
                //add only if the value is number
                var nilai = toAngka(this.value);                
                // console.log(nilai);
                if (!isNaN(nilai) && nilai.length != 0) {
                    sum += parseFloat(nilai);
                    
                }

            });
            //.toFixed() method will roundoff the final sum to 2 decimal places            
            $("#jumlah_all_pajak").val(sum); 
            // console.log(sum);
        }
        

        //edit modal pergeseran
        $(function(){
            $(document).on('click','#ubah_pergeseran',function(e){
                e.preventDefault();
                $('#modalEditPergeseran').modal('show');
                var id= $(this).attr('data-id');
                var edit_bku = id.split('|');
                $('.modal-body #edit_no_bku').val(edit_bku[0]);
                $('.modal-body #edit_no_bukti').val(edit_bku[1]);
                $('.modal-body #edit_jenis_pergeseran').val(edit_bku[2]);                
                $('.modal-body #edit_uraian').val(edit_bku[3]);
                $('.modal-body #edit_penerimaan').val(edit_bku[4]);
                $('.modal-body #edit_pengeluaran').val(edit_bku[5]);
                $('.modal-body #tgl_edit_bku').val(edit_bku[6]);
                $('.modal-body #tgl_edit_bukti').val(edit_bku[7]);  

                if(edit_bku[2]=='SIMPANAN-BANK'){
                    $('.modal-body #edit_jenis_pergeseran').val(1);
                    document.getElementById("edit_penerimaan").readOnly = true;
                    document.getElementById("edit_pengeluaran").readOnly = false;
                }else{
                    $('.modal-body #edit_jenis_pergeseran').val(2);
                    document.getElementById("edit_penerimaan").readOnly = false;
                    document.getElementById("edit_pengeluaran").readOnly = true;
                }
                //edit pergeseran
                $('#tgl_edit_bku').datepicker({
                    format: 'dd/mm/yyyy',
                }).datepicker("setDate", edit_bku[6]); 
                $('#tgl_edit_bukti').datepicker({
                    format: 'dd/mm/yyyy',
                }).datepicker("setDate", edit_bku[7]);                 
                //              
            });
        });

        //edit modal pajak
        $(function(){
            $(document).on('click','#ubah_pajak',function(e){
                e.preventDefault();                
                $('#modalEditPajak').modal('show');
                var id= $(this).attr('data-id');
                var edit_bku = id.split('|');
                $('.modal-body #edit_no_bku_pajak').val(edit_bku[0]);
                $('.modal-body #edit_no_bukti_pajak').val(edit_bku[1]); 
                if(edit_bku[2]=='PUNGUT-PAJAK'){
                    $('.modal-body #edit_jenis_pajak').val(1);
                }else{
                    $('.modal-body #edit_jenis_pajak').val(2);
                }       
                $('.modal-body #edit_uraian_pajak').val(edit_bku[3]);
                var tahun = <?php echo date('Y'); ?>;
                var nomor_bku = edit_bku[0];
                // edit rincian pajak
                $('.input_fields_wrap').html('');
                $.ajax({
                    type :'POST',
                    url  :'<?php echo base_url()?>bku/buku_kas_umum/getPajakByBKU',
                    data : {tahun:tahun,no_bku:nomor_bku},
                    dataType : 'json',
                    cache : 'false',
                    success:function(data){ 
                        if(data != 'fail'){ 
                            // $('.count_pajak').val(x);                                                        
                            for(var i=0; i<data.length; i++){
                                $('.input_fields_wrap').append('<div class="input-group">'+    
                                    '<select class="form-control" style="width:60%;" id="select_pajak_db_'+i+'" name="select_name_'+i+'">'+  
                                    '<input type="text" name="select_pajak_'+i+'" class="form-control amount_format sum_amount" style="width:40%; text-align:right;" placeholder="0,00" id="pajak_input" value="'+data[i].PENERIMAAN+'"/>'+                                
                                    '<span class="input-group-btn"><button class="btn btn-danger" id="remove_field"><i class="fa fa-times"></i></button></span></div>'); //add input box
                            }  
                            // for (var i = 0; i < data.length; i++) { 
                            //     $('#select_pajak_db_'+x).append('<option value="'+data[i].KODEAKUN+'.'+data[i].KODEKELOMPOK+'.'+data[i].KODEJENIS+'.'+data[i].KODEOBJEK+'">'+data[i].SINGKAT+'</option>');
                            // }                           
                          
                        }

                    }

                });
                // if(edit_bku[4]!=0){
                //     $('.modal-body #edit_input_pajak').val(edit_bku[4]);
                // }else if(edit_bku[5]!=0){
                //     $('.modal-body #edit_input_pajak').val(edit_bku[5]);
                // }else{
                //     $('.modal-body #edit_input_pajak').val(0);
                // }
                $('.modal-body #edit_tgl_bku_pajak').val(edit_bku[6]);
                $('.modal-body #edit_tgl_bukti_pajak').val(edit_bku[7]); 
                
                //edit pergeseran
                $('#edit_tgl_bku_pajak').datepicker({
                    format: 'dd/mm/yyyy',
                }).datepicker("setDate", edit_bku[6]); 
                $('#edit_tgl_bukti_pajak').datepicker({
                    format: 'dd/mm/yyyy',
                }).datepicker("setDate", edit_bku[7]); 
                          
            });
        });
        

           //ganti judul
        $(function(){
            $("#jenistransaksi").on('change',function(){  
                $("#selectspp").empty();    
                $('#selectspp').prop('selectedIndex',-1);
                if (this.value == "SPJ") {                    
                    $("#th_jenis_transaksi").text("Pengeluaran");
                    $("#judul_no_bku").text("No. Bukti SPJ");
                    $("#myModalLabel").text("Form Tambah SPJ BKU");                                                                                    
                } else{                    
                    $("#th_jenis_transaksi").text("Penerimaan");
                    $("#judul_no_bku").text("No. Bukti SPP");
                    $("#myModalLabel").text("Form Tambah SPP BKU");                                       
                }
                
                var koderekening = $("#koderekening").val();
                // console.log(koderekening);
                var kd = koderekening.split(".");
                var kodeurusan = kd[0];
                var kodesuburusan = kd[1];
                var kodeorganisasi = kd[2];
                var kodedesa = kd[3];
                var tahun = <?php echo date('Y'); ?>;
                var jenis = this.value;
                // console.log(jenis);
                $.ajax({
                type :"POST",
                url  :"<?php echo base_url()?>bku/buku_kas_umum/no_bukti_by_jenis",
                data :{tahun:tahun,kodeurusan:kodeurusan,kodesuburusan:kodesuburusan,kodeorganisasi:kodeorganisasi,kodedesa:kodedesa,jenis:jenis},
                dataType :"json",
                cache :"false",
                success: function(data){  
                    for (var i = 0; i < data.length; i++) { 
                        // if(data[i]!=0){
                            $("#selectspp").append("<option value='' selected='selected'>-- Pilih SPP --</option>");
                            $("#selectspp").append("<option value=\""+data[i]+"\">"+data[i]+"</option>");
                        // }else{                                                          
                        //     // $("#selectspp").append("<option value='0'>-- Pilih SPP --</option>");                         
                        //     $("#selectspp").append("<option value=\""+data[i]+"\" selected='selected'>-- Pilih SPP --</option>");
                        // }                     
                        
                    };
                
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // console.log(errorThrown);
                }
            });        
            });             
            $('#jenistransaksi').trigger('change');
        });

        //edit SPJ Penerimaan
        $(function(){
            $(document).on('click','#ubah_spj_penerimaan',function(e){                
                e.preventDefault();

                var koderekening = $('#koderekening').val();
                var kd = koderekening.split(".");
                var kodeurusan = kd[0];
                var kodesuburusan = kd[1];
                var kodeorganisasi = kd[2];
                var kodedesa = kd[3];
                var tahun = <?php echo date('Y'); ?>;
                var id= $(this).attr('data-id');
                var edit_bku = id.split('|');
                var no_bku = edit_bku[0];                 

                $("#jumlah_all_edit").text(edit_bku[4]);
                $("#jumlah_all_terima_edit").val(edit_bku[4]); 

                $.ajax({
                    type :'POST',
                    url  :'<?php echo base_url()?>bku/buku_kas_umum/view_edit_penerimaan',
                    data : {tahun:tahun,kodeurusan:kodeurusan,kodesuburusan:kodesuburusan,kodeorganisasi:kodeorganisasi,kodedesa:kodedesa,no_bku:no_bku},
                    dataType : 'json',
                    cache : 'false',
                    success:function(data){
                        
                        $("#edit_data_spj_penerimaan").html("");
                        if(data != 'fail'){      
                            $('.modal-body #edit_no_bku_spj').val(no_bku);
                            $('.modal-body #bukti_penerimaan').val(edit_bku[1]);
                            $('.modal-body #uraian_spj').val(edit_bku[3]);                
                            $('#tgl_bku_penerimaan').datepicker({
                                        format: 'dd/mm/yyyy',
                                    }).datepicker("setDate", edit_bku[6]);
                            $('#tgl_bukti_penerimaan').datepicker({
                                        format: 'dd/mm/yyyy',
                                    }).datepicker("setDate", edit_bku[7]); 

                            for (var i = 0; i < data.length; i++) {    
                            // console.log(data[i]);                            
                                $('#edit_data_spj_penerimaan').append("<tr><td id='kd_rek' width='20%'><input type='hidden' value='"+data[i].REKENING+"' name='rekening_rincian_"+i+"'>"+
                                        "<input type='hidden' name='jml_penerimaan[]' value='"+data.length+"'>"+data[i].REKENING+"<a href='#' data-target='#modal_edit_kode_rekening' data-toggle='modal'" + 
                                        "class='btn btn-primary btn-xs bd-rad-0' data-placement='bottom' title='Cari Rekening'"+
                                        "style='float: right;'><span class='glyphicon glyphicon-search'></span></a></td>"+
                                        "<td id='urai_rek' width='50%'><input type='hidden' value='"+data[i].URAI_REKENING+"' name='urai_rincian_"+i+"'>"+data[i].URAI_REKENING+"<a href='#' class='btn btn-danger btn-xs bd-rad-0' data-placement='bottom' data-toggle='modal' title='Hapus Rekening'"+
                                        "style='float: right;' onclick='hapusEditRekening(this)'><span class='glyphicon glyphicon-remove'></span></a></td>"+
                                        // "<td id='jml_rek' align='right' width='30%'><input class='input-fake' step='0.01' min='0' value='"+format_rupiah(0,false)+"' onmousewheel='event.preventDefault()' onkeyup='_jumlah_penerimaan(this)' data-nilaibiasa='0' onfocus='_value_penerimaan(this)' onblur='_value_hasil(this)'/></td></tr>");  
                                        "<td id='jml_rek' align='right' width='30%'><input type='hidden' name='total_penerimaan[]' id='total_penerimaan'>"+
                                        "<input name='jml_rincian_"+i+"' step='0.01' min='0' value='"+format_rupiah(data[i].PENERIMAAN,false)+"' class='input-fake'  data-nilaibiasa='"+data[i].PENERIMAAN+"' onmousewheel='event.preventDefault()' onkeyup='_jumlah_edit_penerimaan(this)' onfocus='_value_edit_penerimaan(this)' onblur='_value_edit_hasil(this)'/>"+
                                        "</td></tr>");                                
                            }
                            $('[data-toggle="modal"]').tooltip(); 

                            // $('#edit_data_spj_penerimaan').append("<tr><td id='kode_rekening'><a href='#' data-target='#modal_edit_kode_rekening' data-toggle='modal'" + 
                            //             "class='btn btn-primary btn-xs bd-rad-0' data-placement='bottom' title='Cari Rekening'"+
                            //             "style='float: right;'><span class='glyphicon glyphicon-search'></span></a></td>"+
                            //             "<td id='urai_rekening'></td><td id='jml_rekening'></td></tr>");  
                        }

                    }

                });

                
               
            });
        });

        //edit modal SPJ
        $(function(){
            $(document).on('click','#ubah_spj',function(e){
                e.preventDefault();
            var koderekening = $("#koderekening").val();
            //console.log(koderekening);
            var kd = koderekening.split(".");
            var kodeurusan = kd[0];
            var kodesuburusan = kd[1];
            var kodeorganisasi = kd[2];
            var kodedesa = kd[3];
            var tahun = <?php echo date('Y'); ?>;
            var jumlah_pagu = 0;
            var jumlah_ = 0;
            var id= $(this).attr('data-id');
            var edit_bku = id.split('|');
            var no_bku = edit_bku[0];    
            //console.log(no_bukti);
            $.ajax({
                type :"POST",
                url  :"<?php echo base_url()?>bku/buku_kas_umum/view_edit_spj",
                data :{tahun:tahun,kodeurusan:kodeurusan,kodesuburusan:kodesuburusan,kodeorganisasi:kodeorganisasi,kodedesa:kodedesa,no_bku:no_bku},
                dataType :"json",
                cache :"false",
                success: function(data){
                    $('.modal-body #edit_no_bukti_spj').html("");
                    $("#edit_data_rek_bku").html("");
                    $(".loader").hide();
                    if (data != "fail") {
                        $('.modal-body #edit_no_bku_spj').val(no_bku); 
                        // console.log(no_bku);
                        $('.modal-body #edit_no_bukti_spj').append("<option value=\""+data[0]['BUKTI']+"\">"+data[0]['BUKTI']+"</option>"); 
                        if (data[0].IS_PIHAK_KETIGA == 0) {
                            $('.modal-body #edit_kas_bendahara').prop('checked', true);
                        } else{
                             $('.modal-body #edit_pihak_ketiga').prop('checked', true);
                        };
                        $('.modal-body #edit_uraian_spj').text(data[0]['URAI_SPP']);
                        $('.modal-body #edit_kegiatan').val(data[0]['KEGIATAN']);
                            
                        $('#edit_tgl_bku_spj').datepicker({
                            format: 'dd/mm/yyyy',
                        }).datepicker("setDate", edit_bku[6]); 
                        $('#edit_tgl_bukti_spj').datepicker({
                            format: 'dd/mm/yyyy',
                        }).datepicker("setDate", edit_bku[7]); 

                        $("#edit_tahun").val(data[0]['TAHUN']);

                     for (var i = 0; i < data.length; i++) {
                        // console.log(data[i].REKENING);

                        // if (data[0].JENIS_BKU == "SPP") {data[i].} else{};
                        $("#edit_data_rek_bku").append("<tr><td>"+data[i].REKENING+"</td>"+
                                                  "<input type=\"hidden\" name=\"jml_rincian[]\">"+
                                                  "<input type=\"hidden\" name=\"kode_rekening_"+i+"\" value=\""+data[i].REKENING+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_bidang_"+i+"\" value=\""+data[i].KODEBIDANG+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_program_"+i+"\" value=\""+data[i].KODEPROGRAM+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_kegiatan_"+i+"\" value=\""+data[i].KODEKEGIATAN+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_akun_"+i+"\" value=\""+data[i].KODEAKUN+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_kelompok_"+i+"\" value=\""+data[i].KODEKELOMPOK+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_jenis_"+i+"\" value=\""+data[i].KODEJENIS+"\">"+
                                                  "<input type=\"hidden\" name=\"kode_objek_"+i+"\" value=\""+data[i].KODEOBJEK+"\">"+
                                                  "<td>"+data[i].URAI_REKENING+"</td>"+
                                                   "<input type=\"hidden\" name=\"urai_rekening_"+i+"\" value=\""+data[i].URAI_REKENING+"\">"+
                                                  "<td align='right'>"+format_rupiah(data[i].ANGGARAN)+"</td>"+
                                                   "<input type=\"hidden\" name=\"pagu_anggaran_"+i+"\" value=\""+data[i].ANGGARAN+"\">"+
                                                   "<td align='right'>"+
                                                   "<input class='edit_td_pengeluaran_hitung' type=\"text\" data-nilaibiasa=\""+data[i].JUMLAH+"\" onfocus=\"val_biasa(this)\" onblur=\"val_uang(this)\" onkeyup=\"_hitung(this)\""+
                                                   "style=\"border:0;background:transparent;text-align: right;\" name=\"penerimaan_pengeluaran_"+i+"\"  value=\""+format_rupiah(data[i].JUMLAH)+"\"></td>");
                        
                        jumlah_pagu = jumlah_pagu + data[i].ANGGARAN;
                        jumlah_ = jumlah_ + data[i].JUMLAH;
                        // jumlah_all_terima = jumlah_all_terima + data[i].PENERIMAAN;
                        //console.log(jumlah_pagu);
                        //input post

                     };
                        // document.getElementById('jumlah_pagu').innerHtml = jumlah_pagu;
                        if (data[0].JENIS_BKU == "SPP") {
                            $('.modal-body #edit_jenis_spp').prop('checked', true);
                             edit_ganti_judul_spp();
                        } else if(data[0].JENIS_BKU == "SPP"){
                             $('.modal-body #edit_jenis_spj').prop('checked', true);
                             edit_ganti_judul_spj();
                        };

                        $('#edit_jumlah_pagu').text(format_rupiah(jumlah_pagu));
                        $('#edit_jumlah_all_pagu').val(jumlah_pagu);
                        $('#edit_jumlah_all').text(format_rupiah(jumlah_));
                        $('#edit_jumlah_all_').val(jumlah_);
                        // $('#edit_jumlah_all_pengeluaran').text(format_rupiah(jumlah_all_keluar));
                        // $('#edit_jumlah_all_keluar').val(jumlah_all_keluar);
                        // $(".edit_td_pengeluaran_hitung").maskMoney({thousands:'.', decimal:','});
                    } else{
                        document.getElementById('uraian_spj').value="";
                        document.getElementById('kegiatan').value="";
                        $("#data_rek_bku").append("<tr><td colspan='4' align='center'>No Data</td></tr>");
                    };
                
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });           
              
                          
            });
        });

    });    
        
    function _hitung(x) {
        x.dataset.nilaibiasa = x.value;
        var total = 0;
        $(".edit_td_pengeluaran_hitung").each(function(){
            total += Number($(this)[0].dataset.nilaibiasa);
            console.log(this);
        })

        $("#edit_jumlah_all").text(format_rupiah(total));
        $("#edit_jumlah_all_").val(total);
        
    }

    function val_biasa(x){
        x.value = x.dataset.nilaibiasa;
    }

    function val_uang(x){
        x.value=format_rupiah(x.value);
        console.log(x.value);
    }
    


    function _hapus(tahun,kdurusan,kdsuburusan,kdorganisasi,kddesa,nobku) { 

        var bulan = document.getElementById("bulan").innerText;
        var jenis_jurnal = document.getElementById("jenis_jurnal").innerText;
        // swal("Here's a message!"+argument);
        swal({
                title: "Apa anda yakin ?",
                text: "Anda akan menghapus data No BKU "+nobku+" !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Hapus",
                closeOnConfirm: false
            },
            function() {
                if (jenis_jurnal =="SPP" || jenis_jurnal =="SPJ") {
                    window.location.href = "<?php echo base_url() ?>bku/buku_kas_umum/delete_spj_bku/" +tahun+'/'+kdurusan+'/'+kdsuburusan+'/'+kdorganisasi+'/'+kddesa+'/'+nobku+'/'+bulan+'/'+jenis_jurnal;                    
                } else{
                    window.location.href = "<?php echo base_url() ?>bku/buku_kas_umum/delete/" +tahun+'/'+kdurusan+'/'+kdsuburusan+'/'+kdorganisasi+'/'+kddesa+'/'+nobku+'/'+bulan+'/'+jenis_jurnal;
                };
            });
    }

 
    
    function ganti_judul($elm) {
        console.log($(this).val());
        if ($(this).val()=="SPP") {
            $("#th_jenis_transaksi").text("Pengeluaran");
            $("#judul_no_bku").text("No. Bukti SPJ");
            $("#myModalLabel").text("Form Tambah SPJ BKU");
        }else{
            $("#th_jenis_transaksi").text("Penerimaan");
            $("#judul_no_bku").text("No. Bukti SPP");
            $("#myModalLabel").text("Form Tambah SPP BKU");
        };
    }
    //SPJ
    function ganti_judul_spj(){
        
    }
    function ganti_judul_spp(){
        
    }

    function edit_ganti_judul_spj(){
        $("#edit_th_jenis_transaksi").text("Pengeluaran");
        $("#edit_judul_no_bku").text("No. Bukti SPJ");
        $("#edit_myModalLabel").text("Form Tambah SPJ BKU");
        //$(".edit_td_penerimaan").hide();
        //$(".edit_td_pengeluaran").show();
    }
    function edit_ganti_judul_spp(){
        $("#edit_th_jenis_transaksi").text("Penerimaan");
        $("#edit_judul_no_bku").text("No. Bukti SPP");
        $("#edit_myModalLabel").text("Form Tambah SPP BKU");
        //$(".edit_td_pengeluaran").hide();
        //$(".edit_td_penerimaan").show();
    }



    function format_rupiah(idr, rp) {
        rp = rp || false;
        if (idr === '' || idr === '0' || isNaN(idr)) return "Rp. 0,00";
        var uang = number_format(Number(idr),2,',','.');
        if (rp) {
            return "Rp. " + uang;
        } else {
            return uang;
        }
    }    
    var i=0;  
    // pilih rekening didalam modal
    function pilihRekening(){   
        $('#modal_kode_rekening').modal('hide');         
        // document.getElementById('kode_rekening').outerHTML="";
        var row_kode = document.getElementById('kode_rekening');
        var row_urai = document.getElementById('urai_rekening');
        var row_jml = document.getElementById('jml_rekening');
        row_kode.parentNode.removeChild(row_kode);
        row_urai.parentNode.removeChild(row_urai);
        row_jml.parentNode.removeChild(row_jml);
        var koderekening = $("tr.selected td:nth-child(1)").html(); 
        var uraian = $("tr.selected td:nth-child(2)").html();         
        // document.getElementById('kode_rekening').innerText = koderekening; 
        // document.getElementById('urai_rekening').innerText = uraian;    
        
        $('#data_spj_penerimaan').append("<tr><td id='kd_rek' width='20%'><input type='hidden' value='"+koderekening+"' name='rekening_rincian_"+i+"'>"+
                                        "<input type='hidden' name='jml_penerimaan[]'>"+koderekening+"<a href='#' data-target='#modal_kode_rekening' data-toggle='modal'" + 
                                        "class='btn btn-primary btn-xs bd-rad-0' data-placement='bottom' title='Cari Rekening'"+
                                        "style='float: right;'><span class='glyphicon glyphicon-search'></span></a></td>"+
                                        "<td id='urai_rek' width='50%'><input type='hidden' value='"+uraian+"' name='urai_rincian_"+i+"'>"+uraian+"<a href='#' class='btn btn-danger btn-xs bd-rad-0' data-placement='bottom' title='Hapus Rekening' data-toggle='modal'"+
                                        "style='float: right;' onclick='hapusRekening(this)'><span class='glyphicon glyphicon-remove'></span></a></td>"+
                                        // "<td id='jml_rek' align='right' width='30%'><input class='input-fake' step='0.01' min='0' value='"+format_rupiah(0,false)+"' onmousewheel='event.preventDefault()' onkeyup='_jumlah_penerimaan(this)' data-nilaibiasa='0' onfocus='_value_penerimaan(this)' onblur='_value_hasil(this)'/></td></tr>");  
                                        "<td id='jml_rek' align='right' width='30%'><input type='hidden' name='total_penerimaan[]' id='total_penerimaan'>"+
                                        "<input name='jml_rincian_"+i+"' step='0.01' min='0' value='"+format_rupiah(0,false)+"' class='input-fake'  data-nilaibiasa='0' onmousewheel='event.preventDefault()' onkeyup='_jumlah_penerimaan(this)' onfocus='_value_penerimaan(this)' onblur='_value_hasil(this)'/>"+
                                        "</td></tr>");  

        $('#data_spj_penerimaan').append("<tr><td id='kode_rekening'><a href='#' data-target='#modal_kode_rekening' data-toggle='modal'" + 
                                        "class='btn btn-primary btn-xs bd-rad-0' data-placement='bottom' title='Cari Rekening'"+
                                        "style='float: right;'><span class='glyphicon glyphicon-search'></span></a></td>"+
                                        "<td id='urai_rekening'></td><td id='jml_rekening'></td></tr>");                                               
        $('[data-toggle="modal"]').tooltip();
        i++; 
        // mengembalikan sroll aktif
        $(document).on('hidden.bs.modal','.modal', function () {
             $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
    }

    function pilihEditRekening(){   
        $('#modal_edit_kode_rekening').modal('hide');         
        // document.getElementById('kode_rekening').outerHTML="";
        var row_kode = document.getElementById('kode_rekening');
        var row_urai = document.getElementById('urai_rekening');
        var row_jml = document.getElementById('jml_rekening');
        row_kode.parentNode.removeChild(row_kode);
        row_urai.parentNode.removeChild(row_urai);
        row_jml.parentNode.removeChild(row_jml);
        var koderekening = $("tr.selected td:nth-child(1)").html(); 
        var uraian = $("tr.selected td:nth-child(2)").html();         
        // document.getElementById('kode_rekening').innerText = koderekening; 
        // document.getElementById('urai_rekening').innerText = uraian;    
        
        $('#edit_data_spj_penerimaan').append("<tr><td id='kd_rek' width='20%'><input type='hidden' value='"+koderekening+"' name='rekening_rincian_"+i+"'>"+
                                        "<input type='hidden' name='jml_penerimaan[]'>"+koderekening+"<a href='#' data-target='#modal_edit_kode_rekening' data-toggle='modal'" + 
                                        "class='btn btn-primary btn-xs bd-rad-0' data-placement='bottom' title='Cari Rekening'"+
                                        "style='float: right;'><span class='glyphicon glyphicon-search'></span></a></td>"+
                                        "<td id='urai_rek' width='50%'><input type='hidden' value='"+uraian+"' name='urai_rincian_"+i+"'>"+uraian+"<a href='#' class='btn btn-danger btn-xs bd-rad-0' data-placement='bottom' title='Hapus Rekening'"+
                                        "style='float: right;' onclick='hapusEditRekening(this)'><span class='glyphicon glyphicon-remove'></span></a></td>"+
                                        // "<td id='jml_rek' align='right' width='30%'><input class='input-fake' step='0.01' min='0' value='"+format_rupiah(0,false)+"' onmousewheel='event.preventDefault()' onkeyup='_jumlah_penerimaan(this)' data-nilaibiasa='0' onfocus='_value_penerimaan(this)' onblur='_value_hasil(this)'/></td></tr>");  
                                        "<td id='jml_rek' align='right' width='30%'><input type='hidden' name='total_penerimaan[]' id='total_penerimaan'>"+
                                        "<input name='jml_rincian_"+i+"' step='0.01' min='0' value='"+format_rupiah(0,false)+"' class='input-fake'  data-nilaibiasa='0' onmousewheel='event.preventDefault()' onkeyup='_jumlah_edit_penerimaan(this)' onfocus='_value_edit_penerimaan(this)' onblur='_value_edit_hasil(this)'/>"+
                                        "</td></tr>");  

        $('#edit_data_spj_penerimaan').append("<tr><td id='kode_rekening'><a href='#' data-target='#modal_edit_kode_rekening' data-toggle='modal'" + 
                                        "class='btn btn-primary btn-xs bd-rad-0' data-placement='bottom' title='Cari Rekening'"+
                                        "style='float: right;'><span class='glyphicon glyphicon-search'></span></a></td>"+
                                        "<td id='urai_rekening'></td><td id='jml_rekening'></td></tr>");                                               
        i++; 
        // mengembalikan sroll aktif
        $(document).on('hidden.bs.modal','.modal', function () {
             $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
    }

    function _jumlah_penerimaan(x){
        x.dataset.nilaibiasa = x.value;         
    }

    function _value_penerimaan(x){
        x.value = x.dataset.nilaibiasa;       
        // console.log(x.value);
    }
    
    function _value_hasil(x){       
        var hasil = Number(x.dataset.nilaibiasa);
        x.value=number_format(hasil,2,',','.');         
        // console.log(x.value);      
    }

    function _jumlah_edit_penerimaan(x){
        x.dataset.nilaibiasa = x.value;         
    }

    function _value_edit_penerimaan(x){
        x.value = x.dataset.nilaibiasa;       
        // console.log(x.value);
    }
    
    function _value_edit_hasil(x){       
        var hasil = Number(x.dataset.nilaibiasa);
        x.value=number_format(hasil,2,',','.');         
        // console.log(x.value);      
    }

    // hapus rekening dalam modal
    function hapusRekening(t){
        var row = t.parentNode.parentNode;
        var index = (row.rowIndex)-1;
        document.getElementById("data_spj_penerimaan").deleteRow(index);
        // console.log(index);
    }

    // hapus rekening dalam modal
    function hapusEditRekening(t){
        var row = t.parentNode.parentNode;
        var index = (row.rowIndex)-1;
        document.getElementById("edit_data_spj_penerimaan").deleteRow(index);
        // console.log(index);
    }

    function ambilnospp() {
        var nospp =$("#selectspp").val();
        var koderekening = $("#koderekening").val();
        //console.log(koderekening);
        var kd = koderekening.split(".");
        var kodeurusan = kd[0];
        var kodesuburusan = kd[1];
        var kodeorganisasi = kd[2];
        var kodedesa = kd[3];
        var tahun = <?php echo date('Y'); ?>;
        var jumlah_pagu = 0;
        var jumlah_all = 0;
        //console.log(kd[0]);
        $.ajax({
                type :"POST",
                url  :"<?php echo base_url()?>bku/buku_kas_umum/nospp",
                data :{tahun:tahun,kodeurusan:kodeurusan,kodesuburusan:kodesuburusan,kodeorganisasi:kodeorganisasi,kodedesa:kodedesa,nospp:nospp},
                dataType :"json",
                cache :"false",
                success: function(data){
                $("#data_rek_bku").html("");
                if (data != "fail") {
                    document.getElementById('uraian_spj').value=data[0]['URAI'];
                    document.getElementById('kegiatan').value=data[0]['URAI_KEGIATAN'];
                    //console.log(data);
                 for (var i = 0; i < data.length; i++) {
                    console.log(data[i].KODEREKENING);

                    $("#data_rek_bku").append("<tr><td>"+data[i].KODEREKENING+"</td>"+
                                              "<input type=\"hidden\" name=\"jml_rincian[]\">"+
                                              "<input type=\"hidden\" name=\"kode_rekening_"+i+"\" value=\""+data[i].KODEREKENING+"\">"+
                                              "<input type=\"hidden\" name=\"kode_bidang_"+i+"\" value=\""+data[i].KODEBIDANG+"\">"+
                                              "<input type=\"hidden\" name=\"kode_program_"+i+"\" value=\""+data[i].KODEPROGRAM+"\">"+
                                              "<input type=\"hidden\" name=\"kode_kegiatan_"+i+"\" value=\""+data[i].KODEKEGIATAN+"\">"+
                                              "<input type=\"hidden\" name=\"kode_akun_"+i+"\" value=\""+data[i].KODEAKUN+"\">"+
                                              "<input type=\"hidden\" name=\"kode_kelompok_"+i+"\" value=\""+data[i].KODEKELOMPOK+"\">"+
                                              "<input type=\"hidden\" name=\"kode_jenis_"+i+"\" value=\""+data[i].KODEJENIS+"\">"+
                                              "<input type=\"hidden\" name=\"kode_objek_"+i+"\" value=\""+data[i].KODEOBJEK+"\">"+
                                              "<td>"+data[i].URAI_REKENING+"</td>"+
                                               "<input type=\"hidden\" name=\"urai_rekening_"+i+"\" value=\""+data[i].URAI_REKENING+"\">"+
                                              "<td align='right'>"+format_rupiah(data[i].ANGGARAN)+"</td>"+
                                               "<input type=\"hidden\" name=\"pagu_anggaran_"+i+"\" value=\""+data[i].ANGGARAN+"\">"+
                                              "<td align='right'>"+format_rupiah(data[i].JUMLAH)+"</td></tr>"+
                                               "<input type=\"hidden\" name=\"penerimaan_pengeluaran_"+i+"\" value=\""+data[i].JUMLAH+"\">");
                    
                    jumlah_pagu = jumlah_pagu + data[i].ANGGARAN;
                    jumlah_all = jumlah_all + data[i].JUMLAH;
                    //console.log(jumlah_pagu);
                    //input post

                 };
                    // document.getElementById('jumlah_pagu').innerHtml = jumlah_pagu;

                    $('#jumlah_pagu').text(format_rupiah(jumlah_pagu));
                    $('#jumlah_all_pagu').val(jumlah_pagu);
                    $('#jumlah_all').text(format_rupiah(jumlah_all));
                    $('#jumlah_all_terima').val(jumlah_all);
                } else{
                    document.getElementById('uraian_spj').value="";
                    document.getElementById('kegiatan').value="";
                    $("#data_rek_bku").append("<tr><td colspan='4' align='center'>No Data</td></tr>");
                };
                
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });        
    }

</script>

<style type="text/css">
    .ibox-title{
        background-color: #1ab394;
        color: white !important;
    }
    
    .loader {
    border: 12px solid #f3f3f3; /* Light grey */
    border-top: 12px solid #1ab394; /* Blue */
    border-radius: 50%;
    width: 10px;
    height: 10px;
    animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .modal-header{
        background-color: #1ab394;
        color: white !important;
    }
    .select2-dropdown {  
        z-index: 10050 !important;/*1051;*/
    }
  @media (min-width: 768px) {
    .modal-xl {
        width: 85%;
        max-width:1200px;
      }
    }

    .tableRekening{
        width: 834px !important;
        /*margin-right: 1% !important;
        margin-left: 1% !important;*/
    }

    .kodeRek{
        width: 20% !important; 
   }

    .uraiRek{
        width: 80% !important; 
   }

    tr.selected {
        background-color: #acbad4;
    }
    td {
        padding: 5px;
    }

</style>