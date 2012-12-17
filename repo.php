<?php

function checkUDID($udid, $method) {
	switch($method) {
		default:
		case "list":
			// list of udids, comma separated
			$acceptedUDID = array('udid1', 'udid2');
			if (in_array($udid, $acceptedUDID))
				return true;
			else
				return false;
		break;

		case "database":
			// udids from database
			// connect to pdo
			$dbh = new PDO('mysql: host=localhost; dbname=ios', 'root', 'password');
			
			$stmt = $dbh->prepare("SELECT * FROM udids WHERE (udid) = (?);");
			
			$stmt->execute(array($udid));
			$result_count = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($result_count) == 1)
				return true;
			else
				return false;
		break;
	}
}

$udid = $_SERVER["HTTP_X_UNIQUE_ID"];
$file = $_GET["request"];

// choose your method!
$method = "database";

if(checkUDID($udid, $method)) {
	if($file == "release") {

		// Release File
		// see http://www.saurik.com/id/7 for more info
		echo "Origin: UUID Restricted Repo" . "\n";
		echo "Label: Cydia Example" . "\n";
		echo "Suite: stable" . "\n";
		echo "Version: 0.1" . "\n";
		echo "Codename: tangelo" . "\n";
		echo "Architectures: iphoneos-arm" . "\n";
		echo "Components: main" . "\n";
		echo "Description: An Example UUID Restricted Repository" . "\n";

	} elseif($file == "packages") {

		// place the Packages.bz2 file in the same directory as this
		$filename = "Packages.bz2";

		// serve Packages.bz2 if auth'd
		header("Content-Type: application/bzip2");
		header('Content-Disposition: attachment; filename="Packages.bz2"');
		echo readfile($filename);

	} else {
		header("Status: 403 Bad Request");
	}
} else {
	// not found
	header("Status: 404 Not Found");
}