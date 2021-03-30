@extends('layouts.main')

@section('title', 'Invoices')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th colspan="2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>
                        {{$invoice->id}}
                    </td>
                    <td>
                        {{$invoice->invoice_date}}
                    </td>
                    <td>
                        {{$invoice->customer->full_name}}
                    </td>
                    <td>
                        ${{$invoice->total}}
                    </td>
                    <td>
                        @can('view', $invoice)
                            <a href="{{ route('invoice.show', [ 'id' => $invoice->id ]) }}">
                                Details
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection