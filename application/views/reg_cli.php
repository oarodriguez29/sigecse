<?php
/* ------------------------------------------------
  ARCHIVO: reg_cli.php
  DESCRIPCION: Contiene la vista de una ventana modal que muestra el formulario para agregar los Datos de los Usuarios.
  FECHA DE CREACIÓN: 21/01/2018
 * 
  ------------------------------------------------ */
//print $head;

?>
<script>
$(document).ready(function(){  

// AUTH -- VALIDACION DE FORMULARIOS
    $(function () {
        formValidation();
    });
    //  FIN DE AUTH

    // Confirmacion para guardar un registro
    function conf_guar() {
        return  confirm("¿Confirma que desea guardar este registro?");
    }
    // Fin de Confirmacion para guardar un registro

    //  Confirmacion para eliminar un registro
    function conf_elim() {
        return  confirm("¿Confirma que desea eliminar este registro?");
    }  
/*        $("#form_reg_usu").load(base_url + 'Usuarios/reg_usu', function (response, status, xhr) {
            if (status == "error") {
                var msg = "No se cargo correctamente el formulario debido a un error. Error: ";
                $("#error").html(msg + xhr.status + " " + xhr.statusText);
            }
        });*/

    // Configuración del Formulario Wizard
    $("#rgt").formToWizard({            
            submitButton: 'env_reg',
            buttonTag: 'button',
            nextBtnName: 'Siguiente <i style="padding: 0px 0px;" class="fa fa-arrow-right btn btn-success"></i>',
            prevBtnName: '<i style="padding: 0px 0px;" class="fa fa-arrow-left btn btn-success"></i> Atras',
            nextBtnClass: 'btn next_',
            prevBtnClass: 'btn prev_',
            validateBeforeNext: function () {
                //return true;
                return $('#rgt').validationEngine('validate');
            },
            progress: function (i, count) {                
                $('#progress-complete-reg-usu').width('' + (i / count * 100) + '%');                
            }                   
        });        

            // Para habilitar la función de las máscaras en los controles.
            $("[data-mask]").inputmask();

            // Configuración de las máscaras con formato para la CI.
            $("#ci").inputmask(
                    "V-99.999.999",
                    {
                        "placeholder": "_",
                        "onincomplete": function () {                        
                            $(this).val("");
                            //alert("Por Favor! Complete con ceros(0) los Campos en Blanco de su Cèdula!");                            
                            $(this).focus();                            
                        }                        
                    }
            );            
            // Configuración de las máscaras con formato para la Fecha de Nac.
            /*$("#fn").inputmask(
                    "99-99-9999",
                    {
                        "onincomplete": function () {                        
                            $(this).val("");
                            $(this).focus();
                        }
                    }
            );*/
            // Configuración de las máscaras con formato para el TLF.
            $("#tlf").inputmask(
                    "(9999)999-99-99",
                    {
                        "onincomplete": function () {                        
                            $(this).val("");
                            $(this).focus();
                        }
                    }
            ); 

    // AUTH -- VALIDACION DE FORMULARIOS
    $(function () {
        formValidation();
    });
    //  FIN DE AUTH
    //btn_ingreso
    $(document).on("click", "#env_reg", function () {
        var ruta = base_url + "public/img/wait.gif"; 
        //alert("fino");return false;
        if($("#rgt").validationEngine('validate')) {
            if(conf_guar()){
                //var data = new FormData($("#rgt")[0]);
                //var data = $("#rgt").serialize();
                //alert(data);return false;
                var pwd2 = sha1($('#pwd2').val().toString()),
                    cpwd = sha1($('#cpwd').val().toString()),
                    fecha = $('#fn').val();
                    // Formateo la Fecha de: (dd-mm-YYYY) -> a: (YYYY-mm-dd).
                    var fcn = fecha.replace(/^(\d{2})-(\d{2})-(\d{4})$/g,'$3-$2-$1');
                    //alert(resu);return false;
                var data = 
                {
                    "id": $("#id_rgc").val(),                    
                    "ci": $('#ci').val(),
                    "ape": $('#ape').val(),
                    "nom": $('#nom').val(),
                    "fn": fcn,
                    "tlf": $('#tlf').val(),
                    "ncasa": $('#ncasa').val(),
                    "calle": $('#calle').val(),
                    "coha": $('#coha').val(),
                    "email": $('#email').val(),                    
                    "pwd2": pwd2.toString(),
                    "cpwd": cpwd.toString()
                }                
                //console.log(data);
                $.ajax({
                    url: base_url + 'usuarios/reg_cli',
                    async: false,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {datos:data},
                    beforeSend: function() {
                        $('.load').html('<img src="'+ruta+'" width="20px"> Guardando...');
                    },
                    success: function (json) {
                        //alert(parseInt(json.res) +"<->"+ json.msj);return false;
                            if (parseInt(json.res) === 200) {
                                $('.load').html('');
                                //alert(json.msj); // msj (Los Datos Fueron Guardados).
                                //$(document).fnReloadAjax();
                                $(".close").click();
                                $.notify(json.msj,"success");
                                //location.reload(); // Por ahora recargar la pagina mientras no se soluciona la linea de arriba
                            } else {
                                //alert(json.msj); // msj de Validacion.
                                $.notify(json.msj,"warn");                                
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
        }else{
            return false;
        }
    });  
    
    /***MUESTRA EL CALENDARIO***/

    $(document).on("focus", ".calendar", function () {
        $(".calendar").datepicker({
            dateFormat: 'dd-mm-yyyy', //'yy-mm-dd',
            numberOfMonths: 1,
            "onSelect": function (date) {
                min = new Date(date).getTime();
                max = new Date(date).getTime();
                oTable.fnDraw();
            }
        });
    });    

function sha1(valor) {
    return CryptoJS.SHA1(valor);
}

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
                    <?php //print_r($cmb);die; ?>
                    <!-- FIN MODAL HEADER -->
                    <!-- MODAL BODY -->
                    <div class="modal-body brgt">
                            <!-- BARRA DE PROGRESO DEL FORMULARIO -->
                            <div id='progress_formwizard' style="margin-top: -10px;"><div id='progress-complete-reg-usu'></div></div>
                        <!--<div class="">-->
                            <!-- FOMULARIO, REGISTRO DE USUARIO -->
                            <form name="rgt" id="rgt" method="post" action="">                            
                                <div class="input-group input-group-sm" style="display:none;">
                                    <input id="id_rgc" name="id_rgc" value="" class="form-control" style="display: none;">
                                </div>
                                    <br>
                                <!-- FORM-GROUP -->
                                <div class="form-group ">
                                    <!-- FIELDSET I-->
                                    <fieldset  class="fielsetForm"> 
                                        <!-- div row justify-content-center I-->                                       
                                        <div class="row justify-content-center">
                                            <!-- <div class="col-sm-2"></div> -->
                                            <div class="col-sm-3">
                                                    <label class="control-label" for="ci">Cédula</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="" aria-hidden="true">Nº</i>
                                                        </span>
                                                    <input type="text" name="ci" id="ci" class="form-control validate[required]" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                    <label class="control-label" for="ape">Apellidos</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="fa fa-user" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="text" name="ape" id="ape" class="form-control validate[required]" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                    <label class="control-label" for="nom">Nombres</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="fa fa-user" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="text" name="nom" id="nom" class="form-control validate[required]" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIN div row justify-content-center I-->                                  
                                        <br>
                                        <!-- div row justify-content-center II-->                                             
                                        <div class="row justify-content-center">
                                        <div class="col-sm-2"></div>                                          
                                            <div class="col-sm-4">
                                                    <label class="control-label" for="fn">Fecha Nacimiento</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon" id="gr1">
                                                        <i style="text-shadow: -5px 0px 5px grey;" class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="text" name="fn" id="fn" class="form-control validate[required] calendar" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                    <label class="control-label" for="tlf">Nº Telefonico</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="fa fa-phone" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="text" name="tlf" id="tlf" class="form-control validate[required]" value="">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- FIN div row justify-content-center II-->
                                        <br>
                                        <!-- div row justify-content-center II.I-->                                             
                                        <div class="row justify-content-center">                                        
                                            <div class="col-sm-3">
                                                    <label class="control-label" for="ncasa">Nº Casa</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="glyphicon glyphicon-home" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="text" name="ncasa" id="ncasa" class="form-control validate[required, custom[onlyNumberSp]]" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                    <label class="control-label" for="calle">Nº Calle</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="glyphicon glyphicon-road" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="text" name="calle" id="calle" class="form-control validate[required, custom[onlyNumberSp]]" value="">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                    <label class="control-label" for="coha">Condición Habitacional</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="glyphicon glyphicon-tent" aria-hidden="true"></i>
                                                        </span>
                                                    <select name="coha" id="coha" class="form-control validate[required]">
                                                        <option value="">Seleccione</option>
                                                        <?php if($combo != null){ ?>
                                                        <?php if(count($combo)>0) { ?>
                                                        <?php foreach ($combo as $cmb => $value):
                                                            $sl = $cmb === @$cmb ? "selected='selected'": null;
                                                        ?>
                                                        <option <?php  $sl; ?> value="<?php print $cmb; ?>">- <?php print $value; ?></option>
                                                        <?php endforeach; ?>
                                                        <?php }else{ ?>
                                                        <option value="">No se Hallaron Registros!</option>
                                                        <?php } ?>
                                                        <?php }else{ ?>
                                                        <option value="">No Hay Registros!</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <!-- FIN div row justify-content-center II.I--> 
                                        <br><br>                                 
                                    </fieldset>
                                    <!-- FIN FIELDSET I-->
                                    <!-- FIELDSET II-->
                                    <fieldset  class="fielsetForm">                                                                          
                                        <!-- div row justify-content-center III-->
                                        <div class="row justify-content-center">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-6">
                                                    <label class="control-label" for="email">Correo Electronico</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="" aria-hidden="true">@</i>
                                                        </span>
                                                    <input type="email" name="email" id="email" class="form-control validate[required, custom[email]]" value="" placeholder="ejemplo@ejemplo.com">
                                                </div>
                                            </div>                                            
                                        </div>
                                        <!-- FIN div row justify-content-center III-->
                                        <br>
                                        <!-- div row justify-content-center IV-->
                                        <div class="row justify-content-center">
                                        <!-- <div class="col-sm-2"></div> -->                                            
                                            <div class="col-sm-6">
                                                    <label class="control-label" for="pwd1">Contraseña</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="fa fa-key" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="password" name="pwd2" id="pwd2" class="form-control validate[required, minSize[8], maxSize[20]]" value="" placeholder="Contraseña">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                    <label class="control-label" for="cpwd">Confirmar Contraseña</label>
                                                <div class="input-group input-group-sm">
                                                        <span class="input-group-addon" id="gr1">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="fa fa-key" aria-hidden="true"></i>
                                                        </span>
                                                    <input type="password" name="cpwd" id="cpwd" class="form-control validate[required, equals[pwd2], minSize[8], maxSize[20]]" value="" placeholder="Confirmar Contraseña">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIN div row justify-content-center IV--> 
                                        <br><br>
                                        <div class="col-sm-8"></div>                                     
                                    </fieldset>
                                    <!-- FIN FIELDSET II-->
                                </div>
                                <!-- FIN FORM-GROUP -->
                            </form>
                            <!-- FIN FOMULARIO, REGISTRO DE USUARIO -->
                        <!--</div>-->
                        <!-- -->
                    </div>
                    <!-- FIN MODAL BODY -->
                    <!-- MODAL FOOTER -->
                    <div class="modal-footer frgt">
                        <div class="form-group load"></div>
                        <div class="row" align="center">
                            <button type="button" name="env_reg" id="env_reg" class="btn bg-navy">Enviar</button>
                            <button type="button" class="btn btn-default" id="cerrar" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                    <!-- FIN MODAL FOOTER -->
