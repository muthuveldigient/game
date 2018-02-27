   <?php $this->load->view("header"); ?>
   <?php $this->load->view("user_header"); ?>
   <?php $this->load->view("end_header"); ?>

   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         
      <?php $this->load->view("top_menu"); ?>
      <?php $this->load->view("side_menu"); ?>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  Player Search
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo base_url()."dashboard"; ?>"><i class="fa fa-dashboard"></i>Home</a></li>
                  <li><a href="<?php echo base_url()."player/player_search"; ?>">Player</a></li>
                  <li class="active">Search</li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
            <?php $this->load->view("success_error_message"); ?>
               <!-- SELECT2 EXAMPLE -->
               <div class="box box-default">
                  <div class="box-header with-border">
                     <h3 class="box-title">Player Search</h3>
                     
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                     <div class="row">
                        <form class="<?php echo form; ?>">
                           <div class="<?php echo sep_col; ?>">
                              <div class="<?php echo body; ?>">

                              <div class="<?php echo form_group; ?>">
                                 <label class="<?php echo form_lable; ?>">User Name</label>
                                 <div class="<?php echo input_div; ?>">
                                 <input type="hidden" id="csrf_test_name" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                 <input type="username" class="<?php echo input_class; ?>" id="username" placeholder="Username">
                                 </div>
                              </div>

                              <div class="<?php echo form_group; ?>">
                                 <label class="<?php echo form_lable; ?>">Email</label>
                                 <div class="<?php echo input_div; ?>">
                                 <input type="email" class="<?php echo input_class; ?>" id="email" placeholder="Email">
                                 </div>
                              </div>

                              <div class="<?php echo form_group; ?>">
                                 <label class="<?php echo form_lable; ?>">Date range</label>
                                 <div class="<?php echo input_div; ?>">
                                 <div class="input-group">
                                 <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                 <span>
                                 <i class="fa fa-calendar"></i> Date range picker
                                 </span>
                                 <i class="fa fa-caret-down"></i>
                                 </button>
                                 </div>
                                 </div>
                                 <input type="hidden" id="selected_datatime">
                              </div>

                              </div>
                           </div>
                           <!-- /.col -->
                           <div class="<?php echo sep_col; ?>">
                              <div class="<?php echo body; ?>">

                              <div class="<?php echo form_group; ?>">
                                 <label class="<?php echo form_lable; ?>">Login Type</label>
                                 <div class="<?php echo input_div; ?>">
                                 <input type="text" class="<?php echo input_class; ?>" id="login_type" placeholder="Login type">
                                 </div>
                              </div>

                              <div class="<?php echo form_group; ?>">
                                 <label class="<?php echo form_lable; ?>">Status</label>
                                 <div class="<?php echo input_div; ?>">
                                    <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                       <option value="">Select</option>
                                       <option value="2">InActive</option>
                                       <option value="1">Active</option>
                                    </select>
                                 </div>
                              </div>

                              </div>
                           <!-- /.form-group -->
                           </div>

                           <div class="col-md-12">
                              <button type="button" id="search_player" class="btn btn-info">Search</button>
                              <span onClick="window.location.reload()" class="btn btn-default">Clear</span>
                           </div>
                        </form>
                     </div>
                        <!-- /.col -->
                  </div>
                     <!-- /.row -->
               </div>
                  <!-- /.box-body -->
                  <!-- /.box -->
            <?php $this->load->view("player_list"); ?>

            </section>
            <!-- /.content -->
         </div>
         </div>
         <!-- /.content-wrapper -->
        
        <?php $this->load->view("footer"); ?>
        <?php $this->load->view("user_footer"); ?>