<?php

use oct8pus\Invoice\Address;
use oct8pus\Invoice\Company;
use oct8pus\Invoice\Discount;
use oct8pus\Invoice\Invoice;
use oct8pus\Invoice\Person;
use oct8pus\Invoice\Product;

require_once './vendor/autoload.php';

(new \NunoMaduro\Collision\Provider)->register();

$address = new Address("16 Leo Tolstoy Street", "", "119021", "Moscow", "Russia");
$seller = new Company("Widgets Inc.", $address);

$seller->addWebsite('https://www.widgets.ru');
$seller->addEmail('hello@widgets.ru');

$address = new Address("Krasnoarmeyskaya 1", "", "620026", "Yekaterinburg", "Russia");
$buyer = new Person("Yuri", "Kamasov", $address);

$invoice = new Invoice(__DIR__, __DIR__ .'/templates/');
$invoice->addSeller($seller);
$invoice->addBuyer($buyer);

$invoice->addDate(new DateTime('28-04-2022'));
$invoice->addTransactionId("EN43UD6JA7I2LNBC17");
$invoice->addCurrency("$");

// add products
$invoice->addProduct(new Product("Product 1", 4.99, 1, 1.000));
$invoice->addProduct(new Product("Product 2", 9.99, 2, 1.000));
$invoice->addProduct(new Product("Product 3", 3.99, 3, 1.000));

$invoice->addDiscount(new Discount("Special Offer", 10.00));

file_put_contents('invoice.html', $invoice->renderHtml());

file_put_contents('invoice.pdf', $invoice->renderPdf());

/*
// output pdf to browser
$dompdf->stream('invoice.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
*/
