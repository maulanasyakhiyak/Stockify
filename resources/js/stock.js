var csrfToken = $('meta[name="csrf-token"]').attr("content");
var originalUrl = $('meta[name="original"]').attr("content");

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
                window.location.reload();
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
                table: "2c6ee24b09816a6f14f95d1698b24ead",
                term: request.term
            },
            success: function (data) {
                var results = data.map(function (item) {
                    return {
                        label: item.name, // Nilai yang akan disimpan di input
                    };
                });
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

