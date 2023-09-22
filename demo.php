<?php

declare(strict_types=1);

use Oct8pus\Extend\Item;
use Oct8pus\Invoice\Company;
use Oct8pus\Invoice\Discount;
use Oct8pus\Invoice\Invoice;
use Oct8pus\Invoice\Person;
use Oct8pus\Invoice\Shipping;
use Oct8pus\Invoice\Tax;

require_once './vendor/autoload.php';

// command line error handler
(new \NunoMaduro\Collision\Provider())->register();

// create invoice
$invoice = (new Invoice([
    'rootDir' => __DIR__ . DIRECTORY_SEPARATOR . 'resources',
    'templatesDir' => 'templates',
    'locale' => 'en',
]))
    ->setSeller((new Company())
        ->setName('Widgets LLC')
        ->setStreet1('16 Leo Tolstoy Street')
        ->setZip('119021')
        ->setCity('Moscow')
        ->setCountry('Russia')
        ->setWebsite('https://www.widgets.ru')
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

$html = $invoice->renderHtml();

file_put_contents('invoice.html', $html);

$pdf = $invoice->renderPdf([
    'paper' => 'A4',
    'orientation' => 'portrait',
]);

file_put_contents('invoice.pdf', $pdf);

$pdf = $invoice->renderPdf([
    'paper' => 'A4',
    'orientation' => 'portrait',
    // use wk\<html\>topdf
    'engine' => 'alternate',
]);

file_put_contents('invoice-alternate.pdf', $pdf);

/*
// output pdf to browser
$dompdf->stream('invoice.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
*/
