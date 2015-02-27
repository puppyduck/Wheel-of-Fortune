<?php
/*
WoF - PHP implementation of the "Wheel of Fortune" game

Note: This code is fairly old (written in 2006) and things have
changed considerably since then. With a little bit of effort, some css
and graphics this could look pretty nice, but for now forgive the
plain appearance of this script.

Copyright (C) 2006,2015 Marty Anstey (http://marty.anstey.ca/)
------------------------------------------------------------------------
*/
ob_start();
session_start();

$fn = 'wheel.csv';
$free_letters = array('&','-','.','\'','"');

if (!file_exists($fn)) exit("Can't open ".$fn);
if (!$_SESSION["answer"]) {
	$fp = fopen($fn,"rb");
	while (($data = fgetcsv($fp, 8192, ",")) !== FALSE) {
		if ((substr($data[0],0,1)=='#') ||
		(!strlen($data[0]))) continue;	// skip comments & blank lines
		$list[] = $data;
	}
	fclose($fp);

	do {
		$pick = mt_rand(0,count($list)-1);
	} while (in_array($pick,$_SESSION["played"]));

	$_SESSION["played"][] = $pick;
	$_SESSION["answer"] = $list[$pick];
	reload();
}

if ($_GET["pick"])
	$_SESSION["picked"][$_GET["pick"]] = TRUE;

if ($_GET["action"]=='newgame') {
	unset($_SESSION["picked"]);
	unset($_SESSION["answer"]);
	reload();
}

if ($_GET["action"]=='reset') {
	unset($_SESSION["played"]);
	unset($_SESSION["picked"]);
	unset($_SESSION["answer"]);
	reload();
}

$_BADGUESS = FALSE;
if ($_GET["guess"]) {
	$str = strtoupper($_GET["guess"]);
	if ($str == $_SESSION["answer"][1])
		foreach (range('A','Z') as $v) $_SESSION["picked"][$v] = 1;
	else
		$_BADGUESS = TRUE;
}

if ($_GET["action"]=='solve')
	foreach (range('A','Z') as $v) $_SESSION["picked"][$v] = 1;

function reload() {
	header("location: ".$_SERVER["PHP_SELF"]);
	exit;
}

?>
<html>
	<head>
		<style>
			body { font-family: verdana; background-color: white; }
			a { color: #0022cc; }
			td { font-size: 42pt; font-family: verdana; font-color: black; border: 1px solid gray; }
		</style>
	</head>
<body>
<?php
$max_row_len = 12;	// adjust for screen resolution
$answer = explode(' ',$_SESSION["answer"][1]);
$rowlen=0;
?>
<div align="center" style="font-family: verdana; font-size: 16pt; font-weight: bold;">
<?php print ucwords($_SESSION["answer"][0]); ?>
</div>
<hr size="1" noshade/>
<?php
if ($_BADGUESS) print '<div align="center" style="color: red; font-size: 12pt;">Sorry, that guess was incorrect!</div>';
?>
<br/>
<table border="0" cellspacing="12" cellpadding="12">
<tr>
<?php
foreach ($answer as $word) {
	if (($rowlen + strlen($word)) >= $max_row_len) {	// new row
		$rowlen = 0;
		print "</tr>\n<tr>";
	}

	for ($i=0;$i<strlen($word);$i++)
		print '<td align="center">'.((in_array($word[$i],$free_letters))?$word[$i]:(($_SESSION["picked"][$word[$i]])?$word[$i]:'_')).'</td>';

	$rowlen += strlen($word);
	print "<td style=\"border: 0px;\">&nbsp;</td>";
}
?>
</tr>
</table>
<br/><br/><br/><hr size="1" noshade/>
<div align="center" style="font-family: verdana; font-size: 18pt; font-weight: normal;">
<?php
foreach (range('A','Z') as $k=>$v) print (($_SESSION["picked"][$v])?'<font style="color: #e0e0e0;">'.$v.'</font>':"<a href=\"?pick=".$v."\">".$v."</a>")."&nbsp;&nbsp;";
?>
</div>
<hr size="1" noshade/>
<form>
<input type="text" size="<?php print strlen($_SESSION["answer"][1]);?>" name="guess"/><input type="submit" value=" Guess "/><br/>
</form>
<a href="?action=solve">Solve Puzzle</a><br/>
<a href="?action=newgame">Next Game</a><br/>
<a href="?action=reset">Reset</a> [<?php print count($_SESSION["played"]); ?>]
</body>
</html>