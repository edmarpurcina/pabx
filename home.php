<?php
include "verifica_sessao.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Menu Principal</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style type="text/css">
.margin-top-md{
	margin-top: 25px;
}
.margin-botoon-md{
	margin-bottom: 25px;
}
</style>
</head>
<body>   
    <div class="container">    
        <div id="loginbox" class="mainbox col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2 margin-top-md">                    
            <div class="panel panel-primary" >
                <div class="panel-heading">
                    <div class="panel-title" align="right">Ola <?= $_SESSION['nome'] ?> - Ramal: <?= $_SESSION['ramal']?>

                        <a href="logout.php" class="btn-lg btn-danger">Sair </a>
                    </div>
                </div>
                <div class="panel panel-primary margin-top-md">
                    <div class="panel-heading">
                        <div class="panel-title">Gerar Ligação</div>
                    </div>
                    <div class="pannel-body padding-top-md">
                        <form id="ligar" class="form-horizontal" role="form" action="dial.php" method="post">

                            <div class="input-group margin-bottom-md">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                <input type="tel" class="form-control" id="telefone" name="telefone" required placeholder="Ex.: Local: 34415200 - DDD 06434115200">
                            </div>

                            <div class="form-group margin-top-md">
                                <div class="col-sm-12 controls">
                                    <input type="submit" class="btn btn-primary" value="Ligar" name="btn-ligar" id="btn-login">
                                    <a href="desligar.php" class="btn btn-danger">Desligar </a>
                                 </div>
                             </div>
                         </form>
                    </div>
               </div>
               <div class="panel panel-primary margin-top-md">
                    <div class="panel-heading">
                        <div class="panel-title">Hisotrico</div>
                    </div>
                    <div class="pannel-body padding-top-md">
			<div id="login-alert" class="alert  col-sm-12">
                        <span class="glyphiconcons-iphone-transfer"></span>
                        <span id="historico"></span>
                    </div>
                    </div>
               </div>
	   </div>  
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/custom.js"></script> 
</body>
</html>
