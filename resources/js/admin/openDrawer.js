import  { Drawer, initDrawers } from 'flowbite';

const $targetEl = document.getElementById(`drawer-update-product-${ id }`);


const drawer = new Drawer($targetEl,DrawerOptions);

drawer.show()
