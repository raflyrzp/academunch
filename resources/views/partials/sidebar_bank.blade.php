      <!-- sidebar menu area start -->
      <div class="sidebar-menu">
          <div class="sidebar-header">
              <a href="{{ route('bank.index') }}" class="text-center">
                  <h2 class="text-white text-center" style="font-size: 1.5rem">Academunch</h2>
              </a>
          </div>
          <div class="main-menu">
              <div class="menu-inner">
                  <nav>
                      <ul class="metismenu" id="menu">
                          <li class="{{ $title === 'Dashboard' ? 'active' : '' }}"><a
                                  href="{{ route('bank.index') }}"><i class="ti-dashboard"></i>
                                  <span>Dashboard</span></a></li>
                          <li class="{{ $title === 'Top Up' ? 'active' : '' }}"><a href="{{ route('bank.topup') }}"><i
                                      class="ti-plus"></i> <span>Top Up</span></a></li>
                          <li class="{{ $title === 'Tarik Tunai' ? 'active' : '' }}"><a
                                  href="{{ route('bank.withdrawal') }}"><i class="ti-archive"></i> <span>Tarik
                                      Tunai</span></a>
                          </li>

                          <li class="{{ Str::contains($title, 'Laporan') ? 'active' : '' }}">
                              <a href="javascript:void(0)" aria-expanded="true"><i
                                      class="ti-files"></i><span>Laporan</span></a>
                              <ul class="collapse">
                                  <li><a href="{{ route('bank.laporan.topup') }}">Top Up</a></li>
                                  <li><a href="{{ route('bank.laporan.withdrawal') }}">Tarik Tunai</a></li>
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
