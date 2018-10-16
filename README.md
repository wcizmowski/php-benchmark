# php-benchmark

PHP Script benchmark (PHP and MySQL-Server)

 inspired by / thanks to:
 - www.php-benchmark-script.com  (Alessandro Torrisi)
 - www.webdesign-informatik.de

 - @author Witold Ciżmowski
 - @license MIT

 usage:
 * first copy config.sample.inc.php into config.inc.php
 * php php-benchmark.php [option]
 * --db   with Database test
 * --help this help

 tests (with composer update first):
 
 ```vendor/phing/phing/bin/phing -f build/build.xml```

 test simple (test only without composer update):
 
 ```vendor/phing/phing/bin/phing -f build/build.simple.xml```
