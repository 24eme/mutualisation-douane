#Projet CIEL Contrat de service avec les interprofessions vitivinicoles

Version 2.4 du 27/09/2016
[Valable pour la version 1.9 du schéma XSD]

État : Validé

A propos du calendrier de mise en place de cette version 1.9 :

    La mise en recette est prévue mi-novembre, pour une mise en production début janvier. 
    C'est à cette seule date que cette évolution précise sur les centilisations sera 
    disponible en production.
    
    (email du 26 octobre)

##INTRODUCTION
###OBJET DU DOCUMENT

Ce document décrit les interfaces entre le système CIEL et les systèmes d'information (SI) des interprofessions vitivinicoles.

###DOCUMENTS APPLICABLES ET DOCUMENTS DE SECOURS

*supprimé*

###GLOSSAIRE

Terme | Définition |
:-----|:-----------|
CIEL  | Contributions indirectes en ligne |
CRD   | Capsule représentative de droits |
DAA   | Document d’accompagnement administratif |
DAC   | Document d’accompagnement commercial |
DAE   | Document administratif électronique |
DCA   | Document commercial d’accompagnement |
DRA   | Déclaration récapitulative annuelle |
DRM   | Déclaration récapitulative mensuelle |
DSA   | Document simplifié d’accompagnement |
DSAC  | Document simplifié d’accompagnement commercial |
hL    | Hectolitre |
IIP   | Interface avec les interprofessions vitivinicoles |
INAO  | Institut national de l’origine et de la qualité (anciennement Institut national des appellations d’origine) |
MCR   | Moût concentré rectifié |
ROSA  | Référentiel des opérateurs et de suivi des agréments |
SAX   | Simple API for XML |
SEED  | System of exchange of excise data |
SI    | Système d’information |
SOAP  | Simple object access protocol |
TAV   | Titre alcoométrique volumique |
XML   | Extensible markup language |
XSD   | XML schema definition |
WSDL  | Web services description language |

###DÉFINITION

« Numéro d'agrément » : dans le présent document, on entend par « numéro
d'agrément » le « numéro d'agrément d'entrepositaire agréé » ou « numéro
d'accises ». Dans le référentiel ROSA (référentiel des opérateurs et de suivi des
agréments) de la DGDDI, chaque entrepositaire agréé est identifié par un « numéro
d'agrément d'entrepositaire agréé ». Ce numéro correspond au « numéro
d'accises » et constitue l'identifiant commun de l'opérateur entre la DGDDI et les
interprofessions.

« Déclaration récapitulative » : dans le présent document, lorsque le terme
générique de « déclaration récapitulative » est utilisé, il fait référence aux
déclarations récapitulatives mensuelles (DRM) et aux déclarations récapitulatives
annuelles (DRA).

##CIEL ET LES INTERPROFESSIONS VITIVINICOLES

Les opérateurs vitivinicoles saisissent des informations économiques relatives à leur
comptabilité matières sur les portails des interprofessions desquelles ils sont adhérents.
Suite à la validation des données économiques sur le portail de l'interprofession, les
données sont envoyées à CIEL. Tous les mois, les opérateurs se connectent à CIEL pour
y saisir leur déclaration récapitulative mensuelle (tous les ans pour les opérateurs
déposant des déclarations récapitulatives annuelles). CIEL pré-remplit alors la déclaration
récapitulative de l'opérateur à partir des données économiques précédemment reçues de
l'interprofession.

La complétude des informations fournies par les interprofessions vitivinicoles dépend du
portail et de la saisie des opérateurs. La saisie des déclarations récapitulatives dans CIEL
par les opérateurs pouvant se faire à tout moment, l’interprofession doit envoyer les
données économiques à CIEL immédiatement après la validation de la saisie sur le portail
de l'interprofession.

Une fois que les opérateurs ont saisi leur déclaration récapitulative, ils la valident dans
CIEL. Les données économiques des déclarations récapitulatives validées sont ensuite
envoyées aux interprofessions vitivinicoles.

Les opérateurs pouvant modifier leurs déclarations récapitulatives dans CIEL, CIEL envoie
à nouveau aux interprofessions les déclarations modifiées et validées.
NB : La DRM concernant le mois N peut être saisie et validée par l’opérateur jusqu’au 10
du mois N+1 (ex : la DRM de janvier 2016 peut être saisie sur CIEL jusqu’au 10 février
2016). Une fois ce délai dépassé, la déclaration ne peut plus être modifiée par le déclarant
au travers du site web. Toute modification ultérieure entre dans le cadre d’un processus
exceptionnel et non automatisé, qui requiert la validation du chef de service des douanes
locales. Une DRM reste modifiable par le service des douanes :

- tant que le paiement de la somme à recouvrer n’est pas réalisé dans le cas des redevables non EAUP (Echéance Annuelle Unique de Paiement) ;
- tant que la déclaration du mois suivant n’a pas été saisie et validée dans les cas des redevables EAUP.

Une DRM validée sur CIEL est transmise en retour à l’interprofession de rattachement.
Les éventuelles modifications ultérieures, sur CIEL ou dans le cadre de la procédure
exceptionnelle, feront l’objet de nouveaux flux de retour vers l’interprofession concernée.

Le schéma suivant présente ce processus :

*image*

Lorsqu’un opérateur vitivinicole saisit les informations sur sa comptabilité matières dans le
portail de son interprofession, le SI de l’interprofession doit vérifier l’existence du numéro
d’agrément d'entrepositaire agréé (ou numéro d'accises) indiqué par l’opérateur. Pour ce
faire, le SI de l’interprofession interroge le SI de la douane, qui lui indique en retour si le
numéro d’agrément existe.

Les échanges entre le SI des douanes et les SI des interprofessions vitivinicoles sont répartis sur les trois interfaces IIP1, IIP2 et IIP3 représentées dans le schéma ci-dessous :

*image*

Ces trois interfaces sont détaillées dans les chapitres suivants :
 - Interface IIP1 : Envoi des données economiques pour pré-remplissage de la déclaration du portail de l'interprofession vers CIEL
 - Interface IIP2 : Envoi par CIEL des données économiques de la déclaration récapitulative validée à l'interprofession
 - Interface IIP3 : Transmission des données liées à un numéro d'agrément

L’interprofession garantit la sécurité de son accès vis à vis d’éventuelles intrusions
extérieures sur le SI de la Douane.

L’interprofession est responsable de la connexion jusqu’au point de raccordement
(Routeur de l’opérateur de télécommunication pour Pasteur Garanti, ou terminaison du
tunnel VPN pour Pasteur Léger).

Concernant le jeton d’authentification et le jeton d’accès lors des échanges sur l’interface

IIP1, les données mesurant le temps (iat, timestamp, …) sont au format milli-secondes.

##INTERFACE IIP1 : ENVOI DES DONNÉES ECONOMIQUES POUR PRÉ­REMPLISSAGE DE LA DÉCLARATION DU PORTAIL DE L'INTERPROFESSION VERS CIEL

###DESCRIPTION GÉNÉRALE

**IIP1. Envoi des données économiques pour pré-remplissage de la déclaration du portail de l'interprofession vers CIEL**

| Type | Service web synchrone (REST) |
|:-----|:-----------------------------|
| Objectif | Ce service permet aux SI des interprofessions vitivinicoles de fournir aux téléservices clients les données économiques disponibles et nécessaires à la constitution d’une DRM, pour un agrément, un mois et une année donnés (ou pour un agrément et une année donnés dans le cas de la DRA). |
| Acteur | CIEL (serveur) - SI de l’interprofession vitivinicole (client) |
| Fréquence | Disponibilité permanente|
| Temps de réponse maximal | 2 secondes au 90e centile (Sur 100 appels au service web, au moins 90 ont un temps de réponse inférieur ou égal à 2 secondes.) |

###FONCTIONNEMENT GÉNÉRAL

L'interprofession envoie les données économiques validées par le ressortissant sur son portail à CIEL (IIP1). Ce flux est unitaire : il ne concerne qu’une déclaration par période de taxation et par déclarant. A réception du flux, CIEL enregistre une déclaration en mode brouillon à partir des données transférées.

Le ressortissant est redirigé depuis le portail de son interprofession vers CIEL afin de saisir sa déclaration récapitulative (après authentification sur Prodouane). Une fois qu’il a choisi un numéro d’agrément et une période de déclaration, CIEL affiche le formulaire de la déclaration pré-rempli à partir des données économiques envoyées par l'interprofession.

Le schéma suivant représente l'envoi des données économiques par l'interprofession :

*image*

L'opérateur effectue une seule convention d'adhésion à CIEL par compte Prodouane. Pour chaque numéro d'agrément, l'opérateur renseigne son interprofession de rattachement.

Dans la mesure où un compte Prodouane peut être habilité à déclarer pour plusieurs numéros d'agrément, plusieurs interprofessions peuvent être rattachées à un compte Prodouane (une interprofession par numéro d'agrément).

