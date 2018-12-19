<?php
session_start();
include_once("funcoes.php");

$id_projeto = utf8_decode(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
$nome_projeto = utf8_decode(filter_input(INPUT_POST, 'nome_projeto', FILTER_SANITIZE_STRING));
$nome_produto = utf8_decode(filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING));
$descricao_produto = utf8_decode(filter_input(INPUT_POST, 'descricao_produto', FILTER_SANITIZE_STRING));
$riscos = utf8_decode(filter_input(INPUT_POST, 'riscos', FILTER_SANITIZE_STRING));
$interessados = utf8_decode(filter_input(INPUT_POST, 'interessados', FILTER_SANITIZE_STRING));
$viabilidade = utf8_decode(filter_input(INPUT_POST, 'viabilidade', FILTER_SANITIZE_STRING));
$equipe = utf8_decode(filter_input(INPUT_POST, 'equipe', FILTER_SANITIZE_STRING));
$entregas = utf8_decode(filter_input(INPUT_POST, 'entregas', FILTER_SANITIZE_STRING));
$cronograma = utf8_decode(filter_input(INPUT_POST, 'cronograma', FILTER_SANITIZE_STRING));
$premissas = utf8_decode(filter_input(INPUT_POST, 'premissas', FILTER_SANITIZE_STRING));
$efeitos = utf8_decode(filter_input(INPUT_POST, 'efeitos', FILTER_SANITIZE_STRING));
$custo = utf8_decode(filter_input(INPUT_POST, 'custo', FILTER_SANITIZE_STRING));
$anotacoes_complementares = utf8_decode(filter_input(INPUT_POST, 'anotacoes_complementares', FILTER_SANITIZE_STRING));

$conn = connect();

$id_produto = getIdProduto($id_projeto);

$result_produto = "UPDATE produto SET nome_produto='$nome_produto', descricao_produto='$descricao_produto' WHERE id_produto ='$id_produto'";
$resultado_produto = mysqli_query($conn, $result_produto);


$result_projeto = "UPDATE projeto SET nome_projeto='$nome_projeto', riscos='$riscos', interessados='$interessados', viabilidade='$viabilidade', equipe='$equipe', entregas='$entregas', cronograma='$cronograma', premissas='$premissas', efeitos='$efeitos', custo='$custo', anotacoes_complementares='$anotacoes_complementares' WHERE id_projeto ='$id_projeto'";
$resultado_projeto = mysqli_query($conn, $result_projeto);


if(mysqli_affected_rows($conn)){
	$_SESSION['msg'] = "<p style='color:green;'>Alterações realizadas com sucesso!</p>";
	header("Location: listar.php");
}else{
	$_SESSION['msg'] = "<p style='color:red;'>As alterações não foram salvas.</p>";
	header("Location: listar.php?id=$id_projeto");
}
