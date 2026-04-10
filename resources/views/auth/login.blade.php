<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rumah Data 2.0 Kota Samarinda - Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/login-slider.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
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

            <!-- Weather and Clock Widget -->
            <div class="weather-clock-widget">
                <div class="weather-info">
                    <div class="weather-icon" id="weatherIcon">🌤️</div>
                    <div>
                        <div class="weather-temp" id="weatherTemp">25°C</div>
                        <div class="weather-desc" id="weatherDesc">hujan rintas-rintas</div>
                    </div>
                </div>
                <div class="clock-info" id="clockTime">18:43 WITA</div>
                <div class="location-info">Samarinda, Kalimantan Timur</div>
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

    <script src="{{ asset('vendor/global/global.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/swiper/js/swiper-bundle.min.js') }}" type="text/javascript"></script>
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

            // Weather API Configuration
            const WEATHER_API_KEY = '8c3e8e8a8f3e4b5a9c2d1e0f7g8h9i0j'; // Ganti dengan API key Anda dari OpenWeatherMap
            const CITY_NAME = 'Samarinda';
            const COUNTRY_CODE = 'ID';

            // Weather Icons Mapping
            const weatherIcons = {
                '01d': '☀️', '01n': '🌙',
                '02d': '⛅', '02n': '☁️',
                '03d': '☁️', '03n': '☁️',
                '04d': '☁️', '04n': '☁️',
                '09d': '🌧️', '09n': '🌧️',
                '10d': '🌦️', '10n': '🌧️',
                '11d': '⛈️', '11n': '⛈️',
                '13d': '❄️', '13n': '❄️',
                '50d': '🌫️', '50n': '🌫️'
            };

            // Fetch Weather Data
            function fetchWeather() {
                const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${CITY_NAME},${COUNTRY_CODE}&appid=${WEATHER_API_KEY}&units=metric&lang=id`;
                
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.cod === 200) {
                            const temp = Math.round(data.main.temp);
                            const description = data.weather[0].description;
                            const iconCode = data.weather[0].icon;
                            const icon = weatherIcons[iconCode] || '🌤️';

                            document.getElementById('weatherTemp').textContent = `${temp}°C`;
                            document.getElementById('weatherDesc').textContent = description;
                            document.getElementById('weatherIcon').textContent = icon;
                        } else {
                            console.warn('Weather API error:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching weather:', error);
                        // Keep default values on error
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

            // Initialize Weather and Clock
            fetchWeather();
            updateClock();

            // Update clock every second
            setInterval(updateClock, 1000);

            // Update weather every 10 minutes
            setInterval(fetchWeather, 600000);
        });
    </script>
</body>

</html>
