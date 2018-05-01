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
 * @version $Id: [admin]/includes/languages/english/extra_definitions/product_bookx.php 2016-02-02 philou $
 */

// Date format when only month and year are used for "publishing date
define('DATE_FORMAT_MONTH_AND_YEAR', '%M %Y');

// Extra Popup Texts for Product type layout settings
define('BOOKX_LAYOUT_SETTINGS_ENABLED', 'Yes');
define('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY', 'Yes, except when empty');
define('BOOKX_LAYOUT_SETTINGS_DISABLED', 'No');

define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME', 'Name'); // value = 1
define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER', 'Sort Order'); // value = 2
define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_NAME', 'Type Name)'); // value = 3
define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_SORT_ORDER', 'Type Sort Order'); // value = 4

// Admin EXTRA menu items for product type bookx
define('BOX_CATALOG_PRODUCT_BOOKX_AUTHORS', 'BookX: Authors');
define('BOX_CATALOG_PRODUCT_BOOKX_AUTHOR_TYPES', 'BookX: Author Types');
define('BOX_CATALOG_PRODUCT_BOOKX_BINDING', 'BookX: Bindings / Cover');
define('BOX_CATALOG_PRODUCT_BOOKX_CONDITIONS', 'BookX: Book Condition');
define('BOX_CATALOG_PRODUCT_BOOKX_GENRES', 'BookX: Genres');
define('BOX_CATALOG_PRODUCT_BOOKX_IMPRINTS', 'BookX: Publisher Imprints/Labels');
define('BOX_CATALOG_PRODUCT_BOOKX_PRINTING', 'BookX: Printing Type');
define('BOX_CATALOG_PRODUCT_BOOKX_PUBLISHERS', 'BookX: Publishers');
define('BOX_CATALOG_PRODUCT_BOOKX_SERIES', 'BookX: Series');

// Admin CATALOG menu item for product type bookx
define('BOX_CATALOG_PRODUCT_BOOKX', 'BookX Products Editing');

// Admin TOOLS menu item for product type bookx
define('TOOLS_MENU_PRODUCT_BOOKX', 'BookX: Installation & Tools');

// Category listing items for product type bookx
define('LABEL_BOOKX_ISBN', 'ISBN: ');
define('LABEL_BOOKX_VOLUME', 'Volume %s');

// Admin CONFIG menu item for product type bookx
define('CONFIG_MENU_PRODUCT_BOOKX', 'BookX: Configuration');

define('HEADING_TITLE_BOOKX', 'BookX Tools');
define('TEXT_BOOKX_STATUS_INSTALLED', 'BookX is currently <strong>installed</strong>.');
define('TEXT_BOOKX_STATUS_NOT_INSTALLED', 'BookX is currently <strong>not</strong> installed.');

define('BOOKX_LINK_INSTALL', 'Install BookX. (Please make a database backup before you proceed!)');
define('BOOKX_LINK_UPDATE', 'Update BookX to new version. (Please make a database backup before you proceed!)');
define('BOOKX_LINK_REMOVE', 'Remove BookX from the Database. (Please make a database backup before you proceed!) All BookX products as well as authors, genres, publishers etc. will be deleted!');
define('BOOKX_LINK_RESET', 'Reset BookX settngs to defaults. Missing configuration entries will be fixed. <STRONG>No products will be altered or deleted!</strong> (Please make a database backup before you proceed!)');


define('TEXT_CONVERT_BOOKX_PRODUCTS', 'Convert all products of type "BookX" to products of type "General" and remove all product attributes which are specific to product type "BookX".');
define('TEXT_DELETE_BOOKX_PRODUCTS', 'Completely delete all products of type "BookX" from database.');

define('BOOKX_CONFIRM_REMOVE', 'Are you sure?');

define('BOOKX_LINK_MANAGE_PRODUCT_MIGRATION', 'Convert existing products to product type "Book X" or from type "BookX" to another product type. (Selection on next screen)');

define('BOOKX_OPTION_IMPORT', '<strong>Option 1: Convert existing products to product type "BookX":</strong>');
define('BOOKX_SELECT_PRODUCT_TYPE_SOURCE_FOR_MIGRATION', 'Select product type from which to convert to product type "BookX":');

