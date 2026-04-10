<style>
/* ── Header profile trigger ──────────────────────────── */
.hdr-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: linear-gradient(135deg, #434E78 0%, #5a6fa3 100%);
    color: #fff; font-weight: 700; font-size: 15px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; user-select: none; letter-spacing: 0;
    box-shadow: 0 2px 8px rgba(67,78,120,0.28);
}
.hdr-uname {
    display: block; font-size: 13px; font-weight: 600;
    color: #1e2a45; white-space: nowrap;
    max-width: 130px; overflow: hidden; text-overflow: ellipsis;
}
.hdr-urole {
    display: block; font-size: 11px; color: #6b7280;
    font-weight: 400; line-height: 1.2;
}
.hdr-caret {
    font-size: 9px; color: #9ca3af; margin-left: 2px;
    transition: transform 0.2s ease;
}
#headerProfileDropdown > a[aria-expanded="true"] .hdr-caret {
    transform: rotate(180deg);
}

/* ── Force-show all header-right items ───────────────── */
.header .navbar-collapse {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: 100% !important;
    overflow: visible !important;
}
.header .header-right {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    height: 100% !important;
    visibility: visible !important;
    opacity: 1 !important;
    flex-shrink: 0 !important;
}
.header .header-right .nav-item {
    display: flex !important;
    align-items: center !important;
    height: 100% !important;
    visibility: visible !important;
    opacity: 1 !important;
}
.header .header-right .nav-link {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    visibility: visible !important;
    opacity: 1 !important;
}
.header .header-right .notification_dropdown .nav-link i,
.header .header-right .notification_dropdown .nav-link svg {
    visibility: visible !important;
    opacity: 1 !important;
    display: inline-block !important;
}
/* Show theme/fullscreen on all viewports inside the header */
.header .dz-theme-mode,
.header .dz-fullscreen {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* ── Dropdown menu ───────────────────────────────────── */
.hdr-drop-menu {
    min-width: 220px !important;
    border: none !important;
    border-radius: 14px !important;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06) !important;
    padding: 6px !important;
    margin-top: 10px !important;
    overflow: hidden;
}

/* Identity strip */
.hdr-drop-identity {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px 12px;
}
.hdr-drop-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #434E78 0%, #5a6fa3 100%);
    color: #fff; font-weight: 700; font-size: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hdr-drop-name {
    font-size: 13px; font-weight: 700; color: #1e2a45;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;
}
.hdr-drop-role {
    font-size: 11px; color: #6b7280; font-weight: 400; line-height: 1.3;
}

/* Divider */
.hdr-drop-divider {
    height: 1px; background: #f0f2f7; margin: 4px 0;
}

