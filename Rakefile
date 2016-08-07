def vagrant_plugin_install(plugin)
  unless system("vagrant plugin list | grep #{plugin}")
    sh "vagrant plugin install #{plugin}"
  end
end

desc 'Installs runtime dependencies'
task :setup do
  vagrant_plugin_install 'vagrant-vbguest'
  vagrant_plugin_install 'vagrant-omnibus'
  vagrant_plugin_install 'vagrant-berkshelf'
  vagrant_plugin_install 'vagrant-reload'
end
