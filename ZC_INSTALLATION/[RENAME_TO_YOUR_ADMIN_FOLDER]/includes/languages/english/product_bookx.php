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
 * @version $Id: [ZC INSTALLATION]/[ADMIN]includes/languages/english/product_bookx.php 2016-02-02 philou $
 */

define('HEADING_TITLE', 'Categories / Products');
define('HEADING_TITLE_GOTO', 'Go To:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Categories / Products');
define('TABLE_HEADING_CATEGORIES_SORT_ORDER', 'Sort');

define('TABLE_HEADING_PRICE','Price/Special/Sale');
define('TABLE_HEADING_QUANTITY','Quantity');

define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_STATUS', 'Status');

//*** product display status info
define('TEXT_PRODUCT_STATUS_NOT_DISPLAYED_DUE_TO_PRODUCT_STATUS', 'This book is currently <u>not</u> displayed in your shop, since the "product status" is set to "Out of stock".');
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING', 'BookX considers this book as "upcoming" und possibly shows it as "Upcoming Product" (setting <a href="%1$s" target="_blank">here</a>) since the <a href="#publishing_date_field">Publishing Date</a> is less than %2$s days into the future.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_NEW_BUT_UPCOMING_WITHOUT_STOCK', 'BookX considers this book as "upcoming" und possibly shows it as "Upcoming Product" (setting <a href="%1$s" target="_blank">here</a>) even though the <a href="#publishing_date_field">Publishing Date</a> is in the past, since the <a href="#product_quantity_field">Products Quantity</a> is "0". <br /> If this book should be displayed as "new" but temporarily unavailable, then please specifiy a <a href="#date_available_field">Date Available</a> in the future.');
/*** bof obsolete and will be removed */
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING_WITH_DATE_AVAILABLE', 'BookX considers this book an "Upcoming product", since the <a href="#product_quantity_field">Products Quantity</a> is "0" and the <a href="#date_available_field">Date Available</a> is either in the future.');
/*** eof obsoltete */
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING_PREORDER_OPTION', ' This book can be purchased (pre-ordered), since the <a href="#product_quantity_field">Products Quantity</a> is more than "0".');
define('TEXT_PRODUCT_STATUS_NOT_DISPLAYED_SINCE_BEYOND_UPCOMING', 'BookX does not show this book in the shop, since the <a href="#publishing_date_field">publishing date</a> is further than %1$s days into the future. This book will automatically be displayed as "Upcoming product" on: ');
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_NEW', 'BookX considers this book as "New product" since the <a href="#product_quantity_field">Products Quantity</a> is more than "0" and the <a href="#publishing_date_field">Publishing Date</a> is less than %s days in the past.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_OUT_OF_PRINT', 'BookX considers this book as <span class="alert">Out Of Print</span> since the <a href="#product_quantity_field">Products Quantity</a> is "0" and the <a href="#publishing_date_field">Publishing Date"</a> is empty or in the past and no <a href="#date_available_field">Date Available</a> is set.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_TEMPORARILY_UNAVAILABLE', 'BookX considers this book as temporarily unavailable, since the <a href="#product_quantity_field">Products Quantity</a> is "0" but a <a href="#date_available_field">Date Available</a> in the future is set.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_REGULAR_IN_STOCK', 'BookX considers this book to be in stock, since the <a href="#product_quantity_field">Products Quantity</a> is more than "0" and the <a href="#publishing_date_field">Publishing Date"</a> is empty or more than %1$s days in the past.');
define('TEXT_PRODUCT_STATUS_DEFAULT_CASE', 'BookX has trouble determining the product status for this book.');
define('TEXT_ZC_NEW_PRODUCTS_LIMIT_WARNING', 'The Zen Cart feature "%1$s" is in effect and only displays products as "new" which have been created less than %2$s days ago. You can change this setting <a href="%3$s">here</a>.');

