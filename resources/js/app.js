
import 'flowbite';
import './toastr';
import './bootstrap';
import './sidebar';
import './charts';
import './dark-mode';
import './modal.js';
import './stock.js'
// import './stock-opname.js'

document.querySelectorAll('.no-enter').forEach(function(input) {
    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Mencegah aksi default tombol Enter
        }
    });
});









