<?php
  $config = json_decode(file_get_contents('../config/config.json'),true);
  $plateformes = $config['plateformes'];
  $appli = null;
  if(isset($_FILES['csv']) && isset($_POST['appli'])):
        $appli = $_POST['appli'];
        $url = $plateformes[$appli]['url'];
        $userpwd = $plateformes[$appli]['userpwd'];
        $data = file_get_contents($_FILES['csv']['tmp_name']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Content-Type: text/csv',
            'Content-length: '.strlen($data),
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        $isValid = false;
        $csv_retour = str_getcsv($response,"\n");
        foreach ($csv_retour as $num_row => $row) {
          $data_r = explode(";",$row);
          if(count($data_r) && preg_match("/^OK$/", $data_r[0])){
            $isValid = true;
          }
        }
        curl_close ($ch);
?>
<!doctype html>
<html lang="fr_FR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Test du web service DRM - Résultat</title>
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="py-9 text-center">
            <img class="d-block mx-auto mb-4" src="//www.24eme.fr/img/24eme.svg" alt="" width="172" height="172">
            <?php if($isValid): ?>
              <h3 class="text-success text-center">Le fichier est correct et peut être importé</h3>
            <?php else: ?>
              <h3 class="text-danger text-center">Le fichier comporte des problèmes et ne peut pas être importé :</h3>
            <?php endif; ?>
            </div>
            <br/>
            <div class="row justify-content-sm-center">
              <?php if(count($csv_retour) > 2 && $isValid): ?>
              <div class="col-md-12">
                <div class="row">
                  <p>Il y a cependant des points d'attention : </p>
                </div>
              </div>
              <?php endif; ?>
                <div class="col-md-12">
                  <div class="row">
                    <?php if(count($csv_retour) > 2): ?>
                    <table class="table table-striped">
                      <?php
                      foreach ($csv_retour as $num_row => $row):
                        $data_r = explode(";",$row);
                        if(!$num_row): ?>
                        <thead>
                          <tr>
                            <?php foreach ($data_r as $key => $val): ?>
                               <th scope="col"><?php echo $val; ?></th>
                            <?php endforeach; ?>
                          </tr>
                        </thead>
                        <tbody>
                      <?php elseif(!preg_match("/^OK$/", $data_r[0])):
                        ?>
                        <tr>
                          <?php foreach ($data_r as $key => $val): ?>
                             <td class="<?php if(!$key && ($val == "Error")): ?>text-danger<?php endif;?><?php if(!$key && ($val == "Warning")): ?>text-warning<?php endif;?>" ><?php echo $val; ?></td>
                          <?php endforeach; ?>
                        </tr>
                      <?php endif;
                     endforeach;
                     ?>
                      </tbody>
                    </table>
                  <?php endif; ?>
                  </div>
                  <hr/>
                  <div class="row">
                    <p><center><a  href="<?php echo $config["doc"]; ?>">Consulter la documentation générale</a></center></p>
                    <p><center><a  href="<?php echo $plateformes[$appli]['doc']; ?>">la documentation spécifique pour <?php echo $appli; ?></a></center></p>
                  </div>
                  <br/>
                  <div class="row">
                  <a class="btn btn-secondary btn-block" href="/tools/edi_drm.php">Retour</a>
                  </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
exit;
endif;
?>
<!doctype html>
<html lang="fr_FR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Test du web service DRM</title>
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="//www.24eme.fr/img/24eme.svg" alt="" width="172" height="172">
            <h1>Test du web service DRM</h1>
            </div>
            <div class="row justify-content-sm-center">
                <div class="col-md-6">
                <form method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="domaine" class="col-sm-4 col-form-label">Plateforme</label>
                    <div class="col-sm-8">
                        <select class="form-control"  name="appli">
                          <?php foreach ($config["plateformes"] as $applik => $appliv) : ?>
                            <option value="<?php echo $applik; ?>"><?php echo $applik; ?></option>
                          <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="csv" class="col-sm-4 col-form-label">Fichier CSV</label>
                    <div class="col-sm-8">
                        <input type="file" name="csv" class="form-control-file" id="csv">
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-8">
                        <button class="btn btn-success btn-block">Valider et Tester</button>
                    </div>
                </div>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>
