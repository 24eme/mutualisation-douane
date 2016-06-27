##Test du JWT des douanes

Pour configurer la démo :

     cp config.inc.example config.inc

Puis éditer le fichier.

Pour faire fonctionner la démo :

     php oauth_qualif.php

Qui donne comme résultat :

    JWT String : 
    eyJhbGciOiJSUzI1NiJ9.eyJpc3MiOiI2ZTBmZmE5OC0zYzYxLTExZTYtODYzOS1lNDFmMTM0NDc5NGNiIiwic2NvcGUiOiJodHRwOi8vMTAuMjUzLjE2MS41L2NpZWxxdWFsaWZpbnRlcnByby93cy8xLjAvZGVjbGFyYXRpb25zIiwiYXVkIjoiaHR0cDovLzEwLjI1My4xNjEuNS9hdXRodG9rZW5xdWFsaWYvb2F1dGgyL3YxIiwiaWF0IjoiMTQ2NzA1NTYwNjAwMCJ9.sczpQC-D8zyQ9i2TiwHaR0l02XGQcLUZ8ENsAWqj7dEM1IGHm8UUAPnoRERcZYLdg19DEige9yWoPGPZyPS_zBhcoWYU1f-BXkDHfQ77X0k6ZRa5-5KHL1nmNv2DV_gj6lKWzBQVM7BxehpUTVkEtiy3Dm1Hk5rq7M_mEuPp8V7GMKO06pb6t66MZgst2YNosbgPoC-D2kny_AyMttoYof6MxeUl_Dcy1CQvX6aqc1Co0Q6O84Lwc6VHj5EnIqM_LFKkhvl4lWbn7UHF4wQdxL43kos292jqi4oi8lYNnnQ91llccx3Bb0XbArymeuH0IfFEqC39kEE1i9IcMxHGzg

    JWT answer: 
    {"timestamp":1467055606688,"status":500,"error":"Internal Server Error","exception":"fr.gouv.finances.douane.apps.oauth.server.error.UnparsableJWTException","message":"assertion not parsable","path":"/authtokenqualif/oauth2/v1/token"}


La requete HTTP envoyée est la suivante :

    POST /authtokenqualif/oauth2/v1/token HTTP/1.1
    Connection: close
    Content-Length: 695
    Host: 10.253.161.5
    Content-Type: application/x-www-form-urlencoded

    grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion=eyJhbGciOiJSUzI1NiJ9.eyJpc3MiOiI2ZTBmZmE5OC0zYzYxLTExZTYtODYzOS1lNDFmMTM0NDc5NGNiIiwic2NvcGUiOiJodHRwOi8vMTAuMjUzLjE2MS41L2NpZWxxdWFsaWZpbnRlcnByby93cy8xLjAvZGVjbGFyYXRpb25zIiwiYXVkIjoiaHR0cDovLzEwLjI1My4xNjEuNS9hdXRodG9rZW5xdWFsaWYvb2F1dGgyL3YxIiwiaWF0IjoiMTQ2NzA1NTY4NDAwMCJ9.Ym1x3pD7HIQ4TYdBb36caynaADXvZFHx2vqQbmiLbvG6TmIVkPYKFo6yDiHqrZddYf5LuWC_X31uTYfGPWu3SNCmfKl8JjPHcp5Z9iFtDtx_tKK-DTgp4O4U8Z2LeR-o8lwZXAuOj0o44eXww7Kep-KDBvCbVAZm-QWXgmLLfZpPwfhRuCmwkQBHW3sgqAJXNqxHjMZx3T7CyVcHuY8Jr-TKHc7sa5S9eX2GFk1-5nCG82a7YQ88PQeYuEtllAU3vxk0zp-8c9u7Ixk5usxX6IoiIdjc5ePnbSqhKycZCMwwd2dKcmOx5yPAGi2EVrZ5q-u5fIaowmb-2MLN3Xq0Tw

