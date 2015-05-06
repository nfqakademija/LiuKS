jQuery(document).ready(function($)
{
    var $tournament = $('#tournament');
    if ($tournament.length > 0)
    {
        $.ajax({
            method: "get",
            url: $tournament.attr('data-url'),
            success: function(msg)
            {
                var $resp = $(msg);
                var tournament_info = $resp.find('#tournament-info');
                var script = $.grep($resp, function(e){ return e.id == 'tournament-script'; });
                $('#game-info').replaceWith(tournament_info);
                $('body').append(script);
            }
        });
    }
});