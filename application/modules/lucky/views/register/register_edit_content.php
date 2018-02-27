 <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  Partner (Edit)
               </h1>
               <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="#">Partner</a></li>
                  <li class="active">Edit partner</li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
			<?php $this->load->view('success_error_message'); ?>
               <!-- SELECT2 EXAMPLE -->
               <div class="box box-default">
                  <div class="box-header with-border">
                     <h3 class="box-title">Partner</h3>
						
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                     <div class="row">
                        <form class="<?php echo form; ?>" id="player" action="<?php echo base_url().'player/player_register/update_player_details'; ?>" method="post" data-toggle="validator" role="form">
                           <div class="col-md-6">
                              <div class="box-body">
							  <div class="form-group">
                                    <label for="fullname" class="col-sm-4 control-label">Full Name</label>
                                    <div class="col-sm-8">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									<input type="hidden" name="user_id" value="<?php echo !empty( $player['user_id'] ) ? $player['user_id'] : ''; ?>" />
                                       <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo !empty( $player['fullname'] ) ? $player['fullname'] : ''; ?>" placeholder="Full Name" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
                                 <div class="form-group">
                                    <label for="username" class="col-sm-4 control-label">User Name</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="username" name="username" value="<?php echo !empty( $player['username'] ) ? $player['username'] : ''; ?>" placeholder="User Name" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
								 
                                 <div class="form-group">
                                    <label for="password" class="col-sm-4 control-label">Passowrd</label>
                                    <div class="col-sm-8">
                                       <input type="password" class="form-control" name="password" value="" id="password" placeholder="Password" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
								
								  <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-8">
                                       <input type="email" class="form-control" name="email" value="<?php echo !empty( $player['email'] ) ? $player['email'] : ''; ?>" id="email" placeholder="Email" required>
									<div class="help-block with-errors"></div>
								   </div>
                                 </div>
								  
								
								  
                                 
                              </div>
                              <!-- /.box-body -->
                              <!-- /.box-footer -->
                              <!-- /.form-group -->
                           </div>
                           <!-- /.col -->
                           <div class="col-md-6">
                              <div class="box-body">
                                 
								 
								 
								  <div class="form-group">
                              <label for="gender" class="col-sm-4 control-label">Gender</label>
                              <div class="col-sm-8">
                                    <select name="gender" id="gender" class="form-control select2" style="width: 100%;" required>
                                       <option value="">Select</option>
                                       <option value="1" <?php if( !empty( $player['gender'] ) && $player['gender'] == "1" ) { echo "selected"; } ?> >Male</option>
                                       <option value="2" <?php if( !empty( $player['gender'] ) && $player['gender'] == "2" ) { echo "selected"; } ?> >Female</option>
                                    </select>
                              <div class="help-block with-errors"></div>
                              </div>
                           </div>

								<div class="form-group">
                                    <label for="age" class="col-sm-4 control-label">Age</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="age" value="<?php echo !empty( $player['age'] ) ? $player['age'] : ''; ?>" id="age" placeholder="Age" required>
                              <div class="help-block with-errors"></div>
                           </div>
                                 </div>

								 <div class="form-group">
                                    <label for="country" class="col-sm-4 control-label">Country</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="country" value="<?php echo !empty( $player['country'] ) ? $player['country'] : ''; ?>" id="country" placeholder="Country" required>
                           <div class="help-block with-errors"></div>
                           </div>
                                 </div>
                                 
                              </div>
                              <!-- /.form-group -->
                           </div>
                           <div class="col-md-12">
                              <button type="submit" id="submit" class="btn btn-info">Update</button>
                              <a href="<?php echo base_url(); ?>player/player_search" class="btn btn-info">Cancel</a>
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