Lorsque l'interprofession envoie des données économiques pour un numéro d'agrément et un mois donnés, CIEL doit être capable de déterminer si le portail émetteur correspond au portail de référence de l'interprofession d'appartenance pour ce numéro d'agrément. Dans le cas où CIEL reçoit des données économiques pour un numéro d'agrément d'un portail qui n'est pas le portail de référence, CIEL n'accepte pas les données et renvoie un message d'erreur.

CIEL ne saura pas gérer les cas où un opérateur est ressortissant de plusieurs interprofessions vitivinicoles pour un même numéro d'agrément. Pour ces cas, l'opérateur devra choisir son interprofession « principale » lors de son habilitation à la télé-procédure; CIEL ne connaîtra que l’adhésion de cet opérateur à cette interprofession pour le numéro d'agrément concerné. Ainsi, l’interface IIP1 n’aura lieu qu’entre CIEL et le portail de référence de cette interprofession.

Enfin, lorsque le ressortissant valide les données économiques saisies sur le portail de son interprofession, elles ne sont plus modifiables sur le portail de l'interprofession. CIEL ne peut recevoir qu'une seule fois les données économiques de la part d'une interprofession pour un numéro d'agrément et un mois donnés (ou pour un numéro d'agrément et une année donnés dans le cas de la DRA).

###PARAMÈTRES D'ENTRÉE

####DESCRIPTION

Le SI de l’interprofession vitivinicole envoie toutes les informations économiques dont ildispose et étant utiles à l’élaboration d’une déclaration récapitulative pour un numéro d’agrément d'entrepositaire agréé, un mois et une année (ou pour un numéro d'agrément et une année dans le cas de la DRA) donnés. Le SI de l'interprofession pouvant disposer de toutes les données économiques nécessaires à la DRM, la structure des données envoyées par le service, constituant l'entrée de l'IIP1, reprend la structure des données économiques de la DRM.

La télé-déclaration, étant la photographie de la comptabilité matières pour une période donnée, doivent y figurer tous les produits en stocks (en droits suspendus et/ou en droits acquittés) que ces produits aient fait l’objet d’un mouvement (entrées ou sorties) ou pas depuis la période précédente.

####ÉLÉMENTS

#####Élément message­-interprofession

Type : Complexe ordonné

Référence | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:---------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP-1-­E­1    | siren­-interprofession | sirenType | 1 | Identification de l'interprofession d’appartenance de l’opérateur | O | IIP1­-RG6 |
IIP-1-­E­2    | declaration­-recapitulative | declaration­-recapitulative  | 1 | Déclaration récapitulative | O | IIP1­-RG2 |

#####Élément declaration­-recapitulative

Type : Complexe ordonné

Référence   | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:-----------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP-1-­E­2.1  | identification­-declarant | identification­-declarant | 1 | Numéro d'agrément et numéro CVI de l'opérateur | O |  |
IIP-1-­E­2.3  | periode | periode | 1 | Mois et année de la déclaration dont les données sont envoyées (pour les DRA, il s'agit du mois et de l'année de la fin de la période) | O |  |
IIP-1-­E­2.4  | declaration-neant | boolean | ­1 | Déclaration néant : oui / non | O  | IIP1­-RG11 |
IIP-1-­E­2.5  | droits­-suspendus | droits­-suspendus  | 0..1 | Balance des stocks en droits suspendus de la DRM | F | IIP1­-RG11 IIP1­-RG13 |
IIP-1­-E­2.6  | droits­-acquittes | droits­-acquittes | 0..1 | Balance des stocks en droits acquittés de la DRM | F | IIP1­-RG11 IIP1­-RG12 |
IIP-1­-E­2.7  | compte­-crd | compte­-crd | 0..10 | Compte des capsules représentatives de droits de la DRM | F | |
IIP-1­-E­2.8  | document­-accompagnement | document­-accompagnement | 0..3 | Références des documents d’accompagnement émis durant le mois précédent | F | |
IIP-1­-E­2.9  | releve­-­non­-apurement | releve­-­non­-apurement | 0..1 | Relevé de non apurement | F | IIP1-­RG12 |
IIP-1­-E­2.10 | statistiques | statistiques | 0..1 | Statistiques communautaires | F | |

#####Élément identification­-declarant

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP-1-­E­-2.1.1|numero­-agrement | numeroAcciseType|1|Numéro d’agrément d'entrepositaire agréé concerné par la DRM dont les données sont demandées | O | IIP1­RG3 IIP1­RG4 IIP1­RG5 |
IIP-1­-E­-2.1.2|numero­-cvi      | numeroCviType | 0..1 | Numéro CVI de l'opérateur | F | |

#####Élément periode

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP-1­-E­-2.3.1| mois | int | 1 | Mois de la déclaration dont les données sont envoyées (pour les DRA, il s'agit du mois et de l'année de la fin de la période) | O | IIP1­RG7 IIP1­RG8 IIP1­RG9 |
IIP-1-­E-­2.3.2| annee |int | 1 | Année de la déclaration dont les données sont envoyées (pour les DRA, il s'agit du mois et de l'année de la fin de la période) | O | IIP1­RG7 IIP1­RG8 IIP1­RG9 |

#####Élément droits-suspendus

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP-1­-E-­2.4.1| produit | produit | 0..* | Produit concerné par la déclaration en droits suspendus | F | IIP1­RG10 |
IIP-1­-E-­2.4.2| stockEpuise | boolean | 1 | Booléen indiquant si le stock en droits suspendus est épuisé | O | IIP1­RG13 |

#####Élément produit

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP-1-E2.4.1.2 | code­-inao | codeInaoType | 0..1 | Code INAO du produit | F | IIP1RG19 IIP1RG20 IIP1RG23 |
IIP1-E2.4.1.1 | libelle-fiscal | LibelleFiscalType | 0..1 | Libellé fiscal du produit (liste des libellés en annexes) | F |  IIP1RG36 IIP1RG41 IIP1RG42 |
IIP1-E2.4.1.3 | libelle-personnalise | string | 1 | Libellé personnalisé du produit | O | IIP1RG37 |
IIP1-E2.4.1.7 | balance-stocks | balance-stocks | 1 | Balance des stocks en droits suspendus | O | |
IIP1-E2.4.1.4 | tav | tavType | 0..1 | TAV du produit | F |  IIP1RG21 IIP1RG22
IIP1-E2.4.1.5 | premix | boolean | 0..1 | Indique si le produit considéré est un premix ou pas | F |  IIP1RG21 IIP1RG22
IIP1-E2.4.1.6 | observations | string | 0..1 | Observations apportées par le déclarant concernant la balance des stocks en droits suspendus | F |  IIP1RG25 IIP1RG26

#####Élément balance-stocks (Droits suspendus)

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.1 | stock-debut-periode | volumeStock | 1 | Stock de début de période (en hL), systématiquement repris du stock théorique total de fin de la période de la DRM ou DRA précédente. Si 1ère DRM de la campagne vitivinicole, doit être indiqué le stock réel (physique) tel qu'il résulte de l'inventaire des stocks. | O | IIP1RG14 Si saisi, alors >=0
IIP1-E2.4.1.7.2 | entrees-periode | entrees-periode |  0..1 | Entrées sur la période en droits suspendus, pour le produit concerné | F | IIP1RG14 Si saisi, alors >= 0
IIP1-E2.4.1.7.3 | sorties­-periode | sorties­-periode | 0..1 | Sorties sur la période en droits suspendus, pour le produit concerné | F |
IIP1-E2.4.1.7.4 | stock­-fin­-periode | stock­-fin­-periode | 1 | Stock de fin de période (en hL), correspondant à la différence entre les entrées et les sorties de période. | O | IIP1RG17 IIP1RG18

#####Élément entrees-periode

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.2.1  | volume-produit | volumeType | 0..1 | Produits issus des vendanges (récoltants) ou de la déclaration SV12 (négociants vinificateurs), ou produits par assemblage de deux produits ou plus (ratafia, cartagène, floc de Gascogne, pineau des Charentes, etc.), ou ayant fait l'objet d'une déclaration de revendication, ou issus des différentes manipulations possibles sur les vins (soutirages, désalcoolisation...) pour ce qui concerne les lies ou alcools, ou issus d'une activité accessoire (distillation de fruits) (en hL). | F | Si saisi, alors >=0 |
IIP1-E2.4.1.7.2.2 | achats-reintegrations | volumeType | 0..1 | Achat de produits en vrac, ou en bouteilles nues sur pile, réintégrations de produits sortis en suspension de droits (en hL) | F | Si saisi, alors >=0
IIP1-E2.4.1.7.2.3  | mouvements-temporaires | mouvements-temporaires | 0..1 | Prestations de service, relogement, ou pour élaboration à façon de vins mousseux, ou pour distillation de cognac, par exemple. Retour obligatoire à la propriété (en hL) | F |
IIP1-E2.4.1.7.2.4 | ouvements-internes | mouvements-internes | 0..1 | Mouvements internes du produit (en hL) | F |
IIP1-E-2.4.1.7.2.6 | replacement | complexe | 0..1 | Exemple : retour de marchandises, transfert de comptabilité matières. Toute saisie dans cette ligne requiert un commentaire obligatoire dans la rubrique « Observations » (en hL) | F | IIP1RG38
IIP1-E2.4.1.7.2.5 | autres-entrees | volumeType | 0..1 | Excédent suite à inventaire ou contrôle du service des douanes. Toute saisie requiert un commentaire obligatoire dans la rubrique « Observations » (en hL) | F | IIP1RG25 Si saisi, alors >=0

