<?php
$matricula = $_GET['matricula'];

include("backend/conexao.php");
include("backend/classes/classes_index.php");

$conexao = new Conexao();
$conn = $conexao->getConexao();

$modulo = new Modulos($conn);
$modulos = $modulo->ListarModulo();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://kit.fontawesome.com/11640fa694.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body>
    <?php include_once("src/itens/navbar.php") ?>

    <section class="container-menu">
        <div class="titulo-menu">
            <h1>Módulos</h1>
        </div>
        <div class="div-modulos">
            <?php foreach ($modulos as $modulo) {
                echo "<div class='modulo' style='background-color: " . htmlspecialchars($modulo['cor']) . " ;' onclick=\"window.location.href = 'criar-ocerrencia.php?matricula=$matricula'\">
                    <div class='elementos-modulo'>
                        <h1> " . htmlspecialchars($modulo['nome']) . "
                        <img alt='src/img" . htmlspecialchars($modulo['imagem']) . "' src='" . htmlspecialchars($modulo['imagem']) . "'>
                    </div>
                </div>";
            } ?>
        </div>
    </section>
</body>

</html>