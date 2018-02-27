 <script>
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
        autoclose: true,
        endDate   : start
	}).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', minDate);
        });

});
</script>
      <div id="myacc_4" class="tabcontent ">
        <div class="gamehis">
          <div class="report_head">
            <div class="gamehis_head">Draw History</div>
            <div class="tbl_search">
              <form action="" method="post" name="drawHistroy">
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
			<?php if (!empty( $result )) { ?>
			<table class="table gamehis_table" id="myTable">
				<thead>
				  <tr>
					<th>DRAW TIME</th>
					<th title="<?= GAME_DESCRIPTION_1; ?>"><?= GAME_1; ?></th>
					<th title="<?= GAME_DESCRIPTION_2; ?>"><?= GAME_2; ?></th>
					<th title="<?= GAME_DESCRIPTION_3; ?>"><?= GAME_3; ?></th>
					<th title="<?= GAME_DESCRIPTION_4; ?>"><?= GAME_4; ?></th>
					<th title="<?= GAME_DESCRIPTION_5; ?>"><?= GAME_5; ?></th>
					<th title="<?= GAME_DESCRIPTION_6; ?>"><?= GAME_6; ?></th>
					<th title="<?= GAME_DESCRIPTION_7; ?>"><?= GAME_7; ?></th>
					<th title="<?= GAME_DESCRIPTION_8; ?>"><?= GAME_8; ?></th>
					<th title="<?= GAME_DESCRIPTION_9; ?>"><?= GAME_9; ?></th>
					<th title="<?= GAME_DESCRIPTION_10; ?>"><?= GAME_10; ?></th>
				  </tr>
				</thead>
				<tbody>
				<?php 	$i=1;
					foreach ( $result as $day ){
						$class = 'eventable';
						if ( ($i%2) == 0){
							$class = 'oddtable';
						}
						
						$numb1 = array();
						$win1 ='';
						$time = (!empty($day->DRAW_STARTTIME)?date('d-m-Y h:i A',strtotime($day->DRAW_STARTTIME)):'');
						if(!empty($day->DRAW_WINNUMBER)){
							$win1 = json_decode($day->DRAW_WINNUMBER, true);
						}
					?>
				  <tr class="<?= $class ?>">
					<td><?= $time; ?></td>
					<td><?= (isset($win1['double'][1])?$win1['double'][1]:'--'); ?></td>
					<td><?= (isset($win1['double'][2])?$win1['double'][2]:'--'); ?></td>
					<td><?= (isset($win1['double'][3])?$win1['double'][3]:'--'); ?></td>
					<td><?= (isset($win1['double'][4])?$win1['double'][4]:'--'); ?></td>
					<td><?= (isset($win1['double'][5])?$win1['double'][5]:'--'); ?></td>
					<td><?= (isset($win1['double'][6])?$win1['double'][6]:'--'); ?></td>
					<td><?= (isset($win1['double'][7])?$win1['double'][7]:'--'); ?></td>
					<td><?= (isset($win1['double'][8])?$win1['double'][8]:'--'); ?></td>
					<td><?= (isset($win1['double'][9])?$win1['double'][9]:'--'); ?></td>
					<td><?= (isset($win1['double'][10])?$win1['double'][10]:'--'); ?></td>
				  </tr>
				  <?php 	$i++;}?>
				</tbody>
			  </table>
			  <?php }else { echo "<p class='text-center'>Record not available</p>";}?>
			  </div>
          </table>
        </div>
      </div>
    </div>
	<script>
		$('.tablinks').removeClass('active');
		$('#draw').addClass('active');
	</script>
<?php $this->load->view('common/report_footer'); ?>