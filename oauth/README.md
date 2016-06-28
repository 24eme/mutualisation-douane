##Test du JWT des douanes

Pour configurer la démo :

     cp config.inc.example config.inc

Puis éditer le fichier.

Pour faire fonctionner la démo :

     php oauth_qualif.php

Qui donne comme résultat :

    JWT String : 
    eyJhbGciOiJSUzI1NiJ9.eyJpc3MiOiI2ZTBmZmE5OC0zYzYxLTExZTYtODYzOS1lNDFmMTM0NDc5NGMiLCJzY29wZSI6Imh0dHA6Ly8xMC4yNTMuMTYxLjUvY2llbHF1YWxpZmludGVycHJvL3dzLzEuMC9kZWNsYXJhdGlvbnMiLCJhdWQiOiJodHRwczovL2RvdWFuZS5maW5hbmNlcy5nb3V2LmZyL29hdXRoMi92MS9hdXRoIiwiaWF0IjoxNDY3MDk5Nzg2MDAwfQ.K-86s5IQRQ4ZMlryvpC2Mqv-K728vLIiK_tyOoJZl9rnxBFoDhEN4GwhTc7Pph1XUjpeSwF1BGw0a4PUueosp-tZZjoT4hLUdrrtyVrk4aY04N24xArrwcbyb1RXWpXVecWVGfc7aAY1OgydWcpKtSjT-ure-JZOeP55J2lLyhIeLwleFj6mXwYErENN1MgClXn6U8yBpWNk_NLj3UueJIBVvk5GJvmIexq5YguX426YqsmzvfDhvzxCe8gKfunQlDeNFvthQ5O5nvF2VFoBq6EoJcQR7ElNDJLyX35I7H2lZv8CnjXVkBT-wiOccb8v6zHYn-tT6DVHaxK-hIrTMQ

    JWT answer: 
    {"timestamp":"2016-06-28T09:43:06.42","error":"INVALID_CERTIFICATE","message":"invalid certificate"}


La requete HTTP envoyée est la suivante :

    POST /authtokenqualif/oauth2/v1/token HTTP/1.1
    Connection: close
    Content-Length: 695
    Host: 10.253.161.5
    Content-Type: application/x-www-form-urlencoded

    grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion=eyJhbGciOiJSUzI1NiJ9.eyJpc3MiOiI2ZTBmZmE5OC0zYzYxLTExZTYtODYzOS1lNDFmMTM0NDc5NGMiLCJzY29wZSI6Imh0dHA6Ly8xMC4yNTMuMTYxLjUvY2llbHF1YWxpZmludGVycHJvL3dzLzEuMC9kZWNsYXJhdGlvbnMiLCJhdWQiOiJodHRwczovL2RvdWFuZS5maW5hbmNlcy5nb3V2LmZyL29hdXRoMi92MS9hdXRoIiwiaWF0IjoxNDY3MDk5Nzg2MDAwfQ.K-86s5IQRQ4ZMlryvpC2Mqv-K728vLIiK_tyOoJZl9rnxBFoDhEN4GwhTc7Pph1XUjpeSwF1BGw0a4PUueosp-tZZjoT4hLUdrrtyVrk4aY04N24xArrwcbyb1RXWpXVecWVGfc7aAY1OgydWcpKtSjT-ure-JZOeP55J2lLyhIeLwleFj6mXwYErENN1MgClXn6U8yBpWNk_NLj3UueJIBVvk5GJvmIexq5YguX426YqsmzvfDhvzxCe8gKfunQlDeNFvthQ5O5nvF2VFoBq6EoJcQR7ElNDJLyX35I7H2lZv8CnjXVkBT-wiOccb8v6zHYn-tT6DVHaxK-hIrTMQ

