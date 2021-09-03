<li class="nav-item {{ request()->is('outsdocs/011') || request()->is('outsdocs/011/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Project 011C
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
      <a href="{{ route('outsdocs011.index') }}" class="nav-link {{ request()->is('outsdocs/011') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Documents</p>
      </a>
    </li>
  </ul>
</li>