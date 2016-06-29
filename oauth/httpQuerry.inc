<?php

function httpQuerry($url, $options) {
	if (isset($curl_enabled) && $curl_enabled) {
		return httpQuerryCurl($url, $options);
	}
	return httpQuerryFgc($url, $options);
}

function httpQuerryFgc($url, $options) {
        if (isset($options['http']['headers'])) {
                $options['http']['header'] = join('\n', $options['http']['headers']);
                unset($options['http']['headers']);
        }
        $context  = stream_context_create($options);
        return file_get_contents($url, false, $context);
}

function httpQuerryCurl($url, $options) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (isset($options['http']['content']) || (isset($options['http']['method']) && $options['http']['method'] == 'POST')) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $options['http']['content']);  //Post Fields
        }
        if (isset($options['http']['headers'])) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $options['http']['headers']);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        return $server_output;
}


