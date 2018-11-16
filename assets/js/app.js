// The better option is to use addEntry() to point to a JavaScript file,
// then require the CSS needed from inside of that.
import '../css/app.scss';

// Import Jquery.js, Bootstrap.js and font-awesome.js from NPM modules
import $ from 'jquery';
import 'bootstrap'
import '@fortawesome/fontawesome-free'

// Example importing a function from greet.js
// (the .js extension is optional)
import greet from './greet';

const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

$(document).ready(function() {
    // Bootstrap JS
    $('[data-toggle="popover"]').popover();

    // Using others into this one
    console.log(greet('Github User'));
});