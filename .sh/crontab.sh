#!/bin/bash
step=1 #间隔的秒数，不能大于60
 
for (( i = 0; i < 59; i=(i+step) )); do
    #cd /data/wwwroot/www.ebolaunion.gq && php index.php /Chat/Automessage/sendJoke
    curl -s -m 10 --connect-timeout 10 -I http://www.ebolaunion.gq/sendJokes
    sleep $step
done
 
exit 0
