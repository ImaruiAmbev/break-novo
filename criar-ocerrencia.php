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
    <?php include("src/itens/voltar.html") ?>

    <div class="container-pagina">
        <section class="section-pagina">
            <h1 class="titulo-pagina">Criar ocorrência</h1>
            <select class="select-pagina" id="select-mapa" onchange="CapturarCliente(this.value), Frota(this.value)">
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
            <button onclick="AdicionarProduto()">+ Adicionar</button>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Captura o valor do mapa e passa o cliente
        function CapturarCliente(mapaSelecionado) {
            $("#select-pdv").empty();

            if (mapaSelecionado === "0") {
                $("#select-pdv").append('<option value="">Selecione um PDV...</option>');
                return;
            }

            $.ajax({
                type: "POST",
                url: "backend/criar-ocorrencia/criar-ocorrencia.php",
                data: {
                    'mapa': mapaSelecionado
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    $("#select-pdv").append('<option value="">Selecione um PDV...</option>');

                    response.forEach(cliente => {
                        $("#select-pdv").append(`<option value="${cliente}">${cliente}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:");
                    console.error("Status:", status);
                    console.error("Erro:", error);
                    console.error("Resposta do servidor:", xhr.responseText);
                    alert("Erro ao buscar os clientes. Tente novamente.");
                }

            });
        }

        // Captura a frota baseada no mapa
        function Frota(mapaSelecionado) {
            $.ajax({
                type: "POST",
                url: "backend/criar-ocorrencia/criar-ocorrencia-frota.php",
                data: {
                    'mapa': mapaSelecionado
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    $("#input-frota").val(response);
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:");
                    console.error("Status:", status);
                    console.error("Erro:", error);
                    console.error("Resposta do servidor:", xhr.responseText);
                    alert("Erro ao buscar os clientes. Tente novamente.");
                }
            })
        }

        // Captura o cliente e passa a NF
        function CapturarNf(PdvSelecionado) {
            $("#select-nf").empty();

            if (PdvSelecionado === "0") {
                $("#select-nf").append('<option value="">Selecione uma NF...</option>');
                return;
            }

            $.ajax({
                type: "POST",
                url: "backend/criar-ocorrencia/criar-ocorrencia-nf.php",
                data: {
                    'pdv': PdvSelecionado
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    $("#select-nf").append('<option value="">Selecione uma NF...</option>');

                    response.forEach(nf => {
                        $("#select-nf").append(`<option value="${nf}">${nf}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:");
                    console.error("Status:", status);
                    console.error("Erro:", error);
                    console.error("Resposta do servidor:", xhr.responseText);
                    alert("Erro ao buscar os clientes. Tente novamente.");
                }
            })
        }

        // Captura os produtos com base na NF
        function CapturarProdutos(NfSelecinada) {
            $("#select-produtos").empty();

            if (NfSelecinada === "0") {
                $("#select-produtos").append('<option value="">Selecione um produto...</option>');
                return;
            }

            $.ajax({
                type: "POST",
                url: "backend/criar-ocorrencia/criar-ocorrencia-produto.php",
                data: {
                    'nf': NfSelecinada
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    $("#select-produtos").append('<option value="">Selecione um produto...</option>');

                    response.produtos.forEach((prod, index) => {
                        const cod_prod = response.codigos[index];
                        $("#select-produtos").append(`<option value="${cod_prod}-${prod}">${cod_prod} - ${prod}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição AJAX:");
                    console.error("Status:", status);
                    console.error("Erro:", error);
                    console.error("Resposta do servidor:", xhr.responseText);
                    alert("Erro ao buscar os produtos. Tente novamente.");
                }
            });
        }

        // Captura os dados do produto e insere em uma tabela
        function AdicionarProduto() {
            const Radio = $('input[name="radio-pagina"]:checked').val();
            let Produtos = $("#select-produtos").val();
            const ProdutosArray = Produtos.split("-");
            let CodigoProduto = parseInt(ProdutosArray[0]);
            let Produto = ProdutosArray[1]

        }
    </script>
</body>

</html>