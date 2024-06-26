function mensagem(texto) {
    window.alert(texto);
}

function testarBtn() {
    mensagem("Botão respondendo!");
}

function criarParagrafo() {
    document.getElementById("msg").innerHTML = "Estamos alterando a página dinamicamente!";

    // mensagem("Criar Parágrafo funcionando!");
}

function criarLista() {
    let qtdOpcoes = parseInt(document.getElementById("opcoes").value);
    console.log(qtdOpcoes);

    let output = "";
    for (let i = 0; i < qtdOpcoes; i++) {
        output += "<option value=\"Op" + i + "\">Opção " + i + "</option>";
    }
    document.getElementById("lista").innerHTML = output;

    // mensagem("Criar Lista funcionando!");
}

function criarTabela() {
    let linhas = parseInt(document.getElementById("linhas").value);
    let colunas = parseInt(document.getElementById("colunas").value);
    console.log(linhas, colunas);

    let output = "";
    for (let i = 0; i < linhas; i++) {
        output += "<tr>\n";
        for (let j = 0; j < colunas; j++) {
            output += "<td>" + (i * colunas + j) + "</td>\n";
        }
        output += "</tr>\n";
    }

    document.getElementById("tabela").innerHTML = output;

    // mensagem("Criar Lista funcionando!");
}

function testar() {
    // Chamar função a ser testada descomentando a linha.
    testarBtn();
    criarParagrafo();
    criarLista();
    criarTabela();
}