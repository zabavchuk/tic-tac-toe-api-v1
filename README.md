# Tic Tac Toe API v1.1.1

Tic Tac Toe API 
based on PHP Framework Codeigniter 4.0.4.
<br>
The player can only play with the computer.
>Version 1.1.1 updated the computer algorithm.
>The cell is searched according to the Minimax algorithm.

API logic is in `/app/Controllers/TicTacToeApi.php` file.
<br>
Routing: `/app/Config/Routes.php`.
<br>
Tic Tac Toe logic: `/app/ThirdParty/TicTacToeAi.php`. Also
there is `/app/ThirdParty/GamesCache.php` to manage game cache.
<br>
Front-end part in `/public/js/init-frontend.js`


## Setup

Copy `env` to `.env` if you need to change some default values.
<p>
Use command <b>composer install</b> to install all dependencies.
</p>
<p>
Use command <b>php spark serve</b> to run the project.
</p>

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)


## API Requests
* Get all games: GET: ​/api​/v1​/games
* Start a new game/Create game: POST ​/api​/v1​/games
* Get a game: GET ​/api​/v1​/games​/{game_id}
* Make a new move to a game: PUT ​/api​/v1​/games​/{game_id}
* Delete a game: DELETE ​/api​/v1​/games​/{game_id}


## Game flow

* The client (player) starts a game, makes a request to server to initiate a TicTakToe board ( Client (player) will always use cross );
* The backend responds with the location URL of the started game;
* Client gets the board state from the URL;
* Client makes a move, and move is sent back to the server;
* BackEnd validates the move, makes it's own move and updates the game state. The updated game state is returned in the response;
* And so on. The game is over once the computer or the player gets 3 noughts or crosses, horizontally, vertically or diagonally or there are no moves to be made.
