#!/bin/bash

yum -y erase chef

mount_point=$(mount | grep "/tmp/vagrant-chef" | cut -d " " -f 3)
umount $mount_point

rm -vf /home/vagrant/install.sh
rm -vrf /tmp/vagrant-chef
rm -vrf /var/chef

rm -vf /var/lib/dhclient/dhclient-eth0.leases
rm -vf /var/lib/dhclient/dhclient-eth1.leases
chattr -i /etc/resolv.conf
echo 'PEERDNS=yes' >> /etc/sysconfig/network-scripts/ifcfg-eth0

rm -vf /etc/ssh/ssh_host_*

rm -vf /opt/implode.sh
