(function ($) {

    /* ============================================================
       Chart instances (kept in outer scope for update-in-place)
       ============================================================ */
    var statusDistribusiChart  = null;
    var rataRataBulananChart   = null;

    /* ---- Colour palette shared by both charts ---- */
    var COLORS = {
        permohonan:   { bg: 'rgba(99,  102, 241, 0.82)', hover: 'rgba(99,  102, 241, 1)' },
        proses:       { bg: 'rgba(245, 158,  11, 0.82)', hover: 'rgba(245, 158,  11, 1)' },
        selesai:      { bg: 'rgba(16,  185, 129, 0.82)', hover: 'rgba(16,  185, 129, 1)' },
        tidakSesuai:  { bg: 'rgba(239,  68,  68, 0.82)', hover: 'rgba(239,  68,  68, 1)' }
    };

    /* ---- Service definitions (key matches API response object keys) ---- */
    var SERVICES = [
        { label: 'Akta Kematian',  key: 'aktaKematian'      },
        { label: 'Akta Kelahiran', key: 'aktaKelahiranMerge' },
        { label: 'Pindah Datang',  key: 'pindahDatang'       },
        { label: 'Pindah Keluar',  key: 'pindahKeluar'       },
        { label: 'KIA',            key: 'kia'                },
        { label: 'KTP',            key: 'ktp'                },
        { label: 'KK',             key: 'kkMerge'            }
    ];

    /* ============================================================
       Bootstrap
       ============================================================ */
    $(document).ready(function () {
        $('#submitSearch').click(function () { fetchData(); });
    });

    /* ============================================================
       Helpers
       ============================================================ */
    function getMonthsDiff(start, finish) {
        if (!start || !finish) return 1;
        var s = new Date(start), f = new Date(finish);
        var m = (f.getFullYear() - s.getFullYear()) * 12 + (f.getMonth() - s.getMonth()) + 1;
        return Math.max(1, m);
    }

    function round1(n) { return Math.round(n * 10) / 10; }

    function safeInt(val) { return parseInt(val) || 0; }

    function formatDate(dateString) {
        if (!dateString || dateString === 'N/A') return 'N/A';
        var date = new Date(dateString);
        if (isNaN(date.getTime())) return 'N/A';
        var d = String(date.getDate()).padStart(2, '0');
        var m = String(date.getMonth() + 1).padStart(2, '0');
        return d + '/' + m + '/' + date.getFullYear();
    }

    /* ============================================================
       AJAX fetch
       ============================================================ */
    function fetchData() {
        var formData = new FormData(document.getElementById('formSearchDataLayananOnline'));
        $.ajax({
            url: $('#formSearchDataLayananOnline').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Harap Tunggu',
                    allowOutsideClick: false,
                    didOpen: function () { Swal.showLoading(); }
                });
            },
            success: function (response) {
                Swal.close();
                if (typeof window.hideLoading === 'function') window.hideLoading();
                Swal.fire({ title: 'Berhasil', text: response.message || 'Pencarian Berhasil!', icon: 'success' });
                updateCardData(response);
                updateTableRincian(response);
                updateCharts(response);
                var dari   = formatDate(response.date.start)  || 'N/A';
                var sampai = formatDate(response.date.finish) || 'N/A';
                $('#tanggalRequest').text('Laporan Pelayanan Online ' + dari + ' - ' + sampai);
            },
            error: function (xhr) {
                if (typeof window.hideLoading === 'function') window.hideLoading();
                var msg = 'Terjadi kesalahan. Silakan coba lagi.';
                if (xhr.status === 400 || xhr.status === 404) {
                    msg = (xhr.responseJSON && (xhr.responseJSON.data || xhr.responseJSON.message)) || msg;
                }
                Swal.fire({ title: 'Gagal', text: msg, icon: 'error' });
            },
            complete: function () {
                if (typeof window.hideLoading === 'function') window.hideLoading();
            }
        });
    }

    /* ============================================================
       Card + table updates (unchanged logic)
       ============================================================ */
    function updateCardData(response) {
        var p = 0, pr = 0, s = 0, t = 0;
        SERVICES.forEach(function (svc) {
            var d = response[svc.key] || {};
            p  += safeInt(d.permohonan);
            pr += safeInt(d.proses);
            s  += safeInt(d.selesai);
            t  += safeInt(d.tidak_sesuai);
        });
        $('#submissionCard').text(p);
        $('#prosesCard').text(pr);
        $('#selesaiCard').text(s);
        $('#tidakSesuaiCard').text(t);
    }

    function updateTableRincian(response) {
        var tbody = $('#tableLayananOnline tbody');
        tbody.empty();
        response.dataTable.forEach(function (row) {
            tbody.append(
                '<tr>' +
                '<td class="text-left">' + row.nama_layanan  + '</td>' +
                '<td>' + row.permohonan  + '</td>' +
                '<td>' + row.validasi    + '</td>' +
                '<td>' + row.proses      + '</td>' +
                '<td>' + row.selesai     + '</td>' +
                '<td>' + row.tidak_sesuai + '</td>' +
                '</tr>'
            );
        });
    }

    /* ============================================================
       Chart orchestration
       ============================================================ */
    function updateCharts(response) {
        $('#chartEmptyState').hide();
        $('#chartSection').show();

        var months = getMonthsDiff(
            response.date ? response.date.start  : null,
            response.date ? response.date.finish : null
        );

        /* ---- Aggregate totals per status ---- */
        var totP = 0, totPr = 0, totS = 0, totT = 0;
        SERVICES.forEach(function (svc) {
            var d = response[svc.key] || {};
            totP  += safeInt(d.permohonan);
            totPr += safeInt(d.proses);
            totS  += safeInt(d.selesai);
            totT  += safeInt(d.tidak_sesuai);
        });

        /* ---- Monthly averages per service ---- */
        var labels = [], avgP = [], avgPr = [], avgS = [], avgT = [];
        SERVICES.forEach(function (svc) {
            var d = response[svc.key] || {};
            labels.push(svc.label);
            avgP.push( round1(safeInt(d.permohonan)   / months));
            avgPr.push(round1(safeInt(d.proses)        / months));
            avgS.push( round1(safeInt(d.selesai)       / months));
            avgT.push( round1(safeInt(d.tidak_sesuai) / months));
        });

        /* ---- Range label in card header ---- */
        var dari   = formatDate(response.date ? response.date.start  : '');
        var sampai = formatDate(response.date ? response.date.finish : '');
        $('#chartRangeLabel').text('(' + dari + ' – ' + sampai + ', ' + months + ' bln)');

        renderDonut(totP, totPr, totS, totT);
        renderBarAvg(labels, avgP, avgPr, avgS, avgT, months);
    }

    /* ============================================================
       Chart 1 — Doughnut: total distribution by status
       ============================================================ */
    function renderDonut(p, pr, s, t) {
        var ctx = document.getElementById('chartStatusDistribusi');
        if (!ctx) return;

        var newData = {
            labels: ['Permohonan', 'Proses', 'Selesai', 'Tidak Sesuai'],
            datasets: [{
                data: [p, pr, s, t],
                backgroundColor:      [COLORS.permohonan.bg, COLORS.proses.bg, COLORS.selesai.bg, COLORS.tidakSesuai.bg],
                hoverBackgroundColor: [COLORS.permohonan.hover, COLORS.proses.hover, COLORS.selesai.hover, COLORS.tidakSesuai.hover],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff'
            }]
        };

        if (statusDistribusiChart) {
            statusDistribusiChart.data = newData;
            statusDistribusiChart.update();
            return;
        }

        statusDistribusiChart = new Chart(ctx, {
            type: 'doughnut',
            data: newData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 62,
                animation: { animateRotate: true, animateScale: true, duration: 1200, easing: 'easeOutQuart' },
                hover: { animationDuration: 180 },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { fontFamily: 'Poppins', fontSize: 12, fontColor: '#374151', padding: 16, usePointStyle: true }
                },
                tooltips: {
                    backgroundColor: 'rgba(17,24,39,0.95)',
                    titleFontFamily: 'Poppins', titleFontSize: 12, titleFontColor: '#f9fafb',
                    bodyFontFamily:  'Poppins', bodyFontSize:  13, bodyFontColor:  '#d1d5db',
                    borderColor: 'rgba(255,255,255,0.08)', borderWidth: 1,
                    cornerRadius: 8, xPadding: 14, yPadding: 10, displayColors: true,
                    callbacks: {
                        label: function (item, data) {
                            var val = data.datasets[0].data[item.index];
                            var tot = data.datasets[0].data.reduce(function (a, b) { return a + b; }, 0);
                            var pct = tot > 0 ? ((val / tot) * 100).toFixed(1) : 0;
                            return '  ' + data.labels[item.index] + ': ' + val.toLocaleString() + ' (' + pct + '%)';
                        }
                    }
                }
            }
        });
    }

    /* ============================================================
       Chart 2 — Grouped bar: monthly average per service type
       ============================================================ */
    function renderBarAvg(labels, avgP, avgPr, avgS, avgT, months) {
        var ctx = document.getElementById('chartRataRataBulanan');
        if (!ctx) return;

        var datasets = [
            { label: 'Permohonan',   data: avgP,  backgroundColor: COLORS.permohonan.bg,  hoverBackgroundColor: COLORS.permohonan.hover,  borderColor: 'transparent', borderWidth: 0 },
            { label: 'Proses',       data: avgPr, backgroundColor: COLORS.proses.bg,       hoverBackgroundColor: COLORS.proses.hover,       borderColor: 'transparent', borderWidth: 0 },
            { label: 'Selesai',      data: avgS,  backgroundColor: COLORS.selesai.bg,      hoverBackgroundColor: COLORS.selesai.hover,      borderColor: 'transparent', borderWidth: 0 },
            { label: 'Tidak Sesuai', data: avgT,  backgroundColor: COLORS.tidakSesuai.bg,  hoverBackgroundColor: COLORS.tidakSesuai.hover,  borderColor: 'transparent', borderWidth: 0 }
        ];

        if (rataRataBulananChart) {
            rataRataBulananChart.data.labels   = labels;
            rataRataBulananChart.data.datasets = datasets;
            rataRataBulananChart.update();
            return;
        }

        rataRataBulananChart = new Chart(ctx, {
            type: 'bar',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1000, easing: 'easeOutQuart' },
                hover: { animationDuration: 180, mode: 'index' },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { fontFamily: 'Poppins', fontSize: 12, fontColor: '#374151', padding: 16, usePointStyle: true }
                },
                scales: {
                    yAxes: [{
                        gridLines: { color: 'rgba(0,0,0,0.04)', zeroLineColor: 'rgba(0,0,0,0.08)', drawBorder: false },
                        ticks: {
                            beginAtZero: true,
                            fontFamily: 'Poppins', fontSize: 11, fontColor: '#9ca3af', padding: 8,
                            callback: function (v) { return Number.isInteger(v) ? v.toLocaleString() : v.toFixed(1); }
                        }
                    }],
                    xAxes: [{
                        gridLines: { display: false },
                        barPercentage: 0.78,
                        ticks: { fontFamily: 'Poppins', fontSize: 11, fontColor: '#6b7280' }
                    }]
                },
                tooltips: {
                    backgroundColor: 'rgba(17,24,39,0.95)',
                    titleFontFamily: 'Poppins', titleFontSize: 12, titleFontColor: '#f9fafb',
                    bodyFontFamily:  'Poppins', bodyFontSize:  13, bodyFontColor:  '#d1d5db',
                    footerFontFamily: 'Poppins', footerFontSize: 11, footerFontColor: '#F7E396',
                    borderColor: 'rgba(255,255,255,0.08)', borderWidth: 1,
                    cornerRadius: 8, xPadding: 14, yPadding: 10,
                    displayColors: true, mode: 'index', intersect: false,
                    callbacks: {
                        title: function (items) { return items[0].xLabel; },
                        label: function (item, data) {
                            var val = data.datasets[item.datasetIndex].data[item.index];
                            var display = Number.isInteger(val) ? val.toLocaleString() : val.toFixed(1);
                            return '  ' + data.datasets[item.datasetIndex].label + ': ' + display + '/bln';
                        },
                        footer: function (items) {
                            var total = items.reduce(function (sum, i) { return sum + parseFloat(i.yLabel); }, 0);
                            return '  Total: ' + (Number.isInteger(total) ? total.toLocaleString() : total.toFixed(1)) + '/bln';
                        }
                    }
                }
            }
        });
    }

})(jQuery);
