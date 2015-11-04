<?php
	require 'assets/php/kickOut.php';
	require 'assets/php/dbCon.php';
	$SQL = "SELECT ID, name FROM subjects";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	$returnedSubjects = $logon->fetchAll();

	//velur öll tögin í gagnagrunninum og setur þau í array
	$SQL = "SELECT name FROM tags";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	while ($line = $logon->fetch(PDO::FETCH_ASSOC)) {
	    $returnedTags[] = $line['name'];
	}
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
		<form method="post" enctype="multipart/form-data" class="uploadForm" id="data">
			<label for="fileToUpload">Veldu rétta skrá:</label>
	 		<input class="form-control uploadFormInput" type="file" name="fileToUpload" id="fileToUpload">
			<label for="name">Skýrðu verkefnið eitthvað fallegt:</label>
		    <input name="name" class="form-control uploadFormInput" type="text" id="name" placeholder="Nafn Verkefnis">
			<label for="description">Lýstu verkefninu vel:</label>
		    <textarea name="description" class="form-control uploadFormInput" id="description" rows="8" cols="40"></textarea>
			<div class="form-inline">
				<label for="tags">Hvaða tög hæfa verkefninu?&nbsp;<i class="fa fa-tag"></i></label><br>
				<input type="text" placeholder="Bættu við tagi" id="tagMaker" class="form-control uploadFormInput">
				<button type="button" class="btn" id="confirmTag">Staðfesta tag</button>
				<div id="tagContainer"></div>
			</div>
			<label for="subject">Fyrir hvaða fag er námsefnið?</label>
			<select class="form-control" name="subject" id="subject">
				<?php
					foreach ($returnedSubjects as $temp) {
						echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
					}
				?>
			</select>
			<label for="grades">Hvaða bekkjum hentar námsefnið?</label><br>
			<?php 
					//selects all IDs and names from subjects
					$SQL = "SELECT ID, name FROM grades";
					//prepares the query
					$logon = $pdo->prepare($SQL);
					//runs the query
					$logon->execute();
					//gets the values returned by the query
					$returnedGrades = $logon->fetchAll();
					//writes out all the subjects in the database
					foreach ($returnedGrades as $temp) {
						//makes the label and the input and contactinates the relevant ID and name
						echo "<input type=\"checkbox\" name=\"grades[]\" id=\"g" . $temp['ID'] . "\" value=\"" . $temp['ID'] . "\"/>
							  <label for=\"g" . $temp['ID'] . "\"><span>" . $temp['name'] . ". bekk</span></label>";
					}	
				?>
	 	</form>
		<button class="btn uploadFormInput" id="submitUpload">Senda inn verkefni</button>
	<!-- Latest compiled and minified JavaScript -->
	<script src="./assets/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	//adds the tags in the PHP array into a javascript array
	var allTags = <?php print json_encode($returnedTags, JSON_UNESCAPED_UNICODE) ?>;
	//the jQueryUI autocomplete function
	$( "#tagMaker" ).autocomplete({
		//Select the correct sourceArray for the autocomplete function
	    source: allTags
	});
	// define varibles
	var tagArray = new Array();
	// if button is pressed
	var textBoxToggled = function(){
		var box = $('#tagContainer');
		var tag = $('#tagMaker').val();

		if (tag == "") {//athuga hvort að tagið sé tómt
			alert("Tagið má ekki vera tómt");
			return;
		};

		if ($.inArray(tag, tagArray) > -1) {//tékka hvort að tagið sé núþegar í Arrayinu
			alert("Bara er hægt að nota hvert tag einu sinni");//vara notendan við
			return;//Hætti keyrslu functionsins
		};

		tagArray.push(tag);//ef stakið er ekki til, set ég það í arrayinn
		//Bý til elementin div og span
		var deletr = document.createElement("div");
	    var thing = document.createElement("span");
	    //set elementið thing í tagContainerinn
	    box.append(thing);

	    thing.innerHTML = tag;//set textann í taginu sem tagið sem notandinn bað um
	    thing.className = "chosenTag";//set viðeigandi klasa á tagið
		deletr.className = "glyphicon glyphicon-remove deleteTag";//set viðeigandi klasa á x takkan sem sér um að fjarlægja tagið

		deletr.addEventListener("click", deleteThing);//add a click eventlistener to each individual tag
	    thing.appendChild(deletr);//add the delete element to the tag
	    document.getElementById('tagMaker').value = "";//empty the textbox after usage
		$('#tagMaker').focus();    // put focus back on the textbox
		//remove the added tag from the source array of the autocomplete dropdown
		allTags.splice($.inArray(tag, allTags), 1);
	};

	//this runs the function if either enter or the "add" button is pressed
	$("#confirmTag").click(textBoxToggled); // if the add button is pressed
	$('#tagMaker').keypress(function(e){    // if enter is presed whilest over the text box.
		if(e.which == 13){//run the function also if enter is pressed
			textBoxToggled();
		};
	});

	//function that removed the relevant tag if the X buttun is pressed
	function deleteThing () {
		var soonGone = this.closest('.chosenTag');//selects the closes parent element with the .chosenTag class, in this case it will be the relevant tag
		var toBeRemoved = soonGone.textContent;//this selects the text from the same tag
		tagArray.splice($.inArray(toBeRemoved, tagArray), 1);//remove the tag from the array that will be sent via Ajax
		allTags.push(toBeRemoved);//add the removed tag back to the dropdown
		soonGone.remove();//remove the closest tag
	}

	//the Ajax that sends the relevant data to the PHP files
	var grades = new Array();//create the grades array out of scope
	$("#submitUpload").click(function(){
		//take all the available formdata from the form
		//this is unable to take in the tags, so they will be inserted later
	    var formData = new FormData($("form#data")[0]);
	    //the actual ajax
	    $.ajax({
	        url: "assets/php/upload.php",//target the correct file
	        type: 'POST',//use POST for this
	        data: formData,//define the date that will be sent
	        success: function (data) {//if the ajax is successful, do this
	        	//this is a different Ajax query that sends the information about the tags to the database
	        	//it only runs if the other function is successful
	        	var uploadID = data;
	            $.ajax({
					url: 'assets/php/addTagToUpload.php',//target the correct file
					type: 'POST',//use POST
					data: {//the data array that will be sent to the PHP
						id:uploadID,
						tags:tagArray
					},
					success: function(tagData) {//if successful
						console.log(tagData);
						wipeForm();
						alert("Verkefni móttekið");
					}
				});
	        },
	        cache: false,//don't cache
	        contentType: false,//don't use a specific content type
	        processData: false//don't process the data specially
	    });

	    return false;//don't return anything
	});
	//function sem tæmir formið að öllu leiti sé þess óskað
	function wipeForm () {
		$('#data').reset();
		$('#tagContainer').empty();
		tagArray = [];
	}
</script>
</body>
</html>