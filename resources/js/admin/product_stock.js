import Inputmask from "inputmask";

const im = new Inputmask({
  alias: "numeric", // Mask untuk input angka
  digits: 0, // Tidak ada desimal
  rightAlign: false, // Angka rata kiri
  allowMinus: false, // Tidak mengizinkan angka negatif
  placeholder: "", // Tidak ada placeholder
});

im.mask($("input[data-max-input]"));

var originalValue = ''
$(document).on("focus", "input[data-minimal-stock]", function () {
    originalValue = $(this).val()
});
$(document).on("input", "input[data-minimal-stock]", function () {
    var id = $(this).data('minimal-stock');
    var $input = $(this)
    var $button = $(`#button-minimal-stock-${id}`);
    var $form = $(`#update-minimal-stock-${id}`);
    $button.attr('disabled', $(this).val() === originalValue);
    $button.on("mousedown", function (e) {
        e.preventDefault(); // Mencegah kehilangan fokus
    });
    $(this).on("blur", function () {
        $(this).val(originalValue);
        $button.attr('disabled', true);
    });

    $form.on('submit', function(e){
        e.preventDefault()
        $('<input>', {
            type: 'hidden',
            name: 'new_minimum_stock',
            value: $input.val()
        }).appendTo(this);
        e.target.submit();
    })
});


// Log ini akan muncul segera setelah script dijalankan
console.log("tes");
