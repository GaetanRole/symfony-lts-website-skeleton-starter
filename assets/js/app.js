// The better option is to use addEntry() to point to a JavaScript file,
// then require the CSS needed from inside of that.
import '../scss/app.scss';

// Import Jquery.js, Bootstrap.js and font-awesome.js from NPM modules
import $ from 'jquery';
import 'bootstrap'
import '@fortawesome/fontawesome-free'

// Example importing a function from greet.js
// (the .js extension is optional)
import greet from './greet';

$(document).ready(function () {
    // Bootstrap JS dependency
    $('[data-toggle="popover"]').popover();

    // Always show Bootstrap modal for flash messages
    $('.modal').modal('show');

    // Using others into this one
    console.log(greet('Github User'));
});
