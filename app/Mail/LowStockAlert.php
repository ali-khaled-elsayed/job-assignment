<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Ingredient $ingredient)
    {
        //
    }

    public function build()
    {
        return $this->subject('Low Stock Alert')
                    ->view('emails.low_stock_alert')
                    ->with([
                        'name' => $this->ingredient->name,
                        'remaining' => $this->ingredient->stock,
                    ]);
    }
}
