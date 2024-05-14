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
                  <h3>FAQ List Management</h3>
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
											<th>Question</th>
											<th>Answer</th>
												<th>Status</th>
												<th>Action</th>
									</tr>
                                        </thead>
                                        <tbody>
                                           <?php 
										$city = $dating->query("select * from tbl_faq");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['question']; ?>
                                                </td>
                                                
                                               <td>
                                                    <?php echo $row['answer']; ?>
                                                </td>
                                                
                                               
												<?php if($row['status'] == 1) { ?>
												
                                                <td><span class="badge badge-primary">Publish</span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger">Unpublish</span></td>
												<?php } ?>
                                                <td style="white-space: nowrap; width: 15%;"><div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                           <div class="btn-group btn-group-sm" style="float: none;">
										   <a href="add_faq.php?id=<?php echo $row['id'];?>" class="tabledit-edit-button" style="float: none; margin: 5px;"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_1185_24834)">
<path d="M2.64682 19.1289C2.83067 20.7747 4.14635 22.0897 5.79148 22.2801C7.65043 22.4951 9.57133 22.7071 11.5367 22.7071C13.5021 22.7071 15.423 22.4951 17.2819 22.2801C18.927 22.0897 20.2428 20.7747 20.4266 19.1289C20.6332 17.2787 20.8328 15.367 20.8328 13.4112C20.8328 11.4554 20.6332 9.54375 20.4266 7.69361C20.2428 6.04774 18.927 4.7327 17.2819 4.5424C15.423 4.32736 13.5021 4.11523 11.5367 4.11523C9.57133 4.11523 7.65043 4.32736 5.79148 4.5424C4.14635 4.7327 2.83067 6.04774 2.64682 7.69361C2.44015 9.54375 2.24072 11.4554 2.24072 13.4112C2.24072 15.367 2.44015 17.2787 2.64682 19.1289Z" fill="white"/>
<path d="M10.1693 4.14844C8.67889 4.21556 7.21698 4.37875 5.7915 4.54364C4.14635 4.73394 2.83067 6.04898 2.64682 7.69485C2.44015 9.54499 2.24072 11.4566 2.24072 13.4125C2.24072 15.3683 2.44015 17.2799 2.64682 19.1301C2.83067 20.7759 4.14635 22.0909 5.79148 22.2813C7.65043 22.4963 9.57133 22.7085 11.5367 22.7085C13.5021 22.7085 15.423 22.4963 17.2819 22.2813C18.927 22.0909 20.2428 20.7761 20.4266 19.1301C20.5752 17.7993 20.7201 16.4365 20.7897 15.0485" stroke="black" stroke-width="1.71455" stroke-linecap="round"/>
<path d="M18.2599 2.24986L11.9419 9.41867L11.0764 13.4896C10.9371 14.1446 11.6199 14.7644 12.2593 14.5634L16.3105 13.2898L22.8362 6.42316C23.9201 5.2827 23.731 3.37519 22.419 2.21476C21.1378 1.08151 19.2757 1.09723 18.2599 2.24986Z" fill="#9610FF"/>
<path d="M18.2599 2.24986L11.9419 9.41867L11.0764 13.4896C10.9371 14.1446 11.6199 14.7644 12.2593 14.5634L16.3105 13.2898L22.8362 6.42316C23.9201 5.2827 23.731 3.37519 22.419 2.21476C21.1378 1.08151 19.2757 1.09723 18.2599 2.24986Z" stroke="black" stroke-width="1.71455" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_1185_24834">
<rect width="24.0037" height="24.0037" fill="white" transform="translate(0.928223 0.015625)"/>
</clipPath>
</defs>
</svg>
</a>
										   </div>
                                           
                                       </div></td>
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