define('BOOKX_OPTION_EXPORT', '<strong>Option 2: Convert existing products of type "BookX" to another product type </strong>(e.g. back to "General"):');
define('BOOKX_SELECT_PRODUCT_TYPE_DESTINATION_FOR_MIGRATION', 'Select product type to which to convert products of type "BookX". (All fields specific to product type "BookX" will be removed from product):');

define('BOOKX_OPTION_CONVERT_ALL_PRODUCTS', 'Convert all products of this type');
define('BOOKX_OPTION_SELECT_PRODUCTS_TO_CONVERT', 'Select which products of this type to convert');

// message stack messages

define('BOOKX_MS_ALL_EXIST','BookX files all exist in correct positions in the directory structure.');
define('BOOKX_MS_ABORTED','********** Installation has been cancelled. **********');
define('BOOKX_MS_SOME_REQUIRED_FILES_MISSING','Some BookX files do not exist or cannot be read. Perhaps you have uploaded them incorrectly? Or the permissions are set incorrectly?');
define('BOOKX_MS_FILE_SHOULD_ONLY_BE_OVERRIDE','This BookX file should only exist in the folder "template_default" , <u>except</u> if overrides have been made for this ZC shop. When updating the BookX plugin these overrides must be merged into a new copy of the file from folder "template_default":');
define('BOOKX_MS_SOME_LANGUAGE_FILES_MISSING',"The following BookX language files for language '%s' are missing or can't be read. Perhaps you have uploaded them incorrectly? Or the permissions are set incorrectly? If you are not using the language '%s' in your shop, then these language files are not needed and you can ignore this warning message.");
define('BOOKX_MS_VERSION_ALREADY_UP_TO_DATE','BookX version %s is already installed. Update was cancelled.');
define('BOOKX_MS_DB_UPDATE_SUCCESS','BookX updated sucessfully.');
define('BOOKX_MS_TEMPLATE_NOTFOUND','BookX is having some problems finding your current template.');
define('BOOKX_MS_MISSING_OR_UNREADABLE','Missing or unreadable file:');
define('BOOKX_MS_OVERWRITTEN','was overwritten. A back up copy was saved.');
define('BOOKX_MS_NOT_OVERWRITTEN','was NOT overwritten.');
define('BOOKX_MS_CREATED','was created. A back up copy of any overwritten file was saved.');
define('BOOKX_MS_NOT_CREATED','was NOT created.');
define('BOOKX_MS_DB_TABLES_SUCCESS','All BookX database tables have been installed.');
define('BOOKX_MS_SUCCESS','BookX has been successfully installed');
define('BOOKX_MS_RESET_SUCCESS','BookX settings have been successfully reset.');
define('BOOKX_MS_ROLLBACK_OK','was returned to default version.');
define('BOOKX_MS_ROLLBACK_NOT_OK','was NOT rolled back.');
define('BOOKX_MS_UNINSTALL_OK','BookX has been uninstalled.');
define('BOOKX_MS_TABLE_DOESNT_EXIST','Table %s not found in database. (If you are running an "english-only" shop and this error mentions "*_LANGUAGE" tables, that is okay.');

define('BOOKX_MS_BACKUP_INFO','BookX creates back up versions of certain files when it is installed before overwriting them. These files have been left in position for reference. They may be deleted but will not effect the functioning of the shop if you leave them in place.');

define('BOOKX_MS_AUTOLOADER_NOTDELETED','The auto-loader YOURADMIN/includes/auto_loaders/config.product_type_bookx.php has NOT been deleted. For BookX to work you must delete this file manually.');
define('BOOKX_MS_MODULE_ALREADY_INSTALLED','Product-type BookX is already installed. You have to first de-install it before it can be reinstalled.');

define('BOOKX_MS_PRODUCT_TYPE_BOOKX_MISSING','There is no product type "BookX" defined in this shop. Please install BookX.');
define('BOOKX_MS_CONFIG_TYPE_BOOKX_MISSING','There is no configuration type "BookX" defined in this shop. Please install BookX.');

define('BOOKX_MS_PRODUCT_LAYOUT_CONFIGS_NOT_INSTALLED','The layout configuration settings for Bookx could not be installed in the database.');
define('BOOKX_MS_ADMIN_CONFIG_MENU_NOT_INSTALLED','Product Type BookX: Menu entry in menu "Configuration" could not be installed in the database.');
