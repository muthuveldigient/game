 <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  Player (Register)
               </h1>
               <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                  <li><a href="#">Player</a></li>
                  <li class="active">Register player</li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
			   <?php $this->load->view('success_error_message'); ?>
               <!-- SELECT2 EXAMPLE -->
               <div class="box box-default">
                  <div class="box-header with-border">
                     <h3 class="box-title">Player</h3>
						
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                     <div class="row">
                        <form class="<?php echo form; ?>" id="player" action="" method="post" data-toggle="validator" role="form">
                           <div class="col-md-6">
                              <div class="box-body">
							  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Full Name</label>
                                    <div class="col-sm-8">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									<input type="hidden" name="" value="<?php echo $this->security->get_csrf_hash();?>" />
                                       <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo set_value('fullname'); ?>" placeholder="Full Name" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">User Name</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="User Name" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
								 
                                 <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-4 control-label">Passowrd</label>
                                    <div class="col-sm-8">
                                       <input type="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>" id="password" placeholder="Password" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
								
								  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-8">
                                       <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" id="email" placeholder="Email" required>
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
                                    <label for="inputPassword3" class="col-sm-4 control-label">Gender</label>
                                    <div class="col-sm-8">
                                       <select name="gender" id="gender" class="form-control select2" style="width: 100%;" required>
                                          <option value="">Select</option>
                                          <option value="1" <?php if( set_value('gender') == "1" ){ echo "selected";} ?> >Male</option>
                                          <option value="2" <?php if( set_value('gender') == "2" ){ echo "selected";} ?> >Female</option>
                                       </select>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>
								<div class="form-group">
                                    <label for="inputPassword3" class="col-sm-4 control-label">Age</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="age" value="<?php echo set_value('age'); ?>" id="age" placeholder="Age" required>
										<div class="help-block with-errors"></div>
									</div>
                                 </div>

                                 <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-4 control-label">Country</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" name="country" value="<?php echo set_value('country'); ?>" id="country" placeholder="Country" required>
                           <div class="help-block with-errors"></div>
                           </div>
                                 </div>

                                 
                              </div>
                              <!-- /.form-group -->
                           </div>
                           <div class="col-md-12">
                              <button type="submit" id="submit" class="btn btn-info">Save</button>
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