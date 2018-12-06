<script type="text/javascript">
<?php // Declarar variable global base_url para que esté disponible en los documentos .js     ?>
    var base_url = '<?php print base_url(); ?>';
</script>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <link rel="shortcut icon" type="image/ico" href="<?php //echo base_url() ?>public/img/favicon.ico" /> -->
        <link rel="stylesheet" href="<?php print base_url(); ?>public/css/estilo.css">
        <title><?php print $titulo ?></title>
        <!-- <script src="//code.jquery.com/jquery-3.1.1.js" ></script> -->        
        <!-- ESTILOS DE VALIDACION -->
        <link rel="stylesheet" href="<?php print base_url(); ?>assets/plugins/validationengine/css/validationEngine.jquery.css" >
        <!-- FIN DE ESTILOS DE VALIDACION -->
        <!-- ESTILOS DE ICONOS -->        
        <link rel="stylesheet" href="<?php print base_url(); ?>assets/css/iconos/font-awesome.min.css">
        <!-- ANIMACIONES CSS -->
        <link rel="stylesheet" href="<?php print base_url(); ?>assets/css/animate.css">
        <!-- PACE CSS -->
        <link rel="stylesheet" href='<?php print base_url(); ?>assets/plugins/pace/pace.min.css'>
        <!-- AdminLTE - V 2.3.6 -->
        <link rel="stylesheet" href="<?php print base_url(); ?>assets/dist/css/AdminLTE.min.css">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php print base_url(); ?>public/css/bootstrap.min.css">
        <!-- LOGIN CSS -->
        <link rel="stylesheet" href="<?php print base_url(); ?>public/css/login/login.css">
        <!-- DATEPICKER3 CSS-->
        <link rel="stylesheet" href="<?php print base_url(); ?>assets/plugins/datepicker/datepicker3.css">
        <?php /* INCLUIR .JS */ ?>
        <!-- jQuery 2.2.3 -->
        <script src="<?php print base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>        
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php print base_url(); ?>assets/js/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php print base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- SHA1 JS V-3.1.2 -->
        <script src="<?php print base_url(); ?>assets/plugins/sha1/core-min.js"></script>
        <script src="<?php print base_url(); ?>assets/plugins/sha1/sha1.js"></script>        
        <!-- FIN SHA1 JS V-3.1.2 -->
        <!-- LOGIN JS PERSONALIZADO -->
        <script src="<?php print base_url(); ?>public/js/login/login.js"></script>        
        <!-- FIN LOGIN JS PERSONALIZADO -->
        <!--ALERTIFY V-1.5.0-->
        <script src="<?php print base_url(); ?>assets/plugins/alertify/alertify.min.js"></script>
        <!--FIN ALERTIFY V-1.5.0-->
        <!-- FORMWIZARD -->
        <script src="<?php print base_url(); ?>public/js/formwizard/formToWizard.js"></script>
        <?php // <!-- FIN DE FORMWIZARD --> ?>        
        <!-- INPUT-MASK JS-->
        <script src="<?php print base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
        <!-- FIN INPUT MASK JS -->
        <!-- INCLUDES PARA VALIDACION DE FORMULARIOS -->
        <script src='<?php print base_url(); ?>assets/plugins/validationengine/js/jquery.validationEngine.js'></script>
        <script src='<?php print base_url(); ?>assets/plugins/validationengine/js/languages/jquery.validationEngine-es.js'></script>
        <script src='<?php print base_url(); ?>assets/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js'></script>
        <script src='<?php print base_url(); ?>assets/js/validationInit.js'></script>
        <!-- FIN DE INCLUDES PARA VALIDACION DE FORMULARIOS -->
        <!-- NOTIFY JS -->
        <!-- INCLUDES PARA NOTIFICACIONES CON NOTIFYJS -->
        <script src="<?php print base_url(); ?>public/js/notifyjs/notify.js"></script>
        <!-- FIN NOTIFY JS -->
        <!-- FIN DE INCLUDES PARA NOTIFYJS -->
        <script src='<?php print base_url(); ?>assets/plugins/pace/pace.min.js'></script>
        <!-- DATEPICKER JS -->
        <script src='<?php print base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js'></script>        
        <!-- COMMON.JS -->
        <script src="<?php print base_url(); ?>public/js/common.js"></script>

    </head>    
    <body><!-- BODY -->        
        <div class="content"><!-- DIV CONTENT -->                
                <div class="loghead"><!-- DIV LOGHEAD -->
                    <header>
                        <h1 class="animated bounceInDown"><span><i class="fa fa-ioxhost fa-3x" id="iox" aria-hidden="true"></i></span><?php print $titulo2; ?></h1>
                        <h4 id="contenidoss"></h4>
                    </header>                                              
                    <br>
                        <div class="divlog"><!-- DIV DIVLOG -->
                            <div class="form_auth"><!-- DIV FORM_AUTH -->
                                <!-- FORM FORMLOGIN -->
                                <form name="popup-validation" id="popup-validation" method="post" action="">
                                    <div class="form-group load"></div>
                                    <div class="form-group"><!-- DIV FROM-GROUP I-->
                                        <div class="row justify-content-center">
                                                <div class="col-sm-13">
                                                    <div class="input-group animated bounceInLeft has-feedback">
                                                        <span class="input-group-addon">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="text" name="corr" id="corr" class="form-control validate[required, custom[email]]" value="" placeholder="Email" autofocus>
                                                    </div>
                                                </div>                                        
                                            </div>
                                            <br>
                                        <div class="form-group"><!-- FORM-GROUP I.II -->
                                            <div class="row justify-content-center">                                        
                                                <div class="col-sm-13">
                                                    <div class="input-group animated bounceInRight has-feedback">
                                                        <span class="input-group-addon">
                                                            <i style="text-shadow: -5px 0px 5px grey;" class="glyphicon glyphicon-lock"></i>
                                                        </span>
                                                        <input type="password" name="pwd" id="pwd" class="form-control validate[required, minSize[8], maxSize[20]]" value="" placeholder="Contraseña">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- FIN FORM-GROUP I.II -->                                        
                                        <div class="form-group"><!-- FORM-GROUP I.III -->                                        
                                            <div class="row justify-content-center">                                                
                                                <div class="col-sm-13 animated bounceIn">
                                                    <button type="submit" class="btn bg-olive detini" id="ini" name="ini" style="text-shadow: -5px 0px 5px #000;" title="Iniciar Sesión"><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Iniciar</button>
                                                    <button type="button" class="btn btn-default detreg" name="reg" id="reg" data-toggle="modal" data-target="#moinm" style="text-shadow: -5px 0px 5px grey;" title="Registrar Usuario"><i class="glyphicon glyphicon-new-window" aria-hidden="true"></i> Registrarse</button>
                                                    <span title="¿Olvido su Contraseña? ¡Haga Click Aqui!">
                                                        <button type="button" name="rec" id="rec" class="btn btn-link detinf" data-toggle="modal" data-target="#moinm" style="border-radius: 20px;text-shadow: 0px 1px 4px #000000;">
                                                                <i class="fa fa-info fa-lg"></i>
                                                        </button>
                                                    </span>                                                               
                                                </div>
                                            </div>
                                        </div><!-- FIN FORM-GROUP I.III -->
                                    </div><!-- FIN FORM-GROUP I-->
                                </form><!-- FIN FORMLOGIN -->
                            </div><!-- FIN DIV FORM_AUTH -->
                        </div><!-- FIN DIVLOG-->                         
                    <footer><!-- FOOTER -->
                        <div class="" style="text-align: center;">
                            <div class="copyright animated fadeInUp">
                                © 2018 SIGECSE - MARACAY - ARAGUA - FLA - Versión 1.0            
                            </div>    
                        </div>                        
                    </footer><!-- FIN FOOTER -->                    
                </div><!-- FIN LOGHEAD -->                       
        </div><!-- FIN CONTENT -->        
        <!-- MODAL INMODAL -->
        <div id="moinm" class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <!-- MODAL DIALOG modalreg -->
            <div id="modalreg" class="modal-dialog">
                <!-- MODAL CONTENT -->
                <div class="modal-content animated bounceIn">
                <?php //$this->load->view("reg_usu"); ?>
                </div><!-- FIN MODAL CONTENT -->                
            </div><!-- FIN MODAL DIALOG modalreg -->            
        </div><!-- FIN MODAL INMODAL -->
        <!-- MODAL INMODAL -->
        <!-- <div id="moinmII" class="modal inmodal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false"> -->
            <!-- MODAL DIALOG modalrec -->
            <!-- <div id="modalrec" class="modal-dialog"> -->
                <!-- MODAL CONTENT -->
                <!-- <div class="modal-content animated bounceInRight"> -->
                <?php //$this->load->view("rec_pwd"); ?>
                <!-- </div>FIN MODAL CONTENT -->
            <!-- </div>FIN MODAL DIALOG modalrec -->
        <!-- </div>FIN MODAL INMODAL -->
    </body><!-- FIN BODY -->
</html>
