<?php

namespace App\ThirdParty;


class TicTacToeAi
{
    private $game_status = ['RUNNING', 'X_WON', 'O_WON', 'DRAW'];
    private $scores = [0, -10, 10, 0];

    private $ai_mark = 'O';
    private $human_mark = 'X';

    private $board;

    public function __construct(string $board)
    {
        $this->board = $board;
    }

    public function makeMove(array $game): array
    {
        $winner = $this->checkWinner($this->board);

        if ($winner > 0) {
            $game['status'] = $this->game_status[$winner];
            $game['board'] = $this->board;
        } else {
            $best_move = $this->getBestMove($this->board);

            $game['board'] = $best_move;

            $winner = $this->checkWinner($game['board']);

            if ($winner > 0) {
                $game['status'] = $this->game_status[$winner];
            }
        }
        return $game;
    }

    protected function getBestMove(string $board): string
    {
        $best_score = -INF;
        $move = 0;
        for ($i = 0; $i < strlen($board); $i++) {
            if ($board[$i] === '-') {
                $board[$i] = $this->ai_mark;
                $score = $this->minimax($board, 0, false);
                $board[$i] = '-';
                if ($score > $best_score) {
                    $best_score = $score;
                    $move = $i;
                }
            }
        }
        $board[$move] = $this->ai_mark;
        return $board;
    }

    protected function minimax(string $board, int $depth, bool $is_maximizing)
    {
        $result = $this->checkWinner($board);

        if ($result > 0) {
            return $this->scores[$result];
        }

        if ($is_maximizing) {
            $best_score = -INF;
            for ($i = 0; $i < strlen($board); $i++) {
                if ($board[$i] === '-') {
                    $board[$i] = $this->ai_mark;
                    $score = $this->minimax($board, $depth + 1, false);
                    $board[$i] = '-';
                    $best_score = max($score, $best_score);
                }
            }
            return $best_score;
        } else {
            $best_score = INF;
            for ($i = 0; $i < strlen($board); $i++) {
                if ($board[$i] === '-') {
                    $board[$i] = $this->human_mark;
                    $score = $this->minimax($board, $depth + 1, true);
                    $board[$i] = '-';
                    $best_score = min($score, $best_score);
                }
            }
            return $best_score;
        }
    }

    public function checkBoard(string $board): bool
    {
        $check = true;

        if (preg_replace('/(X)|(O)|(-)/', '', $board) !== '') {
            $check = false;
        }
        return $check;
    }

    protected function checkWinner($board): int
    {
        $winner = 0;
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

        if ($winner === 0 && $open_spots === 0) {
            return 3;
        } elseif ($winner !== 0) {
            return ($winner === $this->human_mark ? 1 : 2);
        } else {
            return $winner;
        }
    }
}