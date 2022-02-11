@extends('templates.main')

@section('title_page')
    Reports
@endsection

@section('breadcrumb_title')
    invoices
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card card-secondary">
          <div class="card-header">
            <div class="card-title">Invoice Detail</div>
            <a href="{{ route('reports.report8.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-undo"></i> Back</a>
          </div>
          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-4 text-right">ID</dt>
              <dd class="col-sm-8">: {{ $invoice->inv_id }}</dd>
              <dt class="col-sm-4 text-right">Invoice No</dt>
              <dd class="col-sm-8">: {{ $invoice->inv_no }}</dd>
              <dt class="col-sm-4 text-right">Invoice Date</dt>
              <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($invoice->inv_date)) }}</dd>
              <dt class="col-sm-4 text-right">Vendor</dt>
              <dd class="col-sm-8">: {{ $invoice->vendor->vendor_name }}</dd>
              <dt class="col-sm-4 text-right">Branch</dt>
              <dd class="col-sm-8">: {{ $invoice->vendorbranch->branch }}</dd>
              <dt class="col-sm-4 text-right">Receive Date</dt>
              <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($invoice->receive_date)) }}</dd>
              <dt class="col-sm-4 text-right">Receive Place</dt>
              <dd class="col-sm-8">: {{ $invoice->receive_place }}</dd>
              <dt class="col-sm-4 text-right">Payment Place</dt>
              <dd class="col-sm-8">: {{ $invoice->payment_place }}</dd>
              <dt class="col-sm-4 text-right">PO No</dt>
              <dd class="col-sm-8">: {{ $invoice->po_no }}</dd>
              <dt class="col-sm-4 text-right">Invoice Type</dt>
              <dd class="col-sm-8">: {{ $invoice->invtype->invtype_name }}</dd>
              <dt class="col-sm-4 text-right">Project</dt>
              <dd class="col-sm-8">: {{ $invoice->project->project_code }}</dd>
              <dt class="col-sm-4 text-right">Currency</dt>
              <dd class="col-sm-8">: {{ $invoice->inv_currency }}</dd>
              <dt class="col-sm-4 text-right">Amount</dt>
              <dd class="col-sm-8">: {{ number_format($invoice->inv_nominal, 2) }}</dd>
              <dt class="col-sm-4 text-right">VAT</dt>
              <dd class="col-sm-8">: {{ $invoice->vat }}</dd>
              <dt class="col-sm-4 text-right">Faktur No</dt>
              <dd class="col-sm-8">: {{ $invoice->faktur_no }}</dd>
              <dt class="col-sm-4 text-right">Status</dt>
              <dd class="col-sm-8">: {{ $invoice->inv_status }}</dd>
              <dt class="col-sm-4 text-right">Payment Date</dt>
              <dd class="col-sm-8">: {{ $invoice->payment_date ? date('d-M-Y', strtotime($invoice->payment_date)) :  '' }}</dd>
              <dt class="col-sm-4 text-right">Verification Date</dt>
              <dd class="col-sm-8">: {{ $invoice->to_verify_date ? date('d-M-Y', strtotime($invoice->to_verify_date)) : '' }}</dd>
              <dt class="col-sm-4 text-right">Receive Jkt date</dt>
              <dd class="col-sm-8">: {{ $invoice->mailroom_jkt_date ? date('d-M-Y', strtotime($invoice->mailroom_jkt_date)) : '' }}</dd>
              <dt class="col-sm-4 text-right">Remarks</dt>
              <dd class="col-sm-8">: {{ $invoice->remarks }}<dd>
              <dt class="col-sm-4 text-right">Sent Status</dt>
              <dd class="col-sm-8">: {{ $invoice->sent_status }}<dd>
              <dt class="col-sm-4 text-right">SPI No</dt>
              <dd class="col-sm-8">: {{ $invoice->spis_id ? $invoice->spi->nomor :  '' }}<dd>
              <dt class="col-sm-4 text-right">SPI Date</dt>
              <dd class="col-sm-8">: {{ $invoice->mailroom_bpn_date ? date('d-M-Y', strtotime($invoice->mailroom_bpn_date)) : '' }}</dd>
              <dt class="col-sm-4 text-right">Created by</dt>
              <dd class="col-sm-8">: {{ $invoice->creator }}<dd>
              <dt class="col-sm-4 text-right">Created at</dt>
              <dd class="col-sm-8">: {{ $invoice->created_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->created_at))) : '' }}<dd>
              <dt class="col-sm-4 text-right">Last Updated</dt>
              <dd class="col-sm-8">: {{ $invoice->updated_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->updated_at))) : '' }}<dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
@endsection