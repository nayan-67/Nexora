<?php

namespace App\Jobs;

use App\Mail\Orderinfo;
use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class OrderMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $tries = 3;
    public $timeout = 120;

    protected $data;
    protected $order_id;
    protected $user;

    public function __construct($data, $order_id, $user)
    {
        $this->data = $data;
        $this->order_id = $order_id;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $orderInfo = Orders::find($this->order_id);
        $pdf = Pdf::loadView('pdf.invoice', compact('orderInfo'));
        $path = public_path('invoices/Invoice-' . $this->order_id . '.pdf');
        $pdf->save($path);

        Mail::to($this->user->email)->send(new Orderinfo($this->data, $this->order_id));
    }

    public function backoff()
    {
        return [30, 60, 90]; // Retry after 30 seconds, 1 minute, and 1.30 minutes
    }
}
