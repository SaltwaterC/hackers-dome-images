## About

The source for the CTF images used for Hacker's Dome 1st and 2nd editions (First Blood and Double Kill). Made in collaboration with [CTF365](https://ctf365.com).

This project still under development.

## Dependencies

For using the images:

 * [Vagrant](https://www.vagrantup.com) (1.8+ for development)
 * [VirtualBox](https://www.virtualbox.org)

For development, you need the above list plus:

 * [Packer](https://packer.io)
 * [ChefDK](https://downloads.chef.io/chef-dk)
 * Vagrant plugins (installed by `rake setup`):
  * [vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest)
  * [vagrant-omnibus](https://github.com/chef/vagrant-omnibus)
  * [vagrant-berkshelf](https://github.com/berkshelf/vagrant-berkshelf)
  * [vagrant-reload](https://github.com/aidanns/vagrant-reload)

## Images

 * [ctf01-01](https://atlas.hashicorp.com/SaltwaterC/boxes/ctf01-01) - First Blood image, available
 * [ctf01-02](https://atlas.hashicorp.com/SaltwaterC/boxes/ctf01-02) - First Blood image, available
 * ctf02-01 - Double Kill image, in progress
 * ctf02-02 - Double Kill image, planned

## Project structure

 * packer - contains packer templates for creating the needed Vagrant base boxes
 * cookbooks - contains Chef cookbooks for provision the ctf Vagrant boxes
 * images - contains the Vagrantfile's used for creating the ctf boxes
 * vagrantfiles - contains the Vagrantfile's which contain the example implementation of the ctf boxes
