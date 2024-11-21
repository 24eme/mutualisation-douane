nom=$1

if ! test "$nom"; then
	echo Indiquer le nom du fichier en parametre
	exit 1;
fi

#openssl genrsa -aes256 -out private/ca.key.pem
#openssl req -new -x509 -days 3650 -key private/ca.key.pem -extensions v3_ca -out certs/ca.cert.pem

echo "========================="
echo "Eviter les accents et caractères non ascii"
echo "========================="

openssl genrsa -out "private/"$nom".key"
openssl req -new -days 1095 -key "private/"$nom".key" -out "certs/"$nom".csr"
openssl ca -days 1095 -keyfile private/ca.key.pem -config openssl.cnf -cert certs/ca.cert.pem -in "certs/"$nom".csr" -out "certs/"$nom".crt"
