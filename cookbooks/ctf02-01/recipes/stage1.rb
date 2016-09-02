f = '/etc/apt/sources.list'
cookbook_file f do
  source "rootfs#{f}"
  user 'root'
  group 'root'
  mode '0644'
end

include_recipe 'apt::default'

package %w(linux-image-3.2.0-23-generic linux-headers-3.2.0-23-generic dkms)

script 'kernel_purge' do
  interpreter 'bash'
  code <<-EOF
    for linux_image in $(dpkg --list | grep linux-image | awk '{print $2}')
    do
      if [ "$linux_image" != "linux-image-3.2.0-23-generic" ]
      then
        apt-get remove --yes --purge $linux_image
      fi
    done

    apt-get autoremove --yes --purge
  EOF
end
