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
 * @version $Id: [admin]/includes/languages/german/extra/definitions/product_bookx.php 2016-02-02 philou $
 */
// Date format when only month and year are used for "publishing date
define('DATE_FORMAT_MONTH_AND_YEAR', '%M %Y');

// Extra Popup Texts for Product type layout settings
define('BOOKX_LAYOUT_SETTINGS_ENABLED', 'Ja');
define('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY', 'Ja, außer wenn leer');
define('BOOKX_LAYOUT_SETTINGS_DISABLED', 'Nein');

define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME', 'Name'); // value = 1
define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER', 'Sortierung'); // value = 2
define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_NAME', 'Typ Name)'); // value = 3
define('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_SORT_ORDER', 'Typ Sortierung'); // value = 4


// Admin EXTRA menu items for product type bookx
define('BOX_CATALOG_PRODUCT_BOOKX_AUTHORS', 'BookX: Autoren');
define('BOX_CATALOG_PRODUCT_BOOKX_AUTHOR_TYPES', 'BookX: Autorentypen');
define('BOX_CATALOG_PRODUCT_BOOKX_BINDING', 'BookX: Bindungsarten');
define('BOX_CATALOG_PRODUCT_BOOKX_CONDITIONS', 'BookX: Zustand');
define('BOX_CATALOG_PRODUCT_BOOKX_GENRES', 'BookX: Genres');
define('BOX_CATALOG_PRODUCT_BOOKX_IMPRINTS', 'BookX: Verlag Unterlabel');
define('BOX_CATALOG_PRODUCT_BOOKX_PRINTING', 'BookX: Druck');
define('BOX_CATALOG_PRODUCT_BOOKX_PUBLISHERS', 'BookX: Verlage');
define('BOX_CATALOG_PRODUCT_BOOKX_SERIES', 'BookX: Serien');

// Admin CATALOG menu item for product type bookx
define('BOX_CATALOG_PRODUCT_BOOKX', 'BookX Artikel editieren');

// Admin TOOLS menu item for product type bookx
define('TOOLS_MENU_PRODUCT_BOOKX', 'BookX: Installation & Tools');

// Category listing items for product type bookx
define('LABEL_BOOKX_ISBN', 'ISBN: ');
define('LABEL_BOOKX_VOLUME', 'Band %s');


// Admin CONFIG menu item for product type bookx
define('CONFIG_MENU_PRODUCT_BOOKX', 'BookX: Konfiguration');

define('HEADING_TITLE_BOOKX', 'BookX Tools');
define('TEXT_BOOKX_STATUS_INSTALLED', 'BookX ist bereits <strong>installiert</strong>.');
define('TEXT_BOOKX_STATUS_NOT_INSTALLED', 'BookX ist noch <strong>nicht</strong> installiert.');

define('BOOKX_LINK_INSTALL', 'BookX im Shop installieren. (Bitte auf jeden Fall vorher ein Datenbank-Backup machen!)');
define('BOOKX_LINK_UPDATE', 'BookX auf neue Version aktualisieren. (Bitte auf jeden Fall vorher ein Datenbank-Backup machen!)');
define('BOOKX_LINK_REMOVE', 'BookX aus der Datenbank entfernen. (Bitte auf jeden Fall vorher ein Datenbank-Backup machen!) Alle BookX Artikel, sowie alle BookX Autoren, Genres, Verlage etc. werden gelöscht!');
define('BOOKX_LINK_RESET', 'BookX Einstellungen zurücksetzen. Fehlende Konfigurationseinträge werden ggf. eingefügt. <STRONG>Keine Artikel werden verändert oder gelöscht!</strong> (Bitte auf jeden Fall vorher ein Datenbank-Backup machen!)');


define('TEXT_CONVERT_BOOKX_PRODUCTS', 'Konvertiere alle Artikel vom Typ "BookX" zu Artikeln vom Typ "General" und entferne die zusätzlichen Artikelattribute des Artikeltyps "BookX".');
define('TEXT_DELETE_BOOKX_PRODUCTS', 'Lösche alle Artikel vom Typ "BookX" vollständig aus der Datenbank..');
define('BOOKX_CONFIRM_REMOVE', 'Sind Sie sicher?');

define('BOOKX_LINK_MANAGE_PRODUCT_MIGRATION', 'Bestehende Artikel zum Artikeltyp „BookX” konvertieren, oder vom Typ „BookX” zu einem anderen Typ. (Auswahl im nächsten Schritt)');

define('BOOKX_OPTION_IMPORT', '<strong>Option 1: Existierende Artikel zum Typ „BookX” konvertieren:</strong>');
define('BOOKX_SELECT_PRODUCT_TYPE_SOURCE_FOR_MIGRATION', 'Bitte wählen Sie den Artikeltyp, dessen Artikel zum Typ „BookX” konvertiert werden sollen:');

define('BOOKX_OPTION_EXPORT', '<strong>Option 2: Existierende Artikel vom Typ „BookX” zu einem anderen Artikeltyp konvertieren </strong>(z.B. „Product - General”):');
define('BOOKX_SELECT_PRODUCT_TYPE_DESTINATION_FOR_MIGRATION', 'Bitte wählen Sie den Artikeltyp, zu dem Artikel vom Typ „BookX” konvertiert werden sollen. (Felder, die nur dem Artikeltyp „BookX” zur Verfügung stehen, werden dabei entfernt):');

