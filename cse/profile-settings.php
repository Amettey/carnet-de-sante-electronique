<?php
$num=0;
	session_start();
	$email=$_SESSION['email'];
	$user=$_SESSION['user'];
	include "dbconfig/db.php";
		if(isset($_POST["insert"])){  
		 $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
		 $queries= "update patient set Image='".$file."' WHERE Email='$email'";
		 if(mysqli_query($conn, $queries)){  
			  echo '<script>alert("Image Inserted into Database")</script>';  
		 }  
	} 
	$query = mysqli_query($conn,"select * from patient where Email='$email'");
	$rows = mysqli_fetch_assoc($query);
	$num=mysqli_num_rows($query);
	if ($num == 1) {
		$name=$rows['Name'];
		$contact=$rows['Contact'];	
		$lname=$rows['lname'];
		$dob=$rows['dob'];
		$bg=$rows['bgroup'];
		$contact=$rows['Contact'];
		$address=$rows['address'];
		$city=$rows['city'];
		$emergencynumber=$rows['emergencynumber'];
		$country=$rows['country'];
		$pcode=$rows['pincode'];
		$weight=$rows['weight'];
		$height=$rows['height'];	
	} 
	if (isset($_POST['login'])){
		$lname=$_POST['lname'];
		$lname=$_POST['lname'];
		$dob=$_POST['dob'];
		$bg=$_POST['bgroup'];
		$contact=$_POST['contact'];
		$address=$_POST['address'];
		$city=$_POST['city'];
		$emergencynumber=$_POST['emergencynumber'];
		$country=$_POST['country'];
		$pcode=$_POST['pcode'];
		$weight=$_POST['weight'];
		$height=$_POST['height'];
	
		//$sql = "INSERT INTO doctor (Gender,DOB,BIO,ClinicName,ClinicAddress,City,State,Country,Pincode,Service,Special)VALUES ('$gender','$dob','$bio','$cname','$caddress','$ccity','$ccity','$ccstate'',$ccountry','$cpcode','$service','$generalization') ";
		$sql = "UPDATE patient SET lname='".$lname."',dob='".$dob."',bgroup='".$bg."',Contact='".$contact."',	address='".$address."',city='".$city."',country='".$country."',pincode='".$pcode."',weight='".$weight."',height='".$height."',emergencynumber='".$emergencynumber."' WHERE Email='$email'";
   
        if (mysqli_query($conn,$sql)){
                echo "Updated";
                }
			else
			{
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
	
	}
	
?>
<!DOCTYPE html> 
<html lang="en">
	
<!-- Docter/profile-settings.php  30 Nov 2019 04:12:18 GMT -->
<head>
		<meta charset="utf-8">
		<title>Patient</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
	
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
						<img src="assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
					</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="search.php" class="menu-logo">
								<img src="assets/img/logo.png" class="img-fluid" alt="Logo">
							</a>
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
								<p class="contact-header">Emergency number</p>
								<p class="contact-info-header"><?php echo $emergencynumber;?></p>
							</div>
						</li>
						
						<!-- User Menu -->
						<li class="nav-item dropdown has-arrow logged-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
								<?php
								if (isset($rows['Image'])) {
									$image = isset($rows['Image']) ? $rows['Image'] : '';
									$encodedImage = base64_encode($image);
									echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
									
								}
                                  
                                ?>

								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<?php 
											$image = isset($rows['Image']) ? $rows['Image'] : ''; // Assurez-vous que $rows['Image'] n'est pas null
											$encodedImage = base64_encode($image);
												echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
										?>
									</div>
									<div class="user-text">
										<h6><?php echo $user; ?></h6>
										<p class="text-muted mb-0">Patient</p>
									</div>
								</div>
								<a class="dropdown-item" href="patient-dashboard.php">Dashboard</a>
								<a class="dropdown-item" href="profile-settings.php">Profile Settings</a>
								
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
									<li class="breadcrumb-item"><a href="search.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile Settings</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
					
						<!-- Profile Sidebar -->
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
										<?php
                                               $image = isset($rows['Image']) ? $rows['Image'] : ''; // Assurez-vous que $rows['Image'] n'est pas null
                                            $encodedImage = base64_encode($image);
                                             echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
                                        ?>

										</a>
										<div class="profile-det-info">
											<h3><?php echo $name;?></h3>
											<div class="patient-details">
												<h5><i class="fas fa-blood"></i><?php echo $bg;?></h5>
												<h5><i class="fas fa-ruler"></i><?php echo $height;?> cm</h5>
												<h5><i class="fas fa-weight"></i><?php echo $weight;?> kg</h5>
												<h5><i class="fas fa-birthday-cake"></i><?php echo $dob;?></h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i><?php echo $address;?>, <?php echo $city;?>, <?php echo $country;?></h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
												<a href="patient-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="search.php">
													<i class="fas fa-bookmark"></i>
													<span>Book Appointment</span>
												</a>
											</li>
											
											<li class="active">
												<a href="profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="change-password.php">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="index.php">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
						</div>
						<!-- /Profile Sidebar -->
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									
									<!-- Profile Settings Form -->
								
										<div class="row form-row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<div class="change-avatar">
														<div class="profile-img">
															
														<?php 
														$image = isset($rows['Image']) ? $rows['Image'] : ''; // Assurez-vous que $rows['Image'] n'est pas null
														$encodedImage = base64_encode($image);
														 echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
														?>
														</div>
													<form method="POST"  enctype="multipart/form-data" >
			<div class="upload-img">
				<div class="change-photo-btn">
					<span><i ></i> Select Photo</span>
					<input type="file" class="upload" name="image" id="image">
				</div>
				<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 50KB</small>
			</div>
			<div class="upload-img">
				<div class="change-photo-btn">
					<span><i class="fa fa-upload"></i> Upload Photo</span>
					<input type="submit" name="insert" id="insert" value="Insert" class="upload">
				
				</div>
				
			</div>
</form>
	<form method="post" action="profile-settings.php">
													</div>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>First Name</label>
													<input type="text" class="form-control" value="<?php echo $name;?>" name="name">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>last Name</label>
													<input type="text" class="form-control" value="<?php echo $lname;?>" name="lname">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Date of Birth</label>
													<div class="cal-icon">
														<input type="text" class="form-control datetimepicker" value="<?php echo $dob ;?>" name="dob">
													</div>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Blood Group</label>
													<select class="form-control select" required value=
													"" name="bgroup">
													    
													    <option><?php echo $bg;?></option>
														<option>A-</option>
														<option>A+</option>
														<option>B-</option>
														<option>B+</option>
														<option>AB-</option>
														<option>AB+</option>
														<option>O-</option>
														<option>O+</option>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>weight</label>
													<input type="text" value="<?php echo $weight ;?>" class="form-control" name="weight">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>height</label>
													<input type="text" value="<?php echo $height ;?>" class="form-control" name="height">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Email ID</label>
													<input type="email" class="form-control" value="<?php echo $email; ?> " readonly>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Mobile</label>
													<input type="text" value="<?php echo $contact ;?>" class="form-control" name="contact">
												</div>
											</div>
											
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>City</label>
													<input type="text" class="form-control" value="<?php echo $city ;?>" name="city">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>emergency number</label>
													<input type="text" class="form-control" value="<?php echo $emergencynumber ;?>" name="emergencynumber">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
												<label>Address</label>
													<input type="text" class="form-control" value="<?php echo $address ;?>" name="address">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label for="country">Country</label>
													<select id="country" class="form-control" name="country">
														<option value="">Select a country</option>
														<option value="AF" <?php echo $country == 'AF' ? 'selected' : ''; ?>>Afghanistan</option>
														<option value="AL" <?php echo $country == 'AL' ? 'selected' : ''; ?>>Albania</option>
														<option value="DZ" <?php echo $country == 'DZ' ? 'selected' : ''; ?>>Algeria</option>
														<option value="AD" <?php echo $country == 'AD' ? 'selected' : ''; ?>>Andorra</option>
														<option value="AO" <?php echo $country == 'AO' ? 'selected' : ''; ?>>Angola</option>
														<option value="AG" <?php echo $country == 'AG' ? 'selected' : ''; ?>>Antigua and Barbuda</option>
														<option value="AR" <?php echo $country == 'AR' ? 'selected' : ''; ?>>Argentina</option>
														<option value="AM" <?php echo $country == 'AM' ? 'selected' : ''; ?>>Armenia</option>
														<option value="AU" <?php echo $country == 'AU' ? 'selected' : ''; ?>>Australia</option>
														<option value="AT" <?php echo $country == 'AT' ? 'selected' : ''; ?>>Austria</option>
														<option value="AZ" <?php echo $country == 'AZ' ? 'selected' : ''; ?>>Azerbaijan</option>
														<option value="BS" <?php echo $country == 'BS' ? 'selected' : ''; ?>>Bahamas</option>
														<option value="BH" <?php echo $country == 'BH' ? 'selected' : ''; ?>>Bahrain</option>
														<option value="BD" <?php echo $country == 'BD' ? 'selected' : ''; ?>>Bangladesh</option>
														<option value="BB" <?php echo $country == 'BB' ? 'selected' : ''; ?>>Barbados</option>
														<option value="BY" <?php echo $country == 'BY' ? 'selected' : ''; ?>>Belarus</option>
														<option value="BE" <?php echo $country == 'BE' ? 'selected' : ''; ?>>Belgium</option>
														<option value="BZ" <?php echo $country == 'BZ' ? 'selected' : ''; ?>>Belize</option>
														<option value="BJ" <?php echo $country == 'BJ' ? 'selected' : ''; ?>>Benin</option>
														<option value="BT" <?php echo $country == 'BT' ? 'selected' : ''; ?>>Bhutan</option>
														<option value="BO" <?php echo $country == 'BO' ? 'selected' : ''; ?>>Bolivia</option>
														<option value="BA" <?php echo $country == 'BA' ? 'selected' : ''; ?>>Bosnia and Herzegovina</option>
														<option value="BW" <?php echo $country == 'BW' ? 'selected' : ''; ?>>Botswana</option>
														<option value="BR" <?php echo $country == 'BR' ? 'selected' : ''; ?>>Brazil</option>
														<option value="BN" <?php echo $country == 'BN' ? 'selected' : ''; ?>>Brunei Darussalam</option>
														<option value="BG" <?php echo $country == 'BG' ? 'selected' : ''; ?>>Bulgaria</option>
														<option value="BF" <?php echo $country == 'BF' ? 'selected' : ''; ?>>Burkina Faso</option>
														<option value="BI" <?php echo $country == 'BI' ? 'selected' : ''; ?>>Burundi</option>
														<option value="CV" <?php echo $country == 'CV' ? 'selected' : ''; ?>>Cabo Verde</option>
														<option value="KH" <?php echo $country == 'KH' ? 'selected' : ''; ?>>Cambodia</option>
														<option value="CM" <?php echo $country == 'CM' ? 'selected' : ''; ?>>Cameroon</option>
														<option value="CA" <?php echo $country == 'CA' ? 'selected' : ''; ?>>Canada</option>
														<option value="CF" <?php echo $country == 'CF' ? 'selected' : ''; ?>>Central African Republic</option>
														<option value="TD" <?php echo $country == 'TD' ? 'selected' : ''; ?>>Chad</option>
														<option value="CL" <?php echo $country == 'CL' ? 'selected' : ''; ?>>Chile</option>
														<option value="CN" <?php echo $country == 'CN' ? 'selected' : ''; ?>>China</option>
														<option value="CO" <?php echo $country == 'CO' ? 'selected' : ''; ?>>Colombia</option>
														<option value="KM" <?php echo $country == 'KM' ? 'selected' : ''; ?>>Comoros</option>
														<option value="CG" <?php echo $country == 'CG' ? 'selected' : ''; ?>>Congo, Republic</option>
														<option value="CD" <?php echo $country == 'CD' ? 'selected' : ''; ?>>Congo, Democratic Republic of the</option>
														<option value="CK" <?php echo $country == 'CK' ? 'selected' : ''; ?>>Cook Islands</option>
														<option value="CR" <?php echo $country == 'CR' ? 'selected' : ''; ?>>Costa Rica</option>
														<option value="CI" <?php echo $country == 'CI' ? 'selected' : ''; ?>>Côte d'Ivoire</option>
														<option value="HR" <?php echo $country == 'HR' ? 'selected' : ''; ?>>Croatia</option>
														<option value="CU" <?php echo $country == 'CU' ? 'selected' : ''; ?>>Cuba</option>
														<option value="CY" <?php echo $country == 'CY' ? 'selected' : ''; ?>>Cyprus</option>
														<option value="CZ" <?php echo $country == 'CZ' ? 'selected' : ''; ?>>Czech Republic</option>
														<option value="DK" <?php echo $country == 'DK' ? 'selected' : ''; ?>>Denmark</option>
														<option value="DJ" <?php echo $country == 'DJ' ? 'selected' : ''; ?>>Djibouti</option>
														<option value="DM" <?php echo $country == 'DM' ? 'selected' : ''; ?>>Dominica</option>
														<option value="DO" <?php echo $country == 'DO' ? 'selected' : ''; ?>>Dominican Republic</option>
														<option value="EC" <?php echo $country == 'EC' ? 'selected' : ''; ?>>Ecuador</option>
														<option value="EG" <?php echo $country == 'EG' ? 'selected' : ''; ?>>Egypt</option>
														<option value="SV" <?php echo $country == 'SV' ? 'selected' : ''; ?>>El Salvador</option>
														<option value="GQ" <?php echo $country == 'GQ' ? 'selected' : ''; ?>>Equatorial Guinea</option>
														<option value="ER" <?php echo $country == 'ER' ? 'selected' : ''; ?>>Eritrea</option>
														<option value="EE" <?php echo $country == 'EE' ? 'selected' : ''; ?>>Estonia</option>
														<option value="ET" <?php echo $country == 'ET' ? 'selected' : ''; ?>>Ethiopia</option>
														<option value="FJ" <?php echo $country == 'FJ' ? 'selected' : ''; ?>>Fiji</option>
														<option value="FI" <?php echo $country == 'FI' ? 'selected' : ''; ?>>Finland</option>
														<option value="FR" <?php echo $country == 'FR' ? 'selected' : ''; ?>>France</option>
														<option value="GA" <?php echo $country == 'GA' ? 'selected' : ''; ?>>Gabon</option>
														<option value="GM" <?php echo $country == 'GM' ? 'selected' : ''; ?>>Gambia</option>
														<option value="GE" <?php echo $country == 'GE' ? 'selected' : ''; ?>>Georgia</option>
														<option value="DE" <?php echo $country == 'DE' ? 'selected' : ''; ?>>Germany</option>
														<option value="GH" <?php echo $country == 'GH' ? 'selected' : ''; ?>>Ghana</option>
														<option value="GR" <?php echo $country == 'GR' ? 'selected' : ''; ?>>Greece</option>
														<option value="GD" <?php echo $country == 'GD' ? 'selected' : ''; ?>>Grenada</option>
														<option value="GT" <?php echo $country == 'GT' ? 'selected' : ''; ?>>Guatemala</option>
														<option value="GN" <?php echo $country == 'GN' ? 'selected' : ''; ?>>Guinea</option>
														<option value="GW" <?php echo $country == 'GW' ? 'selected' : ''; ?>>Guinea-Bissau</option>
														<option value="GY" <?php echo $country == 'GY' ? 'selected' : ''; ?>>Guyana</option>
														<option value="HT" <?php echo $country == 'HT' ? 'selected' : ''; ?>>Haiti</option>
														<option value="HN" <?php echo $country == 'HN' ? 'selected' : ''; ?>>Honduras</option>
														<option value="HK" <?php echo $country == 'HK' ? 'selected' : ''; ?>>Hong Kong</option>
														<option value="HU" <?php echo $country == 'HU' ? 'selected' : ''; ?>>Hungary</option>
														<option value="IS" <?php echo $country == 'IS' ? 'selected' : ''; ?>>Iceland</option>
														<option value="IN" <?php echo $country == 'IN' ? 'selected' : ''; ?>>India</option>
														<option value="ID" <?php echo $country == 'ID' ? 'selected' : ''; ?>>Indonesia</option>
														<option value="IR" <?php echo $country == 'IR' ? 'selected' : ''; ?>>Iran</option>
														<option value="IQ" <?php echo $country == 'IQ' ? 'selected' : ''; ?>>Iraq</option>
														<option value="IE" <?php echo $country == 'IE' ? 'selected' : ''; ?>>Ireland</option>
														<option value="IL" <?php echo $country == 'IL' ? 'selected' : ''; ?>>Israel</option>
														<option value="IT" <?php echo $country == 'IT' ? 'selected' : ''; ?>>Italy</option>
														<option value="JM" <?php echo $country == 'JM' ? 'selected' : ''; ?>>Jamaica</option>
														<option value="JP" <?php echo $country == 'JP' ? 'selected' : ''; ?>>Japan</option>
														<option value="JO" <?php echo $country == 'JO' ? 'selected' : ''; ?>>Jordan</option>
														<option value="KZ" <?php echo $country == 'KZ' ? 'selected' : ''; ?>>Kazakhstan</option>
														<option value="KE" <?php echo $country == 'KE' ? 'selected' : ''; ?>>Kenya</option>
														<option value="KI" <?php echo $country == 'KI' ? 'selected' : ''; ?>>Kiribati</option>
														<option value="KP" <?php echo $country == 'KP' ? 'selected' : ''; ?>>North Korea</option>
														<option value="KR" <?php echo $country == 'KR' ? 'selected' : ''; ?>>South Korea</option>
														<option value="KW" <?php echo $country == 'KW' ? 'selected' : ''; ?>>Kuwait</option>
														<option value="KG" <?php echo $country == 'KG' ? 'selected' : ''; ?>>Kyrgyzstan</option>
														<option value="LA" <?php echo $country == 'LA' ? 'selected' : ''; ?>>Laos</option>
														<option value="LV" <?php echo $country == 'LV' ? 'selected' : ''; ?>>Latvia</option>
														<option value="LB" <?php echo $country == 'LB' ? 'selected' : ''; ?>>Lebanon</option>
														<option value="LS" <?php echo $country == 'LS' ? 'selected' : ''; ?>>Lesotho</option>
														<option value="LR" <?php echo $country == 'LR' ? 'selected' : ''; ?>>Liberia</option>
														<option value="LY" <?php echo $country == 'LY' ? 'selected' : ''; ?>>Libya</option>
														<option value="LI" <?php echo $country == 'LI' ? 'selected' : ''; ?>>Liechtenstein</option>
														<option value="LT" <?php echo $country == 'LT' ? 'selected' : ''; ?>>Lithuania</option>
														<option value="LU" <?php echo $country == 'LU' ? 'selected' : ''; ?>>Luxembourg</option>
														<option value="MO" <?php echo $country == 'MO' ? 'selected' : ''; ?>>Macao</option>
														<option value="MG" <?php echo $country == 'MG' ? 'selected' : ''; ?>>Madagascar</option>
														<option value="MW" <?php echo $country == 'MW' ? 'selected' : ''; ?>>Malawi</option>
														<option value="MY" <?php echo $country == 'MY' ? 'selected' : ''; ?>>Malaysia</option>
														<option value="MV" <?php echo $country == 'MV' ? 'selected' : ''; ?>>Maldives</option>
														<option value="ML" <?php echo $country == 'ML' ? 'selected' : ''; ?>>Mali</option>
														<option value="MT" <?php echo $country == 'MT' ? 'selected' : ''; ?>>Malta</option>
														<option value="MH" <?php echo $country == 'MH' ? 'selected' : ''; ?>>Marshall Islands</option>
														<option value="MR" <?php echo $country == 'MR' ? 'selected' : ''; ?>>Mauritania</option>
														<option value="MU" <?php echo $country == 'MU' ? 'selected' : ''; ?>>Mauritius</option>
														<option value="MX" <?php echo $country == 'MX' ? 'selected' : ''; ?>>Mexico</option>
														<option value="FM" <?php echo $country == 'FM' ? 'selected' : ''; ?>>Micronesia</option>
														<option value="MD" <?php echo $country == 'MD' ? 'selected' : ''; ?>>Moldova</option>
														<option value="MC" <?php echo $country == 'MC' ? 'selected' : ''; ?>>Monaco</option>
														<option value="MN" <?php echo $country == 'MN' ? 'selected' : ''; ?>>Mongolia</option>
														<option value="ME" <?php echo $country == 'ME' ? 'selected' : ''; ?>>Montenegro</option>
														<option value="MA" <?php echo $country == 'MA' ? 'selected' : ''; ?>>Morocco</option>
														<option value="MZ" <?php echo $country == 'MZ' ? 'selected' : ''; ?>>Mozambique</option>
														<option value="MM" <?php echo $country == 'MM' ? 'selected' : ''; ?>>Myanmar</option>
														<option value="NA" <?php echo $country == 'NA' ? 'selected' : ''; ?>>Namibia</option>
														<option value="NR" <?php echo $country == 'NR' ? 'selected' : ''; ?>>Nauru</option>
														<option value="NP" <?php echo $country == 'NP' ? 'selected' : ''; ?>>Nepal</option>
														<option value="NL" <?php echo $country == 'NL' ? 'selected' : ''; ?>>Netherlands</option>
														<option value="NC" <?php echo $country == 'NC' ? 'selected' : ''; ?>>New Caledonia</option>
														<option value="NZ" <?php echo $country == 'NZ' ? 'selected' : ''; ?>>New Zealand</option>
														<option value="NI" <?php echo $country == 'NI' ? 'selected' : ''; ?>>Nicaragua</option>
														<option value="NE" <?php echo $country == 'NE' ? 'selected' : ''; ?>>Niger</option>
														<option value="NG" <?php echo $country == 'NG' ? 'selected' : ''; ?>>Nigeria</option>
														<option value="NU" <?php echo $country == 'NU' ? 'selected' : ''; ?>>Niue</option>
														<option value="NF" <?php echo $country == 'NF' ? 'selected' : ''; ?>>Norfolk Island</option>
														<option value="MP" <?php echo $country == 'MP' ? 'selected' : ''; ?>>Northern Mariana Islands</option>
														<option value="NO" <?php echo $country == 'NO' ? 'selected' : ''; ?>>Norway</option>
														<option value="OM" <?php echo $country == 'OM' ? 'selected' : ''; ?>>Oman</option>
														<option value="PK" <?php echo $country == 'PK' ? 'selected' : ''; ?>>Pakistan</option>
														<option value="PW" <?php echo $country == 'PW' ? 'selected' : ''; ?>>Palau</option>
														<option value="PS" <?php echo $country == 'PS' ? 'selected' : ''; ?>>Palestine</option>
														<option value="PA" <?php echo $country == 'PA' ? 'selected' : ''; ?>>Panama</option>
														<option value="PG" <?php echo $country == 'PG' ? 'selected' : ''; ?>>Papua New Guinea</option>
														<option value="PY" <?php echo $country == 'PY' ? 'selected' : ''; ?>>Paraguay</option>
														<option value="PE" <?php echo $country == 'PE' ? 'selected' : ''; ?>>Peru</option>
														<option value="PH" <?php echo $country == 'PH' ? 'selected' : ''; ?>>Philippines</option>
														<option value="PN" <?php echo $country == 'PN' ? 'selected' : ''; ?>>Pitcairn Islands</option>
														<option value="PL" <?php echo $country == 'PL' ? 'selected' : ''; ?>>Poland</option>
														<option value="PT" <?php echo $country == 'PT' ? 'selected' : ''; ?>>Portugal</option>
														<option value="PR" <?php echo $country == 'PR' ? 'selected' : ''; ?>>Puerto Rico</option>
														<option value="QA" <?php echo $country == 'QA' ? 'selected' : ''; ?>>Qatar</option>
														<option value="RE" <?php echo $country == 'RE' ? 'selected' : ''; ?>>Réunion</option>
														<option value="RO" <?php echo $country == 'RO' ? 'selected' : ''; ?>>Romania</option>
														<option value="RU" <?php echo $country == 'RU' ? 'selected' : ''; ?>>Russia</option>
														<option value="RW" <?php echo $country == 'RW' ? 'selected' : ''; ?>>Rwanda</option>
														<option value="BL" <?php echo $country == 'BL' ? 'selected' : ''; ?>>Saint Barthélemy</option>
														<option value="SH" <?php echo $country == 'SH' ? 'selected' : ''; ?>>Saint Helena</option>
														<option value="KN" <?php echo $country == 'KN' ? 'selected' : ''; ?>>Saint Kitts and Nevis</option>
														<option value="LC" <?php echo $country == 'LC' ? 'selected' : ''; ?>>Saint Lucia</option>
														<option value="MF" <?php echo $country == 'MF' ? 'selected' : ''; ?>>Saint Martin</option>
														<option value="PM" <?php echo $country == 'PM' ? 'selected' : ''; ?>>Saint Pierre and Miquelon</option>
														<option value="VC" <?php echo $country == 'VC' ? 'selected' : ''; ?>>Saint Vincent and the Grenadines</option>
														<option value="WS" <?php echo $country == 'WS' ? 'selected' : ''; ?>>Samoa</option>
														<option value="SM" <?php echo $country == 'SM' ? 'selected' : ''; ?>>San Marino</option>
														<option value="ST" <?php echo $country == 'ST' ? 'selected' : ''; ?>>Sao Tome and Principe</option>
														<option value="SA" <?php echo $country == 'SA' ? 'selected' : ''; ?>>Saudi Arabia</option>
														<option value="SN" <?php echo $country == 'SN' ? 'selected' : ''; ?>>Senegal</option>
														<option value="RS" <?php echo $country == 'RS' ? 'selected' : ''; ?>>Serbia</option>
														<option value="SC" <?php echo $country == 'SC' ? 'selected' : ''; ?>>Seychelles</option>
														<option value="SL" <?php echo $country == 'SL' ? 'selected' : ''; ?>>Sierra Leone</option>
														<option value="SG" <?php echo $country == 'SG' ? 'selected' : ''; ?>>Singapore</option>
														<option value="SX" <?php echo $country == 'SX' ? 'selected' : ''; ?>>Sint Maarten</option>
														<option value="SK" <?php echo $country == 'SK' ? 'selected' : ''; ?>>Slovakia</option>
														<option value="SI" <?php echo $country == 'SI' ? 'selected' : ''; ?>>Slovenia</option>
														<option value="SB" <?php echo $country == 'SB' ? 'selected' : ''; ?>>Solomon Islands</option>
														<option value="SO" <?php echo $country == 'SO' ? 'selected' : ''; ?>>Somalia</option>
														<option value="ZA" <?php echo $country == 'ZA' ? 'selected' : ''; ?>>South Africa</option>
														<option value="GS" <?php echo $country == 'GS' ? 'selected' : ''; ?>>South Georgia and the South Sandwich Islands</option>
														<option value="SS" <?php echo $country == 'SS' ? 'selected' : ''; ?>>South Sudan</option>
														<option value="ES" <?php echo $country == 'ES' ? 'selected' : ''; ?>>Spain</option>
														<option value="LK" <?php echo $country == 'LK' ? 'selected' : ''; ?>>Sri Lanka</option>
														<option value="SD" <?php echo $country == 'SD' ? 'selected' : ''; ?>>Sudan</option>
														<option value="SR" <?php echo $country == 'SR' ? 'selected' : ''; ?>>Suriname</option>
														<option value="SZ" <?php echo $country == 'SZ' ? 'selected' : ''; ?>>Swaziland</option>
														<option value="SE" <?php echo $country == 'SE' ? 'selected' : ''; ?>>Sweden</option>
														<option value="CH" <?php echo $country == 'CH' ? 'selected' : ''; ?>>Switzerland</option>
														<option value="SY" <?php echo $country == 'SY' ? 'selected' : ''; ?>>Syria</option>
														<option value="TW" <?php echo $country == 'TW' ? 'selected' : ''; ?>>Taiwan</option>
														<option value="TJ" <?php echo $country == 'TJ' ? 'selected' : ''; ?>>Tajikistan</option>
														<option value="TZ" <?php echo $country == 'TZ' ? 'selected' : ''; ?>>Tanzania</option>
														<option value="TH" <?php echo $country == 'TH' ? 'selected' : ''; ?>>Thailand</option>
														<option value="TL" <?php echo $country == 'TL' ? 'selected' : ''; ?>>Timor-Leste</option>
														<option value="TG" <?php echo $country == 'TG' ? 'selected' : ''; ?>>Togo</option>
														<option value="TK" <?php echo $country == 'TK' ? 'selected' : ''; ?>>Tokelau</option>
														<option value="TO" <?php echo $country == 'TO' ? 'selected' : ''; ?>>Tonga</option>
														<option value="TT" <?php echo $country == 'TT' ? 'selected' : ''; ?>>Trinidad and Tobago</option>
														<option value="TN" <?php echo $country == 'TN' ? 'selected' : ''; ?>>Tunisia</option>
														<option value="TR" <?php echo $country == 'TR' ? 'selected' : ''; ?>>Turkey</option>
														<option value="TM" <?php echo $country == 'TM' ? 'selected' : ''; ?>>Turkmenistan</option>
														<option value="TC" <?php echo $country == 'TC' ? 'selected' : ''; ?>>Turks and Caicos Islands</option>
														<option value="TV" <?php echo $country == 'TV' ? 'selected' : ''; ?>>Tuvalu</option>
														<option value="UG" <?php echo $country == 'UG' ? 'selected' : ''; ?>>Uganda</option>
														<option value="UA" <?php echo $country == 'UA' ? 'selected' : ''; ?>>Ukraine</option>
														<option value="AE" <?php echo $country == 'AE' ? 'selected' : ''; ?>>United Arab Emirates</option>
														<option value="GB" <?php echo $country == 'GB' ? 'selected' : ''; ?>>United Kingdom</option>
														<option value="US" <?php echo $country == 'US' ? 'selected' : ''; ?>>United States</option>
														<option value="UY" <?php echo $country == 'UY' ? 'selected' : ''; ?>>Uruguay</option>
														<option value="UZ" <?php echo $country == 'UZ' ? 'selected' : ''; ?>>Uzbekistan</option>
														<option value="VU" <?php echo $country == 'VU' ? 'selected' : ''; ?>>Vanuatu</option>
														<option value="VE" <?php echo $country == 'VE' ? 'selected' : ''; ?>>Venezuela</option>
														<option value="VN" <?php echo $country == 'VN' ? 'selected' : ''; ?>>Vietnam</option>
														<option value="WF" <?php echo $country == 'WF' ? 'selected' : ''; ?>>Wallis and Futuna</option>
														<option value="EH" <?php echo $country == 'EH' ? 'selected' : ''; ?>>Western Sahara</option>
														<option value="YE" <?php echo $country == 'YE' ? 'selected' : ''; ?>>Yemen</option>
														<option value="ZM" <?php echo $country == 'ZM' ? 'selected' : ''; ?>>Zambia</option>
														<option value="ZW" <?php echo $country == 'ZW' ? 'selected' : ''; ?>>Zimbabwe</option>
													</select>
												</div>
											</div>
										</div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary submit-btn" name="login">Save Changes</button>
										</div>
									</form>
									<!-- /Profile Settings Form -->
									
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
   <script>  
 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>  
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									
											</ul>
										</div>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0"><a href="templateshub.net"></a></p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="term-condition.php">Terms and Conditions</a></li>
											<li><a href="privacy-policy.php">Policy</a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  <script src="assets/js/removebanner.js"></script>
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- Docter/profile-settings.php  30 Nov 2019 04:12:18 GMT -->
</html>