<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Seguridad.class.php');

 class Usuario extends Seguridad
 {
    var $conexion;
	
    public function Usuario()
    {
        //realizando la conexion
        include("conexion.inc");
        $this->conexion = conectar();
    }
    
    public function Autenticar($cuenta, $clave)
    {
		//Seguridad: Filtrado de datos papra evitar ataques del tipo inyección sql, xss, etc.
        //$cuenta = $this->sanatizar($cuenta);
        //$clave = $this->sanatizar($clave);
        
        $sql = "select * from usuario where Cuenta = '$cuenta' and Clave = '$clave'";
		
		//Seguridad: Acceso a la apliación con contraseña encriptada
        //$sql = "select * from usuario where Cuenta = '$cuenta' and Clave = sha1('$clave')";
		
        $result = $this->MyQuery($sql);
        if(mysql_num_rows($result) > 0)
        {
            while($f = mysql_fetch_array($result))
            {
                $idUsuario = $f['Id'];
            }
			mysql_free_result($result);
            return $idUsuario;
        }
        else
        {
            return false;
        }
    }
    
    public function VerPerfil($id)
    {
		//Seguridad: Filtrado de datos papra evitar ataques del tipo inyección sql, xss, etc. 
        //$bool = ( !is_int($id) ? (ctype_digit($id)) : true );
		//if(!$bool) 
            //$id = 0;
		
        $sql = "select * from usuario where Id = $id";
        return $this->MyQuery($sql);
    }
    
    public function Listar()
    {
        $sql = "select * from usuario where Cuenta <> 'admin'";
        return  $this->MyQuery($sql);
    }
    
    public function Insertar($cuenta, $clave, $nombre, $apellido)
    {
		//Seguridad: Filtrado de datos papra evitar ataques del tipo inyección sql, xss, etc.
        //$cuenta = $this->sanatizar($cuenta);
        //$nombre = $this->sanatizar($nombre);
		//$apellido = $this->sanatizar($apellido);
        		
        $fecha = date("Y-m-d");
		
        $sql = "Insert into usuario values (null, '$cuenta', '$clave', '$nombre', '$apellido','$fecha')";
		
		//Registro de usuarios con contraseña encriptada
		//$sql = "Insert into usuario values (null, '$cuenta', SHA1('$clave'), '$nombre', '$apellido','$fecha')";
        return $this->MyQuery($sql);
    }
 }
 
// $obj = new Logica();
// $datos = $obj->Autenticar("' or '1'='1' -- ", 'admin1230000');
// echo $datos;

