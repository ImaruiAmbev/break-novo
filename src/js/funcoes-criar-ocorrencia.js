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
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            $("#select-pdv").append('<option value="">Selecione um PDV...</option>');

            response.forEach(cliente => {
                $("#select-pdv").append(`<option value="${cliente.cod_cli} - ${cliente.cli}">${cliente.cod_cli} - ${cliente.cli}</option>`);
            });
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            $("#input-frota").val(response);
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            $("#select-nf").append('<option value="">Selecione uma NF...</option>');

            response.forEach(nf => {
                $("#select-nf").append(`<option value="${nf}">${nf}</option>`);
            });
        },
        error: function (xhr, status, error) {
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
        success: function (response) {
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
        error: function (xhr, status, error) {
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
    $("#table-produto").show()
    let Quantidade = $("#input-quantidade").val()
    const Radio = $('input[name="radio-pagina"]:checked').val();
    let Produtos = $("#select-produtos").val();
    const ProdutosArray = Produtos.split("-");
    let CodigoProduto = parseInt(ProdutosArray[0]);
    let Produto = ProdutosArray[1]

    if ($(`#tr-produto-${CodigoProduto}`).length) {
        alert("Produto já adicionado");
    } else {
        $("#tbody-produto").append(`
            <tr id='tr-produto-${CodigoProduto}'>
            <td>${CodigoProduto}</td>
            <td>${Produto}</td>
            <td>${Quantidade}</td>
            <td>${Radio}</td>
            <td onclick="DeletarItem()"><i class="fa-solid fa-xmark" style="color: #f05151;"></i></td>
            </tr>
        `);
    }
}

// Deletar produto selecionado
// Função com problema (Deleta sempre o ultimo Registro)
function DeletarItem() {
    let Produtos = $("#select-produtos").val();
    const ProdutosArray = Produtos.split("-");
    let CodigoProduto = parseInt(ProdutosArray[0]);

    $(`#tr-produto-${CodigoProduto}`).remove();
}

// Função para enviar ocorrencia ao banco
function Enviar() {
    const Matricula = $("#matricula").val();
    const Mapa = $("#select-mapa").val();
    const Frota = $("#input-frota").val();
    let PdvCompleto = $("#select-pdv").val();
    const PdvArray = PdvCompleto.split("-");
    let Pdv = parseInt(PdvArray[0]);
    let NomePdv = PdvArray[1];
    const Motivo = $("#select-motivo").val();
    const Nf = $("#select-nf").val();
    const Obs = $("#textarea-obs").val();
    const Radio = $('input[name="radio-pagina"]:checked').val();

    let Produtos = [];

    $('tbody tr').each(function () {
        let ProdutoInfo = [];

        $(this).find('td').each(function () {
            ProdutoInfo.push($(this).text());
        });

        Produtos.push(ProdutoInfo);
    });

    console.log(Produtos);

    if (Mapa.length === 0) {
        alert("Preencha o mapa");
    }

    if (Frota.length === 0) {
        alert("Preencha a frota");
    }

    if (PdvCompleto.length === 0) {
        alert("Selecione o PDV");
    }

    if (Motivo.length === 0) {
        alert("Selecione o motivo");
    }

    if (Nf.length === 0) {
        alert("Selecione a nota fiscal");
    }

    if (Obs.length === 0 || Obs === "Escreva uma observação sobre os produtos") {
        alert("Adicione uma Observação");
    }

    if (!Radio) {
        alert("Selecione uma opção de rádio");
    }

    if (Produtos.length === 0) {
        alert("Adicione pelo menos um produto");
        return;
    }

    $.ajax({
        type: "POST",
        url: "backend/criar-ocorrencia/enviar-ocorrencia.php",
        data: {
            'matricula': Matricula,
            'mapa': Mapa,
            'frota': Frota,
            'pdv': Pdv,
            'nome_pdv': NomePdv,
            'motivo': Motivo,
            'nf': Nf,
            'obs': Obs,
            'radio': Radio,
            'produtos': JSON.stringify(Produtos)
        },
        dataType: "json",
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }
            alert("1");
            // window.location("itens/sucesso.php");
        },
        error: function (xhr, status, error) {
            console.error("Erro na requisição AJAX:");
            console.error("Status:", status);
            console.error("Erro:", error);
            console.error("Resposta do servidor:", xhr.responseText);
            alert("0");
        }
    });
}
