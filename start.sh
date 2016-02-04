#!/usr/bin/env bash

#### Variables

## composer: github key
composer_key=false

#### Functions

## docker: install laravel dependencies
function dependencies () {

    echo -e '\t- Installing Census Application Environment'
    echo -e "\t- US Census Bureau / CitySDK:\t\t";
    echo -e $(git submodule status) \
        | awk '{print "\t\t-", $2, $3, "\n\t\t-", $5, $6 }'

    echo -e '\t- Application Path:' $PWD
    echo -e '\t- Recent 5 Changes to Source Code : '
    TERM=xterm git log -5 --graph \
        --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset' \
        --abbrev-commit --date=relative \
            | sed -e 's/^*\ /\t    Commit: /1'

    [ $( git submodule init ) ] \
        && echo -e '\n\t- Gid: Submodules Initialized'

    echo -e '\n\t- Git: Updating Submodules' \
        && git submodule update

    if [ $composer_key != false ]; then
        echo -e '\t- Composer: Installing GitHub Token' \
            && composer config -g github-oauth.github.com ${composer_key}
    fi

    echo -e '\t- Composer: Installing & Profiling the Class Loader' \
        && composer install --profile

    echo -e '\t- Composer: Drumming Autoloader & Optimizing Application' \
        && composer dump-autoload --optimize --profile

    echo -e '\t- NodeJS Pkg Mgr: Installing Dependencies from package.json' \
        && npm install

    echo -e '\t- Bower: Installing Dependencies from bower.json' \
        && bower --allow-root install

    echo -e '\t- Gulp: Installing Dependencies from Gulpfile' \
        && export DISABLE_NOTIFIER=true gulp

    echo -e '\t- Environment: Storage, Logs...' \
        && mkdir -p storage/logs \
        && touch storage/logs/laravel.log

    echo -e '\t- Artisan: Optimizing Application' \
        && php artisan optimize

    echo -e '\t- Artisan: Migrating Database' \
        && php artisan migrate --force --database=mysql-root

    echo -e '\t- Artisan: Installing Database Migrations' \
        && php artisan migrate:install --database=mysql-root

    # echo -e '\t- Artisan: Installing Database Session Table' \
        # && (rm -rf database/migrations/2015*_create_sessions_table.php;
            # php artisan session:table) # blocks until complete

    echo -e '\t- Environment: Bootstrap/Cache, Storage, Vendor...' \
        && chmod ugo+wrx -R bootstrap/cache/ storage/ vendor/ \
        && mkdir -p /dev/shm/dsni_mysql \
        && chmod -R o+wrx public/

    echo -e '\t- Environment: Complete'
}

## docker: change file modes: users, groups, others: +write, +read, +execute
function chmods () {
    sudo mkdir -p /dev/shm/dsni_mysql
    sudo chmod ugo+wrx -R bootstrap/cache/ storage/ vendor/
    sudo chmod -R o+wrx public/
}


#### Main



if [ $1 ] && [ $1 == 'gulp' ]; then
    install='docker exec -i -t dsnicensus_php_1 gulp' && \
        ${install} \
            && echo 'Gulp: Complete' \
            || echo 'Gulp: Error'
        chmods
        exec echo 'Gulp: Finished'
fi

if [ $1 ] && [ $1 == 'install' ]; then

    if [ x"$CENSUS_DOCKER_APP" == x"TRUE" ]; then
cat <<'EOF'

    `7MM"""Yb.    .M"""bgd `7MN.   `7MF'`7MMF'
      MM    `Yb. ,MI    "Y   MMN.    M    MM
      MM     `Mb `MMb.       M YMb   M    MM
      MM      MM   `YMMNq.   M  `MN. M    MM
      MM     ,MP .     `MM   M   `MM.M    MM
      MM    ,dP' Mb     dM   M     YMM    MM
    .JMMmmmdP'   P"Ybmmd"  .JML.    YM  .JMML.

EOF
        if [ -f ../start.sh ]; then
            cd .. && dependencies
        else
            echo -e '\t- Error: missing start.sh from ' $PWD && exit
        fi

    else

        install='docker exec -i -t dsnicensus_php_1 ../start.sh install' \
            && ${install}

        # Init: /usr/local/sbin/php-fpm

    fi

    exit

else

    weekend_code="true"

    # docker-compose should not be controlled
    # by this bash script, on the docker-machine.

    weekend_disc() {
        z="$(basename $0)"
        echo -e "\n Please remove the weekend_code variable "
        echo " from $z because $z should probably"
        echo " be executed (from container) like: ../$z"
        echo " However leaving it true means you could be work-"
        echo " ing on this app's docker environment. :D"
    }

    if [ ! ${weekend_code} ]; then
        weekend_disc && exit 127
    else
        weekend_disc && sleep 10 && echo -e \
            "\n\tWeekend Code $0 ($(date))"
            exit
        chmods

        ## docker: build to add any possible changes to config files in ./images/
        build=true

        [ $build ] \
            && docker-compose build \
            || echo 'docker-compose build: skipped'

        ## docker: ☘ start containers
        docker-compose stop -t 45
        docker-compose up -d
        docker-compose logs
    fi
fi
