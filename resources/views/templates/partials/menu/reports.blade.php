<li class="nav-item {{ request()->is('reports') || request()->is('reports/*') ? 'menu-open' : '' }}">
  <a href="{{ route('reports.index') }}" class="nav-link {{ request()->is('reports') || request()->is('reports/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Reports
    </p>
  </a>
</li>