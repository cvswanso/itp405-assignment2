<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Invoice::class);

        // $invoices = Invoice::all(); // SLOW because of N+1 queries
        $invoices = Invoice::select('invoices.*')
            ->with(['customer'])
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->when(!Auth::user()->isAdmin(), function($query) {
                return $query->where('customers.email', '=', Auth::user()->email);
            })
            ->get();

        return view('invoice.index', [
            'invoices' => $invoices
        ]);
    }

    public function show($id)
    {
        // $invoice = Invoice::find($id); // SLOW because of N+1 queries
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album',
            'invoiceItems.track.album.artist',
        ])->find($id);

        // if (Gate::denies('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // if (!Gate::allows('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // if (Auth::user()->cannot('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // if (!Auth::user()->can('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // $this->authorize('view-invoice', $invoice);

        $this->authorize('view', $invoice);

        // if (Gate::denies('view', $invoice)) {
        //     abort(403);
        // }

        // if (Auth::user()->cannot('view', $invoice)) {
        //     abort(403);
        // }

        return view('invoice.show', [
            'invoice' => $invoice,
        ]);
    }
}