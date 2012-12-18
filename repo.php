<?php

require_once("./config.php");

$protocol = $_SERVER["SERVER_PROTOCOL"];
function lolerror($exit) {
	global $protocol;
	header(sprintf("%s %s", $protocol, $exit));
}

function checkUDID($udid) {
	switch (UDID_METHOD) {
		case UDIDCheckMethod::UseList:
			if (!($list = unserialize(UDID_LIST))) {
				lolerror("500 Internal Server Error");
				exit(1);
			}
			return in_array($udid, $list);

		case UDIDCheckMethod::UseDatabase:
			// udids from database
			// connect to pdo
			$dbh = new PDO(sprintf('mysql: host=%s; dbname=%s', UDID_DB_HOST, UDID_DB_DBNAME), UDID_DB_USER, UDID_DB_PASSWORD);
			$stmt = $dbh->prepare(sprintf("SELECT * FROM %s WHERE (%s) = (?);", UDID_DB_UDIDTABLE, UDID_DB_UDIDCOLUMN));
			if (!$stmt->execute(array($udid))) {
				lolerror("500 Internal Server Error");
				exit(1);
			}
			
			return (boolean)$stmt->fetch(PDO::FETCH_ASSOC);
		
		default:
	}
}

$udid = $_SERVER["HTTP_X_UNIQUE_ID"];
if (!$udid) { lolerror("403 Bad Request"); return; }

$request = $_GET["request"];
if (!file_exists($request)) { lolerror("404 Not Found"); return; }

if (checkUDID($udid)) {
	$extension = pathinfo($request, PATHINFO_EXTENSION);
	if ($extension) {
		$mimemap = array(
			"bz2" => "application/bzip2",
			"gz" => "application/x-gzip",
			"xz" => "application/x-xz",
			"lzma" => "application/x-lzma",
			"lz" => "application/x-lzip");
		
		header(sprintf("Content-Type: %s", $mimemap[$extension]));
		header(sprintf("Content-Disposition: attachment; filename=\"%s\"", $request));
	}
	
	echo readfile($request);
}
else { lolerror("403 Forbidden"); }

?>