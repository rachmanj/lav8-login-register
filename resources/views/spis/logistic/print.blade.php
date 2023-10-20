<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IRR - Support-LPD Print</title>

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
            <td rowspan="2"><h3><b>Lembar Pengiriman Dokumen / LPD</b></h3>
              <h4> Nomor: {{ $spi->nomor }} </h4>
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
          <strong>{{ $spi->to_project->project_code }}</strong><br>
          {{ $spi->to_project->project_location }}
          <p>up. {{ $spi->to_person ? $spi->to_person : '' }}</p> 
        </address>
      </div>
      <div class="col-6">
        <p><h5>Date: {{ date('d-M-Y', strtotime($spi->date)) }}</h5></p>  
        <p>Expedisi: {{ $spi->expedisi ? $spi->expedisi : '' }} </p>  
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>DOC NO</th>
              <th>DOC TYPE</th>>
              <th>PO NO</th>
              <th>PROJECT</th>
              <th>VENDOR</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($spi->doktams as $doktam)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $doktam->document_no }}</td>
              <td>{{ $doktam->doctype->docdesc }}</td>
              <td>
                @if ($doktam->doktams_po_no)
                  {{ $doktam->doktams_po_no }}
                @elseif ($doktam->invoice)
                    {{ $doktam->invoice->po_no }}
                @endif 
              </td>
              <td>
                @if ($doktam->project_id)
                    {{ $doktam->project->project_code }}
                @elseif ($doktam->invoice)
                    {{ $doktam->invoice->project->project_code }}
                @endif
              </td>
              <td>
              @if ($doktam->invoice)
                  {{ $doktam->invoice->vendor->vendor_name }}
              @endif
              </td>
            </tr>
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
            <th>Prepared by / Logistic</th>
            <th>Received by / Accounting</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
          <tr>
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
