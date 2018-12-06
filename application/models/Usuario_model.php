<?php 
/*
Archivo: Usuario_model.
*/

class Usuario_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model');
	}

	//Obtener ID de usuario
	public function user_get_id($corr, $pwd){
		$query = $this->db->query("SELECT * FROM fn_user_get_id('$corr','$pwd');");
		$result = $query->result();
	    if(count($result) >= 1)
	    {
	        return $result[0];
	    }else{
	        return $result;
	    }
	}
        // Inserta los Clientes Asociados.
        public function user_cli_ins($id, $cod, $ced, $nom, $ape, $fcn, $tlf, $ncasa, $calle, $coha, $corr, $pwd, $fot) {
            if($fot == NULL){                
                //$query = $this->db->query("SELECT `fn_us_cli_ins`(3, 19608285, 'omar', 'rodriguez', 1988-08-10, '(0412) 1982526', '83', '5', 'propietario', 'omargumer22@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 0) AS `fn_us_cli_ins`;");
                $query = $this->db->query("SELECT `fn_us_cli_ins`('$id','$cod', '$ced', '$nom', '$ape', '$fcn', '$tlf', '$ncasa', '$calle', '$coha', '$corr', '$pwd', $fot) AS `fn_us_cli_ins`;");
                $result = $query->result();
                //print_r($result);die();
                $resultado = $result[0]->fn_us_cli_ins;
                //print_r($resultado);die();
            }else{
                $query = $this->db->query("SELECT * FROM fn_us_cli_ins('','','','','','','','','','','','');");
                $result = $query->result();
                $resultado = $result[0]->fn_us_cli_ins_sf;
            }
            switch ($resultado) {
                case 200:
                    return 200; // OK.
                    break;
                case 201:
                    return 201; // OK.
                    break;
                case 1:                    
                    throw new Exception("Esta Cedula Ya Se Encuentra Registrada!");
                    break;
                case 2:                    
                    throw new Exception("Este Correo Ya Se Encuentra Registrado!");
                    break;
                default:
                    throw new Exception("Error de conexión a la BD!");
                    break;                

            }
        }
        
    //OBTENER DATOS DEL CLIENTE A TRAVÉS DE SU CORREO.
    public function cli_get_x_mai($mail) {
        $query = $this->db->query("CALL `pd_cli_get_x_mai`('$mail');"); // AS `pd_cli_get_x_mai`
        $result = $query->result();
        $query->next_result();
        //print_r($result);die();
        return $result;
//        if (count($result) >= 1) {
//            return $result[0];
//        } else {
//            return $result;
//        }
    }
    
    // SETEAR LA CLAVE DE UN USUARIO. (adm ó cli).
    public function set_pwd_us($id, $pwd) {                
        $query = $this->db->query("SELECT `fn_set_pwd_us`('$id', '$pwd') AS `fn_set_pwd_us`;"); // AS `fn_set_pwd_us`
        //print_r($query);die();
        $result = $query->result();
        //$resultado = $result[0]->fn_set_pwd_us;
        //print_r($resultado);die();
        //return $resultado;
        return 0;
    }    

}

