# the-matrix/slim-dic-example

![PHP 5.6](https://img.shields.io/badge/PHP-5.6-blue.svg)
![PHP 7.1](https://img.shields.io/badge/PHP-7-blue.svg)

Use this skeleton application to quickly setup and start working on a new 
[Slim Framework 3](http://www.slimframework.com/) application incorporating the 
power of the  [Symfony 2 Dependency Injection component](https://symfony.com/doc/2.8/service_container.html) or
[Symfony 4 Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection/introduction.html).

Symfony 2 is supported by PHP 5.6.. Symfony 4 is supported by PHP 7.1. 

This demo also uses Sensio Labs' [Twig](http://twig.sensiolabs.org) template 
library, but you don't have to - use Smarty instead, or native PHP for your view 
scripts - it's up to you, - just configure the DIC definition files per
your requirements. (Don't forget to add/remove dependencies in composer.json if
you do.)

Also included is a minimal Controller (MVC) implementation, that allows you to seperate
out the routing from the site application logic.  Again, you don't need to use it if
you don't want to.

This skeleton application was built for Composer. This makes setting up a new 
Slim Framework application quick and easy. You are not intended to include this
as a composer requirement, but to create a new Composer app with it and move on.

This is a PHP5.6+ application

## Install Composer

Install [Composer] (https://getcomposer.org/). It is useful to symlink the
composer.phar file into /usr/local/bin or your ~/bin directory, dependent on
your circumstances e.g.

<pre>
    cd ~/bin
    ln -s /path/to/composer.phar composer
    chmod u+x composer
</pre>

## Install the Application

After you install Composer, run this command from the directory below the one 
in which you want to install your new Slimdic application.

<code>
    composer create-project the-matrix/slim-dic-example my-app-name 3.*
</code>

Replace my-app-name with the desired directory name for your new application. When the installer
asks
<code>
    Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]?
</code>

then enter 'Y'.

(NB. If you want the Slim 2 + Symfony 2 version of this library, use 1.* as the version number above.)

The rest of this section comes under the general heading of 'Teaching Grandma to Suck Eggs',
but hey - someone out there is a newby!

You'll want to:

* Point your virtual host document root to your new application's `public/` directory.

* Ensure your web server has rights to your root directory. It needs to be able 
to read and write to the appropriate directories e.g.

<pre>
    sudo chgrp -R apache my-app-name
    sudo chmod -R g+r my-app-name
    sudo chmod -R g+w my-app-name/spool
</pre>

ensures that both you and the server can read and write. NB, check the user name
that your server is running under, something like:

<pre>
    ps aux | grep httpd
    # or
    ps aux | grep apache
</pre>

normally does the trick.

Have a care for security.  Dependent on your server, set the vhost to allow public
access to the ./public directory only.  The app needs to be able to see everything
from one directory below, and no more.

Dependent on how you have set up your vhost, you may need to add an entry to the
/etc/hosts file.  I like to set each app I'm developing on it's own dns name so
typically, I'll add something like

<code>
127.0.0.1 my-app.localhost
</code>

to /etc/hosts.  Obviously, the name needs to match your web server vhost name

Now assuming you've got all that, point your browser at the the vhost name and
off you go - you should be seeing a nice page.  Now browse to /logon and check
out the cool demo logon.  It doesn't matter if you get it wrong - the answer will 
be revealed.

So you did the demo.  Now look at the code - it's all in there under the Site directory
and in the public/index.php file.

And remember, once you've installed this demo template, you can change it without 
worrying that a `composer update` is going to override any code that you write.  That
will just update any packages you have defined in your composer.json file.

## More reading

[The Site Directory](https://github.com/the-matrix/Slim-Dic-Example/blob/master/Site/readme.md)

[Using the Controller](https://github.com/the-matrix/Slim-Dic-Example/blob/master/Site/Controller/readme.md)

## Find more

Check out [ZF4 Packages](http://zf4.biz/packages?utm_source=github&utm_medium=web&utm_campaign=blinks&utm_content=slimdicexample) for more packages

## History

V1.0.0 Slim 2 + Symfony 2

V2.0.0 Slim 3 + Symfony 2

V2.0.1 Add link to packages

V2.0.2 bug fix from [Nigel Greenway](https://github.com/the-matrix/Slim-Dic-Example/pull/1)

V2.0.3 code clean. readme typos. bug fix from [Nigel Greenway](https://github.com/the-matrix/Slim-Dic-Example/pull/2)

V2.1.0 Update for PHP 7.1

V2.1.1 update composer - forced by packagist composer.json format change

V3.0.0 BC Break.  Remove support for PHP <5.6