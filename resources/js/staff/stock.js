$('[data-form]').on('submit' ,function(e){
    e.preventDefault()
    if($(this).data('form') == 'accept'){
        if (confirm("Apakah Anda yakin untuk menerima transaksi ini?")) {
            e.target.submit()
        }
    }else if($(this).data('form') == 'reject'){
        if (confirm("Apakah Anda yakin untuk menolak transaksi ini?")) {
            e.target.submit()
        }
    }
})