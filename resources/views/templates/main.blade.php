<!DOCTYPE html>

<html lang="en">
<head>
  
  @include('templates.partials.head')

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
    @include('templates.partials.navbar')
  <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('templates.partials.sidebar')
    <!-- End Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- start breadcrumb -->
    @include('templates.partials.breadcrumb')
    <!-- end breadcrumb -->
    
    <!-- Main content -->
    <div class="content">

      <div class="container-fluid">

        @yield('content')
        
      </div><!-- /.container-fluid -->

    </div>  <!-- /.content -->


  </div>  <!-- /.content-wrapper -->
  
  
  <!-- start footer -->
    @include('templates.partials.footer')
  <!-- /.end footer -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('templates.partials.script')

</body>
</html>
