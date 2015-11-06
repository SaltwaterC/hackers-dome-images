#!/bin/bash

apt-get -y autoremove --purge chef

mount_point=$(mount | grep "/tmp/vagrant-chef" | cut -d " " -f 3)
umount $mount_point

rm -vf /home/vagrant/install.sh
rm -vrf /tmp/vagrant-chef
rm -vrf /var/chef

rm -vf /opt/implode.sh
