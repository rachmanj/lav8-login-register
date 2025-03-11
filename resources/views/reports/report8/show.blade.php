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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice: {{ $invoice->inv_no }}</h3>
                    <a href="{{ route('reports.report8.index') }}" class="btn btn-sm btn-primary float-right"><i
                            class="fas fa-undo"></i> Back</a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="invoiceTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                                aria-controls="details" aria-selected="true">Invoice Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab"
                                aria-controls="documents" aria-selected="false">Additional Documents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="spi-tab" data-toggle="tab" href="#spi" role="tab"
                                aria-controls="spi" aria-selected="false">SPI Information</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="invoiceTabContent">
                        <!-- Invoice Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <div class="card-title">Invoice Detail</div>
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
                                        <dd class="col-sm-8">: {{ $invoice->vendor->vendor_name ?? 'N/A' }}</dd>
                                        <dt class="col-sm-4 text-right">Branch</dt>
                                        <dd class="col-sm-8">: {{ $invoice->vendorbranch->branch ?? 'N/A' }}</dd>
                                        <dt class="col-sm-4 text-right">Receive Date</dt>
                                        <dd class="col-sm-8">: {{ date('d-M-Y', strtotime($invoice->receive_date)) }}</dd>
                                        <dt class="col-sm-4 text-right">Receive Place</dt>
                                        <dd class="col-sm-8">: {{ $invoice->receive_place }}</dd>
                                        <dt class="col-sm-4 text-right">Payment Place</dt>
                                        <dd class="col-sm-8">: {{ $invoice->payment_place }}</dd>
                                        <dt class="col-sm-4 text-right">PO No</dt>
                                        <dd class="col-sm-8">: {{ $invoice->po_no }}</dd>
                                        <dt class="col-sm-4 text-right">Invoice Type</dt>
                                        <dd class="col-sm-8">: {{ $invoice->invtype->invtype_name ?? 'N/A' }}</dd>
                                        <dt class="col-sm-4 text-right">Project</dt>
                                        <dd class="col-sm-8">: {{ $invoice->project->project_code ?? 'N/A' }}</dd>
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
                                        <dd class="col-sm-8">:
                                            {{ $invoice->payment_date ? date('d-M-Y', strtotime($invoice->payment_date)) : '' }}
                                        </dd>
                                        <dt class="col-sm-4 text-right">Verification Date</dt>
                                        <dd class="col-sm-8">:
                                            {{ $invoice->to_verify_date ? date('d-M-Y', strtotime($invoice->to_verify_date)) : '' }}
                                        </dd>
                                        <dt class="col-sm-4 text-right">Receive Jkt date</dt>
                                        <dd class="col-sm-8">:
                                            {{ $invoice->mailroom_jkt_date ? date('d-M-Y', strtotime($invoice->mailroom_jkt_date)) : '' }}
                                        </dd>
                                        <dt class="col-sm-4 text-right">Remarks</dt>
                                        <dd class="col-sm-8">: {{ $invoice->remarks }}</dd>
                                        <dt class="col-sm-4 text-right">Sent Status</dt>
                                        <dd class="col-sm-8">: {{ $invoice->sent_status }}</dd>
                                        <dt class="col-sm-4 text-right">Created by</dt>
                                        <dd class="col-sm-8">: {{ $invoice->creator }}</dd>
                                        <dt class="col-sm-4 text-right">Created at</dt>
                                        <dd class="col-sm-8">:
                                            {{ $invoice->created_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->created_at))) : '' }}
                                        </dd>
                                        <dt class="col-sm-4 text-right">Last Updated</dt>
                                        <dd class="col-sm-8">:
                                            {{ $invoice->updated_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->updated_at))) : '' }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Documents Tab -->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <div class="card-title">Additional Documents</div>
                                </div>
                                <div class="card-body">
                                    @if ($invoice->doktams->count() > 0)
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Document No</th>
                                                    <th>Document Type</th>
                                                    <th>Receive Date</th>
                                                    <th>PO No</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoice->doktams as $index => $doktam)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $doktam->document_no }}</td>
                                                        <td>{{ $doktam->doctype->docdesc ?? 'N/A' }}</td>
                                                        <td>{{ $doktam->receive_date ? date('d-M-Y', strtotime($doktam->receive_date)) : 'N/A' }}
                                                        </td>
                                                        <td>{{ $doktam->doktams_po_no }}</td>
                                                        <td>{{ $doktam->status }}</td>
                                                        <td>{{ $doktam->created_by }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-info">
                                            No additional documents found for this invoice.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- SPI Information Tab -->
                        <div class="tab-pane fade" id="spi" role="tabpanel" aria-labelledby="spi-tab">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <div class="card-title">SPI Information</div>
                                </div>
                                <div class="card-body">
                                    @if ($invoice->spis_id)
                                        <dl class="row">
                                            <dt class="col-sm-4 text-right">SPI No</dt>
                                            <dd class="col-sm-8">: {{ $invoice->spi->nomor ?? 'N/A' }}</dd>
                                            <dt class="col-sm-4 text-right">SPI Date</dt>
                                            <dd class="col-sm-8">:
                                                {{ $invoice->mailroom_bpn_date ? date('d-M-Y', strtotime($invoice->mailroom_bpn_date)) : 'N/A' }}
                                            </dd>
                                            <dt class="col-sm-4 text-right">To Project</dt>
                                            <dd class="col-sm-8">: {{ $invoice->spi->to_project->project_code ?? 'N/A' }}
                                            </dd>
                                            <dt class="col-sm-4 text-right">Created At</dt>
                                            <dd class="col-sm-8">:
                                                {{ $invoice->spi->created_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->spi->created_at))) : 'N/A' }}
                                            </dd>
                                            <dt class="col-sm-4 text-right">Updated At</dt>
                                            <dd class="col-sm-8">:
                                                {{ $invoice->spi->updated_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->spi->updated_at))) : 'N/A' }}
                                            </dd>
                                        </dl>
                                    @else
                                        <div class="alert alert-info">
                                            No SPI information found for this invoice.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Additional styles if needed -->
@endsection

@section('scripts')
    <script>
        $(function() {
            // Activate the first tab by default
            $('#invoiceTab a:first').tab('show');
        });
    </script>
@endsection
