$('[data-tab]').on('click', function () {
    $('[data-tab]').each(function () {
        $(this).removeClass('inline-block cursor-pointer p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500 active')
        $(this).addClass('inline-block cursor-pointer p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300')
        var hideContent = $(this).data('tab')
        $(`#${hideContent}`).addClass('hidden')
    })
    $(this).removeClass('inline-block cursor-pointer p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300')
    $(this).addClass('inline-block cursor-pointer p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg dark:text-blue-500 dark:border-blue-500 active')
    var showContent = $(this).data('tab')
    $(`#${showContent}`).removeClass('hidden')
})

var exceptSearch = []

$('#stock-search').on('input', function () {
    var term = $(this).val();

    // Memeriksa apakah input sudah ada nilainya
    if (term.length < 2) {
        $('#autocomplete-results').empty(); // Mengosongkan hasil jika input kurang dari 2 karakter
        return;
    }

    $.ajax({
        url: '/admin/simple-search',
        dataType: 'json',
        data: {
            table: '2d2d2c4b9e1d2f6f2bcd345b223ee6d4',
            term: term
        },
        success: function (data) {
            // Menampilkan hasil debug (opsional)
            if (data.debuging) {
                console.log(data.debuging);
            }
            $('#autocomplete-results').empty();

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
                $('#autocomplete-results').append(results.join(''));

                // Menampilkan hasil
                $('#autocomplete-results').show();
            } else {
                console.log('No results found');
            }
        },
        error: function () {
            console.log('Error during AJAX request');
        }
    });
});

function detectInputProduct(){
    if($('[data-input-stock-id]').length < 1){
        $('#button-start-opname').attr('disabled', true)
    }
    $('[data-input-stock-id]').each(function(){
        if($(this).val()){
            $('#button-start-opname').attr('disabled', false)
        }else{
            $('#button-start-opname').attr('disabled', true)
        }
    })
}

$(document).on('click', '[data-autocomplete-id]', function () {
    var selectedId = $(this).data('autocomplete-id');
    var selectedSKU = $(this).data('autocomplete-sku');
    var selectedName = $(this).data('autocomplete-name');
    $('#autocomplete-results').empty().hide();

    var html = `<tr data-row-id="${selectedId}" class="bg-white dark:bg-gray-800 dark:border-gray-700 divide-x-2 divide-gray-200 dark:divide-gray-700">
                                    <th scope="row"
                                        class="p-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        ${selectedName}
                                    </th>
                                    <td class="p-2">
                                        ${selectedSKU}
                                    </td>
                                    <td class="p-2">
                                         <input type="text" data-input-stock-id="${selectedId}" name="stock-opname-${selectedId}" placeholder="0" class="w-full border-none focus:ring-0 py-1 px-2 placeholder:text-sm bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="p-2">
                                        <div class="flex items-center justify-center">
                                        <button class="" data-delete-row-stock-opname="${selectedId}">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        </div>
                                    </td>
                                </tr>`

    $('#item-search-append').append(html)
    $('#search-info').addClass('hidden');
    $('#product-list-result').removeClass('hidden');
    exceptSearch.push(selectedId);
    detectInputProduct()
});

$(document).on('click','[data-delete-row-stock-opname]', function(){
    var id = $(this).data('delete-row-stock-opname')
    exceptSearch = exceptSearch.filter(index => index !== id);
    if($('[data-delete-row-stock-opname]').length > 1){
        $(`[data-row-id="${id}"]`).remove()
    }else{
        $(`[data-row-id="${id}"]`).remove()
        $('#search-info').removeClass('hidden');
        $('#product-list-result').addClass('hidden');
    }
    detectInputProduct()

})

$(document).on('input','[data-input-stock-id]', function(){
    detectInputProduct()
})


