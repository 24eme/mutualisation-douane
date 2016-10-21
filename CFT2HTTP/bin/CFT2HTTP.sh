#!/bin/bash

. $(dirname $0)/CFT2HTTP.config

for dir in $CFTDIRS ; do
    subrep=$(basename $dir)
	updatefile=$PUBLISHDIR"/"$subrep"/.update"
    publishdir=$(dirname $updatefile)
    if ! test -e $updatefile ; then
		mkdir -p $publishdir
		touch -d 2016-08-01 $updatefile
	fi
	ls -rt $(find $dir -type f -cnewer $updatefile ) | while read zip ; do
        if ! file $zip | grep -i "zip archive" > /tmp/$$.output ; then
			continue;
		fi
        cat /tmp/$$.output | sed 's/:.*/:/' 
		cp $zip /tmp/$$.zip
        mkdir -p /tmp/$$_files/
        unzip -u /tmp/$$.zip -d /tmp/$$_files/ > /dev/null
        find /tmp/$$_files/ -type f | while read xml ; do
			accise=$(grep agrement $xml | sed 's|</.*||' | sed 's/.*>//')
			siren=$(grep siren $xml | sed 's|</.*||' | sed 's/.*>//')
			mois=$(grep '<mois>' $xml | sed 's|</.*||' | sed 's/.*>//' | xargs printf '%02d')
			annee=$(grep '<annee>' $xml | sed 's|</.*||' | sed 's/.*>//')
			if ! test $accise || ! test $siren ; then
				continue;
			fi
            publishfile=$publishdir"/"$siren"/"$annee"/"$mois"/"$(basename $xml)
			mkdir -p $(dirname $publishfile)
            cp $xml  $publishfile
			printf "\t"$publishfile"\n"
        done
        echo $zip > /tmp/$$.lastzip
        rm -rf /tmp/$$.zip /tmp/$$_files
    done
    if test -e /tmp/$$.lastzip ; then
	    touch -r $(cat /tmp/$$.lastzip) $updatefile
	    rm /tmp/$$.lastzip
	fi
done
rm -f /tmp/$$.output

