(function($){
    $('.item-quantity').on('change', function(e) {
        $.ajax({
            url: "/cart/" + $(this).data('id'),
            method: 'put',
            data: {
                quantity: $(this).val(),
                _token: csrf_token // Assuming csrf_token is defined elsewhere
            }
        });
    });
})(jQuery);