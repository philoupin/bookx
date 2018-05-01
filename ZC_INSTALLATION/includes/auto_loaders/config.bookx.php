<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package initSystem
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/auto_loaders/config.bookx.php 2016-02-02 philou $
 */

/**
 * autoloader array for bookx
 * Registers the file [ZC INSTALLATION]/includes/classes/observers/class.bookx_observers.php
 * so it can listen to notifier hooks
 * 
 * see  {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
  */
if (!defined('IS_ADMIN_FLAG')) {
 die('Illegal Access');
}
	$autoLoadConfig[10][] = array('autoType'=>'class',
			'loadFile'=>'observers/class.bookx_observers.php');
	
	$autoLoadConfig[90][] = array('autoType'=>'classInstantiate',
			'className'=>'productTypeFilterObserver',
			'objectName'=>'productTypeFilterObserver');