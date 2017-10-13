<?php
session_start();
//ini_set('display_errors','On');
//error_reporting(E_ALL);

// Constante com a quantidade de tentativas aceitas
define('TENTATIVAS_ACEITAS', 10); 

// Constante com a quantidade minutos para bloqueio
define('MINUTOS_BLOQUEIO', 5); 

// Require da classe de conexão
require 'conexao.php';

// Instancia Conexão PDO
$conexao = Conexao::getInstance();

// Recebe os dados do formulário
$user = (isset($_POST['usuario'])) ? $_POST['usuario'] : '' ;
$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '' ;
$ramal = (isset($_POST['ramal'])) ? $_POST['ramal'] : '' ;

// Validações de preenchimento e-mail e senha se foi preenchido o e-mail
if (empty($user)):
	$retorno = array('codigo' => '0', 'mensagem' => 'Preencha seu usuario!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($senha)):
	$retorno = array('codigo' => '0', 'mensagem' => 'Preencha sua senha!');
	echo json_encode($retorno);
	exit();
endif;

if (empty($ramal)):
	$retorno = array('codigo' => '0', 'mensagem' => 'Preencha seu ramal!');
	echo json_encode($retorno);
	exit();
endif;


// Válida os dados do usuário com o banco de dados
$sql = 'SELECT id, nome, usuario, senha FROM tab_usuario WHERE usuario = ? and status = ? LIMIT 1';
$stm = $conexao->prepare($sql);
$stm->bindValue(1, $user);
$stm->bindValue(2, 'A');
$stm->execute();
$retorno = $stm->fetch(PDO::FETCH_OBJ);

// Válida a senha utlizando a API Password Hash
//if(password_verify($senha, $retorno->senha)):
if ($senha==$retorno->senha):
	$_SESSION['id'] = $retorno->id;
	$_SESSION['nome'] = $retorno->nome;
	$_SESSION['usuario'] = $retorno->email;
	$_SESSION['ramal'] = $ramal;
	$_SESSION['tentativas'] = 0;
	$_SESSION['logado'] = 'SIM';
else:
	$_SESSION['logado'] = 'NAO';
	$bloqueado = ($_SESSION['tentativas'] == TENTATIVAS_ACEITAS) ? 'SIM' : 'NAO';
	
	// Dica 7 - Grava a tentativa independente de falha ou não
	$sql = 'INSERT INTO tab_log_tentativa (ip, email, senha, origem, bloqueado) VALUES (?, ?, ?, ?, ?)';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $_SERVER['SERVER_ADDR']);
	$stm->bindValue(2, $user);
	$stm->bindValue(3, $senha);
	$stm->bindValue(4, $_SERVER['HTTP_REFERER']);
	$stm->bindValue(5, $bloqueado);
	$stm->execute();
endif;


// Se logado envia código 1, senão retorna mensagem de erro para o login
if ($_SESSION['logado'] == 'SIM'):
	$retorno = array('codigo' => 1, 'mensagem' => 'Logado com sucesso!');
	echo json_encode($retorno);
	exit();
else:
	$retorno = array('codigo' => '0', 'mensagem' => 'Usuário não autorizado!');
	echo json_encode($retorno);
	exit();
endif;

