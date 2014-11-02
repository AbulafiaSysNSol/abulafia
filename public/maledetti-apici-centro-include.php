<?php

if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 0){
 $_POST = array_map('addslashes', $_POST );
 $_GET = array_map('addslashes', $_GET );
 $_COOKIE = array_map('addslashes', $_COOKIE );
}

?>