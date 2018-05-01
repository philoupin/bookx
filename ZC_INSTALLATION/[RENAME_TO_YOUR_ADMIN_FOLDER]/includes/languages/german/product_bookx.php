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
 * @version $Id: [ZC INSTALLATION]/[ADMIN]includes/languages/german/product_bookx.php 2016-02-02 philou $
 */


define('HEADING_TITLE', 'Kategorien / Artikel');
define('HEADING_TITLE_GOTO', 'Gehe zu:');
define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Kategorien / Artikel');
define('TABLE_HEADING_CATEGORIES_SORT_ORDER', 'Sortierung');
define('TABLE_HEADING_PRICE', 'Preis | Sonderpreis | Abverkauf');
define('TABLE_HEADING_QUANTITY', 'Lagermenge');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_STATUS', 'Status');

//*** product display status info
define('TEXT_PRODUCT_STATUS_NOT_DISPLAYED_DUE_TO_PRODUCT_STATUS', 'Dieses Buch wird momentan im Shop <u>nicht</u> angezeigt, da der Artikelstatus auf "Nicht lagernd" eingestellt ist.');
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING', 'BookX betrachtet dieses Buch als „Vorankündigung” und zeigt es ggf. als "Vorankündigung" im Shop an (Einstellung <a href="%1$s" target="_blank">hier</a>), da das <a href="#publishing_date_field">Erscheinungsdatum</a> weniger als %2$s Tage in der Zukunft liegt.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_NEW_BUT_UPCOMING_WITHOUT_STOCK', 'BookX betrachtet dieses Buch als „Vorankündigung” und zeigt es ggf. als "Vorankündigung" im Shop an (Einstellung <a href="%1$s" target="_blank">hier</a>), obwohl das <a href="#publishing_date_field">Erscheinungsdatum</a> in der Vergangenheit liegt, da noch kein <a href="#product_quantity_field">Lagerbestand</a> eingetragen ist. <br />Soll dieses Buch als "Neuheit" angezeigt werden, welche nur vorübergehend nicht lieferbar ist, dann bitte ein <a href="#date_available_field">"Erhältlich ab" Datum</a> in der Zukunft angeben.');
/*** bof obsolete and will be removed */
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING_WITH_DATE_AVAILABLE', 'BookX betrachtet dieses Buch als „Vorankündigung” und zeigt es ggf. als "Vorankündigung" im Shop an (Einstellung <a href="%1$s" target="_blank">hier</a>), da der <a href="#product_quantity_field">Lagerbestand</a> "0" ist und das <a href="#date_available_field">"Erhältlich ab" Datum</a> in der Zukunft liegt.');
/*** eof obsoltete */
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING_PREORDER_OPTION', ' Dieses Buch kann gekauft (vorbestellt) werden, da der <a href="#product_quantity_field">Lagerbestand</a> größer "0" ist.');
define('TEXT_PRODUCT_STATUS_NOT_DISPLAYED_SINCE_BEYOND_UPCOMING', 'BookX zeigt dieses Buch nicht im Shop an, da das <a href="#publishing_date_field">Erscheinungsdatum</a> weiter als %1$s Tage in der Zukunft liegt. Dieses Buch wird automatisch als "Vorankündigung" angezeigt ab: ');
define('TEXT_PRODUCT_STATUS_DISPLAYED_AS_NEW', 'BookX betrachtet dieses Buch als „Neuheit” und zeigt es ggf. als "Neuheit" im Shop an, da der <a href="#product_quantity_field">Lagerbestand</a> größer "0" ist und das <a href="#publishing_date_field">Erscheinungsdatum</a> weniger als %s Tage in der Vergangenheit liegt.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_OUT_OF_PRINT', 'BookX betrachtet dieses Buch als <span class="alert">vergriffen</span>, da der <a href="#product_quantity_field">Lagerbestand</a> "0" ist und das <a href="#publishing_date_field">Erscheinungsdatum</a> nicht angegeben ist oder in der Vergangenheit liegt und kein <a href="#date_available_field">"Erhältlich ab" Datum</a> angegeben ist.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_TEMPORARILY_UNAVAILABLE', 'BookX betrachtet dieses Buch als zur Zeit nicht verfügbar, da der <a href="#product_quantity_field">Lagerbestand</a> "0" ist aber ein <a href="#date_available_field">"Erhältlich ab" Datum</a> in der Zukunft angegeben ist.');
define('TEXT_PRODUCT_STATUS_CONSIDERED_REGULAR_IN_STOCK', 'BookX betrachtet dieses Buch als "lieferbar", da der <a href="#product_quantity_field">Lagerbestand</a> größer "0" ist und das <a href="#publishing_date_field">Erscheinungsdatum</a> nicht angegeben ist oder mehr als %1$s Tage in der Vergangenheit liegt.');
define('TEXT_PRODUCT_STATUS_DEFAULT_CASE', 'BookX hat Schwierigkeiten den Produktstatus dieses Buches festzustellen.');
define('TEXT_ZC_NEW_PRODUCTS_LIMIT_WARNING', 'Die Zen Cart Funktion "%1$s" ist aktiviert und zeigt nur solche Artikel als "neu", vor weniger als %2$s Tagen im Shop angelegt wurden. Diese Einstellung kann <a href="%3$s">hier</a> geändert werden.');


