<li class="nav-item {{ request()->is('additionaldocs') || request()->is('additionaldocs/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link {{ request()->is('additionaldocs') || request()->is('additionaldocs/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Additional Documents
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('additionaldocs.index') }}" class="nav-link {{ request()->is('additionaldocs') || request()->is('additionaldocs/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Receive Document</p>
      </a>
    </li>
  </ul>
</li>