define('BOOKX_OPTION_CONVERT_ALL_PRODUCTS', 'Alle Artikel dieses Typs konvertieren');
define('BOOKX_OPTION_SELECT_PRODUCTS_TO_CONVERT', 'Auswählen, welche Artikel dieses Types konvertiert werden');

// message stack messages

define('BOOKX_MS_ALL_EXIST','Alle BookX Dateien sind korrekt in der richtigen Struktur vorhanden.');
define('BOOKX_MS_ABORTED','********** Installation abgebrochen **********');
define('BOOKX_MS_SOME_REQUIRED_FILES_MISSING','Einige benötigte BookX Dateien fehlen oder können nicht gelesen werden. Haben Sie wirklich alle hochgeladen? Sind die Dateiberechtigungen korrekt?');
define('BOOKX_MS_FILE_SHOULD_ONLY_BE_OVERRIDE','Diese BookX Datei sollte nur im Ordner "template_default" vorliegen, <u>außer</u> es sind Overrides für diesen ZC Shop. Beim Aktualisieren des BookX Plugins müssen die Overrides in eine Kopie der Datei aus "template_default" eingefügt werden:');
define('BOOKX_MS_SOME_LANGUAGE_FILES_MISSING','Folgende BookX Sprach-Dateien für die Sprache „%s” fehlen oder konnten nicht gelesen werden. Haben Sie wirklich alle hochgeladen? Sind die Dateiberechtigungen korrekt? Falls die Sprache „%s” im Shop nicht verwendet wird, werden diese Dateien nicht benötigt und Sie können diese warnung ignorieren.');
define('BOOKX_MS_VERSION_ALREADY_UP_TO_DATE','BookX Version %s ist bereits installiert. Kein Update durchgeführt');
define('BOOKX_MS_DB_UPDATE_SUCCESS','BookX wurde erfolgreich aktualisiert.');
define('BOOKX_MS_TEMPLATE_NOTFOUND','BookX kann Ihr aktives Template nicht finden.');
define('BOOKX_MS_MISSING_OR_UNREADABLE','Fehlende oder nicht lesbare Datei:');
define('BOOKX_MS_OVERWRITTEN','wurde überschrieben. Eine Backupdatei wurde angelegt.');
define('BOOKX_MS_NOT_OVERWRITTEN','wurde NICHT überschrieben.');
define('BOOKX_MS_CREATED','wurde angelegt. Backupdateien aller überschriebenen Dateien wurden angelegt.');
define('BOOKX_MS_NOT_CREATED','wurde NICHT angelegt.');
define('BOOKX_MS_DB_TABLES_SUCCESS','Die BookX Datenbank-Tabellen wurden erfolgreich installiert.');
define('BOOKX_MS_SUCCESS','BookX wurde erfolgreich installiert.');
define('BOOKX_MS_RESET_SUCCESS','BookX Einstellungen wurden erfolgreich zurückgesetzt.');
define('BOOKX_MS_ROLLBACK_OK','wurde wieder auf die vorherige Version zurückgestellt.');
define('BOOKX_MS_ROLLBACK_NOT_OK','wurde NICHT wieder auf die vorherige Version zurückgestellt.');
define('BOOKX_MS_UNINSTALL_OK','BookX wurde erfolgreich deinstalliert.');
define('BOOKX_MS_TABLE_DOESNT_EXIST','Tabelle %s konnte nicht in der Datenbank gefunden werden. Installation unvollständig!');

define('BOOKX_MS_BACKUP_INFO','BookX legt Backups bestimmter Dateien an, bevor er diese Dateien bei der Installation überschreibt. Diese Dateien wurden am Server belassen. Sie können Sie löschen, es beeinträchtigt die Funktionalität Ihres Shops aber nicht, wenn Sie sie für Referenzzwecke am Server belassen.');

define('BOOKX_MS_AUTOLOADER_NOTDELETED','Der Autoloader YOURADMIN/includes/auto_loaders/config.product_type_bookx.php wurde NICHT gelöscht. Damit BookX funktioniert, müssen Sie diese Datei manuell löschen.');
define('BOOKX_MS_MODULE_ALREADY_INSTALLED','Der Artikeltyp BookX ist bereits installiert, Sie müssen diesen erst de-installieren, bevor er erneut installiert werden kann.');

define('BOOKX_MS_PRODUCT_TYPE_BOOKX_MISSING','Der Artikeltyp "BookX" ist in diesem Shop nicht installiert. Bitte BookX installieren.');
define('BOOKX_MS_CONFIG_TYPE_BOOKX_MISSING','Der Konfigurationstyp "BookX" ist in diesem Shop nicht installiert. Bitte BookX installieren.');

define('BOOKX_MS_PRODUCT_LAYOUT_CONFIGS_NOT_INSTALLED','Artikeltyp BookX: Layoutkonfiguration konnte nicht in Datenbank installiert werden.');
define('BOOKX_MS_ADMIN_CONFIG_MENU_NOT_INSTALLED','Artikeltyp BookX: Menüpunkt im Menü "Konfiguration" konnte nicht in Datenbank installiert werden.');
