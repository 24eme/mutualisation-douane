# Accès PASTEUR via le VPN CNIV

Les accès à la ligne spécialisée PASTEUR a été mutualisé grace à l'intervention du CNIV. Un serveur offrant un accès mutualisé à l'infrastructure des douanes a été mis en place. La technologie retenue est [OpenVPN](https://openvpn.net/), un projet libre de vpn logiciel qui supporte une dixaine de systèmes d'exploitation.

##  Fichiers livrés

Lors de livraison de l'accès, une archive contenant quatre fichiers est mise à disposition :
 - ``moninterpro.ovpn`` : le fichier de configuration du client OpenVPN. Ce fichier fait référence aux trois autres fichiers, il convient donc de stocker tous ces fichiers dans le même répertoire ou d'éditer cette configuration pour faire référence au chemin absolu des fichiers ;
 - ``moninterpro.crt`` : le certificat contenant la clé publique permettant à l'OpenVPN de vous identifier ;
 - ``moninterpro.key`` : la clé privée permettant à l'OpenVPN de vous identifier. Cette clé est protégée par un mot de passe ;
 - ``ca.crt`` : le certificat de l'autorité de certification qui a émis votre certificat.

Le contenu de ces quatres fichiers sont protégés par un mot de passe. Pour les extraire, il vous sera demandé.

En plus de l'archive, deux mots de passe seront donc fournis :
 - celui permettant d'exploiter l'archive zip contenant les quatres fichiers ;
 - celui permettant de protéger la clé privée.

Pour obtenir ces fichiers, il suffit de s'adresser à <vins@actualys.com>. Lors de cette demande, il est préférablei, afin de rendre l'accès directement opérationnel d'**adresser avec la demande l'adresse ip publique** qui sera utilisé par le client pour accéder à ce VPN afin que les flux soient ouverts chez l'hébergeur.

##  Sécurité de la clé privée

Une fois la clé privée installée, si vous ne souhaitez pas saisir son mot de passe à chaque démarrage, il est possible de la stocker en clair. Toute fois procédez à cette opération en ayant conscience que ca réduit le niveau de sécurité de votre accès. Il ne faut donc pas transférer votre clé privée dans un fichier non chiffré. Avec toutes ces réserves, une fois sur le serveur, OpenSSL permet de déchiffrer ce fichier grace à la commande unix suivante :

    $ openssl rsa -in moninterpro.key  -out moninterpro.nocrypt.key

Si vous choisisez cette option, vous devez modifier le fichier de configuration ``moninterpro.ovpn`` en faisant référence au nouveau fichier (dans notre exemple ``moninterpro.nocrypt.key``).

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

De même si les routes sont bien installées par OpenVPN, vous pourrez avoir accès à la machine des douanes [http://10.253.161.5/](http://10.253.161.5/) qui renvoie sur le portail ProDouane : 

    $ curl http://10.253.161.5/
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>302 Found</title>
    [...]

## Installation sous Windows

L'outil [OpenVPN GUI](https://community.openvpn.net/openvpn/wiki/OpenVPN-GUI) permet une installation simple d'un client OpenVPN.

Une fois qualifiée, l'installation peut être facilement installée comme service en suivant la documentation suivante : [Running OpenVPN as a Windows Service](https://openvpn.net/index.php/open-source/documentation/install.html?start=1# running_as_windows_service)

## Résolutions d'erreur

###  RESOLVE: Cannot resolve host address

Suite à l'installation d'un client OpenVPN, le serveur du CNIV est accessible, mais adresse des douanes qui tombe en erreur (``ERR_CONNECTION_TIMED_OUT``). Dans les logs produits par le client OpenVPN, on peut voir cette ligne :

    00:00:00 2016 RESOLVE: Cannot resolve host address: 10.253.161.5 255.255.255.255: Hôte inconnu.

*Résolution* : Le problème rencontré est lié à la définition de route. L'instruction du fichier de configuration openvpn qui indique que les requêtes vers 10.253.161.5 doivent passées par la liaison VPN sont ignorées. En effet le client OpenVPN prend la chaine de caractère ``10.253.161.5 255.255.255.255`` comme un nom de domaine et non pour un ip suivi de son masque.

Il faut bien vérifier que le fichier de configuration du client OpenVPN contient une ligne ``route`` où l'ip ``10.253.161.5`` et le masque ``255.255.255.255`` ainsi que le réseau ``10.124.0.0`` et son netmask ``255.255.0.0`` sont bien renseignés sans guillemets et sans espace inséquable :

    route 10.253.161.5 255.255.255.255
    route 10.124.0.0 255.255.0.0
 
 ### Cannont reach 10.XXX.XXX.XXX
 
Votre openvpn n'est pas configurer pour prendre en charge les connexions vers les réseaux douaniers. Il faut donc vérifier que le fichier de configuration est bien prévu pour cette prise en charge. Vous devriez y trouver les deux lignes suivantes :

    route 10.253.161.5 255.255.255.255
    route 10.124.0.0 255.255.0.0

