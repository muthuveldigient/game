<div class="modal fade" id="partner_status" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Partner status update.</h4>
			</div>
			<div class="modal-body">
				Do you really want to update partner status.
			</div>
			<div class="modal-footer">
			  <span id="update_reg_status"></span>
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	  </div>
	  	<input type="hidden" id="csrf_test_name1" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />

<script>
function status(status,partner_id){
	
	$("#update_reg_status").html("");
	var newstatus ='<button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_status('+status+','+partner_id+');">Ok</button>';
	$("#update_reg_status").html(newstatus);
	$('#partner_status').modal('toggle');

}
var adjust_point = SITEURL+"user/adjusttp";

function update_status(status,partner_id){
	
	var csrf_test_name1 = $("#csrf_test_name1").val();
	 if(status == 1){
		status = 0;
		var newstatus ='<i class="fa fa-lock" onclick="status('+status+','+partner_id+');" aria-hidden="true"></i>';
	}else{
		status = 1;
		var newstatus ='<i class="fa fa-unlock" onclick="status('+status+','+partner_id+');" aria-hidden="true"></i>';
	}
	$.ajax
	({
		type: "POST",
		url: SITEURL+"administartion/partner/update_status",
		data: {'status':status,'partner_id':partner_id,'csrf_test_name':csrf_test_name1},
		cache: false,
		success: function(msg)
		{
			if(msg == 1){
				$("#up_id"+partner_id).html(newstatus);	
			}
			
		} 
	});

}
</script>