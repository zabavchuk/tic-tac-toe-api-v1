'use strict';

function full_url(uri) {
    return window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/' + (uri !== '' ? uri + '/' : '');
}

$(function () {

    $('.start-game').on('click', function (e) {
        e.preventDefault();

        $.post(
            full_url('api/v1/games'),
            {
            },
            function (response) {
                if(response.location !== ''){
                    $.get(
                        response.location,
                        {
                        },
                        function (response) {
                            console.log(response);

                        },
                        'json'
                    );
                }

            },
            'json'
        );
    });
});