<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><b>IRR</b> - Support</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        {{-- <a href="#" class="d-block">{{ Auth()->user()->name }}</a> --}}
        <a href="{{ route('home') }}" class="d-block">{{ Auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        @include('templates.partials.menu.dashboard')

        @include('templates.partials.menu.site')

        @if (Auth()->user()->role == 'ADMINACC' || Auth()->user()->role == 'SUPERADMIN')
          @include('templates.partials.menu.accounting')
          @include('templates.partials.menu.invoices')
          @include('templates.partials.menu.doktams')
          @include('templates.partials.menu.spi')
          @include('templates.partials.menu.reports')
          @include('templates.partials.menu.admin')
        @endif
          
        @if (Auth()->user()->role == 'ADMINFIN' )
          @include('templates.partials.menu.spi')
          @include('templates.partials.menu.accounting')
        @endif

        @if (Auth()->user()->role == 'ADMINLOG' )
          @include('templates.partials.menu.spi')
        @endif
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>