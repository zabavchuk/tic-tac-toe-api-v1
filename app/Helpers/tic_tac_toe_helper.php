<?php
/**
 * @param string $board
 * @return string
 */
function best_move(string $board)
{
    $best_score = -INF;
    $mark = 'O';

//    $result = check_winner($board);
//    if($result !== null){
//        return $result;
//    }

    for ($i = 0; $i < strlen($board); $i++) {
        if ($board[$i] === '-') {
            $board[$i] = $mark;
//            $score = minimax($board, 0, false);
            $score = 1;
            $board[$i] = '-';
            if ($score > $best_score) {
                $best_score = $score;
                //move
                $move = $i;
                $board[$i] = $mark;
            }
        }
    }

    return $board;
}

function minimax($board, $depth, $isMaximizing)
{
//    $result = check_winner();

//    if ($result !== null) {
//        return scores[result];
//    }

    return 0;
}

function check_winner($board)
{
    $winner = false;
    $open_spots = 0;

    //horizontal
    for ($i = 0; $i < strlen($board); $i++) {
        if ($board[$i] !== '-' && ($i === 0 || $i === 3 || $i === 6)) {
            if ($board[$i] === $board[$i + 1] && $board[$i + 1] === $board[$i + 2]) {
                $winner = $board[$i];
            }
        }
    }

    //vertical
    for ($i = 0; $i < strlen($board); $i++) {
        if ($board[$i] !== '-' && ($i === 0 || $i === 1 || $i === 2)) {
            if ($board[$i] === $board[$i + 3] && $board[$i + 3] === $board[$i + 6]) {
                $winner = $board[$i];
            }
        }
    }

    // Diagonal
    for ($i = 0; $i < strlen($board); $i++) {
        if ($board[$i] !== '-' && $i === 0) {
            if ($board[$i] === $board[$i + 4] && $board[$i + 4] === $board[$i + 8]) {
                $winner = $board[$i];
            }
        }
        if ($board[$i] !== '-' && $i === 2) {
            if ($board[$i] === $board[$i + 2] && $board[$i + 2] === $board[$i + 4]) {
                $winner = $board[$i];
            }
        }
    }

    for ($i = 0; $i < strlen($board); $i++) {
        if($board[$i] === '-'){
            $open_spots++;
        }
    }

    if ($winner === false && $open_spots === 0) {
        return 3;
    } elseif($winner !== false) {
        return ($winner === 'X' ? 1 : 2);
    }
    else{
        return $winner;
    }
}