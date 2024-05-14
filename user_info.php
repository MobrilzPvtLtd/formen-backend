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
                  <h3>User Info Management</h3>
                </div>
               <?php $userinfo = $dating->query("select * from tbl_user where id=".$_GET["user_id"]."")->fetch_assoc();?>
              <?php $img =  explode('$;',$userinfo['other_pic']);?>
			  <?php $goal = $dating->query("select * from relation_goal where id=".$userinfo["relation_goal"]."")->fetch_assoc();?>
		 
			 </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
         <div class="container-fluid general-widget">
            <div class="row">
             
             <div class="row">
               <div class="col-xl-3 col-md-5 box-col-30 xl-30">
                      <div class="default-according style-1 faq-accordion job-accordion" id="accordionoc2">
                        <div class="row">
                          <div class="col-xl-12">
                            <div class="card">
                              <div class="card-header">
                                <h5 class="p-0">
                                  <button class="btn btn-link ps-0" >My Profile</button>
                                </h5>
                              </div>
                              <div class="collapse show" id="collapseicon5" aria-labelledby="collapseicon5" data-parent="#accordion" style="">
                                <div class="card-body socialprofile filter-cards-view">
                                  <div class="d-flex align-items-center"><img class="img-60 img-fluid m-r-20 rounded-circle" src="<?php echo $img[0];?>" alt="">
                                    <div class="flex-grow-1">
                                      <h5 class="font-primary f-w-600"><?php echo $userinfo['name'];?></h5>
                                    </div>
                                  </div>
                                  
                                 
                                </div>
                              </div>
                            </div>
                          </div>
						  
						  <div class="col-xl-12">
                            <div class="card">
                              <div class="card-header">
                                <h5 class="p-0">
                                  <button class="btn btn-link ps-0" >Location</button>
                                </h5>
                              </div>
                              <div id="map"></div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
					
					<div class="col-xl-9 col-md-7 box-col-40 xl-40">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-header pb-0">
                              <h5>Other Picture</h5>
                            </div>
                            <div class="card-body p-xl-4">
                              <div class="avatar-showcase">
                                <div class="pepole-knows">
                                  <ul>
								  <?php 
								  foreach($img as $iv)
								  {
								  ?>
                                    <li>
                                      <div class="add-friend text-center"><img class="img-60 img-fluid rounded-circle" alt="" src="<?php echo $iv; ?>">
                                        
                                      </div>
                                    </li>
								  <?php } ?>
                                    
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-header social-header">
                              <h5 class="f-w-600">Other Information</h5>
                            </div>
                            <div class="card-body pt-0">
                              <div class="row details-about">
                                <div class="col-sm-6">
                                  <div class="your-details">
                                    <h6 class="f-w-600">Profile Bio:</h6>
                                    <p class="mb-0"><?php echo $userinfo['profile_bio'];?></p>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Birth Date:</h6>
                                    <p class="mb-0"><?php 
									$birth_date = $userinfo['birth_date'];

// Convert date string to a Unix timestamp
$timestamp = strtotime($birth_date);

// Format the date
$formatted_date = date('jS M Y', $timestamp);

									echo $formatted_date;?> </p>
                                  </div>
                                </div>
                              </div>
                              <div class="row details-about">
                                <div class="col-sm-6">
                                  <div class="your-details">
                                    <h6 class="f-w-600">Search Preference:</h6>
                                    <p class="mb-0"><?php echo $userinfo['search_preference'];?></p>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Relation Goal:</h6>
                                    <p class="mb-0"><?php echo $goal['title'];?></p>
									<p class="mb-0"><?php echo $goal['subtitle'];?></p>
                                  </div>
                                </div>
                              </div>
                              <div class="row details-about">
                                <div class="col-sm-6">
                                  <div class="your-details">
                                    <h6 class="f-w-600">Gender:</h6>
                                    <p class="mb-0"><?php echo $userinfo['gender'];?></p>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Religion:</h6>
                                    <p class="mb-0"><?php $Religion = $dating->query("SELECT * FROM `tbl_religion` where id=".$userinfo['religion']."")->fetch_assoc();echo $Religion['title'];?></p>
                                  </div>
                                </div>
								
							  
                              
                            </div>
							
							<div class="row details-about">
								<div class="col-sm-6">
                                  <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Radius Search:</h6>
                                    <p class="mb-0"><?php echo $userinfo['radius_search'].'KM';?></p>
                                  </div>
                                </div>
								
								<div class="col-sm-6">
                                  <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Wallet Balance:</h6>
                                    <p class="mb-0"><?php echo $userinfo['wallet'].$set['currency'];?></p>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                        
