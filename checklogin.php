<?php
@session_start(); 
if( $_SESSION['user_type'] != strtolower( $page_title ) ) {
	header('location: ./');
	die();
}