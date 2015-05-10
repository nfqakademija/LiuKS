$(document).ready(
    function ()
    {
        var $login = $('#open_login').fancybox({});
        if (window.location.hash == '#login')
        {
            $login.trigger('click');
        }

        $('#delete-btn').fancybox({});
    }
);