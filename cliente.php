<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
 $method = $_SERVER['REQUEST_METHOD'];
// if($method == "OPTIONS") {
//     die();
// }


include 'conexion/crud.php';

if($method== 'GET'){
    if(isset($_GET['id'])){
        $idsolicita=$_GET['id'];
       echo listar_registro_specifico($idsolicita);
    }
    else{
    echo listar_registros();
    }
}if($method == 'POST'){
    $credentials = json_decode( file_get_contents( 'php://input' ) );
    $q_tipoqueja = $credentials->opcion2;
    $q_departamento = $credentials->departamento;
    $q_municipio = $credentials->municipio;
    $q_estado = $credentials->estado;
    $q_nombre = $credentials->nombre;
    $q_cui = $credentials->cui;
    $q_telefono= $credentials->telefono;
    $q_celular = $credentials->celular;
    $q_correo = $credentials->correo;
    $q_direccion = $credentials->direccion;
    $q_empresa = $credentials->empresa;
    $q_nit = $credentials->nit;
    $q_direccionemp = $credentials->direccionemp;
    $q_zona = $credentials->zona;
    $q_telefonoemp = $credentials->telefonoemp;
    $q_correoemp = $credentials->coreoemp;
     
    if (isset($q_tipoqueja)){
        // header("HTTP/1.1 200 me llego la opcion");
           alta_queja($q_tipoqueja,$q_departamento,$q_municipio,$q_estado,
    $q_nombre,$q_cui,$q_telefono,$q_celular,$q_correo,$q_direccion,$q_empresa,$q_nit,$q_direccionemp,$q_zona,$q_telefonoemp,$q_correoemp);

        }else{
            header("HTTP/1.1 400 opcion incorrecta");
        }

    // $q_tipoqueja=$_POST['opcion'];//tipo de la queja
    // $q_departamento=$_POST['departamento'];//departamento de la empresa
    // $q_municipio=$_POST['municipio'];//municipiode la empresa a la cual se denuncia
    // $q_estado=$_POST['estado'];// de la queja recibida,enproceso,finalizada
    
    // $q_nombre=$_POST['nombre'];//nombre persona si la queja es no anonima
    // $q_cui=$_POST['cui'];//dPI DEL DENUNCIANTE
    // $q_telefono=$_POST['telefono'];//telefono de la persona que envio la queja
    // $q_celular=$_POST['celular'];//celular de la persona que denuncia
    // $q_correo=$_POST['correo'];//correo de la persona que denuncia
    // $q_direccion=$_POST['direccion'];//direccion de la empresa

    // $q_empresa=$_POST['empresa'];//nombre de la empresa
    // $q_nit=$_POST['nit'];//nit de la empresa que esta en la factura
    // $q_direccionemp=$_POST['direccionemp'];//direccion de la empresa o sucursal donde sucedio
    // $q_zona=$_POST['zona'];
    // $q_telefonoemp=$_POST['telefonoemp'];//telefono de la empresa si loo tubiera
    // $q_correoemp=$_POST['correoemp'];//correo de la empresa si lo tubiera
  
//    alta_queja($q_tipoqueja,$q_departamento,$q_municipio,$q_estado,
//    $q_nombre,$q_cui,$q_telefono,$q_celular,$q_correo,$q_direccion,$q_empresa,$q_nit,$q_direccionemp,$q_zona,$q_telefonoemp,$q_correoemp);
  
    // if (isset($_POST['opcion'])){
       
    // }else{
    //     header("HTTP/1.1 400 opcion incorrecta");
    // }
}

?>