var csrfToken = $('meta[name="csrf-token"]').attr("content");
var originalUrl = $('meta[name="original"]').attr("content");
import Inputmask from "inputmask";

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


document.addEventListener('DOMContentLoaded', () => {

    const startDateInput = document.getElementById('datepicker-start');
    const endDateInput = document.getElementById('datepicker-end');
    const earlierDate = startDateInput.getAttribute('data-start-date')
    $('#datepicker-end').attr('disabled', true)

    const startPicker = new Datepicker(startDateInput, {
        autohide: true,
        format: 'yyyy-mm-dd',
        minDate: earlierDate,
        orientation: 'bottom'
    });
    document.querySelectorAll('.datepicker').forEach(function(element) {
        element.classList.add('ignore-dropdown'); // Menambahkan kelas 'ignore' ke setiap elemen
    });

    startDateInput.addEventListener('changeDate', () => {
        const selectedDate = startPicker.getDate();
        $('#datepicker-end').attr('disabled', false)
        // Recreate the end date picker with updated minDate
        const endPicker = new Datepicker(endDateInput, {
            autohide: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom',
            minDate: selectedDate,
        });
        document.querySelectorAll('.datepicker').forEach(function(element) {
            element.classList.add('ignore-dropdown'); // Menambahkan kelas 'ignore' ke setiap elemen
        });
    });
})


$('#applyFilter').on('click', function(){
    var status = []
    $('[data-checkbox="status"]').each(function(){
        if($(this).prop('checked')){
            status.push($(this).attr('name'))
        }
    })
    var selectedType =  $('input[name="default-radio"]:checked').val();
    var dateRangeStart =  $('#datepicker-start').val();
    var dateRangeEnd =  $('#datepicker-end').val();

    $.ajax({
        url: '/admin/stok/filter',
        type:'POST',
        dataType: 'json',
        data: {
            _token : csrfToken,
            filterSearch : $('#simple-search-filter').val(),
            status: status,
            type: selectedType,
            dateRangeStart: dateRangeStart,
            dateRangeEnd: dateRangeEnd,
        },
        success: function (data) {
            if(data.status == 'success'){
                window.location.replace('/admin/stok/riwayat-transaksi');
            }
            if(data.status == 'fail'){
                console.log(data.message);
            }
        }
    })
})

$('#simple-search-filter').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '/admin/simple-search',
            dataType: 'json',
            data: {
                table: [
                    '2c6ee24b09816a6f14f95d1698b24ead',   // Misalnya, 'table_1' adalah nama tabel yang diizinkan
                    '2d2d2c4b9e1d2f6f2bcd345b223ee6d4'
                ],
                term: request.term
            },
            success: function (data) {
                if(data.debuging){
                    console.log(data.debuging);

                }
                if(data.user && data.product){
                    var results = [];
                    var results = results.concat(
                        data.user.map(function (item) {
                            return {
                                label: item.name + ' (user)', // Nilai yang akan disimpan di input
                                value: item.name
                            };
                        })
                    );
                    var results = results.concat(
                        data.product.map(function (item) {
                            return {
                                label: item.name + ' (produk)', // Nilai yang akan disimpan di input
                                value: item.name
                            };
                        })
                    );
                }else{
                    var results = data.map(function (item) {
                        return {
                            label: item.name, // Nilai yang akan disimpan di input
                        };
                    });
                }
                response(results);
            }
        })
    },
    minLength: 2,
    open: function(){
        var items = $(this).autocomplete('widget').find('.ui-menu-item');
        items.addClass('ignore-dropdown');
        ; // Menambahkan kelas custom ke semua item
    }
})

$('[data-filter-collapse]').each(function () {
    $(this).on('click', function () {
        $(this).toggleClass('bg-blue-50 text-blue-400');
        $(`#${$(this).data('filter-collapse')}`).toggleClass('hidden');
        var otherElements = $('[data-filter-collapse]').not(this);

        otherElements.each(function () {
            $(this).removeClass('bg-blue-50 text-blue-400');
            if (!$(`#${$(this).data('filter-collapse')}`).hasClass('hidden')) {
                $(`#${$(this).data('filter-collapse')}`).addClass('hidden')
            }
        });

    })
})

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
