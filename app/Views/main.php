<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Tic-Tac-Toe Game</title>
	<meta name="description" content="The small Tic-Tac_Toe-API">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<!-- HEADER: MENU + HEROE SECTION -->
<?=view('templates/header')?>
<section>
    <h1>Tic Tac Toe</h1>
    <table class="tic-tac-toe">
        <tr>
            <td data-location="0"><a href="#" class="disabled cell cell-decoration"></a></td>
            <td data-location="1" class="vert"><a href="#" class="disabled cell cell-decoration"></a></td>
            <td data-location="2"><a href="#" class="disabled cell cell-decoration"></a></td>
        </tr>
        <tr>
            <td data-location="3" class="hori"><a href="#" class="disabled cell cell-decoration"></a></td>
            <td data-location="4" class="vert hori"><a href="#" class="disabled cell cell-decoration"></a></td>
            <td data-location="5" class="hori"><a href="#" class="disabled cell cell-decoration"></a></td>
        </tr>
        <tr>
            <td data-location="6"><a href="#" class="disabled cell cell-decoration"></a></td>
            <td data-location="7" class="vert"><a href="#" class="disabled cell cell-decoration"></a></td>
            <td data-location="8"><a href="#" class="disabled cell cell-decoration"></a></td>
        </tr>
    </table>


    <a href="#" class="button decoration start-game">Start game</a>
</section>
<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<?=view('templates/footer')?>

<script src="/js/jquery-3.5.1.min.js" defer></script>
<script src="/js/scripts.js" defer></script>
</body>
</html>