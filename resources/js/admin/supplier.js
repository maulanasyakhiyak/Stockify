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
})

$('[data-submit-target]').on('click', function(){
    const target = $(this).data('submit-target')
    $(`#${target}`).trigger('submit')
})


// $("[data-form-update]").on('submit',function(e){
//     $('input').removeClass('border-red-500')
//     e.preventDefault(); // Mencegah form submit otomatis
//     var formData = $(this).serialize();
//     console.log(formData);

//     $.ajax({
//         type:'post',
//         url:$(this).attr('action'),
//         data:formData,
//         success: function(response){
//             if(response.success){
//                 console.log('success');
//             }else{
//                 console.log(response.data);
//                 for (var field in response.errors) {
//                     if (response.errors.hasOwnProperty(field)) {
//                         // Mengakses array error dan menampilkan setiap pesan
//                         response.errors[field].forEach(function(error) {
//                             // Menambahkan kelas 'border-red-500' pada input field berdasarkan ID yang unik
//                             $(`#${field}-${response.id}`).addClass('border-red-500')
//                             $(`#message-${field}-${response.id}`).text(error);
//                         });
//                     }
//                 }


//             }
//         }
//     })

// })
