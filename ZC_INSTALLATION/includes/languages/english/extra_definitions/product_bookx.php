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
 * @version $Id: [ZC INSTALLATION]/includes/languages/english/extra_definitions/product_bookx.php 2016-02-02 philou $
 */
// Date format when only month and year are used for "publishing date
define('DATE_FORMAT_MONTH_AND_YEAR', '%M %Y');

define('BOX_HEADING_BOOKX_FILTERS', 'Book Filters');
define('PULL_DOWN_BOOKX_RESET', '- Reset to default -');
define('BOOKX_GENRE_SEPARATOR', ' | ');

define('BOOKX_BREADCRUMB_LABEL_SEARCHTERM', 'Search for');

//*** extra texts for new and upcoming products
define('TABLE_HEADING_BOOKX_DATE_PUBLISHED', 'Publishing date');
define('TABLE_HEADING_BOOKX_UPCOMING_IMAGE', 'Image');
define('TABLE_HEADING_BOOKX_UPCOMING_DESCRIPTION', 'Description');
define('TEXT_BOOKX_WRAPPER_PUBLISHING_DATE', 'To be published %s.');
define('TEXT_BOOKX_MORE_PRODUCT_INFO', ' more');


//*** These may appear on product_listing page
define('LABEL_BOOKX_CONDITION', 'Condition');
define('LABEL_BOOKX_GENRE', 'Genre');
define('LABEL_BOOKX_PAGES', '%s pages');
define('LABEL_BOOKX_VOLUME', 'vol. %s');
define('LABEL_BOOKX_ISBN', 'ISBN');
define('LABEL_BOOKX_AUTHOR', 'Author');
define('LABEL_BOOKX_AUTHORS', 'Authors');
define('LABEL_BOOKX_MODEL', 'Model No.');
define('LABEL_BOOKX_PUBLISHING_DATE', 'Date of publication: ');


//*** These Labels are used for Breadcrumbs
define('FILTER_LABEL_BOOKX_PUBLISHER_ID', 'Publisher: ');
define('FILTER_LABEL_BOOKX_AUTHOR_ID', 'Author: ');
define('FILTER_LABEL_BOOKX_AUTHOR_TYPE_ID', 'Author Type: ');
define('FILTER_LABEL_BOOKX_IMPRINT_ID', 'Imprint: ');
define('FILTER_LABEL_BOOKX_SERIES_ID', 'Series: ');
define('FILTER_LABEL_BOOKX_GENRE_ID', 'Genre: ');
define('FILTER_LABEL_BOOKX_PRINTING_ID', 'Printing: ');
define('FILTER_LABEL_BOOKX_CONDITION_ID', 'Condition:');
define('FILTER_LABEL_BOOKX_BINDING_ID', 'Binding: ');
define('FILTER_LABEL_BOOKX_UPCOMING', 'Upcoming');
define('FILTER_LABEL_BOOKX_NEW', 'New');

// Labels for filter Sidebox Popups
define('LABEL_FILTER_AUTHOR', 'Show Author:');
define('LABEL_FILTER_AUTHOR_TYPES', 'Show Author only of type:');
define('LABEL_FILTER_GENRE', 'Show Genre:');
define('LABEL_FILTER_IMPRINT', 'Show Label:');
define('LABEL_FILTER_PUBLISHER', 'Show Publisher:');
define('LABEL_FILTER_SERIES', 'Show Series:');
define('LABEL_LIST_ALL_AUTHORS', '--> Show list of all Authors');
define('LABEL_LIST_ALL_AUTHOR_TYPES', '--> Show list of all Author Types');
define('LABEL_LIST_ALL_GENRES', '--> Show list of all Genres');
define('LABEL_LIST_ALL_IMPRINTS', '--> Show list of all Imprints');
define('LABEL_LIST_ALL_PUBLISHERS', '--> Show list of all Publishers');
define('LABEL_LIST_ALL_SERIES', '--> Show list of all Series');
define('BOOKX_LINK_TEXT_RESET_ALL_FILTERS', 'Reset all filters');
define('PULL_DOWN_TEXT_NO_AUTHORS_TO_DISPLAY', '- No authors to choose from -');
define('PULL_DOWN_TEXT_NO_AUTHOR_TYPES_TO_DISPLAY', '- No author types to choose from -');
define('PULL_DOWN_TEXT_NO_PUBLISHERS_TO_DISPLAY', '- No publishers to choose from -');
define('PULL_DOWN_TEXT_NO_IMPRINTS_TO_DISPLAY', '- No imprints to choose from -');
define('PULL_DOWN_TEXT_NO_SERIES_TO_DISPLAY', '- No series to choose from -');
define('PULL_DOWN_TEXT_NO_GENRES_TO_DISPLAY', '- No genres to choose from -');

