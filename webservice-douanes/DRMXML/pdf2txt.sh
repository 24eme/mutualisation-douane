#!/bin/bash

pdftotext $1
sed -i 's/^Page [0-9]*\/[0-9]*//' CIEL*txt
sed -i 's/^CIEL[- ]*Contrat de service avec les interprofessions.*odt//' CIEL*txt
sed -i 's/Ce document est la propriété de la DGDDI et ne peut être ni divulgué ni copié sans son autorisation. Les citations doivent mentionner la source.//' CIEL*txt
sed -i 's/^.*Contrat de service//' CIEL*txt

