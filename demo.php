<?php

use Dompdf\Dompdf;
use oct8pus\Invoice\Address;
use oct8pus\Invoice\Company;
use oct8pus\Invoice\Discount;
use oct8pus\Invoice\Invoice;
use oct8pus\Invoice\Person;
use oct8pus\Invoice\Product;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require_once './vendor/autoload.php';

(new \NunoMaduro\Collision\Provider)->register();

$address = new Address("16 Leo Tolstoy Street", "", "119021", "Moscow", "Russia");
$seller = new Company("Widgets Inc.", $address);

$seller->addWebsite('https://www.widgets.ru');
$seller->addEmail('hello@widgets.ru');

$address = new Address("Krasnoarmeyskaya 1", "", "620026", "Yekaterinburg", "Russia");
$buyer = new Person("Yuri", "Kamasov", $address);

$invoice = new Invoice();
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

$loader = new FilesystemLoader('./templates');

$twig = new Environment($loader, [
    //'cache' => '/path/to/compilation_cache',
]);

// render invoice
$invoiceHtml = $twig->render('invoice.twig', [
    'invoice' => $invoice,
]);

file_put_contents('invoice.html', $invoiceHtml);

// convert invoice to pdf
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->setIsHtml5ParserEnabled(true);

// required to add logo and css but can have security implications
$options->setChroot(__DIR__);
$dompdf->loadHtml($invoiceHtml);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

file_put_contents('invoice.pdf', $dompdf->output());

/*
// output pdf to browser
$dompdf->stream('invoice.pdf', [
    'compress' => true,
    'Attachment' => false,
]);
*/
