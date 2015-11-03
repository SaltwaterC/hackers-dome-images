#!/bin/bash

pkill firefox
rm -rf /home/xubuntu/.mozilla
/opt/firefox/firefox --display=:0 -no-remote http://127.0.0.1/ &
sleep 15
cat /dev/null > /var/www/messages.txt

exit 0
