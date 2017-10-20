<?php
session_start();
//echo "teste";
$telefone=$_POST['telefone'];
$ramal=$_SESSION['ramal'];
// Replace with your port if not using the default.
// If unsure check /etc/asterisk/manager.conf under [general];
$port = 5038;
// Replace with your username. You can find it in /etc/asterisk/manager.conf.
// If unsure look for a user with "originate" permissions, or create one as
// shown at http://www.voip-info.org/wiki/view/Asterisk+config+manager.conf.
$username = "admin";
// Replace with your password (refered to as "secret" in /etc/asterisk/manager.conf)
$password = "sua_senha";
// Internal phone line to call from
//$internalPhoneline = "203";

// Context for outbound calls. See /etc/asterisk/extensions.conf if unsure.
$context = "internal_users";
$socket = stream_socket_client("tcp://127.0.0.1:$port");
if($socket)
{
//	echo "Conectando ao socket, enviando autenticacao.\n";
	// Prepare authentication request
	$authenticationRequest = "Action: Login\r\n";
	$authenticationRequest .= "Username: $username\r\n";
	$authenticationRequest .= "Secret: $password\r\n\r\n";
//	$authenticationRequest .= "Events: off\r\n\r\n";
	// Send authentication request
	$authenticate = stream_socket_sendto($socket, $authenticationRequest);
	if($authenticate > 0)
	{
		// Wait for server response
		usleep(200000);
		// Read server response
		$authenticateResponse = fread($socket, 4096);
		// Check if authentication was successful
		if(strpos($authenticateResponse, 'Success') !== false)
				echo "Could not authenticate to Asterisk Manager Interface.\n";
		}
	}
 else {
		echo "Could not write authentication request to socket.\n";
}

