      <!-- sidebar menu area start -->
      <div class="sidebar-menu">
          <div class="sidebar-header">
              <div class="logo">
                  <a href=""><img src="assets/images/icon/logo.png" alt="logo"></a>
                  {{-- <a href="{{ route('admin.index') }}">Fintech App</a> --}}
              </div>
          </div>
          <div class="main-menu">
              <div class="menu-inner">
                  <nav>
                      <ul class="metismenu" id="menu">
                          <li class="{{ $title === 'Dashboard' ? 'active' : '' }}"><a
                                  href="{{ route('customer.index') }}"><i class="ti-dashboard"></i>
                                  <span>Dashboard</span></a></li>
                          <li class="{{ $title === 'Kantin' ? 'active' : '' }}"><a
                                  href="{{ route('customer.kantin') }}"><i class="ti-home"></i> <span>Kantin</span></a>
                          </li>
                          <li class="{{ $title === 'Keranjang' ? 'active' : '' }}"><a
                                  href="{{ route('customer.keranjang') }}"><i class="ti-shopping-cart"></i>
                                  <span>Keranjang</span></a></li>
                          <li><a href="{{ route('logout') }}"><i class="ti-shift-left-alt"></i> <span>Logout</span></a>
                          </li>

                      </ul>
                  </nav>
              </div>
          </div>
      </div>
      <!-- sidebar menu area end -->
