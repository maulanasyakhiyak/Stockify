import Inputmask from "inputmask";

var csrfToken = $('meta[name="csrf-token"]').attr("content");
var originalUrl = $('meta[name="original"]').attr("content");

$("[data-tab]").on("click", function () {
  $("[data-tab]").each(function () {
    $(this).removeClass(
      "inline-block cursor-pointer p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500 active"
    );
    $(this).addClass(
      "inline-block cursor-pointer p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
    );
    var hideContent = $(this).data("tab");
    $(`#${hideContent}`).addClass("hidden");
  });
  $(this).removeClass(
    "inline-block cursor-pointer p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
  );
  $(this).addClass(
    "inline-block cursor-pointer p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500 active"
  );
  var showContent = $(this).data("tab");
  $(`#${showContent}`).removeClass("hidden");
});

var exceptSearch = [];

$("#stock-opname-search").on("input", function () {
  var term = $(this).val();

  // Memeriksa apakah input sudah ada nilainya
  if (term.length < 2) {
    $("#autocomplete-results").empty(); // Mengosongkan hasil jika input kurang dari 2 karakter
    return;
  }

  $.ajax({
    url: "/admin/simple-search",
    dataType: "json",
    data: {
      table: "2d2d2c4b9e1d2f6f2bcd345b223ee6d4",
      term: term,
    },
    success: function (data) {
      // Menampilkan hasil debug (opsional)
      if (data.debuging) {
        console.log(data.debuging);
      }
      $("#autocomplete-results").empty();

      // Mengecek apakah ada data yang dikembalikan
      if (data.data && data.data.length > 0) {
        // Membuat list hasil pencarian
        var results = data.data.map(function (item) {
          if (!exceptSearch.includes(item.id)) {
            return `
                            <li data-autocomplete-id="${item.id}" data-autocomplete-name="${item.name}" data-autocomplete-sku="${item.sku}"
                                class="p-2 bg-white hover:bg-blue-300 cursor-pointer dark:text-gray-300 dark:hover:bg-gray-700 flex justify-between">
                                ${item.name} <span>${item.sku}</span>
                            </li>
                        `;
          }
        });

        // Menambahkan hasil ke dalam ul
        $("#autocomplete-results").append(results.join(""));

        // Menampilkan hasil
        $("#autocomplete-results").show();
      } else {
        console.log("No results found");
      }
    },
    error: function () {
      console.log("Error during AJAX request");
    },
  });
});

function detectInputProduct() {
  const disabled =
    !$("[data-input-stock-id]")
      .toArray()
      .some((input) => $(input).val()) || !$("#keterangan-opname").val();
  $("[data-button-start-opname]").prop("disabled", disabled);
}

var maskOptions = {
  alias: "numeric",
  min: 0,
  max: 100000,
  rightAlign: false,
};

$(document).on("click", "[data-autocomplete-id]", function () {
  var selectedId = $(this).data("autocomplete-id");
  var selectedSKU = $(this).data("autocomplete-sku");
  var selectedName = $(this).data("autocomplete-name");
  $("#stock-opname-search").val("");
  $("#autocomplete-results").empty().hide();

  var html = `<tr data-row-id="${selectedId}" class="bg-white dark:bg-gray-800 dark:border-gray-700 divide-x-2 divide-gray-200 dark:divide-gray-700">
                                    <th scope="row"
                                        class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        ${selectedName}
                                    </th>
                                    <td class="p-2">
                                        ${selectedSKU}
                                    </td>
                                    <td class="p-2">
                                         <input type="text" data-input-stock-id="${selectedId}" id="${selectedId}" name="stockopname[${selectedId}]" placeholder="0" class="w-full border-none focus:ring-0 py-1 px-2 placeholder:text-sm bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="p-2">
                                        <div class="flex items-center justify-center">
                                        <button class="" data-delete-row-stock-opname="${selectedId}">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        </div>
                                    </td>
                                </tr>`;

  $("#item-search-append").append(html);
  Inputmask(maskOptions).mask($(`#${selectedId}`));
  $("#search-info").addClass("hidden");
  $("#product-list-result").removeClass("hidden");
  exceptSearch.push(selectedId);
  detectInputProduct();
});

