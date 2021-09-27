<?php

include 'conexion.php';
function listar_quejasactualizar(){
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT tb_quejas.ID_QUEJA,tb_departamento.DEPARTAMENTO,tb_municipio.MUNICIPIO,EMPRESA,ESTADO,TIPO,QUEJA_CONSULTA,tb_quejas.FECHA_ALTA,tb_quejas_proveedor.NIT,DIRECCION,ZONA FROM tb_quejas JOIN tb_municipio ON tb_quejas.ID_MUN=tb_municipio.ID_MUN JOIN tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP join tb_quejas_detalle on tb_quejas_detalle.ID_QUEJA=tb_quejas.ID_QUEJA join tb_quejas_proveedor on tb_quejas.id_queja = tb_quejas_proveedor.id_queja JOIN tb_quejas_empresas ON tb_quejas_empresas.NIT=tb_quejas_proveedor.NIT");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;
}

function listarreporteporempresa($valn){
	header("HTTP/1.1 200 hay datos");
	$collectionresumen=array( 'empregion'=> array(listarresumeRegion1($valn)),'empdep'=> array(listarresumeDepartamento1($valn)),'empmun'=> array(listarresumeMunicipio1($valn)));
	return json_encode($collectionresumen);
	exit;
}
function listarresumeRegion1($nitemp){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT COUNT(*) total,REGION, DEPARTAMENTO FROM tb_region join tb_departamento on tb_departamento.ID_REGION=tb_region.ID_REGION JOIN tb_quejas on tb_quejas.ID_DEP = tb_departamento.ID_DEP JOIN tb_quejas_proveedor on tb_quejas_proveedor.ID_QUEJA=tb_quejas.ID_QUEJA WHERE tb_quejas_proveedor.NIT= :id GROUP BY tb_region.ID_REGION");
	$sql->bindValue(':id',$nitemp);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return $sql->fetchAll();
	exit;
}
function listarresumeDepartamento1($nitemp){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT COUNT(*) total,DEPARTAMENTO FROM tb_quejas join tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP JOIN tb_quejas_proveedor on tb_quejas_proveedor.ID_QUEJA=tb_quejas.ID_QUEJA WHERE tb_quejas_proveedor.NIT= :id GROUP BY tb_quejas.ID_DEP");
	$sql->bindValue(':id',$nitemp);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return $sql->fetchAll();
	exit;
}
function listarresumeMunicipio1($nitemp){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT COUNT(*) total,DEPARTAMENTO,MUNICIPIO FROM tb_departamento JOIN tb_municipio on tb_municipio.ID_DEP=tb_departamento.ID_DEP JOIN tb_quejas on tb_quejas.ID_MUN=tb_municipio.ID_MUN JOIN tb_quejas_proveedor on tb_quejas_proveedor.ID_QUEJA=tb_quejas.ID_QUEJA WHERE tb_quejas_proveedor.NIT= :id GROUP BY tb_quejas.ID_MUN");
	$sql->bindValue(':id',$nitemp);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return $sql->fetchAll();
	exit;
}

