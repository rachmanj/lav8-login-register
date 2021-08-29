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
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Dashboard</p>
      </a>
    </li>
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
    <li class="nav-item">
      <a href="{{ route('accounting.doktam_invoices.index') }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>IRR Support - Invoices</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('accounting.invoices') }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Send Invoice</p>
      </a>
    </li>
  </ul>
</li>