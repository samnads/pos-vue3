<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
/*
|--------------------------------------------------------------------------
| Table Names
|--------------------------------------------------------------------------
|
|
*/
defined('TABLE_ADMIN')              or define('TABLE_ADMIN', 'admin');
defined('TABLE_USER')               or define('TABLE_USER', 'user');
defined('TABLE_BARCODE_SYMBOLOGY')  or define('TABLE_BARCODE_SYMBOLOGY', 'symbology');
defined('TABLE_BRAND')              or define('TABLE_BRAND', 'brand');
defined('TABLE_CURRENCY')           or define('TABLE_CURRENCY', 'currency');
defined('TABLE_LABEL_SIZE')         or define('TABLE_LABEL_SIZE', 'label_size');
defined('TABLE_PRODUCT')            or define('TABLE_PRODUCT', 'product');
defined('TABLE_PRODUCT_STOCK')      or define('TABLE_PRODUCT_STOCK', 'product_stock');
defined('TABLE_PRODUCT_TYPE')       or define('TABLE_PRODUCT_TYPE', 'product_type');
defined('TABLE_PRODUCT_GALLERY')    or define('TABLE_PRODUCT_GALLERY', 'product_gallery');
defined('TABLE_CATEGORY')           or define('TABLE_CATEGORY', 'category');
defined('TABLE_SUB_CATEGORY')       or define('TABLE_SUB_CATEGORY', 'sub_category');
defined('TABLE_TAX_RATE')           or define('TABLE_TAX_RATE', 'tax_rate');
defined('TABLE_TAX_GROUP')          or define('TABLE_TAX_GROUP', 'tax_group');
defined('TABLE_TAX_GROUP_RATE')     or define('TABLE_TAX_GROUP_RATE', 'tax_group_rate');
defined('TABLE_UNIT')               or define('TABLE_UNIT', 'unit');
defined('TABLE_UNIT_BULK')          or define('TABLE_UNIT_BULK', 'unit_bulk');
defined('TABLE_CUSTOMER')           or define('TABLE_CUSTOMER', 'customer');
defined('TABLE_CUSTOMER_GROUP')     or define('TABLE_CUSTOMER_GROUP', 'customer_group');
defined('TABLE_WAREHOUSE')          or define('TABLE_WAREHOUSE', 'warehouse');
defined('TABLE_SUPPLIER')           or define('TABLE_SUPPLIER', 'supplier');
defined('TABLE_MODULE')             or define('TABLE_MODULE', 'module');
defined('TABLE_ROLE')               or define('TABLE_ROLE', 'role');
defined('TABLE_PERMISSION')         or define('TABLE_PERMISSION', 'permission');
defined('TABLE_ROLE_PERMISSION')    or define('TABLE_ROLE_PERMISSION', 'role_permission');
defined('TABLE_STOCK_ADJUSTMENT')   or define('TABLE_STOCK_ADJUSTMENT', 'stock_adjustment');
defined('TABLE_STOCK_ADJUSTMENT_PRODUCT')    or define('TABLE_STOCK_ADJUSTMENT_PRODUCT', 'stock_adjustment_product');
