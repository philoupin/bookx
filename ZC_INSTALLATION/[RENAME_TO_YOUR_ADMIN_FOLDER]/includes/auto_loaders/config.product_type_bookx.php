<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package admin
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [admin]/includes/auto_loaders/config.product_type_bookx.php 2016-02-02 philou $
 */


/**
 * This files checks for the $_GET flags "install", "remove" and "update"
 *
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$autoLoadConfig[10][] = array('autoType'=>'class',
		'loadFile'=> 'observers/class.bookx_admin_observers.php',
		'classPath'=>DIR_WS_CLASSES);

$autoLoadConfig[30][] = array('autoType'=>'classInstantiate',
		'className'=>'bookxAdminObserver',
		'objectName'=>'bookxAdminObserver');

if (isset($_GET['action']) &&
	('bookx_remove' == $_GET['action'] ||
	 'bookx_install' == $_GET['action'] ||
	 'bookx_update' == $_GET['action'])) {
	$autoLoadConfig[199][] = array('autoType' => 'init_script',
			'loadFile' => 'init_product_type_bookx.php');

	switch ($_GET['action']) {
		case 'bookx_remove':
			$bookx_install = 'uninstall';
			break;

		case 'bookx_install':
			$bookx_install = 'install';
			break;

		case 'bookx_update':
			$bookx_install = 'update';
			break;
			
		case 'bookx_reset_to_defaults':
		    $bookx_install = 'reset';
		    break;
			    
		default:
			$bookx_install = false;
			break;
	}

}

// uncomment the following line to perform a uninstall
//$bookx_install = 'uninstall';

