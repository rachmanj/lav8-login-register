<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    @if (Auth()->user()->role == 'ADMINACC' || Auth()->user()->role == 'SUPERADMIN')
    <li class="nav-item">
      <a href="{{ route('dashboard.index') }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Dashboard 1</p>
      </a>
    </li>
    @endif
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Dashboard 2</p>
      </a>
    </li>
  </ul>
</li>