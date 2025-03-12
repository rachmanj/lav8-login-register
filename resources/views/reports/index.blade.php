@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    reports
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
            <h3 class="card-title">Reports</h3>
          </div> --}}
                <div class="card-body">
                    <ol>
                        <li><a href="{{ route('reports.report1') }}">List Additional Documents (<b>tabel doktam</b>) yg belum
                                ada invoicenya / belum terhubung dgn invoice (<b>tabel irr5_invoice)</b></a>.</li>
                        <li><a href="{{ route('reports.report2.index') }}">List Invoice vs Additional Document dgn PO yg sama
                                dan belum terhubung.</a></li>
                        <li><a href="{{ route('reports.report3') }}">Cek Additional Docs di table <b>irr5_rec_addoc</b>, dan
                                jika ada dicopy ke table <b>doktams</b>.</a></li>
                        @if (Auth()->user()->role == 'SUPERADMIN' || Auth()->user()->role == 'ADMINACC')
                            <li><a href="{{ route('reports.report4') }}">Invoice dgn Additional Documents lengkap, namun
                                    belum di-SPI-kan.</a></li>
                            <li><a href="{{ route('reports.report5') }}">ITO tanpa nomor PO</a></li>
                            <li><a href="{{ route('reports.report98') }}">Additional Document (doktams) - Edit field
                                    invoice_id</a></li>
                            <li><a href="{{ route('reports.report99') }}">Edit Payment Place</a></li>
                            <li><a href="{{ route('reports.report7.index') }}">Additional Documents (doktams) tanpa nomor
                                    Invoice > 60 hari</a></li>
                            <li><a href="{{ route('reports.report8.index') }}">All Invoice</a></li>
                            <li><a href="{{ route('reports.report9.index') }}">Invoice by Month of receive, order by Days of
                                    completion & status</a></li>
                            <li><a href="{{ route('reports.report10.index') }}">Search Additional Document to attach
                                    document file</a></li>
                            <li><a href="{{ route('reports.report11.index') }}">Search Invoice to attach document file</a>
                            </li>
                        @endif
                        <li><a href="{{ route('reports.report12.index') }}">List of Invoices with Attachment</a></li>
                        <li><a href="{{ route('reports.reconcile.index') }}">Reconciliation</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
