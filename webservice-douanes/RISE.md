# Réseau RISE

La douane migre son réseau vers un nouveau réseau.

Une migration est en cours. Cette page permet de suivre l'état de cette migration.

## Etapes de la migration

| Etape                              | Statut        |
|------------------------------------|---------------|
| Demande de ligne                   | OK            |
| Mise en place de la ligne IPSec    | OK            |
| Recette des webservices CIEL       | OK            |
| Recette CFT                        | En cours      |

## Élements de diagnostiques 

### Recette ligne (ping)

    ping -c 1  194.250.56.185

### Accès services Gama (smtp)

    echo QUIT | nc 194.250.56.186 smtp

### Accès webservices CIEL

Interco réseau PASTEUR :

  - ping http sur l'un des webservice de la machine

    ``curl -m 1 http://10.253.161.5/authtokenqualif/oauth2/v1/ping``

Webservices réseau RISE :

 - préprod jwt :

    ``curl -m 1 http://10.124.131.1/authtoken/oauth2/v1/ping``

 - préprod ciel :

    ``curl -m 1 http://10.124.131.3/cielinterpro/ws/1.0/declarations``

    (une erreur est retournée par cette url, c'est normal)

 - prod jwt :

    ``curl -m 1 http://10.124.111.12/authtoken/oauth2/v1/ping``

 - prod ciel :

    ``curl -m 1 http://10.124.111.3/cielinterpro/ws/1.0/declarations``

    (une erreur est retournée par cette url, c'est normal)

