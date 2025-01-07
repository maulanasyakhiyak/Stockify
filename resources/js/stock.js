var csrfToken = $('meta[name="csrf-token"]').attr("content");
import Inputmask from "inputmask";
import './filterstock'


// input mask pada product stock

document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll("input[data-input-minimum-stock]");
    var maskOptions = {
        regex: "^[1-9][0-9]*$",
        placeholder: "0",  // Kosongkan placeholder jika tidak diinginkan
        clearMaskOnLostFocus: false,  // Hapus masker saat input tidak fokus
        showMaskOnFocus: true,  // Masker hanya terlihat saat input fokus
        showMaskOnHover: true,
    };
    Inputmask(maskOptions).mask(inputs);
});

$(document).on('input', 'input[data-input-minimum-stock]', function(){
    const id = $(this).data('input-minimum-stock')

    const currentValue = $(this).val();
    const currentStock = $(this).data('stock-current');

    // Pastikan nilai input tidak kosong dan tidak 0, dan tidak sama dengan currentStock
    if (currentValue !== "" && currentValue !== "0" && parseInt(currentValue) !== currentStock) {
        $(`[data-save-minimum-stock='${id}']`).attr('disabled', false);
    } else {
        $(`[data-save-minimum-stock='${id}']`).attr('disabled', true);
    }
})

$('[data-save-minimum-stock').on('click', function(){
    const inputId = $(this).data('save-minimum-stock')
    var newStock = $(`[data-input-minimum-stock = ${inputId}]`).val()

    $.ajax({
        type: 'POST',  // Jenis request (POST)
            url: '/admin/stok/product-stock/update-minimum-stock',  // Ganti dengan URL endpoint yang sesuai
            data: {
                id: inputId,
                stock: newStock,
                _token: csrfToken  // Pastikan CSRF token sudah ditambahkan di halaman Anda
            },
            success: function(response) {
                if(response.status === 'success'){
                    window.location.reload()
                }
            }
    })
})


