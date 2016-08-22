# -*- mode: ruby -*-
# vi: set ft=ruby :

#
# Load json configuration to control and set up the development environment.
#
require 'json'

def get_json( filename )
  JSON.parse( IO.read(filename), {symbolize_names: true} )
end

def load_config
  config_default  = {}
  config_local    = {}
  config          = {}
  config_default  = get_json('config/vagrant.default.json') if File.file?('config/vagrant.default.json')
  config_local    = get_json('config/vagrant.local.json') if File.file?('config/vagrant.local.json')
  config          = config_default.merge(config_local)
end

def output_links ( config )
  puts "++++++++++++++++++++++++++++++++++++++++++++++++++++++"
  puts "Virtual Machine Links"
  config.each do | title,links |
    puts "\n#{title}:"
    links.each do | name,val |
      puts " [#{name}](#{val})"
    end
  end
  puts "++++++++++++++++++++++++++++++++++++++++++++++++++++++"
end

config  = load_config

Vagrant.configure(2) do |vagrant_config|
  vagrant_config.ssh.insert_key = false
  vagrant_config.vm.box = config[:box]

  vagrant_config.vm.provider "virtualbox" do |v|
    v.cpus      = config[:cpus] if config[:cpus]
    v.memory    = config[:ram] if config[:ram]
  end

  #
  # Dynamically configure any local projects to add to the guest VM.
  #
  config[:projects].each {|item|
    vagrant_config.vm.synced_folder item[:path_host], item[:path_remote], create: true
    item[:provision_scripts].each {|file|
        vagrant_config.vm.provision "shell", path: file
    }
  }

  vagrant_config.vm.network "private_network", ip: config[:ip]

  #
  # Dynamically configure the docker instances if found in the configuration files.
  #
  if config[:docker_instances]
      vagrant_config.vm.provision "docker" do |d|

        config[:docker_instances].each {|docker_config|
            d.pull_images docker_config[:run][:image] if docker_config[:run][:image]
            d.run docker_config[:name], **docker_config[:run] if docker_config[:run]
        }
      end
  end

end

# Adding some useful output to stdout.
puts "#####################################################################"
puts "To ssh into the box run 'vagrant ssh'"
puts "Ip address for this virtual machine is: '#{config[:ip]}'"
puts "You will need to add a host file entry for: '#{config[:ip]} #{config[:name]}.local'"
output_links(config[:links]) if config[:links]
puts "#####################################################################"