<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
            'paymentOption' => 'Bank Transfer',
            'name' => 'tester',
            'amount' => number_format(70, 2),
            'products' => [[
                "id" => "5ijVADxXLTqLqYwVpJelh5",
                "quantity" => 1,
                "totalPrice" => 25.2
            ]],
            "totalAmount" => 25.2,
            "totalDiscount" => 5,
            "shippingFee" => 8,
            "totalAfterDiscount" => 28.2,
            "note" => 'testing',
            'receiverName' => 'test receiver',
            'phoneNo' => '1234567',
            'addressLine1' => '1, Lorong Test 2',
            'addressLine2' => 'Taman Test',
            'postcode' => 12300,
            'city' => 'test city',
            'state' => 'Selangor',
            'country' => 'Malaysia'
        ]);
    }
}
