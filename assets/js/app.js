// The better option is to use addEntry() to point to a JavaScript file,
// then require the CSS needed from inside of that.
import '../scss/app.scss';

// Import Jquery.js, Bootstrap.js and font-awesome.js from NPM modules
import $ from 'jquery';
import { Modal, Popover } from 'bootstrap';
import '@fortawesome/fontawesome-free';

// Example importing a function from greet.js
// (the .js extension is optional)
import greet from './greet';

// Import stimulus booting script
import './stimulus/stimulus-boot.js';

$(document).ready(function () {
    // Use Modals from Bootstrap 5 with Webpack Encore. Enabled it everywhere.
    if (document.getElementById('modal') != null) {
        let myModal = new Modal(document.getElementById('modal'));
        myModal.show();
    }

    // Use Popover from Bootstrap 5 with Webpack Encore. Enabled it everywhere.
    let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    let popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new Popover(popoverTriggerEl);
    });

    // Using others into this one
    console.log(greet('Github User'));
});
