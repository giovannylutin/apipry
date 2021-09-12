<?php

include 'conexion.php';
	
// $pdo = new Conexion();
function ingreso_reportes($puser,$ppass){
 $pencriptado= encriptacion($ppass);

	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT ROL,ESTADO,TOK FROM tb_diaco_usuarios WHERE USUARIO=:usuario AND PASS=:pass");
	$sql->bindValue(':usuario',$puser,PDO::PARAM_STR);
	$sql->bindValue(':pass',$pencriptado,PDO::PARAM_STR);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$count=$sql->rowCount();
	if ($count) {
		header("HTTP/1.1 200 hay datos");
		return json_encode($sql->fetchAll());
		exit;	
	}else{
		// header("HTTP/1.1 400 fail");
		return json_encode($sql->fetchAll());
		exit;
	}
}
function encriptacion($valorenc){
	return sha1($valorenc);
}
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
    $sql = $pdo->prepare("SELECT tb_departamento.DEPARTAMENTO,tb_municipio.MUNICIPIO,EMPRESA,ESTADO,TIPO,QUEJA_CONSULTA,tb_quejas.FECHA_ALTA,tb_quejas_proveedor.NIT,DIRECCION,ZONA,TELEFONO,CORREO,NOFACTURA,QUEJA FROM tb_quejas JOIN tb_municipio ON tb_quejas.ID_MUN=tb_municipio.ID_MUN JOIN tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP join tb_quejas_detalle on tb_quejas_detalle.ID_QUEJA=tb_quejas.ID_QUEJA join tb_quejas_proveedor on tb_quejas.id_queja = tb_quejas_proveedor.id_queja JOIN tb_quejas_empresas ON tb_quejas_empresas.NIT=tb_quejas_proveedor.NIT WHERE QUEJA_CONSULTA=:id");
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
function filtrar_empresa($varempsolicita,$fechainibuscar,$fsolf){
if ($fechainibuscar == "" && $fsolf=="") {
	$fechainibuscar="2021-01-01";
	$fsolf="2021-12-31";
}elseif($fechainibuscar != "" && $fsolf == ""){
	// $fechainibuscar="2021-01-01";
	$fsolf="2021-12-31";
}elseif($fechainibuscar == "" && $fsolf != ""){
	$fechainibuscar="2021-01-01";
}
	// SELECT REGION,DEPARTAMENTO,EMPRESA,DIRECCION FROM `tb_region` JOIN `tb_departamento`on `tb_region`.`ID_REGION`=`tb_departamento`.`ID_REGION`join `tb_quejas`on `tb_departamento`.`ID_DEP`=`tb_quejas`.`ID_DEP` JOIN `tb_quejas_proveedor`on `tb_quejas`.`ID_QUEJA`=`tb_quejas_proveedor`.`ID_QUEJA`JOIN `tb_quejas_empresas`on `tb_quejas_proveedor`.`NIT`= `tb_quejas_empresas`.`NIT` WHERE (`tb_quejas`.`FECHA_ALTA`) BETWEEN '2021-09-01' AND '2021-09-20'
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT tb_region.ID_REGION,REGION,tb_departamento.ID_DEP,DEPARTAMENTO,tb_municipio.ID_MUN,MUNICIPIO,EMPRESA,tb_quejas.FECHA_ALTA FROM tb_region JOIN tb_departamento ON tb_departamento.ID_REGION=tb_region.ID_REGION JOIN tb_municipio ON tb_municipio.ID_DEP=tb_departamento.ID_DEP JOIN tb_quejas ON tb_quejas.ID_MUN=tb_municipio.ID_MUN JOIN tb_quejas_proveedor ON tb_quejas_proveedor.ID_QUEJA=tb_quejas.ID_QUEJA JOIN tb_quejas_empresas on tb_quejas_empresas.NIT=tb_quejas_proveedor.NIT WHERE tb_quejas_proveedor.NIT=:id AND (tb_quejas.FECHA_ALTA) BETWEEN :fechabuscarinicio AND :fechabuscarinfin");
	 $sql->bindValue(':id',$varempsolicita);
	 $sql->bindValue(':fechabuscarinicio',$fechainibuscar);
	 $sql->bindValue(':fechabuscarinfin',$fsolf);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;	
}
function reporteregionestotales(){
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