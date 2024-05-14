<?php 
require 'inc/Header.php';
?>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
    <?php require 'inc/Navbar.php';?>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
       <?php require 'inc/Sidebar.php';?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6">
                  <h3>Report Data</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
		 
            <div class="row">
             
           <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Interest<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_interest")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/one.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Language<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_language")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/two.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Religion<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_religion")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/three.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Relation Goal<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from relation_goal")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/four.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			 
			 <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">FAQ<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_faq")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/five.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Total Plan<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_plan")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/six.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Total Users<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_user")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/seven.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			   <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Total Pages<i class="fa fa-circle"> </i></p>
                        <h4><?php echo $dating->query("select * from tbl_page")->num_rows;?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/eight.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  <div class="col-sm-6 col-lg-3">
                <div class="card o-hidden">
                  <div class="card-header pb-0">
                    <div class="d-flex"> 
                      <div class="flex-grow-1"> 
                        <p class="square-after f-w-600 header-text-primary">Total Earning<i class="fa fa-circle"> </i></p>
                        <h4><?php $Earning = $dating->query("select sum(`amount`) as total_earn from plan_purchase_history")->fetch_assoc();
						           echo (empty($Earning['total_earn'])) ? '0'.$set['currency'] : $Earning['total_earn'].$set['currency'];
						?></h4>
                      </div>
                      <div class="d-flex static-widget">
                        <img src="images/dashboard/nine.svg" style="width: 60px;">


                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
			  
			  
			 
			  
			  
			  
			  
			  
			
			  
			
            
            </div>
	
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
       
      </div>
    </div>
    <!-- latest jquery-->
   <?php require 'inc/Footer.php'; ?>
    <!-- login js-->
  </body>


</html>