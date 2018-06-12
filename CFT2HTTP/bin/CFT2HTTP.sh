#!/bin/bash

. $(dirname $0)/CFT2HTTP.config

if test -e "/tmp/CFT2HTTP.lock"; then
	echo "Locked";
	exit 1;
fi
touch /tmp/CFT2HTTP.lock

if test "$1"; then
	findlimit=" -name $1"
fi

for dir in /data/axway/reception_douanes* ; do
    subrep=$(basename $dir)
    updatefile=$PUBLISHDIR"/"$subrep"/.update"
    publishdir=$(dirname $updatefile)
    if ! test -e $updatefile ; then
		mkdir -p $publishdir
		touch -d 2016-08-01 $updatefile
	fi
   ls -rt $(find $dir -type f -cnewer $updatefile $findlimit ) | while read zip ; do
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
			mois=$(grep '<mois>' $xml | head -n 1 | sed 's|</.*||' | sed 's/.*>//' | sed 's/[^0-9]//g' | xargs printf '%02d')
			annee=$(grep '<annee>' $xml | head -n 1 | sed 's|</.*||' | sed 's/.*>//' | sed 's/[^0-9]//g')
			if ! test $accise || ! test $siren ; then
				continue;
			fi
            publishfile=$publishdir"/"$siren"/"$annee"/"$mois"/"$(basename $xml)
			mkdir -p $(dirname $publishfile)
            cp $xml  $publishfile
			touch -r $xml  $publishfile
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
rm -f /tmp/$$.output /tmp/CFT2HTTP.lock
