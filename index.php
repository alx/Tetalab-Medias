<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Telalab Medias</title>
<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen">
<script type="text/javascript" src="/js/jquery-1.2.1.pack.js"></script> 
<script type="text/javascript" src="/js/jquery.lightbox-0.5.pack.js"></script> 
<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript"> 
$(function() {
  $('#gallery a').lightBox({fixedNavigation:true});
});
</script> 
</head>
<body>
<div id='gallery'>
<?php
  function compare_filedate($a, $b)
  {
    return strnatcmp($b['date'], $a['date']);
  }

  # Original PHP code by Chirp Internet: www.chirp.com.au
  # Please acknowledge use of this code by including this header.

  function getImages($dir)
  {
    global $imagetypes;

    # array to hold return value
    $retval = array();

    # add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    # full server path to directory
    $fulldir = "{$_SERVER['DOCUMENT_ROOT']}/$dir";

    #$d = @dir($fulldir) or die("getImages: Failed opening directory $dir for reading");

    if(!($d = @dir($fulldir))){
      return array();
    }

    while(false !== ($entry = $d->read())) {
      # skip hidden files
      if($entry[0] == ".") continue;

      # check for image files
      if(in_array(mime_content_type("$fulldir$entry"), $imagetypes)) {
        $retval[] = array(
         "file" => "/$dir$entry",
         "size" => getimagesize("$fulldir$entry"),
	 "date" => filemtime("$fulldir$entry")
        );
      }
    }
    $d->close();

    # order file by date
    usort($retval, 'compare_filedate');

    return $retval;
  }

  # image types to display
  $imagetypes = array("image/jpeg", "image/gif", "image/png");

  # fetch image details
  $users = array("alex", "fabrice", "joebarbar", "pg", "thieum", "vinsc", "boris", "ikujam", "lucas", "sadeden", "thomas", "urs");
  $images = array();
  foreach($users as $user) {
    $images = array_merge($images, getImages("users/$user"));
  }

  # display on page
  foreach($images as $img) {
    echo "<div class=\"photo\">";
    echo "<a href=\"{$img['file']}\">";
    echo "<img src=\"{$img['file']}\" width='200px' alt=\"\"><br>\n";
    echo basename($img['file']),"</a><br>\n";
    echo "({$img['size'][0]}x{$img['size'][1]})";
    echo "</div>\n";
  }
?>
</div>
</body>
</html>
