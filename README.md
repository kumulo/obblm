Open Blood Bowl League Manager
=====
[![Build Status](https://travis-ci.org/kumulo/obblm.svg?branch=dev)](https://travis-ci.org/kumulo/obblm)[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kumulo/obblm/badges/quality-score.png?b=dev)](https://scrutinizer-ci.com/g/kumulo/obblm/?branch=dev)

This project uses [Composer], [Node.js] modules ([Bower] & [Grunt]) and first of all [Symfony].

## Requirements :
- [Composer]
- [Node.js]: >= 4.0.*
- PHP: >= 5.5.*

## Installation :
    npm install
    composer install
    grunt
Create database

    php app/console doctrine:database:create
    php app/console doctrine:schema:create
Now you can create your Super Admin User with FOSUser command lines :

    php app/console fos:user:create MySuperAdmin
    php app/console fos:user:promote MySuperAdmin

[Composer]: <http://Composer.org>
[Node.js]: <https://nodejs.org>
[Bower]: <http://bower.io>
[Grunt]: <http://gruntjs.com>
[Symfony]: <http://symfony.com>