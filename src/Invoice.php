<?php

namespace Oct8pus\Invoice;

use DateTime;
use Dompdf\Dompdf;
use Exception;
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
    protected ?float $subtotal;

    protected ?object $custom;

    protected ?string $html;

    public function __construct(?array $settings)
    {
        // cast array to object
        $settings = (object) $settings;

        $this->rootDir = $settings->rootDir;
        $this->templatesDir = $this->rootDir . DIRECTORY_SEPARATOR . $settings->templatesDir;
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
        $this->subtotal = null;

        $this->custom = null;
        $this->html = null;
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
        if ($this->html) {
            return $this->html;
        }

        $loader = new FilesystemLoader($this->templatesDir);

        $twig = new Environment($loader, [
            // 'cache' => '/path/to/compilation_cache',
        ]);

        Locale::setDefault($this->locale);

        // support for number formatting
        $twig->addExtension(new IntlExtension());

        $this->html = $twig->render('invoice.twig', [
            'invoice' => $this,
        ]);

        return $this->html;
    }

    /**
     * Render pdf
     *
     * @param ?array $options
     *
     * @throws
     *
     * @return string
     */
    public function renderPdf(array $options = []) : string
    {
        if (array_key_exists('engine', $options) && $options['engine'] === 'alternate') {
            $exe = 'wkhtmltopdf';

            if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {
                $exe .= '.exe';
            }

            if (!file_exists($exe)) {
                throw new Exception('cannot find wkhtmltopdf executable');
            }

            $descriptorSpec = [
                // stdin
                0 => ['pipe', 'r'],
                // stdout
                1 => ['pipe', 'w'],
                // stderr
                2 => ['pipe', 'w'], //["file", "/tmp/error-output.txt", "a"],
            ];

            // open process
            $process = proc_open("{$exe} --enable-local-file-access --page-size {$options['paper']} --orientation {$options['orientation']} - -", $descriptorSpec, $pipes, null, null, null);

            if (!is_resource($process)) {
                throw new Exception('wkhtmltopdf open process');
            }

            // write input data
            fwrite($pipes[0], $this->renderHtml());
            fclose($pipes[0]);

            // read output data
            $pdf = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // read errors
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // it is important to close all pipes before calling proc_close in order to avoid a deadlock
            if (proc_close($process) === 0) {
                return $pdf;
            }

            throw new Exception('wkhtmltopdf process return value');
        } else {
            /* uncomment for debugging
            global $_dompdf_show_warnings, $_dompdf_debug, $_DOMPDF_DEBUG_TYPES;

            // record warnings generated by Dompdf
            $_dompdf_show_warnings = false;

            // output frame details for every frame in the document
            $_dompdf_debug = false;

            // record information about page break determination
            $_DOMPDF_DEBUG_TYPES = [
                'page-break' => false,
            ];
            */

            // get temporary directory
            if (array_key_exists('tmp', $options)) {
                $tmp = $options['tmp'];
            } else {
                $tmp = sys_get_temp_dir();
            }

            $options = array_merge([
                // required to load remote content
                'isRemoteEnabled' => true,

                // required to add logo and css but can have security implications
                'chroot' => [
                    $this->rootDir,
                    $tmp,
                ],

                // fonts ttf, ufm and php files
                'fontDir' => $tmp,
                // for fonts php files
                'fontCache' => $tmp,
                'tempDir' => $tmp,

                // https://github.com/dompdf/dompdf/wiki/HTML5-Parser
                'isHtml5ParserEnabled' => true,

                // debugging
                'logOutputFile' => '',
                // extra messaging
                'debugPng' => false,
                // don't delete temp files
                'debugKeepTemp' => false,
                // output style parsing information and frame details for every frame in the document
                'debugCss' => false,
                // draw boxes around frames
                'debugLayout' => false,
                // line boxes
                'debugLayoutLines' => false,
                // block frames
                'debugLayoutBlocks' => false,
                // inline frames
                'debugLayoutInline' => false,
                // padding box
                'debugLayoutPaddingBox' => false,
            ], $options);

            $dompdf = new Dompdf($options);

            if (array_key_exists('paper', $options)) {
                $dompdf->setPaper($options['paper'], $options['orientation'] ?? 'portrait');
            }

            $dompdf->loadHtml($this->renderHtml());

            $dompdf->render();

            return $dompdf->output();
        }
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
        if ($this->subtotal) {
            // hard coded subtotal
            return $this->subtotal;
        } else {
            // calculated subtotal
            $subtotal = 0;

            foreach ($this->items as $item) {
                $subtotal += $item->subtotal();
            }

            return $subtotal;
        }
    }

    public function taxAmount() : float
    {
        return ($this->subtotal() + $this->shipping?->price() - $this->discount?->price()) * $this->tax?->percentage();
    }

    public function total() : float
    {
        $total = $this->subtotal() + $this->shipping?->price() - $this->discount?->price() + $this->taxAmount();

        if ($total <= 0) {
            throw new Exception('invoice total <= 0');
        }

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

    public function setItems(array $items) : self
    {
        $this->items = $items;
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

    public function setSubtotal(?float $subtotal) : self
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    public function setCustomFields(array $fields) : self
    {
        $this->custom = (object) $fields;
        return $this;
    }
}
