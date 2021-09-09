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
    $sql = $pdo->prepare("SELECT ID_MUN,MUNICIPIO FROM tb_municipio WHERE ID_DEP=:id");
	$sql->bindValue(':id',$vardep);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;	
}
function listar_registro_specifico($var){
    $pdo = new Conexion();
    $sql = $pdo->prepare("SELECT ESTADO,TIPO,QUEJA_CONSULTA,tb_quejas.FECHA_ALTA,NIT,DIRECCION,ZONA,TELEFONO,CORREO 
	FROM tb_quejas join tb_quejas_proveedor on tb_quejas.id_queja = tb_quejas_proveedor.id_queja WHERE QUEJA_CONSULTA=:id");
	$sql->bindValue(':id',$var);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;	
}
function listar_region(){
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT ID_REGION,REGION FROM tb_region");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;
}
function listar_empresa_nombre(){
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT NIT,EMPRESA FROM tb_quejas_empresas");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;
}
function listar_departamento_especifico($vardep){
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT ID_DEP,DEPARTAMENTO FROM tb_departamento WHERE ID_REGION=:id");
	$sql->bindValue(':id',$vardep);
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
function alta_queja($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,
$var11,$var12,$var13,$var14,$var15,$var16,$var17,$var18,$var19){
	$pdo = new Conexion();
	$valorhjj="2021-08-09";
	$tipoqueja='Queja no anonima';
	$tkn_consulta=crear_token($var1);
	$stringhed = 'HTTP/1.1 200 '.$tkn_consulta;

	if($var1==1){
		$tipoqueja='Queja anonima';
	}
	$cadenasql = "CALL Proc_Alta_Quejas(:Departamento,:Municipio,:Estado,:Tipo,
	:Tkconsulta,:Nombre,:Cui,:telefono,:celular,:correo,:direccion,
	:nit,:diremp,:Zemp,:telemp,:correoemp,:facturaemp,:fechaemitidaemp,:quejamp,:requiereemp,@result)";
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
	// $stmt->bindParam(':empresa',$var11, PDO::PARAM_STR,50);
	$stmt->bindParam(':nit',$var11, PDO::PARAM_INT);
	$stmt->bindParam(':diremp',$var12, PDO::PARAM_STR,50);
	$stmt->bindParam(':Zemp',$var13, PDO::PARAM_INT);
	$stmt->bindParam(':telemp',$var14, PDO::PARAM_STR,9);
	$stmt->bindParam(':correoemp',$var15, PDO::PARAM_STR,50);
	$stmt->bindParam(':facturaemp',$var16, PDO::PARAM_INT);
	$stmt->bindParam(':fechaemitidaemp',$var17, PDO::PARAM_STR);
	$stmt->bindParam(':quejamp',$var18, PDO::PARAM_STR);
	$stmt->bindParam(':requiereemp',$var19, PDO::PARAM_STR);
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