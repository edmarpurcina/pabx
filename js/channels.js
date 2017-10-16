$('document').ready(function(){

	$("#btn-login").click(function(){
		var data = $(function response()).serialize();
			
		$.ajax({
			type : 'POST',
			url  : 'channels.php',
			data : data,
			dataType: 'json',
			beforeSend: function()
/*			{
				document.getElementByid("botao").onclick=function()	
				$("#btn-login").html('Validando ...');
			},*/
			success :  function(response){						
				$("#channels").html('<strong>Teste </strong>' + response.channels);

			/*	if(response.codigo == "1"){	
					$("#btn-login").html('Entrar');
					$("#login-alert").css('display', 'none')
					window.location.href = "home.php";
					
				}
				else{			
					$("#btn-login").html('Entrar');
					$("#login-alert").css('display', 'block')
					$("#mensagem").html('<strong>Erro! </strong>' + response.historico);
				}*/

		    }
		});
	});

});

