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
function listar_registro_specifico($var){
    $pdo = new Conexion();
    $sql = $pdo->prepare("SELECT * FROM tb_quejas WHERE ID_QUEJA=:id");
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
function alta_queja($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15){
	$pdo = new Conexion();
	$tkn_consulta=crear_token($var1);

	$cadenasql = "CALL Proc_Alta_Quejas(:Departamento,:Municipio,:Estado,:Tipo,:Tkconsulta,:Nombre,:Cui,:telefono,:celular,:correo,:direccion,:empresa,:nit,:diremp,:Zemp,:telemp,:correoemp,@result)";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':Departamento',$var2, PDO::PARAM_INT);
	$stmt->bindParam(':Municipio',$var3, PDO::PARAM_INT);

	if($var1==='1'){
		header("HTTP/1.1 200 OK");
		return "  Usuario creado exitosamente";
		exit;
	}else{
		header("HTTP/1.1 400 Bad Request");
		return "  hubo un pequeño problema";
		exit;
	}
	//$sql = "CALL Proc_Alta_Quejas(:)";
	//$sql = "INSERT INTO contactos (nombre, telefono, email) VALUES(:nombre, :telefono, :email)";
		// $stmt = $pdo->prepare($sql);
		// $stmt->bindValue(':nombre', $_POST['nombre']);
		// $stmt->bindValue(':telefono', $_POST['telefono']);
		// $stmt->bindValue(':email', $_POST['email']);
		// $stmt->execute();
		// $idPost = $pdo->lastInsertId(); 
		// if($idPost)
		// {
		// 	header("HTTP/1.1 200 Ok");
		// 	echo json_encode($idPost);
		// 	exit;
		// }
}

	//Listar registros y consultar registro
	// if($_SERVER['REQUEST_METHOD'] == 'GET'){
		
    //     if(isset($_GET['id']))
	// 	{
	// 		$sql = $pdo->prepare("SELECT * FROM tb_quejas WHERE ID_QUEJA=:id");
	// 		$sql->bindValue(':id', $_GET['id']);
	// 		$sql->execute();
	// 		$sql->setFetchMode(PDO::FETCH_ASSOC);
	// 		header("HTTP/1.1 200 hay datos");
	// 		echo json_encode($sql->fetchAll());
	// 		exit;				
			
	// 		} else {
			
	// 		$sql = $pdo->prepare("SELECT * FROM tb_quejas");
	// 		$sql->execute();
	// 		$sql->setFetchMode(PDO::FETCH_ASSOC);
	// 		header("HTTP/1.1 200 hay datos");
	// 		echo json_encode($sql->fetchAll());
	// 		exit;		
	// 	}
	// }
	
	//Insertar registro
	// if($_SERVER['REQUEST_METHOD'] == 'POST')
	// {
	// 	$sql = "INSERT INTO contactos (nombre, telefono, email) VALUES(:nombre, :telefono, :email)";
	// 	$stmt = $pdo->prepare($sql);
	// 	$stmt->bindValue(':nombre', $_POST['nombre']);
	// 	$stmt->bindValue(':telefono', $_POST['telefono']);
	// 	$stmt->bindValue(':email', $_POST['email']);
	// 	$stmt->execute();
	// 	$idPost = $pdo->lastInsertId(); 
	// 	if($idPost)
	// 	{
	// 		header("HTTP/1.1 200 Ok");
	// 		echo json_encode($idPost);
	// 		exit;
	// 	}
	// }
	
	//Actualizar registro
	// if($_SERVER['REQUEST_METHOD'] == 'PUT')
	// {		
	// 	$sql = "UPDATE contactos SET nombre=:nombre, telefono=:telefono, email=:email WHERE id=:id";
	// 	$stmt = $pdo->prepare($sql);
	// 	$stmt->bindValue(':nombre', $_GET['nombre']);
	// 	$stmt->bindValue(':telefono', $_GET['telefono']);
	// 	$stmt->bindValue(':email', $_GET['email']);
	// 	$stmt->bindValue(':id', $_GET['id']);
	// 	$stmt->execute();
	// 	header("HTTP/1.1 200 Ok");
	// 	exit;
	// }
	
	//Eliminar registro
	// if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	// {
	// 	$sql = "DELETE FROM contactos WHERE id=:id";
	// 	$stmt = $pdo->prepare($sql);
	// 	$stmt->bindValue(':id', $_GET['id']);
	// 	$stmt->execute();
	// 	header("HTTP/1.1 200 Ok");
	// 	exit;
	// }
	
	//Si no corresponde a ninguna opción anterior
	// header("HTTP/1.1 400 Bad Request");
?>