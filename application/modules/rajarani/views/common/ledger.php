<script type="text/javascript">

var start = new Date();
$(document).ready(function(){
  
    $("#startdate").datepicker({
		format: "yyyy-mm-dd",
        todayBtn:  1,
		startDate : '2000-01-01',
        autoclose: true,
		endDate   : start
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
    });
    
    $("#enddate").datepicker({
		format: "yyyy-mm-dd",
        todayBtn:  1,
		startDate : '2000-01-01',
		endDate   : start,
        autoclose: true,
	}).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', minDate);
        });

});
</script>
      <div id="myacc_2" class="tabcontent ">
        <div class="gamehis">
          <div class="report_head">
            <div class="gamehis_head">Ledger</div>
			<div class="tbl_search">
              <form action="" method="post" name="ledger">
					<div class="date_search" id="fromDate">
						<label for="startDate">From Date</label>
						<input type="text" placehoder="Start Date" id="startdate" name="startdate" value="<?= (!empty($start)?$start:''); ?>" readonly/>
					</div>
					<div class="date_search" id="toDate">
						<label for="startDate">To Date</label>
						<input type="text" placehoder="End Date" id="enddate" name="enddate" value="<?= (!empty($end)?$end:''); ?>" readonly/>
					</div>
				 
				<!--<div class="date_search"><label>From Date</label><input type="text"><img src="images/calendar.png"></div>
				<div class="date_search"><label>To Date</label><input type="text"><img src="images/calendar.png"></div>-->
				<div class="date_search"><button name="search" class="search_btn" type="submit">Search</button></div>
			</form>
            </div>
          </div>
          <div class="table_scroll">
			<?php  if (!empty( $transaction )) { ?>
			<table class="table gamehis_table" id="myTable">
				<thead>
				  <tr>
					<th>Transaction ID</th>
					<th>Old Points</th>
					<th>In</th>
					<th>Out</th>
					<th>Current Points</th>
					<th>Date</th>
				  </tr>
				</thead>
				<tbody>
				<?php 	$i = 1;
				foreach ( $transaction as $view ) {
					$class = 'eventable';
					if (($i % 2) == 0) {
						$class = 'oddtable';
					}
					$in = '---';
					$out = '---';
					//11 bet
					/* if (in_array($view->TRANSACTION_TYPE_ID,array(10,11))) {
						$out = $view->TRANSACTION_AMOUNT;
					}
					//12 - win
					if (in_array($view->TRANSACTION_TYPE_ID,array(8,9,12))) {
						$in = $view->TRANSACTION_AMOUNT;
					} */
						
						if ( $view->CURRENT_TOT_BALANCE < $view->CLOSING_TOT_BALANCE ) {
							$in = $view->TRANSACTION_AMOUNT;
						}else{
							$out = $view->TRANSACTION_AMOUNT;
						}
					
						?>
					  <tr class="<?= $class ?>">
						<td><?= $view->INTERNAL_REFERENCE_NO; ?></td>
						<td><?= $view->CURRENT_TOT_BALANCE; ?></td>
						<td><?= $in; ?></td>
						<td><?= $out; ?></td>
						<td><?= $view->CLOSING_TOT_BALANCE; ?></td>
						<td><?= date('d-m-Y h:i A', strtotime($view->TRANSACTION_DATE)); ?></td>
					  </tr>
				  <?php 	$i++;}	?>
				</tbody>
			  </table>
			  <?php }else { echo "<p class='text-center'>Record not available</p>";}?>
			  </div>
        </div>
      </div>
	  <script>
		$('.tablinks').removeClass('active');
		$('#ledger').addClass('active');
	</script>
<?php $this->load->view('common/report_footer'); ?>