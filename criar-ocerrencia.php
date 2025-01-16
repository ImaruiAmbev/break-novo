<?php
$matricula = $_GET['matricula'];

include_once('backend/conexao.php');
include_once('backend/classes/classes-criar-ocorrencias.php');

$conexao = new Conexao();
$conn = $conexao->getConexao();

$mapa = new Mapa($conn);
$mapas = $mapa->ListarMapas($matricula);

// $cliente = New Mapa($conn);
// $clientes = $cliente->ListarCLiente($mapa)

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar ocorrencia</title>
    <script src="https://kit.fontawesome.com/11640fa694.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body>
    <?php include("src/itens/voltar.html") ?>

    <div class="container-pagina">
        <section class="section-pagina">
            <select class="select-pagina" id="select-mapa" onchange="CapturarCliente(this.value)">
                <option value="0">Mapa...</option>
                <?php
                if (!empty($mapas)) {
                    foreach ($mapas as $mapa) {
                        if (isset($mapa['mapa'])) {
                            echo '<option value="' . htmlspecialchars($mapa['mapa']) . '">' . htmlspecialchars($mapa['mapa']) . '</option>';
                        }
                    }
                } else {
                    echo '<option value="">Nenhum mapa encontrado</option>';
                } ?>
            </select>

            <select class="select-pagina" id="select-pdv">

            </select>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        function CapturarCliente(x){
            $("#select-pdv").empty();

            $.ajax({
                type: "POST",
                data:{
                    'mapa': x
                },
                url: "backend/criar-ocorrencia.php",
            })
        }
    </script>
</body>

</html>