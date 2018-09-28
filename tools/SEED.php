<?php

$exciseProduct = array();
$exciseProduct['B000'] = "Bières";
$exciseProduct['I000'] = "Produits intermédiaires";
$exciseProduct['E200'] = "Graisses et Huiles animales et végétales Produits repris sous les codes NC 1507 à 1518, s'ils sont destinés à une utilisation comme combustible de chauffage ou carburant auto (Article 20(1)(a))";
$exciseProduct['E300'] = "Huiles minérales Produits repris sous les codes NC 2707 10, 2707 20, 2707 30 et 2707 50 (Article 20(1)(b))";
$exciseProduct['E410'] = "Essence plombée";
$exciseProduct['E420'] = "Essence sans plomb";
$exciseProduct['E430'] = "Gasoil, non marqué";
$exciseProduct['E440'] = "Gasoil, marqué";
$exciseProduct['E450'] = "Kérosène, non marqué";
$exciseProduct['E460'] = "Kérosène, marqué";
$exciseProduct['E470'] = "Fioul lourd";
$exciseProduct['E480'] = "2710 11 21, 2710 11 25 et 2710 19 29, en trafics commerciaux de vrac";
$exciseProduct['E490'] = "Produits repris sous les codes NC 2710 11 à 2710 19 69, non spécifiés plus haut";
$exciseProduct['E500'] = "Gaz de pétrole liquéfiés (LPG) Produits repris sous les codes NC 2711 (sauf 2711 11, 2711 21 et 2711 29)";
$exciseProduct['E600'] = "Hydrocarbures acycliques saturés Produits repris sous le code CN 2901 10";
$exciseProduct['E700'] = "Hydrocarbures cycliques Produits repris sous les codes NC 2902 20, 2902 30, 2902 41, 2902 42, 2902 43 et 2902 44";
$exciseProduct['E800'] = "Méthanol (alcool méthylique) Produits repris sous le code NC 2905 11 00, qui ne sont pas d'origine synthétique, s'ils sont destinés à une utilisation comme combustible de chauffage ou carburant auto";
$exciseProduct['S200'] = "Spiritueux";
$exciseProduct['S300'] = "Alcool éthylique";
$exciseProduct['S400'] = "Alcool partiellement dénaturé";
$exciseProduct['S500'] = "Autres produits contenant de l'alcool éthylique";
$exciseProduct['T200'] = "Cigarettes";
$exciseProduct['T300'] = "Cigares & cigarillos";
$exciseProduct['T400'] = "Tabac fine coupe pour la confection de cigarettes";
$exciseProduct['T500'] = "Autres tabacs à fumer";
$exciseProduct['W300'] = "Vin mousseux et boissons fermentées mousseuses autres que le vin et la bière";
$exciseProduct['E910'] = "Esters monoalkyliques d'acide gras contenant au moins 96,5 % en volume d'esters";
$exciseProduct['E920'] = "autres";
$exciseProduct['E930'] = "Additifs repris sous les codes 3811 11, 3811 19 00 et 3811 90 00";
$exciseProduct['W200'] = "Produits non effervescents";
$exciseProduct['X000'] = "Produits vitivinicoles (jus et moûts)";
$exciseProduct['X001'] = "Produits vitivinicoles (raisins, marcs et lies)";
$exciseProduct['X002'] = "Capsules CRD";
$exciseProduct['Y001'] = "Additifs pour carburants et combustibles";
$exciseProduct['Y002'] = "Additifs pour carburants et combustibles, contenant des huiles de pétrole ou de minéraux bitumeux";

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


    $data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.seed.douane.finances.gouv.fr/"><soapenv:Header/><soapenv:Body><ws:getInformation><numAccises><numAccise>';
    $data .= $accise;
    $data .= '</numAccise></numAccises></ws:getInformation></soapenv:Body></soapenv:Envelope>';
    if (isset($_GET['request']) && $_GET['request']) {
      echo "<div><pre>".htmlentities($data)."</pre></div>";
      exit;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://pro.douane.gouv.fr/seedWS/SeedWS");
    curl_setopt($ch, CURLOPT_POST, 1);
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

    if (isset($_GET['response']) && $_GET['response']) {
      echo "<div><pre>".htmlentities($server_output)."</pre></div>";
      exit;
    }


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
          $link = 0;
          if (preg_match('/^[A-Z][A-Z]......$/', $fv)) {
            echo '<a href="https://www.tarifdouanier.eu/bureaux/'.$fv.'">';
            $link = 1;
          }
          if (($f == 'vatNumber') && preg_match('/([A-Z][A-Z])(.*)/', $fv, $m)) {
            echo '<a href="http://ec.europa.eu/taxation_customs/vies/vatResponse.html?memberStateCode='.$m[1].'&number='.$m[2].'">';
            $link = 1;
          }
          echo $fv;
          if ($link) {
            echo '</a>';
          }

        }else{
          foreach ($fv as $null => $complex) {
            echo "<p>";
            foreach ($complex as $attr => $value) if ($attr != '@attributes') {
              if ( !is_array($value)) {
                echo $value;
                if ($f == 'exciseProduct') {
                  echo "<small class='text-muted'> - ".$exciseProduct[$value]."</small>";
                }
              }
              echo "<br/>";
            }
            echo "</p>";
          }
        }
        echo '</td></tr>';
      }
      echo '</table>';

    }
    ?>
    <p><a href="?" class="btn btn-secondary">Retour</a></p>
  </div></center>
</div>
</body>
