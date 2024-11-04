$('#import-btn').tooltip()
var csrfToken = $('meta[name="csrf-token"]').attr('content');
var originalUrl = $('meta[name="original"]').attr('content');


$('#items_per_page').on('change', function () {
    $.ajax({
        url: '/change_paginate',
        method: 'POST',
        data: {
            _token: csrfToken,
            paginate_change: $(this).val(),
        },
        success: function (res) {
            if (res['success']) {

                window.location.reload()
            }
            console.log('gagal');

        }
    });
})

$('#filter_product').on('submit', function (event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        success: function (response) {
            if (response.success) {
                location.replace(originalUrl);
            } else {
                toastr.error('error');
            }
        }
    });
})


$('#product_image').on('change', function () {
    const file = this.files[0];
    var target = $(this).attr('id')
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $(`[data-image=${target}]`).attr("src", e.target.result).show();
            $(`[data-noImage=${target}]`).removeClass('flex').addClass('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        $(`[data-noImage=${target}]`).removeClass('hidden').addClass('flex');
        $(`[data-image=${target}]`).hide()
    }
})


$(function() {
    const dropArea = $('label[data-dropfile]');

    console.log(dropArea.length);
    // Ambil ID dari input file dari atribut data
    const fileInputId = dropArea.data('dropfile');
    const fileInput = $('#' + fileInputId); // Gunakan ID untuk mendapatkan elemen input file

    console.log(fileInput);


    // Event drag over
    dropArea.on('dragover', function(event) {
        event.preventDefault();
        console.log('Drag over detected');
        $(this).addClass('bg-gray-100 dark:bg-gray-600'); // Sorot area
    });

    // Event drag leave
    dropArea.on('dragleave', function() {
        $(this).removeClass('bg-gray-100 dark:bg-gray-600'); // Hapus sorotan
    });

    // Event drop
    dropArea.on('drop', function(event) {
        event.preventDefault();
        $(this).removeClass('bg-gray-100 dark:bg-gray-600'); // Hapus sorotan

        const files = event.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            fileInput.prop('files', files); // Tetapkan file yang dijatuhkan ke input
            const img = $(this).find('img[data-image="product_image"]');
            const reader = new FileReader();

            reader.onload = function() {
                img.attr('src', reader.result); // Tampilkan pratinjau gambar
                img.show(); // Tampilkan gambar
                $(dropArea).find('[data-noImage]').removeClass('flex').addClass('hidden'); // Sembunyikan placeholder
            };

            reader.readAsDataURL(files[0]); // Baca file sebagai URL data
        }
    });
})

