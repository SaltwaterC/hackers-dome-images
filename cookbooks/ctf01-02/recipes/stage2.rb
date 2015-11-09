unless node['ctf01-02']['skip_stage_check'] == true
  cmd = 'uname -r'
  if Mixlib::ShellOut(cmd).new.stdout != "3.8.0-29-generic\n"
    fail 'Error: expecting kernel 3.8.0-29-generic after stage1'
  end
end

package %w(virtualbox-guest-utils virtualbox-guest-x11 virtualbox-guest-dkms) do
  action :purge
  not_if { node['ctf01-02']['skip_stage_check'] }
end

script 'update_virtualbox_guest_additions' do
  interpreter 'bash'
  code <<-EOF
    VBOX_VERSION="#{node['ctf01-02']['vbox_version']}"
    curl "http://download.virtualbox.org/virtualbox/${VBOX_VERSION}/VBoxGuestAdditions_${VBOX_VERSION}.iso" -o /tmp/vbox.iso
    mount -o loop /tmp/vbox.iso /mnt
    yes | sh /mnt/VBoxLinuxAdditions.run --nox11
    umount /mnt
    rm -f /tmp/vbox.iso
  EOF
  not_if { node['ctf01-02']['skip_stage_check'] }
end
