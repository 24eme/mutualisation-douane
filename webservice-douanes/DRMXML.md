#WebSerice DRM XML

Un format XML a été proposé par la douane pour transférer les informations relatives aux DRM douanières.

Le format est décrit dans un [Contrat de service](DRMXML/contrat_de_service_interpro.md).

Ce XML doit être envoyé via une requête **HTTP POST** via une liaison [PASTER Garanti](PASTER.md). Le XML doit être encodé en **UTF8** (indiqué via l'entête *Content-Type: application/xml;charset=UTF-8*).

Afin d'identifier l'interpro réalisant le transfert, une entête d'authentification [JWT](JWT.md) doit être fourni (via l'entête *Authorization: Bearer*).

Url de qualification : http://10.253.161.5/cielqualifinterpro/ws/1.0/declarations

Url de production : http://10.253.161.5/cielinterpro/ws/1.0/declarations

Voici un exemple de requête HTTP réalisant ce transfert (ici sur l'instance de qualification de la douane) :

    POST /cielqualifinterpro/ws/1.0/declarations HTTP/1.1
    Host: 10.253.161.5
    Accept: */*
    Content-Type: application/xml;charset=UTF-8
    Authorization: Bearer XXXXXXXXXXX.XXXXXXXXXXXXXXXXXXXXXX.XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXx
    Content-Length: XXX
    <?xml version="1.0" encoding="utf-8" ?>
    <message-interprofession xmlns="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0 echanges-interprofession-1.7.xsd">
    	<siren-interprofession>000000000</siren-interprofession>
    	<declaration-recapitulative>
    		<identification-declarant>
     			<numero-agrement>FR000000000</numero-agrement>
    			<numero-cvi>0000000000</numero-cvi>
    		</identification-declarant>
    		<periode>
    			<mois>MM</mois>
    			<annee>AAAA</annee>
    		</periode>
    		<declaration-neant>false</declaration-neant>
    		<droits-suspendus>
    			<produit>
    				<code-inao>1B0000 </code-inao>
    				<libelle-personnalise>Mon produit</libelle-personnalise>
                                <observations> Mes Observations </observations>
    				<balance-stocks>
    					<stock-debut-periode>307.1100</stock-debut-periode>
    					<sorties-periode>
    						<ventes-france-crd-suspendus>
    							<annee-courante>5.8000</annee-courante>
    						</ventes-france-crd-suspendus>
    					</sorties-periode>
    					<stock-fin-periode>301.3100</stock-fin-periode>
    				</balance-stocks>
    			</produit>
    	<compte-crd>
      		<categorie-fiscale-capsules>T</categorie-fiscale-capsules>
      		<type-capsule>COLLECTIVES_DROITS_SUSPENDUS</type-capsule>
      		<centilisation volume="CL_75">
        		<stock-debut-periode>11530</stock-debut-periode>
        		<entrees-capsules>
    				<achats>5000</achats>
        		</entrees-capsules>
        		<sorties-capsules>
    				<utilisations>3261</utilisations>
    				<destructions>10</destructions>
        		</sorties-capsules>
        		<stock-fin-periode>13259</stock-fin-periode>
      		</centilisation>
      		<centilisation volume="BIB_300">
        		<stock-debut-periode>118</stock-debut-periode>
        		<sorties-capsules>
    				<utilisations>15</utilisations>
    				<manquants>4</manquants>
         		</sorties-capsules>
        		<stock-fin-periode>99</stock-fin-periode>
      		</centilisation>
    	</compte-crd>
    	<compte-crd>
      		<categorie-fiscale-capsules>M</categorie-fiscale-capsules>
      		<type-capsule>COLLECTIVES_DROITS_SUSPENDUS</type-capsule>
      		<centilisation volume="CL_75">
        		<stock-debut-periode>1515</stock-debut-periode>
        		<entrees-capsules>
    				<achats>1000</achats>
        		</entrees-capsules>
        		<sorties-capsules>
    				<utilisations>644</utilisations>
    				<destructions>3</destructions>
           		</sorties-capsules>
        		<stock-fin-periode>1868</stock-fin-periode>
      		</centilisation>
    	</compte-crd>
   	</declaration-recapitulative>
    </message-interprofession>

Le webservice des douanes peut répondre positivement de la manière suivante :

    HTTP/1.1 200 OK
    Date: Fri, 01 Jan 2016 00:00:00 GMT
    Server: Apache
    Vary: Accept-Encoding
    Transfer-Encoding: chunked
    Content-Type: application/xml
    
    <?xml version="1.0" encoding="UTF-8" standalone="yes"?><reponse-ciel xmlns="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0"><identifiant-declaration>9999999</identifiant-declaration><horodatage-depot>2016-01-01T00:00:00.000+02:00</horodatage-depot></reponse-ciel>

Le XML de retour peut également retourner des erreurs du type :

    <?xml version="1.0" encoding="UTF-8" standalone="yes"?><reponse-ciel xmlns="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0"><erreurs-fonctionnelles><erreur-fonctionnelle code-erreur="004"><message-erreur>Le portail interprofessionnel émetteur ne correspond pas au portail de référence de l'interprofession d'appartenance pour ce numéro d'agrément.</message-erreur></erreur-fonctionnelle></erreurs-fonctionnelles></reponse-ciel>
