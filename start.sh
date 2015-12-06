#!/usr/bin/env bash

#### Variables

## composer: github key
composer_key=Example-kT0uZ2GM3HC0c4Efzx8yWBUSRB2agMsQ

#### Functions

## docker: install laravel dependencies
function dependencies () {
    cd .. && echo 'Running Dependencies Within Container Directory:' $PWD
    git submodule init && git submodule update \
                       || echo "Error: git submodule init"
    echo "US Census Bureau / CitySDK:" $(git submodule status)

    # composer config -g github-oauth.github.com ${composer_key}
    composer install --profile
    composer dump-autoload --optimize --profile

    npm install

    bower --allow-root install

    export DISABLE_NOTIFIER=true
    gulp

    # grunt

    mkdir -p storage/logs
    touch storage/logs/laravel.log

    php artisan optimize

    php artisan migrate --force --database=mysql-root
    php artisan migrate:install --database=mysql-root
    chmod ugo+wrx -R bootstrap/cache/ storage/ vendor/
}

## docker: change file modes: users, groups, others: +write, +read, +execute
function chmods () {
    sudo chmod ugo+wrx -R bootstrap/cache/ storage/ vendor/
}


#### Main


if [ x"$CENSUS_DOCKER_APP" == x"TRUE" ]; then

    if [ $1 ] && [ $1 == 'dependencies' ]; then
        dependencies
        exit
    fi

else

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
