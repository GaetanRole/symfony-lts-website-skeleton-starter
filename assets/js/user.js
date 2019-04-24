import $ from 'jquery';
import '../scss/user.scss';

$(document).ready(function () {
    // Testing
    $('[data-toggle="popover"]').popover();
    console.log('User script well imported !');
});
