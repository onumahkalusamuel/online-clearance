<?php
@session_start();

include_once('main.template.php');
include_once('functions.php');

if(isset($_POST['search'])) {
	fetchData($_POST, 'bursary');
	die();
}elseif(isset($_GET['update'])){
	updateData($_GET, 'bursary');
	die();
}
	$searchFields = loadSearch();

myheader("Bursary");
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
					<th>Acceptance Fees</th>
					<th>Year 1 Fees</th>
					<th>Year 2 Fees</th>
					<th>Year 3 Fees</th>
					<th>Year 4 Fees</th>
					<th>Year 5 Fees</th>
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
								html += "<td class='sraccept_fees'>"+((aa[i]['accept_fees'] == null)? 0: aa[i]['accept_fees'])+"</td>";
								html += "<td class='srsch_fees_yr1'>"+((aa[i]['sch_fees_yr1'] == null)? 0: aa[i]['sch_fees_yr1'])+"</td>";
								html += "<td class='srsch_fees_yr2'>"+((aa[i]['sch_fees_yr2'] == null)? 0: aa[i]['sch_fees_yr2'])+"</td>";
								html += "<td class='srsch_fees_yr3'>"+((aa[i]['sch_fees_yr3'] == null)? 0: aa[i]['sch_fees_yr3'])+"</td>";
								html += "<td class='srsch_fees_yr4'>"+((aa[i]['sch_fees_yr4'] == null)? 0: aa[i]['sch_fees_yr4'])+"</td>";
								html += "<td class='srsch_fees_yr5'>"+((aa[i]['sch_fees_yr5'] == null)? 0: aa[i]['sch_fees_yr5'])+"</td>";
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
			var accept_fees = $(a+'>.sraccept_fees').html();
			var sch_fees_yr1 = $(a+'>.srsch_fees_yr1').html();
			var sch_fees_yr2 = $(a+'>.srsch_fees_yr2').html();
			var sch_fees_yr3 = $(a+'>.srsch_fees_yr3').html();
			var sch_fees_yr4 = $(a+'>.srsch_fees_yr4').html();
			var sch_fees_yr5 = $(a+'>.srsch_fees_yr5').html();

			html = "<div class='col-sm-2 col-sm-offset-1'>";
			html += "<input hidden name='user_id' value='"+me+"' />";
			html += "<label style='display:block;' for='name'>Name</label>";
			html += "<span id='name'>"+name+"</span></div>";		

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='accept_fees'>Acceptance Fees</label>";
			html += "<input name='accept_fees' type='checkbox' "+((accept_fees == '0') ? 'unchecked': 'checked')+" /></div>";
			
			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='sch_fees_yr1'>Year 1 Fees</label>";
			html += "<input name='sch_fees_yr1' type='checkbox' "+((sch_fees_yr1 == '0') ? 'unchecked': 'checked')+"/></div>";
			
			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='sch_fees_yr2'>Year 2 Fees</label>";
			html += "<input name='sch_fees_yr2' type='checkbox' "+((sch_fees_yr2 == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='sch_fees_yr3'>Year 3 Fees</label>";
			html += "<input name='sch_fees_yr3' type='checkbox' "+((sch_fees_yr3 == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='sch_fees_yr4'>Year 4 Fees</label>";
			html += "<input name='sch_fees_yr4' type='checkbox' "+((sch_fees_yr4 == '0') ? 'unchecked': 'checked')+"/></div>";

			html += "<div class='col-sm-1'>";
			html += "<label style='display:block;' for='sch_fees_yr5'>Year 5 Fees</label>";
			html += "<input name='sch_fees_yr5' type='checkbox' "+((sch_fees_yr5 == '0') ? 'unchecked': 'checked')+"/></div>";

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