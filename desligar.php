<?php
session_start();
$ramal=$_SESSION['ramal'];
//$telefone=$_POST['telefone'];
//echo "telefone eh: $telefone";

// Replace with your port if not using the default.
// If unsure check /etc/asterisk/manager.conf under [general];
$port = 5038;
// Replace with your username. You can find it in /etc/asterisk/manager.conf.
// If unsure look for a user with "hangup" permissions, or create one as
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
    echo "Connected to socket, sending authentication request.\n";
    // Prepare authentication request
    $authenticationRequest = "Action: Login\r\n";
    $authenticationRequest .= "Username: $username\r\n";
    $authenticationRequest .= "Secret: $password\r\n";
    $authenticationRequest .= "Events: off\r\n\r\n";
    // Send authentication request
    $authenticate = stream_socket_sendto($socket, $authenticationRequest);
    if($authenticate > 0)
    {
        // Wait for server response
        usleep(200000);
        // Read server response
        $authenticateResponse = fread($socket, 4096);
        // Check if authentication was successful
	echo "Autenticatio: $authenticateResponse";
        if(strpos($authenticateResponse, 'Success') !== false)
        {
            echo "Authenticated to Asterisk Manager Inteface. Initiating hangup call.\n";
            // Prepare hangup request
            $hangupResquest = "Action: Hangup\r\n";
            $hangupResquest .= "Channel: /^SIP/$ramal-.*$/\r\n";
	    $hangupResquest .= "Cause: 16\r\n";
	    $hangupResquest .= "\n";
            // Send hangup request
            $hangup = stream_socket_sendto($socket, $hangupResquest);
	    echo "Enviado: $hangup\n";
            if($hangup > 0)
            {
                // Wait for server response
                usleep(200000);
                // Read server response
                $hangupResponse = fread($socket, 4096);
                // Check if hangup was successful
		echo "Saida: $hangupResponse \n";	
                if(strpos($hangupResponse, 'Success') !== false)
                {
                    echo "Hangup initiated.";
                } else {
                    echo "Could not initiate hangup.\r\n";
                }
            } else {
                echo "Could not write hangup initiation request to socket.\n";
            }
        } else {
            echo "Could not authenticate to Asterisk Manager Interface.\n";
        }
    } else {
        echo "Could not write authentication request to socket.\n";
    }
} else {
    echo "Unable to connect to socket.";
}
header("Location: home.php");

