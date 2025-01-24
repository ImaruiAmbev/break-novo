<?php
include '../conexao.php';
include '../classes/classes-criar-ocorrencias.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

if (isset($_POST['mapa']) && !empty($_POST['mapa'])) {
    $mapaSelecionado = $_POST['mapa'];

    $mapaObj = new Mapa($conn);

    $clientes = $mapaObj->ListarClientes($mapaSelecionado);

    echo json_encode($clientes);
} else {
    echo json_encode(['error' => 'Mapa não selecionado.']);
}