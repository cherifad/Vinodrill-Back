#!/bin/bash

dt=$(date '+%d-%m-%Y-%H-%M-%S');
mkdir /home/s212/backup/$dt

# remove old backup
find /home/s212/backup/ -type d -mtime +7 -exec rm -rf {} \;

# keep only 7 folder of backup, remove all other



# zip file backup
zip -r /home/s212/backup/$dt/backupFront.zip /home/s212/VinoDrillFront
zip -r /home/s212/backup/$dt/backupBack.zip /home/s212/VinoDrill

echo "success"
