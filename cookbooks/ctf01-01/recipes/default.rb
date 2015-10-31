%w(
  /var/spool/mail/root
  /root/anaconda-ks.cfg
  /root/install.log
  /root/install.log.syslog
  /root/.bash_history
  /var/log/httpd/access_log
  /var/log/httpd/error_log
).each do |f|
  file f do
    action :delete
  end
end

%w(
  iptables
  sendmail
  cups
  portmap
  nfs
  nfslock
).each do |s|
  service s do
    action [:disable, :stop]
  end
end

# yum_package doesn't support YUM 3.0 and 3.1
# https://tickets.opscode.com/browse/CHEF-4867
execute 'yum -y install httpd php php-mysql system-config-services'

%w(
  /etc/selinux/config
  /etc/php.ini
  /etc/sysconfig/network
  /etc/hosts
  /etc/hostname
  /var/www/html/index.html
  /var/www/html/math.jpg
  /var/www/html/info.php
).each do |f|
  cookbook_file f do
    source "rootfs#{f}"
    user 'root'
    group 'root'
    mode '0644'
    notifies :reload, 'service[httpd]', :delayed
  end
end

execute 'hostname -F /etc/hostname'

directory '/var/www/html/development' do
  user 'root'
  group 'root'
  mode '0755'
end

rd = '/var/www/html/development'
remote_directory rd do
  source "rootfs#{rd}"
  user 'root'
  group 'root'
  mode '0755'
  files_mode '0644'
  purge true
end

# root password jM^Dp7>+3Z}LJ_fX3d0Yh?vZ0(4[i*p8
user 'root' do
  password '$1$FejHOf29$x3SckSqYESn1/XoAJNIld/'
  action :modify
end

ut = '/var/www/user-trophy.txt'
cookbook_file ut do
  source "rootfs#{ut}"
  user 'apache'
  group 'apache'
  mode '0400'
end

st = '/root/superuser-trophy.txt'
cookbook_file st do
  source "rootfs#{st}"
  user 'root'
  group 'root'
  mode '0400'
end

service 'httpd' do
  action [:enable, :start]
end
