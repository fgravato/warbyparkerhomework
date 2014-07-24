#!/usr/bin/env ruby
# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'
servers = YAML.load_file('servers.yml')

Vagrant.configure("2") do |config|

  config.vm.box = "centos65"
  config.vm.box_url = "http://puppet-vagrant-boxes.puppetlabs.com/centos-65-x64-virtualbox-nocm.box"

    config.vm.define 'app' do |machine|
    machine.vm.hostname = 'app'
    machine.vm.network "private_network", ip: "192.168.121.102"
  
  end

  config.vm.define 'front' do |machine|
    machine.vm.hostname = 'front'
    machine.vm.network "private_network", ip: "192.168.121.101"

    machine.vm.provision :ansible do |ansible|
      ansible.playbook = "playbook.yml"

      # Disable default limit (required with Vagrant 1.5+)
      ansible.limit = 'all'
      ansible.groups = {
      "app" => ["app"],
      "front" => ["front"],
      "all_groups:children" => ["app", "front"]
}
    end
  end
  end

