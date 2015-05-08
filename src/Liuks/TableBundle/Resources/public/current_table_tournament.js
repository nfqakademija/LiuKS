$(document).ready(
    function ()
    {
        var $gameInfo = $('#game-info');
        var $tournament = $('#tournament');
        var gameUrl = $gameInfo.attr('data-url');
        setInterval(
            function ()
            {
                if ($tournament.length == 0) {
                    $.ajax(
                        {
                            url: $gameInfo.attr('data-dataUrl')
                        }
                    );
                }
                $gameInfo.load(gameUrl + " #game-info>div");
            }, 10000
        );

        if ($tournament.length > 0) {
            $.ajax(
                {
                    method: "get",
                    url: $tournament.attr('data-url'),
                    success: function (msg)
                    {
                        var $resp = $(msg);
                        var tournament_info = $resp.find('#tournament-info');
                        var script = $.grep(
                            $resp, function (e)
                            {
                                return e.id == 'tournament-script';
                            }
                        );
                        $tournament.replaceWith(tournament_info);
                        $('body').append(script);
                    }
                }
            );
        }
    }
);