// $pdo = new Conexion();
function listartdias(){
	$pdo = new Conexion();
	$sql = $pdo->prepare("CALL proc_resumensemana()");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	// $row = $pdo->query("SELECT *FROM resumensemana;")->fetch(PDO::FETCH_ASSOC);
	return json_encode($sql->fetchAll());
	exit;
}
function listar_totaltipo(){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT count(*) TOTALQ,TIPO FROM tb_quejas GROUP BY TIPO");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return json_encode( $sql->fetchAll());
	exit;
}
function listar_actualiza($var){
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT tb_quejas.ID_QUEJA,tb_departamento.DEPARTAMENTO,tb_municipio.MUNICIPIO,EMPRESA,ESTADO,TIPO,QUEJA_CONSULTA,tb_quejas.FECHA_ALTA,tb_quejas_proveedor.NIT,DIRECCION,ZONA FROM tb_quejas JOIN tb_municipio ON tb_quejas.ID_MUN=tb_municipio.ID_MUN JOIN tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP join tb_quejas_detalle on tb_quejas_detalle.ID_QUEJA=tb_quejas.ID_QUEJA join tb_quejas_proveedor on tb_quejas.id_queja = tb_quejas_proveedor.id_queja JOIN tb_quejas_empresas ON tb_quejas_empresas.NIT=tb_quejas_proveedor.NIT WHERE QUEJA_CONSULTA=:id");
	$sql->bindValue(':id',$var);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	header("HTTP/1.1 200 hay datos");
	return json_encode($sql->fetchAll());
	exit;	

}
function actualizar_quejaestado($est,$tk){
	$pdo = new Conexion();
	$sql = "UPDATE tb_quejas SET ESTADO=:estado, FECHA_ACTUALIZA=NOW() WHERE QUEJA_CONSULTA=:tk";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':estado', $est);
		$stmt->bindValue(':tk', $tk);
		$stmt->execute();
		return header("HTTP/1.1 200 Ok");
		exit;
}
function ubicarresumen(){
	$arraydevuelve= array(0,0,0,0,0,0,0,0);
	$pdo = new Conexion();
	$sql = $pdo->prepare("
	select COUNT(*),dayOFWEEK(FECHA_ALTA),FECHA_ALTA from tb_quejas where WEEKOFYEAR(FECHA_ALTA)=WEEKOFYEAR(now()) GROUP BY DAYOFWEEK(FECHA_ALTA)");
	$sql->execute();
	$arr = $sql->fetchAll(PDO::FETCH_ASSOC);
	// $sql->setFetchMode(PDO::FETCH_ASSOC);
	$count=$sql->rowCount();

 foreach ($arr as $row) {
	 if($row['dayOFWEEK(FECHA_ALTA)']==1){
		 echo "Domingo,";
		 $reemplazosd = array(0 => $row['COUNT(*)']);
		 $cesta = array_replace($arraydevuelve,$reemplazosd);
		
	 }
	 if($row['dayOFWEEK(FECHA_ALTA)']==2){
		echo "Lunes";
		$reemplazos2=array(1 => $row['COUNT(*)']);
		$cesta = array_replace($arraydevuelve,$reemplazos2);
	}
	if($row['dayOFWEEK(FECHA_ALTA)']==3){
		echo "Martes";
		$reemplazos2=array(2 => $row['COUNT(*)']);
		$cesta = array_replace($arraydevuelve,$reemplazos2);
		
	}
	if($row['dayOFWEEK(FECHA_ALTA)']==4){
		echo "Miercoles";
		$reemplazosm=array(3 => $row['COUNT(*)']);
		$cesta = array_replace($arraydevuelve,$reemplazosm);
		
	}
	if($row['dayOFWEEK(FECHA_ALTA)']==5){
		echo "Jueves";
		$reemplazos2=array(4 => $row['COUNT(*)']);
		$cesta = array_replace($arraydevuelve,$reemplazos2);
		
	}
	if($row['dayOFWEEK(FECHA_ALTA)']==6){
		echo "Viernes";
		array(5 => $row['COUNT(*)']);
		echo $arraydevuelve[5];
	}
	if($row['dayOFWEEK(FECHA_ALTA)']==7){
		echo "sabado";
		array(6 => $row['COUNT(*)']);
		echo $arraydevuelve[6];
	}
	// echo $row['COUNT(*)'].",";
    // echo $row['dayOFWEEK(FECHA_ALTA)'].",";
	// echo $row['FECHA_ALTA'];
	// echo "</br>";
	print_r($cesta);
 }
 print_r($cesta);
//  $cesta = array_replace($arraydevuelve,$reemplazos2);
 
		// 	$i = 0;
		// while ($i < $count):
		// 	echo $sql->fetchAll();
		// 	$i++;
		// endwhile;
	// return $count;
	// return json_encode($sql->fetchAll());
	
}
function listar_resumendash(){
	header("HTTP/1.1 200 OK");
	$collectionresumen=array( 'regionresumen'=> array(listarresumeRegion()),'departamentoresumen'=>array(listarresumendepartamento()),'muncipioresumen'=>array(listarresumenmunicipio()));
	return json_encode($collectionresumen);
	exit;
}
function listarresumeRegion(){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT COUNT(*) total,REGION FROM tb_quejas join tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP JOIN tb_region ON tb_region.ID_REGION=tb_departamento.ID_REGION GROUP BY tb_quejas.ID_DEP");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return $sql->fetchAll();

}
function listarresumendepartamento(){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT COUNT(*) total,DEPARTAMENTO FROM tb_quejas join tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP GROUP BY tb_quejas.ID_DEP");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return $sql->fetchAll();
}
function listarresumenmunicipio(){
	$pdo = new Conexion();
	$sql = $pdo->prepare("SELECT COUNT(*) total,MUNICIPIO FROM tb_quejas join tb_municipio on tb_municipio.ID_MUN=tb_quejas.ID_MUN GROUP BY tb_quejas.ID_MUN");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	return $sql->fetchAll();
}
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
		header("HTTP/1.1 200 hay Usuario encontrado");
		return json_encode($sql->fetchAll());
		exit;	
	}else{
		 header("HTTP/1.1 200 Usuario no encontrado");
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
    $sql = $pdo->prepare("SELECT tb_departamento.DEPARTAMENTO,tb_municipio.MUNICIPIO,EMPRESA,ESTADO,TIPO,QUEJA_CONSULTA,tb_quejas.FECHA_ALTA,tb_quejas_proveedor.NIT,DIRECCION,ZONA,TELEFONO,CORREO,NOFACTURA,QUEJA,REQUEIRE FROM tb_quejas JOIN tb_municipio ON tb_quejas.ID_MUN=tb_municipio.ID_MUN JOIN tb_departamento on tb_departamento.ID_DEP=tb_quejas.ID_DEP join tb_quejas_detalle on tb_quejas_detalle.ID_QUEJA=tb_quejas.ID_QUEJA join tb_quejas_proveedor on tb_quejas.id_queja = tb_quejas_proveedor.id_queja JOIN tb_quejas_empresas ON tb_quejas_empresas.NIT=tb_quejas_proveedor.NIT WHERE QUEJA_CONSULTA=:id");
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
function dashresumen(){
	$pdo = new Conexion();
	$sql = $pdo->prepare("CALL Proc_dash_totales (@totaldia,@totalmes,@totaldiaantes,@totalanual)");
	$sql->execute();
	$sql->closeCursor();
	$row = $pdo->query("SELECT @totaldia AS Tdia, @totalmes AS Tmes, @totaldiaantes AS Tdiaantes, @totalanual AS Tanual;")->fetch(PDO::FETCH_ASSOC);
	$diatotals=$row['Tdia'];
	$mestotals=$row['Tmes'];
	$diaantess=$row['Tdiaantes'];
	$anuals=$row['Tanual'];
	$result= array("diatotal"=>$diatotals,"mestotal"=>$mestotals,"diaantes"=>$diaantess,"anual"=>$anuals);
	header("HTTP/1.1 200 OK");
	return json_encode($result);
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
function consultaremp($nitcons,$empcons){
	// $sqlinsert="INSERT INTO `tb_quejas_empresas`(`NIT`, `EMPRESA`, `FECHA__ALTA`, `FECHA_ACTUALIZADO`) VALUES ([value-1],[value-2],[value-3],[value-4])";
	$pdo = new Conexion();
    $sql = $pdo->prepare("SELECT NIT FROM tb_quejas_empresas WHERE NIT=:id");
	$sql->bindValue(':id',$nitcons);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$count=$sql->rowCount();
	// $sql->setFetchMode(PDO::FETCH_ASSOC);
	if ($count==0) {
	$sqla = $pdo->prepare("INSERT INTO tb_quejas_empresas (NIT, EMPRESA, FECHA__ALTA, FECHA_ACTUALIZADO) VALUES (:valnit,:valemp,now(),now())");
	$sqla->bindValue(':valnit',$nitcons);
	$sqla->bindValue(':valemp',$empcons);
	$sqla->execute();
		return TRUE;
		exit;	
	}else{
		return FALSE;
		exit;
	}
}
function alta_queja($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,
$var11,$var12,$var13,$var14,$var15,$var16,$var17,$var18,$var19){
	$pdo = new Conexion();
	// $carga=consultaremp($var11,$empn);
	$valorhjj="2021-08-09";
	$tipoqueja='Queja no anonima';
	$tkn_consulta=crear_token($var1);
	$stringhed = 'HTTP/1.1 200 '.$tkn_consulta;
	// $stringhed = 'HTTP/1.1 200 '.$carga;
	

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
		if ($row['resultadoobtenido']!=0) {
			header($stringhed);
			return $row !== false ? $row['resultadoobtenido'] : null;
			exit;
		}else{
			header("HTTP/1.1 200 fail");
			return "hubo un pequeño problema";
			exit;
		}

	}else{
		header("HTTP/1.1 400 Bad Request");
		return "hubo un pequeño problema";
		exit;
	}
	
}

	
?>