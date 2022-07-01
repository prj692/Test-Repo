<?php
	
	//Includes the file that contains your project's unique server key from the Firebase Console.
	require_once("serverKeyInfo.php");
	
	//Sets the serverKey variable to the googleServerKey variable in the serverKeyInfo.php script.
	$serverKey = $googleServerKey;
	
	//URL that we will send our message to for it to be processed by Firebase.
	$url = "https://fcm.googleapis.com/fcm/send";

	//Recipient of the message. This can be a device token (to send to an individual device) 
	//or a topic (to be sent to all devices subscribed to the specified topic).
	$recipient = "/topics/all";
	
	//Structure of our notification that will be displayed on the user's screen if the app is in the background.
	$notification =
	[
		'title'   => "4th of July Sale!",
		'body'   => "All skins half off until July 7th"
	];

	//Structure of the data that will be sent with the message but not visible to the user.
	//We can however use Unity to access this data.
	$dataPayload = 
	[
		"powerLevel" => "9001",
		"dataString" => "This is some string data"
	];
	
	//Full structure of message inculding target device(s), notification, and data.
	$fields = 
	[
		'to'  => $recipient,
		'notification' => $notification,
		'data' => $dataPayload
	];

	//Set the appropriate headers
	$headers = 
	[
	'Authorization: key=' . $serverKey,
	'Content-Type: application/json'
	];

	//Send the message using cURL.
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, $url);
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	
	//Result is printed to screen.
	echo $result;
?>