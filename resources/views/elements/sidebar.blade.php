<!--**********************************
 Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            {{-- <div class="image-bx">
                <img src="{{ asset('images/Untitled-1.jpg') }}" alt="">
                <a href="javascript:void(0);"><i class="fa fa-user" aria-hidden="true"></i></a>
            </div> --}}
            <h5 class="name"><span class="font-w400">Hello, {{ Auth::user()->name }}</span> </h5>
            <p class="email">{{ Auth::user()->email }}</p>
        </div>
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
                <a class="ai-icon" href="{{route('home')}}" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a href="#1" class="ai-icon" aria-expanded="false" data-bs-toggle="modal"
                    data-bs-target=".pelayanan">
                    <i class="glyph-icon flaticon-381-archive"></i>
                    <span class="nav-text">Pelayanan</span>
                </a>
            </li>
            <li><a href="#2" class="ai-icon" aria-expanded="false" data-bs-toggle="modal"
                    data-bs-target=".agregat-dkb">
                    <i class="glyph-icon flaticon-381-database"></i>
                    <span class="nav-text">Agregat DKB</span>
                </a>
            </li>
            <li><a href="#3" class="ai-icon" aria-expanded="false" data-bs-toggle="modal"
                    data-bs-target=".kepemilikan-dkb">
                    <i class="glyph-icon flaticon-381-bookmark-1"></i>
                    <span class="nav-text">Kepemilikan</span>
                </a>
            </li>
            <li><a href="#5" class="ai-icon" aria-expanded="false" data-bs-toggle="modal"
                    data-bs-target=".umur-dkb">
                    <i class="glyph-icon flaticon-381-user-8"></i>
                    <span class="nav-text">Struktur Umur</span>
                </a>
            </li>
            <li>
                <a href="#4" class="ai-icon" aria-expanded="false" data-bs-toggle="modal"
                    data-bs-target=".kelompok-umur-dkb">
                    <i class="glyph-icon flaticon-152-followers"></i>
                    <span class="nav-text">Statistik Kelompok Umur</span>
                </a>
            </li>
            {{-- @can('web_service') --}}
            <li class="nav-label">Web Service</li>
            <li><a href="#6" class="ai-icon" aria-expanded="false">
                    <i class="glyph-icon flaticon-381-internet"></i>
                    <span class="nav-text">API</span>
                </a>
            </li>
            {{-- @endcan --}}
            {{-- @can('import_data') --}}
                <li class="nav-label">Import</li>
                <li><a href="{{ route('import_data_excel') }}" class="ai-icon" aria-expanded="false">
                        <i class="fa fa-file-excel"></i>
                        <span class="nav-text">Import Excel</span>
                    </a>
                </li>
            {{-- @endcan --}}
            {{-- @can('pengaturan') --}}
                <li class="nav-label">Konfigurasi</li>
                <li><a href="#7" class="ai-icon" aria-expanded="false" data-bs-toggle="modal"
                        data-bs-target=".pengaturan-dkb">
                        <i class="glyph-icon flaticon-381-settings-7"></i>
                        <span class="nav-text">Pengaturan</span>
                    </a>
                </li>
            {{-- @endcan --}}
        </ul>
    </div>
</div>
<!--**********************************
 Sidebar end
***********************************-->
