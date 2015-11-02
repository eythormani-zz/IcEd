<?php
	require 'assets/php/kickOut.php';
	require 'assets/php/dbCon.php';
	$SQL = "SELECT ID, name FROM subjects";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	$returnedSubjects = $logon->fetchAll();

	$SQL = "SELECT ID, name FROM grades";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	$returnedGrades = $logon->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bættu við verkefni</title>

	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="./assets/style/main.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
	<nav id="navigation"></nav>
	<div id ="main"><!--display search results-->
		<h1>Hér getur þú sett inn nýtt verkefni</h1>
		<div class="uploadForm">
			<label for="fileToUpload">Veldu rétta skrá:</label>
	 		<input class="form-control uploadFormInput" type="file" name="fileToUpload" id="fileToUpload">
			<label for="name">Skýrðu verkefnið eitthvað fallegt:</label>
		    <input class="form-control uploadFormInput" type="text" name="name" placeholder="Nafn Verkefnis">
			<label for="description">Lýstu verkefninu vel:</label>
		    <textarea class="form-control uploadFormInput" name="description" rows="8" cols="40"></textarea>
			<div class="form-inline">
				<label for="tags">Hvaða tög hæfa verkefninu?</label><br>
				<input type="text" placeholder="Bættu við tagi" id="tagMaker" class="form-control uploadFormInput">
				<input type="submit" class="btn" id="confirmTag" value="Staðfesta tag"></input>
				<div id="tagContainer"></div>
			</div>
			<label for="subject">Fyrir hvaða fag er námsefnið?</label>
			<select class="form-control" name="subject">
				<?php
					foreach ($returnedSubjects as $temp) {
						echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
					}
				?>
			</select>
			<label for="grades">Hvaða bekkjum hentar námsefnið?</label><br>
			<?php
				foreach ($returnedGrades as $temp) {
					echo '<div class="uploadCheckbox"><input name="grades" type="checkbox" value="' . $temp['ID'] . '">' . $temp['name'] . '</div>';
				}
			?>
		    <input type="submit" class="btn uploadFormInput" value="Senda inn verkefni"></input>
	 	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="./assets/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	// define varibles
	var box;
	var thing;
	var tag;
	var deletr;
	var tagArray = new Array();
	// if button is pressed


		var textBoxToggled = function(){
		box = $('#tagContainer');
		tag = $('#tagMaker').val();

		if (tag == "") {
			alert("Tagið má ekki vera tómt");
			return;
		};
		if ($.inArray(tag, tagArray) > -1) {//tékka hvort að tagið sé núþegar í Arrayinu
			alert("Bara er hægt að nota hvert tag einu sinni");//vara notendan við
			return;//Hætti keyrslu functionsins
		};
		tagArray.push(tag);//ef stakið er ekki til, set ég það í arrayinn
		//Bý til elementin div og span
		deletr = document.createElement("div");
	    thing = document.createElement("span");
	    //set elementið thing í tagContainerinn
	    box.append(thing);
	    thing.innerHTML = tag;//set textann í taginu sem tagið sem notandinn bað um
	    thing.className = "chosenTag";//set viðeigandi klasa á tagið
		deletr.className = "glyphicon glyphicon-remove deleteTag";//set viðeigandi klasa á x takkan sem sér um að fjarlægja tagið

		deletr.addEventListener("click", deleteThing);
	    thing.appendChild(deletr);
	    document.getElementById('tagMaker').value = "";
			$('#tagMaker').focus();    // put focus back on the textbox
	};
	$("#confirmTag").click(textBoxToggled); // if the add button is pressed
	$('#tagMaker').keypress(function(e){    // if enter is presed whilest over the text box.
		if(e.which == 13){
			textBoxToggled();
		};
	});
	var soonGone;
	function deleteThing () {
		soonGone = this.closest('.chosenTag');
		var toBeRemoved = this.closest('.chosenTag').textContent;
		tagArray.splice($.inArray(toBeRemoved, tagArray), 1);
		this.closest('.chosenTag').remove();
	}
	</script>
</body>
</html>
