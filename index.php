<?php
$hubVerifyToken = "kolaposapp";
$challenge = $_REQUEST['hub_challenge'];
$accessToken = "EAAcnQarZCcIMBAGU5zjXncqtFk8mwWFiPgSZCOahwJ3gVEUCEZCd2lkg2JyZCfNLkOVyBlosFcaTqv8Di4r37CCdvQDoGo5gwb7EBy9aJDZBerzCtKhv5sitIQR5BFTHTqvAv9n8yFYSRd9vdw46KgvTW9VzIxIb7ZAgPW8ZBtPR9k8SMfcMfMY";

if ($_REQUEST['hub_verify_token'] === $hubVerifyToken){
	echo $challenge;
exit; 
}

$input = json_decode(file_get_contents('php://input'),true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$pmessage = $input['entry'][0]['messaging'][0]['postback']['payload'];
 if ($message == 'Hi') {
$answer = 'Hello There';
}
$response = [
"recipient"=>["id"=>$sender],
"message"=>$answer
];

$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

if (!empty($message) OR !empty($pmessage)){
	$result = curl_exec($ch);
}
curl_close($ch);
exit;
?>
