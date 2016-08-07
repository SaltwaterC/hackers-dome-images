extend Chef::Mixin::ShellOut

uname_r = shell_out('uname -r').stdout
expect_version = "3.8.0-29-generic\n"

unless node['ctf01-02']['skip_stage_check'] == true
  if uname_r != expect_version
    raise 'Error: expecting kernel 3.8.0-29-generic after stage1'
  end
end

package %w(virtualbox-guest-utils virtualbox-guest-x11 virtualbox-guest-dkms) do
  action :purge
  not_if { node['ctf01-02']['skip_stage_check'] }
end
