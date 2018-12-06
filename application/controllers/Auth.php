<?php

//Controlador de inicio de session del usuario (logueo del usuario)
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('table');
        $this->load->model('usuario_model');
    }

    public function index() {

            $data['titulo'] = 'Inicio de Sesiòn';
            $data['titulo2'] = 'Sistema de Gestion de Condominios S.E';
            $this->load->view('auth', $data);
    }

    public function login() {
        sleep(5);
        $corr = $this->input->post('correo');
        $pwd = $this->input->post('pwd');
        if ($corr != NULL || $pwd != NULL){
        	//print "inicio";die();
            //print "correo: $corr && pwd: $pwd";die();
        }
            $user = $this->usuario_model->user_get_id($corr, $pwd);
        $user2 = 0;       
        if(count($user) >= 1)
        {
            $user2 = $user->fn_user_get_id;
        }       
        if ($usua2 != 0) {            
            $this->session->set_userdata('sess_id', $usua2);            
            $usudat = $this->usuario_model->usua_get_tod_log($usua2);           
            $this->session->set_userdata('sess_na', $usudat->nom_usu . " " . $usudat->ape_usu); // Nombres y Apellidos
            $this->session->set_userdata('sess_log', $usudat->log_usu); // Login
            $this->session->set_userdata('sess_tu', $usudat->des_tip_usu); // Tipo de Usuario
            $this->session->set_userdata('sess_fot', $usudat->fot_per); // Foto de usuario 
            print 'inicio';
        } else {
            print NULL;
        }        
            
    }

}
