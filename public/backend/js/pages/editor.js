// [editor Javascript]
// Project: Sunny Admin - Responsive Admin Template
// Primary use: Used only for the wysihtml5 / CKEditor

$(function () {
    "use strict";

    // Ganti editor1 jika ada
    if ($("#editor1").length) {
        CKEDITOR.replace('editor1');
    }

    // Ganti editor2 jika ada
    if ($("#editor2").length) {
        CKEDITOR.replace('editor2');
    }

    // Inisialisasi textarea dengan WYSIHTML5 jika ada class .textarea
    if ($('.textarea').length) {
        $('.textarea').wysihtml5();
    }
});
