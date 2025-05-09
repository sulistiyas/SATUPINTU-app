<!-- Main Sidebar Container -->
  <aside class="main-sidebar main-sidebar-custom sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('assets/dist/img/INL_Logo_Only.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SATUPINTU - APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/dist/img/avatar4.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="{{ Request::routeIs('index_jn_admin') || Request::routeIs('index_client_admin') || Request::routeIs('index_jn_old_admin') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#"  class="{{ Request::routeIs('index_jn_admin') || Request::routeIs('index_client_admin') || Request::routeIs('index_jn_old_admin') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Job Number
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('index_client_admin') }}" class="{{ Request::routeIs('index_client_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('index_jn_admin') }}" class="{{ Request::routeIs('index_jn_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Job Number List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('index_jn_old_admin') }}" class="{{ Request::routeIs('index_jn_old_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Old Job Number</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="{{ Request::routeIs('index_pr_admin') || Request::routeIs('index_po_admin') || Request::routeIs('index_vendor_admin') || Request::routeIs('create_pr_admin') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#"  class="{{ Request::routeIs('index_pr_admin') || Request::routeIs('index_po_admin') || Request::routeIs('index_vendor_admin') || Request::routeIs('create_pr_admin') ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-shopping-cart"></i>
              <p>
                e-Purchase
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('index_pr_admin') }}" class="{{ Request::routeIs('index_pr_admin') || Request::routeIs('create_pr_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('index_po_admin') }}" class="{{ Request::routeIs('index_po_admin') || Request::routeIs('create_po_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('index_vendor_admin') }}" class="{{ Request::routeIs('index_vendor_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor</p>
                </a>
              </li>
            </ul>
          </li>
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <div class="sidebar-custom">
      <form method="POST" action="{{ route('logout') }}" x-data>
        @csrf
        <button type="submit" class="btn btn-default"><i class="fas fa-power-off"></i></button>
        <a href="{{ url('https://wa.me/+6282110873602') }}" class="btn btn-secondary hide-on-collapse pos-right" target="_blank">Contact Support</a>
      </form>
      {{-- <a href="{{ route('logout') }}" class="btn btn-link"><i class="fas fa-cogs"></i></a> --}}
      
    </div>
  </aside>