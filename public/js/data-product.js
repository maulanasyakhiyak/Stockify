$("#import-btn").tooltip();
var csrfToken = $('meta[name="csrf-token"]').attr("content");
var originalUrl = $('meta[name="original"]').attr("content");

async function addDataToModal(target) {
  var $children = $(`#${target}`).find(".modal_body");

  let data = await getSelectedId(true);

  console.log($children);
  

  let html = "";

  $.each(data, function(index, item) {
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
  console.log(data);
  if (data > 0) {
    hidden = false;
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

// Document Ready Function

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
