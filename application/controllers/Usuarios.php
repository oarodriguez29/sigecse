<?php
require_once 'Mailin.php';
//Controlador de inicio de session del usuario (logueo del usuario)
class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('table');
        $this->load->library('form_validation');
        $this->load->Model('usuario_model');
    }

    public function index() {

        $data["base_url"] = base_url();
        $data["contenido"] = "usuarios";
        $this->load->view("layout", $data);
    }

    public function agr_usu() {
        $data['base_url'] = base_url();
        $data['titulo'] = 'Registro de Usuarios';
        $data['combo'] = array(
            'propietario' => 'Propietario',
            'alquilado' => 'Alquilado',
            'arrimado' => 'Arrimado'
         );    
        //$header = $this->load->view('includes/header');
        //$header = '<script src="assets/plugins/sha1/core-min.js"></script>';
        //$data['head'] = $header;
        
        $this->load->view('reg_cli', $data);
    }

    public function reg_cli() {
        //$this->load->Model("usuario_model");
        $datos = $this->input->post('datos');
        //print_r($datos);die();
        //print $datos['fn'];die();
        $id = trim($datos['id']);
        $cod = 0; // Campo Validado Internamente en el P.A en la BD.
        $ced = trim(str_replace(".","",strtoupper($datos['ci'])));
        //print "cedula ->: ".$ced;die();
        $ape = trim(strtoupper($datos['ape']));
        $nom = trim(strtoupper($datos['nom']));
        //$fcn = nice_date($datos['fn'],'Y-m-d');        
        $fcn = trim($datos['fn']);        
        //print "FECHA ->".nice_date($fcn,'Y-m-d');die();
        $tlf = trim(str_replace("-","",$datos['tlf']));
        //print "TLF ->:".$tlf;die();
        $ncasa = trim(strtoupper($datos['ncasa']));
        $calle = trim(strtoupper($datos['calle']));
        $coha = trim(strtoupper($datos['coha']));
        $corr = trim(strtoupper($datos['email']));
        $pwd = trim($datos['pwd2']);
        $cpwd = trim($datos['cpwd']);
        $fot = 0;        
        try {
            if($id != NULL){
                
            }else{                
                if($pwd === $cpwd){
                    $id = 0;
                    $resu = $this->usuario_model->user_cli_ins($id, $cod, $ced, $nom, $ape, $fcn, $tlf, $ncasa, $calle, $coha, $corr, $pwd, $fot);
                }else{
                    $arr['msj'] = "Las Contraseñas no Coinciden!";                    
                }
            }
            $arr['res'] = 200;
            $arr['msj'] = "Se Ha Registrado Correctamente!";
        } catch (Exception $exc) {
            $arr['msj'] = $exc->getMessage();
        }
        print json_encode($arr);            
    }

    public function recu_clv() {        
        $data['base_url'] = base_url();
        $data['titulo'] = 'Recuperacion de Clave';
        $this->load->view('rec_pwd',$data);

//        sleep(5);
//        $corr = $this->input->post('correo');
//        print $corr;die();        
    }

    // Enviar mail para recuperación de datos del usuario
    public function env_rec() {
        //sleep(5);
        $mail = $this->input->post('corr') != NULL ? $this->input->post('corr') : NULL;
        //print $mail;die();        
        // Declarar variables
        $apellidos = "";
        $nombres = "";
        $correo = "";
        $clave = "";
        $clave_enc = "";
        $dat_usu = "";
        // Verificar que hay datos para consultar
        if(trim($mail) != "" || trim($mail) != NULL){
            // Consultar por correo
            $dat_usu = $this->usuario_model->cli_get_x_mai($mail);
            //print $dat_usu[0]->id_cli;die();
        }
        else{            
            $arr['resu'] = 1;
            $arr['msj'] = "Debe ingresar el correo para recuperar la clave!";            
            //print 'Debe ingresar el nombre de usuario o el correo para recuperar la clave.';
        }
        // Cargar los datos del Usuario en las variables
        if(count($dat_usu) >= 1)
        {
            $id_usu = trim(@$dat_usu[0]->id_cli);
            $apellidos = mb_strtoupper(htmlspecialchars(trim(@$dat_usu[0]->ape_cli)),'utf-8');
            $nombres = mb_strtoupper(htmlspecialchars(trim(@$dat_usu[0]->nom_cli)),'utf-8');            
            $correo = mb_strtolower(htmlspecialchars(trim(@$mail)),'utf-8');
            // Setear la clave
            $id_clave = (new DateTime(date('Y/m/d').' '.date("H:i:s"), new DateTimeZone('America/Caracas')))->getTimestamp();
            $clave = "*.".trim($id_clave)."-";
            $clave_enc = sha1($clave);
            //print $clave_enc;die();
            try {
                $resu = $this->usuario_model->set_pwd_us($id_usu, $clave_enc);                                
                if($resu == 0){
                    // Enviar el correo
                    // Uno o Varios destinatarios
                    $para = "";
                    if(trim($correo) != NULL || trim($correo) != ""){
                        $para  = $correo;                        
                    }
//                    elseif((trim($correo2)!= NULL || trim($correo2)!= "") && (trim($correo1)== NULL || trim($correo1)=="")){
//                        $para  = $correo2;
//                    }
                    elseif(trim($correo) == NULL OR trim($correo) == ""){
                        $arr['resu'] = 5;
                        $arr['msj'] = "El correo vinculado al usuario no es válido!";                                               
                        //print 'El correo vinculado al usuario no es válido';
                    }
                    else{
                        $para  = trim($correo);
                        //$para  = trim($correo1). ', '.trim($correo2); // atención a la coma (si es para mas de 1 destinartario)
                    }
                    // $para  = $correo1; // . ', '; // atención a la coma
                    // $para .= 'wez@example.com';
                    // título
                    $título = utf8_decode('SIGECSE - Recuperación de datos de acceso');
                    // mensaje
                    $mensaje = '
                        <p>&nbsp; &nbsp; &nbsp;Estimado '.$nombres.' '.$apellidos.', los datos para acceder a su cuenta en el <span style="color: #003366;"><strong>Sistema de Gesti&oacute;n de Plan Operativo Anual (SIGEPOA)</strong></span> son:</p>
                        <ul>
                            <li><strong>CORREO:</strong>&nbsp;'.$correo.'</li>
                            <li><strong>CONTRASEÑA:</strong>&nbsp;'.$clave.'</li>
                        </ul>
                        <p>&nbsp; &nbsp; &nbsp;La clave es nueva y ha sido generada autom&aacute;ticamente. Se recomienda que la cambie cuando acceda al Sistema siguiendo los siguientes pasos:</p>
                        <p>&nbsp; &nbsp; &nbsp;1. Hacer clic a su nombre de usuario ubicado en la parte derecha del men&uacute; superior del Sistema.</p>
                        <p><img src="http://sigepoa.co.ve/sigepoa/public/img/soporte_men_sup.jpg" alt="Men&uacute; Superior" width="728" height="71" /></p>
                        <p>&nbsp; &nbsp; &nbsp;2. En la ventana emergente que se abrir&aacute;, debe hacer clic en el bot&oacute;n "Perfil".</p>
                        <p><img src="http://sigepoa.co.ve/sigepoa/public/img/soporte_clic_perfil.jpg" alt="Ventana emergente - Perfil Usuario" width="209" height="206" /></p>
                        <p>&nbsp; &nbsp; &nbsp;3. En el formulario que se desplegar&aacute; de clic en siguiente hasta llegar a los campos de "Datos de Usuario" y coloque su nueva clave.</p>
                        <p><img src="http://sigepoa.co.ve/sigepoa/public/img/soporte_cam_cla.jpg" alt="Editar Campo de Clave" width="406" height="209" /></p>
                        <p>&nbsp; &nbsp; &nbsp;4. Haga clic en bot&oacute;n guardar y los cambios realizados se guardar&aacute;n.</p>
                        <p>&nbsp; &nbsp; &nbsp;Cualquier duda no dude en contactar al equipo de soporte del SIGECSE al correo <a href="mailto:soporte-sigecse@sigecse.co.ve">soporte-sigecse@sigecse.co.ve</a></p>
                        <p>Saludos.</p>
                        <hr />
                        <p style="text-align: center;"><span style="color: #003366;"><strong>Soporte del Sistema de Gesti&oacute;n de Plan Operativo Anual <a style="color: #003366;" title="Sistema de Gesti&oacute;n de Plan Operativo Anual" href="sigecse.co.ve" target="_blank" rel="noopener">(SIGECSE)</a></strong></span></p>
                        <p><span style="color: #003366;"><strong><img style="display: block; margin-left: auto; margin-right: auto;" src="http://sigepoa.co.ve/sigepoa/public/img/consultores4.png" alt="Logo Econodatos" width="250" height="52" /></strong></span></p>
                    ';
                    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Cabeceras adicionales
                    // $cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
                    $cabeceras .= 'From: SIGECSE <soporte-sigecseapp@gmail.com>' . "\r\n";
                    $cabeceras .= 'Cc: oarodriguez@ife.gob.ve' . "\r\n";
                    $cabeceras .= 'Bcc: omar_andres_11@hotmail.com' . "\r\n";
                    // Enviarlo
                    $env = mail($para, $título, $mensaje, $cabeceras); //EN LOCAL NO FUNCIONA
                    if($env){
                        $arr['resu'] = 0;
                        $arr['msj'] = "Sus Datos Fueron Enviados Correctamente!";                         
                    }else{
                        $arr['resu'] = 6;
                        $arr['msj'] = "Su Correo No Pudo ser Enviado!";                        
                    }
                    
//                    print '0';
//                    die;
                    // print 'CLAVE MODIFICADA: '.$clave.' ENCRIPTADA: '.$clave_enc;
                }
                else{
                    $arr['resu'] = 4;
                    $arr['msj'] = "Ocurrió un error al recuperar los datos!";                    
//                    print 'Ocurrió un error al recuperar los datos';
//                    die;
                }
            } catch (Exception $e) {
                $arr['resu'] = 3;
                $arr['msj'] = "No se ha podido recuperar los datos de acceso!";                
//                print 'No se ha podido recuperar los datos de acceso'; //$e->getMessage();
//                die;
            }
        }
        else{
            $arr['resu'] = 2;
            $arr['msj'] = "No existe un usuario con ese correo!";            
//            print 'No existe un usuario con esos datos';
//            die;
        }
        print json_encode($arr);
    }
    
   public function enviar(){
       
        $mail = $this->input->post('corr') != NULL ? $this->input->post('corr') : NULL;
        //print $mail;die();        
        // Declarar variables
        $apellidos = "";
        $nombres = "";
        $correo = "";
        $clave = "";
        $clave_enc = "";
        $dat_usu = "";
        // Verificar que hay datos para consultar
        if(trim($mail) != "" || trim($mail) != NULL){
            // Consultar por correo
            $dat_usu = $this->usuario_model->cli_get_x_mai($mail);
            //print_r($dat_usu);die();
        }
        else{            
            $arr['resu'] = 1;
            $arr['msj'] = "Debe ingresar el correo para recuperar la clave!";            
            //print 'Debe ingresar el nombre de usuario o el correo para recuperar la clave.';
        }       
      /*
       * Cuando cargamos una librería
       * es similar a hacer en PHP puro esto:
       * require_once("libreria.php");
       * $lib=new Libreria();
       */
        
       //Cargamos la librería email
       $this->load->library('email');
        
       /*
        * Configuramos los parámetros para enviar el email,
        * las siguientes configuraciones es recomendable
        * hacerlas en el fichero email.php dentro del directorio config,
        * en este caso para hacer un ejemplo rápido lo hacemos 
        * en el propio controlador
        */
       
   /*private $_config = array(
      'protocol'     =>    'smtp',
      'smtp_host'    =>    'ssl://smtp.gmail.com',
      'smtp_port'    =>    '465',
      'smtp_timeout' =>    '7',
      'smtp_user'    =>    'arael82@gmail.com',
      'smtp_pass'    =>    '',
      'charset'      =>    'utf-8',
      'newline'      =>    '\r\n',
      'mailtype'     =>    'html',
      'validation'   =>    TRUE
   );*/       
        
       //Indicamos el protocolo a utilizar
        $config['protocol'] = 'smtp';
         
       //El servidor de correo que utilizaremos
        //$config["smtp_host"] = 'smtp.gmail.com';
        $config["smtp_host"] = 'smtp-relay.sendinblue.com';
        //$config["smtp_host"] = 'tls://smtp.gmail.com';
        //$config["smtp_host"] = 'ssl://smtp.gmail.com';
         
       //Nuestro usuario
        $config["smtp_user"] = 'omargumer22@gmail.com';
         
       //Nuestra contraseña
        $config["smtp_pass"] = 'mQ7cqhTXsNFwPbRt';    
         
       //El puerto que utilizará el servidor smtp
        $config["smtp_port"] = '587';
        //$config["smtp_port"] = '465';
        
       //El juego de caracteres a utilizar
        $config['charset'] = 'utf-8';
        
        //Tipo de Email a Enviar.
        $config['mailtype'] = 'html';        
        
        //Nueva Linea.
        $config['newline'] = '\r\n';        
 
       //Permitimos que se puedan cortar palabras
        $config['wordwrap'] = TRUE;
         
       //El email debe ser valido  
       $config['validate'] = true;
       //$config['validation'] = TRUE;
       
        
      //Establecemos esta configuración
        $this->email->initialize($config);
        
        // Cargar los datos del Usuario en las variables
        if(count($dat_usu) >= 1)
        {
            $id_usu = trim(@$dat_usu[0]->id_cli);            
            $apellidos = mb_strtoupper(htmlspecialchars(trim(@$dat_usu[0]->ape_cli)),'utf-8');
            $nombres = mb_strtoupper(htmlspecialchars(trim(@$dat_usu[0]->nom_cli)),'utf-8');            
            $correo = mb_strtolower(htmlspecialchars(trim(@$mail)),'utf-8');
            // Setear la clave
            $id_clave = (new DateTime(date('Y/m/d').' '.date("H:i:s"), new DateTimeZone('America/Caracas')))->getTimestamp();
            $clave = "*.".trim($id_clave)."-";
            $clave_enc = sha1($clave);
            //print $clave_enc;die();
            try {
                $resu = $this->usuario_model->set_pwd_us($id_usu, $clave_enc);                                
                if($resu == 0){
                    // Enviar el correo
                    // Uno o Varios destinatarios
                    $para = "";
                    if(trim($correo) != NULL || trim($correo) != ""){
                        $para  = $correo;                        
                    }
//                    elseif((trim($correo2)!= NULL || trim($correo2)!= "") && (trim($correo1)== NULL || trim($correo1)=="")){
//                        $para  = $correo2;
//                    }
                    elseif(trim($correo) == NULL OR trim($correo) == ""){
                        $arr['resu'] = 5;
                        $arr['msj'] = "El correo vinculado al usuario no es válido!";                                               
                        //print 'El correo vinculado al usuario no es válido';
                    }
                    else{
                        $para  = trim($correo);
                        //$para  = trim($correo1). ', '.trim($correo2); // atención a la coma (si es para mas de 1 destinartario)
                    }
 
                        //Ponemos la dirección de correo que enviará el email y un nombre
                          $this->email->from('soporte-sigecse@gmail.com', 'Soporte-Sigecse');

                        /*
                         * Ponemos el o los destinatarios para los que va el email
                         * en este caso al ser un formulario de contacto te lo enviarás a ti
                         * mismo
                         */
                          $this->email->to($para, "$nombres - $apellidos");                          
                          
                        $título = utf8_decode('SIGECSE - Recuperación de datos de acceso');
                        //Definimos el asunto del mensaje
                          $this->email->subject($this->input->post($título));
                    // mensaje
                    $mensaje = '
                        <p>&nbsp; &nbsp; &nbsp;Estimado '.$nombres.' '.$apellidos.', los datos para acceder a su cuenta en el <span style="color: #003366;"><strong>Sistema de Gesti&oacute;n de la Comunidad de Santa Eduviges (SIGECSE)</strong></span> son:</p>
                        <ul>
                            <li><strong>CORREO:</strong>&nbsp;'.$correo.'</li>
                            <li><strong>CONTRASEÑA:</strong>&nbsp;'.$clave.'</li>
                        </ul>
                        <p>&nbsp; &nbsp; &nbsp;La clave es nueva y ha sido generada autom&aacute;ticamente. Se recomienda que la cambie cuando acceda al Sistema siguiendo los siguientes pasos:</p>
                        <p>&nbsp; &nbsp; &nbsp;1. Hacer clic a su nombre de usuario ubicado en la parte derecha del men&uacute; superior del Sistema.</p>
                        <p><img src="http://sigepoa.co.ve/sigepoa/public/img/soporte_men_sup.jpg" alt="Men&uacute; Superior" width="728" height="71" /></p>
                        <p>&nbsp; &nbsp; &nbsp;2. En la ventana emergente que se abrir&aacute;, debe hacer clic en el bot&oacute;n "Perfil".</p>
                        <p><img src="http://sigepoa.co.ve/sigepoa/public/img/soporte_clic_perfil.jpg" alt="Ventana emergente - Perfil Usuario" width="209" height="206" /></p>
                        <p>&nbsp; &nbsp; &nbsp;3. En el formulario que se desplegar&aacute; de clic en siguiente hasta llegar a los campos de "Datos de Usuario" y coloque su nueva clave.</p>
                        <p><img src="http://sigepoa.co.ve/sigepoa/public/img/soporte_cam_cla.jpg" alt="Editar Campo de Clave" width="406" height="209" /></p>
                        <p>&nbsp; &nbsp; &nbsp;4. Haga clic en bot&oacute;n guardar y los cambios realizados se guardar&aacute;n.</p>
                        <p>&nbsp; &nbsp; &nbsp;Cualquier duda no dude en contactar al equipo de soporte del SIGECSE al correo <a href="mailto:soporte-sigecseapp@gmail.com">soporte-sigecseapp@gmail.com</a></p>
                        <p>Saludos.</p>
                        <hr />
                        <p style="text-align: center;"><span style="color: #003366;"><strong>Soporte del Sistema de Gesti&oacute;n de Plan Operativo Anual <a style="color: #003366;" title="Sistema de Gesti&oacute;n de Plan Operativo Anual" href="sigecse.co.ve" target="_blank" rel="noopener">(SIGECSE)</a></strong></span></p>
                        <p><span style="color: #003366;"><strong><img style="display: block; margin-left: auto; margin-right: auto;" src="http://sigepoa.co.ve/sigepoa/public/img/consultores4.png" alt="Logo Econodatos" width="250" height="52" /></strong></span></p>
                    ';
                        //Definimos el mensaje a enviar
                          $this->email->message(
                                  "Email: ".$correo.
                                  " Mensaje: ".$mensaje
                                  );
                        //Enviamos el email y si se produce bien o mal que avise con una flasdata
                        if($this->email->send()){
                            //$this->session->set_flashdata('envio', 'Email enviado correctamente');
                            $arr['resu'] = 0;
                            $arr['msj'] = "Sus Datos Fueron Enviados Correctamente!";                                                
                        }else{
                            //$this->session->set_flashdata('envio', 'No se a enviado el email');
                            $arr['resu'] = 6;
                            //$arr['msj'] = show_error($this->email->print_debugger());
                            $arr['msj'] = "Su Correo no Pudo Enviarse Correctamente!";
                            show_error($this->email->print_debugger());
                        }                          

//                    print '0';
//                    die;
                    // print 'CLAVE MODIFICADA: '.$clave.' ENCRIPTADA: '.$clave_enc;
                }
                else{
                    $arr['resu'] = 4;
                    $arr['msj'] = "Ocurrió un error al recuperar los datos!";                    
//                    print 'Ocurrió un error al recuperar los datos';
//                    die;
                }
            } catch (Exception $e) {
                $arr['resu'] = 3;
                $arr['msj'] = "No se ha podido recuperar los datos de acceso!";                
//                print 'No se ha podido recuperar los datos de acceso'; //$e->getMessage();
//                die;
            }
        }
        else{
            $arr['resu'] = 2;
            $arr['msj'] = "No existe un usuario con ese correo!";            
//            print 'No existe un usuario con esos datos';
//            die;
        }
        print json_encode($arr);        

   }
   
    public function EnvioEmails() {
        //$this->cargaLibraryMail();        
        //$correo = $this->input->post('corr');
        $mailin = new Mailin('omargumer22@gmail.com', 'mQ7cqhTXsNFwPbRt');
        
        //print_r($mailin);die();
        $mailin->
        addTo('omargumer22@gmail.com', 'Omar Rodriguez')-> 

        //addCc('oarodriguez@ife.gob.ve','oarodriguez cc')-> 

        //addBcc('omar_andres_11@hotmail.com','Omar Andres Rodriguez bcc')->
                
        setFrom('soporte-sigecse@gmail.com', 'Soporte-Sigecse')->
        //setReplyTo('reply@example.com','reply name')->
        setSubject(utf8_decode('SIGECSE - Recuperación de datos de acceso'))->
        setText('Texto de Prueba!')->
                
        setHtml('<strong>Correo de Prueba!</strong>');
                
        $res = $mailin->send();
        if ($res == NULL){print "vacio";}else{print json_encode($res);}
        //print_r($mailin->send());
                       
    }   
    
}