define('TEXT_CATEGORIES', 'Kategorien:');
define('TEXT_SUBCATEGORIES', 'Unterkategorien:');
define('TEXT_PRODUCTS', 'Artikel:');
define('TEXT_PRODUCTS_BOOKX_AUTHORS', 'Autor(en):');
define('TEXT_PRODUCTS_BOOKX_AUTHOR', 'Autor:');
define('TEXT_PRODUCTS_BOOKX_AUTHOR_TYPE', 'Autorentyp:');
define('TEXT_PRODUCTS_BOOKX_ADD_AUTHOR', 'Autor hinzufügen');
define('TEXT_PRODUCTS_BOOKX_BINDING', 'Bindung:');
define('TEXT_PRODUCTS_BOOKX_CONDITION', 'Zustand:');
define('TEXT_PRODUCTS_BOOKX_PAGES', 'Seitenanzahl:');
define('TEXT_PRODUCTS_BOOKX_PRINTING', 'Druck:');
define('TEXT_PRODUCTS_BOOKX_PUBLISHER', 'Verlag:');
define('TEXT_PRODUCTS_BOOKX_PUBLISHING_DATE', 'Erscheinungsdatum:');
define('TEXT_PRODUCTS_BOOKX_USE_PARTIAL_PUBLISHING_DATE', '(Eingabe: "00" für Monat oder Tag, wenn dieser unbekannt ist, z.B. "2012-03-00" für "März 2012")');
define('TEXT_PRODUCTS_BOOKX_INFO_PUBLISHING_DATE_INFLUENCES_NEW_PRODUCT_DISPLAY', '[Info: Wenn Erscheinungsdatum nicht länger zurückliegt als %1$s Tage, wird dieses Buch als „Neuheit” angezeigt. %2$s. Liegt das Erscheinungsdatum in der Zukunft <u>und Lagerbestand ist "0"</u>, wird dieses Buch als „Vorankündigung” angezeigt.]');
define('TEXT_PRODUCTS_BOOKX_NEW_PRODUCTS_LOOK_BACKWARD_SETTING_LINK', 'Einstellung ändern');
define('TEXT_PRODUCTS_BOOKX_IMPRINT', 'Sublabel:');
define('TEXT_PRODUCTS_BOOKX_GENRES', 'Genre(s):');
define('TEXT_PRODUCTS_BOOKX_ADD_GENRE', 'weiteres Genre zuweisen');
define('TEXT_PRODUCTS_BOOKX_SERIES', 'Serie:');
define('TEXT_PRODUCTS_BOOKX_SIZE', 'Abmessungen:');
define('TEXT_PRODUCTS_BOOKX_SUBTITLE', 'Untertitel:');
define('TEXT_PRODUCTS_BOOKX_VOLUME', 'Band Nr.:');
define('TEXT_PRODUCTS_BOOKX_ISBN', 'ISBN: <small>(ohne Bindestriche)</small>');
define('TEXT_PRODUCTS_BOOKX_ISBN_DISPLAY', 'Darstellung im Shop: ');
define('TEXT_JAVASCRIPT_ISBN_WRONG_CHECKDIGIT', 'Die eingegebene ISBN "%1$s" stimmt nicht mit der Kontrollziffer überein.\n Die Korrekte Kontrollziffer ist: "%2$s"');
define('TEXT_PRODUCTS_PRICE_INFO', 'Preis:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Steuersatz:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Durchschnittliches Rating:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Lagermenge:');
define('TEXT_DATE_ADDED', 'Erstellt am:');
define('TEXT_DATE_AVAILABLE', 'Erhältlich ab:');
define('TEXT_LAST_MODIFIED', 'Letzte Änderung:');
define('TEXT_IMAGE_NONEXISTENT', 'Bild existiert nicht');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Bitte fügen Sie eine neue Kategorie oder einen neuen Artikel in dieser Ebene ein.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'Für weitere Informationen zu diesem Artikel besuchen Sie bitte diese <a href="http://%s" target="blank">Website</a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'Dieser Artikel wurde am %s hinzugefügt.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Dieser Artikel wird am %s wieder lagernd sein.');
define('TEXT_EDIT_INTRO', 'Bitte führen Sie hier die notwendigen Änderungen durch');
define('TEXT_EDIT_CATEGORIES_ID', 'Kategorie ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Kategoriename:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Kategoriebild:');
define('TEXT_EDIT_SORT_ORDER', 'Sortierung:');
define('TEXT_INFO_COPY_TO_INTRO', 'Bitte wählen Sie die neue Kategorie aus, in der Sie diesen Artikel kopieren möchten');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Kategorie:');
define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Neue Kategorie');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Kategorie ändern');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Kategorie löschen');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Kategorie verschieben');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Artikel löschen');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Artikel verschieben');
define('TEXT_INFO_HEADING_COPY_TO', 'Kopieren nach');
define('TEXT_DELETE_CATEGORY_INTRO', 'Wollen Sie diese Kategorie wirklich löschen?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Wollen Sie diesen Artikel wirklich löschen?');
define('TEXT_DELETE_WARNING_CHILDS', '<b>ACHTUNG:</b> es sind bereits %s (Unter-)Kategorien mit dieser Kategorie verlinkt!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ACHTUNG:</b> es sind bereits %s Artikel mit dieser Kategorie verlinkt!');
define('TEXT_MOVE_PRODUCTS_INTRO', 'Bitte wählen Sie die Kategorie aus, in der Sie <b>%s</b> legen wollen');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Bitte wählen Sie die Kategorie aus, in der Sie <b>%s</b> legen wollen');
define('TEXT_MOVE', 'Verschiebe <b>%s</b> nach:');
define('TEXT_NEW_CATEGORY_INTRO', 'Füllen Sie folgende Informationen für die neue Kategorie aus');
define('TEXT_CATEGORIES_NAME', 'Kategoriename:');
define('TEXT_CATEGORIES_IMAGE', 'Kategoriebild:');
define('TEXT_SORT_ORDER', 'Sortierung:');
define('TEXT_PRODUCTS_STATUS', 'Artikelstatus:');
define('TEXT_PRODUCTS_VIRTUAL', 'Virtueller Artikel:');
define('TEXT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', 'Immer Versandkostenfrei:');
define('TEXT_PRODUCTS_QTY_BOX_STATUS', 'Lagerbestand anzeigen:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_PRODUCT_AVAILABLE', 'Lagernd');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Nicht lagernd');
define('TEXT_PRODUCT_IS_VIRTUAL', 'Ja');
define('TEXT_PRODUCT_NOT_VIRTUAL', 'Nein');
define('TEXT_PRODUCT_IS_ALWAYS_FREE_SHIPPING', 'Ja');
define('TEXT_PRODUCT_NOT_ALWAYS_FREE_SHIPPING', 'Nein');
define('TEXT_PRODUCT_SPECIAL_ALWAYS_FREE_SHIPPING', 'Sonderangebot, Artikel/Download benötigt eine Lieferadresse');
define('TEXT_PRODUCTS_SORT_ORDER', 'Sortierung:');
define('TEXT_PRODUCTS_QTY_BOX_STATUS_ON', 'Ja, zeige Box für Stückzahl');
define('TEXT_PRODUCTS_QTY_BOX_STATUS_OFF', 'Nein, zeige keine Box für Stückzahl');
define('TEXT_PRODUCTS_MANUFACTURER', 'Artikelhersteller:');
define('TEXT_PRODUCTS_NAME', 'Buchtitel:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Klappentext / Kurztext:');
define('TEXT_PRODUCTS_QUANTITY', 'Lagerbestand:');
define('TEXT_PRODUCTS_MODEL', 'Artikelnummer:');
define('TEXT_PRODUCTS_IMAGE', 'Bild:');
define('TEXT_PRODUCTS_IMAGE_DIR', 'Uploadverzeichnis:');
define('TEXT_PRODUCTS_URL', 'Herstellerlink:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(Ohne führendes http://)</small>');
define('TEXT_PRODUCTS_PRICE_NET', 'Nettopreis:');
define('TEXT_PRODUCTS_PRICE_GROSS', 'Bruttopreis:');
define('TEXT_PRODUCTS_WEIGHT', 'Gewicht:');
define('EMPTY_CATEGORY', 'Leere Kategorie');
define('TEXT_HOW_TO_COPY', 'Kopiermethode:');
define('TEXT_COPY_AS_LINK', 'Artikel verlinken');
define('TEXT_COPY_AS_DUPLICATE', 'Artikel kopieren');

