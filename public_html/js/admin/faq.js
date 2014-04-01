$(document).ready(function () {
    $('.edit').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.faq');

        $container.find('.edit-faq').show();
        $container.find('.show-faq').hide();
    });

    $('.edit-faq [type=reset]').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.faq');

        $container.find('.edit-faq').hide();
        $container.find('.show-faq').show();
    });

    $('.delete').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.faq');

        if (confirm('Вы действительно хотите удалить этот FAQ?'))
            $container.find('form[name=delete]').submit();
    });

    $('#create-new').click(function() {
        $(this).hide();
        $('form[name=new]').show();
    });

    $('form[name=new] [type=reset]').click(function() {
        $('#create-new').show();
        $('form[name=new]').hide();
    });
});