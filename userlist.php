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
                  <h3>User List Management</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
         <div class="container-fluid general-widget">
            <div class="row">
             
             <div class="col-sm-12">
                <div class="card">
				<div class="card-body">
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                           <tr>
                                                <th>Sr no.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>mobile</th>
                                                <th>Join Date</th>
                                                <th>Status</th>
												<th>Is Subscribe?</th>
												<th>Plan Name</th>
												<th>Start Date</th>
												<th>Expired Date</th>
												<th>Identity</th>
												<th>Is Verified?</th>
												<th>Information</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
											 $stmt = $dating->query("SELECT * FROM `tbl_user` order by id desc");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	$pname = $dating->query("select title from tbl_plan where id=".$row['plan_id']."")->fetch_assoc();
	
	$i = $i + 1;
											?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $row['name'];?></td>
												<td><?php echo $row['email'];?></td>
												<td><?php echo $row['ccode'].$row['mobile'];?></td>
												<td><?php echo $row['rdate'];?></td>
												<?php if($row['status'] == 1) { ?>
												
                                                <td><span  data-id="<?php echo $row['id'];?>" data-status="0" data-type="update_status" coll-type="userstatus" class="drop badge badge-danger">Make Deactive</span></td>
												<?php } else { ?>
												
												<td>
												<span data-id="<?php echo $row['id'];?>" data-status="1" data-type="update_status" coll-type="userstatus" class="badge drop  badge-success">Make Active</span></td>
												<?php } ?>
												
												
												<?php if($row['is_subscribe'] == 1) { ?>
												
                                                <td><span    class=" badge badge-success">Subscribe</span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge   badge-danger">Not Subscribe</span></td>
												<?php } ?>
												
												
												<?php
if(empty($pname['title']))
	{
		?>
		<td>
												<span class="badge   badge-danger">Not Subscribe</span></td>
		<?php 
		
	}
	else 
	{
		?>
		<td><span    class=" badge badge-success"><?php echo $pname['title']; ?></span></td>
		<?php 
		
	}	
?>	


<?php
if(empty($row['plan_start_date']))
	{
		
		?>
		<td>
												<span class="badge   badge-danger">Not Subscribe</span></td>
		<?php 
		
	}
	else 
	{
		$dt = new DateTime($row['plan_start_date']);
		?>
		<td><span    class=" badge badge-success"><?php echo $dt->format('jS M Y, g:i A'); ?></span></td>
		<?php 
		
	}	
?>	

<?php
if(empty($row['plan_end_date']))
	{
		
		?>
		<td>
												<span class="badge   badge-danger">Not Subscribe</span></td>
		<?php 
		
	}
	else 
	{
		$dts = new DateTime($row['plan_end_date']);
		?>
		<td><span    class=" badge badge-success"><?php echo $dts->format('jS M Y, g:i A'); ?></span></td>
		<?php 
		
	}	
?>	

<td><?php if(empty($row['identity_picture'])) {echo 'not upload';}else {?><img src="<?php echo $row['identity_picture'];?>" width="100px"/> <?php } ?></td>
<td><?php if($row['is_verify'] == 1){?><span  data-id="<?php echo $row['id'];?>" data-status="2" data-type="update_status" coll-type="verifystatus" class="drop badge badge-success">Approve</span>
<span  data-id="<?php echo $row['id'];?>" data-status="0" data-type="update_status" coll-type="verifystatus" class="drop badge badge-danger">Reject</span> <?php } else if($row['is_verify'] == 2) {echo 'Approved';}else {echo 'Wait For Upload';}?></td>
												
												<td>
												<a href="user_info.php?user_id=<?php echo $row['id'];?>">
												<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_1188_24830)">
<path d="M12.9076 13.026C14.9782 13.026 16.6569 11.3474 16.6569 9.27669C16.6569 7.20599 14.9782 5.52734 12.9076 5.52734C10.8368 5.52734 9.1582 7.20599 9.1582 9.27669C9.1582 11.3474 10.8368 13.026 12.9076 13.026Z" fill="white"/>
<path d="M19.2585 20.664C17.4812 21.9739 15.2847 22.748 12.9073 22.748C10.53 22.748 8.33353 21.9739 6.55615 20.664C6.91012 19.3309 7.67574 18.1396 8.74867 17.2626C9.92231 16.3033 11.3915 15.7793 12.9073 15.7793C14.4232 15.7793 15.8924 16.3033 17.066 17.2626C18.1389 18.1396 18.9046 19.3309 19.2585 20.664Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M19.2591 20.6623C21.9063 18.7112 23.6238 15.5713 23.6238 12.0304C23.6238 6.11215 18.8261 1.31445 12.9078 1.31445C6.98959 1.31445 2.19189 6.11215 2.19189 12.0304C2.19189 15.5713 3.90933 18.7112 6.55666 20.6623C6.91062 19.3292 7.67623 18.138 8.74916 17.261C9.92281 16.3017 11.392 15.7776 12.9078 15.7776C14.4237 15.7776 15.8929 16.3017 17.0665 17.261C18.1395 18.138 18.905 19.3292 19.2591 20.6623ZM12.9079 13.0248C14.9786 13.0248 16.6572 11.3462 16.6572 9.27546C16.6572 7.20474 14.9786 5.52611 12.9079 5.52611C10.8371 5.52611 9.15851 7.20474 9.15851 9.27546C9.15851 11.3462 10.8371 13.0248 12.9079 13.0248Z" fill="#9610FF"/>
<path d="M12.9078 22.7463C18.8261 22.7463 23.6238 17.9487 23.6238 12.0304C23.6238 6.11215 18.8261 1.31445 12.9078 1.31445C6.98959 1.31445 2.19189 6.11215 2.19189 12.0304C2.19189 17.9487 6.98959 22.7463 12.9078 22.7463Z" stroke="black" stroke-width="1.71455" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12.9076 13.026C14.9782 13.026 16.6569 11.3474 16.6569 9.27669C16.6569 7.20599 14.9782 5.52734 12.9076 5.52734C10.8368 5.52734 9.1582 7.20599 9.1582 9.27669C9.1582 11.3474 10.8368 13.026 12.9076 13.026Z" stroke="black" stroke-width="1.71455" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M19.2585 20.664C17.4812 21.9739 15.2847 22.748 12.9073 22.748C10.53 22.748 8.33353 21.9739 6.55615 20.664C6.91012 19.3309 7.67574 18.1396 8.74867 17.2626C9.92231 16.3033 11.3915 15.7793 12.9073 15.7793C14.4232 15.7793 15.8924 16.3033 17.066 17.2626C18.1389 18.1396 18.9046 19.3309 19.2585 20.664Z" stroke="black" stroke-width="1.71455" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_1188_24830">
<rect width="24.0037" height="24.0037" fill="white" transform="translate(0.905762 0.0292969)"/>
</clipPath>
</defs>
</svg>

</a>
</td>
												</tr>
												
												
<?php } ?>
                                            
                                        </tbody>
                      </table>
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