define('TEXT_CATEGORIES', 'Categories:');
define('TEXT_SUBCATEGORIES', 'Subcategories:');
define('TEXT_PRODUCTS', 'Products:');
define('TEXT_PRODUCTS_BOOKX_AUTHORS', 'Author(s):');
define('TEXT_PRODUCTS_BOOKX_AUTHOR', 'Author:');
define('TEXT_PRODUCTS_BOOKX_AUTHOR_TYPE', 'Author Type:');
define('TEXT_PRODUCTS_BOOKX_ADD_AUTHOR', 'Add Author');
define('TEXT_PRODUCTS_BOOKX_BINDING', 'Binding:');
define('TEXT_PRODUCTS_BOOKX_CONDITION', 'Condition:');
define('TEXT_PRODUCTS_BOOKX_PAGES', 'No. of Pages:');
define('TEXT_PRODUCTS_BOOKX_PRINTING', 'Printing:');
define('TEXT_PRODUCTS_BOOKX_PUBLISHER', 'Publisher:');
define('TEXT_PRODUCTS_BOOKX_PUBLISHING_DATE', 'Publishing Date:');
define('TEXT_PRODUCTS_BOOKX_USE_PARTIAL_PUBLISHING_DATE', '(Use "00" for month or day, if exact month or day are unknown, e.g. "2012-03-00" for "March 2012")');
define('TEXT_PRODUCTS_BOOKX_IMPRINT', 'Imprint:');
define('TEXT_PRODUCTS_BOOKX_GENRES', 'Genre(s):');
define('TEXT_PRODUCTS_BOOKX_ADD_GENRE', 'Assign additional Genre');
define('TEXT_PRODUCTS_BOOKX_SERIES', 'Series:');
define('TEXT_PRODUCTS_BOOKX_SIZE', 'Size:');
define('TEXT_PRODUCTS_BOOKX_SUBTITLE', 'Subtitle:');
define('TEXT_PRODUCTS_BOOKX_VOLUME', 'Volume No.:');
define('TEXT_PRODUCTS_BOOKX_ISBN', 'ISBN: <small>(without dashes)</small>');
define('TEXT_PRODUCTS_BOOKX_ISBN_DISPLAY', 'Displayed in shop as: ');
define('TEXT_JAVASCRIPT_ISBN_WRONG_CHECKDIGIT', 'The entered ISBN "%1$s" does not match with the entered check digit.\n The correct check digit is: "%2$s"');
define('TEXT_PRODUCTS_BOOKX_INFO_PUBLISHING_DATE_INFLUENCES_NEW_PRODUCT_DISPLAY', '[Info: If publishing date is less than %1$s days ago, this book will be shown as "new product" on home page. %2$s. If publishing date is in the future <u>and stock is "0"</u>, this book will be shown as upcoming product.]');
define('TEXT_PRODUCTS_BOOKX_NEW_PRODUCTS_LOOK_BACKWARD_SETTING_LINK', 'Change setting');
define('TEXT_PRODUCTS_PRICE_INFO', 'Price:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Tax Class:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Average Rating:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Quantity:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_DATE_AVAILABLE', 'Date Available:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Please insert a new category or product in this level.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'For more information, please visit this products <a href="http://%s" target="blank">webpage</a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'This product was added to our catalog on %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'This product will be in stock on %s.');

define('TEXT_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_EDIT_CATEGORIES_ID', 'Category ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Category Name:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Category Image:');
define('TEXT_EDIT_SORT_ORDER', 'Sort Order:');

define('TEXT_INFO_COPY_TO_INTRO', 'Please choose a new category you wish to copy this product to');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Current Categories: ');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'New Category');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edit Category');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Delete Category');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Move Category');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Delete Product');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Move Product');
define('TEXT_INFO_HEADING_COPY_TO', 'Copy To');

define('TEXT_DELETE_CATEGORY_INTRO', 'Are you sure you want to delete this category?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Are you sure you want to permanently delete this product?<br /><br /><strong>Warning:</strong> On Linked Products<br />1 Make sure the Master Category has been changed if you are deleting the Product from the Master Category<br />2 Check the checkbox for the Category to Delete the Product from');

define('TEXT_DELETE_WARNING_CHILDS', '<b>WARNING:</b> There are %s (child-)categories still linked to this category!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNING:</b> There are %s products still linked to this category!');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Please select which category you wish <b>%s</b> to reside in');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Please select which category you wish <b>%s</b> to reside in');
define('TEXT_MOVE', 'Move <b>%s</b> to:');

define('TEXT_NEW_CATEGORY_INTRO', 'Please fill out the following information for the new category');
define('TEXT_CATEGORIES_NAME', 'Category Name:');
define('TEXT_CATEGORIES_IMAGE', 'Category Image:');
define('TEXT_SORT_ORDER', 'Sort Order:');

