// fetch data tahun
function generateYearOptions(selectId, startYear = 2017) {
    const selectElement = document.getElementById(selectId);
    if (!selectElement) return; // Pastikan elemen ada

    const tahunSekarang = new Date().getFullYear();

    // Bersihkan opsi lama jika ada
    selectElement.innerHTML = '<option value="" disabled selected>--PILIH TAHUN--</option>';

    // Tambahkan opsi tahun dari sekarang hingga startYear
    selectElement.innerHTML += Array.from({ length: tahunSekarang - startYear + 1 }, (_, i) => {
        const tahun = tahunSekarang - i;
        return `<option value="${tahun}">${tahun}</option>`;
    }).join('');
}
function dataTableBasic() {
    "use strict";
    var table = $('#table').DataTable({
        createdRow: function (row, data, index) {
            $(row).addClass('selected')
        },
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        }
    });
    table.on('click', 'tbody tr', function () {
        var $row = table.row(this).nodes().to$();
        var hasClass = $row.hasClass('selected');
        if (hasClass) {
            $row.removeClass('selected')
        } else {
            $row.addClass('selected')
        }
    })

    table.rows().every(function () {
        this.nodes().to$().removeClass('selected')
    });
} (jQuery)

function selectAge() {
    const $umurSelect = $('#umur');

    for (let i = 0; i <= 125; i++) {
        $umurSelect.append($('<option>', {
            value: i,
            text: `${i} Tahun`
        }));
    }
}(jQuery)