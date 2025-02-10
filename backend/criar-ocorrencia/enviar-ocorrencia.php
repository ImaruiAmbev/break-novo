<?php
include '../conexao.php';
include '../classes/classes-criar-ocorrencias.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST['matricula'] ?? '';
    $mapa = $_POST['mapa'] ?? '';
    $frota = $_POST['frota'] ?? '';
    $pdv = $_POST['pdv'] ?? '';
    $nome_pdv = $_POST['nome_pdv'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    $nf = $_POST['nf'] ?? '';
    $obs = $_POST['obs'] ?? '';
    $produtos = $_POST['produtos'] ?? [];

    if (empty($matricula) || empty($mapa) || empty($frota) || empty($pdv) || empty($motivo) || empty($nf) || empty($produtos)) {
        echo json_encode(["error" => "Todos os campos são obrigatórios!"]);
        exit;
    }

    $ocorrencia = new Mapa($conn);
    echo $ocorrencia->EnviarProdutos($matricula, $mapa, $frota, $pdv, $nome_pdv, $nf, $motivo, $produtos, $obs);
} else {
    echo json_encode(["error" => "Método inválido."]);
}
