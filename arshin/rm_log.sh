#!/bin/bash
cd /var/services/web/arshin
tail -n 5000 log.txt > tmp && mv tmp log.txt