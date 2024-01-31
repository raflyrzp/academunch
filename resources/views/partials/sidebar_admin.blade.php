      <!-- sidebar menu area start -->
      <div class="sidebar-menu">
          <div class="sidebar-header">
              <a href="{{ route('admin.index') }}" class="text-center">
                  <h2 class="text-white text-center" style="font-size: 1.5rem">Academunch</h2>
              </a>
          </div>
          <div class="main-menu">
              <div class="menu-inner">
                  <nav>
                      <ul class="metismenu" id="menu">
                          <li class="{{ $title === 'Dashboard' ? 'active' : '' }}"><a
                                  href="{{ route('admin.index') }}"><i class="ti-dashboard"></i>
                                  <span>Dashboard</span></a></li>
                          <li class="{{ $title === 'Data Pengguna' ? 'active' : '' }}"><a
                                  href="{{ route('pengguna.index') }}"><i class="ti-user"></i> <span>Daftar
                                      Pengguna</span></a></li>
                          <li><a href="{{ route('logout') }}"><i class="ti-shift-left-alt"></i> <span>Logout</span></a>
                          </li>

                      </ul>
                  </nav>
              </div>
          </div>
      </div>
      <!-- sidebar menu area end -->
