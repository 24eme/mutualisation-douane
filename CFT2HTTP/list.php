<?php

$dir = preg_replace('/\?.*/', '', preg_replace('/.list.php.*/', '', preg_replace('/^./', '', $_SERVER['REQUEST_URI'])));
if (!preg_match('/^reception[a-z0-9\/_]*$/i', $dir)) {
    exit;
}
$prefix = '';
$postfix = '';
$isxml = false;
$isjson = false;
if (isset($_GET['format'])) {
  if ($_GET['format'] == 'xml') {
    $isxml = true;
  }
  if ($_GET['format'] == 'json') {
    $isjson = true;
  }
}
$file = tempnam("/tmp/", "list.date");
if (isset($_GET['from']) && preg_match('/^[0-9][0-9][0-9][0-9]\-[0-9][0-9]\-[0-9][0-9]$/', $_GET['from'])) {
    exec("touch --date=".$_GET['from']." $file");
}else{
    exec("touch --date=2016-01-01 $file");
}
if (isset($_GET['accise']) && preg_match('/^[A-Z0-9]*$/i',$_GET['accise'])) {
  exec("find $dir -cnewer $file -type f -name '".$_GET['accise']."*xml'", $output);
}else{
  exec("find $dir -cnewer $file -type f -name '*xml'", $output);
}
unlink ($file);
if ($isxml) {
    header("content-type: text/xml\n");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\n<list>\n";
    $prefix="<url>";
    $postfix="</url>";
}else if ($isjson) {
  header("content-type: text/json\n");
  echo '[';
  $prefix = '"';
  $postfix = '"';
}else {
    header("content-type: text/plain\n");
}
foreach ($output as $line) {
    print $prefix."http://10.222.223.1/$line".$postfix."\n";
    if ($prefix == '"') {
      $prefix = ',"';
    }
}
if ($isxml) {
    echo "</list>\n";
}else if ($isjson) {
  echo ']';
}
