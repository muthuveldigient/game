
        <!-- DataTables -->
 
        <?php $this->load->view('datatable_header'); ?>
		  <!-- /.box -->
			<div class="box-body" id="count_info">
            </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Transaction</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
				<th>Name</th>
				<th>Username</th>
				<th>Type</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Created On</th>
				<th>Action</th>
                </tr>
                </thead>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      <!-- DataTables -->
	  <!-- user status popup -->
	  <!-- user detail view popup -->
	  
	   <?php $this->load->view('datatable_footer'); ?>
	   <?php $this->load->view('transaction_status_popup'); ?>
	   <form id="partnerUser" action="<?php echo base_url()."administartion/edit"; ?>" method="post">
			<input type="hidden" name="partnerId" id="partnerId">
			<input type="hidden" id="csrf_test_name" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
	   </form>
<script>

	function totals(data){
		var count_data = '<button type="button" class="btn btn-info">Total Partner: '+data.recordsFiltered+'</button>';
		$('#count_info').html(count_data);
	}
	function partnerdetail(partnerId){
		
		$("#partnerId").val(partnerId);
		$("#partnerUser").submit();
		
	}
	//var adjust_point = SITEURL+"user/adjusttp";
	//var user_edit = SITEURL+"user/update";
	var recordsTotal = '';
  $(function () {
	
    //$('#example1').DataTable()
	var oTable = $('#example1').DataTable({
		"responsive": true,
		"pagingType": "numbers",
		"processing": true,
		"serverSide": true,"searching": false,
		"initComplete": function(settings, json){ 
			 var info = oTable.page.info();
			 var recordsTotal = info.recordsDisplay;
		 },
		"lengthMenu": [[10, 25, 50, recordsTotal], [10, 25, 50, "All"]],
		 "ajax": {
			"url": SITEURL+"administartion/partner/search",
			"type": "POST",
			"data": function ( d ) {
				d.name = $('#name').val()
				d.username = $('#username').val()
				d.csrf_test_name = $('#csrf_test_name').val()
				d.email = $('#email').val()
				d.contact_number = $('#contact_number').val()
				d.partner_type = $("#partner_type option:selected").val()
				d.selected_datatime = $("#selected_datatime").val()
			},
			"dataSrc": function (json) {
				totals(json); 
				return json.data; 
			},"error": function (e) {
				$('#datatable_error').modal('show');
			}
		},
		"columnDefs": [{ 
			"targets": 6, // user status use to active and deactive users.
			"data": "description",
			"render": function ( data, type, row, meta ) {
				if(row[7] == 0){ // status == 1 active
					var status =  '<span id="up_id'+row[6]+'"><i class="fa fa-lock"  onclick="status('+row[7]+','+row[6]+');" aria-hidden="true"></i></span>';
				}else{ // status == 2 deactive
					var status =  '<span id="up_id'+row[6]+'"><i class="fa fa-unlock" onclick="status('+row[7]+','+row[6]+');" aria-hidden="true"></i></span>';
				}
				return '<span style="cursor:pointer;" id="search_partner'+row[6]+'">'+ status +'&nbsp;&nbsp;<i class="fa fa-info-circle" onclick="usersetting('+row[7]+');" aria-hidden="true"></i>&nbsp;&nbsp;</span>'
				
			}
		  },
		  { 
			"targets": 0, // Set link to display user details .
			"data": "username",
			"render": function ( data, type, row, meta ) {
				return '<span style="cursor:pointer;"><a onclick="partnerdetail('+row[6]+');">'+row[0]+'</a></span>';
			}
		  },
		 ],
		"dom": 'lBfrtip',
		"buttons": [
		{"extend": 'excel', title: 'Transaction Details'},
		{"extend": 'pdf', title: 'Transaction Details'}
		]
	} );
	$("#search_user").click(function(){
		//oTable.api().ajax.reload();
		oTable.ajax.reload();
		
	});
	
	
  });
</script>