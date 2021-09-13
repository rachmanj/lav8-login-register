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
              {{-- <li><a href="{{ route('reports.report1') }}">Additional Documents (<b>tabel doktam</b>) yg belum ada invoicenya (<b>tabel irr5_invoice)</b></a>.</li> --}}
              <li><a href="#">Additional Documents (<b>tabel doktam</b>) yg belum ada invoicenya (<b>tabel irr5_invoice)</b></a>.</li>
              <li>List Invoice vs possibe doktams (doktams yg belum ada ivnoicesnya vs invoice dgn PO yg sama dgn PO di doktams).</li>
              <li>Report 3: List invoice yg sudah lengkap tapi belum SPI (Invoice dgn pending doktams zero  tapi belum ada SPI nya)</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endsection