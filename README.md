# Billie Task Project

[![Build Status](https://travis-ci.com/ahmedsamir89/billie.svg?token=jTqbLBTY96355XoPLwp8&branch=master)](https://github.com/ahmedsamir89/billie)
### Prerequisites
* [Docker](https://www.docker.com/)

### Container
 - [nginx](https://pkgs.alpinelinux.org/packages?name=nginx&branch=v3.10) 1.16.+
 - [php-fpm](https://pkgs.alpinelinux.org/packages?name=php7&branch=v3.10) 7.3.+
    - [composer](https://getcomposer.org/) 

### Installing
After cloning the Project go to the project file and then:

```
composer install
```

go to the main file and run docker and connect to container:
```
 docker-compose up --build
```

Phpunit in side the symfony file run:
```
bin/phpunit
```

The project now works on port 8000

API example
call [localhost](http://localhost:8000/mars/time?earthDate=2020-10-02) in your browser
 
