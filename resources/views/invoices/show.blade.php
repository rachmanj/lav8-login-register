@extends('templates.main')

@section('title_page')
    Invoice Detail
@endsection

@section('breadcrumb_title')
    invoice detail
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice: {{ $invoice->inv_no }}</h3>
                    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary float-right"><i
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
                        <li class="nav-item">
                            <a class="nav-link" id="followup-tab" data-toggle="tab" href="#followup" role="tab"
                                aria-controls="followup" aria-selected="false">Follow Up</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="invoiceTabContent">
                        <!-- Invoice Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row">
                                <!-- Basic Invoice Information -->
                                <div class="col-md-6">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Basic Invoice Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th style="width: 40%">Invoice ID</th>
                                                    <td>{{ $invoice->inv_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Invoice Number</th>
                                                    <td>{{ $invoice->inv_no }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Invoice Date</th>
                                                    <td>{{ $invoice->inv_date ? date('d-M-Y', strtotime($invoice->inv_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Invoice Type</th>
                                                    <td>{{ $invoice->invtype->invtype_name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $invoice->inv_status == 'PENDING' ? 'warning' : ($invoice->inv_status == 'SAP' ? 'success' : 'secondary') }}">
                                                            {{ $invoice->inv_status ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Financial Information -->
                                <div class="col-md-6">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Financial Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th style="width: 40%">Amount</th>
                                                    <td>{{ $invoice->inv_currency ?? 'Rp' }}
                                                        {{ number_format($invoice->inv_nominal, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>VAT</th>
                                                    <td>{{ $invoice->vat ? number_format($invoice->vat, 2) : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>PO Number</th>
                                                    <td>{{ $invoice->po_no ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Faktur Number</th>
                                                    <td>{{ $invoice->faktur_no ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Date</th>
                                                    <td>{{ $invoice->payment_date ? date('d-M-Y', strtotime($invoice->payment_date)) : 'Not paid yet' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vendor & Project Information -->
                                <div class="col-md-6">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Vendor & Project Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th style="width: 40%">Vendor</th>
                                                    <td>{{ $invoice->vendor->vendor_name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Vendor Branch</th>
                                                    <td>{{ $invoice->vendorbranch->branch_name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Project</th>
                                                    <td>{{ $invoice->project->project_code ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Place</th>
                                                    <td>{{ $invoice->payment_place ?? 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="col-md-6">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Processing Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th style="width: 40%">Receive Date</th>
                                                    <td>{{ $invoice->receive_date ? date('d-M-Y', strtotime($invoice->receive_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created By</th>
                                                    <td>{{ $invoice->creator ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td>{{ $invoice->created_at ? date('d-M-Y H:i:s', strtotime($invoice->created_at)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Updated At</th>
                                                    <td>{{ $invoice->updated_at ? date('d-M-Y H:i:s', strtotime($invoice->updated_at)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Remarks -->
                                <div class="col-md-12">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Remarks</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $invoice->remarks ?? 'No remarks available.' }}</p>
                                        </div>
                                    </div>
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
                                    @if ($invoice->doktams && $invoice->doktams->count() > 0)
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Document Type</th>
                                                    <th>Document No</th>
                                                    <th>Document Date</th>
                                                    <th>Receive Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoice->doktams as $index => $doktam)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $doktam->doktams_type ?? 'N/A' }}</td>
                                                        <td>{{ $doktam->doktams_no ?? 'N/A' }}</td>
                                                        <td>{{ $doktam->doktams_date ? date('d-M-Y', strtotime($doktam->doktams_date)) : 'N/A' }}
                                                        </td>
                                                        <td>{{ $doktam->receive_date ? date('d-M-Y', strtotime($doktam->receive_date)) : 'N/A' }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format($doktam->doktams_amount, 2) }}</td>
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
                                    @if ($invoice->spis_id && $invoice->spi)
                                        <div class="row">
                                            <!-- Basic SPI Information -->
                                            <div class="col-md-6">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Basic SPI Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <th style="width: 40%">SPI ID</th>
                                                                <td>{{ $invoice->spi->id ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>SPI Number</th>
                                                                <td>{{ $invoice->spi->nomor ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>SPI Date</th>
                                                                <td>{{ $invoice->spi->date ? date('d-M-Y', strtotime($invoice->spi->date)) : 'N/A' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Expedition</th>
                                                                <td>{{ $invoice->spi->expedisi ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Document Send Type</th>
                                                                <td>{{ $invoice->spi->docsend_type ?? 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Project & Department Information -->
                                            <div class="col-md-6">
                                                <div class="card card-success">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Project & Department Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <th style="width: 40%">From Project</th>
                                                                <td>{{ isset($invoice->spi->from_project) ? $invoice->spi->from_project->project_code : 'N/A' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>To Project</th>
                                                                <td>{{ isset($invoice->spi->to_project) ? $invoice->spi->to_project->project_code : 'N/A' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>From Department</th>
                                                                <td>{{ $invoice->spi->from_department ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>To Department</th>
                                                                <td>{{ $invoice->spi->to_department ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>To Person</th>
                                                                <td>{{ $invoice->spi->to_person ?? 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Receipt Information -->
                                            <div class="col-md-12">
                                                <div class="card card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Receipt & Creation Information</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <th style="width: 25%">Received At</th>
                                                                <td>{{ $invoice->spi->received_at ? date('d-M-Y H:i:s', strtotime($invoice->spi->received_at)) : 'Not received yet' }}
                                                                </td>
                                                                <th style="width: 25%">Received By</th>
                                                                <td>{{ $invoice->spi->received_by ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Created By</th>
                                                                <td>{{ $invoice->spi->created_by ?? 'N/A' }}</td>
                                                                <th>Created At</th>
                                                                <td>{{ $invoice->spi->created_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->spi->created_at))) : 'N/A' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Last Updated</th>
                                                                <td colspan="3">
                                                                    {{ $invoice->spi->updated_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->spi->updated_at))) : 'N/A' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            No SPI information found for this invoice.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Follow Up Tab -->
                        <div class="tab-pane fade" id="followup" role="tabpanel" aria-labelledby="followup-tab">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <div class="card-title">Follow Up History</div>
                                </div>
                                <div class="card-body">
                                    @if (method_exists($invoice, 'followups') && $invoice->followups && $invoice->followups->count() > 0)
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Date</th>
                                                    <th>Comment</th>
                                                    <th>Follow Up By</th>
                                                    <th>Contact Person</th>
                                                    <th>Additional Person</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoice->followups as $index => $followup)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $followup->fol_date ? date('d-M-Y', strtotime($followup->fol_date)) : 'N/A' }}
                                                        </td>
                                                        <td>{{ $followup->comment ?? 'No comment' }}</td>
                                                        <td>{{ $followup->fol_by }}</td>
                                                        <td>{{ $followup->fol_contact ?? 'N/A' }}</td>
                                                        <td>{{ $followup->fol_by2 ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-info">
                                            No follow-up records found for this invoice.
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

@section('scripts')
    <script>
        $(function() {
            // Activate first tab by default
            $('#invoiceTab a:first').tab('show');

            // Enable tab navigation
            $('#invoiceTab a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@endsection
