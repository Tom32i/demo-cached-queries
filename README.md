# Cached Query demo

Demonstration technique pour l'article "[Des Query mises en cache avec Symfony](https://thomas.jarrand.fr/blog/cache-query-avec-symfony-messenger/)"


## Install

    composer install

## Usage

    symfony server:start --no-tls

## Demo controller

Go to main route: http://127.0.0.1:8000/metrics/user/1

- First call is slow (5s).
- Other call is fast (response from cache).
- Cache is valid for 30 seconds.

## Demo command

    bin/console app:user-metric 1

- First call is slow (5s).
- Other call is fast (response from cache).
- Cache is valid for 30 seconds.

Force cache refresh:

    bin/console app:user-metric 1 --force
