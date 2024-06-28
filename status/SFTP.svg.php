<?php

header('Content-Type: image/svg+xml');

$stats = file("http://10.222.223.1/stats/DRMjour.csv");

$cpt = 0;
for($i = count($stats) -1 ; $i > count($stats) - 5 ; $i--) {
	$ligne = explode(';', $stats[$i]);
	if( ($ligne[0] == date('Y-m-d')) && ($ligne[1] == 'SFTP archives reçues') ) {
		$cpt = $ligne[2] * 1;
		last;
	}
}

if ($cpt || date('H') < 7):
 ?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="88" height="20"><linearGradient id="b" x2="0" y2="100%"><stop offset="0" stop-color="#bbb" stop-opacity=".1"/><stop offset="1" stop-opacity=".1"/></linearGradient><clipPath id="a"><rect width="88" height="20" rx="3" fill="#fff"/></clipPath><g clip-path="url(#a)"><path fill="#555" d="M0 0h37v20H0z"/><path fill="#4c1" d="M37 0h51v20H37z"/><path fill="url(#b)" d="M0 0h88v20H0z"/></g><g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="110"><text x="195" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="270">SFTP</text><text x="195" y="140" transform="scale(.1)" textLength="270">SFTP</text><text x="615" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="410"><?php echo $cpt; ?> reçus</text><text x="615" y="140" transform="scale(.1)" textLength="410"><?php echo $cpt; ?> reçus</text></g></svg>
<?php else: ?>
<svg xmlns="http://www.w3.org/2000/svg" width="81" height="20"><linearGradient id="a" x2="0" y2="100%"><stop offset="0" stop-color="#bbb" stop-opacity=".1"/><stop offset="1" stop-opacity=".1"/></linearGradient><rect rx="3" width="81" height="20" fill="#555"/><rect rx="3" x="37" width="44" height="20" fill="#e05d44"/><path fill="#e05d44" d="M37 0h4v20h-4z"/><rect rx="3" width="81" height="20" fill="url(#a)"/><g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11"><text x="19.5" y="15" fill="#010101" fill-opacity=".3">SFTP</text><text x="19.5" y="14">SFTP</text><text x="58" y="15" fill="#010101" fill-opacity=".3">échec</text><text x="58" y="14">0 reçu</text></g></svg>
<?php endif; ?>
