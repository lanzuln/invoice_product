<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function all_invoice()
    {
        return Invoice::latest()->get();
        // return response()->json([
        //     "invoices" => $invoices,
        // ], 200);
    }
    public function create_invoice(Request $request)
    {
        return view('pages.new-invoice');
    }

    public function store_invoice(Request $request)
    {
        Invoice::create([
            "customer_id" => $request->customer_id,
            'number' => uniqid(),
            "date" => $request->date,
            "due_date" => $request->due_date,
            "reference" => $request->reference,
            "terms_and_conditions" => $request->terms_and_conditions,
            "discount" => $request->discount,
            "sub_total" => $request->sub_total,
            "total" => $request->total
        ]);
        return response()->json([
            'status' => 'ok',
            'message' => 'Request successfull'
        ], 200);
    }
}
