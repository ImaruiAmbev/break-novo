<?php
include '../conexao.php';
include '../classes/classes-criar-ocorrencias.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

if (isset($_POST['nf']) && !empty($_POST['nf'])) {
    $NfSelecionada = $_POST['nf'];

    $nfObj = new Mapa($conn);

    $produto = $nfObj->ListarProdutos($NfSelecionada);

    echo json_encode($produto);
} else {
    error_log("Nenhum mapa selecionado");
}
