"use strict";
$(document).ready(
    function ()
    {
        var $tournamentInfo = $('#tournament-info');
        var tournamentUrl = $tournamentInfo.attr('data-url');
        var tournamentDataUrl = $tournamentInfo.attr('data-dataurl');
        var $tournament = $('#tournament');
        var $join = $('#join_tournament');
        var results, teams;
        loadTournamentInfo();
        setInterval(
            function ()
            {
                $.ajax(
                    {
                        url: tournamentDataUrl
                    }
                );
                $tournamentInfo.load(
                    tournamentUrl + " #tournament-info>div", function ()
                    {
                        loadTournamentInfo();
                    }
                );
            }, 10000
        );

        function loadTournamentInfo()
        {
            $tournament = $('#tournament');
            if ($tournament.length != 0) {
                loadTournament();
            }
        }

        function loadTournament()
        {
            $tournament = $('#tournament');
            var data = JSON.parse($tournament.attr('data-data'));
            results = $.extend(true, [], data['results']);
            teams = $.extend(true, [], data['teams']);
            $tournament.bracket(
                {
                    init: data,
                    save: saveFn,
                    userData: $tournament.attr('data-url')
                }
            );
        }

        function saveFn(newData, url)
        {
            console.log(results.equals(newData['results'].filterEmpty()));
            var changed = !results.equals(newData['results'].filterEmpty()) ? 'results' : !teams.equals(newData['teams']) ? 'teams' : 0;
            if (changed !== 0) {
                $.ajax(
                    {
                        url: url,
                        method: 'POST',
                        data: {json: JSON.stringify(newData[changed]), changed: changed},
                        success: function (msg)
                        {
                            console.log(msg);
                            $tournament.siblings('p').remove();
                            if (msg == 'success') {
                                results = $.extend(true, [], data['results']);
                                teams = $.extend(true, [], data['teams']);
                                $tournament.before('<p class="alert alert-success">Turnyro pakeitimai išsaugoti.</p>');
                            }
                            else {
                                $tournament.before('<p class="alert alert-danger">Įvyko klaida saugant pakeitimus.</p>');
                            }
                        }
                    }
                );
            }
            else {
                $tournament.siblings('p').remove();
                $tournament.before('<p class="alert alert-warning">Pakeitimų nerasta.</p>');
            }
        }
    }
);