#####Élément mouvements-temporaires

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.2.3.1 | embouteillage | volumeType | 0..1 | Retour de prestation d'embouteillage (uniquement si l'embouteillage n'a pas lieu sur place) (en hL) | F |  Si saisi, alors >=0
IIP1-E2.4.1.7.2.3.2 | relogement | volumeType | 0..1 | Retour de relogement (en hL) | F | Si saisi, alors >=0
IIP1-E2.4.1.7.2.3.3 | travail-a-facon | volumeType | 0..1 | Retour de travail à façon (en hL) | F | Si saisi, alors >=0
IIP1-E2.4.1.7.2.3.4 | distillation-a-faconEntrees | volumeType | 0..1 | Retour de distillation à façon (en hL) | F |  Si saisi, alors >=0

#####Élément mouvements-internes

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.2.4.1 | replis­-declassement­-transfert­-changement­-appellation | volumeType | 0..1 | repli, déclassement, transfert, changement d'appellation (en hL) Toute entrée dans cette rubrique pour une colonne doit trouver son équivalent en sortie dans une autre. | F | Si saisi, alors >=0
IIP1-E2.4.1.7.2.4.2 | manipulations | volumeType | 0..1 | Augmentation de volume constatée suite à une manipulation oenologique autorisée (ex. édulcoration) | F | Si saisi, alors >=0
IIP1-E2.4.1.7.2.4.3 | integration-vci-agree | volumeType | 0..1 | Intégration de VCI agréé (en hL) Le cumul des agréments de VCI pour les appellations en bénéficiant doit trouver son équivalent en sortie de la colonne produit VCI. | F | Si saisi, alors >=0

#####Élément replacement-suspension

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.2.6.1 | mois | int | 1 | Mois de la sortie taxable ou de la réception en droits acquittés de ce produit. Entre 1 et 12. | O | IIP1RG40 |
IIP1-E2.4.1.7.2.6.2 | annee | int | 1 | Année de la sortie taxable ou de la réception en droits acquittés de ce produit.  Sur 4 positions. | O | IIP1RG40 |
IIP1-E2.4.1.7.2.6.3 | volume | volumeType | 1 | Volume du produit replacé en suspension | O | >=0 |

#####Élément sorties-periode

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.3.1  | ventes-france-crd-suspendus | ventes-france-crd-suspendus  | 0..1 | Ventes France sous CRD personnalisées ou collectives achetées en droits suspendus, sous DSA ou sous facture (en hL) | F | IIP1RG35 IIP1RG20 Si saisi, alors >=0
IIP1-E2.4.1.7.3.2 | france-crdacquittes | ventesvolumeType | 0..1 | Ventes France sous CRD collectives achetées en droits acquittés Les droits ont été acquittés auprès du répartiteur de capsules au moment de l'achat des CRD Dans CIEL, cette donnée n'alimente pas la liquidation de la déclaration mais a une vocation seulement statistique | F | IIP1RG20 Si saisi, alors >=0
IIP1-E2.4.1.7.3.3 | sorties-sans-paiement-droits | sorties-sans-paiement-droits | 0..1 | Sorties du produit sans paiement des droits (en hL) | F |

#####Élément ventes-france-crd-suspendus

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.3.1.1 | annee-precedente | volumeType | 0..2 | Volume pour l’année précédente (cas unique des DRA) | F | IIP1RG35 Si saisi, alors >=0
IIP1-E2.4.1.7.3.1.2 | annee-courante | volumeType | 0..1 | Volume pour l’année courante (cas des DRA) ou volume à déclarer pour la péruide de taxation | O | IIP1RG35 Si saisi, alors >=0

#####Élément sorties-sans-paiement-droits

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.3.3.1 | sorties-definitives | volumeType | 0..1 | Sorties définitives du produit en droits suspendus : ventes vrac au négoce, en intracommunautaire, à l'export, sous DAE, DAA et DCA ainsi que sorties de lies et DRA (en hL) | F | Si saisi, alors > 0 | IIP1RG26 Si saisi, alors >0
IIP1-E2.4.1.7.3.3.2 | consommation-familiale-degustation | volumeType | 0..1 | Consommation familiale du produit et / ou dégustation à l'exploitation (en hL) | F | Si saisi, alors >0
IIP1-E2.4.1.7.3.3.3 | mouvements-temporaires | mouvements-temporaires | 0..1 | Mouvements temporaires du produit (en hL) Prestations de service, relogement, ou pour élaboration à façon de vins mousseux, ou pour distillation de cognac, par exemple. Retour obligatoire à la propriété | F |
IIP1-E2.4.1.7.3.3.4 | mouvements-internes | mouvements-internes | 0..1 | Mouvements internes du produit (en hL) | F |
IIP1-E2.4.1.7.3.3.5 | autres-sorties | volumeType | 0..1 | Destruction par exemple (en hL) Toute saisie dans cette ligne requiert un commentaire obligatoire dans la rubrique « Observations » | F | IIP1RG26 Si saisi, alors >0

#####Élément mouvements-temporaires

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.3.3.3.1 | embouteillage | volumeType | 0..1 | Sortie pour prestation d'embouteillage (uniquement si l'embouteillage n'a pas lieu sur place) (en hL) | F |  Si saisi, alors >=0
IIP1-E2.4.1.7.3.3.3.2 | relogement | volumeType | 0..1 | Sortie pour relogement (en hL) | F |  Si saisi, alors >=0
IIP1-E2.4.1.7.3.3.3.3 | travail-a-facon | volumeType | 0..1 | Sortie pour travail à façon (en hL) | F |  Si saisi, alors >=0
IIP1-E2.4.1.7.3.3.3.4 | distillation-a-facon | volumeType | 0..1 | Sortie pour distillation à façon (en hL) | F | Si saisi, alors >=0

#####Élément mouvements-internes

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.4.1.7.3.3.4.1 | replis-declassement-transfert-changement-appellation | volumeType | 0..1 | repli, déclassement, transfert, changement d'appellation (en hL) Toute sortie dans cette rubrique pour une colonne doit trouver son équivalent en entrée dans une autre. | F | Si saisi, alors >=0
IIP1-E2.4.1.7.3.3.4.2 | fabrication-autre-produit | volumeType | 0..1 | En cas de mutage de vin par adjonction d'alcool, inscrire ici le volume de vin concerné ainsi que le volume d'alcool ayant permis l'opération, et porter les quantités de vins mutés en entrée (en hL) | F | Si saisi, alors >=0
IIP1-E2.4.1.7.3.3.4.3 | revendication-vci | volumeType | 0..1 | Volume de VCI de l'année N-1 du produit ayant reçu l'agrément à la récolter de l'année N (en hL) | F | Si saisi, alors >=0
IIP1-E2.4.1.7.3.3.4.4 | autres-mouvements-internes | volumeType | 0..1 | Manipulations, soutirages. Réductions de volume constatées suite à soutirages de lies ou manipulations diverses, notamment les méthodes soustractives d'enrichissement ou la désalcoolisation. | F | Si saisi, alors >=0 |

#####Élément droits-acquittes

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.5.1 | produit | produit | 0..* | Produit concerné par la déclaration en droits acquittés | F | IIP1RG10
IIP1-E2.5.3 | stockEpuise | boolean | 1 | Booléen indiquant si le stock en droits suspendus est épuisé | O | IIP1RG13

#####Élément produit

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.5.1.1 | code-inao | codeInaoType | 1 | Code INAO du produit | O |  IIP1RG19 IIP1RG20 IIP1RG23
IIP1-E2.5.1.2 | libelle-fiscal | LibelleFiscalType | 0..1 | Libellé fiscal du produit (liste des libellés en annexes) | F | IIP1RG36
IIP1-E2.5.1.3 | libelle-personnalise | string | 1 | Libellé personnalisé du produit | O | IIP1RG37 |
IIP1-E2.5.1.4 | tav | tavType | 0..1 | TAV du produit | F | IIP1RG21 IIP1RG22
IIP1-E2.5.1.3 | premix | boolean | 0..1 | Indique si le produit considéré est un premix ou pas | F | IIP1RG21 IIP1RG22
IIP1-E2.5.1.4 | balance-stocks | balance-stocks | 1 | Balance des stocks en droits acquittés | O |
IIP1-E2.5.1.5 | observations | string | 0..1 | Observations apportées par le déclarant concernant la balance des stocks en droits acquittés | F | IIP1RG25 IIP1RG26 IIP1RG38

