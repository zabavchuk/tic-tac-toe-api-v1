<?php namespace App\Controllers;

use AbmmHasan\Uuid;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;

class TicTacToeApi extends BaseController
{
    use ResponseTrait;
    private $game_status = ['RUNNING', 'X_WON', 'O_WON', 'DRAW'];
    private $cache_name = 'all_games';
    private $cache_time = 86400;

    public function index()
    {
        return view('main');
    }

    public function create_game()
    {
        // creating game_id
        $game_id = Uuid::v4();

        $game = [
            'id' => $game_id,
            'board' => '---------',
            'status' => $this->game_status[0]
        ];

        // caching games data
        cache_unshift($this->cache_name, $game, $this->cache_time);

        $this->respondCreated($game, 'Game successfully started');

        $response['location'] = base_url(TTT_API_ROUT . '/' . $game['id']);

        return json_encode($response);
    }

    public function make_move($game_id)
    {
        $data = $this->request->getRawInput();

        $games_cache = cache($this->cache_name);

        $game = search_value_array($games_cache, $game_id, 'id');
        $index = search_index_array($games_cache, $game_id, 'id');

        if (strlen($data['board']) === 9) {
            $winner = check_winner($data['board']);

            if($winner){
                $game['status'] = $this->game_status[$winner];
                $game['board'] = $data['board'];

                $games_cache = array_replace($games_cache, [$index => $game]);
            }
            else{
                $best_move = best_move($data['board']);

                $game['board'] = $best_move;

                $games_cache = array_replace($games_cache, [$index => $game]);

                $winner = check_winner($game['board']);

                if($winner){
                    $game['status'] = $this->game_status[$winner];

                    $games_cache = array_replace($games_cache, [$index => $game]);
                }
            }
        } else {
            return $this->fail(['reason' => 'Can\'t read board. Must be only nine characters.']);
        }

        cache()->save($this->cache_name, $games_cache, $this->cache_time);

        return json_encode($game);
    }

    public function get_all_games()
    {
        $response = cache($this->cache_name) ?? cache($this->cache_name) ?? [];

        return json_encode($response);
    }

    public function get_game($game_id)
    {
        $response = search_value_array(cache($this->cache_name), $game_id, 'id');

        return (!empty($response) ? json_encode($response) : $this->failNotFound('Resource not found'));
    }

    public function delete_game($game_id)
    {

        $index = search_index_array(cache($this->cache_name), $game_id, 'id');

        if (is_numeric($index)) {
            $games_cache = cache($this->cache_name);

            unset($games_cache[$index]);

            cache()->save($this->cache_name, $games_cache, $this->cache_time);

            $response = $this->respondDeleted('', 'Game successfully deleted');
        } else {
            $response = $this->failNotFound('Resource not found');
        }

        return $response;
    }
}
