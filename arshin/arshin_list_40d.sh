#!/bin/bash
echo -e "#######\n" | sudo -S docker stop $(echo -e "#######\n" | sudo -S docker ps -aq)
echo -e "#######\n" | sudo -S  docker stop do_chrome
sleep 10
echo -e "#######\n" | sudo -S docker run -v /dev/shm:/dev/shm -d --rm -p 4444:4444 --name do_chrome selenium/standalone-chrome
sleep 10
cd /var/services/web/arshin
DATE=$(date +'%e-%m-%Y %H:%M' --date='40 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='39 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='38 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='37 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='36 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='35 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='34 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='33 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='32 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='31 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='30 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='29 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='28 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='27 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='26 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='25 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='24 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='23 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='22 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='21 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='20 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='19 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='18 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='17 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='16 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='15 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='14 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='13 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='12 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='11 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='10 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='9 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='8 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='7 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='6 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='5 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='4 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='3 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='2 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M' --date='1 days ago')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
DATE=$(date +'%e-%m-%Y %H:%M')
python2 arshin_filter_true.py "$DATE"
sleep 2
python2 arshin_filter_false.py "$DATE"
sleep 2
echo -e "#######\n" | sudo -S  docker stop do_chrome
echo -e "#######\n" | sudo -S docker stop $(echo -e "#######\n" | sudo -S docker ps -aq)