document.addEventListener('DOMContentLoaded', () => {
    const startDateInput = document.getElementById('datepicker-start');
    const endDateInput = document.getElementById('datepicker-end');

    $('#datepicker-end').attr('disabled', true)

    const startPicker = new Datepicker(startDateInput, {
        autohide: true,
        format: 'yyyy-mm-dd',
        orientation: 'bottom'
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
    });
})

$('#simple-search-filter').autocomplete({
    source: function(request,response){
        $.ajax({
            url:'/admin/simple-search',
            dataType:'json',
            data:{
                table:"",
                term:request.term
            },
            success: function(data){
                var results = data.map(function(item) {
                    return {
                        label: item.kode_dosen + " - " + item.name, // Menampilkan kode_dosen dan nama
                        value: item.kode_dosen // Nilai yang akan disimpan di input
                    };
                });
                response(results);
            }
        })
    },
    minLength: 2
})

$('[data-filter-collapse]').each(function(){
    $(this).on('click', function(){
        $(this).toggleClass('bg-blue-50 text-blue-400');
        $(`#${$(this).data('filter-collapse')}`).toggleClass('hidden');
        var otherElements = $('[data-filter-collapse]').not(this);
        
        otherElements.each(function() {
            $(this).removeClass('bg-blue-50 text-blue-400');
            if(!$(`#${$(this).data('filter-collapse')}`).hasClass('hidden')){
                $(`#${$(this).data('filter-collapse')}`).addClass('hidden')
            }
        });
        
    })
})


