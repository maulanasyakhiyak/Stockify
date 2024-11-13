$("#import-btn").tooltip();
var csrfToken = $('meta[name="csrf-token"]').attr("content");
var originalUrl = $('meta[name="original"]').attr("content");

var animation = $('#animation-uploaded')
const anim = lottie.loadAnimation({
    container: animation.get(0), // Elemen target
    renderer: 'svg', // Tipe render: 'svg', 'canvas', atau 'html'
    loop: false, // Apakah animasi akan berulang
    autoplay: false, // Memulai animasi secara otomatis
    path: animation.data('json-animated')
});

$("[data-target-modal]").on("click", function () {
    var targetId = $(this).data("target-modal");
    $(`#${targetId}`).removeClass("hidden");
    setTimeout(() => {
        $(`#${targetId}`).removeClass(" bg-opacity-0");
        $(`#${targetId}`).addClass(" bg-opacity-50");
        $('[data-modal="body"]').addClass("active");
        $("body").addClass("overflow-hidden");
    }, 50);
});

$("[data-hide-modal]").on("click", function () {
    var targetId = $(this).data("hide-modal");
    $('[data-modal="body"]').removeClass("active");
    $(`#${targetId}`).removeClass(" bg-opacity-50");
    $(`#${targetId}`).addClass(" bg-opacity-0");
    setTimeout(() => {
        $(`#${targetId}`).addClass("hidden");
        $("body").removeClass("overflow-hidden");
    }, 500);
});

const firstlabelclass = $("label[for='import_csv']").attr('class');
$('[data-hide-modal="import-modal"]').on('click', function () {
    $("label[for='import_csv']").attr('class', firstlabelclass)
    $('#icon-import').removeClass('hidden')
    $('#no-file').removeClass('hidden')
    $('#uploaded').addClass('hidden')
    $('#filechange').addClass('hidden')
    $("#import_csv").val('')
})

$("[data-button-delete-selected]").on("click", function () {
    addDataToModal($(this).data("button-delete-selected"));
});

async function addDataToModal(target) {
    var $children = $(`#${target}`).find(".modal_body");

    let data = await getSelectedId(true);

    console.log($children);

    let html = "";

    $.each(data, function (index, item) {
        html += ` ${item.id}-${item.name}, `;
    });

    // Menghapus konten lama di modal_body
    $children.empty();
    $children.append(html);
}

// FILTER PAGE FUNCTION =========================================================================
$("#items_per_page").on("change", function () {
    $.ajax({
        url: "/change_paginate",
        method: "POST",
        data: {
            _token: csrfToken,
            paginate_change: $(this).val(),
        },
        success: function (res) {
            if (res["success"]) {
                window.location.reload();
            }
        },
    });
});

// FILTER FUNCTION =========================================================================
$("#filter_product").on("submit", function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: formData,
        success: function (response) {
            if (response.success) {
                location.replace(originalUrl);
            } else {
                toastr.error("error");
            }
        },
    });
});
// IMPORT DATA FUNCTION ==========================================================================
$("#import_csv").on("change", function () {
    const file = this.files[0];
    if (file && (file.name.endsWith(".csv") || file.name.endsWith(".xlsx") || file.name.endsWith(".xls"))) {
        $("#uploaded").addClass("hidden");
        $("#no-file").addClass("hidden");
        $("#file_name").html(file.name);
        $("#icon-import").removeClass("hidden");
        $("#filechange").removeClass("hidden");
        $("#submit-import-file").attr("disabled", false);
    } else {
        $("#no-file").removeClass("hidden");
        $("#file_name").empty();
        $("#filechange").addClass("hidden");
        $("#submit-import-file").attr("disabled", true);
    }
});

function succesForm() {
    $('#import_csv').val('')
    $('#uploading-file').addClass('hidden')
    $('#uploaded').removeClass('hidden')
    $('#button-cancel-upload').attr('disabled', true)
    anim.goToAndStop(0, true);
    anim.play()
}

function errorForm() {
    $("label[for='import_csv']").addClass('cursor-pointer')
    $("#uploading-file").addClass("hidden");
    $("#no-file").addClass("hidden");
    $("#icon-import").removeClass("hidden");
    $("#filechange").removeClass("hidden");
    $("#submit-import-file").attr("disabled", false);
    $("#import_csv").attr('disabled', false)
    $('label[for="import_csv"]').removeClass('border-sky-500')
    $('label[for="import_csv"]').addClass('border-red-500')
    $('label[for="import_csv"]').removeClass('bg-sky-50')
    $('label[for="import_csv"]').addClass('bg-white')
}

let xhr;
$("#form-import-file").on("submit", function (event) {
    event.preventDefault();
    const file = $("#import_csv")[0].files[0];
    importData(file, false, $(this).attr("action"))
    $('#no-file').addClass('hidden')
    $('#icon-import').addClass('hidden')
    $('#filechange').addClass('hidden')
    $('#uploading-file').removeClass('hidden')
    $("#import_csv").attr('disabled', true)
    $("#submit-import-file").attr('disabled', true)
    $("[data-hide-modal='import-modal']").attr('disabled', true)
    $("label[for='import_csv']").removeClass('cursor-pointer')


});

