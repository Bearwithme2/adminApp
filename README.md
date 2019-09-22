adminApp

Pouzite technologie
* composer
* PHP 7.2.9+
* Symfony 4.3
* Doctrine 2
* Twig
***
Postup pro pouziti aplikace
1) klonovat projekt
2) `composer install`
3) Zalozit db - admin_app
4) specifikovat pristup k db v `.env`
5) `php bin/console doctrine:migrations:migrate`
6) vytvorit virtual host pro libovolnou adresu