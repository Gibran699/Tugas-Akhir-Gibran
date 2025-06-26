@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="form-head mb-sm-5 mb-3 d-flex flex-wrap align-items-center">
            <h2 class="font-w600 title mb-2 me-auto " style="direction: ltr;">Dashboard</h2>
        </div>
        @include('dashboard.component.card_content_penduduk')
        @include('dashboard.component.chart')
        @include('dashboard.component.card_content_kepemilikan')
        @include('dashboard.component.table_kelompok_umur')
    </div>
    <script>
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
            barPercentage: 0.9,
            barColors: [
                'rgba(235, 129, 83, 1)',  // Orange
                'rgba(52, 152, 219, 1)',  // Blue
                'rgba(46, 204, 113, 1)',  // Green
                'rgba(155, 89, 182, 1)',  // Purple
                'rgba(241, 196, 15, 1)',  // Yellow
                'rgba(231, 76, 60, 1)',   // Red
                'rgba(26, 188, 156, 1)',  // Cyan
                'rgba(230, 126, 34, 1)',  // Dark Orange
                'rgba(52, 73, 94, 1)',    // Gray
                'rgba(142, 68, 173, 1)'   // Dark Purple
            ],
            pieColors: [
                'rgba(235, 129, 83, 0.9)',  // Orange
                'rgba(52, 152, 219, 0.9)',  // Blue
                'rgba(46, 204, 113, 0.9)',  // Green
                'rgba(155, 89, 182, 0.9)'   // Purple
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
                console.warn(`${dataKey} data is missing`);
                return { labels: [], values: [] };
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
            context.height = CHART_CONFIG.height;
            return new Chart(context, {
                type: 'bar',
                data: {
                    defaultFontFamily: 'Poppins',
                    labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: values,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 0
                    }]
                },
                options: {
                    legend: { display: false },
                    scales: {
                        yAxes: [{ ticks: { beginAtZero: true } }],
                        xAxes: [{
                            barPercentage: CHART_CONFIG.barPercentage,
                            ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 }
                        }]
                    },
                    tooltips: { callbacks: { label: (tooltipItem, data) => `${data.labels[tooltipItem.index]}: ${formatNumber(data.datasets[0].data[tooltipItem.index])}` } }
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
            context.height = CHART_CONFIG.height;
            return new Chart(context, {
                type: 'pie',
                data: {
                    defaultFontFamily: 'Poppins',
                    datasets: [{ data: values, borderWidth: 0, backgroundColor: colors, hoverBackgroundColor: colors }],
                    labels
                },
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'right',
                        labels: { fontFamily: 'Poppins', fontSize: 12, padding: 20 }
                    },
                    maintainAspectRatio: false,
                    tooltips: { callbacks: { label: (tooltipItem, data) => `${data.labels[tooltipItem.index]}: ${formatNumber(data.datasets[0].data[tooltipItem.index])}` } }
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
            const context = document.getElementById('top10Work').getContext('2d');
            const { labels, values } = processData(data, data.top10_pekerjaan.map(item => ({ key: null, label: item.pekerjaan })), 'top10_pekerjaan');
            initializeBarChart(context, labels, values, CHART_CONFIG.barColors);
        };

        /**
         * Render marital status pie chart
         * @param {Object} data - JSON data
         */
        const renderMaritalStatusChart = (data) => {
            if (!checkElementExists(CHART_CONFIG.pieMaritalCanvasId, 'Marital status chart')) return;
            const context = document.getElementById('statusKawin').getContext('2d');
            const { labels, values } = processData(data, CHART_CONFIG.maritalLabels, 'status_kawin');
            initializePieChart(context, labels, values, CHART_CONFIG.pieColors.slice(0, 4));
        };

        /**
         * Render education bar chart
         * @param {Object} data - JSON data
         */
        const renderEducationChart = (data) => {
            if (!checkElementExists(CHART_CONFIG.barEducationCanvasId, 'Education chart')) return;
            const context = document.getElementById('statusPendidikan').getContext('2d');
            const { labels, values } = processData(data, CHART_CONFIG.pendidikanLabels, 'pendidikan');
            initializeBarChart(context, labels, values, CHART_CONFIG.barColors);
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
        const fetchDataDashboard = () => {
            $.ajax({
                url: '/data_json/dashboard',
                type: 'GET',
                dataType: 'json',
                success: (data) => {
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
        $(document).ready(() => fetchDataDashboard());
    </script>
@endsection
