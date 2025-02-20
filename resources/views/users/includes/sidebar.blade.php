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
          @php
              $user_id = Auth::user()->id;
              // if women : pict women 
              // if men : pict men
          @endphp
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
          <li class="{{ Request::routeIs('index_jn_users') || Request::routeIs('index_client_users') || Request::routeIs('index_jn_2018') || Request::routeIs('index_jn_2019') || Request::routeIs('index_jn_2020') || Request::routeIs('index_jn_2021') || Request::routeIs('index_jn_2022') || Request::routeIs('index_jn_2023') || Request::routeIs('index_jn_2024') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#"  class="{{ Request::routeIs('index_jn_users') || Request::routeIs('index_client_users') || Request::routeIs('index_jn_2018') || Request::routeIs('index_jn_2019') || Request::routeIs('index_jn_2020') || Request::routeIs('index_jn_2021') || Request::routeIs('index_jn_2022') || Request::routeIs('index_jn_2023') || Request::routeIs('index_jn_2024') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Job Number
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('index_client_users') }}" class="{{ Request::routeIs('index_client_users') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('index_jn_users') }}" class="{{ Request::routeIs('index_jn_users') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Job Number List</p>
                </a>
              </li>
              <li class="{{ Request::routeIs('index_jn_2018') || Request::routeIs('index_jn_2019') || Request::routeIs('index_jn_2020') || Request::routeIs('index_jn_2021') || Request::routeIs('index_jn_2022') || Request::routeIs('index_jn_2023') || Request::routeIs('index_jn_2024') ? 'nav-item menu-open' : 'nav-item menu' }}">
                <a href="#" class="{{ Request::routeIs('index_jn_2018') || Request::routeIs('index_jn_2019') || Request::routeIs('index_jn_2020') || Request::routeIs('index_jn_2021') || Request::routeIs('index_jn_2022') || Request::routeIs('index_jn_2023') || Request::routeIs('index_jn_2024') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Old Job Number
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2018') }}" class="{{ Request::routeIs('index_jn_2018') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2018</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2019') }}" class="{{ Request::routeIs('index_jn_2019') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2019</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2020') }}" class="{{ Request::routeIs('index_jn_2020') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2020</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2021') }}" class="{{ Request::routeIs('index_jn_2021') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2021</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2022') }}" class="{{ Request::routeIs('index_jn_2022') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2022</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2023') }}" class="{{ Request::routeIs('index_jn_2023') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2023</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_jn_2024') }}" class="{{ Request::routeIs('index_jn_2024') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>JN 2024</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <li class="{{ Request::routeIs('index_pr_users') || Request::routeIs('create_pr_users') || Request::routeIs('index_old_prpo')|| Request::routeIs('epurchase_report_index')? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#"  class="{{ Request::routeIs('index_pr_users') || Request::routeIs('create_pr_users') || Request::routeIs('index_old_prpo')|| Request::routeIs('epurchase_report_index')? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-shopping-cart"></i>
              <p>
                e-Purchase
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('index_pr_users') }}" class="{{ Request::routeIs('index_pr_users') || Request::routeIs('create_pr_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('epurchase_report_index') }}" class="{{ Request::routeIs('epurchase_report_index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('index_old_prpo') }}" class="{{ Request::routeIs('index_old_prpo') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Old PR PO</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="{{ Request::routeIs('index_atk_users') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('index_atk_users')  ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-pencil-ruler"></i>
              <p>
                ATK
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('index_atk_users') }}" class="{{ Request::routeIs('index_atk_users') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Data</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="{{ Request::routeIs('index_letter_number') || Request::routeIs('index_letter_2018') || Request::routeIs('index_letter_2019') || Request::routeIs('index_letter_2020') || Request::routeIs('index_letter_2021') || Request::routeIs('index_letter_2022') || Request::routeIs('index_letter_2023') || Request::routeIs('index_letter_2024') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#"  class="{{ Request::routeIs('index_letter_number') || Request::routeIs('index_letter_2018') || Request::routeIs('index_letter_2019') || Request::routeIs('index_letter_2020') || Request::routeIs('index_letter_2021') || Request::routeIs('index_letter_2022') || Request::routeIs('index_letter_2023') || Request::routeIs('index_letter_2024') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-envelope-open-text"></i>
              <p>Letter Number</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('index_letter_number') }}" class="{{ Request::routeIs('index_letter_number') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Letter Number List</p>
                </a>
              </li>
              <li class="{{ Request::routeIs('index_letter_2018') || Request::routeIs('index_letter_2019') || Request::routeIs('index_letter_2020') || Request::routeIs('index_letter_2021') || Request::routeIs('index_letter_2022') || Request::routeIs('index_letter_2023') || Request::routeIs('index_letter_2024') ? 'nav-item menu-open' : 'nav-item menu' }}">
                <a href="#"  class="{{ Request::routeIs('index_letter_2018') || Request::routeIs('index_letter_2019') || Request::routeIs('index_letter_2020') || Request::routeIs('index_letter_2021') || Request::routeIs('index_letter_2022') || Request::routeIs('index_letter_2023') || Request::routeIs('index_letter_2024') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Old Letter Number</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2018') }}" class="{{ Request::routeIs('index_letter_2018') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2018</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2019') }}" class="{{ Request::routeIs('index_letter_2019') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2019</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2020') }}" class="{{ Request::routeIs('index_letter_2020') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2020</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2021') }}" class="{{ Request::routeIs('index_letter_2021') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2021</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2022') }}" class="{{ Request::routeIs('index_letter_2022') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2022</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2023') }}" class="{{ Request::routeIs('index_letter_2023') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2023</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('index_letter_2024') }}" class="{{ Request::routeIs('index_letter_2024') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Letter Number 2024</p>
                    </a>
                  </li>
                </ul>
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