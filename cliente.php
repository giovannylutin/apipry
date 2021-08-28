<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

include 'conexion/crud.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $idsolicita=$_GET['id'];
       echo listar_registro_specifico($idsolicita);
    }
    else{
    echo listar_registros();
    }
}if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $q_tipoqueja=$_POST['opcion'];//tipo de la queja
    $q_departamento=$_POST['departamento'];//departamento de la empresa
    $q_municipio=$_POST['municipio'];//municipiode la empresa a la cual se denuncia
    $q_estado=$_POST['estado'];// de la queja recibida,enproceso,finalizada
    //$q_tipo=$_POST['tipo'];
    //$q_consulta=$_POST['consulta'];//tokenpara consultar queja del lado del cliente
    $q_nombre=$_POST['nombre'];//nombre persona si la queja es no anonima
    $q_cui=$_POST['cui'];//dPI DEL DENUNCIANTE
    $q_telefono=$_POST['telefono'];//telefono de la persona que envio la queja
    $q_celular=$_POST['celular'];//celular de la persona que denuncia
    $q_correo=$_POST['correo'];//correo de la persona que denuncia
    $q_direccion=$_POST['direccion'];//direccion de la empresa

    $q_empresa=$_POST['empresa'];//nombre de la empresa
    $q_nit=$_POST['nit'];//nit de la empresa que esta en la factura
    $q_direccionemp=$_POST['direccionemp'];//direccion de la empresa o sucursal donde sucedio
    $q_zona=$_POST['zona'];
    $q_telefonoemp=$_POST['telefonoemp'];//telefono de la empresa si loo tubiera
    $q_correoemp=$_POST['correoemp'];//correo de la empresa si lo tubiera
   //$pnombre = $_POST['nombre'];
    if (isset($_POST['opcion'])){
        echo alta_queja($q_tipoqueja,$q_departamento,$q_municipio,$q_estado,
        $q_nombre,$q_cui,$q_telefono,$q_celular,$q_correo,$q_direccion,$q_empresa,$q_nit,$q_direccionemp,$q_zona,$q_telefonoemp,$q_correoemp);
       
    }else{
        header("HTTP/1.1 400 opcion incorrecta");
    }
}

?>