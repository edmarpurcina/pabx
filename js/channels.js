// Função responsável por atualizar as frases
function atualizar(){
        // Fazendo requisição AJAX
        $.post('channels.php', function (response) {
         // Exibindo frase
        $('#channels').html('<strong>' + response.channels + '</strong>' );

        }, 'JSON');
}

// Definindo intervalo que a função será chamada
setInterval("atualizar()", 10000);
// Quando carregar a página

$(function() {
        // Faz a primeira atualização
        atualizar();
});

