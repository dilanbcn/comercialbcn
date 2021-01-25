$(function() {
    $('.form-prevent-multiple-submits').on('submit', function(e) {
        $('.button-prevent-submit').prop('disabled', true);
        $('.spinner').show();
    });
});