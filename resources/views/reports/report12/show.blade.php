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
                    <a href="{{ route('reports.report12.index') }}" class="btn btn-sm btn-primary float-right"><i
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
                                                                class="btn btn-sm btn-info" target="_blank">
                                                                <i class="fas fa-eye"></i> View Attachment
                                                            </a>
                                                        @else
                                                            <span class="text-muted">No attachment</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Tab -->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                            <!-- Documents content here -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Additional Documents</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Document Type</th>
                                                <th>Document No</th>
                                                <th>Document Date</th>
                                                <th>Receive Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($invoice->doktams as $index => $doktam)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $doktam->doctype->doctype_name ?? 'N/A' }}</td>
                                                    <td>{{ $doktam->doktams_no }}</td>
                                                    <td>{{ $doktam->doktams_date ? date('d-M-Y', strtotime($doktam->doktams_date)) : 'N/A' }}
                                                    </td>
                                                    <td>{{ $doktam->receive_date ? date('d-M-Y', strtotime($doktam->receive_date)) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $doktam->status == 'RECEIVED' ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $doktam->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No additional documents found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- SPI Tab -->
                        <div class="tab-pane fade" id="spi" role="tabpanel" aria-labelledby="spi-tab">
                            <!-- SPI content here -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">SPI Information</h3>
                                </div>
                                <div class="card-body">
                                    @if ($invoice->spi)
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th style="width: 30%">SPI Number</th>
                                                <td>{{ $invoice->spi->spi_no }}</td>
                                            </tr>
                                            <tr>
                                                <th>SPI Date</th>
                                                <td>{{ $invoice->spi->spi_date ? date('d-M-Y', strtotime($invoice->spi->spi_date)) : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>From Project</th>
                                                <td>{{ $invoice->spi->from_project->project_code ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>To Project</th>
                                                <td>{{ $invoice->spi->to_project->project_code ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span
                                                        class="badge {{ $invoice->spi->status == 'RECEIVED' ? 'badge-success' : 'badge-warning' }}">
                                                        {{ $invoice->spi->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    @else
                                        <div class="alert alert-info">
                                            No SPI information available for this invoice.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Follow Up Tab -->
                        <div class="tab-pane fade" id="followup" role="tabpanel" aria-labelledby="followup-tab">
                            <!-- Follow Up content here -->
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
                                    <button type="button" class="btn btn-sm btn-success float-right"
                                        id="addAttachmentBtn">
                                        <i class="fas fa-plus"></i> Add Attachment
                                    </button>
                                </div>
                                <div class="card-body">
                                    <!-- Upload Form (Hidden by default) -->
                                    <div id="attachmentFormContainer" class="mb-4" style="display: none;">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title" id="attachmentFormTitle">Upload New Attachment</h3>
                                            </div>
                                            <div class="card-body">
                                                <form id="attachmentForm" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" id="attachmentId" name="attachmentId"
                                                        value="">
                                                    <div class="form-group">
                                                        <label for="attachmentFile">File</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="attachmentFile" name="file">
                                                                <label class="custom-file-label"
                                                                    for="attachmentFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="attachmentDescription">Description</label>
                                                        <textarea class="form-control" id="attachmentDescription" name="description" rows="3"
                                                            placeholder="Enter description"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="saveAttachmentBtn">Save</button>
                                                        <button type="button" class="btn btn-default"
                                                            id="cancelAttachmentBtn">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAttachmentModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteAttachmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAttachmentModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this attachment? This action cannot be undone.
                    <p class="mt-2 font-weight-bold" id="deleteAttachmentName"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Add some custom styles for the attachments tab -->
    <style>
        .attachment-row {
            transition: all 0.3s ease;
        }

        .attachment-row:hover {
            background-color: #f8f9fa;
        }
    </style>
    <!-- Bootstrap Custom File Input -->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
@endsection

@section('scripts')
    <!-- Attachment handling scripts -->
    <script>
        $(function() {
            // Initialize variables
            const invoiceId = {{ $invoice->inv_id }};
            let attachments = [];
            let currentAttachment = null;

            // Initialize file input plugin
            if (typeof bsCustomFileInput !== 'undefined') {
                bsCustomFileInput.init();
            } else {
                // Fallback for file input label
                $('#attachmentFile').on('change', function() {
                    const fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').html(fileName || 'Choose file');
                });
            }

            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Define a notification function that uses toastr if available, otherwise falls back to alert
            const notify = {
                success: function(message) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(message);
                    } else {
                        alert('Success: ' + message);
                    }
                },
                error: function(message, title) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message, title);
                    } else {
                        alert('Error: ' + (title ? title + ' - ' : '') + message);
                    }
                }
            };

            // Load attachments when the tab is clicked
            $('#attachments-tab').on('click', function() {
                loadAttachments();
            });

            // Add attachment button click
            $('#addAttachmentBtn').on('click', function() {
                resetAttachmentForm();
                $('#attachmentFormTitle').text('Upload New Attachment');
                $('#attachmentFormContainer').slideDown();
            });

            // Cancel button click
            $('#cancelAttachmentBtn').on('click', function() {
                $('#attachmentFormContainer').slideUp();
                resetAttachmentForm();
            });

            // Handle attachment form submission
            $('#attachmentForm').on('submit', function(e) {
                e.preventDefault();

                const isEdit = $('#attachmentId').val() !== '';
                const formData = new FormData(this);

                // Add CSRF token
                const metaToken = $('meta[name="csrf-token"]').attr('content');
                const formToken = $('input[name="_token"]').val();
                const csrfToken = metaToken || formToken;
                formData.append('_token', csrfToken);

                // If editing and no new file selected, don't include file in request
                if (isEdit && !$('#attachmentFile')[0].files[0]) {
                    formData.delete('file');
                }

                // Show loading state
                $('#saveAttachmentBtn').html('<i class="fas fa-spinner fa-spin"></i> Saving...').prop(
                    'disabled', true);

                // Determine URL based on whether we're creating or updating
                const url = isEdit ?
                    `/attachments/${$('#attachmentId').val()}` :
                    `/invoices/${invoiceId}/attachments`;

                // Determine method based on whether we're creating or updating
                const method = 'POST';

                // If editing, add _method field for Laravel to handle as PUT
                if (isEdit) {
                    formData.append('_method', 'PUT');
                }

                // Ensure we're using the correct field name for the file
                if (!isEdit && $('#attachmentFile')[0].files[0]) {
                    const file = $('#attachmentFile')[0].files[0];
                    // Remove the 'file' field and add 'attachment' field which is what the controller expects
                    formData.delete('file');
                    formData.append('attachment', file);
                }

                // Send AJAX request
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(xhr) {
                        // Also set the X-CSRF-TOKEN header
                        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            notify.success(isEdit ? 'Attachment updated successfully' :
                                'Attachment uploaded successfully');

                            // Hide form and reload attachments
                            $('#attachmentFormContainer').slideUp();
                            resetAttachmentForm();
                            loadAttachments();
                        } else {
                            notify.error(response.message || 'An error occurred');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show detailed error if available
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            notify.error(xhr.responseJSON.message);
                        }
                        // Show validation errors if available
                        else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            let errorMsg = '<ul>';

                            for (const field in errors) {
                                errors[field].forEach(function(error) {
                                    errorMsg += `<li>${error}</li>`;
                                });
                            }

                            errorMsg += '</ul>';
                            notify.error(errorMsg, 'Validation Error');
                        } else {
                            notify.error('An error occurred while saving the attachment');
                        }
                    },
                    complete: function() {
                        // Reset button state
                        $('#saveAttachmentBtn').html('Save').prop('disabled', false);
                    }
                });
            });

            // Handle delete confirmation
            $('#confirmDeleteBtn').on('click', function() {
                if (!currentAttachment) return;

                // Show loading state
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Deleting...').prop('disabled', true);

                // Get CSRF token
                const token = $('meta[name="csrf-token"]').attr('content');
                const formToken = $('input[name="_token"]').val();
                const csrfToken = token || formToken;

                // Send delete request
                $.ajax({
                    url: `/attachments/${currentAttachment.id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: csrfToken
                    },
                    beforeSend: function(xhr) {
                        // Also set the X-CSRF-TOKEN header
                        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            notify.success('Attachment deleted successfully');

                            // Hide modal and reload attachments
                            $('#deleteAttachmentModal').modal('hide');
                            loadAttachments();
                        } else {
                            notify.error(response.message || 'An error occurred');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show detailed error if available
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            notify.error(xhr.responseJSON.message);
                        } else {
                            notify.error('An error occurred while deleting the attachment');
                        }
                    },
                    complete: function() {
                        // Reset button state
                        $('#confirmDeleteBtn').html('Delete').prop('disabled', false);
                    }
                });
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
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info view-attachment" data-id="${attachment.id}" data-filename="${attachment.filename}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary edit-attachment" data-id="${attachment.id}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-attachment" data-id="${attachment.id}" data-filename="${attachment.filename}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
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

                // Attach event handlers to view buttons
                $('.view-attachment').on('click', function() {
                    const attachmentId = $(this).data('id');
                    const filename = $(this).data('filename');
                    viewAttachment(attachmentId, filename);
                });

                // Attach event handlers to edit buttons
                $('.edit-attachment').on('click', function() {
                    const attachmentId = $(this).data('id');
                    editAttachment(attachmentId);
                });

                // Attach event handlers to delete buttons
                $('.delete-attachment').on('click', function() {
                    const attachmentId = $(this).data('id');
                    const filename = $(this).data('filename');
                    showDeleteConfirmation(attachmentId, filename);
                });
            }

            // Function to view an attachment
            function viewAttachment(attachmentId, filename) {
                // Create a modal to view the attachment
                const fileExt = filename.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'].includes(fileExt);
                const isPdf = fileExt === 'pdf';
                const isText = ['txt', 'csv', 'json', 'xml', 'html', 'htm', 'js', 'css', 'md'].includes(fileExt);

                // Create modal HTML based on file type
                let modalContent = '';

                if (isImage) {
                    modalContent = `
                        <div class="text-center">
                            <img src="/attachments/${attachmentId}?view=1" class="img-fluid" alt="${filename}" style="max-height: 80vh;">
                        </div>
                    `;
                } else if (isPdf) {
                    modalContent = `
                        <div class="embed-responsive embed-responsive-16by9" style="height: 80vh;">
                            <iframe class="embed-responsive-item" src="/attachments/${attachmentId}?view=1" allowfullscreen></iframe>
                        </div>
                    `;
                } else if (isText) {
                    modalContent = `
                        <div class="embed-responsive embed-responsive-16by9" style="height: 80vh;">
                            <iframe class="embed-responsive-item" src="/attachments/${attachmentId}?view=1" allowfullscreen></iframe>
                        </div>
                    `;
                } else {
                    // For other file types, provide both view and download options
                    modalContent = `
                        <div class="text-center">
                            <p>This file type may not be viewable in the browser.</p>
                            <div class="btn-group mt-3">
                                <a href="/attachments/${attachmentId}?view=1" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Open in New Tab
                                </a>
                                <a href="/attachments/${attachmentId}?download=1" class="btn btn-secondary">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    `;
                }

                // Create and show the modal
                const modalHtml = `
                    <div class="modal fade" id="viewAttachmentModal" tabindex="-1" role="dialog" aria-labelledby="viewAttachmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewAttachmentModalLabel">${filename}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ${modalContent}
                                </div>
                                <div class="modal-footer">
                                    <a href="/attachments/${attachmentId}?download=1" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Remove any existing modal
                $('#viewAttachmentModal').remove();

                // Add the modal to the page
                $('body').append(modalHtml);

                // Show the modal
                $('#viewAttachmentModal').modal('show');
            }

            // Function to edit an attachment
            function editAttachment(attachmentId) {
                // Find the attachment in the array
                currentAttachment = attachments.find(a => a.id == attachmentId);

                if (!currentAttachment) return;

                // Populate the form
                $('#attachmentId').val(currentAttachment.id);
                $('#attachmentDescription').val(currentAttachment.description || '');
                $('.custom-file-label').text('Choose new file (optional)');

                // Show the form
                $('#attachmentFormTitle').text('Edit Attachment');
                $('#attachmentFormContainer').slideDown();

                // Scroll to the form
                $('html, body').animate({
                    scrollTop: $('#attachmentFormContainer').offset().top - 100
                }, 500);
            }

            // Function to show delete confirmation
            function showDeleteConfirmation(attachmentId, filename) {
                // Find the attachment in the array
                currentAttachment = attachments.find(a => a.id == attachmentId);

                if (!currentAttachment) return;

                // Set the filename in the modal
                $('#deleteAttachmentName').text(filename);

                // Show the modal
                $('#deleteAttachmentModal').modal('show');
            }

            // Function to reset the attachment form
            function resetAttachmentForm() {
                $('#attachmentForm')[0].reset();
                $('#attachmentId').val('');
                $('.custom-file-label').text('Choose file');
                currentAttachment = null;
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
