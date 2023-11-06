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
      <a href="{{ route('spis.logistic.index') }}" class="nav-link {{ request()->is('spis/logistic') || request()->is('spis/logistic/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Send Documents</p>
      </a>
    </li>
    @if (Auth()->user()->role !== 'ADMINLOG')
    <li class="nav-item">
      <a href="{{ route('spis.general.index') }}" class="nav-link {{ request()->is('spis/general') || request()->is('spis/general/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Receive SPI / LPD</p>
      </a>
    </li>
    @endif
  </ul>
</li>