require_relative 'spec_helper'

describe 'ctf01-01' do
  %w[httpd php php-mysql].each do |pkg|
    describe package(pkg) do
      it { is_expected.to be_installed }
    end
  end

  describe file('/var/www/html/index.html') do
    it { is_expected.to be_file }
    it { is_expected.to contain '<title>Y R U HERE?!</title>' }
    it { is_expected.to be_owned_by 'root' }
    it { is_expected.to be_grouped_into 'root' }
    it { is_expected.to be_mode '644' }
  end

  describe file('/var/www/html/info.php') do
    it { is_expected.to be_file }
    it { is_expected.to contain 'phpinfo();' }
  end

  describe file('/var/www/html/development') do
    it { is_expected.to be_directory }
  end

  describe file('/var/www/html/development/obj/collectivite.class.php') do
    it { is_expected.to be_file }
    it { is_expected.to contain 'require_once (\$path_om."formulairedyn.class.php");' }
  end

  describe file('/var/www/user-trophy.txt') do
    it { is_expected.to contain '4fd242fd2c9c82f8df16854430430624a73360e0' }
  end

  describe file('/root/superuser-trophy.txt') do
    it { is_expected.to contain 'a05328c332e80147ff0902ebbf939c484aa9f295' }
  end

  describe file('/etc/hostname') do
    it { is_expected.to contain 'ctf01-01.localdomain' }
  end

  describe file('/etc/shadow') do
    it { is_expected.to contain 'root:\$1\$FejHOf29\$x3SckSqYESn1/XoAJNIld/:' }
  end

  # service fails to detect service and chkconfig due to how sudo is configured
  describe command('/etc/init.d/httpd status') do
    its(:exit_status) { is_expected.to eq 0 }
  end

  describe port('80') do
    it { is_expected.to be_listening.with('tcp') }
  end

  describe command('uname -r') do
    its(:stdout) { is_expected.to eq "2.6.18-53.el5\n" }
  end

  describe file('/opt/implode.sh') do
    it { is_expected.to be_file }
    it { is_expected.to be_owned_by 'root' }
    it { is_expected.to be_grouped_into 'root' }
    it { is_expected.to be_mode '700' }
  end
end
