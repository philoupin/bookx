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
 * @version $Id: [ZC INSTALLATION]/includes/languages/german/extra_definitions/product_bookx.php 2016-02-02 philou $
 */
// Date format when only month and year are used for "publishing date
define('DATE_FORMAT_MONTH_AND_YEAR', '%M %Y');

define('BOX_HEADING_BOOKX_FILTERS', 'Bücher Filter');
define('PULL_DOWN_BOOKX_RESET', '- Zurücksetzen -');
define('BOOKX_GENRE_SEPARATOR', ' | ');

define('BOOKX_BREADCRUMB_LABEL_SEARCHTERM', 'Suchbegriff');


//*** extra texts for new and upcoming products
define('TABLE_HEADING_BOOKX_DATE_PUBLISHED', 'Erscheinungsdatum');
define('TABLE_HEADING_BOOKX_UPCOMING_IMAGE', 'Bild');
define('TABLE_HEADING_BOOKX_UPCOMING_DESCRIPTION', 'Beschreibung');
define('TEXT_BOOKX_WRAPPER_PUBLISHING_DATE', 'Erscheint vorraussichtlich %s.');
define('TEXT_BOOKX_MORE_PRODUCT_INFO', '&nbsp;mehr');


//*** These may appear on product_listing page
define('LABEL_BOOKX_CONDITION', 'Zustand');
define('LABEL_BOOKX_GENRE', 'Genre');
define('LABEL_BOOKX_PAGES', '%s Seiten');
define('LABEL_BOOKX_VOLUME', 'Band %s');
define('LABEL_BOOKX_ISBN', 'ISBN');
define('LABEL_BOOKX_AUTHOR', 'Autor');
define('LABEL_BOOKX_AUTHORS', 'Autoren');
define('LABEL_BOOKX_MODEL', 'Art.Nr.');
define('LABEL_BOOKX_PUBLISHING_DATE', 'Erscheinungsdatum: ');


//*** These Labels are used for Breadcrumbs
define('FILTER_LABEL_BOOKX_PUBLISHER_ID', 'Verlag: ');
define('FILTER_LABEL_BOOKX_AUTHOR_ID', 'Autor: ');
define('FILTER_LABEL_BOOKX_AUTHOR_TYPE_ID', 'Autorentyp: ');
define('FILTER_LABEL_BOOKX_IMPRINT_ID', 'Label: ');
define('FILTER_LABEL_BOOKX_SERIES_ID', 'Serie: ');
define('FILTER_LABEL_BOOKX_GENRE_ID', 'Genre: ');
define('FILTER_LABEL_BOOKX_PRINTING_ID', 'Druck: ');
define('FILTER_LABEL_BOOKX_CONDITION_ID', 'Zustand:');
define('FILTER_LABEL_BOOKX_BINDING_ID', 'Einband: ');
define('FILTER_LABEL_BOOKX_UPCOMING', 'In Vorbereitung');
define('FILTER_LABEL_BOOKX_NEW', 'Neuerscheinung');


//*** Labels for filter Sidebox Popups
define('LABEL_FILTER_AUTHOR', 'Zeige Autor:');
define('LABEL_FILTER_AUTHOR_TYPES', 'Zeige Autoren vom Typ:');
define('LABEL_FILTER_GENRE', 'Zeige Genre:');
define('LABEL_FILTER_IMPRINT', 'Zeige Label:');
define('LABEL_FILTER_PUBLISHER', 'Zeige Verlag:');
define('LABEL_FILTER_SERIES', 'Zeige Serie:');
define('LABEL_LIST_ALL_AUTHORS', '--> Alle Autoren auflisten');
define('LABEL_LIST_ALL_AUTHOR_TYPES', '--> Alle Autorentypen auflisten');
define('LABEL_LIST_ALL_GENRES', '--> Alle Genres auflisten');
define('LABEL_LIST_ALL_IMPRINTS', '--> Alle Unterlabel auflisten');
define('LABEL_LIST_ALL_PUBLISHERS', '--> Alle Verlage auflisten');
define('LABEL_LIST_ALL_SERIES', '--> Alle Serien auflisten');
define('BOOKX_LINK_TEXT_RESET_ALL_FILTERS', 'Alle Filter zurücksetzen');
define('PULL_DOWN_TEXT_NO_AUTHORS_TO_DISPLAY', '- Keine Autoren zur Auswahl -');
define('PULL_DOWN_TEXT_NO_AUTHOR_TYPES_TO_DISPLAY', '- Kein Autorentyp zur Auswahl -');
define('PULL_DOWN_TEXT_NO_PUBLISHERS_TO_DISPLAY', '- Keine Verlage zur Auswahl -');
define('PULL_DOWN_TEXT_NO_IMPRINTS_TO_DISPLAY', '- Keine Label zur Auswahl -');
define('PULL_DOWN_TEXT_NO_SERIES_TO_DISPLAY', '- Keine Serien zur Auswahl -');
define('PULL_DOWN_TEXT_NO_GENRES_TO_DISPLAY', '- Keine Genres zur Auswahl -');


