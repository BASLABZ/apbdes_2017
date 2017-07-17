<script>
        // click all
        function toggle(argument) {
        checkbox = $(".sarasvati");
            for (var i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = argument.checked;
            }
        }

        // batalkan persetujuan
        function  batalkan(argument) {
            var id_persetujuan = <?php echo $this->session->userdata('kd_user'); ?>;
            checkbox = argument;
            swal({  
                    title: "Apa anda yakin?",   
                    text: "Anda akan membatalkan persetujuan Draft SPP No "+checkbox,   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Ya, batalkan!",   
                    cancelButtonText: "Tidak!",   
                    closeOnConfirm: false,   
                    closeOnCancel: false }, 
                    function(isConfirm){   
                        if (isConfirm) {
                                $.ajax({
                                        type :"POST",
                                        url  :"<?php echo base_url()?>verifikasi/persetujuan/batalkanSPP",
                                        data :{spp:checkbox,id_persetujuan:id_persetujuan},
                                        dataType :"html",
                                        cache :"false",
                                        success: function(data){
                                           if (data=="OK") {
                                            swal({
                                                   title :"Informasi",
                                                   text : "Draft SPP telah dibatalkan.",
                                                   type : "success"
                                                },
                                                function(){
                                                    window.location.reload();
                                                })
                                            // $("#tampil").trigger('click');    
                                           }else{
                                            $("#tampil").trigger('click');     
                                            swal("","Terjadi Kesalahan, Silahkan Coba Lagi.","error");
                                           }
                                            // console.log(data);
                                        },
                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                            // console.log(errorThrown);
                                        }
                                    });
                            
                        } else {
                            swal({
                                   title :"Informasi",
                                   text : "Draft SPP tidak jadi dibatalkan",
                                   type : "warning"
                                },
                                function(){
                                    window.location.reload();
                                })
                            // $("#tampil").trigger('click');
                            // swal("Cancel", "Draft SPP tidak jadi dibatalkan", "error");   
                        } 
                    });
        }
</script>
<script>
    winload(function(){
        // pilih desa
        
        $('#pilihDesa').on('change',function(){
            $('#tampil').click();
        })

        $(".select2").select2({
           placeholder: "-- Pilih Kecamatan/Desa --",
           // allowClear: true
        });         
               
        
        // css select2
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");

        //form simpan setujui
        $("#btnsetujuisend").click(function(e){
            e.preventDefault();
            var nospp=[];
            var id_persetujuan = <?php echo $this->session->userdata('kd_user'); ?>;
            $(".sarasvati:checked").each(function(i){
                nospp[i] = $(this).val();
            });
            // console.log(nospp);
            if (nospp.length == 0) { swal("","NO SPP Belum ada yang di pilih.","warning");return false;};
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url()?>verifikasi/persetujuan/setujuiSPP",
                data :{spp:nospp,id_persetujuan:id_persetujuan},
                dataType : "html",
                cache:"false",
                success:function(data) {
                    if (data=='OK'){
                        
                        swal({
                           title :"Informasi",
                           text : "Draft SPP telah berhasil disetujui.",
                           type : "success"
                        },
                        function(){
                            window.location.reload();
                        });
                        // $("#tampil").trigger('click');
                    }else{
                        swal("","Terjadi Kesalahan, Silahkan Coba Lagi.","error");
                    }
                },
                 error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    
    });
</script>