#####Élément balance-stocks (Droits acquittés)

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.6.1.2.1 | stock-debut-periode | volumeStockType | 1 | Stock de début de période (en hL), systématiquement repris du stock théorique total de fin de la période de la DRM ou DRA précédente. Si 1ère DRM de la campagne vitivinicole, doit être indiqué le stock réel (physique) tel qu'il résulte de l'inventaire des stocks. | O | IIP1RG17 IIP1RG18
IIP1-E2.6.1.2.2 | entrees-periode | entrees-periode | 0..1 | Entrées sur la période en droits acquittés, pour le produit concerné | F |
IIP1-E2.6.1.2.3 | sorties-periode | sorties-periode | 0..1 | Sorties sur la période en droits acquittés, pour le produit concerné | F |
IIP1-E2.6.1.2.4 | stock-fin-periode | volumeStockType | 1 | Stock de fin de période (en hL), correspondant à la différence entre les entrées et les sorties de période. | O | IIP1RG14 Si saisi, alors >=0

#####Élément entrees-periode

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.6.1.2.2.1 | achats | volumeType | 0..1 | Achats du produit (en hL) | F | Si saisi, alors >=0
IIP1-E2.6.1.2.2.2 | autres-entrees | volumeType | 0..1 | Autres entrées du produit (en hL) | F | IIP1RG25 Si saisi, alors >=0

#####Élément sorties-periode

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.6.1.2.3.1  | ventes | volumeType | 0..1 | Ventes de produit (en hL) | F | Si saisi, alors >=0
IIP1-E2.6.1.2.3.2 | replacement-suspension | volumeType | 0..1 | Replacement en suspension du produit (en hL) | F | Si saisi, alors >=0
IIP1-E2.6.1.2.3.3 | autres-sorties | volumeType | 0..1 | Autres sorties du produits (en hL) | F | IIP1RG26 Si saisi, alors >=0 |

#####Élément compte-crd

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.7.1 | categorie-fiscale-capsules | categorieFiscaleCapsuleType | 1 | Catégorie fiscale de capsules représentatives de droits | O | IIP1RG27
IIP1-E2.7.2 | type-capsule | typeCapsulesType | 1 | Type de capsules représentatives de droits | O | IIP1RG28
IIP1-E2.7.3 | centilisation | centilisation | 1..* | Centilisation des capsules déclarées | O | IIP1RG29 IIP1RG31 |

#####Élément centilisation

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.7.3.1 | stock-debut-periode | nonNegativeInteger | 0..1 | Stock de capsules du début de la période | O | IIP1RG31 IIP1RG39 |
IIP1-E2.7.3.2 | entrees-capsules | entrees-capsules | 0..1 | Entrées de capsules | F |
IIP1-E2.7.3.3 | sorties-capsules | sorties-capsules | 0..1 | Sorties de capsules | F |
IIP1-E2.7.3.4 | stock-fin-periode | nonNegativeInteger | 1 | Stock de capsules de la fin de la période | O | IIP1RG30 IIP1RG39 |

#####Élément entrees-capsules

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.7.3.2.1 | achats | nonNegativeInteger | 0..1 | Nombre de capsules achetées | F |
IIP1-E2.7.3.2.2 | retours | nonNegativeInteger | 0..1 | Nombre de capsules retournées | F |
IIP1-E2.7.3.2.3 | excedents | nonNegativeInteger | 0..1 | Nombre de capsules excédentaires | F |

#####Élément sorties-capsules

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.7.3.3.1 | utilisations | nonNegativeInteger | 0..1 | Nombre de capsules utilisées | F |
IIP1-E2.7.3.3.2 | destructions | nonNegativeInteger | 0..1 | Nombre de capsules détruites | F |
IIP1-E2.7.3.3.3 | manquants | nonNegativeInteger | 0..1 | Nombre de capsules manquantes | F |

#####Élément document-accompagnement

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.8.1 | numero-empreintes | DebutFinDocumentType | 0..1 | Type de référence du document d'accompagnement | F | IIP1RG34
IIP1-E2.8.2 | daa-dca | DebutFinDocumentType | 0..1 | Type de document pré-validé | F | IIP1RG34
IIP1-E2.8.3 | dsa-dsac | DebutFinDocumentType | 0..1 | Type de document pré-validé | F | IIP1RG34

#####Type DebutFinDocumentType

Type : Complexe non ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.8.1.1 | debut-periode | numeroDocumentType | 1 | Référence du premier document de la période | O |
IIP1-E2.8.1.2 | fin-periode  | numeroDocumentType | 1 | Référence du dernier document de la période | O |
IIP1-E2.8.1.2 | nombre-document-empreinte | int | 1 | Nombre de références sur la période | O | >0 |


#####Élément releve-non-apurement

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.9.1 | numero-daa-dac-dae | numeroRnaType | 0..1 | Numéro de DAA/DAC/DAE | O | IIP1RG12
IIP1-E2.9.2 | date-expedition | date | 0..1 | Date d’expédition (doit être de la forme AAAA-MM-JJ) | O
IIP1-E2.9.3 | numero-accise-destinataire | String (13 caractères destinataire maximum) | 0..1 | Numéro d’accise du destinataire  ou référence du bureau d’export | F | IIP1RG42

#####Élément statistiques

Type : Complexe ordonné

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif |  Règles  |
:------------|:--------|:----:|:------------|:------------|:----------------------:|:---------|
IIP1-E2.10.1 | quantite-mouts-jus | volumeType | 0..1 | Quantité de moûts de raisin transformés en jus de raisin | F | Si saisi, alors >=0
IIP1-E2.10.2 | quantite-mouts-mcr | volumeType | 0..1 | Quantité de moûts de raisin transformés en MCR (moûts concentrés rectifiés) | F | Si saisi, alors >=0
IIP1-E2.10.3 | quantite-vins-vinaigre | volumeType | 0..1 | Quantité de vins utilisés pour la fabrication de vinaigre | F | Si saisi, alors >=0 |

####TYPES SIMPLES

#####TYPES SIMPLES BASÉS SUR LE TYPE PRIMITIF DECIMAL

Type    | Nombre de décimales | Minimum | Description |
:-------|:-------------------:|:-------:|:------------|
volumeType | 4 | 0                      | Représente un volume positif ou nul |
volumeStockType | 4 |                   | Représente un volume positif, négatif ou nul |
tavType | 2 | 0                         | Représente le TAV d’un produit. Un tav ne peut être <=0.5 ou ≥ 100.


#####TYPES SIMPLES BASÉS SUR LE TYPE PRIMITIF STRING

Type    | Longueur minimale | Longueur maximale | valeurs possibles | format | Description |
:-------|:-----------------:|:-----------------:|:------------------|:-------|:------------|
sirenType | 9 | 9                               |          | Nombres entiers | Représente le numéro SIREN d'une interprofession strictement positifs
codeInaoType | 6 | 8                            |          |       | Représente le code INAO d’un produit. Un code INAO doit contenir entre 6 et 8 digits. Si le code est sur 5 digits, l'interprofession émettrice doit ajouter un espace avant envoi à CIEL.
LibelleFiscalType | |                           |          |       | Représente le libellé fiscal d’un produit
numeroAcciseType |13 | 13                  |     | [A­Za­z]{2}[0­9A­Za­z]{11} | Représente un numéro d’agrément
numeroCviType | 10 | 10 | | 10 chiffres | Représente un numéro CVI
typeCapsulesType | |    |  PERSONNALISEES COLLECTIVES_DROITS_SUSPENDUS COLLECTIVES_DROITS_ACQUITTES | | Représente un type de capsules représentatives de droits
categorieFiscaleCapsuleType | | | « M » (vin mousseux) « T » (vin tranquille) « PI » (produit intermédiaire) COGNACARMAGNAC ALCOOLS | | Représente une catégorie fiscale de capsule représentative de droits
numeroDocumentType | 1 | 9 | | Nombre entier positif | Numéro de référence de document d'accompagnement d'une DRM. En cas de valeur numérique indiquée, seul les entiers positifs sont autorisés.
numeroRnaType | 1 | 21 | | Chaîne caractères | Numéro de référence du daa­ de dac­dae
Attribut « volume » de l’élément centilisation | | | CL_10 CL_12_5 CL_18_7 CL_20 CL_25 CL_35 CL_37_5 CL_50 CL_62 CL_70 CL_75 CL_100 CL_150 CL_175 CL_200 BIB_225 BIB_300 BIB_400 BIB_500 BIB_800 BIB_1000 AUTRE| |Représente la centilisation de capsules représentatives de droits. Valeur obligatoire.
volumePersonnalise |  |  |  | Nombre décimal (1 chiffre après la virgule) | Volume indiqué pour une centilisation AUTRE
bib |  |  | Vrai / Faux | Booléen | Indique si la centilisation AUTRE est de type Bag-in-box

