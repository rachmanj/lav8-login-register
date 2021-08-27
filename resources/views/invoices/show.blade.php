<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pending Docs Info</title>

  <link rel="stylesheet" href="{{ asset('adminlte/fontgoogle.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Invoice Detail</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- the content goes here -->
        
        <div class="row">
          <div class="col-md-10">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Invoice No. {{ $invoice->inv_no }}</h3>
              </div>
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Invoice Date</label>
                    <input class="form-control" value="{{ date('d-M-Y', strtotime($invoice->inv_date)) }}">
                  </div>
                  <div class="form-group">
                    <label>PO No</label>
                    <input class="form-control" value="{{ $invoice->po_no }}">
                  </div>
                  <div class="form-group">
                    <label>Vendor Name</label>
                    <input class="form-control" value="{{ $invoice->vendor->vendor_name }}">
                  </div>
                  <div class="form-group">
                    <label>Project</label>
                    <input class="form-control" value="{{ $invoice->project->project_code }}">
                  </div>
                  <div class="form-group">
                    <label>Amount</label>
                    <input class="form-control" value="Rp. {{ number_format($invoice->inv_nominal, 2) }}">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- the content ends here -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('templates.partials.footer')
</div>


<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>


</body>
</html>