/* Menu items */
.hdr-drop-item {
    display: flex !important; align-items: center; gap: 10px;
    padding: 9px 12px !important; border-radius: 9px !important;
    font-size: 13px !important; font-weight: 500 !important;
    color: #374151 !important; text-decoration: none !important;
    transition: background 0.15s ease, color 0.15s ease !important;
    width: 100%; border: none; background: none; text-align: left; cursor: pointer;
}
.hdr-drop-item:hover { background: #f0f2f9 !important; color: #434E78 !important; }
.hdr-drop-item--logout { color: #ef4444 !important; }
.hdr-drop-item--logout:hover { background: #fff1f1 !important; color: #dc2626 !important; }

/* Icon badge inside items */
.hdr-drop-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; flex-shrink: 0;
}
.hdr-drop-icon--key    { background: #fef3c7; color: #d97706; }
.hdr-drop-icon--logout { background: #fee2e2; color: #ef4444; }
</style>

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="navbar-collapse justify-content-between" style="display:flex;align-items:center;height:100%;">
                <div class="header-left">
                    {{-- <div class="input-group search-area right d-lg-inline-flex d-none">
                        <input type="text" class="form-control" placeholder="Find something here...">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)">
                                    <i class="flaticon-381-search-2"></i>
                                </a>
                            </span>
                        </div>
                    </div> --}}
                </div>
                <ul class="navbar-nav header-right main-notification">
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-theme-mode" href="#">
                            <i id="icon-light" class="fas fa-sun"></i>
                            <i id="icon-dark" class="fas fa-moon"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-fullscreen" href="#">
                            <svg id="icon-full" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                class="css-i6dzq1">
                                <path
                                    d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"
                                    style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path>
                            </svg>
                            <svg id="icon-minimize" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-minimize">
                                <path
                                    d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"
                                    style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item dropdown" id="headerProfileDropdown">
                        {{-- ── Trigger button ── --}}
                        <a class="nav-link d-flex align-items-center" href="#"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false"
                           style="gap:10px; padding:0 0 0 20px; border-left:1px solid #e5e7eb;
                                  margin-left:12px; min-height:56px; text-decoration:none;">

                            {{-- Avatar circle with first-letter initial --}}
                            <div class="hdr-avatar" aria-hidden="true">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            {{-- Name + role (hidden on very small screens) --}}
                            <div class="d-none d-sm-block" style="text-align:left; line-height:1.25;">
                                <span class="hdr-uname">{{ Auth::user()->name }}</span>
                                <small class="hdr-urole">
                                    {{ Auth::user()->getRoleNames()->implode(', ') }}
                                </small>
                            </div>

                            <i class="fas fa-chevron-down d-none d-sm-inline-block hdr-caret"></i>
                        </a>

                        {{-- ── Dropdown menu ── --}}
                        <div class="dropdown-menu dropdown-menu-end hdr-drop-menu">

                            {{-- Identity strip --}}
                            <div class="hdr-drop-identity">
                                <div class="hdr-drop-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="hdr-drop-name">{{ Auth::user()->name }}</div>
                                    <div class="hdr-drop-role">
                                        {{ Auth::user()->getRoleNames()->implode(', ') }}
                                    </div>
                                </div>
                            </div>

                            <div class="hdr-drop-divider"></div>

                            {{-- Change password --}}
                            <a href="#" class="hdr-drop-item"
                               data-bs-toggle="modal" data-bs-target="#changePassword">
                                <span class="hdr-drop-icon hdr-drop-icon--key">
                                    <i class="fas fa-key"></i>
                                </span>
                                Ubah Kata Sandi
                            </a>

                            <div class="hdr-drop-divider"></div>

                            {{-- Logout --}}
                            {!! Form::open(['method' => 'post', 'route' => 'logout']) !!}
                            <button type="submit" class="hdr-drop-item hdr-drop-item--logout">
                                <span class="hdr-drop-icon hdr-drop-icon--logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                Keluar
                            </button>
                            {!! Form::close() !!}

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="sub-header">
            <div class="d-flex align-items-center flex-wrap me-auto">
                <h5 class="dashboard_bar">
                    @yield('title', $page_title ?? '')
                </h5>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Kata Sandi</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open([
                    'method' => 'POST',
                    'route' => 'change_password',
                    'id' => 'formChangePassword',
                ]) !!}
                <div class="form-group">
                    <label for="currentPassword">Kata sandi lama</label>
                    <div class="input-group">
                        <input type="password" class="form-control password-field" id="currentPassword"
                            name="current_password" required>
                        <button type="button" class="btn btn-outline-info toggle-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPassword">Kata sandi baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control password-field" id="newPassword"
                            name="new_password" required>
                        <button type="button" class="btn btn-outline-info toggle-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPasswordConfirmation">Kata sandi baru konfirmasi</label>
                    <div class="input-group">
                        <input type="password" class="form-control password-field" id="newPasswordConfirmation"
                            name="new_password_confirmation" required>
                        <button type="button" class="btn btn-outline-info toggle-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-primary mt-3" id="saveChangePassword">Simpan</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/system/change_password.js')}}"></script>

<!--**********************************
    Header end ti-comment-alt
***********************************-->
