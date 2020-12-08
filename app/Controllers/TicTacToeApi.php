<?php namespace App\Controllers;

use AbmmHasan\Uuid;
use CodeIgniter\API\ResponseTrait;

class TicTacToeApi extends BaseController
{
    use ResponseTrait;
    private $basic_status = 'RUNNING';
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
            'status' => $this->basic_status
        ];

        $games_cache = service('gamesCacher', $this->cache_name, $this->cache_time);
        $games_cache->addGame($game, $this->cache_time);

        $this->respondCreated($game, 'Game successfully started');

        $response['location'] = base_url(TTT_API_ROUT . '/' . $game['id']);

        return json_encode($response);
    }

    public function make_move($game_id)
    {
        $data = $this->request->getRawInput();

        $games_cache = service('gamesCacher', $this->cache_name, $this->cache_time);
        $game = $games_cache->getGame($game_id);

        if (!empty($game) && $game['status'] === $this->basic_status) {
            if (strlen($data['board']) === 9) {
                $tic_tac_toe = service('ticTacToe', $data['board']);

                if ($tic_tac_toe->checkBoard($data['board'])) {
                    $game = $tic_tac_toe->makeMove($game);
                } else {
                    return $this->fail(['reason' => 'Can\'t read board. Incorrect symbol(s).']);
                }
            } else {
                return $this->fail(['reason' => 'Can\'t read board. Must be only nine characters.']);
            }
        } else {
            return $this->fail('Bad request');
        }
        $games_cache->updateGame($game_id, $game);

        return json_encode($game);
    }

    public function get_all_games()
    {
        $games_cache = service('gamesCacher', $this->cache_name, $this->cache_time);
        $response = $games_cache->getAllGames();

        return json_encode($response);
    }

    public function get_game($game_id)
    {
        $games_cache = service('gamesCacher', $this->cache_name, $this->cache_time);
        $response = $games_cache->getGame($game_id);

        return (!empty($response) ? json_encode($response) : $this->failNotFound('Resource not found'));
    }

    public function delete_game($game_id)
    {
        $games_cache = service('gamesCacher', $this->cache_name, $this->cache_time);
        $is_delete = $games_cache->deleteGame($game_id);

        if ($is_delete) {
            $response = $this->respondDeleted('', 'Game successfully deleted');
        } else {
            $response = $this->failNotFound('Resource not found');
        }

        return $response;
    }
}
