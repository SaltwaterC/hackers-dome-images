yum -y groupinstall Core
yum -y install gcc make kernel-headers kernel-devel-`uname -r`

# update sudo - vagrant expects sudo -E to work properly
if ((1<<32)); then
  arch=x86_64
else
  arch=i386
fi

rpm -Uvh "http://vault.centos.org/5.10/os/${arch}/CentOS/sudo-1.7.2p1-28.el5.${arch}.rpm"
