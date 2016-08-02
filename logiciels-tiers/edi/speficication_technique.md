#Spécifications techniques de l'EDI DRM des portails Déclarvins (InterRhone, CIVP, IVSE), CIVA, InterLoire, IVBD et IVSO.

##Architecture technique de sécurité

###Authentification des utilisateurs

Tous les utilisateurs déclarant ayant accès à la plateforme devront être authentifiés. Avant de pouvoir consulter n'importe quelle page, les utilisateurs doivent donc s'identifier sur le service d’authentification unique et centralisée CAS [1].

Cette authentification se réalisera sur la base d'un identifiant et d'un mot de passe connus des seuls utilisateurs. Pour toute ouverture d'un compte, un courrier papier est envoyé au télédéclarant contenant un code unique permettant la création du compte et la définition d'un mot de passe.

Sur l'application, les utilisateurs seront reconnus via un cookie de session fourni par le framework Symfony pour l'interface DTI et via une authentification HTTP [2] pour l'EDI.

Les informations relatives aux identifiants/mots de passe, aux cookies ou aux authentifications HTTP seront transférées en HTTPS [3] comme tout le reste des informations.

###Authentification - DTI

Les fichiers CSV provenant des logiciels de gestion cave pourront être « uploadé » sur l'espace DRM du ressortissant. Dans ce cas, l'utilisateur s'authentifiera de manière classique au portail de son interpro.

###Authentification - EDI

L'interface EDI n'est accessible qu'après authentification. L'authentification nécessite que l'utilisateur possède un compte sur la plateforme de télédéclaration des interpros. Une fois ce compte créé, l'utilisateur pourra s'identifier sur la plateforme EDI en fournissant son login et mot de passe via le protocole d'authentification HTTP (HTTP Authentication Basic [2]).

###Protocole technique utilisé

L'EDI mis à disposition des vignerons est accessible à travers le protocole HTTPS. Pour l'envoi d'information, la méthode POST x-www-form-urlencoded [4] doit être implémentée.

###Échange de données

Les données échangées en mode lecture ou écriture se font sous le format CSV [5]. La plateforme supporte indifféremment les séparateurs virgules (« , ») ou point-virgules (« ; »). En revanche, il est nécessaire qu'un seul type de séparateur soit utilisé  au sein d'un même document.

La plateforme de télédéclération est insensible à la casse et aux caractères accentués. Les chaines de caractères « Côte » ou « cote » seront donc traitées de manière identique.
Il faut noter toute fois, qu'en cas d'utilisation de caractères accentués, ces caractères devront être encodés en UTF-8 [6]. 

Débuter une ligne par le caractère « # » permet de définir des commentaires. Elles ne sont donc pas prises en compte par la plateforme.

Les nombres décimaux peuvent avoir pour séparateur décimal une virgule « , » ou un point « . ». Dans le cas ou la virgule « , » est choisi, bien faire attention qu'il n'y ai pas de confusion avec le séparateur du CSV.

###Sécurité des transferts

Toutes les connexions réalisées sur l'interface de saisie des DRM se feront via le protocole HTTPS [3].

##Description de l'interfaces DRM

La création d'une DRM préremplie sur la plateforme de télédéclaration des interpros peut se faire de deux manières :

 - par envoi automatique depuis un logiciel tiers : c'est l'interface EDI
 - par dépot manuel par les utilisateurs de la plateforme via un formulaire HTML d'*upload* : c'est l'interface DTI+

###Domaine dédié à l'EDI

Un nom de domaine est dédié aux tests et un autre à la production, les URL fournies dans ce document font abstraction du nom de domaine à utiliser.

Un nom de domaine de production et un de production sont mis à disposition sur le portail des interpros.

###Envoi des informations par EDI

