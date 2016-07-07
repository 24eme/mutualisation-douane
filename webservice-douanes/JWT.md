#Webservice d'authentification JWT

Pour permettre aux interprofessions de pouvoir envoyer des DRM pour le compte de leurs ressortissant, les dounes ont mis en place un service d'authentification basé sur le protocol JWT.

De nombreuses implémentations sont disponibles pour ce protocole. Elles sont référencées sur le site [jwt.io](http://jwt.io/). Ce site offre également un outil permettant de valider les messages échangés.

Ce protocole est basé sur l'exploitation de messages signés via un mecanisme de clés privée/publique souvent réunies en certificat. Pour l'implémentation douanière, un certificat PKI X509 RGS une étoile est nécessaire.

## Acquisition d'un certificat RGS une étoile

Pour acquérir un certificat RGS une étoile, il faut s'adresser à l'une des autorités de certification reconnue. Voici les listes des entreprises fournissant des certificats avec ce niveau de sécurité :
 - [ChamberSign](http://www.chambersign.fr/certificat-rgs-initio/) : entreprise associée aux CCI, les documents sont donc déposables dans la CCI de sa région ;
 - [Certinomis](https://www.certinomis.fr/nos-solutions/lidentite-professionnelle/offre-elementaire-rgs-1-etoile)
 - votre banque

La livraison de ce certificat se fait généralement par mail en 48h. Il se matérialise par un fichier ``keychain_access/pkcs12`` ayant pour extension ``.p12``. Ce fichier contient deux informations :
 - votre certificat (contenant votre clé publique signée par l'autorité de certification) ;
 - la clée privée associée à votre certificat.

Comme la clée privée est une information confidentielle qui ne doit pas être partagée le fichier ``pkcs12`` est normalement protégé par un mot de passe qui vous est fourni par votre organisme de certification.

## Extraire le certificat p12 de votre navigateur

Certaines autorité de certification installe directement les certificats dans le navigateur au lieu de fournir un fichier p12 par email.

Dans ce cas, allez dans les préférences de votre navigateur pour « Sauvegarder » le fichier (sous firefox, « Préférence » puis « Avancé » puis « Certificats » puis « Voir les certificats », dans l'onglet « Vos certificats », cliquez sur le certificat puis sur le bouton « Sauvegarder »). Le navigateur vous demande alors un mot de passe pour protéger la clé privée qui sera incluse dans le fichier.

## Extraire les certificats du fichier p12

La suite [OpenSLL](https://www.openssl.org/) permet assez facilement d'exploiter les fichiers ``p12`` et notamment d'en extraire les deux certificats ainsi que la clée privée.

Il faut d'abord convertir le fichier ``pkcs12`` au format ``pem``. Vu que le fichier original est protégé par un mot de passe, openssl vous demandera un mot de passe. Le fichier ``pem`` contiendra la clée, openssl vous demandera donc par deux fois un mot de passe pour protéger cette clée :

    $ openssl pkcs12 -in certificats.p12 -out certificats.pem
    Enter Import Password: <entrer ici le mot de passe du fichier p12>
    MAC verified OK
    Enter PEM pass phrase: <indiquer ici le mot de passe que vous souhaitez pour le fichier pem>
    Verifying - Enter PEM pass phrase: <confirmer ici le mot de passe souhaité pour le fichier pem>

Le fichier produit aura la forme suivant :

    -----BEGIN ENCRYPTED PRIVATE KEY-----
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    ...
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXX
    -----END ENCRYPTED PRIVATE KEY-----
    Bag Attributes
    friendlyName: MON ORGANISATION
    localKeyID: XX XX XX XX XX XX XX XX XX XX XX XX XX XX XX XX XX XX XX XX
    subject=/C=FR/O=MOI OU MON ORGANISATION
    issuer=/C=FR/O=MON ORGANISATION/OU=XXXXXXXXXXXXX/CN=XXXXXXXXXXXXXXXX
    -----BEGIN CERTIFICATE-----
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    ...
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    YYYYYYYYYYY
    -----END CERTIFICATE-----

Certaines autorités de certification intègrent leur propre certificat dans ce cas, il y aura deux sections certificates (en général, le certificat de l'autorité de certificat est la première) :

    Bag Attributes: <No Attributes>
    subject=/C=FR/O=NOM AUTORITÉ/OU=MON AUTORITÉ/CN=XXXXXXXXXXXX
    issuer=/C=FR/O=XXXXX/OU=XXXXXXXXX/CN=XXXXXXX
    -----BEGIN CERTIFICATE-----
    ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    ...
    ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    ZZZZZZZZZZZZZZZZZZZZZZZZ
    -----END CERTIFICATE-----

Copier/coller chacune des sections PEM dans des fichiers ditincts, on aurait donc :

 - certificat-client.crt ayant pour contenu :

    -----BEGIN CERTIFICATE-----
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    ...
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY
    YYYYYYYYYYY
    -----END CERTIFICATE-----

 - cleprivee-client.pem

    -----BEGIN ENCRYPTED PRIVATE KEY-----
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    ...
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXX
    -----END ENCRYPTED PRIVATE KEY-----

Si vous souhaitez stocker la clée privée sans protection par mot de passe, vous pouvez la convertir via la commande :

    openssl

En plus de votre certificat client, vous devrez fournir aux douanes le fichier de révocation émis par l'autorité de certification que vous avez choisi. Sa localiation est en générale indiquée dans le certificat. Pour le lire :

    $ openssl x509 -in certificat-client.crt -text | grep crl
                      URI:http://crl.chambersign.fr/crl/rgs/lcr-directes/crl-1.crl

## Envoi de certificat et du crl aux dounaes

Pour avoir accès au webservice d'authentification JWT, il faut envoyer deux fichiers aux douanes :
 - le certificat X509 RGS* (*certificat-client.crt*) dans notre exemple ;
 - le fichier de révocation émis par l'autorité de certification.

L'url du fichier de révocation est en général cité dans le certificat. Voici une commande openssl qui permet de visualiser cette information :

Sa localiation est en générale indiquée dans le certificat. Pour le lire :

    $ openssl x509 -in certificat-client.crt -text | grep -A 5 crl
            X509v3 CRL Distribution Points: 

                Full Name:
                  URI:http://crl.chambersign.fr/crl/rgs/lcr-directes/crl-1.crl

Une fois que ces deux fichiers installés, les douanes fournirront un identifiant ``ISS`` qui permettra d'associer la requête d'authentification à votre interprofession.

## Tester la bonne configuration du service JWT

Une fois le numéro ISS installé et à condition qu'un accès [PASTER](PASTER.md) soit opérationel, il est possible d'obtenir un token JWT afin de pouvoir s'authentifier auprès du webservice.

Un script PHP de test a été développé afin de valider l'accès JWT douanier : [OAuth](https://github.com/24eme/mutualisation-douane/tree/master/oauth). Pour pouvoir l'exploiter, il faudra copier le contenu de la clée privée et indiquer l'identifiant ``ISS`` dans le fichier de configuration ``config.inc``.
