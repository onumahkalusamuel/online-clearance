$(document).ready(function(){
	var a = $('#college').val();
	changeDepts(a);
});

function changeDepts(college){
	var html = $("#depts>."+college).html();
	$("#department").html(html);
}

function doUpdate() {
	$(".hideable").hide();
	$(".update_details").show();
	var data = $(".update_info").serialize();
	$.ajax({
		type:'get',
		url: '?update=true&'+data,
		success: function(response){
			$(".hideable").hide();
			//alert(response);
			if(response.match("updated")) {
						$(".message").html("Update successful. Do a re-search to verify.");
			} else {
				$(".message").html("Error updating details. Please retry later.");
			}
			$(".message_container").show();
		},
		error: function(){
			$(".hideable").hide();
			$(".message").html("Something went wrong. Please retry later.");
			$(".message_container").show();
		}
	});
}
/*FOR FOOTER*/

window.showFullFooter = true;