<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rumah Data 2.0 Kota Samarinda - Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/login-slider.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
</head>

<body class="vh-100">
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <!-- Animated Slider Background -->
    <div class="tp-slider-area">
        <div class="tp-slider-wrapper p-relative">
            <!-- Slider Arrow Box -->
            <div class="tp-slider-arrow-box">
                <button class="slider-prev">←</button>
                <button class="slider-next">→</button>
            </div>
            
            <!-- Decorative Shapes -->
            <div class="slider-shapes">
                <div class="shape-circle shape-1"></div>
                <div class="shape-circle shape-2"></div>
                <img src="{{ asset('images/slider/pesut-shape.png') }}" alt="" class="shape-dolphins" style="position: absolute; left: -10px; top: 50%; transform: translateY(-50%); width: 650px; height: 1700px; opacity: 0.45; z-index: 2;">
                <svg class="shape-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path fill="white" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>

            <!-- Weather Card (KSAplay inspired) -->
            <div class="wx-card">
                <div class="wx-top">
                    <div class="wx-location">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        Samarinda, Kaltim
                    </div>
                    <div class="wx-date" id="wxDate">–</div>
                </div>
                <div class="wx-main">
                    <div>
                        <div class="wx-temp" id="weatherTemp">--°</div>
                        <div class="wx-desc-text" id="weatherDesc">Memuat cuaca…</div>
                    </div>
                    <div class="wx-icon" id="weatherIcon"><i class="fas fa-cloud-sun"></i></div>
                </div>
                <div class="wx-divider"></div>
                <div class="wx-footer">
                    <div class="wx-stat">
                        <span><i class="fas fa-droplet"></i></span><span id="wxHumidity">--%</span>
                    </div>
                    <div class="wx-stat">
                        <span><i class="fas fa-wind"></i></span><span id="wxWind">-- km/h</span>
                    </div>
                    <div class="wx-clock" id="clockTime">--:-- WITA</div>
                </div>
            </div>

            <!-- Swiper Container -->
            <div class="swiper-container tp-slider-active swiper-container-fade swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                <div class="swiper-wrapper" style="transition-duration: 0ms;">
                    <!-- Slide 2 -->
                    <div class="swiper-slide swiper-slide-duplicate-prev" 
                         data-swiper-slide-index="1" 
                         style="width: 100%; opacity: 0; transform: translate3d(-100%, 0px, 0px); transition-duration: 0ms;">
                        <div style="background-image: url('{{ asset('images/slider/slide0.png') }}'); width: 100%; height: 100%; background-size: cover; background-position: center;"></div>
                        
                        <!-- Slide Content -->
                        <div class="slide-content">
                            <div class="slide-subtitle">Dinas Kependudukan dan Pencatatan Sipil Kota Samarinda</div>
                            <h1 class="slide-title">RUMAH DATA<br>KOTA SAMARINDA</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-1">
                                        <img src="{{ asset('logo/bank_data_logo_login.png') }}" alt="">
                                    </div>
                                    <h4 class="text-center mb-2">Rumah Data</h4>
                                    <form id="loginForm" method="POST" action="{{ route('action_login') }}">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Masukkan Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                    {{-- <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary"
                                                href="{{ url('/page-register') }}">Sign up</a></p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/auth/login.js')}}" type="text/javascript"></script>

    <script src="{{ asset('libs/global/global.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libs/swiper/js/swiper-bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/deznav-init.js') }}" type="text/javascript"></script>

    <!-- Swiper Slider Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Swiper
            var swiper = new Swiper('.swiper-container', {
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 1000,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                loop: true,
                navigation: {
                    nextEl: '.slider-next',
                    prevEl: '.slider-prev',
                },
                on: {
                    init: function() {
                        console.log('Swiper initialized');
                    }
                }
            });

            // Open-Meteo API — free, no API key required
            const SAMARINDA_LAT = -0.5022;
            const SAMARINDA_LON = 117.1536;

            // WMO Weather Code → { description (Indonesian), day icon class, night icon class }
            const WMO_MAP = {
                0:  { desc:'Cerah',                      day:'fas fa-sun', night:'fas fa-moon' },
                1:  { desc:'Sebagian Cerah',             day:'fas fa-cloud-sun', night:'fas fa-moon' },
                2:  { desc:'Berawan Sebagian',           day:'fas fa-cloud-sun', night:'fas fa-cloud' },
                3:  { desc:'Berawan',                    day:'fas fa-cloud', night:'fas fa-cloud' },
                45: { desc:'Berkabut',                   day:'fas fa-smog', night:'fas fa-smog' },
                48: { desc:'Kabut Tebal',                day:'fas fa-smog', night:'fas fa-smog' },
                51: { desc:'Gerimis Ringan',             day:'fas fa-cloud-sun-rain', night:'fas fa-cloud-rain' },
                53: { desc:'Gerimis Sedang',             day:'fas fa-cloud-sun-rain', night:'fas fa-cloud-rain' },
                55: { desc:'Gerimis Lebat',              day:'fas fa-cloud-rain', night:'fas fa-cloud-rain' },
                56: { desc:'Gerimis Dingin Ringan',      day:'fas fa-cloud-rain', night:'fas fa-cloud-rain' },
                57: { desc:'Gerimis Dingin Lebat',       day:'fas fa-cloud-rain', night:'fas fa-cloud-rain' },
                61: { desc:'Hujan Ringan',               day:'fas fa-cloud-sun-rain', night:'fas fa-cloud-rain' },
                63: { desc:'Hujan Sedang',               day:'fas fa-cloud-rain', night:'fas fa-cloud-rain' },
                65: { desc:'Hujan Lebat',                day:'fas fa-cloud-showers-heavy', night:'fas fa-cloud-showers-heavy' },
                66: { desc:'Hujan Es Ringan',            day:'fas fa-cloud-rain', night:'fas fa-cloud-rain' },
                67: { desc:'Hujan Es Lebat',             day:'fas fa-cloud-showers-heavy', night:'fas fa-cloud-showers-heavy' },
                71: { desc:'Salju Ringan',               day:'fas fa-snowflake', night:'fas fa-snowflake' },
                73: { desc:'Salju Sedang',               day:'fas fa-snowflake', night:'fas fa-snowflake' },
                75: { desc:'Salju Lebat',                day:'fas fa-snowflake', night:'fas fa-snowflake' },
                77: { desc:'Butiran Salju',              day:'fas fa-snowflake', night:'fas fa-snowflake' },
                80: { desc:'Hujan Ringan Sesaat',        day:'fas fa-cloud-sun-rain', night:'fas fa-cloud-rain' },
                81: { desc:'Hujan Sedang Sesaat',        day:'fas fa-cloud-rain', night:'fas fa-cloud-rain' },
                82: { desc:'Hujan Lebat Sesaat',         day:'fas fa-cloud-showers-heavy', night:'fas fa-cloud-showers-heavy' },
                85: { desc:'Hujan Salju Ringan',         day:'fas fa-cloud-meatball', night:'fas fa-cloud-meatball' },
                86: { desc:'Hujan Salju Lebat',          day:'fas fa-cloud-meatball', night:'fas fa-cloud-meatball' },
                95: { desc:'Hujan Petir',                day:'fas fa-bolt', night:'fas fa-bolt' },
                96: { desc:'Hujan Petir & Hujan Es',     day:'fas fa-poo-storm', night:'fas fa-poo-storm' },
                99: { desc:'Hujan Petir & Hujan Es Lebat', day:'fas fa-poo-storm', night:'fas fa-poo-storm' },
            };

            function isDay() {
                const now = new Date();
                const utc = now.getTime() + now.getTimezoneOffset() * 60000;
                const wita = new Date(utc + 8 * 3600000);
                const h = wita.getHours();
                return h >= 6 && h < 18;
            }

            function resolveWmo(code) {
                const entry = WMO_MAP[code] || WMO_MAP[3];
                return {
                    desc: entry.desc,
                    iconClass: isDay() ? entry.day : entry.night,
                };
            }

            // Update date display (Indonesian format)
            function updateDate() {
                const now = new Date();
                const utc  = now.getTime() + now.getTimezoneOffset() * 60000;
                const wita = new Date(utc + 8 * 3600000);
                const days  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                const el = document.getElementById('wxDate');
                if (el) el.textContent = `${days[wita.getDay()]}, ${wita.getDate()} ${months[wita.getMonth()]} ${wita.getFullYear()}`;
            }

            // Fetch Weather Data from Open-Meteo (free, no API key)
            function fetchWeather() {
                const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${SAMARINDA_LAT}&longitude=${SAMARINDA_LON}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&timezone=Asia/Makassar`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.current) {
                            const temp     = Math.round(data.current.temperature_2m);
                            const humidity = data.current.relative_humidity_2m;
                            const wmoCode  = data.current.weather_code;
                            const wind     = Math.round(data.current.wind_speed_10m);
                            const w        = resolveWmo(wmoCode);

                            document.getElementById('weatherTemp').textContent  = `${temp}°`;
                            document.getElementById('weatherDesc').textContent  = w.desc;
                            document.getElementById('weatherIcon').innerHTML    = `<i class="${w.iconClass}"></i>`;
                            document.getElementById('wxHumidity').textContent   = `${humidity}%`;
                            document.getElementById('wxWind').textContent       = `${wind} km/h`;
                        }
                    })
                    .catch(error => {
                        console.error('Gagal mengambil data cuaca:', error);
                    });
            }

            // Update Clock for Samarinda (WITA - UTC+8)
            function updateClock() {
                const now = new Date();
                
                // Convert to WITA timezone (UTC+8)
                const witaOffset = 8 * 60; // 8 hours in minutes
                const localOffset = now.getTimezoneOffset(); // Local timezone offset in minutes
                const witaTime = new Date(now.getTime() + (witaOffset + localOffset) * 60000);
                
                const hours = String(witaTime.getHours()).padStart(2, '0');
                const minutes = String(witaTime.getMinutes()).padStart(2, '0');
                const seconds = String(witaTime.getSeconds()).padStart(2, '0');
                
                document.getElementById('clockTime').textContent = `${hours}:${minutes}:${seconds} WITA`;
            }

            // Initialize Weather, Date, and Clock
            fetchWeather();
            updateClock();
            updateDate();

            // Update clock every second
            setInterval(updateClock, 1000);

            // Update weather every 10 minutes
            setInterval(fetchWeather, 600000);

            // Update date every minute (handles midnight rollover)
            setInterval(updateDate, 60000);
        });
    </script>

    <!-- Anime.js v4 (local): splitText clone animation — "RUMAH DATA KOTA SAMARINDA" -->
    <script type="module">
        import { createTimeline, stagger, splitText }
            from '{{ asset("vendor/animejs/anime.esm.min.js") }}';

        window.addEventListener('load', function () {
            /* Small delay so Swiper finishes creating all slide clones */
            setTimeout(function () {
                document.querySelectorAll('.slide-title').forEach(function (titleEl) {
                    /* Flatten <br> so splitText gets a plain text node */
                    titleEl.innerHTML = titleEl.innerHTML.replace(/<br\s*\/?>/gi, ' ');

                    try {
                        var result = splitText(titleEl, {
                            chars: { wrap: 'clip', clone: 'bottom' },
                        });

                        if (!result || !result.chars || !result.chars.length) return;

                        createTimeline()
                            .add(result.chars, {
                                y: '-100%',
                                loop: true,
                                loopDelay: 3500,
                                duration: 700,
                                ease: 'inOut(2)',
                            }, stagger(55, { from: 'first' }));
                    } catch (err) {
                        console.warn('[anime.js] splitText error:', err);
                    }
                });
            }, 250);
        });
    </script>
</body>

</html>
