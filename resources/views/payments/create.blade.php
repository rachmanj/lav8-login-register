@extends('templates.main')

@section('title_page')
    Invoice Payment
@endsection

@section('breadcrumb_title')
    payment
@endsection

@section('content')
    <div class="row">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <a href="{{ route('payment_details.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-undo"></i> Back </a>
            <h3 class="card-title float-right">Create Payment</h3>
          </div> {{-- card-header --}}
          <div class="card-header">
            <h5 class="card-title">Total {{ $jumlah_invoices . ' invoice, Rp. ' . number_format($nominal_invoices, 0) }}</h5>
          </div>

          <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input name="date" type="date" class="form-control @error('date') is-invalid @enderror" id="date" autofocus>
                    @error('date')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="2" class="form-control"></textarea>
                  </div>
                </div>
              </div> 
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
            </div>
        </form>
        </div> {{--  card --}}
      </div>
    </div>
@endsection