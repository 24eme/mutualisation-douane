# Vérification Ciel Lot 1

Pour les négoicants pur, il y a un XSD spécial. Voici comment vérifier la conformité d'un XML DRM avec le XSD : 

     xmllint --schema lot1-1.0.12.xsd DRM-00000001-20200220.xml --noout

xmllint est disponible sous Debian via le paquet `libxml2-utils`.
