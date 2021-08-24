<?php

include("db.con.php");

function loadSearch() {
	
	$file = 'res/collegedept.txt';

	if( ! file_exists($file) ){
		return json_encode('default');
	}

	$file = file_get_contents($file);

	$exp = explode( 'COLLEGE', $file );

	$h = '';
	foreach($exp as $full) {
		if( $full ) {
			$ex = explode( 'DEPARTMENTS', trim( $full ) );
			$de = explode(',', trim($ex[1]));
			$h .= "<div class='" . $ex[0] . "'><option>" . implode('</option><option>', $de) . "</option></div>";	
			$col[] = $ex[0];
		}
	}
	$return['depts'] = $h;
	$return['colleges'] = "<option>" . implode('</option><option>', $col) . "</option>" ;

	return $return;
}

function fetchData($post, $requested) {

	global $con;

	$college = $post['college'];
	$department = $post['department'];
	$search_term = $post['search_term'];

	$query = "SELECT d.id, d.name, d.reg_no, r.*
				FROM users as d
					LEFT JOIN $requested as r
						ON d.id = r.user_id
				WHERE (
					(d.name LIKE '%$search_term%')
					| (d.reg_no LIKE '%$search_term%')
				)
				AND d.college = '$college'
				AND d.department = '$department'";

	$result = mysqli_query($con, $query);

	while ($r = mysqli_fetch_assoc($result)) {
		$return[] = $r;
	}

	if( ! isset($return) ) {
		$return = 0;
	}
	echo json_encode($return);
	return;
}

function updateData($data, $requested) {

	global $con;
	unset($data['update']);
	$user_id = $data['user_id'];
	$query1 = "SELECT * FROM $requested WHERE user_id='$user_id' LIMIT 1";
	$result = mysqli_query($con, $query1);
	$r = mysqli_fetch_assoc($result);

	if( ! $r ) {

		$query2 = "INSERT INTO $requested(user_id) VALUES('$user_id')";
		mysqli_query($con, $query2);
		$result = mysqli_query($con, $query1);
		$r = mysqli_fetch_assoc($result);
	}

	foreach ($r as $key => $value) {
		$update[$key] = "0";
	}
	unset($update['user_id']);
	
	if (! empty ( $data ) ) {
		foreach( $data as $key => $val ) {
			if( $val == 'on' )
				$update[$key] = "1";
		}
	}

	//prepare for update online
	foreach( $update as $key => $value) {
		$up[] = "$key='$value'";
	}

	$a = implode(',', $up);

	//do the update
	$updateQuery = "UPDATE $requested SET {$a} WHERE user_id='$user_id'";

	$b = mysqli_query($con, $updateQuery);

	if( $b ) {

		echo "updated";
	}

	return;
}

function doClearance($section, $user_id) {
	global $con;
	$return['error'] = true;

	$query1 = "SELECT * FROM $section WHERE user_id='$user_id' LIMIT 1";
	$result = mysqli_query($con, $query1);
	$r = mysqli_fetch_assoc($result);

	if( ! $r ) {
		$query2 = "INSERT INTO $section(user_id) VALUES('$user_id')";
		mysqli_query($con, $query2);
		// doClearance($section, $user_id);
		$return['message'] = $section;
		echo json_encode($return);
		return;
	}
	unset($r['user_id']);

	if ( $section == 'student_affairs' ) {
		unset($r['student_affairs']);
		unset($r['completion_date']);
	}

	if( $r ) {
		foreach($r as $it) {
			if($it == 0){
				$return['message'] = $section;
				echo json_encode($return);
				return;
			}
		}
	}

	//check if the record exists first
	$query = "SELECT 1 FROM student_affairs WHERE user_id='$user_id'";
	$run = mysqli_query($con, $query);

	if (mysqli_num_rows($run) != 1 ) {
		$query = "INSERT INTO student_affairs(user_id) VALUES($user_id)";
		$run = mysqli_query($con, $query);
	}

	//then verify and update the status on student affairs table
	$query = "SELECT $section FROM student_affairs WHERE user_id='$user_id'";
	
	$run = mysqli_query($con, $query);

	if(mysqli_fetch_assoc($run)[$section] != 1 ) {
		//condition the query for student_affairs
		$set = "$section = 1";
		if ( $section == 'student_affairs' ) {
			$set .= ", completion_date = NOW()";
		}

		$query = "UPDATE student_affairs SET $set WHERE user_id='$user_id';";

		$run = mysqli_query($con, $query);
	}

	$return['success'] = true;
	unset($return['error']);
	$return['message'] = $section;
	echo json_encode($return);
}
