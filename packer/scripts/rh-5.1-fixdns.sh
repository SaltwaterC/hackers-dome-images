rm -f /var/lib/dhclient/dhclient-eth0.leases

cat << EOF > /etc/resolv.conf
nameserver 8.8.8.8
nameserver 8.8.4.4
EOF

echo 'Updated /etc/resolv.conf'
cat /etc/resolv.conf

chattr +i /etc/resolv.conf
