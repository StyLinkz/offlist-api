Vagrant.configure("2") do |config|
    config.vm.box = "laravel/homestead"
    config.vm.box_version = "12.1.0"

    config.vm.provider "virtualbox"
    config.vm.provision "shell", inline: "cp /vagrant/scripts/000-default.conf /etc/apache2/sites-available/000-default.conf"
    config.vm.provision "shell", path: "scripts/provision.sh"
    config.vm.network "forwarded_port", guest: 80, host: 8085
end