function importData(file = null, withconfirm = false, url) {
    let formData = new FormData();
    formData.append("_token", csrfToken);
    formData.append("file", file);
    if (withconfirm) {
        formData.append("confirm_add_category", true);
    }
    xhr = $.ajax({
        url: url, // Ganti dengan URL endpoint server Anda
        type: "POST",
        data: formData,
        processData: false, // Jangan proses data secara otomatis
        contentType: false, // Jangan atur contentType otomatis
        timeout: 30000,
        xhr: function () {
            let xhr = new window.XMLHttpRequest();
            // Update progress bar
            xhr.upload.addEventListener("progress", function (e) {
                if (e.lengthComputable) {
                    let percentComplete = (e.loaded / e.total) * 100;
                    console.log("Upload Progress:", Math.round(percentComplete) + "%");
                    $('#progress-bar-import-file').css('width', percentComplete + '%')
                    $('#progress-bar-import-file').text(Math.round(percentComplete) + "%")
                    if (Math.round(percentComplete) + "%" == '100%') {
                        $('#progress-bar-import-file').text('importing...')
                        $('#button-cancel-upload').attr('disabled', true)
                        $('.uploading_text').text('')
                    }
                    // $('#progress-container').show();
                    // $('#progress-bar').css('width', percentComplete + '%');
                    // $('#progress-percent').text(Math.round(percentComplete) + '%');
                }
            });
            return xhr;
        },
        success: function (response) {
            if (response.status == 'pending') {
                console.log(response.newCategory);
                console.log(url);

                if (confirm('ada category baru tambahkan?')) {
                    var newData = new FormData();
                    newData.append('addNewCategory', true);
                    newData.append('newCategory', JSON.stringify(response.newCategory));
                    $.ajax({
                        url: url,
                        type: 'POST',
                        processData: false, // Jangan proses data secara otomatis
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: newData,
                        success: function (result) {
                            if (result.status == 'debug') {
                                console.log(result.data);
                            }
                            if (result.status == 'fail') {
                                console.log(result.error);
                            } else if (result.status == 'success') {
                                toastr.success(`${result.added} data added, ${result.updated} data updated`)
                                succesForm();
                                setTimeout(() => {
                                    window.location.reload()
                                }, 3000);
                            }

                        },
                        error: function (xhr, status, error) {
                            toastr.error(`Terjadi kesalahan saat memproses konfirmasi,${error}`);
                        }
                    });
                } else {
                    // Jika pengguna memilih "tidak", hentikan proses lebih lanjut
                    toastr.info('Proses impor dibatalkan.');
                    return;  // Menghentikan eksekusi lebih lanjut
                }
            }
            if (response.status == 'debug') {
                console.log(response.data);
            }
            if (response.status == 'success') {
                toastr.success(`${response.added} data added, ${response.updated} data updated`)
                succesForm();
                setTimeout(() => {
                    window.location.reload()
                }, 3000);
            } else if (response.status == 'fail') {
                console.log(response.error);
                errorForm()
            }


        },
        error: function (xhr, status, error) {

            if (status === 'timeout') {
                console.log('Request timed out.');
                toastr.error('The request has timed out. Please try again later.');
                errorForm()
            } else {
                console.log('Error:', error);
                toastr.error('An error occurred while processing the request.');
            }
        }
    });
}
$('#button-cancel-upload').on('click', function () {
    if (xhr) {
        xhr.abort();
        $("label[for='import_csv']").addClass('cursor-pointer')
        $("#uploading-file").addClass("hidden");
        $("#no-file").addClass("hidden");
        $("#icon-import").removeClass("hidden");
        $("#filechange").removeClass("hidden");
        $("#submit-import-file").attr("disabled", false);
        $("#import_csv").attr('disabled', false)
    }
})
// PREVIEW IMAGE FUNCTION =========================================================================
$("input[data-file]").on("change", function () {
    const file = this.files[0];

    var target = $(this).attr("id");
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $(`[data-image=${target}]`).attr("src", e.target.result).show();
            $(`[data-noImage=${target}]`).removeClass("flex").addClass("hidden");
        };
        reader.readAsDataURL(file);
    } else {
        $(`[data-noImage=${target}]`).removeClass("hidden").addClass("flex");
        $(`[data-image=${target}]`).hide();
    }
});

// CHECKALL FUNCTION=============================================================================

