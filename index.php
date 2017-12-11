<?php
$hubVerifyToken = "kolaposapp";
$challenge = $_REQUEST['hub_challenge'];
global $accessToken = "EAAcnQarZCcIMBAGU5zjXncqtFk8mwWFiPgSZCOahwJ3gVEUCEZCd2lkg2JyZCfNLkOVyBlosFcaTqv8Di4r37CCdvQDoGo5gwb7EBy9aJDZBerzCtKhv5sitIQR5BFTHTqvAv9n8yFYSRd9vdw46KgvTW9VzIxIb7ZAgPW8ZBtPR9k8SMfcMfMY";
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken){
	echo $challenge;
}
$input = json_decode(file_get_contents('php://input'),true);
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$pmessage = $input['entry'][0]['messaging'][0]['postback']['payload'];
 if ($message == "start" OR $pmessage == "start") {
$answer = "Hello There, Welcome to Kolapo's app";
}
else if (strlen($message) == "Hi" OR strlen($message) == "hello"){
$answer = "Good Day";
}
else {
$answer = "I don't understand that yet!";
exit;
}
$response = [
"recipient"=>["id"=>$sender],
"message"=>$answer
];
	
$get_started_button = '{
  "setting_type":"call_to_actions",
  "thread_state":"new_thread",
  "call_to_actions":[
    {
      "payload":"start"
    }
  ]
}';

function curl($input) {
	global $accessToken; 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v2.6/me/thread_settings?access_token='.$accessToken);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	$output = curl_exec($ch);
	curl_close($ch);
	error_log($output); 
 } 
 
curl($get_started_button);

$response = [
"recipient"=>["id"=>$sender],
"message"=>$answer
];

function curl1($response,$encode)
 {
	global $accessToken;
	global $input;
	$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);

    curl_setopt($ch, CURLOPT_POST, 1);
    if($encode === 1){
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
	}
	else{
       curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	}
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
   if(!empty($input)){
   $result = curl_exec($ch);
   }
   curl_close($ch);  
 }


curl1($response,1);
exit;
?>
