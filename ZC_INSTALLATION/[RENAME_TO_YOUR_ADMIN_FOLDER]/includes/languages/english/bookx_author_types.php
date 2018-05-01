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
 * @version $Id: [admin]/includes/languages/english/bookx_author_types.php 2016-02-02 philou $
 */


define('HEADING_TITLE', 'Author type');
define('TABLE_HEADING_AUTHOR_TYPE', 'Author type');
define('TABLE_HEADING_SORT_ORDER', 'Sort Order');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_NEW_INTRO', 'Please provide information below for the new author type.');
define('TEXT_EDIT_INTRO', 'Please edit below the information for the author type.');
define('TEXT_DELETE_INTRO', 'Are you sure you want to delete the author type „%1$s”? The entry for the author type „%1$s” will be removed from all books which it is assigned to');
define('TEXT_DELETE_IMAGE', 'Delete image(s)?');
define('TEXT_AUTHOR_TYPE_DESCRIPTION', 'Description of author type (e.g. "writer", "illustrator", "photographer"');
define('TEXT_AUTHOR_TYPE_IMAGE', 'Image for author type');
define('TEXT_AUTHOR_TYPE_SORT_ORDER', 'Sort order');
define('TEXT_AUTHOR_TYPE_SORT_ORDER_INFLUENCES_DISPLAY', '<strong>Attention:</strong> Author Types with a sort order of "%1$s" or greater, will not be displayed in the product <u>list</u>. Edit this value in the <a href="%2$s">layout settings for product type "BookX"</a>.');
define('TEXT_AUTHOR_TYPE_IMAGE_NOT_DEFINED', '[No image available for author type]');
define('TEXT_AUTHOR_TYPE_IMAGE_DIR', 'Images directory ');
define('TEXT_AUTHOR_TYPE_IMAGE_MANUAL', '<strong>Or choose an existing image from the server. Filename:</strong>');
define('TEXT_HEADING_NEW_AUTHOR_TYPE', 'New author type');
define('TEXT_HEADING_EDIT_AUTHOR_TYPE', 'Edit author type');
define('TEXT_HEADING_DELETE_AUTHOR_TYPE', 'Delete author type');
define('TEXT_DATE_ADDED', 'Created on');
define('TEXT_LAST_MODIFIED', 'Last changed');
define('TEXT_IMAGE_NONEXISTENT', "Image doesn't exist");
define('TEXT_PRODUCTS', 'Linked books');
define('TEXT_DISPLAY_NUMBER_OF_AUTHOR_TYPES', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> author types)');

define('TEXT_SETNULL_AUTHORTYPE_AUTHORS', 'Remove all <u>authors</u> of type „%1$s” from linked books? If you check this option, all <u>authors</u> of author <u>type</u> „%1$s” will be removed from books they are assigned to. The authors themselves will not be deleted and remain in the database.');

define('TEXT_DELETE_AUTHORTYPE_PRODUCTS', 'Delete all books linked to author type „%1$s”? If you check this option, all books with an assigned authr type „%1$s” will be deleted. The authors themselves will not be deleted and remain in the database.');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ATTENTION:</b> There are still „%1$s” books associated with „%2$s”! This association will be removed, the book will <u>not</u> be deleted.');