####RÈGLES DE GESTION

Dès réception d’un flux, CIEL met en place une série de contrôles pour vérifier la validité et la cohérence des données contenues. Chaque élément ci-dessous reprend la teneur de la vérification ainsi que le message d’erreur associé.

Chaque erreur est préfixée d’un texte commun indiquant le numéro (code) de l’erreur, repris dans les tableaux ci-dessous.

Exemple : « Erreur 007. Les données économiques ont déjà été reçues pour la période. »

Certains contrôles nécessitent la récupération de la télé-déclaration de la période immédiatement précédente. Cependant, la présence de la déclaration précédente ne devant pas constituer un frein à la transmission des télé-déclarations par les interprofessions, les règles de gestion suivantes s’appliquent donc pour la réception des DRM :

*RG_DecPrécédente_1* :

Si la période de la dernière DRM connue de l’opérateur est après 6 mois de la période transmise, l’ensemble des contrôles relatifs à la DRM précédente ne sont pas appliqués.

Exemples :
 - dernière DRM en 03/2015 et envoi de la période 10/2015 → les contrôles ne sont pas faits
 - dernière DRM en 03/2015 et envoi de la période 06/2015 → CIEL réclame la période 04/2015, l’envoi est rejeté

*RG_DecPrécédente_2* :

S’il n’existe aucune DRM pour le numéro d’agrément transmis, les contrôles relatifs à la DRM précédente ne sont pas appliqués.

*RG_DecPrécédente_3* :

La recherche de la DRM précédente (cf RG ci-dessus) inclut tous les formats (GILDA, CIEL-intranet et CIEL-internet). Cependant, les contrôles sur les données (produits, stocks ...) ne peuvent s’appliquer que si la DRM précédente est une télédéclaration.

NB : les contrôles pour les opérateurs réalisants des DRA (déclarations récapitulatives
annuelles) ne peuvent être faits que si une relation COCI active indiquant cet état est liée
à la relation EACI.

Important : une seule erreur, quelle qu’elle soit, est suffisante pour justifier le rejet
global du flux de la déclaration.

Hors les erreurs de format (non respect du XSD) et les erreurs 001 à 007 qui
bloquent immédiatement l’exécution des contrôles, l’ensemble des tests doit être
passé pour effectuer un contrôle complet de la déclaration.

Enfin, un code ‘999’ est prévu pour toutes les erreurs techniques. Le libellé associé
contient dans ce cas un identifiant unique (UUID) servant de support dans le
dépannage du problème.

####Cohérence des méta-données

Code RG | Test et condition(s) | Code erreur | Message si erreur |
:-------|:---------------------|:------------|:------------------|
IIP1RG1 | Le flux transmis doit respecter le schéma XSD prévu. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. | 001 | Le flux ne répond pas au schéma de transmission défini. Message technique &lt;message erreur xsd>. |
IIP1RG2 | Le flux transmis par l'interprofession doit contenir un seul fichier par déclaration. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés.
IIP1RG3 | Le numéro d’agrément d'entrepositaire agréé fourni par le SI de l’interprofession vitivinicole doit exister et être actif dans ROSA. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. | 002 | Le numéro d’agrément d'entrepositaire agréé n’existe pas ou n’est pas actif.
IIP1RG4 | L’agrément considéré, récupéré dans ROSA, doit reprendre une activité « EA viti » (les données transmises reprennent uniquement ce format). | 003 | Le numéro d’agrément d'entrepositaire agréé ne correspond à une activité vitivinicole. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés.
IIP1RG5 | L'ensemble des informations nécessaires au fonctionnement de CIEL doivent être disponibles et cohérentes dans le référentiel des opérateurs de la DGDDI (ROSA) pour le numéro d'agrément concerné.
IIP1RG6 | Le portail interprofessionnel indiqué pour l’envoi des données économiques (IIP1) doit correspondre au portail de référence de l'interprofession principale de Le flux ne répond pas au schéma de transmission défini. Message technique <message erreur xsd>. | 004 | Le portail interprofessionnel émetteur ne correspond pas au portail de référence de rattachement du numéro d'agrément pour lequel il envoie les données économiques à CIEL. NB : même erreur si aucune relation OVNI associée. l'interprofession d'appartenance pour ce numéro d'agrément. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. |
IIP1RG7 | La période de taxation doit être obligatoirement antérieure ou égale au mois courant. | 005 | La déclaration ne peut pas être déposée pour la période indiquée.
IIP1RG8 | La période de taxation de la déclaration doit être celle suivant la période de la déclaration précédente (mois + 1 pour les DRM et année + 1 dans le cas des DRA). Dans le cas des DRM, ce contrôle ne s’applique que sur les 6 derniers mois si une DRM existe pour le numéro d’agrément considéré. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. | 006 | Les données économiques n'ont pas été reçues pour la période précédente.
IIP1RG9 | Un opérateur déclarant mensuellement ou annuellement ne peut saisir qu'une DRM/DRA par numéro d'agrément et par mois/année de taxation. Il ne doit pas y avoir de déclaration validée pour la période de taxation transmise (mois et année pour les DRM ou année pour les DRA), quelle que soit son origine (intranet ou internet). NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. | 007 | Les données économiques ont déjà été reçues pour la période.
IIP1RG37 | Un nouveau produit dans une déclaration doit être identifié soit pas son code INAO s’il s’agit d’un vin mousseux ou d’un vin tranquille, soit par son libellé fiscal. Pour chaque nouveau produit déclaré, un libellé personnalisé doit être défini par l’opérateur. Le libellé personnalisé servira d’unique identifiant produit pour les déclarations futures, et n’est par conséquent plus modifiable une fois définie. Le code INAO ou le libellé fiscal, ainsi que le libellé personnalisé devront être transmis dans tous les cas, CIEL vérifiera que le produit (retrouvé par son libellé personnalisé) a bien les mêmes caractéristiques. | 030 | Le produit <libellé personnalisé> transmis ne correspond pas au produit indiqué dans la précédente déclaration. |


#### Balance des stocks

