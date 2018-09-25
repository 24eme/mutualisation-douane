# Détail du WebService SOAP SEED

Le WebService SEED est un webservice des douanes qui permet de connaitre les informations relatives à un numero d'accise.

Il répond au protocol HTTP/SOAP dont le WSDL est disponible à l'adresse [https://pro.douane.gouv.fr/seedWS/SeedWS?wsdl](https://pro.douane.gouv.fr/seedWS/SeedWS?wsdl)

La méthode ``getInformation`` permet de connaitre les produits autorisée pour un numéro d'accise ainsi que sa localisation.

SOAP impose que le nom de la méthode soit fourni dans l'entête de la requête HTTP là où les parametres passent en information POST sous la forme d'un XML.

## Implémentation publique du WebService

[http://cniv.24eme.fr/tools/SEED.php](http://cniv.24eme.fr/tools/SEED.php)

##  Exemple de requête via curl

Voici un exemple d'implémentation avec la commande unix ``curl`` :

    $ curl --header "Content-Type: text/xml;charset=UTF-8" \
           --header "SOAPAction: getInformation" \
           --data @getInformation.xml \
           https://pro.douane.gouv.fr/seedWS/SeedWS 

où le fichier ``getInformation.xml`` contient :

    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.seed.douane.finances.gouv.fr/">
    <soapenv:Header/>
    <soapenv:Body>
    <ws:getInformation>
    <numAccises>
    <numAccise>FR00000000001</numAccise>
    </numAccises>
    </ws:getInformation>
    </soapenv:Body>
    </soapenv:Envelope>

##  Résultat de la requête HTTP

Ce qui produit la requête HTTP suivante :

    POST /seedWS/SeedWS HTTP/1.1
    Host: pro.douane.gouv.fr
    User-Agent: curl/7.47.0
    Accept: */*
    Content-Type: text/xml;charset=UTF-8
    SOAPAction: getInformation
    Content-Length: 210
    
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.seed.douane.finances.gouv.fr/">
    <soapenv:Header/>
    <soapenv:Body>
    <ws:getInformation>
    <numAccises>
    <numAccise>FR00000000001</numAccise>
    </numAccises>
    </ws:getInformation>
    </soapenv:Body>
    </soapenv:Envelope>

##  Le document retourné par le webservice

En réponse, le serveur fourni les informations relatives à ce numéro d'accise :

    <?xml version="1.0" ?><S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
    <S:Body><ns2:getInformationResponse xmlns:ns2="http://ws.seed.douane.finances.gouv.fr/">
    <root>
      <uid>xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</uid>
      <traderAuthorisation>
        <traderExciseNumber>FR00000000001</traderExciseNumber>
        <vatNumber>FR00000000001</vatNumber>
        <authorisationBeginDate>1970-01-01</authorisationBeginDate>
        <country>FR</country>
        <operatorTypeCode>1</operatorTypeCode>
        <referenceNumberOfExciseOffice>FR000001</referenceNumberOfExciseOffice>
        <exciseProduct>
          <exciseProductCode>W200</exciseProductCode>
          <exciseProductCode>W300</exciseProductCode>
          <exciseProductCode>X000</exciseProductCode>
          <exciseProductCode>X001</exciseProductCode>
          <exciseProductCode>X002</exciseProductCode>
        </exciseProduct>
        <usingTaxWarehouse><referenceOfTaxWarehouse>FR00000000001</referenceOfTaxWarehouse></usingTaxWarehouse>
        <addresses><address lang="fr">
          <name>EARL XXXX XXXX</name>
          <streetName>Rue XXXXXXXXXXX</streetName>
          <streetNumber>1</streetNumber>
          <postCode>XXXXX</postCode>
          <city>XXXXXXXXXX</city>
          <countryCode>FR</countryCode>
        </address></addresses>
      </traderAuthorisation>
    </root></ns2:getInformationResponse>
    </S:Body></S:Envelope>

##  Erreur connue

###  Erreur 500

Si la requête HTTP/SOAP/XML est malformée ou si tous les attributs d'une balise ne sont pas sur la même ligne, le serveur renvoie l'erreur 500 enigmatique suivante :

    HTTP Status 500 - type Status report
    
    message:

    description: The server encountered an internal error () that prevented it from fulfilling this request.

###  WSDL en HTTPS

Contrairement à ce qu'indique le WSDL, l'accès à ce webservice se réalise en HTTPS. Certaines librairies se fiant aux informations publiées par le WSDL échoueront dans l'envoi de leurs requêtes. Il faut donc réécrire l'url contenu dans la description du service de http:// en https://
