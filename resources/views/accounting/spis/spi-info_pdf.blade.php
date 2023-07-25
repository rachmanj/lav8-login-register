<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IRR - Support-SPI Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  
    <div class="row">
    <div class="card col-5">
        <div class="card-body">
            {{-- <div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-default ribbon text-lg">
                  Attention!
                </div>
            </div> --}}
   
                <!-- accepted payments column -->
                    <h3>Attention!</h3>
                    
                    <p><small>
                    Please check contents immediately after receiving and do updates to IRR System.
                    <br>
                    This envelope contains invoices :
                    </small></p>
                    <ol>
                        @foreach ($spi->invoices as $invoice)
                        <small><li>No. {{ $invoice->inv_no }}, {{ $invoice->vendor->vendor_name }}</li></small>
                        @endforeach
                    </ol>
            </div>
                <!-- /.row -->
        </div>
    </div>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
