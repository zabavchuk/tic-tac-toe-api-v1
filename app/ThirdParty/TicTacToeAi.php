<?php

namespace App\ThirdParty;


class TicTacToeAi
{
    private $game_status = ['RUNNING', 'X_WON', 'O_WON', 'DRAW'];

    private $board;

    public function __construct(string $board)
    {
        $this->board = $board;
    }

    public function makeMove(array $game)
    {
        $winner = $this->checkWinner($this->board);

        if ($winner) {
            $game['status'] = $this->game_status[$winner];
            $game['board'] = $this->board;
        } else {
            $best_move = $this->bestMove($this->board);

            $game['board'] = $best_move;

            $winner = $this->checkWinner($game['board']);

            if ($winner) {
                $game['status'] = $this->game_status[$winner];
            }
        }

        return $game;
    }

    protected function bestMove(string $board)
    {
        $best_score = -INF;
        $mark = 'O';

        for ($i = 0; $i < strlen($board); $i++) {
            if ($board[$i] === '-') {
                $board[$i] = $mark;
//            $score = minimax($board, 0, false);
                $score = 1;
                $board[$i] = '-';
                if ($score > $best_score) {
                    $best_score = $score;
                    $board[$i] = $mark;
                }
            }
        }

        return $board;
    }

    public function checkBoard(string $board)
    {
        $check = true;

        if (preg_replace('/(X)|(O)|(-)/', '', $board) !== '') {
            $check = false;
        }
        return $check;
    }

    protected function checkWinner($board)
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
            if ($board[$i] === '-') {
                $open_spots++;
            }
        }

        if ($winner === false && $open_spots === 0) {
            return 3;
        } elseif ($winner !== false) {
            return ($winner === 'X' ? 1 : 2);
        } else {
            return $winner;
        }
    }
}