<?php

include('config.inc');

function base64safe_encode($str) {
    return str_replace('=', '', strtr(base64_encode($str), '+/', '-_'));
}

$oauth_url = 'http://10.253.161.5/authtokenqualif/oauth2/v1';
$oauth_service = 'http://10.253.161.5/cielqualifinterpro/ws/1.0/declarations';

$entete = '{"alg":"RS256"}';

$corps = '{"iss":"'.$iss.'","scope":"'.$oauth_service.'","aud":"'.$oauth_url.'","iat":"'.time().'000"}';

$base = base64safe_encode($entete).'.'.base64safe_encode($corps);

$encrypted = '';
if (! openssl_sign($base, $encrypted, $key, 'SHA256')) {
    print('ERROR: '.openssl_error_string()."\n");
}

$oauth_string = $base.'.'.base64safe_encode($encrypted);

echo "JWT String : \n".$oauth_string."\n\n";

$data = array('grant_type'=> 'urn:ietf:params:oauth:grant-type:jwt-bearer' , 'assertion' => $oauth_string);

$options = array(
    'http' => array(
        'header'  => "Host: 10.253.161.5\nContent-Type: application/x-www-form-urlencoded\n",
        'method'  => 'POST',
        'protocol_version' => 1.1,
        'ignore_errors' => true,
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);

$result = file_get_contents($oauth_url.'/token', false, $context);

echo "JWT answer: \n".$result ."\n";