<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

    <li class="nav-item dropdown">
      <a id="dropdownPayreq" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ auth()->user()->name }} ({{ auth()->user()->project->project_code }})</a>
      <ul aria-labelledby="dropdownPayreq" class="dropdown-menu border-0 shadow">
        <li>
          <a href="{{ route('users.change_password', auth()->user()->id) }}" class="dropdown-item">Change Password</a>
        </li>
        <li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><b>LOGOUT</b></a>
        </li>
      </ul>
    </li>

  </ul>

</nav>