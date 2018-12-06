$(document).ready(function () {

    // Capturo el Tipo de Navegador usado por el User.
    var es_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
    var es_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
    var es_opera = navigator.userAgent.toLowerCase().indexOf('opera');
    var es_ie = navigator.userAgent.indexOf("MSIE") > -1;
    var valor = null;
    //Valido segun el Navegador Detectado.
    if (es_chrome) { // Chrome.
        //alert("El navegador que se está utilizando es Chrome");
        var vb = "true";
    }
    if (es_firefox) { // Firefox.
        //alert("El navegador que se está utilizando es Firefox");
        var vb = "false";
    }
    if (es_opera) { // Opera.
        //alert("El navegador que se está utilizando es Opera");
        var vb = "true";
    }
    if (es_ie) { // Internet Explorer.
        //alert("El navegador que se está utilizando es Internet Explorer");
        var vb = "false";
    }    
    
    // Evento AjaxStar para crear efecto de recargado en espera de la pag.
    //$(document).ajaxStart(function() { Pace.restart(); });    
    // AUTH -- VALIDACION DE FORMULARIOS
    $(function () {
        formValidation();
    });
    //  FIN DE AUTH
    
    var btnreg = $("#reg");
    var btnrec = $("#rec");
    var modal = $("#modalreg");
    var close = $(".close");            
    var refresh = function(){
        window.location.href = 'auth';
    };

    $(btnreg).click(function() {
        $('.modal-content').load(base_url + 'usuarios/agr_usu', function (response, status, xhr) {            
            if (status == "error") {
                var msg = "No se cargo correctamente el formulario debido a un error. Error: ";
                $("#error").html(msg + xhr.status + " " + xhr.statusText);
            }                            
        });                        

    });
    $(btnrec).click(function() {                
        $('.modal-content').load(base_url + 'usuarios/recu_clv', function (response, status, xhr) {
            if (status == "error") {
                var msg = "No se cargo correctamente el formulario debido a un error. Error: ";
                $("#error").html(msg + xhr.status + " " + xhr.statusText);
            }                            
        });
        // Forza el Cierre del Modal.
        //setTimeout(function() {
        //$(".modal").modal("hide");
        //}, 6000);
    });    
    
    
    //btn_ingreso
    $(document).on("click", "#ini", function (vb) {
        var correo = $("#corr").val();
        var pwd = sha1($("#pwd").val().toString());        
        var ruta = base_url + "public/img/wait.gif";                
        if (correo != "" && pwd != "") {
            $.ajax({
                url: base_url + 'auth/login',
                async: vb,                
                type: 'POST',
                data: {
                    correo: correo,
                    pwd: pwd.toString()
                },
                beforeSend: function() { // Evento que se Ejecuta Antes del Evento Principal.                   
                    // Evento ¡Cargando...! 
                    $('.load').html('<img src="'+ruta+'" width="30px"> Cargando...');                    
                },
                success: function (data) { // Evento Principal.            
                    switch (data.toString()) {                        
                        case "inicio":
                            //alert("fino");return false;
                            redireccion('inicio');
                            break;
                        default:
                            //alert('no llega');return false;
                             $(".form_auth").notify(                                
                                "El correo o la clave son incorrectos", 
                                {   position:"top center", 
                                    // position
                                    arrowShow: false,                                    
                                    // hide pestaña
                                    showAnimation: 'slideDown',
                                    // show animation duration
                                    showDuration: 100,
                                    // hide animation
                                    hideAnimation: 'slideUp',
                                    // hide animation duration
                                    hideDuration: 300,
                                    // padding between element and notification
                                    gap: 5,
                                    className: 'error'
                                }
                            );
                            //$('.ajax-content').html('<hr>Ajax Request Completed !');                          
                            //alertify.notify('El usuario o la clave no son correctos', 'error', 5, null);
                            break;
                    }
                },
                complete: function() { // Evento que se Ejecuta Una vez Completado el Evento Principal, si Todo sale Bien.
                    // Elimina el Efecto Cargando!
                    $('.load').html("");
                },
                error: function(ajax, estado, excepcion) { // Evento que se Ejecuta Luego del Evento Principal, si Todo Sale Mal.
                    alert("Error De Conexiòn.");
                }
            });            
        }
    });              


// =============== POPOVER-DETALLES ===================
/*
    $('.detini').popover({
        container: 'body',
        //title: '<h5 class="modal-title divlegh3 leg" align="center"><em>Iniciar Sesión </em><i class="fa fa- modal-icon"></i></h5>',
        content: '<h5 class="animated fadeIn btn bg-olive color-palette btn-xs" align="center"><em>Iniciar Sesión </em><i class="fa fa- modal-icon"></i></h5>',
        html: true,
        placement: 'bottom',
        trigger: 'hover'        
    });

    $('.detreg').popover({
        container: 'body',
        //title: '<h5 class="modal-title divlegh3 leg" align="center"><em>Registrar Usuario </em><i class="fa fa- modal-icon"></i></h5>',
        content: '<h5 class="animated fadeIn btn bg-light-blue disabled color-palette btn-xs" align="center"><em>Registrar Usuario </em><i class="fa fa- modal-icon"></i></h5>',
        html: true,
        placement: 'bottom',
        trigger: 'hover'        
    });

    $('.detinf').popover({
        container: 'body',
        //title: '<h5 class="modal-title divlegh3 leg" align="center"><em>Registrar Usuario </em><i class="fa fa- modal-icon"></i></h5>',
        content: '<h6 class="animated fadeIn btn bg-orange color-palette btn-xs" align="center"><em>¿Olvido su Contraseña? ¡Haga Click Aqui! </em><i class="fa fa- modal-icon"></i></h6>',
        html: true,
        placement: 'right',
        trigger: 'hover'        
    }); */   
// ======FIN====== POPOVER-DETALLES ========FIN========  

});

function aMays(e, elemento) {
    tecla = (document.all) ? e.keyCode : e.which;
    elemento.value = elemento.value.toUpperCase();
}

function aMins(e, elemento) {
    tecla = (document.all) ? e.keyCode : e.which;
    elemento.value = elemento.value.toLowerCase();
}

function redireccion(contr, meth) {
    location.replace(base_url + contr + (meth ? "/" + meth : ""));
}

function sha1(valo) {
    return CryptoJS.SHA1(valo);
}