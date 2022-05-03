<?php

namespace oct8pus\Invoice;

use DateTime;
use Dompdf\Dompdf;
use Locale;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

class Invoice
{
    protected string $templatesDir;
    protected string $rootDir;
    protected string $locale;

    protected ?DateTime $date;
    protected string $number;
    protected string $currency;

    protected ?Entity $seller;
    protected ?Entity $buyer;

    protected array $items;

    protected ?Discount $discount;
    protected ?Shipping $shipping;
    protected ?Tax $tax;

    protected ?object $custom;

    public function __construct(?array $settings)
    {
        // cast array to object
        $settings = (object) $settings;

        $this->rootDir = $settings->rootDir;
        $this->templatesDir = $settings->templatesDir;
        $this->locale = $settings->locale;

        $this->date = null;
        $this->number = '';
        $this->currency = '';

        $this->seller = null;
        $this->buyer = null;

        $this->items = [];

        $this->discount = null;
        $this->shipping = null;
        $this->tax = null;

        $this->custom = null;
    }

    public function __toString() : string
    {
        $result = "{$this->seller}\n";
        $result .= "{$this->buyer}\n";

        $result .= $this->date->format('Y-m-d') . "\n";
        $result .= "{$this->number}\n";

        $total = 0;

        foreach ($this->items as $items) {
            $total += $items->subtotal();

            $result .= "{$items->quantity()}\t{$items->name()}\t{$items->price()}\t{$items->subtotal()}\n";
        }

        return $result . "\t\t\ttotal {$total}\n";
    }

    public function renderHtml() : string
    {
        $loader = new FilesystemLoader($this->templatesDir);

        $twig = new Environment($loader, [
            // 'cache' => '/path/to/compilation_cache',
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

    public function seller() : ?Entity
    {
        return $this->seller;
    }

    public function buyer() : ?Entity
    {
        return $this->buyer;
    }

    public function items() : array
    {
        return $this->items;
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

        foreach ($this->items as $items) {
            $subtotal += $items->subtotal();
        }

        return $subtotal;
    }

    public function taxAmount() : float
    {
        return ($this->subtotal() + $this->shipping?->price() - $this->discount?->price()) * $this->tax?->percentage();
    }

    public function total() : float
    {
        $total = $this->subtotal() + $this->shipping?->price() - $this->discount?->price() + $this->taxAmount();

        assert($total > 0);

        return $total;
    }

    public function discount() : ?Discount
    {
        return $this->discount;
    }

    public function shipping() : ?Shipping
    {
        return $this->shipping;
    }

    public function tax() : ?Tax
    {
        return $this->tax;
    }

    public function custom() : object
    {
        return $this->custom;
    }

    public function rootDir() : string
    {
        return $this->rootDir;
    }

    public function addItem(Item $item) : self
    {
        array_push($this->items, $item);
        return $this;
    }

    public function setSeller(Entity $seller) : self
    {
        $this->seller = $seller;
        return $this;
    }

    public function setBuyer(Entity $buyer) : self
    {
        $this->buyer = $buyer;
        return $this;
    }

    public function setDate(DateTime $date) : self
    {
        $this->date = $date;
        return $this;
    }

    public function setNumber(string $number) : self
    {
        $this->number = $number;
        return $this;
    }

    public function setCurrency(string $currency) : self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setDiscount(?Discount $discount) : self
    {
        $this->discount = $discount;
        return $this;
    }

    public function setShipping(?Shipping $shipping) : self
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function setTax(?Tax $tax) : self
    {
        $this->tax = $tax;
        return $this;
    }

    public function setCustomFields(array $fields) : self
    {
        $this->custom = (object) $fields;
        return $this;
    }
}
