import { DateRangePicker } from "flowbite-datepicker";
import { Dropdown } from "flowbite";
import '../filterstock'

$(function(){
    new DateRangePicker($('#date-range-picker').get(0),{
        autohide: true,
        format: 'd-M-yyyy',
    })
    new Dropdown($('#dropdown-filter-stock').get(0),$('#dropdown-filter-stock-button').get(0),{
        ignoreClickOutsideClass: 'datepicker',
        onHide: () => {
            $('#date-range-picker input').val('')
            $('#category').val(' ')
        },
    })
})