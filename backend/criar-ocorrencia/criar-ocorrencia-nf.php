<?php
include '../conexao.php';
include '../classes/classes-criar-ocorrencias.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

if (isset($_POST['pdv']) && !empty($_POST['pdv'])) {
    $PdvSelecionado = $_POST['pdv'];

    $nfObj = new Mapa($conn);

    $nfs = $nfObj->ListarNf($PdvSelecionado);

    echo json_encode($nfs);
} else {
    echo json_encode(['error' => 'Mapa não selecionado.']);
}
