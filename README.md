# The pigeon invoice

[![packagist](http://poser.pugx.org/8ctopus/pigeon-invoice/v)](https://packagist.org/packages/8ctopus/pigeon-invoice)
[![downloads](http://poser.pugx.org/8ctopus/pigeon-invoice/downloads)](https://packagist.org/packages/8ctopus/pigeon-invoice)
[![min php version](http://poser.pugx.org/8ctopus/pigeon-invoice/require/php)](https://packagist.org/packages/8ctopus/pigeon-invoice)
[![license](http://poser.pugx.org/8ctopus/pigeon-invoice/license)](https://packagist.org/packages/8ctopus/pigeon-invoice)
[![tests](https://github.com/8ctopus/pigeon-invoice/actions/workflows/tests.yml/badge.svg)](https://github.com/8ctopus/pigeon-invoice/actions/workflows/tests.yml)
![code coverage badge](https://raw.githubusercontent.com/8ctopus/pigeon-invoice/image-data/coverage.svg)
![lines of code](https://raw.githubusercontent.com/8ctopus/pigeon-invoice/image-data/lines.svg)

Create pdf and html invoices

## features

- create pdf and html invoices
- fully customizable thanks to `Twig` templates
- localizable with unicode support
- extendable to include custom data (see the `extend` dir)
- choice of pdf engines: `Dompdf` using either `CPDF` or `PDFLib` and `wk<html>topdf`
- adjust paper size

![invoice demo screenshot](screenshot.png)

## requirements

- `php > 8.0` with `ext-dom` and `ext-mbstring` installed

## demo

- git clone the project
-

```sh
composer install
php demo.php
```

- check generated invoices `invoice.pdf` and `invoice.html`

## install

- install package

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

require_once __DIR__ . '/vendor/autoload.php';

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
    // allow to download content from the internet such as fonts
    'isRemoteEnabled' => true,
    // valid options: CPDF, PDFLib, GD, wkhtmltopdf and auto
    'pdfBackend' => 'CPDF',
]);

file_put_contents('invoice.pdf', $pdf);
```

## pdf engines

- `Dompdf` includes three engines
    - `CPDF` (bundled with Dompdf)
    - [`PDFLib`](https://www.pdflib.com/) is a commercial library with more advanced rendering than `CPDF`. It takes the form of a php extension that you will need to add to your php configuration.
    - `GD` will produce a pdf containing an image

- `wk<html>topdf`

To use the `wk<html>topdf` engine, you will need to [download the binary](https://wkhtmltopdf.org/downloads.html) for your system and add it to the current working directory `getcwd()` or to the system path.

## Twig templates reference documentation

    https://twig.symfony.com/doc/3.x/

## custom fonts

Fonts can either be provided as a style sheet link in the html head, which requires the `isRemoteEnabled` permission:

```html
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;700&display=swap" rel="stylesheet">
```

or directly in the css, but only in TrueType `*.ttf` format:

```css
@font-face {
    font-family: 'Tangerine';
    src: url('../fonts/tangerine-400.ttf');
    font-weight: normal;
}

@font-face {
    font-family: 'Tangerine';
    src: url('../fonts/tangerine-700.ttf');
    font-weight: bold;
}
```

## unicode

A font supports a limited number of languages, and therefore if you want to support many different languages, you will need to add fallback fonts. Here's an example where the default font is `Segoe UI` (latin languages), then it falls back to `Meiyro UI` for Japanese, and `Malgun Gothic` for Korean:

```css
font-family: 'Segoe UI', 'Meiryo UI', 'Malgun Gothic', sans-serif;
```

Font fallback is not yet released in the production version 2.0.0 of `Dompdf`, for now it's only available on the master branch, you will need to force composer to use a specific commit from this branch:

```json
{
    "require": {
        "dompdf/dompdf": "dev-master#05abdb3dbf51cb2263080b500a63ec483d5d4125",
    },
    "minimum-stability": "stable",
    "prefer-stable": true,
}
```

More info: https://github.com/dompdf/dompdf/wiki/UnicodeHowTo

## credits

- Dompdf https://github.com/dompdf/dompdf
- CPDF https://github.com/PhenX/CPdf (used internally by Dompdf)
- wk\<html\>topdf https://wkhtmltopdf.org/
- Twig https://github.com/twigphp/Twig
- logo https://www.canva.com/design
- Tangerine font https://www.fontsquirrel.com/license/Tangerine

## tests

    composer test

Note: tests do not check the pdf output, it seems it's not ready yet in [DomPDF](https://github.com/dompdf/dompdf/pull/2510)

## clean code

    composer fix
