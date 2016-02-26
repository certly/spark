<?php

namespace Laravel\Spark\Billing;

use Laravel\Spark\Spark;
use Laravel\Cashier\Invoice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\Expression as ViewExpression;
use Laravel\Spark\Contracts\Billing\InvoiceNotifier;

class EmailInvoiceNotifier implements InvoiceNotifier
{
    /**
     * Notify the given user about a new invoice.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Cashier\Invoice  $invoice
     * @return void
     */
    public function notify(Authenticatable $user, Invoice $invoice)
    {
        $invoiceData = array_merge([
            'vendor' => 'Vendor',
            'product' => 'Product',
            'vat' => new ViewExpression(nl2br(e($user->extra_billing_info))),
        ], Spark::generateInvoicesWith());

        $data = compact('user', 'invoice', 'invoiceData');

        Mail::send('spark::emails.billing.invoice', $data, function ($message) use ($user, $invoice, $invoiceData) {
            $message->to($user->email, $user->name)
                    ->subject('Your '.$invoiceData['product'].' Invoice')
                    ->attachData($invoice->pdf($invoiceData), 'invoice.pdf');
        });
    }
}
