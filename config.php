<?php

/* DEFINITIONS -- DO NOT MODIFY */
abstract class UDIDCheckMethod {
	const UseList = 0;
	const UseDatabase = 1;
}
/* == END OF DEFINITIONS */

define("UDID_METHOD", UDIDCheckMethod::UseDatabase);

/* UDID List Method Constants */
define("UDID_LIST", serialize(array(/* insert accepted UDIDs here. */)));

/* UDID Database Method Constants */
define("UDID_DB_HOST", "localhost");
define("UDID_DB_DBNAME", "udid");
define("UDID_DB_USER", "root");
define("UDID_DB_PASSWORD", "password");
define("UDID_DB_UDIDTABLE", "udids");
define("UDID_DB_UDIDCOLUMN", "udid");