<li class="nav-item">
  <a href="{{ route('doktams.index') }}" class="nav-link {{ request()->is('doktams') || request()->is('doktams/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      Pending Documents
    </p>
  </a>
</li>