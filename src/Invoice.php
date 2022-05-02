<?php

namespace oct8pus\Invoice;

use DateTime;
use Locale;
use Dompdf\Dompdf;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;

class Invoice
{
    protected string $templatesDir;
    protected string $rootDir;
    protected string $locale;

    protected DateTime $date;
    protected string $number;
    protected string $currency;
    protected Entity $seller;
    protected Entity $buyer;
    protected array $products;
    protected ?Discount $discount;
    protected ?Tax $tax;

    public function __construct(string $rootDir, string $templatesDir, string $locale)
    {
        $this->rootDir = $rootDir;
        $this->templatesDir = $templatesDir;
        $this->locale = $locale;

        $this->products = [];
        $this->discount = null;
        $this->tax = null;
    }

    public function renderHtml() : string
    {
        $loader = new FilesystemLoader($this->templatesDir);

        $twig = new Environment($loader, [
            //'cache' => '/path/to/compilation_cache',
        ]);

        Locale::setDefault($this->locale);

        // support for number formatting
        $twig->addExtension(new IntlExtension());

        return $twig->render('invoice.twig', [
            'invoice' => $this,
        ]);
    }

    public function renderPdf() : string
    {
        $html = $this->renderHtml();

        // convert invoice to pdf
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();

        $dompdf->setPaper('A4', 'portrait');

        // required to add logo and css but can have security implications
        $options->setChroot($this->rootDir);

        $dompdf->loadHtml($this->renderHtml());

        $options->setIsHtml5ParserEnabled(true);

        $dompdf->render();

        return $dompdf->output();
    }

    public function __toString() : string
    {
        $result = "{$this->seller}\n";
        $result .= "{$this->buyer}\n";

        $result .= $this->date->format('Y-m-d') . "\n";
        $result .= "{$this->number}\n";

        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->subtotal();

            $result .= "{$product->quantity()}\t{$product->name()}\t{$product->price()}\t{$product->subtotal()}\n";
        }

        return $result . "\t\t\ttotal {$total}\n";
    }

    public function addProduct(Product $product) : void
    {
        array_push($this->products, $product);
    }

    public function setSeller(Entity $seller) : void
    {
        $this->seller = $seller;
    }

    public function setBuyer(Entity $buyer) : void
    {
        $this->buyer = $buyer;
    }

    public function setDate(DateTime $date) : void
    {
        $this->date = $date;
    }

    public function setNumber(string $number) : void
    {
        $this->number = $number;
    }

    public function setCurrency(string $currency) : void
    {
        $this->currency = $currency;
    }

    public function setDiscount(?Discount $discount) : void
    {
        $this->discount = $discount;
    }

    public function setTax(?Tax $tax) : void
    {
        $this->tax = $tax;
    }

    public function products() : array
    {
        return $this->products;
    }

    public function seller() : Entity
    {
        return $this->seller;
    }

    public function buyer() : Entity
    {
        return $this->buyer;
    }

    public function date() : string
    {
        return $this->date->format('Y-m-d');
    }

    public function number() : string
    {
        return $this->number;
    }

    public function currency() : string
    {
        return $this->currency;
    }

    public function subtotal() : float
    {
        $subtotal = 0;

        foreach ($this->products as $product) {
            $subtotal += $product->subtotal();
        }

        return $subtotal;
    }

    public function taxAmount() : float
    {
        return ($this->subtotal() - $this->discount?->price()) * $this->tax?->percentage();
    }

    public function total() : float
    {
        $total = $this->subtotal() - $this->discount?->price() + $this->taxAmount();

        assert($total > 0);

        return $total;
    }

    public function discount() : ?Discount
    {
        return $this->discount;
    }

    public function tax() : ?Tax
    {
        return $this->tax;
    }
}
