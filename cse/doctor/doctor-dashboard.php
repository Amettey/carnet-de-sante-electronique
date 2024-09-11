<?php
session_start();
$email=$_SESSION['email'];
$name=$_SESSION['user'];
include "../dbconfig/db.php";
$date=gettoday();
$query = mysqli_query($conn,"select * from doctor where Email='$email'");
$rowdocs = mysqli_fetch_assoc($query);
$patientmail=array();
if (mysqli_num_rows($query)) {
	
	$dcontact=$rowdocs['Contact'];	
	$dspecial=$rowdocs['Special'];
	
		
}
$kicksql="Select * from appointments where DoctorMail='$email'";
$kickres=mysqli_query($conn, $kicksql);
$tappointment=mysqli_num_rows($kickres);
$i=0;
while($kickrow=mysqli_fetch_array($kickres)){
	$patientmail[$i]=$kickrow['PatientMail'];
	$i++;
}
$patients=array_unique($patientmail);
$kicknum=count($patients);


$sql1 = "Select * from appointments where DoctorMail='$email' and DateOfAppointment>'$date'";
$result1=mysqli_query($conn, $sql1);
$num1=mysqli_num_rows($result1);
$i=0;
while($row1 = mysqli_fetch_array($result1)){
	//echo $row1['Name'];
	$uppatmail[$i]=$row1['PatientMail'];
	//$temp=$row1['PatientMail'];
	$upaid[$i]=$row1['AppointmentId'];
	$updoa[$i]=$row1['DateOfAppointment'];
	$uptoa[$i]=railway($row1['Time']);
	$upstatus[$i]=$row1['Status'];
	
	$sql = "Select * from patient where Email='$uppatmail[$i]'";
	$result=mysqli_query($conn, $sql);
	while($row = mysqli_fetch_array($result)){
		$uppatname[$i]=$row['Name'];
		$uppatcountry[$i]=$row['country'];
		$upcontact[$i]=$row['Contact'];
		$updp[$i]=$row['Image'];
		
	}
	$i++;
}
$sq = "Select * from appointments where DoctorMail='$email' and DateOfAppointment='$date'";
$result=mysqli_query($conn, $sq);
$num=mysqli_num_rows($result);
$i=0;
$todayPatients=0;
while($rows = mysqli_fetch_array($result)){
	//echo $row1['Name'];
	$patmail[$i]=$rows['PatientMail'];
	//$temp=$row1['PatientMail'];
	$aid[$i]=$rows['AppointmentId'];
	$doa[$i]=$rows['DateOfAppointment'];
	$toa=railway($rows['Time']);
	$status[$i]=$rows['Status'];
	
	$sq1 = "Select * from patient where Email='$patmail[$i]'";
	$res=mysqli_query($conn, $sq1);
	while($rows1 = mysqli_fetch_array($res)){
		$patname[$i]=$rows1['Name'];
		$patcountry[$i]=$rows1['country'];
		$contact[$i]=$rows1['Contact'];
		$dp[$i]=$rows1['Image'];
		
	}
	$i++;
	$tpatients=array_unique($patmail);
    $todayPatients=count($tpatients);
}


function monthName($date){
	list($day, $month, $year) = explode("/", $date);
	$dateObj   = DateTime::createFromFormat('!m', $month);
	$monthName = $dateObj->format('F');
	$datewithname=$day.', '.$monthName.' '.$year;
	return $datewithname;

}

function railway($str){	
$hours = str_split($str, 2);
$min=str_split($str, 3);
$hour=$hours[0];
$minutes=$min[1];
$merid="AM";
if($hour>12){
$hour-=12;
$merid="PM";
}
$time=$hour.':'.$minutes.' '.$merid;
return $time;
}

function gettoday(){
	$y=date("Y");
$m=date("m");
$d=date("d");
$today=$d.'/'.$m.'/'.$y;
return $today;
}
if(isset($_POST['accept'])){
	$id=$_POST['accept'];
	$sql = "UPDATE appointments SET Status='1' WHERE AppointmentId='$id'";
	$result=mysqli_query($conn,$sql);

}else if(isset($_POST['reject'])){
	$id=$_POST['reject'];
	$sql = "UPDATE appointments SET Status='-1' WHERE AppointmentId='$id'";
	$result=mysqli_query($conn,$sql);
}
?>
<!DOCTYPE html> 
<html lang="en">
	
