<li class="nav-item {{ request()->is('invoices') || request()->is('invoices/*') ||
  request()->is('payments') || request()->is('payments/*') || request()->is('wait-payment') || request()->is('wait-payment/*')
  ? 'menu-open' : '' }}">
  <a href="#" class="nav-link {{ request()->is('invoices') || request()->is('invoices/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Invoices
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->is('invoices') || request()->is('invoices/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Receive Invoice</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('wait-payment.index') }}" class="nav-link {{ request()->is('wait-payment') || request()->is('wait-payment/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Wait Payment</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('payments.index') }}" class="nav-link {{ request()->is('payments') || request()->is('payments/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Payment</p>
      </a>
    </li>
  </ul>
</li>