define('TEXT_PRODUCTS_STATUS', 'Products Status:');
define('TEXT_PRODUCTS_VIRTUAL', 'Product is Virtual:');
define('TEXT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', 'Always Free Shipping:');
define('TEXT_PRODUCTS_QTY_BOX_STATUS', 'Products Quantity Box Shows:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Date Available:');
define('TEXT_PRODUCT_AVAILABLE', 'In Stock');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Out of Stock');
define('TEXT_PRODUCT_IS_VIRTUAL', 'Yes, Skip Shipping Address');
define('TEXT_PRODUCT_NOT_VIRTUAL', 'No, Shipping Address Required');
define('TEXT_PRODUCT_IS_ALWAYS_FREE_SHIPPING', 'Yes, Always Free Shipping');
define('TEXT_PRODUCT_NOT_ALWAYS_FREE_SHIPPING', 'No, Normal Shipping Rules');
define('TEXT_PRODUCT_SPECIAL_ALWAYS_FREE_SHIPPING', 'Special, Product/Download Combo Requires a Shipping Address');
define('TEXT_PRODUCTS_SORT_ORDER', 'Sort Order:');

define('TEXT_PRODUCTS_QTY_BOX_STATUS_ON', 'Yes, Show Quantity Box');
define('TEXT_PRODUCTS_QTY_BOX_STATUS_OFF', 'No, Do not show Quantity Box');

define('TEXT_PRODUCTS_MANUFACTURER', 'Products Manufacturer:');
define('TEXT_PRODUCTS_NAME', 'Products Name:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Products Description:');
define('TEXT_PRODUCTS_QUANTITY', 'Products Quantity:');
define('TEXT_PRODUCTS_MODEL', 'Products Model:');
define('TEXT_PRODUCTS_IMAGE', 'Products Image:');
define('TEXT_PRODUCTS_IMAGE_DIR', 'Upload to directory:');
define('TEXT_PRODUCTS_URL', 'Products URL:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(without http://)</small>');
define('TEXT_PRODUCTS_PRICE_NET', 'Products Price (Net):');
define('TEXT_PRODUCTS_PRICE_GROSS', 'Products Price (Gross):');
define('TEXT_PRODUCTS_WEIGHT', 'Products Shipping Weight:');

define('EMPTY_CATEGORY', 'Empty Category');

define('TEXT_HOW_TO_COPY', 'Copy Method:');
define('TEXT_COPY_AS_LINK', 'Link product');
define('TEXT_COPY_AS_DUPLICATE', 'Duplicate product');

