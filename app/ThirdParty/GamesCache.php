<?php

namespace App\ThirdParty;

class GamesCache
{
    private $cache_name;
    private $cache_time;

    public function __construct(string $cache_name, int $cache_time)
    {
        $this->cache_name = $cache_name;
        $this->cache_time = $cache_time;
    }

    /**
     * @param array $value
     * @param int $cache_time
     */
    public function addGame(array $value, int $cache_time)
    {

        if (cache($this->cache_name) === null) {
            $values[] = $value;
            cache()->save($this->cache_name, $values, $cache_time);
        } else {
            $values = cache($this->cache_name);
            array_unshift($values, $value);
            cache()->save($this->cache_name, $values, $cache_time);
        }
    }

    public function getAllGames()
    {
        return cache($this->cache_name) ?? cache($this->cache_name) ?? [];
    }

    public function getGame(string $game_id)
    {
        $game = [];
        $all_games = $this->getAllGames();

        if (!empty($all_games)) {
            $index = search_index_array($all_games, $game_id, 'id');

            if (isset($all_games[$index]) && !empty($all_games[$index])) {
                $game = $all_games[$index];
            }
        }

        return $game;
    }

    public function updateGame(string $game_id, array $game)
    {
        $all_games = $this->getAllGames();
        if (!empty($all_games)) {
            $index = search_index_array($all_games, $game_id, 'id');

            $updated_cache = array_replace($all_games, [$index => $game]);

            cache()->save($this->cache_name, $updated_cache, $this->cache_time);
        }
    }

    public function deleteGame(string $game_id)
    {

        $all_games = $this->getAllGames();
        $game = $this->getGame($game_id);

        if (isset($game) && !empty($all_games)) {

            $index = search_index_array($all_games, $game_id, 'id');
            if (is_numeric($index)) {
                unset($all_games[$index]);

                cache()->save($this->cache_name, $all_games, $this->cache_time);

                $is_delete = true;
            } else {
                $is_delete = false;
            }
        } else {
            $is_delete = false;
        }

        return $is_delete;
    }
}