Voici les détails téchnique pour accéder au webservice d'envoi EDI d'une DRM :

 - Protocole : HTTPS
 - Authentification : HTTP Authentication Basic
 - Encodage des caractères : UTF-8
 - Format des données à fournir en entrée : CSV
 - Format des données fournies en sortie : Aucun
 - Type de requete : POST x-www-form-urlencoded
 - URL : /edi/etablissement/drm/:id_chais:/:datedrm:
   avec :
   - *:id_chais:* : l'identifiant interpro du chai
   - *:datedrm:* : la date de la DRM au format AAAAMM (soit pour la DRM d'aout 2015, 201508)

##Fichier attendu par les interfaces DTI+ et EDI

Le fichier décrivant les éléments constitutifs de la DRM qui devra être fourni par les logiciels de gestion de cave est un fichier CSV.

###Organisation générale 

Le fichier CSV permet de déclarer les différentes informations liée à la DRM.

Les premiers champs de chaque ligne sont des champs communs pour tout le fichier, ils décrivent :
 - le type de ligne concernée (CAVE, CRD, ANNEXE, comme décrit plus bas)
 - la date de la DRM courrante (format AAAAMM)
 - l'identifiant interpro du champs (chiffres constitué de l'identifiant interpro (6 à 10 chiffres) et d'un identifiant du chai sur deux chiffres, si le ressortissant concerné n'a qu'un chai et que sont compte interpro est 800999, son identifiant de chais sera 80099901)
 - le numéro d'ascise du ressortisant

Le fichier CSV est constitué de trois types de lignes :
 - CAVE : pour déclarer le stock et les mouvements de cave ;
 - CRD : pour déclarer le stock et les mouvements de CRD ;
 - ANNEXE : pour les informations demandées en annexe par les douanes (documents d'accompagnement, taux de sucre, observations, ...)

L'idée du fichier CSV est de permettre d'autres exploitations que celles liées à la télédéclaration des DRM. Certaines informations peuvent être éclatées en plusieurs champs afin par exemple de permettre des utilisation statistique (c'est le cas notamment pour la description des produits).

Les 3 types de lignes se basent toutes les trois sur une structure commune. Cette structure s'organise autour des 5 sections de champs :
 - la partie commune (4 champs) qui fournit les informations liée à la DRM et permet d'identifier le type de ligne
 - la partie identification du produit (9 champs) qui permet d'identifier le vin déclaré, le type de CRD ou d'annexe)
 - la partie identification du mouvement (3 champs) qui permet d'idenfifier si le type de mouvement ou de stock concerné
 - la quantité de produit concernée (1 champs) qui permet de connaître le volume ou le nombre de CRD associé au mouvement concerné
 - la partie détails (3 champs) qui permet d'indiquer les détails nécessaires à la déclaration du mouvement (pays d'export, n° de contrat concerné, ...)

La partie identification du produit peut être utilisé soit de manière éclaté (qui permet de faire des exploitations statistiques sur les appellations, les couleurs, ...), soit de manière agrégé en indiquant le nom complet du produit ou du type de CRD dans le premier champs de cette section.

###Description des lignes CAVE

Les lignes de CAVE se constituents des champs suivants :

 **Pour la section commune :**
 
 1. CAVE
 2. Date de la DRM (AAAAMM)
 3. Identification du chais (8 chiffres)
 4. Numéro d'ascise

 **Pour l'identification du vin :**

 5. Certification du vin (AOC, IGP, Sans IG, ...) ou nom du produit complet
 6. Genre du vin (Tranquille, Effervecent, ...) ou vide
 7. Appellation du vin (Anjou, Alsace Grand Cru, Côtes-du-rhône, ...) ou vide
 8. Mention du vin (Primeur, ...) ou vide
 9. Lieu du vin (par exemple "Gorges" pour le Muscadet Sèvre et Maine, "Sommerberg" pour Grand Cru Alsace) ou vide
 10. Couleur du vin (Blanc, Rouge ou Rosé) ou vide
 11. Le cépage du vin (Melon, Gewurztraminer, ...) ou vide
 12. Complément produit (AB, Millesime, ...) ou vide
 13. Libellé personnalisé du produit (Chaine de caractère libre)

 **Pour le type de mouvement :**
 
 14. Le type de la DRM (suspendu ou acquitte)
 15. La catégorie du mouvement (stock_debut, entrée, sortie, stock _fin)
 16. Le nom du mouvement (renvendiqué, achat, ...)

 **Pour la quantité :**
 
 17. volume en hl (ou valeur information complémentaire)
 
 **Pour les détails :**
 
 18. le pays de l'export (Code ISO 3166 https://fr.wikipedia.org/wiki/ISO_3166) (si le mouvement est un export, sinon vide)
 19. le numéro du contrat (si le mouvement est une sortie vrac sous contrat, sinon vide)
 20. le numéro de document d'accompagnement (si le mouvement fait l'objet d'un document d'accompagnement douanier)

