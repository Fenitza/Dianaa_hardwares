<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class BulkOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $quantity;
    public $message;
    public $userName;
    public $userEmail;
    public $userPhone;

    public function __construct($data)
    {
        $this->product = Product::find($data['productId']);
        $this->quantity = $data['quantity'];
        $this->emailMessage = $data['message'];
        $this->userName = $data['userName'];
        $this->userEmail = $data['userEmail'];
        $this->userPhone = $data['userPhone'];
    }

    public function build()
    {
        return $this->view('emails.bulkOrder')
                    ->with([
                        'product_name' => $this->product ? $this->product->Name : 'Product not found',
                        'sku' =>  $this->product ? $this->product->SKU : 'Product not found',
                        'quantity' => $this->quantity,
                        'emailMessage' => $this->emailMessage,
                        'userName' => $this->userName,
                        'userEmail' => $this->userEmail,
                        'userPhone' => $this->userPhone
                    ]);
    }
}
