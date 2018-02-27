<div id="myacc_3" class="tabcontent " >
    <div class="gamehis ">
        <div class="report_head">
            <div class="gamehis_head">User Profile</div>
        </div>
        <div class="usr_det_1 table_scroll">
            <table class="table gamehis_table" id="myTable" style="margin-bottom:15px;">
                <thead>
                    <tr>
                        <th>UserName</th>
                        <th>Email ID</th>
                        <th>Contact</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= (!empty($getTerminalBal[0]->USERNAME) ? strtoupper($getTerminalBal[0]->USERNAME) : '--'); ?></td>
                        <td><?= (!empty($getTerminalBal[0]->EMAIL_ID) ? strtoupper($getTerminalBal[0]->EMAIL_ID) : '--'); ?></td>
                        <td><?= (!empty($getTerminalBal[0]->CONTACT) ? strtoupper($getTerminalBal[0]->CONTACT) : '--'); ?></td>
                        <td><?php echo (!empty($getTerminalBal[0]->USER_TOT_BALANCE) ? $getTerminalBal[0]->USER_TOT_BALANCE : '0000'); ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.tablinks').removeClass('active');
    $('#user').addClass('active');
</script>
<?php $this->load->view('common/report_footer'); ?>