// Products and Attribute Copy Options
  define('TEXT_COPY_ATTRIBUTES_ONLY','Only used for Duplicate Products ...');
  define('TEXT_COPY_ATTRIBUTES','Copy Product Attributes to Duplicate?');
  define('TEXT_COPY_ATTRIBUTES_YES','Yes');
  define('TEXT_COPY_ATTRIBUTES_NO','No');
  define('TEXT_COPY_MEDIA_MANAGER','Copy any Media Manager collections associated with this product.');

  define('TEXT_INFO_CURRENT_PRODUCT', 'Current Product: ');
  define('TABLE_HEADING_MODEL', 'Model');

  define('TEXT_INFO_HEADING_ATTRIBUTE_FEATURES','Attributes Changes for Products ID# ');
  define('TEXT_INFO_ATTRIBUTES_FEATURES_DELETE','Delete <strong>ALL</strong> Product Attributes for:<br />');
  define('TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO','Copy Attributes to another Product or to an entire Category from:<br />');

  define('TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_PRODUCT','Copy Attributes to another <strong>product</strong> from:<br />');
  define('TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_CATEGORY','Copy Attributes to another <strong>category</strong> from:<br />');

  define('TEXT_COPY_ATTRIBUTES_CONDITIONS','<strong>How should existing product attributes be handled?</strong>');
  define('TEXT_COPY_ATTRIBUTES_DELETE','<strong>Delete</strong> first, then copy new attributes');
  define('TEXT_COPY_ATTRIBUTES_UPDATE','<strong>Update</strong> with new settings/prices, then add new ones');
  define('TEXT_COPY_ATTRIBUTES_IGNORE','<strong>Ignore</strong> and add only new attributes');

  define('SUCCESS_ATTRIBUTES_DELETED','Attributes successfully deleted');
  define('SUCCESS_ATTRIBUTES_UPDATE','Attributes successfully updated');

  define('ICON_ATTRIBUTES','Attribute Features');

  define('TEXT_CATEGORIES_IMAGE_DIR','Upload to directory:');

  define('TEXT_PRODUCTS_QTY_BOX_STATUS_PREVIEW','Warning: Does not show Quantity Box, Default to Qty 1');
  define('TEXT_PRODUCTS_QTY_BOX_STATUS_EDIT','Warning: Does not show Quantity Box, Default to Qty 1');

  define('TEXT_PRODUCT_OPTIONS', '<strong>Please Choose:</strong>');
  define('TEXT_PRODUCTS_ATTRIBUTES_INFO','Attribute Features For:');
  define('TEXT_PRODUCT_ATTRIBUTES_DOWNLOADS','Downloads: ');

  define('TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES','Product Priced by Attributes:');
  define('TEXT_PRODUCT_IS_PRICED_BY_ATTRIBUTE','Yes');
  define('TEXT_PRODUCT_NOT_PRICED_BY_ATTRIBUTE','No');
  define('TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_PREVIEW','*Display price will include lowest group attributes prices plus price');
  define('TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_EDIT','*Display price will include lowest group attributes prices plus price');

  define('TEXT_PRODUCTS_QUANTITY_MIN_RETAIL','Product Qty Minimum:');
  define('TEXT_PRODUCTS_QUANTITY_UNITS_RETAIL','Product Qty Units:');
  define('TEXT_PRODUCTS_QUANTITY_MAX_RETAIL','Product Qty Maximum:');

  define('TEXT_PRODUCTS_QUANTITY_MAX_RETAIL_EDIT','0 = Unlimited, 1 = No Qty Boxes');

  define('TEXT_PRODUCTS_MIXED','Product Qty Min/Unit Mix:');

  define('PRODUCTS_PRICE_IS_FREE_TEXT', 'Product is Free');
  define('TEXT_PRODUCT_IS_FREE','Product is Free:');
  define('TEXT_PRODUCTS_IS_FREE_PREVIEW','*Product is marked as FREE');
  define('TEXT_PRODUCTS_IS_FREE_EDIT','*Product is marked as FREE');

  define('TEXT_PRODUCT_IS_CALL','Product is Call for Price:');
  define('TEXT_PRODUCTS_IS_CALL_PREVIEW','*Product is marked as CALL FOR PRICE');
  define('TEXT_PRODUCTS_IS_CALL_EDIT','*Product is marked as CALL FOR PRICE');

  define('TEXT_ATTRIBUTE_COPY_SKIPPING','<strong>Skipping New Attribute </strong>');
  define('TEXT_ATTRIBUTE_COPY_INSERTING','<strong>Inserting New Attribute from </strong>');
  define('TEXT_ATTRIBUTE_COPY_UPDATING','<strong>Updating from Attribute </strong>');

// meta tags
  define('TEXT_META_TAG_TITLE_INCLUDES','<strong>Mark What the Product\'s Meta Tag Title Should Include:</strong>');
  define('TEXT_PRODUCTS_METATAGS_PRODUCTS_NAME_STATUS','<strong>Product Name:</strong>');
  define('TEXT_PRODUCTS_METATAGS_TITLE_STATUS','<strong>Title:</strong>');
  define('TEXT_PRODUCTS_METATAGS_MODEL_STATUS','<strong>Model:</strong>');
  define('TEXT_PRODUCTS_METATAGS_PRICE_STATUS','<strong>Price:</strong>');
  define('TEXT_PRODUCTS_METATAGS_TITLE_TAGLINE_STATUS','<strong>Title/Tagline:</strong>');
  define('TEXT_META_TAGS_TITLE','<strong>Meta Tag Title:</strong>');
  define('TEXT_META_TAGS_KEYWORDS','<strong>Meta Tag Keywords:</strong>');
  define('TEXT_META_TAGS_DESCRIPTION','<strong>Meta Tag Description:</strong>');
  define('TEXT_META_EXCLUDED', '<span class="alert">EXCLUDED</span>');
