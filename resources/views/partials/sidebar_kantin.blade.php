      <!-- sidebar menu area start -->
      <div class="sidebar-menu">
          <div class="sidebar-header">
              <a href="{{ route('kantin.index') }}" class="text-center">
                  <h2 class="text-white text-center" style="font-size: 1.5rem">Academunch</h2>
              </a>
          </div>
          <div class="main-menu">
              <div class="menu-inner">
                  <nav>
                      <ul class="metismenu" id="menu">
                          <li class="{{ $title === 'Dashboard' ? 'active' : '' }}"><a
                                  href="{{ route('kantin.index') }}"><i class="ti-dashboard"></i>
                                  <span>Dashboard</span></a></li>
                          <li class="{{ $title === 'Data Kategori' ? 'active' : '' }}"><a
                                  href="{{ route('kategori.index') }}"><i class="ti-layout-grid2-alt"></i> <span>Data
                                      Kategori</span></a></li>
                          <li class="{{ $title === 'Data Produk' ? 'active' : '' }}"><a
                                  href="{{ route('produk.index') }}"><i class="ti-package"></i> <span>Data
                                      Produk</span></a></li>
                          <li
                              class="{{ $title === 'Laporan Transaksi Harian' || $title === 'Laporan Transaksi' ? 'active' : '' }}">
                              <a href="{{ route('kantin.laporan') }}"><i class="ti-files"></i>
                                  <span>Laporan</span></a>
                          </li>
                          <li><a href="{{ route('logout') }}"><i class="ti-shift-left-alt"></i> <span>Logout</span></a>
                          </li>

                      </ul>
                  </nav>
              </div>
          </div>
      </div>
      <!-- sidebar menu area end -->
