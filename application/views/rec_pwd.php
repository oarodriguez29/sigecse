<?php
/* ------------------------------------------------
  ARCHIVO: rec_pwd.php
  DESCRIPCION: Contiene la vista de una ventana modal que muestra el formulario para Recuperar los Datos del Usuario.
  FECHA DE CREACIÓN: 22/01/2018
 * 
  ------------------------------------------------ */
?>
<script type="text/javascript">
$(document).ready(function(){

    // Configuración del Formulario Wizard
    $("#form_rcpwd").formToWizard({            
            submitButton: 'env_rec',
            buttonTag: 'button',
            nextBtnName: 'Siguiente <i style="padding: 0px 0px;" class="fa fa-arrow-right btn btn-success"></i>',
            prevBtnName: '<i style="padding: 0px 0px;" class="fa fa-arrow-left btn btn-success"></i> Atras',
            nextBtnClass: 'btn next_',
            prevBtnClass: 'btn prev_',
            validateBeforeNext: function () {
                return true;
                //return $('#edit_grp1').validationEngine('validate');
            },
            progress: function (i, count) {                
                $('#progress-complete').width('' + (i / count * 100) + '%');                
            }                   
        });     

            // Para habilitar la función de las máscaras en los controles.
            $("[data-mask]").inputmask();

            // Configuración de las máscaras con formato para la CI.
            $("#corr_rec").inputmask(
                    "",
                    {
                        "onincomplete": function () {                        
                            $(this).val("");
                            $(this).focus();
                        }
                    }
            );
    
    $(document).on("click","#env_rec", function(){
        if($("#rcpwd").validationEngine('validate')) {        
            var correo = $("#corr_rec").val();
            var ruta = base_url + "public/img/wait.gif";
            //alert(correo);            
            $.ajax({
                url: base_url + 'usuarios/EnvioEmails', //enviar', //'usuarios/env_rec',
                async: false,                
                type: "POST",
                dataType: "JSON",
                data: {corr:correo},
                beforeSend: function() {
                    $('.load').html('<img src="'+ruta+'" width="20px"> Enviando...');
                },                
                success: function(json) {
//                    if (parseInt(json.resu) !== 0) {
//                    alert(json.msj +'<->'+json.resu);
//                    //$.notify(data,"success");
//                    }
                    switch (parseInt(json.resu)) {
                        case 0:
                            $.notify(json.msj,"success");
                            $(".close").click();                            
                            setTimeout(function(){
                                    $.notify("Por Favor Revise la Bandeja de Entrada de su Correo o la Carpeta de Spam",{className:'info',autoHideDelay:10000});
                                }, 6000);
                            break;
                        case 1:
                            $.notify(json.msj,"warn");
                            break;
                        case 2:
                            $.notify(json.msj,"warn");
                            break;
                        case 3:
                            $.notify(json.msj,"warn");
                            break;
                        case 4:
                            $.notify(json.msj,"error");
                            break;
                        case 5:
                            $.notify(json.msj,"warn");
                            break;
                        case 6:
                            $.notify(json.msj,"warn");
                            break;                            
                    }                    
                },
                complete: function() {
                    $('.load').html('');
                },
                error: function(ajax, estado, excepcion){
                    //alert("Error de Conexiòn.");
                    $.notify("Error de Conexion!","error");
                }                
            });
        }else{
            return false;
        }
    });
    
    
    
//            /* Para el ajax load */
//            $body = $("body");
//
//            $(document).on({
//                // para el ajax load
//                ajaxStart: function() { $body.addClass("loading"); },
//                ajaxStop: function() { $body.removeClass("loading"); }
//            });
//
//            
//            $(document).on('click', '#ini_ses', function () {
//                location.href= base_url + "auth/";
//            });
//            
//            $(document).on('click', '#rec_dat', function () {
//                <?php // Recuperar datos por medio del nombre de usuario ?>
//                $('#uno').addClass("loading");
//                var login = $("#logi").val();
//                var mail = $("#mail").val();
//                if (login.length >= 1 || mail.length >= 1) {
//                    $.ajax({
//                        type: 'POST',
//                        url: base_url + 'auth/rec_dat_acc',
//                        data: {
//                            log: login, mai: mail
//                        },
//                        success: function (msg) {
//                            if (msg == '0') {
//                                $(".form_recovery").notify("Los datos de acceso se han enviado a su correo", 
//                                    {   position:"bottom center", showAnimation: 'slideDown', showDuration: 400, hideAnimation: 'slideUp', hideDuration: 200, gap: 2, className: 'info' }
//                                );
//                                location.href=base_url + 'auth/';
//                            } else {
//                                $(".form_recovery").notify(msg, 
//                                    {   position:"bottom center", showAnimation: 'slideDown', showDuration: 400, hideAnimation: 'slideUp', hideDuration: 200, gap: 2, className: 'error' }
//                                );
//                            }
//                        }
//                    });
//                }
//                else {
//                    // alert("Debe colocar el nombre de usuario o el correo para recuperar los datos de acceso");
//                    $(".form_recovery").notify("Debe colocar el nombre de usuario o el correo para recuperar los datos de acceso", 
//                        {   position:"bottom center", showAnimation: 'slideDown', showDuration: 400, hideAnimation: 'slideUp', hideDuration: 200, gap: 2, className: 'warn' }
//                    );
//                }
//            });
            
 
});
</script>
                    <!-- MODAL HEADER -->
                    <div class="modal-header hrgt">
                        <button class="close" data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                            <span class="sr-only">Cerrar</span>                            
                        </button>
                        <h3 align="center"><?php print $titulo; ?> <i class="fa fa-edit"></i></h3>
                    </div>
                    <!-- FIN MODAL HEADER -->
                    <!-- MODAL BODY -->
                    <div class="modal-body brcpwd">                                               
                            <!-- FOMULARIO, REGISTRO DE USUARIO -->
                            <form name="rcpwd" id="rcpwd" method="post" action="">
                                <!-- FIELSET I -->
                                <!--<fieldset class="fielsetForm">-->
                                    <!-- FORM-GROUP I-->
                                    <div class="form-group">                                         
                                        <!-- div row justify-content-center I-->
                                        <div class="row justify-content-center">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-6 animated rotateIn ">
                                                    <label class="control-label" for="email">Correo Electronico</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="" aria-hidden="true">@</i>
                                                        </span>
                                                    <input type="email" name="corr_rec" id="corr_rec" class="form-control validate[required, custom[email]]" value="" placeholder="ejemplo@ejemplo.com" autofocus>
                                                </div>
                                                <br>
                                                <!--<div class="alert alert-info animated rotateIn">si llego fino</div>-->
                                            </div>                                            
                                        </div>
                                        <!-- FIN div row justify-content-center I-->
                                    </div>
                                    <!-- FIN FORM-GROUP I-->
                                        <br>
                                <!--</fieldset>-->
                                <!-- FIN FIELSET I -->    
                            </form>
                            <!-- FIN FOMULARIO, RECUPERACION DE DATOS -->
                    </div>
                    <!-- FIN MODAL BODY -->
                    <!-- MODAL FOOTER -->
                    <div class="modal-footer frcpwd">
                        <div class="form-group load"></div>
                        <div class="row" align="center">
                            <button type="button" name="env_rec" id="env_rec" class="btn bg-navy next">Enviar</button>
                            <button type="button" class="btn btn-default" id="cerrar" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                    <!-- FIN MODAL FOOTER -->
