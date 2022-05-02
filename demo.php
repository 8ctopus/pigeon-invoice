<?php

use oct8pus\Invoice\Address;
use oct8pus\Invoice\Company;
use oct8pus\Invoice\Discount;
use oct8pus\Invoice\Invoice;
use oct8pus\Invoice\Person;
use oct8pus\Extend\Product;
use oct8pus\Invoice\Tax;

require_once './vendor/autoload.php';

(new \NunoMaduro\Collision\Provider)->register();

$address = new Address("16 Leo Tolstoy Street", "", "119021", "Moscow", "Russia");
$seller = new Company("Widgets Inc.", $address);

$seller->setWebsite('https://www.widgets.ru')
    ->setEmail('hello@widgets.ru');

$address = new Address("Krasnoarmeyskaya 1", "", "620026", "Yekaterinburg", "Russia");
$buyer = new Person("Yuri", "Kamasov", $address);

$locale = 'en';

$invoice = new Invoice(__DIR__, __DIR__ .'/templates/', $locale);

$invoice->setSeller($seller)
    ->setBuyer($buyer)
    // add tax
    ->setTax(new Tax("VAT", 0.21))

    ->setDate(new DateTime('28-04-2022'))
    ->setNumber("EN43UD6JA7I2LNBC17")
    ->setCurrency("$")

    // add products
    ->addProduct(new Product("Product 1", 4.99, 1, 1.000))
    ->addProduct(new Product("Product 2", 9.99, 2, 1.000))
    ->addProduct(new Product("Product 3", 3.99, 3, 1.000))

    ->setDiscount(new Discount("Special Offer", 10.00));

$html = $invoice->renderHtml();

file_put_contents('invoice.html', $html);

$pdf = $invoice->renderPdf();

file_put_contents('invoice.pdf', $pdf);

/*
// output pdf to browser
$dompdf->stream('invoice.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
*/