//
define('BOOKX_URL_LINK_TEXT_AUTHOR', 'Autorenwebseite');
define('BOOKX_URL_LINK_TEXT_PUBLISHER', 'Verlagswebseite');


//*** Extra Buttons
define('BUTTON_IMAGE_BOOKX_UPCOMING','button_bookx_upcoming.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/
define('BUTTON_IMAGE_BOOKX_NEW','button_bookx_new.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/
define('BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE','button_bookx_temporarily_unavailable.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/
define('BUTTON_IMAGE_BOOKX_UPCOMING_PREORDER','button_bookx_upcoming_preorder.gif'); // This image file is NOT provided, you have to make it yourself and put it into includes/templates/[YOUTEMPLATE]/buttons/[YOURLANGUAGE]/

define('BUTTON_IMAGE_BOOKX_UPCOMING_ALT','Vorankündigung');
define('BUTTON_IMAGE_BOOKX_NEW_ALT','Neu! Bestellen');
define('BUTTON_IMAGE_BOOKX_TEMPORARILY_UNAVAILABLE_ALT','Nicht auf Lager');
define('BUTTON_IMAGE_BOOKX_UPCOMING_PREORDER_ALT','Vorbestellen');


//*** Texte & Label für Listen der Autoren, Verlage, Serien etc.
define('TEXT_BOOKX_FILTERS_STOCKCHECKBOX_LABEL', 'auch vergriffener Bücher anzeigen');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_AUTHOR', 'Bücher von %s');
define('TEXT_DISPLAY_NUMBER_OF_AUTHORS', 'Zeige %1$s bis %2$s von %3$s Autoren');
define('TEXT_BOOKX_AUTHOR_LIST_TITLE', 'Liste der Autoren');
define('TEXT_BOOKX_AUTHOR_LIST_STOCKCHECKBOX_LABEL', 'auch Autoren vergriffener Bücher anzeigen');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_GENRE', 'Bücher mit dem Genre %s');
define('TEXT_DISPLAY_NUMBER_OF_GENRES', 'Zeige %1$s bis %2$s von %3$s Genres');
define('TEXT_BOOKX_GENRE_LIST_TITLE', 'Liste der Genres');
define('TEXT_BOOKX_GENRE_LIST_STOCKCHECKBOX_LABEL', 'auch Genre mit vergriffenen Büchern anzeigen');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_IMPRINT', 'Bücher unter dem Label %s');
define('TEXT_DISPLAY_NUMBER_OF_IMPRINTS', 'Zeige %1$s bis %2$s von %3$s Labeln');
define('TEXT_BOOKX_IMPRINT_LIST_TITLE', 'Liste der Label');
define('TEXT_BOOKX_IMPRINT_LIST_STOCKCHECKBOX_LABEL', 'auch Label mit vergriffenen Büchern anzeigen');

define('TEXT_BOOKX_LIST_PRODUCTS_BY_PUBLISHER', 'Bücher von %s');
define('TEXT_DISPLAY_NUMBER_OF_PUBLISHERS', 'Zeige %1$s bis %2$s von %3$s Verlagen');
define('TEXT_BOOKX_PUBLISHER_LIST_TITLE', 'Liste der Verlage');
define('TEXT_BOOKX_PUBLISHER_LIST_STOCKCHECKBOX_LABEL', 'auch Verlage mit vergriffenen Büchern anzeigen');

define('TEXT_BOOKX_LIST_PRODUCTS_OF_SERIES', 'Bücher der Serie %s');
define('TEXT_DISPLAY_NUMBER_OF_SERIES', 'Zeige %1$s bis %2$s von %3$s Serien');
define('TEXT_BOOKX_SERIES_LIST_TITLE', 'Liste der Serien');
define('TEXT_BOOKX_SERIES_LIST_STOCKCHECKBOX_LABEL', 'auch vergriffene Serien anzeigen');

define('TEXT_BOOKX_PUBLISHED_PRODUCTS_LABEL', 'Erschienen');
define('TEXT_BOOKX_UPCOMING_PRODUCTS_LABEL', 'In Vorbereitung');
define('TEXT_BOOKX_NEW_PRODUCTS_LABEL', 'Neuheiten');

define('TEXT_BOOKX_LINK_TO_PRODUCT_DETAIL', '-> Leseproben / Autoren-Bio / Rezensionen');