<!-- Docter/doctor-dashboard.php  30 Nov 2019 04:12:03 GMT -->
<head>
		<meta charset="utf-8">
		<title>Doctor</title>
		 <script src="../assets/js/removebanner.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="../assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="../assets/css/style.css">
		<style>button {
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
		}
	</style>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="../assets/js/html5shiv.min.js"></script>
			<script src="../assets/js/respond.min.js"></script>
		<![endif]-->
	
	</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="doctor-dashboard.php" class="navbar-brand logo">
							<img src="../assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<div>
							<span>
								<div class="translate" id="google_translate_element"></div>

								<script type="text/javascript">
									function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
								</script>
								<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
							</span>
						</div>
					</div>		 
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header"><?php echo $dcontact;?></p>
							</div>
						</li>
						
						<!-- User Menu -->
						<li class="nav-item dropdown has-arrow logged-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
								 <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($rowdocs['Image'] ).'"  alt="'.$name.'"/>  ';?>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<?php echo '<img class="avatar-img rounded-circle" src="data:image/jpeg;base64,'.base64_encode($rowdocs['Image'] ).'"  alt="'.$name.'"/>  ';?>
									</div>
									<div class="user-text">
										<h6><?php echo $name;?></h6>
										<p class="text-muted mb-0">Doctor</p>
									</div>
								</div>
								<a class="dropdown-item" href="doctor-dashboard.php">Dashboard</a>
								<a class="dropdown-item" href="doctor-profile-settings.php">Profile Settings</a>
								
							</div>
						</li>
						<!-- /User Menu -->
						
					</ul>
				</nav>
			</header>
			<!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
							
							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
										<?php 
										if (!empty($rowdocs['Image'])) {
										    echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . base64_encode($rowdocs['Image']) . '" alt="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '"/>';
										} else {
										    echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . base64_encode('default_image_content') . '" alt="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '"/>';
										}
										?>

										</a>
										<div class="profile-det-info">
											<h3><?php echo $name;?></h3>
											
											<div class="patient-details">
												<!-- <h5 class="mb-0">/</h5> -->
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="active">
												<a href="doctor-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="appointments.php">
													<i class="fas fa-calendar-check"></i>
													<span>Appointments</span>
												</a>
											</li>
											<li>
												<a href="my-patients.php">
													<i class="fas fa-user-injured"></i>
													<span>My Patients</span>
												</a>
											</li>
											
										
											<li>
												<a href="doctor-profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											
											<li>
												<a href="doctor-change-password.php">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="../logout.html">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-md-7 col-lg-8 col-xl-9">

							<div class="row">
								<div class="col-md-12">
									<div class="card dash-card">
										<div class="card-body">
											<div class="row">
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar circle-bar1">
															<div class="circle-graph1" data-percent="50">
																<img src="../assets/img/icon-01.png" class="img-fluid" alt="patient">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Total Patients</h6>
															<h3><?php echo $kicknum;?></h3>
															<p class="text-muted"></p>
														</div>
													</div>
												</div>
												
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar circle-bar2">
															<div class="circle-graph2" data-percent="50">
																<img src="../assets/img/icon-02.png" class="img-fluid" alt="Patient">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Today Patients</h6>
															<h3><?php echo $todayPatients;?></h3>
															<p class="text-muted"><?php echo monthName($date);?></p>
														</div>
													</div>
												</div>
												
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget">
														<div class="circle-bar circle-bar3">
															<div class="circle-graph3" data-percent="50">
																<img src="../assets/img/icon-03.png" class="img-fluid" alt="Patient">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Total Appoinments</h6>
															<h3><?php echo $tappointment;?></h3>
															<p class="text-muted"></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<h4 class="mb-4">Patient Appoinment</h4>
									<div class="appointment-tab">
									
										<!-- Appointment Tab -->
										<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
											<li class="nav-item">
												<a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#today-appointments" data-toggle="tab">Today</a>
											</li> 
										</ul>
										<!-- /Appointment Tab -->
										
										<div class="tab-content">
										
											<!-- Upcoming Appointment Tab -->
