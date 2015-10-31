## Changes

These changes don't affect the actual experience, but they were necessary to properly support automation.

## ctf01-01

 * Upgraded from CentOS 5.0 to CentOS 5.1 as 5.0 doesn't have a netinstall ISO to use with packer
 * Upgraded sudo to 1.7.2p1 as Vagrant expects 'sudo -E' to be successful

## Common changes

These changes were made to support open sourcing the code in a more consistent way.

 * Converted the provisioning from salt-ssh to Chef Zero
 * Converted the integration testing from Mocha to Serverspec
 * Built on top of Vagrant
