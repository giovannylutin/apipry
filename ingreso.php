<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
include 'conexion/crud.php';
if($method== 'GET'){
   
    $usuario=$_GET['user'];
    $pass=$_GET['pass'];

    if ($usuario !="" && $pass !="") {
        echo ingreso_reportes($usuario,$pass);
    }else{
        header("HTTP/1.1 400 oops");
    }

}



// $str = '@Gio2019';
// echo sha1($str);
 
// if (sha1($str) === '3afb82af5b2ceb032597e911eac407c6969ca7fe') {
//     echo "El texto coincide con el hash.";
// }
?>