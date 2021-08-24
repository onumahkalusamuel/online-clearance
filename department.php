<?php
@session_start();

include_once('main.template.php');
include_once('functions.php');

if(isset($_POST['search'])) {
	fetchData($_POST, 'department');
	die();
}elseif(isset($_GET['update'])){
	updateData($_GET, 'department');
	die();
}
	$searchFields = loadSearch();

myheader("Department");
?>
	<div class="search_area">
	<div id="depts" style="display:none;"><?php print_r($searchFields['depts']);?></div>
		<!-- Search Area -->
		<form id="searchform" method="post" onsubmit="return false">
                    <div class="container-fluid">
                <div class="row">
			<div class="col-sm-3">
				<input type="text" id="search_term" placeholder="Name or Reg No" class="form-control" required />
			</div>
			<div class="col-sm-3">	
				<select id="college" class="form-control" required>
					<?=$searchFields['colleges'];?>
				</select>
			</div>
			<div class="col-sm-3">
				<select id="department" class="form-control" id="department" required>
				</select>
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
					<th>Completed Year 1</th>
					<th>Completed Year 2</th>
					<th>Completed Year 3</th>
					<th>Completed Year 4</th>
					<th>Completed Year 5</th>
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
								html += "<td class='sryr1_complete'>"+((aa[i]['yr1_complete'] == null)? 0: aa[i]['yr1_complete'])+"</td>";
								html += "<td class='sryr2_complete'>"+((aa[i]['yr2_complete'] == null)? 0: aa[i]['yr2_complete'])+"</td>";
								html += "<td class='sryr3_complete'>"+((aa[i]['yr3_complete'] == null)? 0: aa[i]['yr3_complete'])+"</td>";
								html += "<td class='sryr4_complete'>"+((aa[i]['yr4_complete'] == null)? 0: aa[i]['yr4_complete'])+"</td>";
								html += "<td class='sryr5_complete'>"+((aa[i]['yr5_complete'] == null)? 0: aa[i]['yr5_complete'])+"</td>";
								
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
			var yr1_complete = $(a+'>.sryr1_complete').html();
			var yr2_complete = $(a+'>.sryr2_complete').html();
			var yr3_complete = $(a+'>.sryr3_complete').html();
			var yr4_complete = $(a+'>.sryr4_complete').html();
			var yr5_complete = $(a+'>.sryr5_complete').html();

			html = "<div class='col-sm-2 col-sm-offset-2'>";
			html += "<input hidden name='user_id' value='"+me+"' />";
			html += "<label style='display:block;' for='name'>Name</label>";
			html += "<span id='name'>"+name+"</span></div>";		

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='yr1_complete'>Completed Year 1</label>";
			html += "<input name='yr1_complete' type='checkbox' "+((yr1_complete == '0') ? 'unchecked': 'checked')+" /></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='yr2_complete'>Completed Year 2</label>";
			html += "<input name='yr2_complete' type='checkbox' "+((yr2_complete == '0') ? 'unchecked': 'checked')+" /></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='yr3_complete'>Completed Year 3</label>";
			html += "<input name='yr3_complete' type='checkbox' "+((yr3_complete == '0') ? 'unchecked': 'checked')+" /></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='yr4_complete'>Completed Year 4</label>";
			html += "<input name='yr4_complete' type='checkbox' "+((yr4_complete == '0') ? 'unchecked': 'checked')+" /></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='yr5_complete'>Completed Year 5</label>";
			html += "<input name='yr5_complete' type='checkbox' "+((yr5_complete == '0') ? 'unchecked': 'checked')+" /></div>";

			html += "<div class='col-sm-1'>";
			html += "<button id='update_btn' onclick='doUpdate();' class='btn btn-primary'> Update </button> </div>";
			html += "<div class='col-sm-2'></div>";

			$('.update_info').html(html);
			$(".hideable").hide();
			$(".update_details").show();
		}
	</script>
<?php
myfooter();