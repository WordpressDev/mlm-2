$(document).ready(function () {
    $('.edit').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.article');

        $container.find('.edit-article').show();
        $container.find('.show-article').hide();
    });

    $('.edit-article [type=reset]').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.article');

        $container.find('.edit-article').hide();
        $container.find('.show-article').show();
    });

    $('.delete').click(function(e) {
        e.preventDefault();
        var $container = $(this).closest('.article');

        if (confirm('Вы действительно хотите удалить эту статью?'))
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