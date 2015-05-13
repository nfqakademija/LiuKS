$(document).ready(
    function ()
    {
        var $html = $('html').toggleClass('loader');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
        else {
            $('h3').html("Geolocation is not supported by this browser.");
        }

        function showPosition(position)
        {
            var $closestTables = $('#closest-tables');
            $.ajax(
                {
                    method: "post",
                    url: $closestTables.attr('data-url'),
                    data: {lat: position.coords.latitude, long: position.coords.longitude},
                    success: function (msg)
                    {
                        $html.toggleClass('loader');
                        if (msg) {
                            $closestTables.replaceWith(msg);
                            var $form = $('form');
                            $('.list-group-item').on(
                                'click', function (e)
                                {
                                    e.preventDefault();
                                    var $this = $(this);
                                    $this.siblings().removeClass('active');
                                    $this.addClass('active');
                                    var id = $this.attr('data-id');
                                    var oldAction = $form.attr('action');
                                    $form.attr(
                                        'action',
                                        oldAction.substr(0, oldAction.lastIndexOf('/') + 1) + id
                                    )
                                }
                            );
                        }
                    }
                }
            );
        }
    }
);