
        <!-- DataTables -->
 
        <?php $this->load->view('datatable_header'); ?>
		  <!-- /.box -->
			<div class="box-body" id="count_info">
            </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Player</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
				<th>Full Name</th>
				<th>Username</th>
				<th>Email</th>
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
	   <?php $this->load->view('player_status_popup'); ?>
	   <!-- action="<?php //echo base_url()."player/player_register/get_player_details"; ?>" -->
	   <form id="playerUser" method="post">
			<input type="hidden" name="playerId" id="playerId">
			<input type="hidden" id="csrf_test_name" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
	   </form>

<script>

	function totals(data) {
		var count_data = '<button type="button" class="btn btn-info">Total Partner: '+data.recordsFiltered+'</button>';
		$('#count_info').html(count_data);
	}

	function playerdetail(playerId, action) {
		
		if ( action == 'adjust_points' ) {
			$('#playerUser').attr('action', '<?php echo base_url(); ?>player/player_points/get_player_points');
		} else {
			$('#playerUser').attr('action', '<?php echo base_url(); ?>player/player_register/get_player_details');
		}
		$("#playerId").val(playerId);
  		$('#playerUser').submit();
	}

	var recordsTotal   = '';
	var adjust_points  = "adjust_points";
	var player_details = "player_details";

  	$(function () {

	    //$('#example1').DataTable()
		var oTable = $('#example1').DataTable({
			"responsive": true,
			"pagingType": "numbers",
			"processing": true,
			"serverSide": true,
			"searching": false,
			"initComplete": function(settings, json){ 
				 var info 		  = oTable.page.info();
				 var recordsTotal = info.recordsDisplay;
			 },
			"lengthMenu": [[10, 25, 50, recordsTotal], [10, 25, 50, "All"]],
			 "ajax": {
				"url": SITEURL+"player/player_search/search",
				"type": "POST",
				"data": function ( d ) {
					d.csrf_test_name 	= $('#csrf_test_name').val()
					d.username 			= $('#username').val()
					d.email 			= $('#email').val()
					d.selected_datatime = $("#selected_datatime").val()
					d.login_type 		= $('#login_type').val()
					d.status 			= $("#status option:selected").val()
				},
				"dataSrc": function (json) {
					totals(json); 
					return json.data; 
				},"error": function (e) {
					$('#datatable_error').modal('show');
				}
			},
			"columnDefs": [
				{ "targets": 4, // user status use to active and deactive users.
				"data": "description",
				"render": function ( data, type, row, meta ) {
					if( row[4] == 0 ) { // status == 1 active
						var status_html =  '<span id="up_id'+row[5]+'"><i class="fa fa-lock"  onclick="status('+row[4]+','+row[5]+');" aria-hidden="true"></i></span>';
					} else { // status == 2 deactive
						var status_html =  '<span id="up_id'+row[5]+'"><i class="fa fa-unlock" onclick="status('+row[4]+','+row[5]+');" aria-hidden="true"></i></span>';
					}
					return '<span style="cursor:pointer;" id="search_player'+row[5]+'">'+ status_html +'&nbsp;&nbsp;<i class="fa fa-info-circle" title="Adjust Points" onclick="playerdetail('+row[5]+','+adjust_points+');" aria-hidden="true"></i>&nbsp;&nbsp;</span>'
				} }, 
				{ "targets": 0, // Set link to display user details .
				"data": "username",
				"render": function ( data, type, row, meta ) {
					return '<span style="cursor:pointer;"><a onclick="playerdetail('+row[5]+','+player_details+');">'+row[0]+'</a></span>';
				} },
			],
			"dom": 'lBfrtip',
			"buttons": [
			{"extend": 'excel', title: 'Player Details'},
			{"extend": 'pdf', title: 'Player Details'}
			]
		});

		$("#search_player").click(function(){
			oTable.ajax.reload();
		});
	
    });
</script>