<?php
function myheader($page_title = null) { 

$a = ['bursary','department','hostel','medicals','security','student','student affairs'];

if ( in_array(($page_title ? strtolower($page_title) : '0'), $a) ) {

    include('checklogin.php');
}
	if(!$page_title)
		$page_title = "Home";
	?>

<!DOCTYPE html>
<html>
	<head>
		<title><?= $page_title; ?> - Online Clearance Portal </title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/font-awesome/css/font-awesome.min.css" />
		<style type="text/css">
            /*altering BootStrap*/
            .navbar-default{
                border-radius: 0;
                /*background-color: anyColor you want Here;*/

            }
            .main-content{
                margin: 5% auto;
            }
            .footer{
                position: fixed;
                bottom: 0;
                width: 100%;
                overflow: hidden;
                margin-top: 10%;
                background-color: #eee;
                border-top: solid 1px #ddd;
            }
            .copy{
                padding: 10px;
                background-color: #eee;
                border-top: solid 1px #ddd;
            }

            #innerClearance .item{
                padding: 8px 0;
                font-size: 1.2em;
            }

            #innerClearance .item span{
                margin-left: 10px;
            }
		</style>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<script type="text/javascript" src="js/general.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>

    <!-- Navigation -->
    <br>
        &nbsp;&nbsp;&nbsp;&nbsp;<img src="res/img/university_logo.png" height="60px" style="margin-bottom:20px;"/>
        <span style="padding-top:20px;" class="pull-right"><em><strong>Knowledge, Food and Security...&nbsp;&nbsp;&nbsp;&nbsp;</strong></em></span>
    <nav class="navbar navbar-default">
        <div class="container-fluid header">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navLinks" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="glyphicon glyphicon-menu-hamburger"></span>
                </button>
                <a class="navbar-brand" href="#"><?= $page_title; ?> - Online Clearance Portal</a>

            </div>
            <?php if( isset( $_SESSION['user_id']) && isset( $_SESSION['name']) ) : ?>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-right" >
                <span class="navbar-text">
                    Welcome,
                    <?php echo $_SESSION['name'];?>
                </span>

                &nbsp;
                <span class="navbar-text btn-link" style="cursor:pointer;">
                    <a href='logout.php'><i class="fa fa-sign-out"></i> Logout </a>
                </span>
            </div>
        <?php endif;?>
        </div><!-- /.container-fluid -->
    </nav>
		<!-- Main Content -->
		<div class="main-content">

<?php } ?>

<?php function myfooter() { ?>

		</div>

		<footer class="footer text-center">
           <div class="row copy">
                &copy; <a href="https://github.com/onumahkalusamuel/online-clearance" target="__blank">Online Clearance Script</a> 2015 - <?php echo date('Y')?>
            </div>
        </footer>
	</body>
</html>


<?php } 

function message($message = null) { ?>
        <div class="alert alert-danger" style="font-weight: bold;" role="alert">
            <i cass="fa fa-exclamation-circle"></i>
                &nbsp;&nbsp;<?php echo ($message ? $message : "An error occured!!!");?>
                <span href='#' class="pull-right fa fa-times"style="cursor: pointer;" onclick="$(this).parent().hide();"></span>&nbsp;&nbsp;
        </div>

<?php }

?>
