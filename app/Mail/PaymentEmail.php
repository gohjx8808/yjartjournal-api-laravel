<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $paymentOption;
    protected $products;
    protected $totalAmount;
    protected $totalDiscount;
    protected $shippingFee;
    protected $totalAfterDiscount;
    protected $note;
    protected $receiverName;
    protected $phoneNo;
    protected $addressLine1;
    protected $addressLine2;
    protected $postcode;
    protected $city;
    protected $state;
    protected $country;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $paymentOption,
        $products,
        float $totalAmount,
        float|null $totalDiscount,
        float $shippingFee,
        float $totalAfterDiscount,
        string|null $note,
        string $receiverName,
        string $phoneNo,
        string $addressLine1,
        string|null $addressLine2,
        string $postcode,
        string $city,
        string $state,
        string $country,
    ) {
        $this->name = $name;
        $this->paymentOption = $paymentOption;
        $this->products = $products;
        $this->totalAmount = $totalAmount;
        $this->totalDiscount = $totalDiscount;
        $this->shippingFee = $shippingFee;
        $this->totalAfterDiscount = $totalAfterDiscount;
        $this->note = $note;
        $this->receiverName = $receiverName;
        $this->phoneNo = $phoneNo;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Complete Your YJ Art Journal Order';

        return $this->view('emails.payment')->subject($subject)->with([
            'paymentOption' => $this->paymentOption,
            'name' => $this->name,
            'products' => $this->products,
            "totalAmount" => number_format($this->totalAmount, 2),
            "totalDiscount" => number_format($this->totalDiscount, 2),
            "shippingFee" => number_format($this->shippingFee, 2),
            "totalAfterDiscount" => number_format($this->totalAfterDiscount, 2),
            "note" => $this->note,
            'receiverName' => $this->receiverName,
            'phoneNo' => $this->phoneNo,
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);
    }
}