$(document).on("click", "[data-delete-row-stock-opname]", function () {
  var id = $(this).data("delete-row-stock-opname");
  exceptSearch = exceptSearch.filter((index) => index !== id);
  if ($("[data-delete-row-stock-opname]").length > 1) {
    $(`[data-row-id="${id}"]`).remove();
  } else {
    $(`[data-row-id="${id}"]`).remove();
    $("#search-info").removeClass("hidden");
    $("#product-list-result").addClass("hidden");
  }
  detectInputProduct();
});

$(document).on(
  "input",
  "[data-input-stock-id] , #keterangan-opname",
  function () {
    detectInputProduct();
  }
);

$("[data-button-start-opname]").on("click", function () {
  
  var dataOpname = [];
  $("input[data-input-stock-id]").each(function () {
    var inputValue = $(this).val();
    var inputId = $(this).data("input-stock-id");
    dataOpname.push({
      id: inputId,
      value: inputValue,
    });
  });
  
  $.ajax({
    type: "POST",
    url: "/admin/stok/product-stock/opname",
    data: {
      _token: csrfToken,
      data: dataOpname,
      keterangan: $("#keterangan-opname").val(),
    },
    success: function (response) {
      if (response.status == "debuging") {
        console.log(response.message);
      }
      if (response.status == "success") {
        console.log(response.data);
        window.location.replace(response.url);
      }
      if (response.status == "error") {
        $("#alert-opname").removeClass("hidden");
        $("#error-message-opname").text(response.message);
        $("#button-start-opname").attr("disabled", true);
      }
    },
  });
});

$("#upload-opname-csv").on("change", function () {
  $("#item-csv-append").empty();
  var $this = $(this);
  $("#product-list-result-csv").addClass("hidden");
  $("#loading-csv-opname").removeClass("hidden");
  $this.attr("disabled", true);
  var file = this.files[0];
  var formData = new FormData();
  formData.append("file-opname-csv", file);
  formData.append("_token", csrfToken);
  $.ajax({
    type: "POST",
    url: "/admin/stok/product-stock/opname-withcsv",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      if (response.status == "success") {
        console.log(response.message);
        $.each(response.data, function (index, dat) {
          
          var row = $(
            `<tr data-row-id="${dat.id}" class="bg-white dark:bg-gray-800 dark:border-gray-700 divide-x-2 divide-gray-200 dark:divide-gray-700">`
          );
          row.append(
            `<th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"> ${dat.name} </th>`
          );
          row.append(
            `<th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"> ${dat.sku} </th>`
          );
          row.append(
            `<td class="p-2"> <input type="text" data-input-stock-id="${dat.id}" value="${dat.value}" id="${dat.id}" name="stockopname[${dat.id}]" readonly class="w-full border-none focus:ring-0 py-1 px-2 placeholder:text-sm bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white"></td>`
          );
          if( dat.error == 'Not Found'){
            var row = $(
              `<tr  class="bg-white border-y dark:bg-gray-800 dark:border-gray-700 divide-x-2 divide-gray-200 dark:divide-gray-700">`
            );
            row.append(
              `<td class="p-2 text-center" colspan='3'>
              <span class="inline-flex w-1/3 items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        ${dat.error} ( <span class="font-thin">${dat.message}</span> )
                                    </span>
               
               </td>`
            );
          }
          $("#item-csv-append").append(row);
        });
        detectInputProduct();
        $this.attr("disabled", false);
        $("#loading-csv-opname").addClass("hidden");
        $("#product-list-result-csv").removeClass("hidden");
      }
      if(response.status == "error") {
        $this.attr("disabled", false);
        $("#loading-csv-opname").addClass("hidden");
        $("#item-csv-append").empty();
        toastr.error(response.message)
      }
    },
  });
  setTimeout(function () {}, 3000);
});
