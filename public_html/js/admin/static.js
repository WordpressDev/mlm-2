$(document).ready(function () {
    $('.edit').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.static');

        $container.find('.edit-static').show();
        $container.find('.show-static').hide();
    });

    $('.edit-static [type=reset]').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.static');

        $container.find('.edit-static').hide();
        $container.find('.show-static').show();
    });

    $('.delete').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.static');

        if (confirm('Вы действительно хотите удалить эту страницу?'))
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