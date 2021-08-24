<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);
if(session_destroy()) {
	header('Location: ./');
} else {
	$loc = $_SERVER['HTTP_REFERRER'];
	header('Location: $loc');
}
