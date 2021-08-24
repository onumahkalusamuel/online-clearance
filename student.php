<?php
@session_start();

if( ! isset( $_SESSION['user_id'] ) ) {
	header('location: ./');
	die();
}

$user_id = $_SESSION['user_id'];
$regno = $_SESSION['regno'];

if(isset($_POST['section'])) {
	include_once('functions.php');
	doClearance($_POST['section'], $_POST['user_id']);
	die();
}

include_once("main.template.php");

myheader("Clearance Page");
?>



<div class="container-fluid">
    <div id="cleared" class="alert alert-success" role="alert" style="display:none;">
        <i class="fa fa-check-circle"></i>
        &nbsp;&nbsp;You have completed your clearance. Please proceed to print your clearance certificate.
        <a href="printcert.php?regno=<?php echo $regno; ?>" target="__blank">Print Clearance Certificate</a>
        <span href='#' class="pull-right fa fa-times"style="cursor: pointer;" onclick="$(this).parent().hide();"></span>&nbsp;&nbsp;
    </div>

    <div id="not_cleared" class="alert alert-danger" role="alert" style="display:none;">
        <i class="fa fa-exclamation-circle"></i>
        &nbsp;&nbsp;Your records are not cleared yet. Please visit the offices in charge of the below red-marked departments to resolved the issue. Thanks.
        <span href='#' class="pull-right fa fa-times"style="cursor: pointer;" onclick="$(this).parent().hide();"></span>&nbsp;&nbsp;
    </div>

    <div class="panel panel-default">
        <div id="container outer" class="panel-body">
            <div id="innerClearance" class="list-group">
                <div class="item" id="department">
                    <i class="fa fa-times"></i>
                    <input hidden type="checkbox" name="department"  />
                    <span class="item_title">Department</span>
                </div>
                <div class="item" id="hostel">
                    <i class="fa fa-times"></i>
                    <input hidden type="checkbox" name="hostel"  />
                    <span class="item_title">Hostel</span>
                </div>

                <div class="item" id="security">
                    <i class="fa fa-times"></i>
                    <input hidden type="checkbox" name="security"  />
                    <span class="item_title">Security</span>
                </div>

                <div class="item" id="medicals">
                    <i class="fa fa-times"></i>
                    <input hidden type="checkbox" name="medicals"  />
                    <span class="item_title">Medicals</span>
                </div>

                <div class="item" id="bursary">
                    <i class="fa fa-times"></i>
                    <input hidden type="checkbox" name="bursary"  />
                    <span class="item_title">Bursary</span>
                </div>

                <div class="item" id="student_affairs">
                    <i class="fa fa-times"></i>
                    <input hidden type="checkbox" name="student_affairs"  />
                    <span class="item_title">Student Affairs</span>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="buttons">
                <button id="start_clearance" class="btn btn-primary">
                    <i class="fa fa-send"></i>&nbsp;<span>Start Clearance</span>
                </button>
                <button id="cancel" class="btn btn-danger">
                    <i class="fa fa-times"></i>&nbsp;Cancel
                </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	
	user_id = "<?php echo $_SESSION['user_id'] ?>";

	$("#start_clearance").on("click", function(){
		$(this).attr('disabled','disabled');
		$(this).siblings().attr('disabled','disabled');

		//the actual start of clearance
		async function myClearance() {
			var ids = Array();
			var items = $('.item').each(function(){
				id = $(this).attr('id');
				ids.push(id);
			});

			for (var i = 0; i < ids.length; i++) {
				
				if($("#"+ids[i]+">input").attr('checked') == 'checked'){
					$("#"+ids[i]+">i").removeClass();
					$("#"+ids[i]+">i").addClass('fa fa-check');
				} else {
					$("#"+ids[i]+">i").removeClass();
					$("#"+ids[i]+">i").addClass('fa fa-spinner fa-spin');
				}

				await new Promise(next => {
					
					setTimeout(function(){
					
						$.ajax({
					
							type:'post',
							data: {'section': ids[i], 'user_id': user_id},
					
							success: function(response) {
								console.log(response);
								var json = JSON.parse(response);
								if (json.error == true) {
									$("#"+json.message).addClass("text text-danger");
									$("#"+json.message+">i").removeClass();
									$("#"+json.message+">i").addClass('fa fa-times');
								} else if(json.success == true) {
									$("#"+json.message).addClass("text text-success");
									$("#"+json.message+">input").attr('checked', 'checked');
									$("#"+json.message+">i").removeClass();
									$("#"+json.message+">i").addClass('fa fa-check');
								}
								next();
							},
					
							error: function() {
							}
						});

					}, 2000);
				});
				//do post clearance
			}

			function postClearance() {
				var ch = Array();
				for (var i = 0; i < ids.length; i++) {
					// $(".buttons").hide();
					var a = $("#"+ids[i]+">input").attr('checked');
					console.log(a);
					if( a == null ) {
						var not_cleared = true;
					}
				}
				console.log(ch);

				if( not_cleared ) {
					$('#not_cleared').show();
				} else {
					$('#cleared').show();
				}
			}
			postClearance();
		}

		myClearance();

	});
</script>

<?php 
myfooter();