// Products and Attribute Copy Options
define('TEXT_COPY_ATTRIBUTES_ONLY', 'wird nur für doppelte Artikel verwendet ...');
define('TEXT_COPY_ATTRIBUTES', 'Artikelattribute zum Duplikat kopieren?');
define('TEXT_COPY_ATTRIBUTES_YES', 'Ja');
define('TEXT_COPY_ATTRIBUTES_NO', 'Nein');
define('TEXT_COPY_MEDIA_MANAGER', 'Kopiere jede Kollektion im Medienmanager, die mit diesem Artikel in Verbindung stehen.');
define('TEXT_INFO_CURRENT_PRODUCT', 'Aktueller Artikel:');
define('TABLE_HEADING_MODEL', 'Artikelnummer');
define('TEXT_INFO_HEADING_ATTRIBUTE_FEATURES', 'Attribute für Artikel ID# geändert');
define('TEXT_INFO_ATTRIBUTES_FEATURES_DELETE', 'Lösche <strong>ALLE</strong> Artikelattribute für:<br />');
define('TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO', 'Kopiere Attribute zu einem anderen Artikel oder einer ganzen Kategorie von:<br />');
define('TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_PRODUCT', 'Kopiere Attribute zu einem anderen <strong>Artikel</strong> von:<br />');
define('TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_CATEGORY', 'Kopiere Attribute zu einer anderen <strong>Kategorie</strong> von:<br />');
define('TEXT_COPY_ATTRIBUTES_CONDITIONS', '<strong>Wie sollen existierende Artikelattribute behandelt werden?</strong>');
define('TEXT_COPY_ATTRIBUTES_DELETE', '<strong>Löschen</strong> - Die vorhandenen Attribute werden gelöscht, bevor die neue Attribute kopiert werden');
define('TEXT_COPY_ATTRIBUTES_UPDATE', '<strong>Aktualisieren</strong> - Die vorhanden Attribute werden mit den neuen Einstellungen/Preise aktualisiert, bevor die neuen Attribute hinzufügt werden');
define('TEXT_COPY_ATTRIBUTES_IGNORE', '<strong>Ignorieren</strong> - Es werden nur neue Attribute hinzufügt');
define('SUCCESS_ATTRIBUTES_DELETED', 'Die Attribute wurden gelöscht');
define('SUCCESS_ATTRIBUTES_UPDATE', 'Die Attribute wurden aktualisiert');
define('ICON_ATTRIBUTES', 'Attributmerkmale');
define('TEXT_CATEGORIES_IMAGE_DIR', 'In Verzeichnis hochladen:');
define('TEXT_PRODUCTS_QTY_BOX_STATUS_PREVIEW', 'WARNUNG: Die Lagerstückzahl nicht angezeigt, der Standardwert ist 1');
define('TEXT_PRODUCTS_QTY_BOX_STATUS_EDIT', 'WARNUNG: Die Lagerstückzahl wird nicht angezeigt, der Standardwert ist 1');
define('TEXT_PRODUCT_OPTIONS', '<strong>Bitte wählen Sie:</strong>');
define('TEXT_PRODUCTS_ATTRIBUTES_INFO', 'Attributeigenschaften für:');
define('TEXT_PRODUCT_ATTRIBUTES_DOWNLOADS', 'Downloads:');
define('TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES', 'Preis durch Attribute festgelegt:');
define('TEXT_PRODUCT_IS_PRICED_BY_ATTRIBUTE', 'Ja');
define('TEXT_PRODUCT_NOT_PRICED_BY_ATTRIBUTE', 'Nein');
define('TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_PREVIEW', '*Der angezeigte Preis enthält den niedrigsten Gruppenattributspreis plus dem Grundpreis');
define('TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_EDIT', '*Der angezeigte Preis enthält den niedrigsten Gruppenattributspreis plus dem Grundpreis');
define('TEXT_PRODUCTS_QUANTITY_MIN_RETAIL', 'Artikel Mindestbestand:');
define('TEXT_PRODUCTS_QUANTITY_UNITS_RETAIL', 'Artikelbestandseinheit:');
define('TEXT_PRODUCTS_QUANTITY_MAX_RETAIL', 'Artikel Maximalbestand:');
define('TEXT_PRODUCTS_QUANTITY_MAX_RETAIL_EDIT', 'geben Sie die Anzahl ein (0 = unlimitiert)');
define('TEXT_PRODUCTS_MIXED', 'Artikel Mindestbestand/Anzahl Mix:');
define('PRODUCTS_PRICE_IS_FREE_TEXT', 'Artikel ist kostenlos');
define('TEXT_PRODUCT_IS_FREE', 'Artikel ist kostenlos:');
define('TEXT_PRODUCTS_IS_FREE_PREVIEW', '*Artikel ist als kostenlos markiert');
define('TEXT_PRODUCTS_IS_FREE_EDIT', '*Artikel ist als kostenlos markiert');
define('TEXT_PRODUCT_IS_CALL', 'Artikel ist "Preis bitte anfragen":');
define('TEXT_PRODUCTS_IS_CALL_PREVIEW', '*Artikel ist als "Preis bitte anfragen" gekennzeichnet');
define('TEXT_PRODUCTS_IS_CALL_EDIT', '*Artikel ist als "Preis bitte anfragen" gekennzeichnet');
define('TEXT_ATTRIBUTE_COPY_SKIPPING', '<strong>Überspringe neue Attribute </strong>');
define('TEXT_ATTRIBUTE_COPY_INSERTING', '<strong>Einfügen neuer Attribute von</strong>');
define('TEXT_ATTRIBUTE_COPY_UPDATING', '<strong>Aktualisiere von Attribut </strong>');

// meta tags
define('TEXT_META_TAG_TITLE_INCLUDES', '<strong>Wählen Sie aus, welche Informationen die Metatags des Artikels enthalten sollen:</strong>');
define('TEXT_PRODUCTS_METATAGS_PRODUCTS_NAME_STATUS', '<strong>Artikelname:</strong>');
define('TEXT_PRODUCTS_METATAGS_TITLE_STATUS', '<strong>Titel:</strong>');
define('TEXT_PRODUCTS_METATAGS_MODEL_STATUS', '<strong>Artikelnummer:</strong>');
define('TEXT_PRODUCTS_METATAGS_PRICE_STATUS', '<strong>Preis:</strong>');
define('TEXT_PRODUCTS_METATAGS_TITLE_TAGLINE_STATUS', '<strong>Titelüberschrift:</strong>');
define('TEXT_META_TAGS_TITLE', '<strong>Meta Tag Titel:</strong>');
define('TEXT_META_TAGS_KEYWORDS', '<strong>Meta Tag Schlüsselwörter:</strong>');
define('TEXT_META_TAGS_DESCRIPTION', '<strong>Meta Tag Beschreibung:</strong>');
define('TEXT_META_EXCLUDED', '<span class="alert">AUSGESCHLOSSEN</span>');
