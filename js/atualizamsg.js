// Função responsável por atualizar as frases
function atualizar()
{
    // Fazendo requisição AJAX
    //$.post('ajax/atualizar.php', function (frase) {
 
        // Exibindo frase
        $('#batata').html('<i>' + teste + '</i><br />' + testes);
 
    }, 'JSON');
}
 
// Definindo intervalo que a função será chamada
setInterval("atualizar()", 10000);
 
// Quando carregar a página
$(function() {
    // Faz a primeira atualização
    atualizar();
});
