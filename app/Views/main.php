<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to CodeIgniter 4!</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<!-- HEADER: MENU + HEROE SECTION -->
<?=view('templates/header')?>
<section>
    <h1>Tic Tac Toe</h1>
    <table>
        <tr>
            <td><a href="#" data-location="1"></a>1</td>
            <td class="vert"><a href="#" data-location="2"></a>2</td>
            <td><a href="#" data-location="3"></a>3</td>
        </tr>
        <tr>
            <td class="hori"><a href="#" data-location="4"></a>4</td>
            <td class="vert hori"><a href="#" data-location="5"></a>5</td>
            <td class="hori"><a href="#" data-location="6"></a>6</td>
        </tr>
        <tr>
            <td><a href="#" data-location="7"></a>7</td>
            <td class="vert"><a href="#" data-location="8"></a>8</td>
            <td><a href="#" data-location="9"></a>9</td>
        </tr>
    </table>


    <a href="#" class="button hello start-game">Start game</a>
</section>
<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<?=view('templates/footer')?>

<script src="/js/jquery-3.5.1.min.js" defer></script>
<script src="/js/scripts.js" defer></script>
</body>
</html>