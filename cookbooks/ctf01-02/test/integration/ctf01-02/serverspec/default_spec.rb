require_relative 'spec_helper'

describe 'ctf01-02' do
  describe package('linux-image-3.8.0-29-generic') do
    it { is_expected.to be_installed }
  end

  describe file('/var/www/index.php') do
    it { is_expected.to be_file }
    it { is_expected.to be_owned_by 'root' }
    it { is_expected.to be_grouped_into 'root' }
    it { is_expected.to be_mode '644' }
    it { is_expected.to contain %q(Hi people. Post a message while I'm AFK. Say what you need. I'll check periodically to see if there's something new.) }
  end

  describe user('xubuntu') do
    it { is_expected.to exist }
    it { is_expected.to belong_to_group 'xubuntu' }
    it { is_expected.to have_home_directory '/home/xubuntu' }
    it { is_expected.to have_login_shell '/bin/bash' }
    its(:encrypted_password) { is_expected.to eq '$6$BShdj9H4$1XEhTO3y69iajsUj0Mb3Wmyt6HtVeNQcqImOWs0RiIfVOPgl9x4mXOKJVluzNxXkRVTK9jLOSVVhO6lNpDR740' }
  end

  describe file('/home/xubuntu') do
    it { is_expected.to be_directory }
    it { is_expected.to be_mode '700' }
  end

  describe file('/etc/lightdm/lightdm.conf') do
    it { is_expected.to contain 'autologin-user=xubuntu' }
  end

  describe file('/opt/firefox-17.0.1') do
    it { is_expected.to be_directory }
  end

  %w(
    /opt/firefox/firefox
    /opt/ff-run.sh
  ).each do |f|
    describe file(f) do
      it { is_expected.to be_file }
    end
  end

  describe file('/home/xubuntu/user-trophy.txt') do
    it { is_expected.to be_file }
    it { is_expected.to be_owned_by 'xubuntu' }
    it { is_expected.to be_grouped_into 'xubuntu' }
    it { is_expected.to be_mode '400' }
    it { is_expected.to contain 'e6233d88a4d77ee843ce48768471eaa03b4ce12a' }
  end

  describe file('/root/superuser-trophy.txt') do
    it { is_expected.to be_file }
    it { is_expected.to be_owned_by 'root' }
    it { is_expected.to be_grouped_into 'root' }
    it { is_expected.to be_mode '400' }
    it { is_expected.to contain 'df9b9625c563cb6f81e5abf25d7b86d0bf6ed3c3' }
  end

  describe command('uname -r') do
    its(:stdout) { is_expected.to eq "3.8.0-29-generic\n" }
  end

  %w(22 80).each do |p|
    describe port(p) do
      it { is_expected.to be_listening.with('tcp') }
    end
  end

  describe file('/opt/implode.sh') do
    it { is_expected.to be_file }
    it { is_expected.to be_owned_by 'root' }
    it { is_expected.to be_grouped_into 'root' }
    it { is_expected.to be_mode '700' }
  end
end
