f = '/etc/apt/sources.list'
cookbook_file f do
  source "rootfs#{f}"
  user 'root'
  group 'root'
  mode '0644'
end

include_recipe 'apt::default'
include_recipe 'ark::default'

%w(
  /var/mail/root
  /root/.bash_history
  /home/xubuntu/.bash_history
  /var/log/auth.log
  /var/www/index.html
  /var/log/apache2/access.log
  /var/log/apache2/error.log
  /var/log/apache2/other_vhosts_access.log
  /etc/udev/rules.d/70-persistent-net.rules
).each do |f|
  file f do
    action :delete
  end
end

pkg = %w(
  xubuntu-desktop
  linux-image-3.8.0-29-generic
  apache2
  libapache2-mod-php5
  flashplugin-installer
  build-essential
  git
  htop
)
package pkg

%w(
  /var/www/index.php
  /etc/hosts
  /etc/hostname
  /etc/apache2/conf.d/fqdn
  /etc/apache2/htpasswd
  /etc/apache2/sites-available/default
  /etc/apache2/sites-available/default-localhost
  /etc/ssh/sshd_config
).each do |f|
  cookbook_file f do
    source "rootfs#{f}"
    owner 'root'
    group 'root'
    mode '0644'
    notifies :reload, 'service[apache2]', :delayed
    notifies :reload, 'service[ssh]', :delayed
  end
end

execute 'hostname -F /etc/hostname'

group 'xubuntu' do
  gid '600'
end

# xubuntu password ca-4u$j*wd5?LcKqAM5"(Y5tbYZ9[jEN
user 'xubuntu' do
  uid '600'
  gid 'xubuntu'
  home '/home/xubuntu'
  shell '/bin/bash'
  password '$6$BShdj9H4$1XEhTO3y69iajsUj0Mb3Wmyt6HtVeNQcqImOWs0RiIfVOPgl9x4mXOKJVluzNxXkRVTK9jLOSVVhO6lNpDR740'
end

# manage_home is useless
directory '/home/xubuntu' do
  user 'xubuntu'
  group 'xubuntu'
  mode '700'
end

execute '/usr/lib/lightdm/lightdm-set-defaults --autologin xubuntu'

ark 'firefox' do
  url 'http://ftp.mozilla.org/pub/mozilla.org/firefox/releases/17.0.1/linux-x86_64/en-US/firefox-17.0.1.tar.bz2'
  version '17.0.1'
  checksum 'e05963b4c8906e4b660717070bee568a3b3b0680667ea9eaa53d9b424f5f8843'
  prefix_root '/opt'
  home_dir '/opt/firefox'
end

f = '/var/www/messages.txt'
cookbook_file f do
  source "rootfs#{f}"
  user 'xubuntu'
  group 'xubuntu'
  mode '0666'
end

f = '/opt/ff-run.sh'
cookbook_file f do
  source "rootfs#{f}"
  user 'xubuntu'
  group 'xubuntu'
  mode '0755'
end

cron 'firefox' do
  user 'xubuntu'
  command '/opt/ff-run.sh'
end

f = '/home/xubuntu/user-trophy.txt'
cookbook_file f do
  source "rootfs#{f}"
  user 'xubuntu'
  group 'xubuntu'
  mode '0400'
end

f = '/root/superuser-trophy.txt'
cookbook_file f do
  source "rootfs#{f}"
  user 'root'
  group 'root'
  mode '0400'
end

link '/etc/apache2/sites-enabled/default-localhost' do
  to '/etc/apache2/sites-available/default-localhost'
  notifies :reload, 'service[apache2]', :delayed
end

script 'kernel-purge' do
  interpreter 'bash'
  code <<-EOF
    for linux_image in $(dpkg --list | grep linux-image | awk '{print $2}')
    do
    	if [ "$linux_image" != "linux-image-3.8.0-29-generic" ]
    	then
    		apt-get remove --yes --purge $linux_image
    	fi
    done

    apt-get autoremove --yes --purge
  EOF
end

%w(ssh apache2).each do |s|
  service s do
    action [:enable, :start]
  end
end

execute 'reboot' do
  not_if { `uname -r` == "3.8.0-29-generic\n" }
end
