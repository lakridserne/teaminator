<?php
$salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
echo $salt . "<br />";
echo sha1('abcd1234' . $salt);
?>
