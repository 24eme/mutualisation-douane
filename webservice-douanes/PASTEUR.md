# Accès PASTEUR via le VPN CNIV

Les accès à la ligne spécialisée PASTEUR a été mutualisé grace à l'intervention du CNIV. Un serveur offrant un accès mutualisé à l'infrastructure des douanes a été mis en place. La technologie retenue est [OpenVPN](https://openvpn.net/), un projet libre de vpn logiciel qui supporte une dixaine de systèmes d'exploitation.

##  Éléments livrés

Lors de livraison de l'accès, une archive ZIP du fichier ``moninterpro.ovpn`` sera fourni. Il s'agit du fichier de configuration du client OpenVPN qui contient les informations nécessaires à la connexion OpenVPN :
 - le certificat contenant la clé publique permettant à l'OpenVPN de vous identifier ;
 - la clé privée permettant à l'OpenVPN de vous identifier ;
 - le certificat de l'autorité de certification qui a émis votre certificat ;
 - les éléments réseaux nécessaire à la connexion.

En plus de l'archive, un mot de passe seront donc fournis qui permettra de l'exploiter.

Pour obtenir ces informations, il suffit de s'adresser à <vins@24eme.fr>. Lors de cette demande, il est préférablei, afin de rendre l'accès directement opérationnel d'**adresser avec la demande l'adresse ip publique** qui sera utilisé par le client pour accéder à ce VPN afin que les flux soient ouverts chez l'hébergeur.

##  Lancer OpenVPN

Une fois ces quatres fichiers mis dans le même répertoire (ou après avoir modifié le fichier de configuration), vous pouvez lancer openvpn en y faisant référence. Sous un unix, la commande suivante permet de le faire :

    $ sudo openvpn --config moninterpro.opvn

La connexion s'établie correctement au moment où openvpn affiche le message ``Initialization Sequence Completed`` comme dans l'exemple suivant :

    Thu Jan  1 00:00:00 1970 OpenVPN X.Y.Z [SSL (OpenSSL)] [LZO] [EPOLL] [PKCS11] [MH] [IPv6] ...
    Thu Jan  1 00:00:00 1970 bla bla bla bla 
    [...]
    Thu Jan  1 00:00:00 1970 [vpn-cniv.msp.fr.clara.net] Peer Connection Initiated with [AF_INET]89.185.41.66:1194
    [...]
    Thu Jan  1 00:00:02 1970 bla bla bla bla
    Thu Jan  1 00:00:02 1970 Initialization Sequence Completed

Pour fonctionner, votre client OpenVPN doit pouvoir dialoguer avec le port **udp** ``1194`` à la machine ``vpn-cniv.msp.fr.clara.net``. Si les logs n'indiquent pas ``Peer Connection Initiated`` comme dans l'exemple ci-dessus, c'est que ce flux n'est pas autorisé.

##  Test de la connexion

Tant que votre client OpenVPN sera opérationnel, vous pourrez interroger le serveur du CNIV via l'url [http://10.222.223.1/](http://10.222.223.1/) qui renvoie pour l'instant un message « 403 FORBIDDEN ».

    $ curl http://10.222.223.1/
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    [...]

De même si les routes sont bien installées par OpenVPN, vous pourrez avoir accès à la machine des douanes [http://xxx.xxx.xxx.xxx/](http://xxx.xxx.xxx.xxx/) qui renvoie sur le portail ProDouane : 

    $ curl http://xxx.xxx.xxx.xxx/
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>302 Found</title>
    [...]

## Installation sous Windows

L'outil [OpenVPN GUI](https://community.openvpn.net/openvpn/wiki/OpenVPN-GUI) permet une installation simple d'un client OpenVPN.

Une fois qualifiée, l'installation peut être facilement installée comme service en suivant la documentation suivante : [Running OpenVPN as a Windows Service](https://openvpn.net/index.php/open-source/documentation/install.html?start=1#running_as_windows_service)

## Résolutions d'erreur

###  RESOLVE: Cannot resolve host address

Suite à l'installation d'un client OpenVPN, le serveur du CNIV est accessible, mais adresse des douanes qui tombe en erreur (``ERR_CONNECTION_TIMED_OUT``). Dans les logs produits par le client OpenVPN, on peut voir cette ligne :

    00:00:00 2016 RESOLVE: Cannot resolve host address: xxx.xxx.xxx.xxx 255.255.255.255: Hôte inconnu.

*Résolution* : Le problème rencontré est lié à la définition de route. L'instruction du fichier de configuration openvpn qui indique que les requêtes vers xxx.xxx.xxx.xxx doivent passées par la liaison VPN sont ignorées. En effet le client OpenVPN prend la chaine de caractère ``xxx.xxx.xxx.xxx 255.255.255.255`` comme un nom de domaine et non pour un ip suivi de son masque.

Il faut bien vérifier que le fichier de configuration du client OpenVPN contient une ligne ``route`` où l'ip ``xxx.xxx.xxx.xxx`` et le masque ``255.255.255.255`` ainsi que le réseau ``10.124.0.0`` et son netmask ``255.255.0.0`` sont bien renseignés sans guillemets et sans espace inséquable :

    route xxx.xxx.xxx.xxx 255.255.255.255
    route 10.124.0.0 255.255.0.0
 
 ### Cannont reach 10.XXX.XXX.XXX
 
Votre openvpn n'est pas configurer pour prendre en charge les connexions vers les réseaux douaniers. Il faut donc vérifier que le fichier de configuration est bien prévu pour cette prise en charge. Vous devriez y trouver les deux lignes suivantes :

    route xxx.xxx.xxx.xxx 255.255.255.255
    route 10.124.0.0 255.255.0.0

### Déconnexion régulière de l'OpenVPN

En général la déconnexion d'un openVPN Client peut avoir deux raisons :

 - les parametres de connexion qui vous ont été attribués sont utilisés par un autre client OpenVPN : si vous avez plusieurs clients openVPN, assurez vous que leurs paramètres (clés et ip) soient uniques et que notamment d'anciennes instances ne soient plus actives
 - OpenVPN n'est pas activité en mode démon, il se désactive donc à chaque déconnexion de l'utilisateur qui l'héberge. Voici une [documentation pour installer openvpn comme un service windows](https://openvpn.net/community-resources/running-openvpn-as-a-windows-service/)
