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
                        <li class="nav-item">
                            <a class="nav-link" id="followup-tab" data-toggle="tab" href="#followup" role="tab"
                                aria-controls="followup" aria-selected="false">Follow Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="attachments-tab" data-toggle="tab" href="#attachments" role="tab"
                                aria-controls="attachments" aria-selected="false">Attachments</a>
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
                                                    <td>{{ date('d-M-Y', strtotime($invoice->inv_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Invoice Type</th>
                                                    <td>{{ $invoice->invtype->invtype_name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>PO Number</th>
                                                    <td>{{ $invoice->po_no ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <span
                                                            class="badge {{ $invoice->inv_status == 'PAID' ? 'badge-success' : ($invoice->inv_status == 'PENDING' ? 'badge-warning' : 'badge-info') }}">
                                                            {{ $invoice->inv_status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Sent Status</th>
                                                    <td>{{ $invoice->sent_status }}</td>
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
                                                    <th style="width: 40%">Currency</th>
                                                    <td>{{ $invoice->inv_currency }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Amount</th>
                                                    <td class="text-right font-weight-bold">
                                                        {{ number_format($invoice->inv_nominal, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>VAT</th>
                                                    <td class="text-right">{{ number_format($invoice->vat, 2) }}</td>
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
                                                <tr>
                                                    <th>Payment Place</th>
                                                    <td>{{ $invoice->payment_place }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Attachment</th>
                                                    <td>
                                                        @if ($invoice->filename)
                                                            <a href="{{ asset('document_upload/' . $invoice->filename) }}"
                                                                class="btn btn-sm btn-info" target="_blank">View
                                                                Attachment</a>
                                                        @else
                                                            <span class="text-muted">No attachment</span>
                                                        @endif
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
                                                    <td>{{ $invoice->vendorbranch->branch ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Project</th>
                                                    <td>{{ $invoice->project->project_code ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Project Owner</th>
                                                    <td>{{ $invoice->project->project_owner ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Project Location</th>
                                                    <td>{{ $invoice->project->project_location ?? 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Processing Timeline -->
                                <div class="col-md-6">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Processing Timeline</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th style="width: 40%">Receive Date</th>
                                                    <td>{{ date('d-M-Y', strtotime($invoice->receive_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Receive Place</th>
                                                    <td>{{ $invoice->receive_place }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Verification Date</th>
                                                    <td>{{ $invoice->to_verify_date ? date('d-M-Y', strtotime($invoice->to_verify_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jakarta Mailroom Date</th>
                                                    <td>{{ $invoice->mailroom_jkt_date ? date('d-M-Y', strtotime($invoice->mailroom_jkt_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Forward to Finance Date</th>
                                                    <td>{{ $invoice->invjkt_fwdtofin_date ? date('d-M-Y', strtotime($invoice->invjkt_fwdtofin_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>SPI Jakarta Date</th>
                                                    <td>{{ $invoice->spi_jkt_date ? date('d-M-Y', strtotime($invoice->spi_jkt_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>SPI Balikpapan Date</th>
                                                    <td>{{ $invoice->spi_bpn_date ? date('d-M-Y', strtotime($invoice->spi_bpn_date)) : 'N/A' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="col-md-12">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">Additional Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered table-striped">
                                                        <tr>
                                                            <th style="width: 40%">Remarks</th>
                                                            <td>{{ $invoice->remarks ?? 'No remarks' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created By</th>
                                                            <td>{{ $invoice->creator }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Created At</th>
                                                            <td>{{ $invoice->created_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->created_at))) : 'N/A' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Last Updated</th>
                                                            <td>{{ $invoice->updated_at ? date('d-M-Y H:i:s', strtotime('+7 hour', strtotime($invoice->updated_at))) : 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="timeline">
                                                        <div class="time-label">
                                                            <span class="bg-primary">Invoice Timeline</span>
                                                        </div>

                                                        @if ($invoice->receive_date)
                                                            <div>
                                                                <i class="fas fa-inbox bg-blue"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ date('d-M-Y', strtotime($invoice->receive_date)) }}</span>
                                                                    <h3 class="timeline-header">Invoice Received</h3>
                                                                    <div class="timeline-body">
                                                                        Invoice received at {{ $invoice->receive_place }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($invoice->to_verify_date)
                                                            <div>
                                                                <i class="fas fa-check bg-green"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ date('d-M-Y', strtotime($invoice->to_verify_date)) }}</span>
                                                                    <h3 class="timeline-header">Invoice Verified</h3>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($invoice->mailroom_jkt_date)
                                                            <div>
                                                                <i class="fas fa-paper-plane bg-yellow"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ date('d-M-Y', strtotime($invoice->mailroom_jkt_date)) }}</span>
                                                                    <h3 class="timeline-header">Received at Jakarta
                                                                        Mailroom</h3>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($invoice->mailroom_bpn_date)
                                                            <div>
                                                                <i class="fas fa-file-invoice bg-purple"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ date('d-M-Y', strtotime($invoice->mailroom_bpn_date)) }}</span>
                                                                    <h3 class="timeline-header">SPI Created</h3>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($invoice->payment_date)
                                                            <div>
                                                                <i class="fas fa-money-bill-wave bg-success"></i>
                                                                <div class="timeline-item">
                                                                    <span class="time"><i class="fas fa-clock"></i>
                                                                        {{ date('d-M-Y', strtotime($invoice->payment_date)) }}</span>
                                                                    <h3 class="timeline-header">Invoice Paid</h3>
                                                                    <div class="timeline-body">
                                                                        Payment completed
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div>
                                                            <i class="fas fa-clock bg-gray"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                                <td>{{ $invoice->spi->from_project->project_code ?? 'N/A' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>To Project</th>
                                                                <td>{{ $invoice->spi->to_project->project_code ?? 'N/A' }}
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
                                                                <td>{{ $invoice->spi->created_by }}</td>
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Follow Up History</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Person</th>
                                                <th>Notes</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($invoice->followups) && count($invoice->followups) > 0)
                                                @foreach ($invoice->followups as $index => $followup)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ date('d-M-Y', strtotime($followup->followup_date)) }}</td>
                                                        <td>{{ $followup->person }}</td>
                                                        <td>{{ $followup->notes }}</td>
                                                        <td>{{ $followup->created_by }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No follow-up records found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments Tab -->
                        <div class="tab-pane fade" id="attachments" role="tabpanel" aria-labelledby="attachments-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Invoice Attachments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="attachmentsTable">
                                            <thead>
                                                <tr>
                                                    <th>Filename</th>
                                                    <th>Description</th>
                                                    <th>Size</th>
                                                    <th>Uploaded By</th>
                                                    <th>Upload Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="attachmentsList">
                                                <!-- Attachments will be loaded here via AJAX -->
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        <i class="fas fa-spinner fa-spin"></i> Loading attachments...
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
    <!-- Timeline styles -->
    <style>
        .timeline {
            position: relative;
            margin: 0 0 30px 0;
            padding: 0;
            list-style: none;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 31px;
            margin: 0;
            border-radius: 2px;
        }

        .timeline>div {
            position: relative;
            margin-right: 10px;
            margin-bottom: 15px;
        }

        .timeline>div>.timeline-item {
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            margin-top: 0;
            background: #fff;
            color: #444;
            margin-left: 60px;
            margin-right: 15px;
            padding: 0;
            position: relative;
        }

        .timeline>div>.fa,
        .timeline>div>.fas,
        .timeline>div>.far,
        .timeline>div>.fab,
        .timeline>div>.glyphicon,
        .timeline>div>.ion {
            width: 30px;
            height: 30px;
            font-size: 15px;
            line-height: 30px;
            position: absolute;
            color: #fff;
            background: #d2d6de;
            border-radius: 50%;
            text-align: center;
            left: 18px;
            top: 0;
        }

        .timeline>.time-label>span {
            font-weight: 600;
            padding: 5px;
            display: inline-block;
            background-color: #fff;
            border-radius: 4px;
            color: #fff;
        }

        .timeline-item>.time {
            color: #999;
            float: right;
            padding: 10px;
            font-size: 12px;
        }

        .timeline-item>.timeline-header {
            margin: 0;
            color: #555;
            border-bottom: 1px solid #f4f4f4;
            padding: 10px;
            font-size: 16px;
            line-height: 1.1;
        }

        .timeline-item>.timeline-body {
            padding: 10px;
        }

        /* Add some custom styles for the attachments tab */
        .attachment-row {
            transition: all 0.3s ease;
        }

        .attachment-row:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Activate the first tab by default
            $('#invoiceTab a:first').tab('show');
        });
    </script>

    <!-- Attachment handling scripts -->
    <script>
        $(function() {
            // Initialize variables
            const invoiceId = {{ $invoice->inv_id }};
            let attachments = [];

            // Load attachments when the tab is clicked
            $('#attachments-tab').on('click', function() {
                loadAttachments();
            });

            // Function to load attachments
            function loadAttachments() {
                $.ajax({
                    url: `/invoices/${invoiceId}/attachments`,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#attachmentsList').html(
                            '<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading attachments...</td></tr>'
                        );
                    },
                    success: function(response) {
                        if (response.success) {
                            attachments = response.data;
                            renderAttachments();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading attachments:', xhr);
                        $('#attachmentsList').html(
                            '<tr><td colspan="6" class="text-center text-danger">Error loading attachments. Please try again.</td></tr>'
                        );
                    }
                });
            }

            // Function to render attachments
            function renderAttachments() {
                let html = '';

                if (attachments.length === 0) {
                    html = '<tr><td colspan="6" class="text-center">No attachments found</td></tr>';
                } else {
                    attachments.forEach(function(attachment, index) {
                        html += `
                            <tr id="attachment-${attachment.id}" class="attachment-row">
                                <td>${attachment.filename}</td>
                                <td>${attachment.description || '-'}</td>
                                <td>${formatFileSize(attachment.filesize)}</td>
                                <td>${attachment.uploaded_by || 'System'}</td>
                                <td>${formatDate(attachment.created_at)}</td>
                                <td>
                                    <a href="/attachments/${attachment.id}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#attachmentsList').html(html);


                // Apply animation to the rows
                $('.attachment-row').each(function(index) {
                    $(this).css('opacity', 0);
                    $(this).animate({
                        opacity: 1
                    }, 300 * (index + 1));
                });
            }

            // Format file size
            function formatFileSize(bytes) {
                if (!bytes) return '0 Bytes';

                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Format date
            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
            }

            // Load attachments when the page loads if the attachments tab is active
            if (window.location.hash === '#attachments') {
                $('#attachments-tab').tab('show');
                loadAttachments();
            }
        });
    </script>
@endsection
