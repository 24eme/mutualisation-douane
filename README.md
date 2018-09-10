#  Espace de documentation du projet de mutualisation CNIV/DRM

Cet espace a vocation de réunir la documentation permettant de mieux s'orienter dans le projet « CIEL Lot 2 » permettant aux interprofessions du vins de transférer aux douanes les informations des DRM saisies par leurs ressortissants sur le portail de télédéclaration.

Voici les différents éléments contenu dans cet espace documentaire :
 - [Documentation de l'accès PASTEUR et des WebServices de la douane](webservice-douanes/)
 - [Scripts PHP permettant de recetter l'accès JWT](oauth/)
 - [Les différentes versions des spécification XML DRM](webservice-douanes/DRMXML)

##  Avancement des différentes interpros

| Nom du projet | Interpros (SIREN)      | Prestataire |  PASTEUR | Tocken JWT  | XML DRM recetté | SEED | Recette VDI | XML en Prod | Retour XML | URL du projet |
|---------------|-----------------|-------------|----------|-------------|-----------------|------|-------------|-------------|------------|---------------|
| Declarvins    | InterRhone (783204001), CIVP (451070197), IVSE (513558494) | 24ème | OK   | OK          | OK              | OK   | OK          | OK          | OK          | [declarvins.net](http://declarvins.net/) |
| VinsValDeLoire.pro | InterLoire (429164072)        | 24ème | OK  | OK          | OK              | OK   | OK          | OK          | OK           | [vinsvaldeloire.pro](http://vinsvaldeloire.pro) |
| VinsAlsace.pro| CIVA (778904706)                  | 24ème | OK   | OK          | OK              | OK   | OK            | OK             | OK            | [vinsalsace.pro](http://vinsalsace.pro)  |
| IVBDpro       | IVBD (781641329)       | 24ème | OK   | OK          | OK              | OK   |  OK         | OK            | OK           | [ivbdpro.fr](http://ivbdpro.fr) |
| IVSOpro       | IVSO (387577851) + Cahors / Floc / Armangnac| 24ème |OK| OK     | OK              | OK   |  OK         | OK             | OK           | [ivsopro.com](http://ivsopro.com) |
| Registre de cave Extranet de Beaujolais | Inter Beaujolais (779759935) |  RMSI| OK |OK| OK | OK | OK   | OK    | OK     | [extranet.beaujolais.com](http://extranet.beaujolais.com/)  |
| DeclaViti     | CIVR (434341103), Oc (489331314), InterSud (493069546), CIVL (399153386)     | Infodial | OK    |   OK       |       OK       |  OK   | OK          | OK          | OK         | [declaviti.fr](https://declaviti.fr/)|
| DematVin      | BIVB  (378184758)        | Estalis - HelixDev| OK    | OK         | OK  | OK  | OK   | OK  | OK  | [extranet.bivb.com](https://extranet.bivb.com/)   |
| Vins Centre Loire      | BIVC  (402946016)        |  24ème | OK    | OK         | OK  | OK  | OK   | OK  | OK  | [declaration.vins-centre-loire.com](https://declaration.vins-centre-loire.com/)   |

## Statistiques d'usage

Deux fichiers sont mis à disposition aux interprofessions partenaires (via le VPN) :
 - Nombre de XML reçues par interpros : [http://10.222.223.1/stats/DRMInterpro.csv](http://10.222.223.1/stats/DRMInterpro.csv)
 - Nombre de XML générés et les archives transmises par la douane par jour : [http://10.222.223.1/stats/DRMjour.csv](http://10.222.223.1/stats/DRMjour.csv)

Ils sont mis à jour quotidiennement (à 8h30)