<div class="tab-pane show active" id="upcoming-appointments">
<div class="card card-table mb-0">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover table-center mb-0">
				<thead>
					<tr>
						<th>Patient Name</th>
						<th>Appt Date</th>
						<th>Appt Time</th>
						<th>Contact</th>
						<th>Status</th>
						
						<th></th>
					</tr>
				</thead>
				<tbody>
				<form method="POST" action="doctor-dashboard.php">
				<?php	
				$i=0;
				while($i<$num1){
				echo'<tr>
						<td>
							<h2 class="table-avatar">
								<a href="../patient-profile.php" class="avatar avatar-sm mr-2">
							<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($updp[$i]).'"  class="img-thumnail" alt="Pic"/>
								<a href="../patient-profile.php">'.$uppatname[$i].'<span>'.$upaid[$i].'</span></a>
							</h2>
						</td>
						<td><span class="d-block text-info">'.$updoa[$i].'</span></td>
						<td>'.$uptoa[$i].'</span></td>
						<td>'.$upcontact[$i].'</td>
						
						
						<td>';
						if($upstatus[$i]==1){
							echo '<div class="appointment-action">				
										<a href="javascript:void(0);" class="btn btn-sm bg-success-light" >					
											<i class="fas fa-check" style="color:green;"> Accepted</i>
										</a>
										
									</div>
								</div>';
						}else if($upstatus[$i]==-1){
							echo '<div class="appointment-action">				
										
										<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
										<i class="fas fa-times" style="color:red;"> Cancelled</i>					
										</a>
									</div>
								</div>';
						}else{
									echo '<div class="appointment-action">				
										<a href="javascript:void(0);" class="btn btn-sm bg-success-light" >					
											<button class="fas fa-check" style="color:green;" name="accept" value="'.$upaid[$i].'"> Accept</button>
										</a>
										<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
										<button class="fas fa-times" style="color:red;" name="reject" value="'.$upaid[$i].'"> Cancel</button>					
										</a>
									</div>
								</div>';
						}

					echo '</td>
					</tr>';
					$i++;
				}
					?>
				</form>	
				</tbody>
			</table>		
		</div>
	</div>
</div>
</div>
											<!-- /Upcoming Appointment Tab -->
									   
											<!-- Today Appointment Tab -->
											<div class="tab-pane" id="today-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive">
															<table class="table table-hover table-center mb-0">
							<thead>
							<tr>
								<th>Patient Name</th>
								<th>Appt Date</th>
								<th>Appt Time</th>
								<th>Contact</th>
								<th>Status</th>								
								<th></th>
							</tr>
							</thead>
							<tbody>
							<form method="POST" action="doctor-dashboard.php">
				<?php	
				$i=0;
				while($i<$num){
				echo'<tr>
						<td>
							<h2 class="table-avatar">
								<a href="../patient-profile.php" class="avatar avatar-sm mr-2">
									<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp[$i]).'"  class="img-thumnail" alt="Pic"/>
								</a>
								<a href="../patient-profile.php">'.$patname[$i].'<span>'.$aid[$i].'</span></a>
							</h2>
						</td>
						<td><span class="d-block text-info">'.$doa[$i].'</span></td>
						<td>'.$toa[$i].'</td>
						<td>'.$contact[$i].'</td>
						
						
						<td>';
						if($status[$i]==1){
							echo '<div class="appointment-action">				
										<a href="javascript:void(0);" class="btn btn-sm bg-success-light" >					
											<i class="fas fa-check" style="color:green;"> Accepted</i>
										</a>
										
									</div>
								</div>';
						}else if($status[$i]==-1){
							echo '<div class="appointment-action">				
										
										<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
										<i class="fas fa-times" style="color:red;"> Cancelled</i>					
										</a>
									</div>
								</div>';
						}else{
									echo '<div class="appointment-action">				
										<a href="javascript:void(0);" class="btn btn-sm bg-success-light" >					
											<button class="fas fa-check" style="color:green;" name="accept" value="'.$aid[$i].'"> Accept</button>
										</a>
										<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
										<button class="fas fa-times" style="color:red;" name="reject" value="'.$aid[$i].'"> Cancel</button>					
										</a>
									</div>
								</div>';
						}

					echo '</td>
					</tr>';
					$i++;
				}
					?>
				</form>	
							</tbody>
															</table>		
														</div>	
													</div>	
												</div>	
											</div>
											<!-- /Today Appointment Tab -->
											
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
               
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  	
		<!-- jQuery -->
		<script src="../assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="../assets/js/popper.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="../assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="../assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Circle Progress JS -->
		<script src="../assets/js/circle-progress.min.js"></script>
		
		<!-- Custom JS -->
		<script src="../assets/js/script.js"></script>
		
	</body>

<!-- Docter/doctor-dashboard.php  30 Nov 2019 04:12:09 GMT -->
</html>