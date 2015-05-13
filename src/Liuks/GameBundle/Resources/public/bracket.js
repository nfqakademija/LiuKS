"use strict";
$(document).ready(
    function ()
    {
        var $tournamentInfo = $('#tournament-info');
        var tournamentUrl = $tournamentInfo.attr('data-url');
        var tournamentDataUrl = $tournamentInfo.attr('data-dataurl');
        var $tournament = $('#tournament');
        var $join = $('#join_tournament');
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
            $join = $('#join_tournament');
            if ($tournament.length != 0) {
                loadTournament();
            }
            else if ($join.length != 0) {
                $('#new_team_popup').fancybox({});
                $('#existing_team_popup').fancybox({});

                var $body = $('body').on(
                    'click', '#create_team', function (e)
                    {
                        e.preventDefault();
                        var $this = $(this);
                        var $team_form = $this.siblings('#team_name_form');
                        var team_name = $team_form.find('input').val();

                        if (typeof team_name != "undefined") {
                            if (team_name.length < 2 || team_name.length > 50) {
                                $team_form.addClass('has-error');
                                $team_form.find('.help-block').html('Blogas komandos pavadinimo ilgis.').removeClass('hidden');
                                team_name = 0;
                            }
                        }

                        if (team_name !== 0) {
                            $.fancybox.close();
                            sendRegisterRequest(this, team_name, null);
                        }

                    }
                );

                $body.on(
                    'click', '#add_team', function (e)
                    {
                        e.preventDefault();
                        var $this = $(this);
                        var $team_form = $this.siblings('#team_select_form');
                        var team_id = $team_form.find('select').val();

                        if (typeof team_id != "undefined") {
                            if (team_id == '') {
                                $team_form.addClass('has-error');
                                $team_form.find('.help-block').html('Prašome pasirinkti komandą.').removeClass('hidden');
                                team_id = 0;
                            }
                        }

                        if (team_id !== 0) {
                            $.fancybox.close();
                            sendRegisterRequest(this, null, team_id);
                        }
                    }
                );

                $body.on(
                    'click', '.play', function (e)
                    {
                        e.preventDefault();
                        sendRegisterRequest(this, null, null);
                    }
                );
            }
        }

        function sendRegisterRequest(element, team_name, team_id)
        {
            var $this = $(element);
            team_name = typeof team_name !== 'undefined' ? team_name : null;
            team_id = typeof team_id !== 'undefined' ? team_id : null;
            $.ajax(
                {
                    method: 'POST',
                    url: $this.attr('data-url'),
                    data: {
                        team: $this.attr('data-team'),
                        team_name: team_name,
                        team_id: team_id
                    },
                    success: function (msg)
                    {
                        if (msg) {
                            $('#tournament-info').find('> div').html('<h3>Sveikinu! Jūs užsiregistravote į turnyrą.</h3>');
                        }
                        else {
                            $('#tournament-info').find('> div').html('<h3>Įvyko klaida registruojantis į turnyrą.</h3>');
                        }
                    }
                }
            );
        }


        function loadTournament()
        {
            $tournament = $('#tournament');
            var data = JSON.parse($tournament.attr('data-data'));
            $tournament.bracket(
                {
                    init: data
                }
            );
        }
    }
);