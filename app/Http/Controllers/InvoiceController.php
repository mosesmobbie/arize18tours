<?php

namespace App\Http\Controllers;

use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Quotation;
use App\Helpers\ContactHelper;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private function invoiceData(Request $request): array
    {
        $quotation = Quotation::with('items')->findOrFail($request->input('quotation_id'));
        $taxPercent = -15;
        $taxFactor = 1 + ($taxPercent / 100);

        $items = $quotation->items->map(function ($item) {
            $qty = max((int) $item->unit, 1);
            return [
                'title'       => $item->name,
                'description' => $item->description,
                'note'        => null,
                'quantity'    => $qty,
                'rate'        => round($item->amount / $qty, 2),
                'amount'      => $item->amount,
            ];
        })->toArray();

        if ((float) $quotation->deposit_amount > 0) {
            $items[] = [
                'title'       => 'Refundable Deposit',
                'description' => null,
                'note'        => null,
                'quantity'    => 1,
                'rate'        => (float) $quotation->deposit_amount,
                'amount'      => (float) $quotation->deposit_amount,
            ];
        }

        $rawSubtotal = collect($items)->sum('amount');

        $items = array_map(function ($item) use ($taxFactor) {
            $item['rate'] = round((float) $item['rate'] * $taxFactor, 2);
            $item['amount'] = round((float) $item['amount'] * $taxFactor, 2);

            return $item;
        }, $items);

        $subtotal = collect($items)->sum('amount');
        $taxAmount = round($subtotal - $rawSubtotal, 2);

        return [
            'invoice_number'  => str_pad($quotation->id, 6, '0', STR_PAD_LEFT),
            'bill_to'         => $quotation->name,
            'bill_to_phone'   => $quotation->phone,
            'invoice_date'    => $quotation->created_at->format('M d, Y'),
            'balance_due'     => $quotation->total_amount - $quotation->amount_paid,
            'items'           => $items,
            'subtotal'        => $subtotal,
            'tax_percent'     => $taxPercent,
            'tax_amount'      => $taxAmount,
            'total'           => $quotation->total_amount,
            'payment_details' => [
                'Account Name: ' . env('PAYMENT_ACCOUNT_NAME'),
                'Bank Name: '    . env('PAYMENT_BANK_NAME').' (' . env('PAYMENT_BRANCH_CODE') . ')',
                'Account No.: '  . env('PAYMENT_ACCOUNT_NUMBER'),
                'Account Type: ' . env('PAYMENT_ACCOUNT_TYPE'),
                'Reference: '    . str_pad($quotation->id, 6, '0', STR_PAD_LEFT),
            ],
            'terms' => '50% Payment confirms booking.',
        ];
    }

    public function preview(Request $request)
    {
        $invoice = (object) $this->invoiceData($request);

        return view('pdfs.invoice', [
            'invoice'          => $invoice,
            'isPdf'            => false,
            'showDownloadLink' => true,
            'quotationId'      => $request->input('quotation_id'),
            'printType'        => $request->input('print', 'quote'),
            'contact'          => ContactHelper::getActive(),
        ]);
    }

    public function generateInvoice(Request $request)
    {
        $invoice = (object) $this->invoiceData($request);

        return Pdf::view('pdfs.invoice', [
            'invoice'          => $invoice,
            'isPdf'            => true,
            'showDownloadLink' => false,
            'printType'        => $request->input('print', 'quote'),
            'contact'          => ContactHelper::getActive(),
        ])
        ->name('invoice-' . $invoice->invoice_number . '.pdf')
        ->download();
    }
}
