      <!-- sidebar menu area start -->
      <div class="sidebar-menu">
          <div class="sidebar-header">
              <a href="{{ route('siswa.index') }}" class="text-center">
                  <h2 class="text-white text-center" style="font-size: 1.5rem">Academunch</h2>
              </a>
          </div>
          <div class="main-menu">
              <div class="menu-inner">
                  <nav>
                      <ul class="metismenu" id="menu">
                          <li class="{{ $title === 'Dashboard' ? 'active' : '' }}"><a
                                  href="{{ route('siswa.index') }}"><i class="ti-dashboard"></i>
                                  <span>Dashboard</span></a></li>
                          <li class="{{ $title === 'Kantin' ? 'active' : '' }}"><a href="{{ route('siswa.kantin') }}"><i
                                      class="ti-home"></i> <span>Kantin</span></a>
                          </li>
                          <li class="{{ $title === 'Keranjang' ? 'active' : '' }}"><a
                                  href="{{ route('siswa.keranjang') }}"><i class="ti-shopping-cart"></i>
                                  <span>Keranjang</span></a></li>
                          <li class="{{ Str::contains($title, 'Riwayat') ? 'active' : '' }}">
                              <a href="javascript:void(0)" aria-expanded="true"><i
                                      class="ti-files"></i><span>Riwayat</span></a>
                              <ul class="collapse">
                                  <li><a href="{{ route('siswa.riwayat.transaksi') }}">Transaksi</a></li>
                                  <li><a href="{{ route('siswa.riwayat.topup') }}">Top Up</a></li>
                                  <li><a href="{{ route('siswa.riwayat.withdrawal') }}">Tarik Tunai</a></li>
                              </ul>
                          </li>
                          <li><a href="{{ route('logout') }}"><i class="ti-shift-left-alt"></i> <span>Logout</span></a>
                          </li>
                      </ul>
                  </nav>
              </div>
          </div>
      </div>
      <!-- sidebar menu area end -->
