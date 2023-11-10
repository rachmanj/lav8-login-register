@extends('templates.main')

@section('title_page')
    Additional Documents
@endsection

@section('breadcrumb_title')
    search
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Search Result</h3>
                <a href="{{ route('additionaldocs.search.index') }}" class="btn btn-sm btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document No</th>
                            <th>Document Type</th>
                            <th>Invoice No</th>
                            <th>PO No</th>
                            <th>Receive Date</th>
                            <th>Creator</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doktams as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->document_no }}</td>
                                <td>{{ $item->doctype->docdesc }}</td>
                                <td>{{ $item->invoice ? $item->invoice->inv_no : '-' }}</td>
                                <td>{{ $item->po_no }}</td>
                                {{-- <td>{{ $item->whereNull('receive_date') ? ' - ' : date('d-M-Y', strtotime($item->receive_date)) }}</td> --}}
                                <td>{{ $item->receive_date == null ? ' - ' : date('d-M-Y', strtotime($item->receive_date)) }}</td>
                                <td>{{ $item->created_by }}</td>
                                <th>
                                    <form action="{{ route('additionaldocs.receive.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                    <button class="btn btn-xs btn-danger" {{ $item->receive_date == null ? '' : 'disabled' }} onclick="return confirm('Are you sure you want to delete this record?')">delete</button>
                                    </form>
                                </th>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection