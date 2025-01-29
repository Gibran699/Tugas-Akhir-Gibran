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
