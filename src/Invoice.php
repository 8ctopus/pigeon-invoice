<?php

namespace oct8pus\Invoice;

use DateTime;

class Invoice
{
    protected DateTime $date;
    protected string $transactionId;
    protected string $currency;
    protected Entity $seller;
    protected Entity $buyer;
    protected array $products;
    protected ?Discount $discount;

    public function __construct()
    {
        $this->products = [];
        $this->discount = null;
    }

    public function __toString() : string
    {
        $result = "{$this->seller}\n";
        $result .= "{$this->buyer}\n";

        $result .= $this->date->format('Y-m-d') . "\n";
        $result .= "{$this->transactionId}\n";

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

    public function addSeller(Entity $seller) : void
    {
        $this->seller = $seller;
    }

    public function addBuyer(Entity $buyer) : void
    {
        $this->buyer = $buyer;
    }

    public function addDate(DateTime $date) : void
    {
        $this->date = $date;
    }

    public function addTransactionId(string $transactionId) : void
    {
        $this->transactionId = $transactionId;
    }

    public function addCurrency(string $currency) : void
    {
        $this->currency = $currency;
    }

    public function addDiscount(?Discount $discount) : void
    {
        $this->discount = $discount;
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
        return $this->date->format('F j, Y');
    }

    public function transactionId() : string
    {
        return $this->transactionId;
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

    public function total() : float
    {
        if (!$this->discount) {
            return $this->subtotal();
        }

        $total = $this->subtotal() - $this->discount->price();

        assert($total > 0);

        return $total;
    }

    public function discount() : ?Discount
    {
        return $this->discount;
    }
}
