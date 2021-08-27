<li class="nav-item {{ request()->is('outsdocs/017') || request()->is('outsdocs/017/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Project 017C
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
      <a href="{{ route('outsdocs017.index') }}" class="nav-link {{ request()->is('outsdocs/017') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Documents</p>
      </a>
    </li>
  </ul>
</li>