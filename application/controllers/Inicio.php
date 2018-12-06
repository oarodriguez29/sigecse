<?php

//Controlador de inicio de session del usuario (logueo del usuario)
class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('table');
        $this->load->library('form_validation');
    }

    public function index() {

//        $data = array('mensaje' => 'Bienvenido', 'titulo' => 'Logueo de Usuario');

            $data['titulo'] = 'Inicio de Sesiòn';
            $this->load->view('inicio', $data);
//            $this->load->view('includes/header');

//        $data['titulo'] = 'Logueo de Usuario';
//        $this->load->view('auth', $data);
    }

    }