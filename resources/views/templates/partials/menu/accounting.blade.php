<li class="nav-item {{ request()->is('accounting') || request()->is('accounting/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link {{ request()->is('accounting') || request()->is('accounting/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Accounting
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('dashboard.index1') }}" class="nav-link {{ request()->is('accounting/dashboard') || request()->is('accounting/dashboard/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Dashboard</p>
      </a>
    </li>
    {{-- @if (Auth()->user()->role == 'SUPERADMIN')
    <li class="nav-item">
      <a href="{{ route('accounting.outdocs_index') }}" class="nav-link {{ request()->is('accounting/addocs') || request()->is('accounting/addocs/edit') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Pending Docs</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('accounting.invoices') }}" class="nav-link {{ request()->is('accounting/invoices') || request()->is('accounting/invoices/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>IRR5 - Invoices</p>
      </a>
    </li>
    @endif --}}
    <li class="nav-item">
      <a href="{{ route('accounting.doktam_invoices.index') }}" class="nav-link {{ request()->is('accounting/doktams/invoices') || request()->is('accounting/doktams/invoices/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>IRR Support - Invoices</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('sent_index') }}" class="nav-link {{ request()->is('accounting/sent') || request()->is('accounting/sent/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Send Invoice</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('accounting.spi_index') }}" class="nav-link {{ request()->is('accounting/spis') || request()->is('accounting/spis/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>SPI List</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('accounting.lpd.index') }}" class="nav-link {{ request()->is('accounting/lpds') || request()->is('accounting/lpds/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>LPD List</p>
      </a>
    </li>
  </ul>
</li>