# The pigeon invoice

The pigeon invoice is a php package that creates html and pdf invoices.\
You can customize and localize it using the `Twig` template engine. `Dompdf` is used for pdf generation.

[![Latest Stable Version](http://poser.pugx.org/8ctopus/pigeon-invoice/v)](https://packagist.org/packages/8ctopus/pigeon-invoice)
![GitHub Workflow Status (branch)](https://img.shields.io/github/actions/workflow/status/8ctopus/pigeon-invoice/tests.yml?branch=master)
[![Total Downloads](http://poser.pugx.org/8ctopus/pigeon-invoice/downloads)](https://packagist.org/packages/8ctopus/pigeon-invoice)
[![PHP Version Require](http://poser.pugx.org/8ctopus/pigeon-invoice/require/php)](https://packagist.org/packages/8ctopus/pigeon-invoice)
[![License](http://poser.pugx.org/8ctopus/pigeon-invoice/license)](https://packagist.org/packages/8ctopus/pigeon-invoice)

## features

- pdf or html invoice
- includes shipping, discount and tax
- fully customizable thanks to the `Twig` templates
- localizable
- extendable (see the `extend` dir)
- 2 pdf engines available: Dompdf and wk\<html\>topdf
- adjust paper size

![invoice demo screenshot](screenshot.png)

## requirements

- `php > 8.0` with `ext-dom` and `ext-mbstring`

## demo

- git clone the project
-

```sh
composer install
php demo.php
```

- check generated invoices `invoice.pdf` and `invoice.html`

## install

-

```sh
composer require 8ctopus/pigeon-invoice
```

- copy the `resources` directory to your project

```php
use Oct8pus\Invoice\Company;
use Oct8pus\Invoice\Discount;
use Oct8pus\Invoice\Invoice;
use Oct8pus\Invoice\Item;
use Oct8pus\Invoice\Person;
use Oct8pus\Invoice\Shipping;
use Oct8pus\Invoice\Tax;

require_once './vendor/autoload.php';

$invoice = (new Invoice([
    'rootDir' => __DIR__ . DIRECTORY_SEPARATOR . 'resources',
    'templatesDir' => 'templates',
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
    ->setCurrency('EUR')

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

$pdf = $invoice->renderPdf([
    'paper' => 'A4',
    'orientation' => 'portrait',
    // uncomment to use wk\<html\>topdf
    //'engine' => 'alternate',
]);

file_put_contents('invoice.pdf', $pdf);
```

## wk\<html\>topdf

To use the wk\<html\>topdf engine, you will need to [download the binary](https://wkhtmltopdf.org/downloads.html) for your system and add it to the current working directory `getcwd()` or it to the system path.

## Twig templates reference documentation

    https://twig.symfony.com/doc/3.x/

## custom fonts and unicode

Custom fonts must be in TrueType (\*.ttf) format.

    https://github.com/dompdf/dompdf/wiki/UnicodeHowTo

## credits

- Dompdf https://github.com/dompdf/dompdf
- wk\<html\>topdf https://wkhtmltopdf.org/
- Twig https://github.com/twigphp/Twig
- logo https://www.canva.com/design
- Tangerine font https://www.fontsquirrel.com/license/Tangerine

## tests

    composer test

Note: tests do not check the pdf output, it seems it's not ready yet in [DomPDF](https://github.com/dompdf/dompdf/pull/2510)

## clean code

    composer fix
