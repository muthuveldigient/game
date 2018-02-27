 <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  Adjust Points
               </h1>
               <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                  <li><a href="#">Player</a></li>
                  <li class="active">Adjust Points</li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
			   <?php $this->load->view('success_error_message'); ?>
               <!-- SELECT2 EXAMPLE -->
               <div class="box box-default">
                  <div class="box-header with-border">
                     <h3 class="box-title">Adjust Points</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                     <div class="row">
                        <form class="<?php echo form; ?>" id="player_points" action="<?php echo base_url().'player/player_points/player_points_update'; ?>" method="post" data-toggle="validator" role="form">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                           <input type="hidden" name="user_id" value="<?php echo !empty( $default_result['user_id'] ) ? $default_result['user_id'] : ''; ?>" />
                           <div class="col-md-6">
                              <div class="box-body">
                                 <div class="form-group">
                                    <label for="current_xps" class="col-sm-4 control-label">Player Xps</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="current_xps" value="<?php echo !empty( $default_result['current_xps'] ) ? $default_result['current_xps'] : ''; ?>" id="current_xps" placeholder="Xps" required>
                                    <div class="help-block with-errors"></div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="current_coins" class="col-sm-4 control-label">Player Coins</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="current_coins" value="<?php echo !empty( $default_result['current_coins'] ) ? $default_result['current_coins'] : ''; ?>" id="current_coins" placeholder="Coins" required>
                                    <div class="help-block with-errors"></div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="current_gems" class="col-sm-4 control-label">Player Gems</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="current_gems" value="<?php echo !empty( $default_result['current_gems'] ) ? $default_result['current_gems'] : ''; ?>" id="current_gems" placeholder="Gems" required>
                                    <div class="help-block with-errors"></div>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>

                           <div class="col-md-12">
                              <button type="submit" id="submit" class="btn btn-info">Update</button>
                           </div>
                        </form>
                        <!-- /.col -->
                     </div>
                     <!-- /.row -->
                  </div>
                  <!-- /.box-body -->
               </div>
               <!-- /.box -->
            </section>
            <!-- /.content -->
         </div>