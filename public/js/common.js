$(document).ready(function(event){
/*        $("#form_reg_usu").load(base_url + 'Usuarios/reg_usu', function (response, status, xhr) {
            if (status == "error") {
                var msg = "No se cargo correctamente el formulario debido a un error. Error: ";
                $("#error").html(msg + xhr.status + " " + xhr.statusText);
            }
        });*/


    // AUTH -- VALIDACION DE FORMULARIOS
    $(function () {
        formValidation();
    });
    //  FIN DE AUTH

/*
    //btn_ingreso
    $(document).on("click", "#env_reg", function () {        
        var ruta = base_url + "public/img/loader.gif"; 
        //alert("fino");return false;
        if($("#rgt").validationEngine('validate')) {
            //var data = new FormData($("#rgt")[0]);
            var data = $("#rgt").serialize();
            //console.log(data);return false;
            $.ajax({
                url: base_url + 'usuarios/reg_usu',
                async: false,
                type: 'POST',
                data: sha1(data),
                beforeSend: function() {
                    $('.load').html('<img src="'+ruta+'" width="20px"> Guardando...');
                },
                success: function (data) {
                        if (parseInt(data) === 0) {
                            alert("Los datos se han guardado con éxito");
                            //dt_prov.fnReloadAjax();
                            $(".close").click();
                            location.reload(); // Por ahora recargar la pagina mientras no se soluciona la linea de arriba
                        } else {
                            alert(data);
                            return false;
                        }                    
                },
                complete: function() {
                   $('.load').html(''); 
                }
            });
        }else{
            return false;
        }
    }); */

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