$('[data-checkbox_all="true"]').on("change", function () {
    var checkedItems = [];
    var uncheckedItems = [];

    if ($(this).prop("checked")) {
        $("[data-checkbox_item]").each(function () {
            checkedItems.push($(this).data("checkbox_item"));
        });
    } else {
        $("[data-checkbox_item]").each(function () {
            uncheckedItems.push($(this).data("checkbox_item"));
        });
    }
    // Kirim data yang dicentang
    if (checkedItems.length > 0) {
        $.ajax({
            type: "POST",
            url: "/record-checkbox",
            data: {
                _token: csrfToken,
                checkedItems: checkedItems, //[1,2,3,4]
            },
            success: function (response) {
                if (response.success) {
                    checkedItems.forEach(function (item) {
                        $(`[data-checkbox_item=${item}]`).prop("checked", true);
                    });
                    ifHereSelected();
                } else {
                    toastr.error("Error processing checked items");
                }
            },
            error: function () {
                toastr.error("Error sending data");
            },
        });
    }

    // Kirim data yang tidak dicentang
    if (uncheckedItems.length > 0) {
        $.ajax({
            type: "POST",
            url: "/record-checkbox",
            data: {
                _token: csrfToken,
                uncheckedItems: uncheckedItems,
            },
            success: function (response) {
                if (response.success) {
                    uncheckedItems.forEach(function (item) {
                        $(`[data-checkbox_item=${item}]`).prop("checked", false);
                    });
                    ifHereSelected();
                } else {
                    toastr.error("Error processing unchecked items");
                }
            },
            error: function () {
                toastr.error("Error sending data");
            },
        });
    }
    // checkallselected()
});

function getSelectedId(data = false) {
    if (data === true) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: "/get-selected-id",
                data: {
                    _token: csrfToken,
                    withData: true,
                },
                success: function (response) {
                    if (response.success) {
                        resolve(response.data);
                    } else {
                        toastr.error("Error processing unchecked items");
                        reject("Error processing unchecked items");
                    }
                },
                error: function () {
                    toastr.error("Error sending data");
                    reject("Error sending data");
                },
            });
        });
    } else {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: "/get-selected-id",
                success: function (response) {
                    if (response.success) {
                        resolve(response.data); // Jika berhasil, resolve dengan data
                    } else {
                        toastr.error("Error processing unchecked items");
                        reject("Error processing unchecked items");
                    }
                },
                error: function () {
                    toastr.error("Error sending data");
                    reject("Error sending data");
                },
            });
        });
    }
}

function checkallselected() {
    var allChecked = true;

    $("[data-checkbox_item]").each(function () {
        if (!$(this).prop("checked")) {
            allChecked = false;
        }
    });

    $("#checkbox-all-product").prop("checked", allChecked);
}

async function ifHereSelected() {
    var hidden = true;
    const data = await getSelectedId();
    $("[data-attr='selected-data']").text(data);
    if (data > 0) {
        hidden = false;
        $("#export_selected").removeClass("pointer-events-none text-gray-300 dark:text-gray-500");
        $("#export_selected").addClass("text-gray-700 dark:text-gray-300");
    } else {
        $("#export_selected").removeClass("text-gray-700 dark:text-gray-300");
        $("#export_selected").addClass("pointer-events-none text-gray-300 dark:text-gray-500");
    }
    $("#delete_selected").prop("disabled", hidden);
}

// CHECK FUNCTION
$("[data-checkbox_item]").on("change", function () {
    if ($(this).prop("checked")) {
        $.ajax({
            type: "POST",
            url: "/record-checkbox",
            data: {
                _token: csrfToken,
                checkedItems: [$(this).data("checkbox_item")],
            },
            success: function (response) {
                if (response.success) {
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error("Error sending data");
            },
        });
    } else {
        $.ajax({
            type: "POST",
            url: "/record-checkbox",
            data: {
                _token: csrfToken,
                uncheckedItems: [$(this).data("checkbox_item")],
            },
            success: function (response) {
                if (response.success) {
                } else {
                    toastr.error("Error processing unchecked items");
                }
            },
            error: function () {
                toastr.error("Error sending data");
            },
        });
    }
    ifHereSelected();
    checkallselected();
});

// FITUR SEARCH ---------------------------------------------------------------------------------------------------------
$("#products-search").on("enter", function () { });

$(function () {
    checkallselected();
    ifHereSelected();
    const dropArea = $("label[data-dropfile]");
    // Ambil ID dari input file dari atribut data
    const fileInputId = dropArea.data("dropfile");
    const fileInput = $("#" + fileInputId); // Gunakan ID untuk mendapatkan elemen input file
    // Event drag over
    dropArea.on("dragover", function (event) {
        event.preventDefault();
        $(this).addClass("bg-gray-100 dark:bg-gray-600"); // Sorot area
    });

    // Event drag leave
    dropArea.on("dragleave", function () {
        $(this).removeClass("bg-gray-100 dark:bg-gray-600"); // Hapus sorotan
    });

    // Event drop
    dropArea.on("drop", function (event) {
        event.preventDefault();
        $(this).removeClass("bg-gray-100 dark:bg-gray-600"); // Hapus sorotan

        const files = event.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            fileInput.prop("files", files); // Tetapkan file yang dijatuhkan ke input
            const img = $(this).find('img[data-image="product_image"]');
            const reader = new FileReader();

            reader.onload = function () {
                img.attr("src", reader.result); // Tampilkan pratinjau gambar
                img.show(); // Tampilkan gambar
                $(dropArea)
                    .find("[data-noImage]")
                    .removeClass("flex")
                    .addClass("hidden"); // Sembunyikan placeholder
            };

            reader.readAsDataURL(files[0]); // Baca file sebagai URL data
        }
    });
});
