<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\User;

class SellerTransactionCompletedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $product; // 商品情報
    public $buyer;   // 購入者情報

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product, User $buyer)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
