#!/bin/bash


ls certs/*crt | while read cert ; do echo $cert ; openssl x509 -noout -dates < $cert | grep notAfter ; echo ; done 
