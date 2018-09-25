<?php 

$accise = $_GET['accise'];
?><!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Plateforme de mutualisation CNIV d'accès aux webservices douaniers CIEL</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="//www.24eme.fr/img/24eme.svg" alt="" width="172" height="172">
        <h1>Enregistrement SEED</h1>
<?php
if (!preg_match('/^FR...........$/', $accise)):
?>
</div>
<center>
<form method="GET">
    <label>Numéro d'accise&nbsp;: &nbsp;</label><input name="accise"/>
    <input class="btn btn-success" type=submit value="Interroger"/>
</form>
</center>
</div></body></html>
<?php
	exit;
endif;



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://pro.douane.gouv.fr/seedWS/SeedWS");
curl_setopt($ch, CURLOPT_POST, 1);
$data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.seed.douane.finances.gouv.fr/"><soapenv:Header/><soapenv:Body><ws:getInformation><numAccises><numAccise>';
$data .= $accise;
$data .= '</numAccise></numAccises></ws:getInformation></soapenv:Body></soapenv:Envelope>';
//echo $data;exit;
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //Post Fields
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Content-Type: text/xml;charset=UTF-8',
    'SOAPAction: getInformation',
    'Content-length: '.strlen($data)
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = preg_replace('/<\/root>.*/', '</root>', preg_replace('/.*<\/uid>/', '<root>', curl_exec ($ch)));

curl_close ($ch);

$xml = simplexml_load_string($server_output);
$json = json_encode($xml);
$array = json_decode($json,TRUE);
?>
<h2>Accise n°&nbsp;<?php echo $accise; ?></h2>
	</div>
<center><div style="width: 750px">
<?php
foreach($array as $k => $v) {
	echo '<h3>'.$k.'</h3>';
	echo '<table class="lead table">';
	foreach($v as $f => $fv) {
		echo '<tr><th style="vertical-align:top">'.$f.':</th><td>';
		if (is_string($fv)){
			echo $fv;
		}else{
                        foreach ($fv as $null => $complex) {
			echo "<p>";
			foreach ($complex as $attr => $value) if ($attr != '@attributes') {
				echo($value."<br/>");
			}
			echo "</p>";
			}
		}
		echo '</td></tr>';
        }
	echo '</table>';

}
?>
</div></center>
</div>
</body>