Code RG | Test et condition(s) | Code erreur | Message si erreur |
:-------|:---------------------|:------------|:------------------|
IIP1RG10 | Si la déclaration précédente pour ce numéro d’agrément existe, CIEL pré remplit la déclaration avec les produits renseignés dans la déclaration précédente. | / | / |
IIP1RG11 | Si l’indicateur « déclaration-néant » est vrai, alors les objets « droits-suspendus » et « droits-acquittes » ne peuvent pas contenir de « produit » (liste vide ou nulle). | 008 | Des éléments de la balance des stocks en droits suspendus et/ou acquittés ont été saisis alors que l'opérateur a indiqué effectuer une déclaration néant. Par exemple, si le flux arrive le 30 mai, la période de taxation est au plus tard le mois de mai. NB : si cette condition n’est pas vérifiée, les contrôles suivants ne seront pas exécutés. |
IIP1RG12 | Si l’agrément n’autorise pas les mouvements de stock en droits suspendus (agrément de type « Entrepositaire national en droits acquittés », contient la lettre « A »), alors l’objet « droits-suspendus » ne peut pas contenir de « produit » (liste vide ou nulle). De même dans ce cas, il ne doit pas y avoir de « relevé-non-apurement ». | 009 | Des mouvements de stocks en droits suspendus ou des relevés de non apurement ont été saisis alors que l'agrément ne l’autorise pas. |
IIP1RG13 | Si la déclaration précédente indique un stock épuisé pour la balance des stocks en droits suspendus, alors l’objet « droits-suspendus » ne peut pas contenir de « produit » (liste vide ou nulle). | 010 | Des éléments de la balance des stocks en droits suspendus ont été saisis alors que l'opérateur a déclaré que son stock était épuisé sur la précédente déclaration. |
IIP1RG14 | Avec la déclaration précédente, CIEL effectue un contrôle de correspondance avec les produits (identifiés par leur libellé personnalisé), pour la balance des stocks en droits suspendus. Pour chaque produit retrouvé, la valeur de « stockdébut-période » doit être égale au stock de fin de période de la déclaration précédente. Si le mois de taxation de la déclaration est août (début de la campagne viti-vinicole), cette règle ne doit pas être appliquée. | 011 | Le stock de début de période du produit <libellé personnalisé> de la balance des stocks en droits suspendus ne correspond pas au stock de fin de période du même produit de la déclaration précédente. |
IIP1RG15 | Avec la déclaration précédente, CIEL effectue un contrôle de correspondance avec les produits (leur identifiésar libellé personnalisé), pour la balance des stocks en droits acquittés. Pour chaque produit retrouvé, la valeur de « stockdébut-période » doit être égale au stock de fin de période de la déclaration précédente. Si le mois de taxation de la déclaration est août (début de la campagne viti-vinicole), cette règle ne doit pas être appliquée. | 012 | Le stock de début de période du produit <libellé personnalisé> de la balance des stocks en droits acquittés ne correspond pas au stock de fin de période du même produit de la déclaration précédente. |
IIP1RG16 | Pour chaque produit en droits suspendus de la déclaration transmise, la valeur « stock-fin-période » doit être égale à : « stock-début-période » + « entréespériode » - « sorties-période ». | 013 | Le stock de fin de période du produit <libellé personnalisé> de la balance des stocks en droits suspendus ne correspond pas aux éléments de la déclaration. |
IIP1RG17 | Pour chaque produit en droits acquittés de la déclaration transmise, la valeur « stock-fin-période » doit être égale à : « stock-début-période » + « entréespériode » - « sorties-période ». | 014 | Le stock de fin de période du produit <libellé personnalisé> de la balance des stocks en droits acquittés ne correspond pas aux éléments de la déclaration. |
IIP1RG18 | Dans CIEL, il est possible d’avoir un stock théorique de fin de période négatif. | / | / |
IIP1RG19 | Les codes INAO doivent contenir entre 6 et 8 digits. Si le code est sur 5 digits, l'interprofession émettrice doit ajouter un espace avant envoi à CIEL. CIEL rejettera le code INAO « 5 digits + espace », si le code existe déjà dans le référentiel sur 6 digits. | 015 | Le code INAO &lt;code> n’existe pas ou n’est pas valide. Si un code produit transmis n’est pas retrouvé dans la déclaration précédente ou que cette dernière n’existe pas, alors son code INAO doit exister dans le référentiel avec un statut « VALIDE ». La seule exception à cette règle est pour les codes INAO suivants : 4B988Y ;  4R988Y ; 4X999V  |
IIP1RG20 | Si le code INAO est 4B988Y ou 4R988Y ou 4X999V, alors les champs " Ventes France sous CRD en droits suspendus" et "Ventes France sous CRD en droits acquittés" ne sont pas exploités par CIEL dans la partie "Sorties de la période" pour ce produit | / | / |
IIP1RG21 | Si le produit nécessite la saisie d’un TAV et/ou de l’indicateur de premix, CIEL contrôle que ces données sont bien présentes. NB : Si le code INAO choisi est de la forme 1___N et/ou commence par 1R175, 1S175, 1B175, le TAV doit être obligatoirement saisi pour savoir si VDN VDL AOP>18%vol ou si VDN VDL AOP ≤ 18 % vol. Pas de choix prémix. ;  Si le code INAO est de la forme 1___Z, le TAV est demandé et le premix également (en réalité dans CIEL Internet, le prémix n’est considéré que si le TAV est =<18%) ; Pour tous les autres codes INAO, pas de saisie de TAV ni de prémix | 027 | Le produit <libellé personnalisé> doit avoir un TAV et/ou indiquer s'il s'agit d'un premix ou non. |
IIP1RG36 | Les règles suivantes s’appliquent aux produits identifiés par un libellé fiscal :  La valeur du TAV saisie pour un produit doit respecter la tranche du TAV définie dans le libellé fiscal (ex : si le libellé fiscal choisi est VDN_VDL_AOP_SUP_18, alors le TAV doit être strictement supérieur à 18%) ;  Si le produit choisi est un prémix, alors le TAV doit être compris entre 1,2 % exclus et 12 % exclus ; Les deux règles ci-dessus doivent s’appliquer simultanément (ex : si le libellé fiscal choisi est BIERE_INF_2_8_PREMIX, alors le TAV doit être compris entre 1,2 % exclus et 2,8% inclus) ; Toute valorisation du champ prémix ne peut être considérée car c’est le libellé fiscal qui porte cette information ; Si le libellé fiscal indique « SUP », cela sousentend strictement supérieur. S’il indique « INF », cela sous-entend inférieur ou égal. | 029 | Le TAV indiqué pour le produit <libellé personnalisé> ne correspond pas au libellé fiscal choisi. |
IIP1RG22 | Si le code INAO n’est pas de la forme 1xxxxN ou 1xxxxZ ou commence pas par 1B175, 1R175, 1S175, alors les champs TAV et prémix ne sont pas exploités par CIEL | / | / |
IIP1RG23 | Les balances des stocks en droits suspendus et en droits acquittés ne peuvent contenir qu’un seul et même code INAO respectivement. | 028 | Le produit <libellé personnalisé> apparaît deux fois dans la balance des stocks |
IIP1RG24 | Si un produit existe dans la déclaration précédente et n’a pas été repris dans la déclaration transmise, alors le | 016 | Le produit <libellé personnalisé> n’est pas repris stock de fin de période de ce produit pour la déclaration précédente doit être de 0. dans la déclaration alors que son stock théorique de fin de période précédente n’est pas nul. |
IIP1RG25 | Si le champ « autres-entrées » contient une valeur positive dans une balance des stocks (droits suspendus ou droits acquittés), alors la zone observations de la balance des stocks en question ne doit pas être vide. | 017 | Si d’autres entrées ont été indiquées, merci de remplir la case ‘observations’. |
IIP1RG26 | Si le champ « autres-sorties» contient une valeur positive dans une balance des stocks (droits suspendus ou droits acquittés), alors la zone observations de la balance des stocks en question ne doit pas être vide. | 018 | Si d’autres sorties ont été indiquées, merci de remplir la case ‘observations’. |
IIP1RG38 | Si le champ "replacements" est valorisé, alors la zone observations de la balance des stocks en question ne doit pas être vide. | 031 | Si un replacement en suspension a été indiqué, merci de remplir la case ‘observations’. |
IIP1RG40 | Le mois et l’année du replacement en suspension saisi ne peuvent dater de plus de deux ans à compter du mois et de l’année de taxation en cours. | 032 | Un replacement en suspension datant de plus de deux ans n’est pas possible. |
IIP1RG35 | Si l'exercice commercial de l'opérateur ne correspond pas à l'année civile alors l'opérateur bénéficiant de la DRA doit saisir en double le champs : Vente en France sous CRD  ; Compte CRD | / | / |
IIP1RG41 | Pour les libellés fiscaux  « MATIERES_PREMIERES_SPIRITUEUX » et « MATIERES_PREMIERES_ALCOOLS », les balises « replacements » et « ventes-france-crd-suspendus » doivent être vides. | 038 |  Les libellés fiscaux de matières premières interdisent l’utilisation de replacements et les sorties avec paiement de droits.
IIP1RG42 | Pour les libellés fiscaux « MATIERES_PREMIERES_SPIRITUEUX » et « MATIERES_PREMIERES_ALCOOLS », il faut avoir une des activités suivantes précisées dans le référentiel des opérateurs « distillateurs/producteurs d’alcools », « régénérateurs », « dénaturateurs d’alcools », « utilisateurs d’alcools en exonération », « fournisseurs à UT », « récoltants vinificateurs », « négociants vinificateurs », « caves coopératives » | 039 | L’activité de l’agrément douanier n’autorise pas l’utilisation des libellés fiscaux de matières premières.
IIP1RG43 | Les libellés fiscaux « MATIERES_PREMIERES_SPIRITUEUX » et « MATIERES_PREMIERES_ALCOOLS » ne sont pas autorisés dans les balances de stocks en droits acquittés. | 040 | Les matières premières ne sont pas autorisées dans la balance des stocks en droits acquittés.

##### Compte CRD


