<li class="nav-item {{ request()->is('spis') || request()->is('spis/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link {{ request()->is('spis') || request()->is('spis/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      SPI
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('spis.create.index') }}" class="nav-link {{ request()->is('spis') || request()->is('spis/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Receive SPI / LPD</p>
      </a>
    </li>
    {{-- <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>List</p>
      </a>
    </li> --}}
  </ul>
</li>