<?php if($userinfo['is_subscribe'] == 1) {
	$pinfo = $dating->query("SELECT * from tbl_plan where id=".$userinfo['plan_id']."")->fetch_assoc();
	?>
<div class="col-sm-12">
                          <div class="card">
                            <div class="card-header social-header">
                              <h5 class="f-w-600">Plan Information <span class="badge badge-primary"><?php echo $pinfo['title'].' Membership';?></span></h5>
                            </div>
                            <div class="card-body pt-0">
                              
                              <div class="row details-about">
                                <div class="col-sm-6">
                                  <div class="your-details">
                                    <h6 class="f-w-600">Plan Start Date:</h6>
                                    <p class="mb-0"><?php
$birth_date = $userinfo['plan_start_date'];

// Convert date string to a Unix timestamp
$timestamp = strtotime($birth_date);

// Format the date
$formatted_date = date('jS M Y', $timestamp);

									echo $formatted_date;
									?></p>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Plan End Date:</h6>
                                    <p class="mb-0"><?php
$birth_date = $userinfo['plan_end_date'];

// Convert date string to a Unix timestamp
$timestamp = strtotime($birth_date);

// Format the date
$formatted_date = date('jS M Y', $timestamp);

									echo $formatted_date;
									?></p>
									
                                  </div>
                                </div>
                              </div>
                              
                          </div>
                        </div>
						</div>
<?php } ?>
                        <div class="col-sm-12">
                          <div class="card">
                            <div class="card-header pb-0">
                              <h5>Ineterest</h5>
                            </div>
                            <div class="card-body p-xl-4">
                              <div class="avatar-showcase">
                                <div class="pepole-knows">
                                  <ul>
								  <?php 
								  $interest = $dating->query("SELECT * from tbl_interest where id IN(".$userinfo['interest'].")");
								  while($row = $interest->fetch_assoc())
								  {
								  ?>
                                    <li>
                                      <div class="add-friend text-center"><img class="img-60 img-fluid rounded-circle" alt="" src="<?php echo $row["img"]; ?>"><span class="d-block f-w-600"><?php echo $row["title"]; ?></span>
                                        
                                      </div>
                                    </li>
								  <?php } ?>
                                    
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
						
						
						<div class="col-sm-12">
                          <div class="card">
                            <div class="card-header pb-0">
                              <h5>Languages Known</h5>
                            </div>
                            <div class="card-body p-xl-4">
                              <div class="avatar-showcase">
                                <div class="pepole-knows">
                                  <ul>
								  <?php 
								  $language = $dating->query("SELECT * from tbl_language where id IN(".$userinfo['language'].")");
								  while($rows = $language->fetch_assoc())
								  {
								  ?>
                                    <li>
                                      <div class="add-friend text-center"><img class="img-60 img-fluid rounded-circle" alt="" src="<?php echo $rows["img"]; ?>"><span class="d-block f-w-600"><?php echo $rows["title"]; ?></span>
                                        
                                      </div>
                                    </li>
								  <?php } ?>
                                    
                                  </ul>
                                </div>
                              </div>
                            </div>
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
   <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
	
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNuJFHTBoAJeSsDdJhyuQrpkDo5_bl6As&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var myLatLng = {lat: <?php echo $userinfo['lats']; ?>, lng: <?php echo $userinfo['longs']; ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: myLatLng
            });
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: '<?php echo $userinfo['name'];?> Location'
            });
        }
    </script>
    <!-- login js-->
  </body>


</html>