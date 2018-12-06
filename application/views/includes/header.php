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
        <?php // <!-- INCLUDES PARA NOTIFICACIONES CON NOTIFYJS --> ?>
        <script src="<?php print base_url(); ?>public/js/notifyjs/notify.js"></script>
        <!-- FIN NOTIFY JS -->
        <?php // <!-- FIN DE INCLUDES PARA NOTIFYJS --> ?>     
        <script src='<?php print base_url(); ?>assets/plugins/pace/pace.min.js'></script>                
        <!-- COMMON.JS -->
        <script src="<?php print base_url(); ?>public/js/common.js"></script>

</head>
<body>
