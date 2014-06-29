<?php
	$CLASSNAME = isset($_GET["className"]) ? $_GET["className"] : "";
	$QUERY = isset($_GET["classQuery"]) ? $_GET["classQuery"] : "";
	
	include_once("classes/Conexao.php");
	include_once("classes/".$CLASSNAME.".php");
	
	Conexao::Conectar();

	echo json_encode(call_user_func($CLASSNAME."::".$QUERY));
?>