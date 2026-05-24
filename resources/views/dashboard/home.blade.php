@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="form-head mb-3 d-flex flex-wrap align-items-center">
            <h2 class="font-w600 title mb-2 me-auto" style="direction: ltr;">Dashboard</h2>
        </div>
        <div class="card mb-4">
            <div class="card-body py-3">
                <div class="row align-items-end g-2">
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label mb-1 small text-muted">Semester</label>
                        <select id="filterSemester" class="form-control filter-select">
                            <option value="1">Semester I</option>
                            <option value="2">Semester II</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label mb-1 small text-muted">Tahun</label>
                        <select id="filterTahun" class="form-control filter-select"></select>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="d-flex align-items-center flex-wrap mt-sm-0 mt-2" style="gap:10px">
                            <button id="btnFilterDashboard" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                            <span id="activePeriodLabel" class="badge badge-primary px-3 py-2" style="font-size:0.82rem;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.component.card_content_penduduk')
        @include('dashboard.component.chart')
        @include('dashboard.component.card_content_kepemilikan')
        @include('dashboard.component.table_kelompok_umur')
    </div>
    <script src="{{ asset('js/global_func.js') }}"></script>
    <script>
        const DEFAULT_SEMESTER = '{{ config("dataArray.dataDashboard.semester") }}';
        const DEFAULT_TAHUN = '{{ config("dataArray.dataDashboard.tahun") }}';
        let workChart = null, maritalChart = null, educationChart = null;

        /**
         * Configuration constants for charts and tables
         * @constant
         */
        const CHART_CONFIG = {
            barCanvasId: '#top10Work',
            pieMaritalCanvasId: '#statusKawin',
            barEducationCanvasId: '#statusPendidikan',
            tablePendudukKelompokUmurId: '#table_kelompok_umur',
            tableKepalaKeluargaKelompokUmurId: '#table_kepala_keluarga_kelompok_umur',
            height: 100,
            barPercentage: 0.72,
            barColors: [
                'rgba(99,  102, 241, 0.82)',
                'rgba(59,  130, 246, 0.82)',
                'rgba(16,  185, 129, 0.82)',
                'rgba(245, 158,  11, 0.82)',
                'rgba(239,  68,  68, 0.82)',
                'rgba(168,  85, 247, 0.82)',
                'rgba(20,  184, 166, 0.82)',
                'rgba(249, 115,  22, 0.82)',
                'rgba(236,  72, 153, 0.82)',
                'rgba(34,  197,  94, 0.82)'
            ],
            barHoverColors: [
                'rgba(99,  102, 241, 1)',
                'rgba(59,  130, 246, 1)',
                'rgba(16,  185, 129, 1)',
                'rgba(245, 158,  11, 1)',
                'rgba(239,  68,  68, 1)',
                'rgba(168,  85, 247, 1)',
                'rgba(20,  184, 166, 1)',
                'rgba(249, 115,  22, 1)',
                'rgba(236,  72, 153, 1)',
                'rgba(34,  197,  94, 1)'
            ],
            pieColors: [
                'rgba(99,  102, 241, 0.88)',
                'rgba(59,  130, 246, 0.88)',
                'rgba(16,  185, 129, 0.88)',
                'rgba(245, 158,  11, 0.88)'
            ],
            pieHoverColors: [
                'rgba(99,  102, 241, 1)',
                'rgba(59,  130, 246, 1)',
                'rgba(16,  185, 129, 1)',
                'rgba(245, 158,  11, 1)'
            ],
            kelompokUmurLabels: [
                { key: '00_04_tahun_jml', label: '0-4 Tahun' },
                { key: '05_09_tahun_jml', label: '5-9 Tahun' },
                { key: '10_14_tahun_jml', label: '10-14 Tahun' },
                { key: '15_19_tahun_jml', label: '15-19 Tahun' },
                { key: '20_24_tahun_jml', label: '20-24 Tahun' },
                { key: '25_29_tahun_jml', label: '25-29 Tahun' },
                { key: '30_34_tahun_jml', label: '30-34 Tahun' },
                { key: '35_39_tahun_jml', label: '35-39 Tahun' },
                { key: '40_44_tahun_jml', label: '40-44 Tahun' },
                { key: '45_49_tahun_jml', label: '45-49 Tahun' },
                { key: '50_54_tahun_jml', label: '50-54 Tahun' },
                { key: '55_59_tahun_jml', label: '55-59 Tahun' },
                { key: '60_64_tahun_jml', label: '60-64 Tahun' },
                { key: '65_69_tahun_jml', label: '65-69 Tahun' },
                { key: '70_74_tahun_jml', label: '70-74 Tahun' },
                { key: 'lebih_75_tahun_jml', label: 'Lebih dari 75 Tahun' }
            ],
            pendidikanLabels: [
                { key: 'tidak_blm_sekolah_jml', label: 'Tidak/Belum Sekolah' },
                { key: 'belum_tamat_sd_sederajat_jml', label: 'Belum Tamat SD' },
                { key: 'tamat_sd_sederajat_jml', label: 'Tamat SD' },
                { key: 'sltp_sederajat_jml', label: 'SLTP' },
                { key: 'slta_sederajat_jml', label: 'SLTA' },
                { key: 'diploma_i_ii_jml', label: 'Diploma I/II' },
                { key: 'akademi_dipl_iii_s_muda_jml', label: 'Akademi/Diploma III' },
                { key: 'diploma_iv_strata_i_jml', label: 'Diploma IV/Strata I' },
                { key: 'strata_ii_jml', label: 'Strata II' },
                { key: 'strata_iii_jml', label: 'Strata III' }
            ],
            maritalLabels: [
                { key: 'belum_kawin', label: 'Belum Kawin' },
                { key: 'sudah_kawin', label: 'Sudah Kawin' },
                { key: 'cerai_hidup', label: 'Cerai Hidup' },
                { key: 'cerai_mati', label: 'Cerai Mati' }
            ]
        };

        /**
         * Utility to check if DOM element exists
         * @param {string} selector - jQuery selector
         * @param {string} elementName - Name for error logging
         * @returns {boolean} Whether element exists
         */
        const checkElementExists = (selector, elementName) => {
            if ($(selector).length === 0) {
                console.warn(`${elementName} element ${selector} not found`);
                return false;
            }
            return true;
        };

        /**
         * Format number for display
         * @param {number} value - Number to format
         * @returns {string} Formatted number
         */
        const formatNumber = (value) => value.toLocaleString();

        /**
         * Process data for charts or tables
         * @param {Object} data - Raw JSON data
         * @param {Array} config - Configuration with key and label
         * @param {string} dataKey - Key to access data in JSON
         * @returns {Object} Processed labels and values
         */
        const processData = (data, config, dataKey) => {
            if (!data || !data[dataKey]) {
                console.warn(`${dataKey} data is missing or empty`);
                return { labels: [], values: [] };
            }
            if (dataKey === 'top10_pekerjaan') {
                if (!Array.isArray(data[dataKey]) || data[dataKey].length === 0) {
                    console.warn('top10_pekerjaan data is not a valid array or is empty');
                    return { labels: [], values: [] };
                }
                return {
                    labels: data[dataKey].map(item => item.pekerjaan || 'Unknown'),
                    values: data[dataKey].map(item => parseInt(item.total || 0))
                };
            }
            return {
                labels: config.map(item => item.label),
                values: config.map(item => parseInt(data[dataKey][item.key] || 0))
            };
        };

        /**
         * Initialize bar chart
         * @param {CanvasRenderingContext2D} context - Canvas context
         * @param {Array<string>} labels - Chart labels
         * @param {Array<number>} values - Chart values
         * @param {Array<string>} colors - Bar colors
         * @returns {Chart} Chart.js instance
         */
        const initializeBarChart = (context, labels, values, colors) => {
            if (!labels.length || !values.length) {
                console.warn('No data to render bar chart');
                return null;
            }
            const hoverColors = CHART_CONFIG.barHoverColors.slice(0, colors.length);
            return new Chart(context, {
                type: 'bar',
                data: {
                    defaultFontFamily: 'Poppins',
                    labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: values,
                        backgroundColor: colors,
                        hoverBackgroundColor: hoverColors,
                        borderColor: 'transparent',
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    hover: {
                        animationDuration: 180,
                        mode: 'index'
                    },
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: 'rgba(0,0,0,0.045)',
                                zeroLineColor: 'rgba(0,0,0,0.09)',
                                drawBorder: false
                            },
                            ticks: {
                                beginAtZero: true,
                                fontFamily: 'Poppins',
                                fontSize: 11,
                                fontColor: '#9ca3af',
                                padding: 8,
                                callback: (v) => v.toLocaleString()
                            }
                        }],
                        xAxes: [{
                            gridLines: { display: false },
                            barPercentage: CHART_CONFIG.barPercentage,
                            ticks: {
                                autoSkip: false,
                                maxRotation: 40,
                                minRotation: 30,
                                fontFamily: 'Poppins',
                                fontSize: 11,
                                fontColor: '#6b7280'
                            }
                        }]
                    },
                    tooltips: {
                        backgroundColor: 'rgba(17,24,39,0.95)',
                        titleFontFamily: 'Poppins',
                        titleFontSize: 12,
                        titleFontColor: '#f9fafb',
                        bodyFontFamily: 'Poppins',
                        bodyFontSize: 13,
                        bodyFontColor: '#d1d5db',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        xPadding: 14,
                        yPadding: 10,
                        displayColors: true,
                        callbacks: {
                            label: (tooltipItem, data) =>
                                `  ${data.labels[tooltipItem.index]}: ${formatNumber(data.datasets[0].data[tooltipItem.index])} jiwa`
                        }
                    }
                }
            });
        };

        /**
         * Initialize pie chart
         * @param {CanvasRenderingContext2D} context - Canvas context
         * @param {Array<string>} labels - Chart labels
         * @param {Array<number>} values - Chart values
         * @param {Array<string>} colors - Segment colors
         * @returns {Chart} Chart.js instance
         */
        const initializePieChart = (context, labels, values, colors) => {
            if (!labels.length || !values.length) {
                console.warn('No data to render pie chart');
                return null;
            }
            const total = values.reduce((a, b) => a + b, 0);
            const hoverColors = CHART_CONFIG.pieHoverColors.slice(0, colors.length);
            return new Chart(context, {
                type: 'doughnut',
                data: {
                    defaultFontFamily: 'Poppins',
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        hoverBackgroundColor: hoverColors,
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverBorderWidth: 4,
                        hoverBorderColor: '#ffffff'
                    }],
                    labels
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 62,
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1200,
                        easing: 'easeOutQuart'
                    },
                    hover: { animationDuration: 180 },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontFamily: 'Poppins',
                            fontSize: 12,
                            fontColor: '#374151',
                            padding: 18,
                            usePointStyle: true
                        }
                    },
                    tooltips: {
                        backgroundColor: 'rgba(17,24,39,0.95)',
                        titleFontFamily: 'Poppins',
                        titleFontSize: 12,
                        titleFontColor: '#f9fafb',
                        bodyFontFamily: 'Poppins',
                        bodyFontSize: 13,
                        bodyFontColor: '#d1d5db',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        xPadding: 14,
                        yPadding: 10,
                        displayColors: true,
                        callbacks: {
                            label: (tooltipItem, data) => {
                                const val = data.datasets[0].data[tooltipItem.index];
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return `  ${data.labels[tooltipItem.index]}: ${formatNumber(val)} (${pct}%)`;
                            }
                        }
                    }
                }
            });
        };

        /**
         * Render table from data
         * @param {string} tableId - Table selector
         * @param {Array<Object>} data - Array of { kelompok, jumlah }
         */
        const renderTable = (tableId, data) => {
            if (!checkElementExists(tableId, 'Table')) return;
            const $tableBody = $(tableId).find('tbody');
            $tableBody.empty();
            data.forEach(item => {
                $tableBody.append(`
                    <tr>
                        <td>${item.kelompok}</td>
                        <td>${formatNumber(item.jumlah)}</td>
                    </tr>
                `);
            });
        };

        /**
         * Render work status bar chart
         * @param {Object} data - JSON data
         */
        const renderWorkStatusChart = (data) => {
            if (!checkElementExists(CHART_CONFIG.barCanvasId, 'Work status chart')) return;
            if (workChart) { workChart.destroy(); workChart = null; }
            const context = document.getElementById('top10Work').getContext('2d');
            const { labels, values } = processData(data, [], 'top10_pekerjaan');
            if (labels.length && values.length) {
                workChart = initializeBarChart(context, labels, values, CHART_CONFIG.barColors);
            } else {
                console.warn('No valid data for work status chart');
            }
        };

        /**
         * Render marital status pie chart
         * @param {Object} data - JSON data
         */
        const renderMaritalStatusChart = (data) => {
            if (!checkElementExists(CHART_CONFIG.pieMaritalCanvasId, 'Marital status chart')) return;
            if (maritalChart) { maritalChart.destroy(); maritalChart = null; }
            const context = document.getElementById('statusKawin').getContext('2d');
            const { labels, values } = processData(data, CHART_CONFIG.maritalLabels, 'status_kawin');
            maritalChart = initializePieChart(context, labels, values, CHART_CONFIG.pieColors.slice(0, 4));
        };

        /**
         * Render education bar chart
         * @param {Object} data - JSON data
         */
        const renderEducationChart = (data) => {
            if (!checkElementExists(CHART_CONFIG.barEducationCanvasId, 'Education chart')) return;
            if (educationChart) { educationChart.destroy(); educationChart = null; }
            const context = document.getElementById('statusPendidikan').getContext('2d');
            const { labels, values } = processData(data, CHART_CONFIG.pendidikanLabels, 'pendidikan');
            educationChart = initializeBarChart(context, labels, values, CHART_CONFIG.barColors);
        };

        /**
         * Render penduduk kelompok umur table
         * @param {Object} data - JSON data
         */
        const renderPendudukKelompokUmurTable = (data) => {
            const tableData = processData(data, CHART_CONFIG.kelompokUmurLabels, 'penduduk_kelompok_umur')
                .values.map((jumlah, index) => ({ kelompok: CHART_CONFIG.kelompokUmurLabels[index].label, jumlah }));
            renderTable(CHART_CONFIG.tablePendudukKelompokUmurId, tableData);
        };

        /**
         * Render kepala keluarga kelompok umur table
         * @param {Object} data - JSON data
         */
        const renderKepalaKeluargaKelompokUmurTable = (data) => {
            const tableData = processData(data, CHART_CONFIG.kelompokUmurLabels, 'kepala_keluarga_kelompok_umur')
                .values.map((jumlah, index) => ({ kelompok: CHART_CONFIG.kelompokUmurLabels[index].label, jumlah }));
            renderTable(CHART_CONFIG.tableKepalaKeluargaKelompokUmurId, tableData);
        };

        /**
         * Update card content
         * @param {Object} data - JSON data
         */
        const updateCardContent = (data) => {
            const cards = [
                { id: '#sumPenduduk', key: 'penduduk' },
                { id: '#sumKepalaKeluarga', key: 'kepala_keluarga' },
                { id: '#umur017', key: 'penduduk_017' },
                { id: '#pendudukWajibKtp', key: 'wajib_ktp' },
                { id: '#kepemilikanKtp', key: 'kepemilikan_ktp' },
                { id: '#kepemilikanAktaKelahiran', key: 'kepemilikan_akta_lahir' },
                { id: '#kepemilikanAktaKawin', key: 'kepemilikan_kawin' },
                { id: '#kepemilikanKartuKeluarga', key: 'kepemilikan_kk' },
                { id: '#kepemilikanKia', key: 'kepemilikan_kia' },
                { id: '#kepemilikanAktaCerai', key: 'kepemilikan_cerai' }
            ];
            cards.forEach(({ id, key }) => {
                if (checkElementExists(id, 'Card')) {
                    $(id).text(data[key] || '0');
                }
            });
        };

        /**
         * Fetch dashboard data and update UI
         */
        const fetchDataDashboard = (semester, tahun) => {
            const smstr = semester || DEFAULT_SEMESTER;
            const thn   = tahun    || DEFAULT_TAHUN;
            const semLabel = smstr === '1' ? 'Semester I' : 'Semester II';
            $.ajax({
                url: '/data_json/dashboard',
                type: 'GET',
                data: { semester: smstr, tahun: thn },
                dataType: 'json',
                success: (data) => {
                    $('#activePeriodLabel').text(semLabel + ' - ' + thn);
                    updateCardContent(data);
                    renderWorkStatusChart(data);
                    renderMaritalStatusChart(data);
                    renderEducationChart(data);
                    renderPendudukKelompokUmurTable(data);
                    renderKepalaKeluargaKelompokUmurTable(data);
                },
                error: (jqXHR, textStatus, error) => {
                    console.error('Failed to fetch dashboard data:', textStatus, error);
                }
            });
        };

        /* Initialize dashboard */
        $(document).ready(() => {
            generateYearOptions('filterTahun');
            $('#filterSemester, #filterTahun').selectpicker({ container: 'body' });
            $('#filterTahun').val(DEFAULT_TAHUN).selectpicker('refresh');
            $('#filterSemester').val(DEFAULT_SEMESTER).selectpicker('refresh');
            fetchDataDashboard(DEFAULT_SEMESTER, DEFAULT_TAHUN);
            $('#btnFilterDashboard').on('click', function () {
                const semester = $('#filterSemester').val();
                const tahun    = $('#filterTahun').val();
                if (!semester || !tahun) {
                    alert('Silakan pilih semester dan tahun terlebih dahulu.');
                    return;
                }
                fetchDataDashboard(semester, tahun);
            });
        });
    </script>
@endsection
