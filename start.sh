#!/usr/bin/env bash

# docker: change file modes: users, groups, others: +write, +read, +execute
chmod ugo+wrx -R bootstrap/cache/ storage/ vendor/

# docker: build to add any possible changes to config files in images/
build=true
[ $build ] && docker-compose build || :

# docker: stop and start containers
docker-compose restart
docker-compose logs
