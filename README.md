# the-matrix/slim-dic-application-skeleton

Use this skeleton application to quickly setup and start working on a new 
[Slim Framework](http://www.slimframework.com/) application incorporating the 
power of the [Symfony Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection/introduction.html). 
This demo also uses Sensio Labs' [Twig](http://twig.sensiolabs.org) template 
library, but you don't have to - use Smarty instead, or native PHP for your view 
scripts - it's up to you, - just configure the DIC definition files per
your requirements. (Don't forget to add/remove dependencies in composer.json if
you do.)

I've used the XML variant of the Symfony DIC definition. It's basically the most
powerful form.  Self validating and packed with those little extras that make 
XML a joy to use.  If you really must use Yaml to define your DIC, then take a
look at the supporting chippyash/slim-dic library and create a Builder that will
handle Yaml.  You might even consider contributing it to that repo! 

This skeleton application was built for Composer. This makes setting up a new 
Slim Framework application quick and easy. You are not intended to include this
as a composer requirement, but to create a new Composer app with it and move on.

This is a PHP5.5+ application

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
    composer create-project the-matrix/slim-dic-example \<my-app-name\>
</code>

Replace \<my-app-name\> with the desired directory name for your new application. 

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
