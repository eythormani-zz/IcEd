<!DOCTYPE html>
<html>
<head>
	<title>Bættu við verkefni</title>
	<meta charset="utf-8">
	<meta name="author" content="Eyþór Máni Steinarsson, Ómar Högni Guðmarsson, Þorgrímur Kári Emilsson">
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
		<form action="assets/php/upload.php" method="post" enctype="multipart/form-data" class="uploadForm">
			<label for="fileToUpload">Veldu rétta skrá:</label>
	 		<input class="form-control uploadFormInput" type="file" name="fileToUpload" id="fileToUpload">
			<label for="name">Skýrðu verkefnið eitthvað fallegt:</label>
		    <input class="form-control uploadFormInput" type="text" name="name" placeholder="Nafn Verkefnis">
			<label for="description">Lýstu verkefninu vel:</label>
		    <textarea class="form-control uploadFormInput" name="description" rows="8" cols="40"></textarea>
		    <input class="form-control uploadFormInput" type="submit" value="Senda inn verkefni">
	 	</form>
		<div id="tagContainer">
			
		</div>
		<label for="tags">Hvaða tög hæfa verkefninu?</label><br>
		<input type="text" placeholder="Bættu við tagi" id="tagMaker">
		<button class="btn" id="confirmTag">Staðfesta tag</button>
	</div>
	<footer>
	 	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	 	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	 	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	 	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	 	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	 	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</footer>
	<!-- Latest compiled and minified JavaScript -->
	<script src="./assets/js/main.js" type="text/javascript" charset="utf-8" async defer></script>
	<script type="text/javascript">
	$("#confirmTag").click(function(){
		var box = $('#tagContainer').val();
		var tag = $('tagMaker').val();
	    var thing = document.createElement("span").
	    var text = document.createTextNode(tag);
	    thing.appendChild(text);
	});
	</script>
</body>
</html>