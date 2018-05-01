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
 * @version $Id: [admin]/includes/languages/german/bookx_author_types.php 2016-02-02 philou $
 */


define('HEADING_TITLE', 'Autorentyp');
define('TABLE_HEADING_AUTHOR_TYPE', 'Autorentyp');
define('TABLE_HEADING_SORT_ORDER', 'Sortierung');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_NEW_INTRO', 'Geben Sie bitte unten die Informationen für den neuen Autorentyp an.');
define('TEXT_EDIT_INTRO', 'Bearbeiten Sie bitte unten die Informationen des Autorentyps.');
define('TEXT_DELETE_INTRO', 'Sind Sie sicher, dass Sie den Autorentyp „%1$s” löschen wollen?');
define('TEXT_DELETE_IMAGE', 'Bild(er) löschen?');
define('TEXT_AUTHOR_TYPE_DESCRIPTION', 'Bezeichnung des Autorentyps (z.B. „Schriftsteller”, „Illustrator”, „Fotograf”');
define('TEXT_AUTHOR_TYPE_IMAGE', 'Bild für Autorentyp');
define('TEXT_AUTHOR_TYPE_SORT_ORDER', 'Sortierung');
define('TEXT_AUTHOR_TYPE_SORT_ORDER_INFLUENCES_DISPLAY', '<strong>Achtung:</strong> Autorentypen mit Sortierung "%1$s" oder größer, werden in der Artikel<u>liste</u> nicht angezeigt. Änderung in <a href="%2$s">Layouteinstellung für Artikeltyp "BookX"</a>.');
define('TEXT_AUTHOR_TYPE_IMAGE_NOT_DEFINED', '[Kein Bild für Autorentyp vorhanden]');
define('TEXT_AUTHOR_TYPE_IMAGE_DIR', 'Bildverzeichnis ');
define('TEXT_AUTHOR_TYPE_IMAGE_MANUAL', '<strong>Oder wählen Sie ein bestehendes Bild vom Server, Dateiname:</strong>');
define('TEXT_HEADING_NEW_AUTHOR_TYPE', 'Neuer Autorentyp');
define('TEXT_HEADING_EDIT_AUTHOR_TYPE', 'Autorentyp bearbeiten');
define('TEXT_HEADING_DELETE_AUTHOR_TYPE', 'Autorentyp löschen');
define('TEXT_DATE_ADDED', 'Erstellt am');
define('TEXT_LAST_MODIFIED', 'Letzte Änderung');
define('TEXT_IMAGE_NONEXISTENT', 'Das Bild existiert nicht');
define('TEXT_PRODUCTS', 'Verlinkte Bücher');
define('TEXT_DISPLAY_NUMBER_OF_AUTHOR_TYPES', 'Zeige <strong>%d</strong> bis <strong>%d</strong> (von <strong>%d</strong> Autorentypen)');

define('TEXT_SETNULL_AUTHORTYPE_AUTHORS', 'Alle Autoren des Autorentyps „%1$s” von verlinkten Büchern entfernen? Wenn diese Option ausgewählt ist, werden alle Autoren des Autorentyps „%1$s” von zugewiesenen Büchern entfernt. Die Autoren selbst werden nicht gelöscht und verbleiben in der Datenbank.');

define('TEXT_DELETE_AUTHORTYPE_PRODUCTS', 'Alle mit dem Autorentyp „%1$s” verlinkten Bücher löschen? Wenn diese Option ausgewählt ist, werden alle Bücher gelöscht, denen ein Autor des Autorentyps „%1$s” zugewiesen ist. Die Autoren selbst werden nicht gelöscht und verbleiben in der Datenbank.');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ACHTUNG:</b>  Es gibt noch %1$s Bücher, die mit Autoren vom Typ „%2$s” verlinkt sind! Diese Verlinkung wird aufgehoben, das Buch wird <u>nicht</u> gelöscht.');
