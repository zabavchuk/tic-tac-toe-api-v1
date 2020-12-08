'use strict';

function getFullUrl(uri) {
    return `${window.location.origin}/${(uri !== '' ? uri + '/' : '')}`;
}

if(localStorage.getItem('game_id') !== null){
    getGame(localStorage.getItem('game_id'));
}

function getGame(game_id){
    $.get(
        getFullUrl(`api/v1/games/${game_id}`),
        {
        },
        drawGame,
        'json'
    );
}

function drawGame(response) {
    let board = response.board;
    let status = response.status;

    if(status ==='RUNNING'){
        $('a.start-game').addClass('disabled');
        $('table').find('a').removeClass('disabled');
        $('table').find('a').addClass('cell-decoration');

        for (let i = 0; i < board.length; i++) {
            if(board[i] !=='-'){
                $('table.tic-tac-toe').find(`[data-location='${i}']`).text(board[i]);
            }
        }
    }
}

function initiateGame(response) {
    localStorage.setItem('game_id', response.id);

    $('a.start-game').addClass('disabled');
    $('table').find('a').removeClass('disabled');
    $('table').find('a').addClass('cell-decoration');

    $('table.tic-tac-toe').find('td').html('<a href="#" class="cell cell-decoration">');
}

function handleResponse(response) {
    if(response.location !== ''){
        $.get(
            response.location,
            {
            },
            initiateGame,
            'json'
        );
    }
}

function startGame(e){
    e.preventDefault();

    $.post(
        getFullUrl('api/v1/games'),
        {
        },
        handleResponse,
        'json'
    );
}

function creatBoard(index) {
    let board = '';
    if($(this).text() === ''){
        board += '-';
    }
    else {
        board += $(this).text();
    }
}

function redrawBoard(response) {

    for (let i = 0; i < response.board.length; i++) {
        if(response.board[i] !=='-'){
            $('table.tic-tac-toe').find(`[data-location='${i}']`).text(response.board[i]);
        }
    }

    if(response.status !== 'RUNNING'){
        alert(response.status);
        $('a.start-game').removeClass('disabled');

    }
    else {
        $('table.tic-tac-toe').find('a').removeClass('disabled');
    }
}

function makeMove(e) {
    e.preventDefault();

    let $cells = $(this).closest('table').find('td');
    let board = '';

    $(this).closest('td').text('X');
    $('table.tic-tac-toe').find('a').addClass('disabled');
    $cells.each(function(){

        if($(this).text() === ''){
            board += '-';
        }
        else {
            board += $(this).text();
        }
    });

    $.ajax({
        url: getFullUrl(`api/v1/games/${localStorage.getItem('game_id')}`),
        type: 'PUT',
        data: {'board' : board},
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: redrawBoard
    });
}

$(function () {

    $(document).on('click', '.start-game', startGame);

    // $('.cell').on('click', makeMove);
    $(document).on('click', '.cell' , makeMove);

});