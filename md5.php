<?php
echo (!empty($_GET['pass'])?md5($_GET['pass']):"Add pass as get parameter to url. e.g. .../md5.php?pass=secret"); 
?>