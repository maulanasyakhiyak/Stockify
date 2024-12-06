import {addDataToModal, checkallselected, ifHereSelected} from '../admin/data-product'

var csrfToken = $('meta[name="csrf-token"]').attr("content");
var originalUrl = $('meta[name="original"]').attr("content");

const firstlabelclass = $("label[for='import_csv']").attr("class");

$('[data-hide-modal="import-modal"]').on("click", function () {
    $("label[for='import_csv']").attr("class", firstlabelclass);
    $("#icon-import").removeClass("hidden");
    $("#no-file").removeClass("hidden");
    $("#uploaded").addClass("hidden");
    $("#filechange").addClass("hidden");
    $("#import_csv").val("");
});

$("[data-button-delete-selected]").on("click", function () {
    addDataToModal($(this).data("button-delete-selected"));
});

// .New atribut form
$("[data-add-atribute-target]").on("click", function () {
    const targetEle = $(this).data('add-atribute-target')
    var target = $(`#${targetEle}`)
    var indexEle = target.find('[data-atribute-form]').last();
    var index = indexEle.data('atribute-index') + 1;
    console.log(index);

    var html = `<div data-atribute-form=${index} data-atribute-index="${index}" class="mt-2 relative w-full flex overflow-hidden bg-white border divide-x-2 divide-solid dark:divide-gray-500 border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <div class="atribute">
                        <input type="text" name="atributes[${index}][name]" class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white" placeholder="Nama">
                    </div>
                    <div class="value">
                        <input type="text" name="atributes[${index}][value]" class="border-none focus:ring-0 p-2 placeholder:text-sm w-28 bg-white text-gray-900 dark:bg-gray-700 dark:text-white" placeholder="Val (optional)">
                    </div>
                    <button type="button" data-remove-atribute-form=${index} data-atribute-parent="${targetEle}"
                    class="flex items-center justify-center flex-grow text-gray-900 dark:text-white disabled:text-gray-300 dark:disabled:text-gray-500 dark:hover:text-red-500 hover:text-red-500">
                        <i class="fa-solid fa-minus "></i>
                    </button>
                </div>`;
    target.append(html);
});

$(document).on('click', 'button[data-remove-atribute-form]', function () {
    var parent = $(this).data("atribute-parent");
    var id = $(this).data("remove-atribute-form");
    $(`[data-atribute-form=${id}]`).remove();
    $(`#${parent}`).find("[data-atribute-form]").each(function (index) {
        $(this).attr("data-atribute-index", index);
        $(this).attr("data-atribute-form", index);
        $(this).find(".atribute").attr("name", `atributes[${index}][name]`);
        $(this).find(".value input").attr("name", `atributes[${index}][value]`);
    })
});

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
                window.location.reload();
            } else {
                toastr.error("error");
            }
        },
    });
});
// IMPORT DATA FUNCTION ==========================================================================
$("#import_csv").on("change", function () {
    const file = this.files[0];
    if (
        file &&
        (file.name.endsWith(".csv") ||
            file.name.endsWith(".xlsx") ||
            file.name.endsWith(".xls"))
    ) {
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

let xhr;
$("#form-import-file").on("submit", function (event) {
    event.preventDefault();
    const file = $("#import_csv")[0].files[0];
    importData(file, false, $(this).attr("action"));
    $("#no-file").addClass("hidden");
    $("#icon-import").addClass("hidden");
    $("#filechange").addClass("hidden");
    $("#uploading-file").removeClass("hidden");
    $("#import_csv").attr("disabled", true);
    $("#submit-import-file").attr("disabled", true);
    $("[data-hide-modal='import-modal']").attr("disabled", true);
    $("label[for='import_csv']").removeClass("cursor-pointer");
});

$("#button-cancel-upload").on("click", function () {
    if (xhr) {
        xhr.abort();
        $("label[for='import_csv']").addClass("cursor-pointer");
        $("#uploading-file").addClass("hidden");
        $("#no-file").addClass("hidden");
        $("#icon-import").removeClass("hidden");
        $("#filechange").removeClass("hidden");
        $("#submit-import-file").attr("disabled", false);
        $("#import_csv").attr("disabled", false);
    }
});
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

