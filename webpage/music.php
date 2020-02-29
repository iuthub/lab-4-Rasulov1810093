
<?php 

$playlist = (isset($_REQUEST["playlist"]))?$_REQUEST["playlist"]:NULL;

$shuffle = (isset($_REQUEST["shuffle"]))?$_REQUEST["shuffle"]:NULL;

function audioSize($fileSize) {
  if($fileSize > 0 && $fileSize < 1024){
    return $fileSize . " b";
  }
  elseif ($fileSize > 1023 && $fileSize < 1048576){
    return round($fileSize/1024, 2) . " kb";
  }
  elseif ($fileSize > 1048577) {
    return round($fileSize/1048576, 2) . " mb";
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Music Viewer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="viewer.css" type="text/css" rel="stylesheet" />
  </head>
  <body>

    <div id="header">

      <p><a href="audio.php">Main Page</a>    <a href="audio.php?shuffle=on">Shuffle</a></p>


      <h1>190M Music Playlist Viewer</h1>
      <h2>Search Through Your Playlists and Music</h2>
    </div>


    <div id="listarea">
      <ul id="musiclist">

        <?php
        if($playlist)
        {
          $audios = file("audios/$playlist", FILE_IGNORE_NEW_LINES);
        }
        else if($shuffle)
        {
          $audios = glob("audios/*.mp3");
          shuffle($audios);
        }
        else
        {
          $audios = glob("audios/*.mp3");
        }

        foreach ( $audios as $audio) {
          if(strstr($audio, ".mp3")){
          ?>
          <li class="mp3item" ><a href="<?= 'audios/'.basename($audio)?> "> <?= basename($audio) ?></a> (<?= audioSize(filesize("audios/". basename($audio))) ?>)</li>
        <?php } }

        $set = glob("audios/*.m3u");
        if(!($playlist))
        {
          foreach ( $set as $audio) {
          ?>
          <li class="playlistitem" ><a href="audio.php?playlist=<?= basename($audio)?>"> <?= basename($audio) ?>   </a> </li>

        <?php } } ?>

      </ul>
    </div>
  </body>
</html>
