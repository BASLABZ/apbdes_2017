<script>
        // click all
        function toggle(argument) {
        checkbox = $(".sarasvati");
            for (var i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = argument.checked;
            }
        }
        // batalkan pengesahan
        function  batalkan(argument) {
            var id_pengesahan = <?php echo $this->session->userdata('kd_user'); ?>;
            checkbox = argument;
            swal({  
                    title: "Apa anda yakin?",   
                    text: "Anda akan membatalkan pengesahan Draft SPP No "+checkbox,   
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
                                        url  :"<?php echo base_url()?>verifikasi/pengesahan/batalkanSPP",
                                        data :{spp:checkbox,id_pengesahan:id_pengesahan},
                                        dataType :"html",
                                        cache :"false",
                                        success: function(data){
                                           if (data=="OK") {
                                            // $("#tampil").trigger('click');     
                                            // swal("Batalkan!", "Draft SPP dibatalkan", "success");   
                                            swal({
                                                   title :"Informasi",
                                                   text : "Draft SPP dibatalkan.",
                                                   type : "success"
                                                },
                                                function(){
                                                    window.location.reload();
                                                });
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
      
        $(".select2").select2({
           placeholder: "-- Pilih Kecamatan/Desa --",
           // allowClear: true
        })

        // css select2
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");

        

        //form simpan setujui
        $("#btnsetujuisend").click(function(e){
            e.preventDefault();
            var id_pengesahan = <?php echo $this->session->userdata('kd_user'); ?>;
            var nospp=[];
            $(".sarasvati:checked").each(function(i){
                nospp[i] = $(this).val();
            });
            // console.log(nospp);
            if (nospp.length == 0) {swal("","NO SPP Belum ada yang di pilih.","warning");return false;};
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url()?>verifikasi/pengesahan/sahkanSPP",
                data :{spp:nospp,id_pengesahan:id_pengesahan},
                dataType : "html",
                cache:"false",
                success:function(data) {
                    if (data=='OK'){
                        // $("#tampil").trigger('click');
                        swal({
                           title :"Informasi",
                           text : "Draft SPP berhasil disahkan.",
                           type : "success"
                        },
                        function(){
                            window.location.reload();
                        });
                    }else{
                        swal("","Terjadi Kesalahan, Silahkan Coba Lagi.","error");
                    }
                },
                 error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // console.log(errorThrown);
                }
            });
        });

    });
</script>