## Dudley Street Neighborhood Initiative

## Census & Map Application

Made possible with Docker and Laravel and Opensource software. Please donate: https://my.fsf.org/donate/

### API Key

Census API Key Required:
http://api.census.gov/data/citysdk.html

Identify your API key by editing the file ```docker-compose.yml``` as shown:

```
environment:
    CENSUS_APIKEY: Example-U6ufn1MMMFWPqMqMnOnRnaZcJ41aaqIM
    GOOGLE_API_KEY: Example-AIzaSyC6c_Example-fI8SuWZNE6AGX
```


## About the Docker Container Environmenet

If you are not seeing your changes to the Docker environment (such as the database directory is not being used (images/mysql_data)) simply remove all the containers  ```docker-compose rm``` and then restart with ```docker-compose up```

### Database

Create the directory /dev/shm/dsni_mysql to enable an in-memory database. To store the database on disk please create remove the symbolic link images/mysql_data then create a directory images/mysql_data. By default the database will temporarily reside within the docker container.

An example for creating the dsni user account. (Just use mysql-workbench)

```MySQL

INSERT INTO `mysql`.`user`
  (`Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`, `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`, `Event_priv`, `Trigger_priv`, `Create_tablespace_priv`, `ssl_type`, `max_questions`, `max_updates`, `max_connections`, `max_user_connections`, `plugin`, `authentication_string`, `password_expired`)
VALUES
  ('%', 'dsni', '*D1DC3BBFB68E8F142AE83622634ECCFAF2B63D5B', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '0', '0', '0', '0', 'mysql_native_password', '', 'N');

```

Table Permissions for the dsni user account

```MySQL

INSERT INTO `mysql`.`db`
  (`Host`, `Db`, `User`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Execute_priv`, `Event_priv`, `Trigger_priv`)
VALUES
  ('%', 'dsni', 'dsni', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'Y', 'N', 'N');

```


The fastest way to get this done is to use MySQL-Workbench (in Docker, of course)

```Bash

docker run \
    -it \
    -v /tmp/.X11-unix:/tmp/.X11-unix \
    -e DISPLAY=unix$DISPLAY \
    raphabot/mysql-workbench

```

Once the username is set up, you can enter the Docker container, and migrate the database:

```Bash
docker exec -i -t dsnicensus_php_1 bash
cd /app
./artisan migrate --database=mysql-root --force
```

You should see:

```
Migration table created successfully.
Migrated: 2014_10_12_000000_create_users_table
Migrated: 2014_10_12_100000_create_password_resets_table
Migrated: 2015_12_06_064245_create_sessions_table
```


### Filesystem

The filesystem changes within or around the docker-compose environment(s) then please see the script: ```start.sh```

## About the Laravel PHP Framework

Laravel is a web application framework with expressive, elegant syntax. Great documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
