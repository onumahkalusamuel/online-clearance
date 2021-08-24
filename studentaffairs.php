<?php
@session_start();

include_once('main.template.php');
include_once('functions.php');

if(isset($_POST['search'])) {
	fetchData($_POST, 'student_affairs');
	die();
}elseif(isset($_GET['update'])){
	updateData($_GET, 'student_affairs');
	die();
}
	$searchFields = loadSearch();
myheader("Student Affairs");
?>
	<div class="search_area">
	<div id="depts" style="display:none;"><?php print_r($searchFields['depts']);?></div>
		<!-- Search Area -->
		<form id="searchform" method="post" onsubmit="return false">
			<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" id="search_term" placeholder="Name or Reg No" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select id="college" class="form-control" required>
                                <?=$searchFields['colleges'];?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select id="department" class="form-control" id="department" required>
                            </select>
                        </div>
                    </div>
                    <div class=" col-sm-3">
                        <button id="search" class="btn btn-primary form-control">Search</button>
                    </div>
                </div>
            </div>
		</form>
	</div>
	<!-- Display Search Results -->
	<hr class="divider" />
	<div class="container-fluid">
        <div class="search_results hideable panel panel-default" style="display:none;">
            <div class="panel-heading text-center">

                <h6><i class="fa fa-search"></i> &nbsp;<span>Search Results</span></h6>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="result table table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>Security</th>
                            <th>Medicals</th>
                            <th>Hostel</th>
                            <th>Bursary</th>
                            <th>Department</th>
                            <th>General</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="search_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<!-- Message Container -->
	<div class="hideable message_container text-center" style="display:none;">
		<h3 class="text-muted">Messsage</h3>
		<p class="message text-muted"></p>
	</div>
	<!-- Edit and Update Details -->
	<div class="update_details hideable text-center" style="text-align:center; display:none;">
	<h3 class="text-muted">Update Details</h3>
		<hr class="divider" />
		<form class="update_info col-sm-12" method="post" onsubmit="return false">
		</form>
	</div>
	<script type="text/javascript">
		$('#college').on('change', function() {
			changeDepts($(this).val());
		});

		$('#search').on('click',function(){
			if($('#searchform').valid()){
				//hide all hideables
				$(".hideable").hide();
				var data = {'search_term':$("#search_term").val(),
						'college':$("#college").val(),
						'department':$("#department").val(),
						'search': true};
				$.ajax({
					type:'POST',
					data: data,
					success: function(response) {
						if(response != 0) {

							var aa = JSON.parse(response);
							var html = "";
							for(i=0; i< aa.length; i++){

								var id = aa[i]['id'];

								html += "<tr id='row"+id+"'>";
								html += "<td>"+(i+1)+"</td>";
								html += "<td class='srname'>"+(aa[i]['name'])+"</td>";
								html += "<td>"+(aa[i]['reg_no'])+"</td>";
								html += "<td class='srsecurity'>"+((aa[i]['security'] == null)? 0: aa[i]['security'])+"</td>";
								html += "<td class='srmedicals'>"+((aa[i]['medicals'] == null)? 0: aa[i]['medicals'])+"</td>";
								html += "<td class='srhostel'>"+((aa[i]['hostel'] == null)? 0: aa[i]['hostel'])+"</td>";
								html += "<td class='srbursary'>"+((aa[i]['bursary'] == null)? 0: aa[i]['bursary'])+"</td>";
								html += "<td class='srdepartment'>"+((aa[i]['department'] == null)? 0: aa[i]['department'])+"</td>";
								html += "<td class='srstudent_affairs'>"+((aa[i]['student_affairs'] == null)? 0: aa[i]['student_affairs'])+"</td>";
								html += "<td><a onclick='showUpdate("+id+")' class='fa fa-2x fa-edit edit' id='"+id+"' href='#'></a></td>";
								html += "</tr>";
							}

							$("#search_tbody").html(html);
							$(".search_results").show();
						} else {
							$(".message").html("Nothing found.");
							$(".message_container").show();
						}
					},
					error: function() {
						$(".message").html("An error occured. Please try again later.");
						$(".message_container").show();
					}
				});
			} else {
				// preventDefault();
			}
		});
		function showUpdate(me) {
			
			var a = '#row'+me;
			var name = $(a+'>.srname').html();
			var security = $(a+'>.srsecurity').html();
			var medicals = $(a+'>.srmedicals').html();
			var hostel = $(a+'>.srhostel').html();
			var bursary = $(a+'>.srbursary').html();
			var department = $(a+'>.srdepartment').html();
			var student_affairs = $(a+'>.srstudent_affairs').html();

			html = "<div class='row'>";

			html += "<div class='col-sm-2 col-sm-offset-1'>";
			html += "<input hidden name='user_id' value='"+me+"' />";
			html += "<label style='display:block;' for='name'>Name</label>";
			html += "<span id='name'>"+name+"</span></div>";		

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='security'>Security</label>";
			html += "<input name='security' type='checkbox' "+((security == '0') ? 'unchecked': 'checked')+" /></div>";
			
			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='medicals'>Medicals</label>";
			html += "<input name='medicals' type='checkbox' "+((medicals == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='hostel'>Hostel</label>";
			html += "<input name='hostel' type='checkbox' "+((hostel == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='bursary'>Bursary</label>";
			html += "<input name='bursary' type='checkbox' "+((bursary == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='department'>Department</label>";
			html += "<input name='department' type='checkbox' "+((department == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='student_affairs'>Student Affairs</label>";
			html += "<input name='student_affairs' type='checkbox' "+((student_affairs == '0') ? 'unchecked': 'checked')+"/></div>";
			
			html += "<div class='col-sm-1'>";
			html += "<button id='update_btn' onclick='doUpdate();' class='btn btn-primary'> Update </button> </div>";

            html += "<div class='col-sm-2'>";
			html += "</div>";

			$('.update_info').html(html);
			$(".hideable").hide();
			$(".update_details").show();
		}
	</script>
<?php
myfooter();