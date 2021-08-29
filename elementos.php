<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
include 'conexion/crud.php';

if($method== 'GET'){
    if(isset($_GET['id'])){
        $idsolicita=$_GET['id'];
       echo listar_registro_specifico($idsolicita);
    }
    else{
        echo listar_departamentos();
    }
}
?>