//
define('BOOKX_URL_LINK_TEXT_AUTHOR', 'Webpage author');
define('BOOKX_URL_LINK_TEXT_PUBLISHER', 'Webpage publisher');

//*** Extra Buttons
define('BUTTON_IMAGE_BOOKX_UPCOMING','button_bookx_upcoming.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/
define('BUTTON_IMAGE_BOOKX_NEW','button_bookx_new.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/
define('BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE','button_bookx_temporarily_unavailable.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/
define('BUTTON_IMAGE_BOOKX_UPCOMING_PREORDER','button_bookx_upcoming_preorder.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/

define('BUTTON_IMAGE_BOOKX_UPCOMING_ALT','Upcoming');
define('BUTTON_IMAGE_BOOKX_NEW_ALT','New');
define('BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE_ALT','Temporarily out of stock');
define('BUTTON_IMAGE_BOOKX_UPCOMING_PREORDER_ALT','Pre-order');

//*** Texts & Labels for authors list, series list etc.
define('TEXT_BOOKX_FILTERS_STOCKCHECKBOX_LABEL', 'also list books out of print');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_AUTHOR', 'Books by %s');
define('TEXT_DISPLAY_NUMBER_OF_AUTHORS', 'Showing %1$s to %2$s of %3$s authors');
define('TEXT_BOOKX_AUTHOR_LIST_TITLE', 'List of authors');
define('TEXT_BOOKX_AUTHOR_LIST_STOCKCHECKBOX_LABEL', 'also list authors with books out of print');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_GENRE', 'Books with genre %s');
define('TEXT_DISPLAY_NUMBER_OF_GENRES', 'Showing %1$s to %2$s of %3$s genres');
define('TEXT_BOOKX_GENRE_LIST_TITLE', 'List of genres');
define('TEXT_BOOKX_GENRE_LIST_STOCKCHECKBOX_LABEL', 'also list genres with books out of print');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_IMPRINT', 'Books in imprint %s');
define('TEXT_DISPLAY_NUMBER_OF_IMPRINTS', 'Showing %1$s to %2$s of %3$s imprints');
define('TEXT_BOOKX_IMPRINT_LIST_TITLE', 'List of imprints');
define('TEXT_BOOKX_IMPRINT_LIST_STOCKCHECKBOX_LABEL', 'also list imprints with books out of print');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_PUBLISHER', 'Books of publisher %s');
define('TEXT_DISPLAY_NUMBER_OF_PUBLISHERS', 'Showing %1$s to %2$s of %3$s publishers');
define('TEXT_BOOKX_PUBLISHER_LIST_TITLE', 'List of publishers');
define('TEXT_BOOKX_PUBLISHER_LIST_STOCKCHECKBOX_LABEL', 'also list publishers with books out of print');

define('TEXT_BOOKX_LIST_PRODUCTS_OF_SERIES', 'Books of series %s');
define('TEXT_DISPLAY_NUMBER_OF_SERIES', 'Showing %1$s to %2$s of %3$s series');
define('TEXT_BOOKX_SERIES_LIST_TITLE', 'List of series');
define('TEXT_BOOKX_SERIES_LIST_STOCKCHECKBOX_LABEL', 'also list series out of print');

define('TEXT_BOOKX_PUBLISHED_PRODUCTS_LABEL', 'Published');
define('TEXT_BOOKX_UPCOMING_PRODUCTS_LABEL', 'Upcoming');
define('TEXT_BOOKX_NEW_PRODUCTS_LABEL', 'New');

define('TEXT_BOOKX_LINK_TO_PRODUCT_DETAIL', '-> more infos');

//added by mesnitu
//added by mesnitu
define('PULL_DOWN_ALL_AUTHORS', 'Filter authors');
define('PULL_DOWN_ALL_AUTHOR_TYPES', 'Filter Author Types');
define('PULL_DOWN_ALL_SERIES', 'Filter Series');
define('PULL_DOWN_ALL_GENRES', 'Filter Genres');
define('PULL_DOWN_ALL_IMPRINTS', 'Filter Imprint');
define('PULL_DOWN_ALL_PUBLISHERS', 'Filter Publishers');