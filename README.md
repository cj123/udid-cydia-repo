# UDID Protected Cydia Repository

## Usage

1. Clone this repository inside your APT repository's root directory.
2. Edit your information inside `config.php`.
3. Change *your_repo_folder* inside `.htaccess` into your APT repository's root directory.

`Packages`, `Release` and its compressed forms (gzip, bzip2, lzma, lz, xz) will be blocked if the UDID which tries add the repository does not match a database/list entry.

## Config.php Reference

* **UDID\_METHOD**: One of UDIDCheckMethod::UseList and UDIDCheckMethod::UseDatabase.
	* `UseList`: Checks config.php-defined `UDID_LIST` – a serialized array – for accepted UDIDs.
	* `UseDatabase`: Checks a database specified in `UDID_DB_*` for accepted UDIDs.

* **UDID\_LIST**: Serialized PHP array of strings which represent accepted UDIDs.

* **UDID\_DB\_HOST**: Hostname for database.
* **UDID\_DB\_DBNAME**: Database name for database.
* **UDID\_DB\_USER**: User name for database.
* **UDID\_DB\_PASSWORD**: Password for database.
* **UDID\_DB\_UDIDTABLE**: Table name for UDIDs.
* **UDID\_DB\_UDIDCOLUMN**: Column name for UDIDs.

## Return Codes

* In the case of `UDID_LIST` or `UDID_DB_*` misdefinition, a `500 Internal Server Error` header will be returned.

* In case of failure obtaining `Release`/`Packages` files, a `404 Not Found` header will be returned.

* In case of failure on UDID authentication, a `403 Forbidden` header will be returned.

* In case of no UDID sent in the request header, `403 Bad Request` is returned.

* On success, `200 OK` is returned.

## Credits

* **@moeseth** - original code
* **@icj_** - updates including database support
* **theiostream** - most likely something

Special thanks to http://serverfault.com/questions/166535/creating-a-password-protected-cydia-repository
