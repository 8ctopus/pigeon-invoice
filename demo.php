<?php

declare(strict_types=1);

use NunoMaduro\Collision\Provider;
use Oct8pus\Extend\Item;
use Oct8pus\Invoice\Company;
use Oct8pus\Invoice\Discount;
use Oct8pus\Invoice\Invoice;
use Oct8pus\Invoice\Person;
use Oct8pus\Invoice\Shipping;
use Oct8pus\Invoice\Tax;

require_once __DIR__ . '/vendor/autoload.php';

// command line error handler
(new Provider())
    ->register();

$files = [
    __DIR__ . '/invoice.html',
    __DIR__ . '/invoice.pdf',
    __DIR__ . '/invoice-alternate.pdf',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        unlink($file);
    }
}

/** @disregard P1013 */
$invoice = (new Invoice([
    'rootDir' => __DIR__ . '/resources',
    'templatesDir' => 'templates',
    'locale' => 'en',
]))
    ->setSeller((new Company())
        ->setName('Widgets LLC')
        ->setStreet1('16 Leo Tolstoy Street')
        ->setZip('119021')
        ->setCity('Moscow')
        ->setCountry('Russia')
        ->setWebsite('https://widgets.ru')
        ->setEmail('hello@widgets.ru'))

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
    ->addItem((new Item())->setName('Item 1')->setPrice(4.99)->setQuantity(1)->setVersion(1.000))
    ->addItem((new Item())->setName('Item 2')->setPrice(9.99)->setQuantity(2)->setVersion(1.000))
    ->addItem((new Item())->setName('Item 3')->setPrice(3.99)->setQuantity(3)->setVersion(1.000))

    ->setDiscount((new Discount())->setName('Special Offer')->setPrice(10.00))
    ->setShipping((new Shipping())->setName('Shipping')->setPrice(5.00))
    ->setTax((new Tax())->setName('VAT')->setPercentage(0.21))

    ->setCustomFields([
        'notes' => 'Thank you for shopping with us!',
    ]);

echo 'render html...' . PHP_EOL;

$html = $invoice->renderHtml();

file_put_contents('invoice.html', $html);

$cache = __DIR__ . '/cache';

if (!file_exists($cache)) {
    mkdir($cache);
}

echo 'render pdf... (may take some time the first time to download the fonts' . PHP_EOL;

$pdf = $invoice->renderPdf([
    'paper' => 'A4',
    'orientation' => 'portrait',
    // allow to download content from the internet such as fonts
    'isRemoteEnabled' => true,
    'cache' => $cache,
    'debug' => true,
    // valid options: CPDF, PDFLib, GD, wkhtmltopdf and auto
    'pdfBackend' => 'PDFLib',
]);

file_put_contents('invoice.pdf', $pdf);

/*
// output pdf to browser
$dompdf->stream('invoice.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
*/
