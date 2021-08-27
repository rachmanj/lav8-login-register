<li class="nav-item {{ request()->is('outsdocs/APS') || request()->is('outsdocs/APS/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Project APS
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
      <a href="{{ route('outsdocsAPS.index') }}" class="nav-link {{ request()->is('outsdocs/APS') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Documents</p>
      </a>
    </li>
  </ul>
</li>