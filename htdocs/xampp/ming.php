<?php
    include "langsettings.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta name="author" content="Kai Oswald Seidler, Kay Vogelgesang, Carsten Wiedmann">
        <link href="xampp.css" rel="stylesheet" type="text/css">
        <title><?php echo $TEXT['flash-head']; ?></title>
    </head>

    <body>
        <br><h1><?php echo $TEXT['flash-head']; ?></h1>

<? 
	$text=@$_REQUEST['text'];
	if($text=="")$text = "ceci n est pas un ami d apache"; 
?>
	
<object data="mingswf.php?<?php echo htmlentities("text=".urlencode($text)); ?>" width="520" height="320" type="application/x-shockwave-flash">
            <param name="movie" value="mingswf.php?<?php echo htmlentities("text=".urlencode($text)); ?>">
            <param name="loop" value="true">
            <a href="http://www.macromedia.com/go/getflashplayer"><img src="http://www.macromedia.com/images/shared/download_buttons/get_flash_player.gif" width="88" height="31" alt="get flash player" title=""></a>
        </object>

<p class=small>
<?=$TEXT['flash-text1']?>
<p>

<form name=ff action=ming.php method=get>
<input type=text name=text value="<?=$text?>" size=30> <input type=submit value="<?=$TEXT['flash-ok']?>">
</form>
<? $file="mingswf.php";include("showcode.php"); ?>

</body>
</html>
