<?php
try{

	$source = 'mysql:host=localhost;dbname=IcEd';
	$user = 'IcEd';
	$password = 'J9sK63t6sSSxdEvM';

	# tegund og nafn á server, nafn á db og PHP aðgangur
	$pdo = new PDO($source, $user, $password);

	# stillum hann af hvernig hann með höndlar villur
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	# Við getum notað exec fyrir INSERT; UPDATE og DELETE
	#  notum utf-8 og gerum það með SQL fyrirspurn exec sendir sql fyrirspurnir til database
	$pdo->exec('SET NAMES "utf8"');

}
catch (PDOException $e){

	#skemmtilegri skilaboð til notanda sjá kóða t.d. bls. 99
	echo "tenging tókst ekki". "<br>" . $e->getMessage();

}
?>