Code RG | Test et condition(s) | Code erreur | Message si erreur |
:-------|:---------------------|:------------|:------------------|
IIP1RG27 | Une même catégorie fiscale de capsules ne peut apparaître que deux fois maximum dans un même compte CRD. Pour les EA en acquittés (l'agrément contient la lettre "A"), il ne doit pas y avoir de compte CRD. | 019 | La catégorie de capsule <catégorie> ne devrait être présente que 2 fois maximum dans le compte CRD, ou un compte CRD a été saisi alors que l’agrément ne l’autorise pas. |
IIP1RG28 | Pour chaque catégorie de produits, il n'est possible d'avoir dans les comptes CRD que les types de capsules suivants : capsules personnalisées en DS ; capsules collectives en DS ; capsules personnalisées + collectives en DS (2 comptes distincts) ; capsules collectives en DA ; capsules collectives en DA + collectives en DS (2 comptes distincts) | 020 | Erreur sur le type de capsules déclarées. |
IIP1RG29 | Dans un même compte CRD, une centilisation définie ne peut apparaître qu’une seule fois (unicité de l’attribut « volume »  de la centilisation pour une catégorie fiscale donnée et un type de capsules donné). Cette règle exclut la centilisation « AUTRE ».  | 021  | La centilisation <volume> pour la catégorie <catégorie> (<type de capsule>) devrait être unique dans un même compte CRD. |
IIP1RG30 | Pour une centilisation donnée, le stock de fin de période doit être égal « stock-debut-période » + « entrées- | 022 | Le stock de fin de période de la centilisation <volume> pour la capsules » - « sorties-capsules ». catégorie <catégorie> (<type de capsule>) ne correspond pas aux entrées et sorties. |
IIP1RG31 | Si une centilisation d’un compte existe dans la déclaration précédente et n’a pas été repris dans la déclaration transmise, alors le stock de fin de période de cette centilisation pour la déclaration précédente doit être de 0. | 023 | La centilisation <volume> pour la catégorie <catégorie> (<type de capsule>) n’est pas reprise dans la déclaration alors que son stock théorique de fin de période précédente n’est pas nul. |
IIP1RG32 | Pour une centilisation AUTRE, le volume personnalisé et l’indicateur de ‘bag-in-box’ sont  obligatoires. | 024 | Une centilisation pour la catégorie <catégorie> (<type de capsule>) n’est pas correctement renseignée. |
IIP1RG32 | Pour une centilisation AUTRE, le couple « volume personnalisé + indicateur ‘bag-in-box » doit être unique dans un même compte CRD. | 025 | La centilisation personnalisée <volume> pour la catégorie <catégorie> (<type de capsule>) est reprise deux fois avec le même indicateur bag-in-box. |
IIP1RG32 | Pour une centilisation AUTRE, le volume personnalisé et l’indicateur bag-in-box ne doivent pas être déjà prévus dans la liste définie des centilisations. | 033 | La centilisation personnalisée <volume> pour la catégorie <catégorie> (<type de capsule>) existe déjà dans la liste de définition prévue. |
IIP1RG39 | Avec la déclaration précédente, CIEL effectue un contrôle de correspondance des comptes CRD. Pour chaque centilisation de CRD retrouvée, la valeur de « stock-début-période » doit être égale au stock de fin de période de la déclaration précédente. Si le mois de taxation de la déclaration est août (début de la campagne viti-vinicole), cette règle ne doit pas être appliquée. | 035 | La centilisation <volume> pour la catégorie <catégorie> (<type de capsule>) doit avoir un stock de début de période égal au stock de fin de période de la déclaration précédente.  |
IIP1RG33 | Pour les documents d’accompagnement, chaque numéro de fin de période doit être strictement supérieur au numéro de début de période. | 025 | Erreur sur les numéros de période des documents d'accompagnement. |
IIP1RG34 | Si le numéro d’agrément contient la lettre « A », alors le type de document ne peut être que « DSA/DSAC ». Dans le cas contraire, il ne peut s’agir que du type de document « DAA/DAC » ou « DSA/DSAC ». | 026 | L'agrément n'autorise pas les types de documents d'accompagnement saisis. |
IIP1RG42 | Le champ « Numéro d’accise destinataire » accepte : soit un numéro d’accises alphanumérique de 13 caractères ; soit un alphanumérique de 8 caractères commençant par « FR » Si le numéro d’accise commence par « FR » et contient 13 caractères, alors une vérification de l’existence de l’opérateur destinataire dans ROSA est effectuée. | 034 | Le numéro d’accise destinataire saisi dans le relevé de non apurement n’est pas correct ou n’existe pas dans le référentiel des opérateurs de la DGDDI. |
IIP1RG43 | Pour les documents d’accompagnement, les champs « Première référence de la période » et « Dernière référence de la période » acceptent :  soit une chaîne de caractères ; soit un numérique strictement positif. Dans le cas de la chaîne de caractères, toute valeur est acceptée. | 036 | Les références des documents d'accompagnement ne peuvent
pas être des nombres négatifs, nuls ou décimaux. |
IIP1RG44 | Pour les documents d’accompagnement, le champ «Nombre de référence(s) dans la période » accepte uniquement un entier strictement positif. | 037 | Le nombre de référence dans la période doit être un entier strictement positif.

####FICHIER XSD

Le fichier XSD d’IIP1-entrée est présenté dans un fichier joint à ce contrat de service.

####EXEMPLE DE PARAMÈTRES D'ENTRÉE

Un exemple de fichier XML en entrée d’IIP1 est présenté dans un fichier joint à ce contrat de service.

###PARAMÈTRES DE SORTIE

##DESCRIPTION

Les paramètres de sortie de ce service sont décrits dans un document XSD encodé en UTF-8.

Suite à l'envoi des données économiques par l'interprofession, CIEL retourne un flux
indiquant à l'interprofession la bonne prise en compte des données économiques ou le
rejet (message d'erreur).

Si les données économiques envoyées par l'interprofession à CIEL ne respectent pas une
ou plusieurs des règles de gestion définies dans le flux d'entrée de l'IIP1, alors CIEL
rejette en totalité le flux. De plus, si pour l'agrément concerné, les informations
nécessaires ne sont pas trouvées par CIEL dans le référentiel des opérateurs de la
DGDDI (ROSA), alors CIEL rejette en totalité le flux. CIEL retourne le message d'erreur
correspondant à la règle de gestion non respectée.

Si les données économiques envoyées par l'interprofession respectent l'ensemble des
règles de gestion définies dans le flux d'entrée de l'IIP1, alors CIEL confirme la bonne
prise en compte des données.

###Élément reponse-ciel

Référence    | Élément | Type | Cardinalité | Description | Obligatoire/Facultatif
:------------|:--------|:----:|:------------|:------------|:----------------------:
IIP1-S-1 | identification-declaration | int | 0..1 | Identifiant de la déclaration dans CIEL | F
IIP1-S-2 | horodatage-depot | dateTime | 0..1 | Date et heure de l’enregistrement du flux transmis | F
IIP1-S-3 | erreurs fonctionnelles | complexe | 0..n | Contient une liste de type « erreurfonctionnelle », chacune contenant un code erreur défini et un message (max 500 caractères) | F
IIP1-S-4 | erreur technique | complexe | 0..1 | Contient la référence technique de l’erreur (UUID) avec le message afférent.

Nota : si la liste des erreurs est vide (non valorisée) ou qu’il n’y a pas d’erreurs techniques,
le flux est considéré comme accepté et les deux premiers éléments sont valorisés. Dans le
cas contraire, l’identifiant de la déclaration dans CIEL de même que l’horodatage de dépôt
sont laissés vide et la liste des erreurs contient au moins un élément (raisons du rejet).

####RÈGLES DE GESTION

cf. Règles de gestion des paramètres d'entrée de l'IIP1 : Règles de gestion.

####FICHIER XSD

Le fichier XSD d’IIP1-sortie est présenté dans un fichier joint à ce contrat de service.

####EXEMPLE DE FICHIER ÉCHANGÉ

Exemples de flux XML de réponse :

Sans erreur :

    <reponse-ciel
    xmlns="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0 echanges-interprofession-1.0.xsd">
    <identifiant-declaration>1</identifiant-declaration>
    <horodatage-depot>2001-12-17T09:30:47Z</horodatage-depot>
    </reponse-ciel>

Erreurs fonctionnelles :

    <reponse-ciel
    xmlns="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0 echanges-interprofession-1.0.xsd">
    <erreurs-fonctionnelles>
    <erreur-fonctionnelle code-erreur="010">
    <message-erreur>Des éléments de la balance des stocks en
    droits suspendus ont été saisis alors que l'opérateur a
    déclaré que son stock était épuisé sur la précédente
    déclaration.</message-erreur>
    </erreur-fonctionnelle>
    <erreur-fonctionnelle code-erreur="015">
    <message-erreur>Le code INAO "123456" n’existe pas ou n’est
    pas valide.</message-erreur>
    </erreur-fonctionnelle>
    </erreurs-fonctionnelles>
    </reponse-ciel>

Erreur technique :

    <reponse-ciel
    xmlns="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://douane.finances.gouv.fr/app/ciel/interprofession/echanges/1.0 echanges-interprofession-1.0.xsd">
    <erreur-technique reference-erreur="^000000000-0000-0000-00000000000000000">
    <message-erreur>>Le flux ne répond pas au schéma de transmission
    défini. Message technique: cvc-pattern-valid : La valeur
    '0000000000' n'est pas un facet valide par rapport au modèle '[0-9]
    {9}' pour le type '#AnonType_siren-interprofessionmessageinterprofession'..</message-erreur>
    </erreur-technique>
    </reponse-ciel>

##INTERFACE IIP2 : ENVOI PAR CIEL DES DONNÉES ÉCONOMIQUES DE LA DÉCLARATION RÉCAPITULATIVE VALIDÉE À L'INTERPROFESSION

###DESCRIPTION GÉNÉRALE

IIP2. Mise à disposition des données économiques de la déclaration récapitulative validée pour l'interprofession

Type : Traitement asynchrone

Objectif : Cette interface permet aux SI des interprofessions vitivinicoles d’obtenir les
données des DRM qui ont été créées ou modifiées dans CIEL.

Acteurs : Serveur CIEL pour l'envoie ; SI des interprofessions vitivinicoles pour la récupération des données

Fréquence : Quotidienne

###FONCTIONNEMENT GÉNÉRAL

Tous les soirs, l'application CIEL constituera par interprofession, par période et par
déclarant, un fichier (archive zip) qui contiendra un lot de déclarations.

Une fois constitués, les fichiers sont envoyés par l'application CIEL aux interprofessions
correspondantes.

CIEL enverra un seul zip contenant toutes les déclarations à destination du portail X
(même si ce portail est utilisé par les interpros X et Y). La distinction sera possible en se
basant sur le numéro d'agrément indiqué dans le nom du fichier de déclaration
Chaque interprofession recevra uniquement les données économiques des DRM validées
par l'un de ses ressortissants. Dans le cas où le ressortissant utilise le portail d'une
interprofession B (prêt de portail), CIEL envoie les données économiques suite à la
validation de la DRM à l'interprofession B uniquement. Charge aux interprofessions de
définir les modalités de mutualisation des données entre interprofessions.
Une sauvegarde est effectuée sur serveur chaque jour, puis versée sur des cassettes
spécifiques à disposition une semaine en cas de besoin de restaurer les données au-delà
de J+1 (à J+1, on peut utiliser encore la sauvegarde sur serveur qui est effacée une fois
les données versées sur cassettes).

Le schéma suivant représente cet échange :


###EXPORT IIP2-E

Tous les soirs, l'application CIEL constitue autant de fichiers que de déclarations. CIEL
sélectionne regroupe les données des déclarations récapitulatives par interprofession,
période et déclarant sur chaque répertoire. CIEL sélectionne les déclarations
récapitulatives qui ont été validées (créées ou modifiées) la veille et les regroupe dans un
dossier spécifique selon les interprofessions auxquelles adhèrent les bénéficiaires de ces
DRM.

Une fois constitués, les fichiers sont envoyés par l'application CIEL par protocole SFTP
vers la plate­forme d'échange de la DNSCE. L'envoi vers les interprofessions se fera par
protocole CFT.

Les accusés de réception et mécanismes de reprise sont gérés au niveau de CFT.
Chaque fichier est nommé de la manière suivante :
canalCFT_SIREN_iddeclaration_numaccise_periodetaxation_AAAAMMJJ.xml
declarations_vitivinicoles_interprofession_SIREN_AAAAMMJJ.xml, où :

 - canalCFT est le nom du canal à utiliser pour l’envoi des fichiers
(auto­aiguillage du destinataire)
 - SIREN est remplacé par le numéro SIREN de l’interprofession destinataire du fichier ;
iddeclaration est l’identifiant technique de la déclaration dans CIEL (entier de
longueur maximale 7) ;
 - numaccise est le numéro d’accise du déclarant.leperiodetaxation est la période de taxation relative à la délcaration
 - AAAAMMJJ est remplacé par la date de l’export, au format AAAAMMJJ.

Cet export doit être exécuté en début de journée, idéalement à minuit, pour exporter les
données de la veille dès que la nouvelle journée commence.

###IMPORT IIP2-I

Chaque SI d’interprofession vitivinicole récupère le fichier qui lui est destiné et qui a été
envoyé par CIEL afin d’intégrer les données des déclarations récapitulatives qui s’y
trouvent.

NB : Les fichiers sont supprimés au bout de 14 mois.

###FICHIER ÉCHANGÉ IIP2-FI

Les fichiers échangés via cette interface sont des documents XML encodés en UTF-8.

####ÉLÉMENTS

Le formalisme (schéma XSD) est exactement le même que celui utilisé en entrée, dans le
service IIP1.

## INTERFACE IIP3 : TRANSMISSION DES DONNÉES LIÉES À UN NUMÉRO D'AGRÉMENT

L'interface IIP3 utilisera le service SEED. La description de ce flux se trouve dans la
documentation relative au service SEED. Procédure de secours en cas d’indidisponiblité des services


##PROCÉDURE DE SECOURS EN CAS D’INDIDISPONIBLITÉ DES SERVICES

###INDISPONIBILITÉ DU PORTAIL INTERPROFESSIONNEL

Il n'y aura pas, dans ce cas, de délai supplémentaire accordé aux redevables. Lorsque un
portail interprofessionnel est indisponible, l'interprofession devra orienter ses opérateurs
vers CIEL afin d'y saisir directement leurs déclarations en passant par Prodouane. Les
déclarations validées dans CIEL seront mises à disposition des inter-professions.

###INDISPONIBILITÉ DE L'APPLICATION CIEL

N jours de délai de déclaration seront donnés aux redevables sur l’ensemble des portails
interprofessionnels si CIEL est indisponible.

##ANNEXES

###CARDINALITÉS D’ÉLÉMENT XML

Ce document utilise des cardinalités pour les éléments XML. Il s’agit du nombre
d’occurrences d’un élémet pouvant apparaître dans son élément parent. Ces cardinalités
sont définies dans le tableau suivant :

Cardinalité | Description
:----------:|:--------------------
 0..1       | L’élément peut ne pas apparaître, ou apparaître une fois seulement.
 1          | L’élément doit apparaître une fois, et une fois seulement.
 0..*       | L’élément peut ne pas apparaître, apparaître une fois ou apparaître plusieurs fois.

###TYPES PRIMITIFS DE XSD

Ce document utilise plusieurs types primitifs fournis par XSD. Ces types sont définis dans
le tableau suivant :

Type | Description | Exemple
:----|:------------|:------------
boolean | Booléen | true
date | Date | 2014­07­21
dateTime |Date et heure | 2014­07­21T14:54:26
decimal | Nombre décimal | 1234.56789
gMonth | Mois | ­­07
gYear | Année | 2014
gYearMonth | Mois et année | 2014­07
int | Nombre entier | 12
nonNegativeInteger | Nombre entier positif ou nul | 4
string | Chaîne de caractères | Ceci est un exemple.

###LISTE DES LIBELLÉS FISCAUX

 - BOISSONS_FERMENTEES_AUTRES
 - BOISSONS_FERMENTEES_AUTRES_PREMIX
 - CIDRES
 - POIRES
 - HYDROMELS
 - HYDROMELS_PREMIX
 - PETILLANTS
 - PETILLANTS_PREMIX
 - VDN_VDL_AOP_SUP_18
 - VDN_VDL_AOP_INF_18
 - AUTRES_PI_SUP_18
 - AUTRES_PI_INF_18
 - AUTRES_PI_INF_18_PREMIX
 - BIERE_INF_2_8
 - BIERE_INF_2_8_PREMIX
 - BIERE_SUP_18_BRASSERIE_TAUX_NORMAL
 - BIERE_SUP_2_8_BRASSERIE_TAUX_NORMAL
 - BIERE_SUP_2_8_BRASSERIE_TAUX_NORMAL_PREMIX
 - BIERE_SUP_18_PETITE_BRASSERIE_10000
 - BIERE_SUP_2_8_PETITE_BRASSERIE_10000
 - BIERE_SUP_2_8_PETITE_BRASSERIE_10000_PREMIX
 - BIERE_SUP_18_PETITE_BRASSERIE_50000
 - BIERE_SUP_2_8_PETITE_BRASSERIE_50000
 - BIERE_SUP_2_8_PETITE_BRASSERIE_50000_PREMIX
 - BIERE_SUP_18_PETITE_BRASSERIE_200000
 - BIERE_SUP_2_8_PETITE_BRASSERIE_200000
 - BIERE_SUP_2_8_PETITE_BRASSERIE_200000_PREMIX
 - RHUM_TRADITIONNEL_DOM_ART_1
 - RHUM_TRADITIONNEL_DOM_ART_2
 - RHUM_TIERS_ET_AUTRES
 - ALCOOL_AUTRE_SUP_18
 - ALCOOL_AUTRE_INF_18
 - ALCOOL_AUTRE_INF_18_PREMIX
 - RHUM_GUADELOUPE
 - RHUM_MARTINIQUE
 - RHUM_GUYANE
 - RHUM_REUNION
 - SPIRITUEUX_GUADELOUPE_SUP_18
 - SPIRITUEUX_GUADELOUPE_INF_18
 - SPIRITUEUX_GUADELOUPE_INF_18_PREMIX
 - SPIRITUEUX_MARTINIQUE_SUP_18
 - SPIRITUEUX_MARTINIQUE_INF_18
 - SPIRITUEUX_MARTINIQUE_INF_18_PREMIX
 - SPIRITUEUX_GUYANE_SUP_18
 - SPIRITUEUX_GUYANE_INF_18
 - SPIRITUEUX_GUYANE_INF_18_PREMIX
 - SPIRITUEUX_REUNION_SUP_18
 - SPIRITUEUX_REUNION_INF_18
 - SPIRITUEUX_REUNION_INF_18_PREMIX
 - AUTRES_ALCOOLS_SUP_18
 - AUTRES_ALCOOLS_INF_18
 - AUTRES_ALCOOLS_INF_18_PREMIX
 - MATIERES_PREMIERES_SPIRITUEUX
 - MATIERES_PREMIERES_ALCOOLS
