<?php 
include "dbconfig/db.php";
session_start();
$email=$_SESSION['email'];
if (isset($_POST['login'])){
	$doa=$_POST['doa'];
	$dmail=$_POST['dmail'];
	$toa=$_POST['time'];
	$apid=getAppointmentId();
//	echo $dmail;
	$sql = "INSERT INTO appointments (AppointmentId,DoctorMail,PatientMail,DateOfAppointment,Time) VALUES ('$apid','$dmail','$email','$doa','$toa') ";

	if (mysqli_query($conn, $sql)) {
	//	echo "<h2>Appointment Booked Successfully";
		header( "Refresh:1; url=patient-dashboard.php");

	}else{
		echo "<h2>Error on Booking appointment";
		header( "url=search.php");
	}

}
function getAppointmentId(){
	$unique=uniqid();
	$file = substr($unique, strlen($unique) - 6, strlen($unique));
	$aid="ID".$file;
	return $aid;
}
?>