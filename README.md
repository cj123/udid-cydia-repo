# UDID Protected Cydia Repository

## Usage

* modify the "Release" settings inside `repo.php`
* choose your method of storing udids:
	for db:    ```php $method = "database"; ```
	for array: ```php $method = "list"; ```
* if you have selected to use the "list" method, please modify the list of udids in `repo.php`
* see .htaccess which plays an important role here.
* create Packages.bz2 as you would with any other repository (see [saurik's post on creating a repository](http://www.saurik.com/id/7))

## Credits

* **@moeseth** - original code
* **@icj_** - updates including database support

Special thanks to http://serverfault.com/questions/166535/creating-a-password-protected-cydia-repository