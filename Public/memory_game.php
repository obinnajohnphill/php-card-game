<?php	
	session_start();

require_once('../Controllers/BoardController.php');
require_once('../Controllers/CardController.php');
	
	// first check if we have a utility function
	if ( isset($_REQUEST["won"]) ){
		// if we won we need to reset the game board
		unset($_SESSION['board']);
		$_SESSION['games_won'] = ++$_SESSION['games_won'];
		$response = array("status" => "ok");
		exit(json_encode($response));
	}
	
	// All the card files we have
	$CARDS = array("images/image0001.png",
					"images/image0002.png","images/image0003.png",
					"images/image0004.png","images/image0005.png",
					"images/image0006.png","images/image0007.png",
					"images/image0008.png","images/image0009.png",
					"images/image0010.png","images/image0011.png",
					"images/image0012.png","images/image0013.png",
					"images/image0014.png","images/image0015.png",
					"images/image0016.png","images/image0017.png",
					"images/image0018.png","images/image0019.png",
					"images/image0020.png");


$level = 1;
if (!isset($_SESSION['games_won'])) {
    $_SESSION['games_won'] = 0;
}

if (isset($_REQUEST['level']) ) {
    $level = $_REQUEST['level'];

    $board = new BoardController($level, $CARDS);
    $_SESSION['board'] = $board;
} else {
    if (!isset($_SESSION['board'])) {
        $board = new BoardController($level, $CARDS);
        $_SESSION['board'] = $board;
    } else {
        $board = $_SESSION['board'];
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title>Card Game Prototype</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" href="css/memory_game.css" type="text/css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.metadata.js"></script>
	<script type="text/javascript" src="js/jquery.quickflip.js"></script>
	<script type="text/javascript" src="js/memory_game.js"></script>
	<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
	var flashvars = false;
	var attributes = {};
	var params = {
	  allowscriptaccess : "always",
	  wmode : "transparent",
	  menu: "false"
	};
	swfobject.embedSWF("sfx.swf", "sfx_movie", "1", "1", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
</script>
</head>
<style>
	<?php
		print $board->get_css();
	?>
</style>
<body>
<h3>Simple Memory Game</h3>
<div id="sfx_movie">
	<h1>This page requires flash for full funcionality</h1>
	<p><a href="http://www.adobe.com/go/getflashplayer">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
	</a></p>
</div>
<div id="control" style="width:<?php print $board->get_cols()*75; ?>px;">
	<label>Level:</label>
	<select id="level_chooser">
		<?php 
			print "<!-- ".$board->max_level()." -->";
			for ( $i = 0; $i < $board->max_level(); ++$i ){
					$selected = ( ($i+1) == $level ) ? " selected=selected" : "";
					print "\r<option value=\"".($i+1)."\"".$selected.">".($i+1)."</option>";
			}
		?>
		
	</select>
	<label>Games Finished: </label>
	<span><?php print $_SESSION["games_won"]; ?></span>
	<label>Moves:</label>
	<span id="num_of_moves">0</span>
</div>
<div id="game_board" style="width:<?php print $board->get_cols()*75; ?>px;">
<?php
	print $board->get_html();
?>
</div>
<div id="player_won"></div>
<div id="start_again"><a id="again" href="#">Click here to play again</a></div>
<div id="sfx_movie">
	<h1>This page requires flash for full funcionality</h1>
	<p><a href="http://www.adobe.com/go/getflashplayer">
		<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
	</a></p>
</div>
</body>
</html>
