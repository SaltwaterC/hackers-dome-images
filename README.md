## About

The source for the CTF images used for Hacker's Dome 1st and 2nd editions (First Blood and Double Kill). Made in collaboration with [CTF365](https://ctf365.com).

This project still under development.

## Dependencies

For using the images:

 * [Vagrant](https://www.vagrantup.com)
 * [VirtualBox](https://www.virtualbox.org)

For development, you need the above list plus:

 * [Packer](https://packer.io)
 * [ChefDK](https://downloads.chef.io/chef-dk)
 * [vagrant-omnibus](https://github.com/chef/vagrant-omnibus)

## Images

 * ctf01-01 - First Blood image, available
 * ctf01-02 - First Blood image, in development
 * ctf02-01 - Double Kill image, planned
 * ctf02-02 - Double Kill image, planned

## Project structure

 * packer - contains packer templates for creating the needed Vagrant base boxes
 * cookbooks - contains Chef cookbooks for provision the ctf Vagrant boxes
 * images - contains the Vagrantfile's used for creating the ctf boxes
 * vagrantfiles - contains the Vagrantfile's which contain the example implementation of the ctf boxes
