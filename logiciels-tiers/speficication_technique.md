#Spécifications techniques du format « webservice DRM » des portails Déclarvins (InterRhone, CIVP, IVSE), CIVA, InterLoire, IVBD et IVSO.

##Architecture technique de sécurité

###Authentification des utilisateurs

Tous les utilisateurs déclarant ayant accès à la plateforme devront être authentifiés. Avant de pouvoir consulter n'importe quelle page, les utilisateurs doivent donc s'identifier sur le service d’authentification unique et centralisée CAS [1].

Cette authentification se réalisera sur la base d'un identifiant et d'un mot de passe connus des seuls utilisateurs.

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

Les nombres décimaux peuvent avoir pour séparateur décimal une virgule « , » ou un point « . ». Dans le cas ou la virgule « , » est choisi, bien faire attention qu'il n'y ait pas de confusion avec le séparateur du CSV.

###Sécurité des transferts

Toutes les connexions réalisées sur l'interface de saisie des DRM se feront via le protocole HTTPS [3].

##Description de l'interface DRM

La création d'une DRM préremplie sur la plateforme de télédéclaration des interpros peut se faire de deux manières :

 - par envoi automatique depuis un logiciel tiers : c'est l'interface EDI
 - par dépot manuel par les utilisateurs de la plateforme via un formulaire HTML d'*upload* : c'est l'interface DTI+

###Domaine dédié à l'EDI

Un nom de domaine est dédié aux tests et un autre à la production, les URL fournies dans ce document font abstraction du nom de domaine à utiliser.

Un nom de domaine de pré-production et un de production sont mis à disposition sur le portail des interpros.

###Envoi des informations par EDI

Voici les détails téchnique pour accéder au webservice d'envoi EDI d'une DRM :

 - Protocole : HTTPS
 - Authentification : HTTP Authentication Basic
 - Encodage des caractères : UTF-8
 - Format des données à fournir en entrée : CSV
 - Format des données fournies en sortie : Aucun ou CSV
 - Type de requete : POST x-www-form-urlencoded
 - URL : *mis à disposition sur le portail des interpros*

##Fichier attendu par les interfaces DTI+ et EDI

Le fichier décrivant les éléments constitutifs de la DRM qui devra être fourni par les logiciels de gestion de cave est un fichier CSV.

###Organisation générale 

Le fichier CSV permet de déclarer les différentes informations liées à la DRM.

Les premiers champ de chaque ligne sont des champs communs pour tout le fichier, ils décrivent :
 - le type de ligne concernée (CAVE, CRD, ANNEXE, comme décrit plus bas)
 - la période de la DRM courante (format AAAAMM)
 - l'identifiant interpro du chai
 - le numéro d'accise du ressortisant

Le fichier CSV est constitué de trois types de lignes :
 - CAVE : pour déclarer le stock et les mouvements de cave ;
 - CRD : pour déclarer le stock et les mouvements de CRD ;
 - ANNEXE : pour les informations demandées en annexe par les douanes (documents d'accompagnement, observations, ...)

L'idée du fichier CSV est de permettre d'autres exploitations que celles liées à la télédéclaration des DRM. Certaines informations peuvent être éclatées en plusieurs champs afin par exemple de permettre des utilisations statistiques (c'est le cas notamment pour la description des produits).

Les trois types de lignes se basent sur une structure commune. Cette structure s'organise autour de cinq sections de champs :
 - la partie commune (4 champs) qui fournit les informations liées à la DRM et permet d'identifier le type de ligne
 - la partie identification du produit (9 champs) qui permet d'identifier le vin déclaré, le type de CRD ou d'annexe)
 - la partie identification du mouvement (3 champs) qui permet d'idenfifier le type de mouvement ou le stock concerné
 - la quantité de produit concerné (1 champ) qui permet de connaître le volume ou la quantité associée au mouvement
 - la partie détail (3 champs) qui permet d'indiquer les détails nécessaires à la déclaration du mouvement (pays d'export, n° de contrat concerné, ...)

La partie identification du produit peut être utilisé soit de manière éclaté (qui permet de faire des exploitations statistiques sur les appellations, les couleurs, ...), soit de manière agrégé en indiquant le nom complet du produit ou du type de CRD dans le premier champ de cette section.

###Description des lignes CAVE

