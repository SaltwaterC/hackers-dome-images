yum -y erase gcc make kernel-headers kernel-devel-`uname -r`
yum -y clean all
rm -rf VBoxGuestAdditions_*.iso
rm -rf /tmp/rubygems-*
rm -f /etc/ssh/ssh_host_*
