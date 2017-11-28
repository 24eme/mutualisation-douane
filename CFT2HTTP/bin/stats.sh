#!/bin/bash

curl -s https://raw.githubusercontent.com/24eme/mutualisation-douane/master/README.md | awk -F '|' '{print $3}' | sed 's/[,\+]/\n/g' | grep '[0-9]' | sed 's/ *[()] */;/g' | sed 's/^ *//' | awk -F ';' '{print $2";"$1}' | sort  -t ';' -k 1,1 > /tmp/siren2interpro.csv
find publication_web/reception_douanes/ | sed 's|publication_web/reception_douanes/||'  | sed 's|/|;|' | sed 's|/|-|'  | sed 's|/.*||' | sort | uniq -c  | grep '\-' | sed 's/^ *//' | sed 's/ /;/' | awk -F ';' '{print $3";"$2";"$1}' | sort -t ';' -k 2,2 > /tmp/sirenmois.csv
join -t ';' -1 1 -2 2 /tmp/siren2interpro.csv /tmp/sirenmois.csv | awk -F ';' '{print $3";"$2";"$1";"$4}' | sort > publication_web/stats/DRMInterpro.csv.tmp
mv -f publication_web/stats/DRMInterpro.csv.tmp publication_web/stats/DRMInterpro.csv

find publication_web/reception_douanes/ -type d -exec ls -l --full-time '{}/' ';'  | grep xml   | awk '{print $6}' | sort |  uniq -c | awk '{print $2";XML créés;"$1}' > /tmp/xmlcrees.csv
ls -l --full-time donnees_cft/reception_douanes/  |  awk '{print $6}' | sort |  uniq -c | awk '{print $2";archives reçues;"$1}' > /tmp/archivesrecues.csv
cat /tmp/xmlcrees.csv /tmp/archivesrecues.csv | sort > publication_web/stats/DRMjour.csv.tmp
mv -f publication_web/stats/DRMjour.csv.tmp publication_web/stats/DRMjour.csv

rm /tmp/siren2interpro.csv /tmp/sirenmois.csv /tmp/xmlcrees.csv /tmp/archivesrecues.csv
