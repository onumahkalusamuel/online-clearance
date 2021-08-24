<?php

if(!isset($_SERVER['HTTP_REFERER'])) {
    die("Unauthorized Access!!!");
}

//get the http referrer
$ref = explode("/",$_SERVER['HTTP_REFERER']);
$r = array_pop($ref);

if($r!="student.php") {
    die("Unauthorized Access!!!");
}

if( ! isset($_GET['regno'])|| empty($_GET['regno']) ) {
    die("Unauthorized Access!!!");
}

include('db.con.php');

$query = "SELECT a.*, b.completion_date
            FROM users AS a LEFT JOIN
            student_affairs as b
            ON b.user_id=a.id
            WHERE reg_no = '".$_GET['regno']."'
            AND user_type='student' LIMIT 1";

$result = mysqli_query($con,$query);
if($result) {
    $details = mysqli_fetch_assoc($result);
}

if(empty($details)) {
   die('User not found');
}

$details['school'] = "Michael Okpara University of Agriculture, Umudike";
?>

<html>
    <head>
        <title>Clearance Certificate</title>
        <style type="text/css">
                *{font-family: Arial, Helvetica, sans-serif;text-align: center;}
                
                .certificate {padding: 20px 30px;}
                
                h3, h4 {text-align: center; padding: 0px; margin: 1px;}
                
                .name {text-decoration: underline; text-transform: uppercase; font-weight: bold; font-size: 1.2em;}
                
                .stamp {text-align: center; height: 150px; width:100%; background: url('res/img/stamp.jpg') no-repeat center; background-size: contain;}
                
                .date{font-size: 0.8em; font-weight: bold;}
                
                .printbtn {border:0; font-weight: bolder; padding: 10px; background-color: #000000; color: #ffffff;}
                
                @media print {
                    .printbtn {display: none;}
                }
        </style>
    </head>
<body>
    <hr/>
    <div class="certificate">
	<h3><?=$details['school'];?></h3>
	<h4>(Student Affairs Department)</h4>
	<h4>Clearance Certificate</h4>
	<p>This is to certify that the bearer <span class="name"><?=$details['name'];?></span> 
	of Reg. No. <span class="name"><?=$details['reg_no'];?></span> of <span class="name"><?=$details['department'];?> / <?=$details['college'];?></span>
	has been cleared by all the relevant Colleges/Departments and therefore can be issued his/her statement of results.</p>
        <div class="stamp">
            <br/><br/><br/><br/>
            <span class="date">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo explode(" ", $details['completion_date'])[0];?>
            </span>
        </div>
    </div>
    <hr/>
    <br/><br/>
    <button class="printbtn" onclick="window.print();window.close()">Print Certificate</button>
</body>
</html>