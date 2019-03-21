<?php
session_start();
include_once("funcoes.php");

$conn = connect();
$id_usuario = $_SESSION['id'];
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);

updateTelefone($conn, $telefone, $id_usuario);

if(mysqli_affected_rows($conn)){
    $_SESSION['msg'] = "<p style='color:green;'>Telefone alterado com sucesso!</p>";
    header("Location: ../view/configuracoes.php");
}else{
    $_SESSION['msg'] = "<p style='color:red;'>Não foi possível alterar o telefone.</p>";
    header("Location: ../view/configuracoes.php");
}

?>