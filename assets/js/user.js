// The better option is to use addEntry() to point to a JavaScript file,
// then require the CSS needed from inside of that.
import $ from 'jquery';
import '../css/user.scss';

$(document).ready(function() {
    // Bootstrap JS
    $('[data-toggle="popover"]').popover();

    // Using others into this one
    console.log('User script well imported !');
});