Le CVS peut contenir plusieurs mouvements de même type. Dans ce cas ils seront additionnés.

**Cas des informations complémentaires**

La douane demande parfois des informations complémentaires afin de déclarer pour un produit son **taux d'alcool volume (TAV)**, le **premix** ou des **observations**. Dans ce cas ces informations sont transmises via un mouvement "complément". Le champs 17 indiquera la valeur pour ces informations (entier pour TAV, boolean pour premix et chaine de caractère pour observation)

[Voici un exemple ne contenant que quelques lignes de type CAVE](https://github.com/24eme/mutualisation-douane/blob/master/logiciels-tiers/edi/exemple_cave.csv "csv_de_type_cave")

###Description des lignes CRD

 **Pour la section commune :**
 
 1. CRD
 2. Date de la DRM (AAAAMM)
 3. Identification du chais (8 chiffres)
 4. Numéro d'ascise
 
 **Pour l'identification de la CRD :**
 
 5. Couleur de la CDR (vert, bleu ou lie de vin)
 6. Genre de la CDR (tranquille, mousseux, vdn, ...)
 7. centilitrage
 8. vide
 9. vide
 10. vide
 11. vide
 
 **Pour le type de mouvement :**
 
 12. Type de capsule (suspendue collective, acquittee collective, personnalisee)
 13. La catégorie du mouvement (stock_debut, entrée, sortie, stock _fin)
 14. le nom du mouvement (perte, achat, utilisations, ...)
 
 **Pour la quantité :**
 
 15. nombre de CRD 

Il n'y a pas de champs compléments pour les CRD.

Comme pour les mouvements de Cave, il est possible d'indiquer plusieurs mouvements identiques de CRD. Dans ce cas, les quantités sont additionnées.

[Voici un exemple ne contenant que quelques lignes de type CRD](https://github.com/24eme/mutualisation-douane/blob/master/logiciels-tiers/edi/exemple_crd.csv "csv_de_type_crd")

###Description des lignes ANNEXE

 **Pour la section commune :**
 
 1. ANNEXE
 2. Date de la DRM (AAAAMM)
 3. Identification du chais (8 chiffres)
 4. Numéro d'ascise
 
 **Pour la description du produit :**
 
 5. vide
 6. vide
 7. vide
 8. vide
 9. vide
 10. vide
 11. vide
 
 **Pour le type de mouvement :**
 
 12. vide
 13. Type d'annexe (DAADAC, DSADSAC, EMPREINTE, NONAPUREMENT, STATS EUROPEENNES) 
 14. "debut" ou "fin" (pour les numeros d'empruntes, DAA, DSA, ...), JUS, MCR et VINAIGRE pour l'annexe STATS EUROPEENNES
 
 **Pour la quantité :**
 
 15. quantité (en kg pour les sucres)
 
 **Pour les compléments :**
 
 16. date d'envoi (pour le type non apurement)
 17. numero d'ascise du destinataire (pour le non apurement)
 18. le numéro de document d'accompagnement (pour les documents DAADAC, DSADSAC, EMPREINTE et non apurement)

[Voici un exemple ne contenant que quelques lignes de type ANNEXE](https://github.com/24eme/mutualisation-douane/blob/master/logiciels-tiers/edi/exemple_annexe.csv "csv_de_type_annexe")

###Exemple de CSV complet

[Vous trouverez ici un exemple complet possèdant plusieurs produits, crds et annexes différentes](https://github.com/24eme/mutualisation-douane/blob/master/logiciels-tiers/edi/export_edi_complet.csv "csv_complet")

   [1]: https://jasig.github.io/cas/4.0.x/index.html
   [2]: https://fr.wikipedia.org/wiki/Authentification_HTTP
   [3]: https://tools.ietf.org/html/rfc2818
   [4]: http://www.w3.org/TR/html401/interact/forms.html#h-17.13.4.1
   [5]: https://fr.wikipedia.org/wiki/Comma-separated_values
   [6]: https://fr.wikipedia.org/wiki/UTF-8
