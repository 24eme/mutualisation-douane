<?php

header('Content-Type: image/svg+xml');

$ping = file_get_contents("http://10.253.161.5/authtokenqualif/oauth2/v1/ping", false, stream_context_create(array('http' => array('timeout' => 1))));
exec("tcptraceroute -f 6 -m 6 -q 1 -n -w 1  10.253.161.5 80", $output);

if($ping || preg_match('/10.94.10.2/', $output[0])): ?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="88" height="20"><linearGradient id="b" x2="0" y2="100%"><stop offset="0" stop-color="#bbb" stop-opacity=".1"/><stop offset="1" stop-opacity=".1"/></linearGradient><clipPath id="a"><rect width="88" height="20" rx="3" fill="#fff"/></clipPath><g clip-path="url(#a)"><path fill="#555" d="M0 0h37v20H0z"/><path fill="#4c1" d="M37 0h51v20H37z"/><path fill="url(#b)" d="M0 0h88v20H0z"/></g><g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="110"><text x="195" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="270">PASTR</text><text x="195" y="140" transform="scale(.1)" textLength="270">PASTR</text><text x="615" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="410">^ UP ^</text><text x="615" y="140" transform="scale(.1)" textLength="410">^ UP ^</text></g></svg>
<?php else: ?>
<svg xmlns="http://www.w3.org/2000/svg" width="81" height="20"><linearGradient id="a" x2="0" y2="100%"><stop offset="0" stop-color="#bbb" stop-opacity=".1"/><stop offset="1" stop-opacity=".1"/></linearGradient><rect rx="3" width="81" height="20" fill="#555"/><rect rx="3" x="37" width="44" height="20" fill="#bfbfbf"/><path fill="#bfbfbf" d="M37 0h4v20h-4z"/><rect rx="3" width="81" height="20" fill="url(#a)"/><g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11"><text x="19.5" y="15" fill="#010101" fill-opacity=".3">PASTR</text><text x="19.5" y="14">PASTR</text><text x="58" y="15" fill="#010101" fill-opacity=".3">down</text><text x="58" y="14">down</text></g></svg>
<?php endif; ?>
