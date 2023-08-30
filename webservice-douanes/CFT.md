# Note relatives au CFT

## Activation de l'envirronement

Un fichier `cft/env_cft` a été créé pour charger la configuration. Il contient :

    . $CFTPATH/Transfer_CFT/runtime/profile
    LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/lib:/lib/x86_64-linux-gnu:/usr/lib:/usr/local/lib
    cd $CFTPATH/Transfer_CFT/runtime

Certaine commande générant des écritures ont besoin d'avoir le droit en écriture sur le répertoire runtime.

## Consultaion des partenaires

La commande ``cftpart`` permet de lister tous les partenaires.

## Duplication d'un partenetaire

La commande ``cftutil cftext`` permet de générer un fichier permettant de modifier des partenaire. En sélectionnant les deux sections du partenaire à dupliquer, on va pouvoir créer ce nouveau partenaire sur la base des paramètres du précédent.

    cftutil cftext > /tmp/ctfext.txt

Cette commande permet l'export. Puis on crée, fichier ``/tmp/partneaire_duplique.txt`` en copiant et adaptant au moins l'identifiant et les NSPART/NRPART. Puis, on charge le nouveau partenaire avec la commande :

    cftutil @/tmp/partneaire_duplique.txt

## Vérification du fonctionnement

Le service écoute sur le port **1762**.

Lorsqu'il fonctionne correctement, les processus suivants sont lancés :
 - CFTTSSL
 - CFTMAIN
 - CFTLOG
 - CFTTFIL
 - CFTTFIL
 - CFTTCOM
 - CFTPRX
 - CFTTPRO
 - CFTTFIL
 - CFTTCPS
