<script>
var start = new Date();
$(document).ready(function(){
  
    $("#startdate").datepicker({
		format: "dd-mm-yyyy",
        todayBtn:  1,
		startDate : '01-01-2000',
        autoclose: true,
		endDate   : start
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
    });
    
    $("#enddate").datepicker({
		format: "dd-mm-yyyy",
        todayBtn:  1,
		startDate : '01-01-2000',
		endDate   : start,
        autoclose: true,
	}).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', minDate);
        });

});
</script>
<div id="myacc_1" class="tabcontent ">
        <div class="gamehis">
          <div class="report_head">
            <div class="gamehis_head">Game History</div>
            <div class="tbl_search">
              <form action="" method="post" name="gameHistroy">
				<div class="date_search" id="fromDate">
					<label for="startDate">From Date</label>
					<input type="text" placehoder="Start Date" id="startdate" name="startdate" value="<?= (!empty($start)?$start:''); ?>" readonly />
				</div>
				<div class="date_search" id="toDate">
					<label for="startDate">To Date</label>
					<input type="text" placehoder="End Date" id="enddate" name="enddate" value="<?= (!empty($end)?$end:''); ?>" readonly />
				</div>
			 
			<!--<div class="date_search"><label>From Date</label><input type="text"><img src="images/calendar.png"></div>
			<div class="date_search"><label>To Date</label><input type="text"><img src="images/calendar.png"></div>-->
			<div class="date_search"><button name="search" class="search_btn" type="submit">Search</button></div>
			</form>
            </div>
          </div>
          <div class="table_scroll">
			<?php if (!empty( $viewTickets )) { ?>
			<table class="table gamehis_table" id="myTable">
				<thead>
				  <tr>
					<th>Transaction ID</th>
					<th>Game Type</th>
					<!--<th>Name</th>-->
					<th class="bet_no">Ticket : Qty No</th>
					<!--<th class="bet_value"></th>-->
					<th>Total</th>
					<th>Total Win</th>
					<th>Win No</th>
					<th>Date</th>
				  </tr>
				</thead>
				<tbody>
				<?php 	$i=1;
					foreach ( $viewTickets as $view ){
						$class = 'eventable';
						if ( ($i%2) == 0){
							$class = 'oddtable';
						}
						$game_type = (!empty($view->BET_TYPE)?constant('BET_TYPE_'.$view->BET_TYPE):'');
						$game_name = (!empty($view->GAME_TYPE_ID)?constant('GAME_'.$view->GAME_TYPE_ID):'');
						$gameDiscription = (!empty($view->GAME_TYPE_ID)?constant('GAME_DESCRIPTION_'.$view->GAME_TYPE_ID):'');
						
						if($view->BET_NUMBER == '0'){
							$betValue = $view->BET_NUMBER.'-'.$view->BET_AMOUNT_VALUE;
						}else{
							$betValue = str_replace(':','-',str_replace('"','',str_replace(',',', ', substr($view->BET_VALUE, 1, -1))));
						}
					?>
				  <tr class="<?= $class ?>">
					<td><?= $view->INTERNAL_REFERENCE_NO; ?></td>
					<td title="<?=  $gameDiscription.' ( '.$game_type.' )'; ?>"><?=  $game_name.' ('.substr( $game_type,0,1 ).')'; ?></td>
					  <td class="bet_no"><?=  $betValue; ?></td>
					  <!-- <td class="bet_value"><? //=  str_replace(","," ",$view->BET_AMOUNT_VALUE); ?></td>-->
					<td><?= $view->TOTAL_BET; ?></td>
					<td><?= $view->TOTAL_WIN; ?></td>
					<td><?=  (!empty($view->WIN_NUMBER)?$view->WIN_NUMBER:''); ?></td>
					<td><?= date('d-m-Y h:i:s A', strtotime($view->CREATED_DATE)); ?></td>
				  </tr>
				  <?php 	$i++;}?>
				</tbody>
			  </table>
			  <?php }else { echo "<p class='text-center'>Record not available</p>";}?>
			  </div>
        </div>
      </div>
	  <script>
		$('.tablinks').removeClass('active');
		$('#game').addClass('active');
	</script>
<?php $this->load->view('common/report_footer'); ?>