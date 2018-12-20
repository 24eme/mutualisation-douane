<?php if(isset($_FILES['csv'])):
        $data = file_get_contents($_FILES['csv']['tmp_name']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://url_edi/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Content-Type: text/csv',
            'Content-length: '.strlen($data),
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        print_r($response);

	curl_close ($ch);

	exit;
endif; ?>
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
                        <select class="form-control">
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
