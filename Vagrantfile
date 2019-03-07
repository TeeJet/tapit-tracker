# Optimized for Vagrant 1.7 and above.
Vagrant.require_version ">= 1.7.0"

Vagrant.configure(2) do |config|

    config.vm.box = "ubuntu/xenial64"
    config.vm.define "tracker" do |tracker|
    end

    config.vm.hostname = "tracker.local"
    config.vm.network "private_network", ip: "192.168.33.85"
    
    config.vm.synced_folder ".", "/vagrant", type: "virtualbox", owner: "ubuntu", group: "ubuntu", mount_options: ["dmode=777,fmode=777"]
    
    config.vm.provision "shell", path: "vagrant/provision.sh"

    config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

    config.vm.provider "virtualbox" do |vb|
        vb.name = "tracker.local"
        vb.gui = false
        vb.memory = "512"
        vb.customize ["modifyvm", :id, '--audio', 'none']
    end
end