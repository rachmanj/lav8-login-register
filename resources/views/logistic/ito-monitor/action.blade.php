<button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#manual-update-{{ $model->id }}">update</button>

<div class="modal fade" id="manual-update-{{ $model->id }}">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Receive-Back Date ITO No.<b>{{ $model->document_no }}</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('logistic.ito-monitoring.update') }}" method="POST">
                @csrf
            <div class="modal-body">
                <input type="hidden" name="ito_id" value="{{ $model->id }}">
                <div class="form-group">
                    <label>Receive-Back Date</label>
                    {{-- make default value to today --}}
                    <input type="date" name="receiveback_date" value="{{ date('Y-m-d') }}" class="form-control @error('receiveback_date') is-invalid @enderror">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
            </div>
            </form>
        </div>
    </div>
</div>