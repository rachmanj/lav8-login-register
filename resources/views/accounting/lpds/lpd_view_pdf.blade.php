<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IRR - Support-PDF Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <table class="table">
          <tr>
            <td rowspan="2"><h4>PT Arkananta Apta Pratista</h4></td>
            <td rowspan="2"><h3><b>List Pengiriman Dokumen</b></h3>
              <h4> Nomor: {{ $lpd->nomor }} </h4>
            </td>
            <td class="text-">ARKA/ACC/IV/01.01</td>
          </tr>
          <tr>
            <td>20-Aug-2014</td>
          </tr>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row">
      <div class="col-5">
        Kepada
        <address>
          <strong>PT Arkananta Apta Pratista</strong> <br>
          <strong>{{ $lpd->to_project->project_code }}</strong><br>
          {{ $lpd->to_project->project_location }}
          <p>up. {{ $lpd->to_person ? $lpd->to_person : '' }}</p> 
        </address>
      </div>
      <div class="col-6">
        <p><h5>Date: {{ date('d-M-Y', strtotime($lpd->date)) }}</h5></p>  
        <p>Expedisi: {{ $lpd->expedisi ? $lpd->expedisi : '' }} </p>  
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>NO</th>
              <th>INVOICE NO.</th>
              <th>INVOICE DATE</th>
              <th class="text-center">AMOUNT</th>
              <th>VENDOR</th>
              <th>PO NO</th>
              <th>PROJECT</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lpd->invoices as $invoice)
                <tr>
                  <th>{{ $loop->iteration }}</th>
                  <th>{{ $invoice->inv_no }}</th>
                  <th>{{ date('d-M-Y', strtotime($invoice->inv_date)) }}</th>
                  <th class="text-right">{{ $invoice->inv_currency }}  {{ number_format($invoice->inv_nominal, 0) }}</th>
                  <th>{{ $invoice->vendor->vendor_name }}</th>
                  <th>{{ $invoice->po_no }}</th>
                  <th>{{ $invoice->project->project_code }}</th>
                </tr>
                  @if ($invoice->doktams->count() > 0)
                    <thead>
                      <tr>
                        <th colspan="2" class="text-right">Additional Docs:</th>
                        <th>Document Type</th>
                        <th colspan="2">Dokumen No</th>
                      </tr>
                    </thead>
                      <tbody>
                        @foreach ($invoice->doktams as $doktam)
                          <tr>
                            <td colspan="2"></td>
                            <td>{{ $doktam->doctype->docdesc }}</td>
                            <td colspan="2">{{ $doktam->document_no }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  @endif
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-12">
        <table class="table">
          <tr>
            <th>Prepared by</th>
            <th>Acknowledge</th>
            <th>Received by</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>(____________________________________)</td>
            <td>(____________________________________)</td>
            <td>(____________________________________)</td>
          </tr>
        </table>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>