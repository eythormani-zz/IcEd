$(function(){
	// cahce some dom
	var $searchIcon = $('#search-icon');
	var $searchinput = $('#search');
	// search icon effect
	$searchIcon.on('click', function(){
		$searchinput.animate({width:'toggle'},350);

	});
	// When you press a button in the search bar
	$searchinput.on('keydown',function(){
		// query the request that someone just entered
		console.log(this.value);
	});
  

});
// this loads the navbar
  	$('#navigation').load('./assets/includes/navbar.html');
function logout(){
	$.ajax({type: "GET",url: "../assets/php/logout.php"});
	window.location.replace("index.php");
};
