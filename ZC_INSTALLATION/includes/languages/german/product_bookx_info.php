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
 * @version $Id: [ZC INSTALLATION]/includes/languages/german/product_bookx_info.php 2016-02-02 philou $
 */


define('TEXT_PRODUCT_NOT_FOUND', 'Entschuldigen Sie bitte, aber das Buch konnte nicht gefunden werden.');
define('TEXT_CURRENT_REVIEWS', 'Aktuelle Bewertungen:');
define('TEXT_MORE_INFORMATION','Für weitere Informationen besuchen Sie diese <a href="%s" target="_blank">Webseite</a>.');
define('TEXT_DATE_ADDED', 'Dieses Buch wurde am %s im Shop aufgenommen.');
define('TEXT_DATE_AVAILABLE', 'Dieses Buch wird voraussichtlich ab %s wieder lieferbar sein.');
define('TEXT_ALSO_PURCHASED_PRODUCTS', 'Kunden, die dieses Buch kauften, haben auch diese Bücher / diese Artikel gekauft...');
define('TEXT_PRODUCT_OPTIONS', 'Bitte wählen Sie:');
define('TEXT_PRODUCT_WEIGHT', 'Versandgewicht: ');
define('TEXT_PRODUCT_QUANTITY', ' Exemplare auf Lager');
define('TEXT_PRODUCT_MODEL', 'Artikelnummer: ');
define('TEXT_PRODUCT_ISBN', 'ISBN: ');
define('TEXT_PRODUCT_COLLECTIONS', 'Medienkollektion: ');


// boox specific data



define('LABEL_PUBLISHER', 'Verlag: ');
define('LABEL_PUBLISHER_DESCRIPTION', 'Über den Verlag: ');
define('TEXT_PUBLISHER_URL', 'Weitere Informationen zu diesem Verlag erhalten Sie auf dieser <a href="%s" target="_blank">Webseite</a>.');

define('LABEL_IMPRINT', 'Sublabel: ');
define('LABEL_IMPRINT_DESCRIPTION', 'Über das Label: ');

define('LABEL_SERIES', 'Serie: ');
define('LABEL_SERIES_DESCRIPTION', 'Über die Serie: ');

define('LABEL_AUTHORS', 'Autoren');
define('LABEL_AUTHOR', 'Autor');
define('LABEL_AUTHOR_DESCRIPTION', 'Über %s: ');
define('TEXT_AUTHOR_URL', '<a href="%s" target="_blank">Autorenwebseite</a>');
define('HEADING_AUTHOR_RELATED_PRODUCTS', 'Weitere Bücher von <span class="author">%s</span>:');
define('TEXT_AUTHOR_TEAM_AND', 'und');

define('BOOKX_PRODUCT_STATUS_IN_STOCK', '');
define('BOOKX_PRODUCT_STATUS_OUT_OF_PRINT', '(vergriffen)');
define('BOOKX_PRODUCT_STATUS_UPCOMING_PRODUCT', '(in Vorbereitung!)');
define('BOOKX_PRODUCT_STATUS_NEW_PRODUCT', 'Neu!');


// previous next product
define('PREV_NEXT_PRODUCT', 'Buch ');
define('PREV_NEXT_UPCOMING_PRODUCT', 'Buch in Vorbereitung');
define('PREV_NEXT_NEW_PRODUCT', 'Neuheit');
define('PREV_NEXT_FROM', ' von ');
define('IMAGE_BUTTON_PREVIOUS','Vorheriges Buch');
define('IMAGE_BUTTON_NEXT','Nächstes Buch');
define('IMAGE_BUTTON_RETURN_TO_PRODUCT_LIST','Zurück zur Bücherliste');

// missing products
//define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
//define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
//define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

define('TEXT_ATTRIBUTES_PRICE_WAS',' [kostete: ');
define('TEXT_ATTRIBUTE_IS_FREE',' ist jetzt: KOSTENLOS]');
define('TEXT_ONETIME_CHARGE_SYMBOL', ' *');
define('TEXT_ONETIME_CHARGE_DESCRIPTION', ' Einmalige Gebühren können anfallen');
define('TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK','Mengenrabatte erhältlich');
define('ATTRIBUTES_QTY_PRICE_SYMBOL', zen_image(DIR_WS_TEMPLATE_ICONS . 'icon_status_green.gif', TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK, 10, 10) . '&nbsp;');
define('ATTRIBUTES_PRICE_DELIMITER_PREFIX', ' ( ' );
define('ATTRIBUTES_PRICE_DELIMITER_SUFFIX', ' )' );
define('ATTRIBUTES_WEIGHT_DELIMITER_PREFIX', ' (' );
define('ATTRIBUTES_WEIGHT_DELIMITER_SUFFIX', ') ' );
