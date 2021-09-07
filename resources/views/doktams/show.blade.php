@extends('templates.main')

@section('title_page')
    Pending Documents
@endsection

@section('breadcrumb_title')
    doktams
@endsection

@section('content')
    <div class="row">

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5>{{ $doktam->doctype->docdesc }} No. {{ $doktam->document_no }} | Inv. {{ $doktam->invoice->inv_no }} | {{ $doktam->invoice->vendor->vendor_name }}</h5>
            <a href="{{ route('doktams.index') }}" class="btn btn-sm btn-primary"> Back</a>
          </div>
          <div class="card-header">
            <div class="col-sm-12">
              <form action="{{ route('doktams.post_comment') }}" method="POST">
                @csrf
                <div class="input-group input-group-sm">
                  <input type="hidden" name="doktams_id" value="{{ $doktam->id }}">
                  <input type="text" class="form-control" name="body" placeholder="enter comment here">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-flat"><i class="far fa-comment-dots"></i></button>
                  </span>
                </div>
              </form>
            </div>
          </div>

          <div class="card-body">
            
            <div class="row">
              <div class="col-12">
                <h4>Comments</h4>
                @foreach ($doktam->comments as $comment)
                <div class="post">
                  <span class="username">
                    from <b class="text-success">{{ $comment->user->name }}</b>
                    {{-- <a href="#">from {{ $comment->user->name }}</a> --}}
                  </span>
                  <span class="description">, sent {{ $comment->created_at->diffForHumans() }}</span>
                  <!-- /.user-block -->
                  <p class="text-primary">
                    {{ $comment->body }}
                  </p>
                </div>
                @endforeach
              </div>
            </div>

          </div>
        </div>
      </div>

      
  </div>
@endsection