# -*- mode: ruby -*-
# vi: set ft=ruby :

# Code heavily inspired by the work at: https://altitude.otago.ac.nz/cosc349/vagrant-multivm
# Credit to David Eyers and Pradeesh

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/focal64"

  config.vm.define "clientserver" do |clientserver|

    clientserver.vm.hostname = "clientserver"

    # Create a forwarded port mapping which allows access to a specific port
    # within the machine from a port on the host machine and only allow access
    # via 127.0.0.1 to disable public access
    # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

    clientserver.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

    # Create a private network, which allows host-only access to the machine
    # using a specific IP.
    # config.vm.network "private_network", ip: "192.168.33.10"

    clientserver.vm.network "private_network", ip: "192.168.56.11"
    
    # Enable functionality in CS Labs just in case

    clientserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    clientserver.vm.provision "shell", path: "build-clientserver-vm.sh"
  end

  config.vm.define "staffserver" do |staffserver|

    staffserver.vm.hostname = "staffserver"

    staffserver.vm.network "forwarded_port", guest: 80, host: 9090, host_ip: "127.0.0.1"

    staffserver.vm.network "private_network", ip: "192.168.56.12"

    staffserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]

    staffserver.vm.provision "shell", path: "build-staffserver-vm.sh"
  end

  config.vm.define "databaseserver" do |databaseserver|

    databaseserver.vm.hostname = "databaseserver"

    databaseserver.vm.network "private_network", ip: "192.168.56.13"

    databaseserver.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "vagrant", mount_options: ["dmode=775,fmode=777"]
    
    databaseserver.vm.provision "shell", path: "build-databaseserver-vm.sh"
  end

end