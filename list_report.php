<?php 
require 'inc/Header.php';
function addOrdinalSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
        switch ($num % 10) {
            // Handle 1st, 2nd, 3rd
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
        }
    }
    // All other cases, including 11th, 12th, 13th
    return $num.'th';
}
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
                  <h3>Report List Management</h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
            <div class="row">
           <div class="col-sm-12">
                <div class="card">
				<div class="card-body">
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>Sr No.</th>
							
											
											<th>Report maker user</th>
												<th>Report gain user</th>
												<th>comment</th>
												<th>Date</th>
												
                          </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city = $dating->query("select * from report");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$ruser = $dating->query("select * from tbl_user where id=".$row["reporter_id"]."")->fetch_assoc();
											$tuser = $dating->query("select * from tbl_user where id=".$row["uid"]."")->fetch_assoc();
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                
												
												
                                               
												
												<td>
                                                    <?php echo $ruser['name']; ?>
                                                </td>
                                                
												<td>
                                                    <?php echo $tuser['name']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['comment']; ?>
                                                </td>
                                               
												<td><?php 
												$report_date = $row['report_date'];
												$timestamp = strtotime($report_date);

// Format the date
$formatted_date = date('jS M Y', $timestamp);

// Replace the day part with ordinal suffix
$day = date('j', $timestamp);
$formatted_date = preg_replace('/\b\d{1,2}\b/', addOrdinalSuffix($day), $formatted_date, 1); // Replace only the first occurrence of 1 or 2 digits
												echo $formatted_date;?></td>
												
                                                
                                                </tr>
											<?php 
										}
										?>
                          
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