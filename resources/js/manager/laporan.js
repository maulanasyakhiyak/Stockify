import { DateRangePicker } from "flowbite-datepicker";
import { Dropdown } from "flowbite";
const today = new Date();
        const startDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7); // 7 hari yang lalu
        const endDate = today
$(function(){
    new DateRangePicker($('#date-range-picker').get(0),{
        autohide: true,
        format: 'd-M-yyyy',
        defaultDate:  {
            from: startDate,
            to: endDate
        },
    })
    new Dropdown($('#dropdown-filter-stock').get(0),$('#dropdown-filter-stock-button').get(0),{
        ignoreClickOutsideClass: 'datepicker',  
    })
    $(document).on('click', '#reset_period', function(){
        $('#date-range-picker input').val('')
    })
})