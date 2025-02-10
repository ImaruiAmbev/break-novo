<?php
$matricula = $_GET['matricula'];

include_once('backend/conexao.php');
include_once('backend/classes/classes-criar-ocorrencias.php');

$conexao = new Conexao();
$conn = $conexao->getConexao();

$mapa = new Mapa($conn);
$mapas = $mapa->ListarMapas($matricula);
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
    <input id="matricula" type="hidden" value="<?php echo $matricula; ?>">
    <?php include("src/itens/voltar.html") ?>

    <div class="container-pagina">
        <section class="section-pagina">
            <h1 class="titulo-pagina">Criar ocorrência</h1>
            <select class="select-pagina" id="select-mapa" onchange="CapturarCliente(this.value), Frota(this.value)">
                <option value="">Mapa...</option>
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

            <input id="input-frota" type="text" placeholder="Frota" disabled>

            <select class="select-pagina" id="select-pdv" onchange="CapturarNf(this.value)">

            </select>

            <select class="select-pagina" id="select-motivo">
                <option value="">Escolha um motivo</option>
                <option value="avaria">Avaria</option>
                <option value="falta">Falta</option>
            </select>

            <select class="select-pagina" id="select-nf" onchange="CapturarProdutos(this.value)">

            </select>
            <textarea id="textarea-obs">Escreva uma observação sobre os produtos</textarea>
        </section>

        <section class="section-pagina">
            <h1 class="titulo-pagina">Produtos</h1>
            <select id="select-produtos">

            </select>
            <input type="text" class="input-pagina" id="input-quantidade" placeholder="Quantidade">
            <div class="radios-pagina">
                <label for="cx-radio-pagina">
                    <input id="cx-radio-pagina" type="radio" name="radio-pagina" value="cx">
                    CX
                </label>
                <label for="uni-radio-pagina">
                    <input id="uni-radio-pagina" type="radio" name="radio-pagina" value="uni">
                    UNI
                </label>
            </div>
            <button class="botao-adicionar" onclick="AdicionarProduto()">+ Adicionar</button>
            <table id="table-produto" style="display: none;">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Qtde</th>
                        <th>Med.</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="tbody-produto">
                </tbody>
            </table>
            <button onclick="Enviar()">Enviar</button>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="src/js/funcoes-criar-ocorrencia.js"></script>
</body>

</html>