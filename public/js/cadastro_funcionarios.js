// Função para remover pontos e traços do CPF
function limparCPF() {
    // Obtém o valor do campo de input com o id "cpf"
    var cpf = document.getElementById("cpf").value;

    // Remove tudo que não for número (pontos, traços, letras, etc.)
    // A expressão regular /[^\d]+/g:
    // [^\d] significa "qualquer caractere que não seja um número".
    // + significa "um ou mais desses caracteres".
    // g é o modificador global, ou seja, vai substituir todas as ocorrências.
    cpf = cpf.replace(/[^\d]+/g, '');

    // Atualiza o campo de input "cpf" com o valor limpo (somente números)
    document.getElementById("cpf").value = cpf;
}
