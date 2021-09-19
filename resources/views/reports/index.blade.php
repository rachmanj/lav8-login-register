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
              <li><a href="{{ route('reports.report1') }}">List Additional Documents (<b>tabel doktam</b>) yg belum ada invoicenya / belum terhubung dgn invoice (<b>tabel irr5_invoice)</b></a>.</li>
              <li><a href="{{ route('reports.report2') }}">List Invoice vs Additional Document dgn PO yg sama dan belum terhubung.</a></li>
              <li><a href="{{ route('reports.report3') }}">Cek Additional Docs di table <b>irr5_rec_addoc</b>, dan jika ada dicopy ke table <b>doktams</b>.</a></li>
              <li><a href="{{ route('reports.report4') }}">Invoice dgn Additional Documents lengkap, namun belum di-SPI-kan.</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endsection