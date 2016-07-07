#Accès PASTEUR via le VPN CNIV

Les accès à la ligne spécialisée PASTEUR a été mutualisé grace à l'intervention du CNIV. Un serveur offrant un accès mutualisé à l'infrastructure des douanes a été mis en place. La technologie retenue est [OpenVPN](https://openvpn.net/), un projet libre de vpn logiciel qui supporte une dixaine de système d'exploitation.

Lors de livraison de l'accès, une archive contenant quatre fichiers sont livrés :
 - ``moninterpro.ovpn`` : le fichier de configuration du client OpenVPN. Ce fichier fait référence aux trois autres fichiers, il convient donc de stocker tous ces fichiers dans le même répertoire ou d'éditer cette configuration pour faire référence au chemin absolu des fichiers ;
 - ``moninterpro.crt`` : le certificat contenant la clé publique permettant à l'OpenVPN de vous identifier ;
 - ``moninterpro.key`` : la clé privée permettant à l'OpenVPN de vous identifier. Cette clé est protégée par un mot de passe ;
 - ``ca.crt`` : le certificat de l'autorité de certification qui a émis votre certificat.

Le contenu de ces quatres fichiers sont protégés par un mot de passe. Pour les extraire, il vous sera demandé.

En plus de l'archive, deux mots de passe seront donc fournis :
 - celui permettant d'exploiter l'archive zip contenant les quatres fichiers ;
 - celui permettant de protéger la clé privée.

Une fois la clé privée installée, si vous ne souhaitez pas saisir son mot de passe à chaque démarrage, il est possible de la stocker en clair. Toute fois procédez à cette opération en ayant conscience que ca réduit le niveau de sécurité de votre accès. Il ne faut donc pas transférer votre clé privée dans un fichier non chiffré. Avec toutes ces réserves, une fois sur le serveur, OpenSSL permet de déchiffre ce fichier grace à la commande unix suivante :

    $ openssl rsa -in moninterpro.key  -out moninterpro.nocrypt.key

Si vous choisisez cette option, vous devez modifier le fichier de configuration ``moninterpro.ovpn`` en faisant référence au nouveau fichier (dans notre exemple ``moninterpro.nocrypt.key``).

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

Tant que votre client OpenVPN sera opérationnel, vous pourrez interroger le serveur du CNIV via l'url :

    $ curl http://10.222.223.1/
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    [...]

De même si les routes sont bien installées par OpenVPN, vous pourrez avoir accès à la machine des douanes :

    $ curl http://10.253.161.5/
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>302 Found</title>
    [...]

