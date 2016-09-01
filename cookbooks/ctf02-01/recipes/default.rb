%w(
  /var/mail/root
  /root/.bash_history
  /home/ubuntu/.bash_history
  /var/log/auth.log
  /var/log/apache2/access.log
  /var/log/apache2/error.log
  /var/log/apache2/other_vhosts_access.log
  /etc/udev/rules.d/70-persistent-net.rules
).each do |fi|
  file fi do
    action :delete
  end
end
