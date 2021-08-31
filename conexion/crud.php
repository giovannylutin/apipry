<?php

include 'conexion.php';
	
// $pdo = new Conexion();

function listar_registros(){
    $pdo = new Conexion();
    $sql = $pdo->prepare("SELECT * FROM tb_quejas");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;		
}
function listar_departamentos(){
    $pdo = new Conexion();
    $sql = $pdo->prepare("SELECT * FROM tb_departamento");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;		
}
function listar_municipio($vardep){
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT * FROM tb_municipio WHERE ID_MUN=:id");
	$sql->bindValue(':id',$vardep);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;	
}
function listar_registro_specifico($var){
    $pdo = new Conexion();
    $sql = $pdo->prepare("SELECT * FROM tb_quejas WHERE QUEJA_CONSULTA=:id");
	$sql->bindValue(':id',$var);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;	
}
function crear_token($biene){
	$tipoop='A';
	if($biene==2){
		$tipoop='B';
	}
	setlocale(LC_ALL,"es_ES");
	$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	return $tipoop.substr(str_shuffle($caracteres),0,5).date("m").date("y");
}
function alta_queja($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15,$var16){
	$pdo = new Conexion();
	$tipoqueja='Queja no anonima';
	$tkn_consulta=crear_token($var1);
	$stringhed = 'HTTP/1.1 200 '.$tkn_consulta;

	if($var1==1){
		$tipoqueja='Queja anonima';
	}
	$cadenasql = "CALL Proc_Alta_Quejas(:Departamento,:Municipio,:Estado,:Tipo,:Tkconsulta,:Nombre,:Cui,:telefono,:celular,:correo,:direccion,:empresa,:nit,:diremp,:Zemp,:telemp,:correoemp,@result)";
	$stmt = $pdo->prepare($cadenasql);
	$stmt->bindParam(':Departamento',$var2, PDO::PARAM_INT);
	$stmt->bindParam(':Municipio',$var3, PDO::PARAM_INT);
	$stmt->bindParam(':Estado',$var4, PDO::PARAM_STR,20);
	$stmt->bindParam(':Tipo',$tipoqueja, PDO::PARAM_STR,20);
	$stmt->bindParam(':Tkconsulta',$tkn_consulta, PDO::PARAM_STR,10);
	$stmt->bindParam(':Nombre',$var5, PDO::PARAM_STR,10);
	$stmt->bindParam(':Cui',$var6, PDO::PARAM_INT);
	$stmt->bindParam(':telefono',$var7, PDO::PARAM_STR,9);
	$stmt->bindParam(':celular',$var8, PDO::PARAM_STR,9);
	$stmt->bindParam(':correo',$var9, PDO::PARAM_STR,50);
	$stmt->bindParam(':direccion',$var10, PDO::PARAM_STR,50);
	$stmt->bindParam(':empresa',$var11, PDO::PARAM_STR,50);
	$stmt->bindParam(':nit',$var12, PDO::PARAM_INT);
	$stmt->bindParam(':diremp',$var13, PDO::PARAM_STR,50);
	$stmt->bindParam(':Zemp',$var14, PDO::PARAM_INT);
	$stmt->bindParam(':telemp',$var15, PDO::PARAM_STR,9);
	$stmt->bindParam(':correoemp',$var16, PDO::PARAM_STR,50);
	$stmt->execute();
	$stmt->closeCursor();
	$row = $pdo->query("SELECT @result AS resultadoobtenido")->fetch(PDO::FETCH_ASSOC);

	if($row){
		header($stringhed);
		return $row !== false ? $row['resultadoobtenido'] : null;
		exit;
	}else{
		header("HTTP/1.1 400 Bad Request");
		return "hubo un pequeño problema";
		exit;
	}
	
}

	
?>