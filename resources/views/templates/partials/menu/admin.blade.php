<li class="nav-item {{ request()->is('admin') || request()->is('admin/*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link {{ request()->is('admin') || request()->is('admin/*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-folder"></i>
    <p>
      ADMIN
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('user.activate_index') }}" class="nav-link {{ request()->is('admin/activate') || request()->is('admin/deactivate') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Activate User</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Edit User Data</p>
      </a>
    </li>
  </ul>
</li>