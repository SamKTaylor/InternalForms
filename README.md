# Internal Forms

Example of an Internal company intranet site with login managed by Active Directory.

This is an example project, It worked at one point but hase not been tested for some time as I dont have access to an AD server at the moment and is provided as an example of various technologies.

CI/CD with github actions.

docker-compose.yml included for development.

## Development Setup

Make sure you user belongs to www-data group, make sure src folder is owned by www-data user and group.

to run composer update on container use the following docker command, you will need to do this at least once.

```
docker exec -it -w /var/www/html if_dev_web composer update
```

### LDAP Configuration

4 main variables that can be set though env files LDAP_HOST, LDAP_USERNAME, LDAP_PASSWORD, LDAP_BASE_DN.

  * LDAP_HOST: Host or ip address of AD server
  * LDAP_USERNAME: admin ad user that the aplication can use to auth users, must be the users Distinguished Name.
  * LDAP_PASSWORD: admin users password.
  * LDAP_BASE_DN: details here : https://ldaprecord.com/docs/configuration/#base-distinguished-name

### MYSQL

Project will pull mysql credentials from laravel .ENV file. These are named identicallly to the ENV variables required by official mysql docker containers so you can use the same file for both and thent he details will match.

### Tech used:
Docker - Nginx - PHP-FPM - MYSQL - Laravel 7

Laravel 7:
  * Bootstrap 4
  * jquery
  * datatables
  * https://github.com/yajra/laravel-datatables
  * https://github.com/DirectoryTree/LdapRecord-Laravel
  
Current Features:
  * LDAP login
  * Forms:
    * Complaints
    * Returns
  