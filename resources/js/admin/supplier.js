import Inputmask from "inputmask";
document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll("input[ data-input='phone-mask']");
    var phoneMaskOption = {
        mask: "(+99)999 9999 9999",
        showMaskOnFocus: true,
    };
    Inputmask(phoneMaskOption).mask(inputs);  
});
$('[data-drawer-target]').on('click', function(){
    console.log('clicked');
});
$('[data-submit-target]').on('click', function(){
    const target = $(this).data('submit-target')
    $(`#${target}`).trigger('submit')
});
