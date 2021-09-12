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
        $irop=$_GET['verop'];
        $idsolicita=$_GET['id'];
        $fsol=$_GET['fechaini'];
        $fsolf=$_GET['fechafin'];
        if($irop==1){
            // $idsolicita=$_GET['id'];
            echo listar_departamento_especifico($idsolicita);
        }if($irop==2){
            echo listar_municipio($idsolicita);
        }if($irop==3){
             echo listar_empresa_nombre();
        }if ($irop==4){
            echo filtrar_empresa($idsolicita,$fsol,$fsolf);
        }
    }
    else{
        echo listar_region();    
    }
}