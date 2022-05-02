# The pigeon invoice

The pigeon invoice package helps you create html and pdf invoices.
Customize and localize using the `Twig` template engine and `Dompdf`.

![invoice demo screenshot](screenshot.png)

## features

- pdf / html invoice
- includes discount and tax
- customize using `Twig` template engine
- localizable

## demo

- git clone the project
- `composer install`
- `php demo.php`
- check result in `invoice.pdf` / `invoice.html`

## install

```sh
composer require 8ctopus/pigeon-invoice
```

See `demo.php` on how to use

## Twig templates reference documentation

https://twig.symfony.com/doc/3.x/

## credits

- Dompdf https://github.com/dompdf/dompdf
- Twig https://github.com/twigphp/Twig
- logo https://www.canva.com/design

## clean code

```sh
vendor/bin/php-cs-fixer fix
```
