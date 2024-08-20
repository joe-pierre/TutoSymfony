/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import $ from 'jquery';

// Import Select2 with relative path
import 'select2/dist/js/select2.min.js';

// Import Select2 CSS
import 'select2/dist/css/select2.min.css';

// Import Bootstrap 5 theme for Select2
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css';

// Set Select2 Bootstrap 5 theme
$(function () {
    $('select').select2({
        theme: 'bootstrap-5'
    });    
})