Les lignes de CAVE se constituents des champs suivants :

 **Pour la section commune :**
 
 1. CAVE (champ obligatoire à valeur fixe) 
 2. La période de la DRM (champ obligatoire au format AAAA-MM)  
 3. L'identification de l'établissement (champ alpha-numérique obligatoire)
 4. Le numéro d'accise (champ alpha-numérique de 13 caractères obligatoire)

 **Pour l'identification du vin :**

 5. Le code certification du vin (champ obligatoire)  
 6. Le code genre du vin (champ obligatoire)  
 7. Le code appellation du vin (champ facultatif)
 8. Le code mention du vin (champ facultatif)  
 9. Le code lieu du vin (champ facultatif)
 10. Le code couleur du vin (champ obligatoire)
 11. Le code cépage du vin (champ facultatif)
 12. Le libellé personnalisé du vin (champ facultatif)
 13. Le complément du vin (champ facultatif)

 **Pour le type de mouvement :**
 
 14. Le type de la DRM : (champ obligatoire, ex: suspendu, acquitte)
 15. La catégorie de mouvement : (champ obligatoire, ex: stocks, stock_debut, entrée, sortie, stock _fin ...)
 16. Le type de mouvement (champ obligatoire, ex: renvendiqué, achat, ...)

 **Pour la quantité :**
 
 17. Le volume en hl (ou valeur information complémentaire)
 
 **Pour les détails :**
 
 18. Le pays d'export ([Code ISO 3166](https://fr.wikipedia.org/wiki/ISO_3166)) si le mouvement est un export / la période au format AAAAMM si le mouvement est une entrée replacement en suspension CRD / sinon vide
 19. Le numéro du contrat (si le mouvement est une sortie vrac sous contrat, sinon vide)
 20. Le numéro de document d'accompagnement (si le mouvement fait l'objet d'un document d'accompagnement douanier, sinon vide)


**Cas des informations complémentaires**

La douane demande parfois des informations complémentaires pour un produit afin de déclarer son **taux d'alcool volume (TAV)**, le **premix** ou des **observations**. Dans ce cas ces informations sont transmises via un mouvement "complement". Le champ 17 indiquera la valeur pour ces informations (flottant pour TAV, boolean pour premix et chaine de caractère pour observation)

[Voici un exemple ne contenant que quelques lignes de type CAVE](exemple_cave.csv "csv_de_type_cave")

###Description des lignes CRD

 **Pour la section commune :**
 
 1. CRD (champ obligatoire à valeur fixe)  
 2. La période de la DRM (champ obligatoire au format AAAAMM)
 3. L'identification de l'établissement (champ alpha-numérique obligatoire)
 4. Le numéro d'accise (champ alpha-numérique de 13 caractères obligatoire)
 
 **Pour l'identification de la CRD :**
 
 5. La couleur de la CRD (champ facultatif)
 6. La catégorie fiscale de la CRD (champ obligatoire)
 7. Le centilitrage de la CRD (champ obligatoire)
 8. vide
 9. vide
 10. vide
 11. vide
 12. vide
 13. vide
 
 **Pour le type de mouvement :**
 
 14. Type de la CDR (champ obligatoire)
 15. La catégorie de mouvement : (champ obligatoire, ex: stock_debut, entrée, sortie, stock _fin)
 16. Le type de mouvement (champ obligatoire, ex: perte, achat, utilisations, ...)
 
 **Pour la quantité :**
 
 17. La quantité de CRD (champ obligatoire au format nombre entier)

 **Pour les détails :**
 
 18. vide
 19. vide
 20. vide

[Voici un exemple ne contenant que quelques lignes de type CRD](exemple_crd.csv "csv_de_type_crd")

###Description des lignes ANNEXE

 **Pour la section commune :**
 
 1. ANNEXE (champ obligatoire à valeur fixe)  
 2. La Période de la DRM (champ obligatoire au format AAAAMM)
 3. L'identification de l'établissement (champ alpha-numérique obligatoire)
 4. Le numéro d'accise (champ alpha-numérique de 13 caractères obligatoire)
 
 **Pour la description du produit :**
 
 5. vide
 6. vide
 7. vide
 8. vide
 9. vide
 10. vide
 11. vide
 12. vide
 13. vide
 
 **Pour le type de mouvement :**
 
 14. vide
 15. La catégorie d'annexe (champ obligatoire, ex: empreinte, daa, dsa, rna, statistiques, ...)
 16. Le type lié à la catégorie d'annexe (champ facultatif, ex: debut, fin, jus, mcr, vinaigre ...)
 
 **Pour la quantité :**
 
 17. La Valeur d'annexe (champsfacultatif)
 
 **Pour les compléments :**
 
 18. La date d'expédition (champ obligatoire au format AAAA-MM-DD si l'annexe est un relevé de non apurement, sinon vide)
 19. Le numéro d'accise du destinataire (champ obligatoire au format alpha-numérique de 13 caractères si l'annexe est un relevé de non apurement, sinon vide)
 20. Le numéro DAA/DAC/DAE (champ obligatoire au format nombre entier si l'annexe est un relevé de non apurement, sinon vide)

[Voici un exemple ne contenant que quelques lignes de type ANNEXE](exemple_annexe.csv "csv_de_type_annexe")

###Exemple de CSV complet

[Vous trouverez ici un exemple complet possèdant plusieurs produits, crds et annexes différentes](export_edi_complet.csv "csv_complet")

   [1]: https://jasig.github.io/cas/4.0.x/index.html
   [2]: https://fr.wikipedia.org/wiki/Authentification_HTTP
   [3]: https://tools.ietf.org/html/rfc2818
   [4]: http://www.w3.org/TR/html401/interact/forms.html#h-17.13.4.1
   [5]: https://fr.wikipedia.org/wiki/Comma-separated_values
   [6]: https://fr.wikipedia.org/wiki/UTF-8
