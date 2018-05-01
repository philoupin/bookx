<?php
/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package languageDefines
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/languages/english/product_bookx_info.php 2016-02-02 philou $
 */


define('TEXT_PRODUCT_NOT_FOUND', 'Sorry, the product was not found');
define('TEXT_CURRENT_REVIEWS', 'Current Reviews:');
define('TEXT_MORE_INFORMATION', 'For more information, please visit this product\'s <a href="%s" target="_blank">webpage</a>.');
define('TEXT_DATE_ADDED', 'This book was added to our catalog on %s.');
define('TEXT_DATE_AVAILABLE', 'This product will be in stock on %s.');
define('TEXT_ALSO_PURCHASED_PRODUCTS', 'Customers who bought this book also purchased...');
define('TEXT_PRODUCT_OPTIONS', 'Please Choose:');
define('TEXT_PRODUCT_WEIGHT', 'Shipping Weight: ');
define('TEXT_PRODUCT_QUANTITY', ' Units in Stock');
define('TEXT_PRODUCT_MODEL', 'Model: ');
define('TEXT_PRODUCT_ISBN', 'ISBN: ');
define('TEXT_PRODUCT_COLLECTIONS', 'Media Collection: ');


// boox specific data

define('LABEL_PUBLISHER', 'Publisher: ');
define('LABEL_PUBLISHER_DESCRIPTION', 'About the publisher: ');
define('TEXT_PUBLISHER_URL', 'For more information, please visit the publisher\'s <a href="%s" target="_blank">webpage</a>.');

define('LABEL_IMPRINT', 'Sublabel / Imprint: ');
define('LABEL_IMPRINT_DESCRIPTION', 'About the sublabel / imprint: ');

define('LABEL_SERIES', 'Series: ');
define('LABEL_SERIES_DESCRIPTION', 'About the series: ');

define('LABEL_AUTHORS', 'Authors:');
define('LABEL_AUTHOR', 'Author:');
define('LABEL_AUTHOR_DESCRIPTION', 'About %s: ');
define('TEXT_AUTHOR_URL', 'For more information, please visit the author\'s <a href="%s" target="_blank">webpage</a>.');
define('HEADING_AUTHOR_RELATED_PRODUCTS', 'Other books by <span class="author">%s</span>:');
define('TEXT_AUTHOR_TEAM_AND', 'and');

define('BOOKX_PRODUCT_STATUS_IN_STOCK', '');
define('BOOKX_PRODUCT_STATUS_OUT_OF_PRINT', '(out of print)');
define('BOOKX_PRODUCT_STATUS_UPCOMING_PRODUCT', '(soon to be released)');
define('BOOKX_PRODUCT_STATUS_NEW_PRODUCT', 'New!');


// previous next product
define('PREV_NEXT_PRODUCT', 'Book ');
define('PREV_NEXT_UPCOMING_PRODUCT', 'Upcoming book');
define('PREV_NEXT_NEW_PRODUCT', 'New book');
define('PREV_NEXT_FROM', ' of ');
define('IMAGE_BUTTON_PREVIOUS','previous book');
define('IMAGE_BUTTON_NEXT','next book');
define('IMAGE_BUTTON_RETURN_TO_PRODUCT_LIST','Back to Book list');

// missing products
//define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

define('TEXT_ATTRIBUTES_PRICE_WAS',' [was: ');
define('TEXT_ATTRIBUTE_IS_FREE',' now is: Free]');
define('TEXT_ONETIME_CHARGE_SYMBOL', ' *');
define('TEXT_ONETIME_CHARGE_DESCRIPTION', ' One time charges may apply');
define('TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK','Quantity Discounts Available');
define('ATTRIBUTES_QTY_PRICE_SYMBOL', zen_image(DIR_WS_TEMPLATE_ICONS . 'icon_status_green.gif', TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK, 10, 10) . '&nbsp;');
define('ATTRIBUTES_PRICE_DELIMITER_PREFIX', ' ( ' );
define('ATTRIBUTES_PRICE_DELIMITER_SUFFIX', ' )' );
define('ATTRIBUTES_WEIGHT_DELIMITER_PREFIX', ' (' );
define('ATTRIBUTES_WEIGHT_DELIMITER_SUFFIX', ') ' );
