<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['fecha']) & isset($_GET['hora'])){
        $idsolicita=$_GET['fecha'];
        $idsolicitaa=$_GET['hora'];
       echo $idsolicita;
       echo $idsolicitaa;
    }
}
else{
    echo "no";
}
?>