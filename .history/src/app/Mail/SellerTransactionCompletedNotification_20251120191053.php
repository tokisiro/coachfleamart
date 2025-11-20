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
    public $seller; // 出品者
    public $buyer;   // 購入者情報

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product,User $seller, User $buyer)
    {
        $this->product = $product;
        $this->seller = $seller;
        $this->buyer = $buyer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【' . config('app.name') . '】商品「' . $this->product->ppname . '」の取引が完了しました！', // メールの件名
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.seller_transaction_completed', // Bladeテンプレートの指定 (後で作成)
            // または view: 'transaction_completed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
