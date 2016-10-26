#Accès aux fichiers XML DRM via le serveur de mutualisation douane

Les fichiers reçus de la douane sont mis à disposition à travers une arborescence HTTP accessible aux partenaires du projet CNIV mutualisation Douane.

Pour y avoir accès, il faut un accès OpenVPN.

L'accès OpenVPN va permettre à chaque interpro d'être identifiée via une adresse IP.

## Découverte de son adresse IP sur le VPN

Pour connaitre l'adresse IP qui vous est attribuée, une url est mise à votre disposition : http://10.222.223.1/myip.php

     $ curl http://10.222.223.1/myip.php
     10.222.223.XXX

Pour avoir accès aux XML reçus de la douane, il faut réaliser une demande auprès de l'équipe vins d'Actualys en leur fournissant cette adresse ip.

## Accès aux fichiers XML

L'accès aux fichiers XML reçus de la plateforme ProDou@ne doit se faire via une arborescence qui répond au schéma suivant :

    http://10.222.223.1/reception_douanes/<SIREN_INTERPRO>/<ANNEE_DRM>/<MOIS_DRM>/<ACCISE_RESSORTISANT>_<NOMBRE>_<DATE_DEPOT>.xml

Voici un exemple d'url :

    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160901.xml

Pour accéder aux XML transmis en préproduction, l'url change légèrement. ``reception_douanes`` doit être changé par ``reception_douanes_PP`` :

    http://10.222.223.1/reception_douanes_PP/123456789/2016/08/FR123456E1234_1234567_20160901.xml

## Listing des DRM reçues

En interrogeant les répertoires de l'arborescence, il est possible d'avoir un listing des XML qui s'y trouvent :

    $ curl http://10.222.223.1/reception_douanes/123456789/2016/08/
    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160914.xml
    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160906.xml

Ce mécanisme fonctionne pour tous les répertoires à partir de celui représentant le SIREN de l'interpro :

    $ curl http://10.222.223.1/reception_douanes/123456789/
    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160914.xml
    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160906.xml
    http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml
    http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml

Par defaut, l'application retourne les fichiers reçus depuis les 30 derniers jours.

Il est possible de passer deux parametres GET à ces requêtes :

 - ``from`` indique à partir de quelle date on souhaite récupérer la liste des fichiers. La date doit être indiquée au format ISO-8601 (AAAA-MM-JJ)
 - ``format`` permet de demander une sortie dans un format XML

 Il est donc possible d'obtenir en XML la liste des DRM reçues depuis le 1er janvier 2016 :

     $curl http://10.222.223.1/reception_douanes/123456789/?from=2016-01-01&format=xml
     <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
     <list>
     <url>http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160914.xml</url>
     <url>http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160906.xml</url>
     <url>http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml</url>
     <url>http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml</url>
     </list>

Ou plus simplement la liste des DMR reçues depuis le 1er octobre 2016 :

    $ curl http://10.222.223.1/reception_douanes/123456789/?from=2016-10-01
    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160914.xml
    http://10.222.223.1/reception_douanes/123456789/2016/08/FR123456E1234_1234567_20160906.xml
    http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml
    http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml

## Questions frequement posées

### Comment savoir quand a été reçue une DRM ?

Chaque fichier XML est daté sur le serveur à la date de sa reception. En interrogeant l'entête HTTP ``Last-Modified``, il est donc possible d'obtenir cette information :

    $ curl -s -D /dev/stderr http://10.222.223.1/reception_douanes/123456789/2016/09/FR123456E1234_1234567_20160914.xml
    HTTP/1.1 200 OK
    Date: Wed, 26 Oct 2016 16:50:30 GMT
    Server: Apache
    Last-Modified: Fri, 21 Oct 2016 14:57:14 GMT
    ...
