# The pigeon invoice

The pigeon invoice is a php package that creates html and pdf invoices.
You can customize and localize it using the `Twig` template engine. `Dompdf` is used for pdf generation.

## features

- pdf / html invoice
- includes shipping, discount and tax
- fully customizable thanks to the `Twig` template engine
- localizable

![invoice demo screenshot](screenshot.png)

## requirements

- `php` > 8 with `ext-dom` and `ext-mbstring`

## demo

- git clone the project
-

```sh
composer install
php demo.php
```

- check generated invoices `invoice.pdf` and `invoice.html`.

## install

```sh
composer require 8ctopus/pigeon-invoice
```

```php
use oct8pus\Invoice\Company;
use oct8pus\Invoice\Discount;
use oct8pus\Invoice\Invoice;
use oct8pus\Invoice\Person;
use oct8pus\Invoice\Shipping;
use oct8pus\Invoice\Tax;

require_once './vendor/autoload.php';

$invoice = (new Invoice([
    'rootDir' => __DIR__,
    'templatesDir' => __DIR__ . '/templates/',
    'locale' => 'en'
]))
    ->setSeller((new Company())
        ->setName('Widgets LLC')
        ->setWebsite('https://www.widgets.ru')
        ->setEmail('hello@widgets.ru')
        ->setStreet1('16 Leo Tolstoy Street')
        ->setZip('119021')
        ->setCity('Moscow')
        ->setCountry('Russia'))

    ->setBuyer((new Person())
        ->setFirstName('Yuri')
        ->setLastName('Kamasov')
        ->setStreet1('Krasnoarmeyskaya 1')
        ->setZip('620026')
        ->setCity('Yekaterinburg')
        ->setCountry('Russia'))

    ->setDate(new DateTime('28-04-2022'))
    ->setNumber('EN43UD6JA7I2LNBC17')
    ->setCurrency('$')

    // add items
    ->addItem((new Item())->setName('Item 1')->setPrice(4.99)->setQuantity(1))
    ->addItem((new Item())->setName('Item 2')->setPrice(9.99)->setQuantity(2))
    ->addItem((new Item())->setName('Item 3')->setPrice(3.99)->setQuantity(3))

    ->setDiscount((new Discount())->setName('Special Offer')->setPrice(10.00))

    ->setShipping((new Shipping())->setName('Shipping')->setPrice(5.00))

    ->setTax((new Tax())->setName('VAT')->setPercentage(0.21))

    ->setCustomFields([
        'notes' => 'Thank you for shopping with us!',
    ]);

$html = $invoice->renderHtml();

file_put_contents('invoice.html', $html);

$pdf = $invoice->renderPdf();

file_put_contents('invoice.pdf', $pdf);
```

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
