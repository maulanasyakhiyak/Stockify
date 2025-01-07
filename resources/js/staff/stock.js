import '../filterstock'

function add_input(idElement,appendTo){
    var target = $(`#${idElement}`);
    target.appendTo(appendTo);
}

$('[data-form]').on('submit', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    const formType = $(this).data('form');
    const confirmationMessage = formType === 'accept' 
        ? "Apakah Anda yakin untuk menerima transaksi ini?" 
        : "Apakah Anda yakin untuk menolak transaksi ini?";
    if (confirm(confirmationMessage)) {
        const notes = $(`#notes-transaction-${id}`).val();
        $('<input>', {
            type: 'hidden',
            name: 'notes',
            value: notes
        }).appendTo(this);
        e.target.submit();
    }
});