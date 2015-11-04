<?php
	require 'assets/php/kickOut.php';
	require 'assets/php/dbCon.php';
	$id = $_SESSION['username'];
	$SQL = "SELECT name, address, email, phone FROM users WHERE id = $id";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	$returnedData = $logon->fetch();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="./assets/style/main.css" media="screen" title="no title" charset="utf-8">
	<title>Stillingar fyrir notendur</title>
</head>
<body id="bodyUserSettings">
	<nav id="navigation"></nav>
	<div id="main">
		<div id="form">
			<h1>Hérna eru þínar upplýsingar</h1>
			<label for="name">Nafn:</label>
			<input class="form-control" type="text" id="name" value="<?php echo $returnedData['name'] ?>"><br>
			<label for="name">Heimilisfang:</label>
			<input class="form-control" type="text" id="address" value="<?php echo $returnedData['address'] ?>"><br>
			<label for="name">Tölvupóstfang:</label>
			<input class="form-control" type="text" id="email" value="<?php echo $returnedData['email'] ?>"><br>
			<label for="name">Símanúmer:</label>
			<input class="form-control" type="text" id="phone" value="<?php echo $returnedData['phone'] ?>">
			<h1>Breyttu þeim fögum sem þú kennir</h1>
			<div class="allSubjects">
				<?php 
					//selects all IDs and names from subjects
					$SQL = "SELECT ID, name FROM subjects";
					//prepares the query
					$logon = $pdo->prepare($SQL);
					//runs the query
					$logon->execute();
					//gets the values returned by the query
					$returnedSubjects = $logon->fetchAll();
					//selects IDs of the subjects taught by the logged in user
					$SQL = "SELECT subjectID from userSubjects WHERE userID = $id";
					//prepares the query
					$logon = $pdo->prepare($SQL);
					//runs the query
					$logon->execute();
					//gets the values returned by the array
					$returnedCurrentSubjects = $logon->fetchAll();
					//writes out all the subjects in the database
					foreach ($returnedSubjects as $temp) {
						//makes the label and the input and contactinates the relevant ID and name
						echo "<input name=\"subjects\" type=\"checkbox\" value=\"" . $temp['ID'] . "\" id=\"" . $temp['ID'] . "\"/>
							  <label for=\"" . $temp['ID'] . "\"><span>" . $temp['name'] . "</span></label>";
					}	
				 ?>
			</div>
			<h1>Hér getur þú breytt bekkjunum sem þú kennir</h1>
			<div class="allGrades">
				<?php 
					//selects all IDs and names from subjects
					$SQL = "SELECT ID, name FROM grades";
					//prepares the query
					$logon = $pdo->prepare($SQL);
					//runs the query
					$logon->execute();
					//gets the values returned by the query
					$returnedGrades = $logon->fetchAll();
					//selects IDs of the subjects taught by the logged in user
					$SQL = "SELECT gradeID from userGrades WHERE userID = $id";
					//prepares the query
					$logon = $pdo->prepare($SQL);
					//runs the query
					$logon->execute();
					//gets the values returned by the array
					$returnedCurrentGrades = $logon->fetchAll();
					//writes out all the subjects in the database
					foreach ($returnedGrades as $temp) {
						//makes the label and the input and contactinates the relevant ID and name
						echo "<input type=\"checkbox\" name=\"grade\" id=\"g" . $temp['ID'] . "\" value=\"" . $temp['ID'] . "\"/>
							  <label for=\"g" . $temp['ID'] . "\"><span>" . $temp['name'] . ". bekk</span></label>";
					}	
				?>
			</div>
			<button class="btn" id="submitChanges" >Breyta upplýsingum</button>
		</div>
		<div class="passwordChanger">
			<h1>Breyttu lykilorðinu þínu</h1>
			<label for="name">Gamalt lykilorð:</label>
			<input class="form-control" type="password" id="oldPass"><br>
			<label for="name">Nýtt lykilorð:</label>
			<input class="form-control" type="password" id="newPass0"><br>
			<label for="name">Staðfesting lykilorðs:</label>
			<input class="form-control" type="password" id="newPass1"><br>
			<button class="btn" id="confirmPassChange" >Staðfesta breytingar</button>
		</div>
	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="./assets/js/main.js" type="text/javascript"></script>
	<script type="text/javascript">
		//checks if the new passwords match, and if they do sends it to the PHP
		//don't even try to modify this to pass on a bad password, the PHP also preformes validation checks
		$('#confirmPassChange').click(function() {
			var oldPass = $('#oldPass').val();
			var newPass0 = $('#newPass0').val();
			var newPass1 = $('#newPass1').val();
			if (!newPass0 || !newPass1 || !oldPass) {
				alert("Þú þarft að filla í alla reitina");
				return;
			};
			if (newPass0 == newPass1) {
				$.ajax({
					url: 'assets/php/changePass.php',
					type: 'POST',
					data: {
						oldPass:oldPass,
						newPass1:newPass1,
						newPass0:newPass0
					},
					success: function(data) {
						console.log(data);
						if (data=="success") {alert("Lykilorðinu hefur verið breytt, notaðu það þegar þú skráir þig inn næst");};
						if (data=="nofit") {alert("Gamla lykilorðið var ekki rétt, því hefur ekki verið breytt");};
						
					}
				});
			};
			if (newPass0 != newPass1){
				alert("Lykilorðin eru ekki eins");
			}
		});

		var grades = new Array();
		var	subjects = new Array();
		$(document).ready(function() {
			$('#submitChanges').on('click', function() {   
			var name = $('#name').val();
			var address = $('#address').val();
			var email = $('#email').val();
			var phone = $('#phone').val();
			$.each($("input[name='grade']:checked"), function() {
				grades.push($(this).val());
			});
			$.each($("input[name='subjects']:checked"), function() {
				subjects.push($(this).val());
			});
				$.ajax({
					url: 'assets/php/editUser.php',
					type: 'POST',
					data: {
						name:name,
						address:address,
						email:email,
						phone:phone,
						grades:grades,
						subjects:subjects
					},
					success: function(data) {
						alert("Breytingar mótteknar");
					}
				});
			});
		});
	</script>
	<script type="text/javascript">
		<?php 
			//take the arrays in $returnedCurrentSubjects and select value with index subjectID and insert it into a new array
			foreach ($returnedCurrentSubjects as $temp) {
				//insert the relevant value into an array
				$realReturnedCurrentSubjects[] = $temp['subjectID'];
			}
			//for loop that runs as often as the number of indexes in $returnedSubjects
			for ($i=1; $i < sizeof($returnedSubjects)+1; $i++) {
				//if the value i exists in the array of ID's currently selected by the user
				if (in_array($i, $realReturnedCurrentSubjects)) {
					//echo out jQuery that will check the appropriate checkbox
					echo "$('#" . $i . "').prop('checked', true);";
				};
			}

			//take the arrays in $returnedCurrentSubjects and select value with index subjectID and insert it into a new array
			foreach ($returnedCurrentGrades as $temp) {
				//insert the relevant value into an array
				$realReturnedCurrentGrades[] = $temp['gradeID'];
			}
			//for loop that runs as often as the number of indexes in $returnedSubjects
			for ($i=1; $i < sizeof($returnedGrades)+1; $i++) {
				//if the value i exists in the array of ID's currently selected by the user
				if (in_array($i, $realReturnedCurrentGrades)) {
					//echo out jQuery that will check the appropriate checkbox
					echo "$('#g" . $i . "').prop('checked', true);";
				};
			}
		?>
	</script>
</body>
</html>
