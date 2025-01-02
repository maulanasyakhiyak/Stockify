import '../filterstock'
import { searchAutocomplete } from '../fitur'

var options = {searching : 'sku'}
const filterSearch = new searchAutocomplete($('#product_sku'),options).itemOnClick(function(item){
    $('#product_sku').val(item.sku)
})