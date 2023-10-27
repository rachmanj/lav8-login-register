<li class="nav-item {{ request()->is('logistic') || request()->is('logistic/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('logistic') || request()->is('logistic/*') ? 'active' : '' }}">
      <i class="nav-icon fas fa-folder"></i>
      <p>
        Logistic
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      @if (Auth()->user()->role == 'ADMINLOG' || Auth()->user()->role == 'SUPERADMIN')
      <li class="nav-item">
        <a href="{{ route('logistic.ito-upload.index') }}" class="nav-link {{ request()->is('logistic/ito-upload') || request()->is('logistic/ito-upload/*') ? 'active' : '' }}">
          <i class="far fa-circle nav-icon"></i>
          <p>Upload ITO</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logistic.ito-monitoring.index') }}" class="nav-link {{ request()->is('logistic/ito-monitoring') || request()->is('logistic/ito-monitoring/*') ? 'active' : '' }}">
          <i class="far fa-circle nav-icon"></i>
          <p>ITO Monitoring - HO</p>
        </a>
      </li>
      @endif
      <li class="nav-item">
        <a href="{{ route('logistic.site-monitoring.index') }}" class="nav-link {{ request()->is('logistic/site-monitoring') || request()->is('logistic/site-monitoring/*') ? 'active' : '' }}">
          <i class="far fa-circle nav-icon"></i>
          <p>ITO Monitoring - Site</p>
        </a>
      </li>
    </ul>
  </li>