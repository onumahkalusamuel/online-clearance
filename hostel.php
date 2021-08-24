<?php
@session_start();

include_once('main.template.php');
include_once('functions.php');

if(isset($_POST['search'])) {
	fetchData($_POST, 'hostel');
	die();
}elseif(isset($_GET['update'])){
	updateData($_GET, 'hostel');
	die();
}
	$searchFields = loadSearch();

myheader("Hostel");
/* 
1. I need to collect student record.
	first I give search box to get student name and reg no
	based on department and college.
	once I select a student, I can update the following records:
	- paid (hostel fees in full)
	- stolen (any hostel item)
	- broken (any item in the hostel)

	you can view and edit student hostel records.	
*/
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
					<th>Not Owing</th>
					<th>Not Stolen</th>
					<th>Not Broken</th>
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
								html += "<td class='srpaid'>"+((aa[i]['paid'] == null)? 0: aa[i]['paid'])+"</td>";
								html += "<td class='srstolen'>"+((aa[i]['stolen'] == null)? 0: aa[i]['stolen'])+"</td>";
								html += "<td class='srbroken'>"+((aa[i]['broken'] == null)? 0: aa[i]['broken'])+"</td>";
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
			var paid = $(a+'>.srpaid').html();
			var stolen = $(a+'>.srstolen').html();
			var broken = $(a+'>.srbroken').html();

			html = "<div class='col-sm-2 col-sm-offset-3'>";
			html += "<input hidden name='user_id' value='"+me+"' />";
			html += "<label style='display:block;' for='name'>Name</label>";
			html += "<span id='name'>"+name+"</span></div>";		

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='paid'>Paid</label>";
			html += "<input name='paid' type='checkbox' "+((paid == '0') ? 'unchecked': 'checked')+" /></div>";
			
			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='stolen'>Stolen</label>";
			html += "<input name='stolen' type='checkbox' "+((stolen == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='broken'>Broken</label>";
			html += "<input name='broken' type='checkbox' "+((broken == '0') ? 'unchecked': 'checked')+"/></div>";
			
			html += "<div class='col-sm-1'>";
			html += "<button id='update_btn' onclick='doUpdate();' class='btn btn-primary'> Update </button> </div>";
			html += "<div class='col-sm-3'></div>";

			$('.update_info').html(html);
			$(".hideable").hide();
			$(".update_details").show();
		}
	</script>
<?php
myfooter();