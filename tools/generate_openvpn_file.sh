#!/bin/bash

clientname=$1

cd ~/openvpn-easy-rsa
sudo ./easyrsa build-client-full $clientname nopass
if test -f "pki/issued/"$clientname".crt"; then
mkdir -p openvpn
echo "# The name of your server to connect to" > "openvpn/cniv_"$clientname".openvpn"
echo "remote 10.20.75.250" >> "openvpn/cniv_"$clientname".openvpn"
echo "client" >> "openvpn/cniv_"$clientname".openvpn"
echo "# use a random source port instead the fixed 1194" >> "openvpn/cniv_"$clientname".openvpn"
echo "nobind" >> "openvpn/cniv_"$clientname".openvpn"
echo "" >> "openvpn/cniv_"$clientname".openvpn"
echo "# Uncomment the following line if you want to route" >> "openvpn/cniv_"$clientname".openvpn"
echo "# all traffic via the VPN" >> "openvpn/cniv_"$clientname".openvpn"
echo "# redirect-gateway def1 ipv6" >> "openvpn/cniv_"$clientname".openvpn"
echo "" >> "openvpn/cniv_"$clientname".openvpn"
echo "# To set a DNS server" >> "openvpn/cniv_"$clientname".openvpn"
echo "# dhcp-option DNS 192.168.234.1" >> "openvpn/cniv_"$clientname".openvpn"
echo "" >> "openvpn/cniv_"$clientname".openvpn"
echo "<key>" >> "openvpn/cniv_"$clientname".openvpn"
sudo cat "pki/private/"$clientname".key" >> "openvpn/cniv_"$clientname".openvpn"
echo "</key>" >> "openvpn/cniv_"$clientname".openvpn"
echo "<cert>" >> "openvpn/cniv_"$clientname".openvpn"
sudo cat "pki/issued/"$clientname".crt" >> "openvpn/cniv_"$clientname".openvpn"
echo "</cert>" >> "openvpn/cniv_"$clientname".openvpn"
echo "<ca>" >> "openvpn/cniv_"$clientname".openvpn"
sudo cat "pki/ca.crt" >> "openvpn/cniv_"$clientname".openvpn"
echo "</ca>" >> "openvpn/cniv_"$clientname".openvpn"
echo "# This is the fingerprint of the server that we trust. We generated this fingerprint" >> "openvpn/cniv_"$clientname".openvpn"
echo "# in step 2 of the server setup" >> "openvpn/cniv_"$clientname".openvpn"
echo "#peer-fingerprint 8F:24:87:F5:E4:B4:B2:B1:59:3C:E3:FE:80:2D:C3:EB:05:20:74:F6:D7:D3:27:7B:25:FB:E7:EE:A6:D7:BF:E6" >> "openvpn/cniv_"$clientname".openvpn"
echo "" >> "openvpn/cniv_"$clientname".openvpn"
echo "# The tun-mtu of the client should match the server MTU" >> "openvpn/cniv_"$clientname".openvpn"
echo "tun-mtu 1400" >> "openvpn/cniv_"$clientname".openvpn"
echo "dev tun" >> "openvpn/cniv_"$clientname".openvpn"
echo "" >> "openvpn/cniv_"$clientname".openvpn"
echo "" >> "openvpn/cniv_"$clientname".openvpn"
echo "route 10.124.131.1 255.255.255.255" >> "openvpn/cniv_"$clientname".openvpn"
echo "route 10.124.131.3 255.255.255.255" >> "openvpn/cniv_"$clientname".openvpn"
echo "route 10.124.111.12 255.255.255.255" >> "openvpn/cniv_"$clientname".openvpn"
echo "route 10.124.111.3 255.255.255.255" >> "openvpn/cniv_"$clientname".openvpn"

echo $(pwd)"/openvpn/cniv_"$clientname".openvpn generated"
fi
