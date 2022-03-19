<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$voter = $_POST['voter'];
		
		$sql = "SELECT * FROM voters WHERE firstname = '$voter'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find voter with the ID';
		}
		// Comparing the fingerprint
		else{
			$row = $query->fetch_assoc();
			$image = 'images/fingerprints/'.$row['photo'];

			$fingerprintDatabase =md5(file_get_contents($image));
			$fingerprintForm =md5(file_get_contents($_FILES['fingerprint']['tmp_name']));
			if($fingerprintDatabase == $fingerprintForm){
				$_SESSION['voter'] = $row['id'];
			}
			else{
				$_SESSION['error'] = 'Incorrect Fingerprint Image';
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input voter credentials first';
	}

	header('location: index.php');

?>