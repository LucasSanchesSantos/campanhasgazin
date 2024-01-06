$(document).ready(() => {
    $('#modalFiltro').modal('show')
})

let condicaoSelecionarTudo = true;



function atualizarCards(idFilialSessao) {
    const elementoIdFilial = document.getElementById('idFilial');

    let idFilial = elementoIdFilial ? elementoIdFilial.value : idFilialSessao;

    let filtroPromocao = document.getElementById('filtroIdPromocao').value;
    // let filtroCategoria = document.getElementById('filtroCategoria').value;
    // let filtroSubcategoria = document.getElementById('filtroSubcategoria').value;
    let filtroIdProduto = document.getElementById('filtroIdProduto').value;

    $('#modalFiltro').modal('hide');

    let validacaoFiltroPromocao = '';

    if(filtroPromocao == undefined || filtroPromocao == null || filtroPromocao.length === 0){
        validacaoFiltroPromocao = 0;
    }else{
        validacaoFiltroPromocao = 10000000;
    }

    let parametros = {
        "idFilial": idFilial,
        "promocao": filtroPromocao,
        // "idDepartamento": filtroCategoria,
        // "idSubdepartamento": filtroSubcategoria,
        "validacaoFiltroPromocao": validacaoFiltroPromocao,
        "idProduto": filtroIdProduto
    };

    let divInformativoFiltro = document.getElementById('divInformativoFiltro');
    let informativoFiltro = document.getElementById('informativoFiltro');

    divInformativoFiltro.setAttribute('class', 'd-none');

    $.get(`${URL}impressao/produtosPorFiltro`, parametros)
        .done(function(response) {
            let dados = JSON.parse(response);

            if (dados == null) {
                divInformativoFiltro.setAttribute('class', 'mt-4 w-100');

                informativoFiltro.innerHTML = 'Nenhum produto encontrado!';

                return;
            }

            let divCards = document.getElementById('divCards');

            divCards.innerHTML = '';

            let idElemento = 1;
            
            Object.values(dados).forEach((produto) => {
                let valor = produto['tipo'] === 'A Vista' ? 
                    converterStringEmMoeda(produto['preco_partida'])
                    : converterStringEmMoeda(produto['preco_a_prazo']);

                let divInformacoes = getDivInformacoes(produto, valor, idElemento);
                let divImgInformacoes = getDivImgInformacoes();
                let divImg = getDivImg(produto['imagem']);
                let divCheckbox = getDivCheckbox(idElemento);
                let divImgInformacoesCheckbox = getDivImgInformacoesCheckbox();

                divImgInformacoes.appendChild(divImg);
                divImgInformacoes.appendChild(divInformacoes);

                divImgInformacoesCheckbox.appendChild(divImgInformacoes);
                divImgInformacoesCheckbox.appendChild(divCheckbox);

                let divDe = getDivDe(idElemento);
                let divPromocao = getDivPromocao(produto, idElemento);
                let divPromocaoDe = getDivPromocaoDe();

                divPromocaoDe.appendChild(divPromocao);
                divPromocaoDe.appendChild(divDe);

                let divConteudoCard = getDivConteudoCard(idElemento);

                divConteudoCard.appendChild(divImgInformacoesCheckbox);
                divConteudoCard.appendChild(divPromocaoDe);

                let divCard = getDivCard(idElemento, produto);

                divCard.appendChild(divConteudoCard);

                divCards.appendChild(divCard);

                aplicarMascaras();

                idElemento++;
            });
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Ocorreu um erro na requisição:", textStatus, errorThrown);

            divInformativoFiltro.setAttribute('class', 'mt-4 w-100');

            informativoFiltro.innerHTML = 'Produto(s) não encontrado(s).';

            divCards.innerHTML = '';
        });
}

function getDivImgInformacoes() {
    let div = document.createElement('div');

    div.setAttribute('class', 'd-flex');

    return div;
}

function getDivImg(url) {
    let div = document.createElement('div');
    let img = document.createElement('img');

    img.setAttribute('src', url);
    img.setAttribute('width', '150px');

    div.appendChild(img);

    return div;
}

function getDivCheckbox(idElemento) {
    let div = document.createElement('div');
    let checkbox = document.createElement('input');

    div.setAttribute('class', 'form-check d-flex justify-content-end');
    checkbox.setAttribute('class', 'form-check-input');
    checkbox.setAttribute('type', 'checkbox');
    checkbox.setAttribute('value', `produtoPromocao${idElemento}`);

    checkbox.checked = false;

    div.appendChild(checkbox);

    return div;
}

function getDivImgInformacoesCheckbox() {
    let div = document.createElement('div');

    div.setAttribute('class', 'd-flex justify-content-between');

    return div;
}

function getDivConteudoCard(idElemento) {
    let div = document.createElement('div');

    div.setAttribute('class', 'h-100 border p-3');
    div.setAttribute('onclick', `selecionarCheckbox('produtoPromocao${idElemento}')`);

    return div;
}

function getDivCard(idElemento, produto) {
    let div = document.createElement('div');

    div.setAttribute('class', 'col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 p-3');
    div.setAttribute('id', `produtoPromocao${idElemento}`);

    let json = JSON.stringify(produto);

    div.setAttribute('dados', json);

    return div;
}

function converterStringEmMoeda(valor) {
    valor = (+valor).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
    valor = valor.replace('R$', '');

    return valor;
}

function getAlturaPrimeiroConteudo(conteudo) {
    let tamanhoEmBytes = new Blob([JSON.stringify(conteudo)]).size;
    let tamanhoEmKiloBytes = tamanhoEmBytes / 1024;
    let pixelsPorKiloByte = 10; // Exemplo: 10 pixels por kilobyte
    let tamanhoEmPixels = tamanhoEmKiloBytes * pixelsPorKiloByte;
    let marginsExtras = 0;

    return tamanhoEmPixels + marginsExtras;
}
