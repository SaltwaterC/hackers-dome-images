## About

The source for the CTF images used for Hacker's Dome 1st and 2nd editions (First Blood and Double Kill). Made in collaboration with [CTF365](https://ctf365.com).

This is still under development. Will update this README to reflect the actual progress.

## Dependencies

 * [Packer](https://packer.io) - used for building the Vagrant base boxes, not needed if you're using the pre-built boxes from Atlas
 * [ChefDK](https://downloads.chef.io/chef-dk) - used to develop and test the cft cookbooks, not needed to build the actual ctf images
 * [Vagrant](https://www.vagrantup.com) - required to build the ctf Vagrant boxes
 * [vagrant-omnibus](https://github.com/chef/vagrant-omnibus) plugin - required for older distributions, Chef Omnibus is better than Vagrant at bootstrapping chef-client

## Images

 * ctf01-01 - used for First Blood - CentOS 5.1 i386

## Project structure

 * packer - contains packer templates for creating the needed Vagrant base boxes
 * cookbooks - contains Chef cookbooks for provision the ctf Vagrant boxes
 * images - contains the Vagrantfile's used for creating the ctf boxes
 * vagrantfiles - contains the Vagrantfile's which contain the example implementation of the ctf boxes
