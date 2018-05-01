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
 * @version $Id: [admin]/includes/init_includes/init_product_type_bookx.php 2016-02-02 philou $
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}


//=======================================
//
// SET INSTALLATION VARIABLES
//
//=======================================

// set version
$version = '0.9.5';

// flags
$install_incomplete = false;
$no_template = false;

// find current template
$sql = "SELECT template_dir FROM ".TABLE_TEMPLATE_SELECT." LIMIT 1";
$obj = $db->Execute($sql);
$current_template = $obj->fields['template_dir'];

if($current_template == '' ) {
	$install_incomplete = true;
	$no_template = true;
	$messageStack->add(BOOKX_MS_TEMPLATE_NOTFOUND, 'warning');

}

$admin_page_keys = array('configBookXTools',
						'configProdTypeBookX',
						'bookxAuthors',
						'bookxAuthorTypes',
						'bookxBinding',
						'bookxConditions',
						'bookxGenres',
						'bookxImprints',
						'bookxPrinting',
						'bookxPublishers',
						'bookxSeries',
						'bookxProduct');

// get constants for use inside Heredoc block
$const = get_defined_constants();

// necessary BookX files
$required_files = array(
		DIR_FS_CATALOG . 'includes/auto_loaders/config.bookx.php',
		DIR_FS_CATALOG . 'includes/classes/observers/class.bookx_observers.php',
		DIR_FS_CATALOG . 'includes/extra_configures/bookx_defines_and_configures.php',
		DIR_FS_CATALOG . 'includes/extra_datafiles/bookx_type_database_names.php',
		DIR_FS_CATALOG . 'includes/functions/extra_functions/functions_product_type_bookx.php',
		DIR_FS_CATALOG . 'includes/index_filters/bookx_filter.php',
		DIR_FS_CATALOG_MODULES . 'product_bookx_prev_next.php',
		DIR_FS_CATALOG_MODULES . 'pages/product_bookx_info/header_php.php',
		DIR_FS_CATALOG_MODULES . 'pages/product_bookx_info/jscript_main.php',
		DIR_FS_CATALOG_MODULES . 'pages/product_bookx_info/jscript_textarea_counter.js',
		DIR_FS_CATALOG_MODULES . 'pages/product_bookx_info/main_template_vars_product_type.php',
		DIR_FS_CATALOG_MODULES . 'pages/product_bookx_info/main_template_vars.php',
		DIR_FS_CATALOG_MODULES . 'sideboxes/bookx_filters.php',
		DIR_FS_CATALOG_MODULES . 'pages/bookx_authors_list/header_php.php',
		DIR_FS_CATALOG_MODULES . 'pages/bookx_series_list/header_php.php',
		DIR_FS_CATALOG_MODULES . 'pages/bookx_publishers_list/header_php.php',
    	DIR_FS_CATALOG_MODULES . 'pages/bookx_imprints_list/header_php.php',
		DIR_FS_CATALOG_MODULES . 'pages/bookx_genres_list/header_php.php',
        DIR_FS_CATALOG_MODULES . $current_template .'/new_products.php',
        DIR_FS_CATALOG_MODULES . $current_template .'/product_listing_alpha_sorter.php',
        DIR_FS_CATALOG_MODULES . $current_template .'/upcoming_products.php',
    
		DIR_FS_CATALOG_TEMPLATES . $current_template . '/common/tpl_tabular_display.php',
		DIR_FS_CATALOG_TEMPLATES . $current_template . '/css/stylesheet_bookx.css',
		DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_index_product_list.php',
        DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_modules_upcoming_products.php',
       // DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_modules_whats_new.php',
    

		DIR_FS_CATALOG_TEMPLATES . 'template_default/sideboxes/tpl_bookx_filters_select.php',
		DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_bookx_authors_list_default.php',
		DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_bookx_publishers_list_default.php',
		DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_bookx_imprints_list_default.php',
    	DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_bookx_genres_list_default.php',
		DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_bookx_series_list_default.php',
		DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_product_bookx_info_display.php',
        DIR_FS_CATALOG_TEMPLATES . 'template_default/templates/tpl_bookx_products_next_previous.php',

		DIR_FS_ADMIN.'includes/languages/english/product_bookx.php',
		DIR_FS_ADMIN.'bookx_author_types.php',
		DIR_FS_ADMIN.'bookx_authors.php',
		DIR_FS_ADMIN.'bookx_binding.php',
		DIR_FS_ADMIN.'bookx_conditions.php',
		DIR_FS_ADMIN.'bookx_genres.php',
		DIR_FS_ADMIN.'bookx_imprints.php',
		DIR_FS_ADMIN.'bookx_printing.php',
		DIR_FS_ADMIN.'bookx_publishers.php',
		DIR_FS_ADMIN.'bookx_series.php',
		DIR_FS_ADMIN.'bookx_tools.php',
		DIR_FS_ADMIN.'includes/extra_datafiles/bookx_type_database_names.php',
		DIR_FS_ADMIN.'includes/extra_datafiles/bookx_type_filenames.php',
		DIR_FS_ADMIN.'includes/functions/extra_functions/product_bookx_functions.php',
		/*DIR_FS_ADMIN.'includes/modules/product_bookx/collect_info_metatags.php',*/
		DIR_FS_ADMIN.'includes/modules/product_bookx/collect_info.php',
		DIR_FS_ADMIN.'includes/modules/product_bookx/copy_to_confirm.php',
		DIR_FS_ADMIN.'includes/modules/product_bookx/delete_product_confirm.php',
		/*DIR_FS_ADMIN.'includes/modules/product_bookx/move_product_confirm.php',*/
		/*DIR_FS_ADMIN.'includes/modules/product_bookx/preview_info_meta_tags.php',*/
		DIR_FS_ADMIN.'includes/modules/product_bookx/preview_info.php',
		DIR_FS_ADMIN.'includes/modules/product_bookx/update_product.php',
		DIR_FS_ADMIN.'product_bookx.php'
		);

		// possibly overriden BookX files
		$template_default_overriden_files = array(
			DIR_FS_CATALOG_TEMPLATES . $current_template . '/sideboxes/tpl_bookx_filters_select.php',
			DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_bookx_authors_list_default.php',
			DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_bookx_series_list_default.php',
			DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_product_bookx_info_display.php'
		);

/*$overridden_files = array(
 DIR_FS_CATALOG_TEMPLATES . $current_template . '/common/tpl_tabular_display.php',
		DIR_FS_CATALOG_TEMPLATES . $current_template . '/templates/tpl_index_product_list.php'
);*/

/*
 DIR_FS_CATALOG.'includes/languages/english/product_bookx_info.php',
DIR_FS_CATALOG.'includes/languages/english/extra_definitions/product_bookx.php',

DIR_FS_ADMIN.'includes/languages/english/product_bookx.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_authors.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_author_types.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_binding.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_conditions.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_genres.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_imprints.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_printing.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_publishers.php',
DIR_FS_ADMIN.'includes/languages/english/bookx_series.php',
DIR_FS_ADMIN.'includes/languages/english/extra_definitions/product_bookx.php',*/

$available_languages = array('english', 'german');
$language_catalog_files = array('product_bookx_info.php','extra_definitions/product_bookx.php');

$language_admin_files = array('product_bookx.php',
		'bookx_authors.php',
		'bookx_author_types.php',
		'bookx_conditions.php',
		'bookx_genres.php',
		'bookx_imprints.php',
		'bookx_printing.php',
		'bookx_publishers.php',
		'bookx_series.php',
		'extra_definitions/product_bookx.php'
);


//=======================================
// INSTALL CHECK
//=======================================

// Test for existing installation
$sql = <<<EOT
     SELECT * FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler = 'product_bookx';
EOT;
$result = $db->Execute($sql); /* @var $result queryFactoryResult */
if ( 0 < $result->RecordCount()) {
	$already_installed = true;
	if($bookx_install != 'uninstall') {
		//$messageStack->add('' . BOOKX_MS_MODULE_ALREADY_INSTALLED .'', 'warning');
	}
} else {
	$already_installed = false;
}

// do not run installer on log in page
if(strpos($_SERVER['PHP_SELF'],'login.php'))
{
	$login_page = true;
	if (!$already_installed) {
		$_SESSION['bookx_install_delayed'] = true;
		$messageStack->add_session('BookX_delayed','success');
	}

} else {
	$login_page = false;

	//check that all files are where they should be
	foreach($required_files as $f) {
		if(!is_readable($f)) {
			$messageStack->add(BOOKX_MS_SOME_REQUIRED_FILES_MISSING . ' '.$f, 'error');
			//$install_incomplete = true;
		}
	}

	//check for overrides to template default
	foreach($template_default_overriden_files as $f) {
		if(is_readable($f)) {
			$messageStack->add(BOOKX_MS_FILE_SHOULD_ONLY_BE_OVERRIDE . ' '.$f, 'warning');
		}
	}

	///***** check if multiple languages are installed and which
	$multilanguage = false;
	$german_installed = false;

	$installed_languages = zen_get_languages();
	if(sizeof($installed_languages)) $multilanguage = true;

	for ($i=0, $n=sizeof($installed_languages); $i<$n; $i++) {
		if ('de' == $installed_languages[$i]['code']) $german_installed = true;
	}

	foreach ($available_languages as $language) {
		$files_missing = array();
		switch (true) {
		    case 'english' == $language:
		    case 'german' == $language && $german_installed:
        		foreach($language_catalog_files as $f) {
        			$f = DIR_FS_CATALOG_LANGUAGES . $language . '/' . $f;
        
        			if(!is_readable($f)) $files_missing[] = $f;
        		}
        
        		foreach($language_admin_files as $f) {
        			$f = DIR_FS_ADMIN . 'includes/languages/' . $language . '/' . $f;
        
        			if(!is_readable($f))  $files_missing[] = $f;
    		      }
    		      break;
		}
		if (!empty($files_missing)) {
			$messageStack->add('' . sprintf(BOOKX_MS_SOME_LANGUAGE_FILES_MISSING, $language) . '<br />'.implode(', ', $files_missing), 'caution');
		}
	}
}


//=======================================
// INSTALL / UPDATE / UNINSTALL
//=======================================

switch (true) {
	case ($bookx_install == 'update' AND !$login_page AND $already_installed):
		//** get installed version
		$sql = 'SELECT configuration_value AS version FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key = "BOOKX_VERSION";';
		$result = $db->Execute($sql); /* @var $result queryFactoryResult */

	    if (!$result->EOF) {
	    	$installed_version = $result->fields['version'];
	    } else {
	    	$installed_version = '0.9'; // some first BETA files had no version info
	    	$sql = 'REPLACE INTO ' . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
	    	VALUES ('BookX Version', 'BOOKX_VERSION', '0.9', 'BookX Version is stored but not editable', 0, 10000, NOW(), NOW(), NULL, NULL)";
	    	$db->Execute($sql);
	    }

	    $sql = "SELECT type_id FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler= 'product_bookx'";

	    $product_type = $db->Execute($sql);
	    $type_id = null;

	    while (!$product_type->EOF) {
	    	$type_id = $product_type->fields['type_id'];
	    	$product_type->MoveNext();
	    }

	    $sql = "SELECT configuration_group_id FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_title = 'BookX';";

	    $config_groups = $db->Execute($sql);
	    $cf_gid = null;

	    while (!$config_groups->EOF) {
	    	$cf_gid = $config_groups->fields['configuration_group_id'];
	    	$config_groups->MoveNext();
	    }

	    switch ($installed_version) {
	    	case '0.9':
	    		$sql = "SELECT IFNULL(column_name, '') FROM information_schema.columns WHERE table_name = '{$const['TABLE_PRODUCT_BOOKX_AUTHORS']}' AND column_name = 'author_default_type';";
	    		$result = $db->Execute($sql);

	    		if (0 == $result->RecordCount()) {
	    			$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHORS']} ADD author_default_type INT NULL DEFAULT NULL AFTER author_image;";
	    			$db->Execute($sql);
	    		}

	    		$sql = "SELECT IFNULL(column_name, '') FROM information_schema.columns WHERE table_name = '{$const['TABLE_PRODUCT_BOOKX_EXTRA']}' AND column_name = 'isbn';";
	    		$result = $db->Execute($sql);

	    		if (0 == $result->RecordCount()) {
	    			$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_EXTRA']} ADD isbn VARCHAR(13) NULL DEFAULT NULL AFTER size;";
	    		 	$db->Execute($sql);
	    		}


	    		//** fix default values for sort order fields
	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHORS']} CHANGE author_sort_order author_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_BINDING']} CHANGE binding_sort_order binding_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_CONDITIONS']} CHANGE condition_sort_order condition_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_GENRES']} CHANGE genre_sort_order genre_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_IMPRINTS']} CHANGE imprint_sort_order imprint_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_PRINTING']} CHANGE printing_sort_order printing_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS']} CHANGE publisher_sort_order publisher_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);

	    		$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_SERIES']} CHANGE series_sort_order series_sort_order INT( 11 ) NOT NULL DEFAULT '0';";
	    		$db->Execute($sql);



	    		//** fix typos in set function which prevented editing of layout values
	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']} SET set_function = \"" . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')))," .
	    				'" WHERE set_function = "' . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')))" . '";' ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']} SET set_function = \"" . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')))," .
	    				'" WHERE set_function = "' . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))" . '";' ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']} SET set_function = \"" . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')))," .
	    				'" WHERE set_function = "' . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))" . '";' ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']} SET set_function = \"" . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER')))," .
	    				'" WHERE set_function = "' . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER')))" . '";' ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']} SET set_function = \"" . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER')), array('id'=>'3', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_NAME')), array('id'=>'4', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_SORT_ORDER')))," .
	    				'" WHERE set_function = "' . "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'), array('id'=>'3', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_NAME')), array('id'=>'4', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_SORT_ORDER')))" . '";' ;
	    		$db->Execute($sql);

	    		// update texts for BOOKX_AUTHOR_IMAGE_MAX_HEIGHT & WIDTH
	    		$sql = "UPDATE {$const['TABLE_CONFIGURATION']}
	    		SET configuration_title = 'Product Info Page Author Photo: Maximum Height',
	    		configuration_description = '<br />Maximum height in pixels for author photo on product info page. A value of 0 will show all images at their actual size without any scaling.'
	    		WHERE configuration_key = 'BOOKX_AUTHOR_IMAGE_MAX_HEIGHT';" ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_CONFIGURATION']}
	    		SET configuration_title = 'Product Info Page Author Photo: Maximum Width',
	    		configuration_description = '<br />Maximum width in pixels for author photo on product info page. A value of 0 will show all images at their actual size without any scaling.',
	    		configuration_key = 'BOOKX_AUTHOR_IMAGE_MAX_WIDTH'
	    		WHERE configuration_key = 'BOOKX_AUTHOR_IMAGE_WIDTH';" ;
	    		$db->Execute($sql);

	    		if ($german_installed && defined(TABLE_CONFIGURATION_LANGUAGE)) {
		    		$sql = "UPDATE {$const['TABLE_CONFIGURATION_LANGUAGE']}
		    		SET configuration_title = 'Autorenbild auf Seite Artikeldetails: Maximale Höhe',
		    		configuration_description = '<br />Maximale Höhe (in Pixeln) des Autorenbilds auf der Seite Artikeldetails. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.'
		    		WHERE configuration_key = 'BOOKX_AUTHOR_IMAGE_MAX_HEIGHT' AND configuration_language_id = '43';" ;
		    		$db->Execute($sql);

		    		$sql = "UPDATE {$const['TABLE_CONFIGURATION_LANGUAGE']}
		    		SET configuration_title = 'Autorenbild auf Seite Artikeldetails: Maximale Breite',
		    		configuration_description = '<br />Maximale Breite (in Pixeln) des Autorenbilds auf der Seite Artikeldetails. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.',
		    		configuration_key = 'BOOKX_AUTHOR_IMAGE_MAX_WIDTH'
		    		WHERE configuration_key = 'BOOKX_AUTHOR_IMAGE_WIDTH' AND configuration_language_id = '43';" ;
		    		$db->Execute($sql);
	    		}

	    		// update SHOW_PRODUCT_BOOKX_LISTING_MODEL
	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']}
	    		SET configuration_title = 'Product Listing: Show Model Number',
	    		configuration_description = 'Display Model Number on Product Listing.'
	    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_LISTING_MODEL';" ;
	    		$db->Execute($sql);

	    		if ($german_installed && defined(TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE)) {
		    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
		    		SET configuration_title = 'Artikelliste: Artikelnummer anzeigen',
		    		configuration_description = 'Artikelnummer in der Artikelliste anzeigen.'
		    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_LISTING_MODEL' AND languages_id = '43';" ;
		    		$db->Execute($sql);
	    		}

	    		// update SHOW_PRODUCT_BOOKX_INFO_MODEL
	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']}
	    		SET configuration_title = 'Product Detail: Show Model Number',
	    		configuration_description = 'Display Model Number on Product Info.'
	    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_MODEL';" ;
	    		$db->Execute($sql);

	    		if ($german_installed && defined(TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE)) {
		    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
		    		SET configuration_title = 'Artikeldetails: Artikelnummer anzeigen',
		    		configuration_description = 'Soll auf der Produktseite die Artikelnummer anzeigt werden <br/> '
		    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_MODEL' AND languages_id = '43';" ;
		    		$db->Execute($sql);
	    		}


	    		//*** these will be removed until it is clear what they are used for
	    		$sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT']}
	    				WHERE configuration_key IN ('SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_TITLE_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_SUBTITLE_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_MODEL_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRICE_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_AUTHOR_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_PUBLISHER_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_GENRE_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_SERIES_STATUS'
	    									,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_IMPRINT_STATUS'
	    									)";
	    		$db->Execute($sql);
                if (defined(TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE)) {
    	    		$sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
    				    		WHERE configuration_key IN ('SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_TITLE_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_SUBTITLE_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_MODEL_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRICE_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_AUTHOR_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_PUBLISHER_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_GENRE_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_SERIES_STATUS'
    				    		,'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_IMPRINT_STATUS'
    				    		)";
    	    		$db->Execute($sql);
                }

	    		/* not needed until use of meta tag options is clear

	    		 // update SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_NAME_STATUS
	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']}
	 	    			SET configuration_title = 'Show Metatags Title Default - Product Title',
	 	    			    configuration_description = 'Display Book Title in Meta Tags Title.'
	    				WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_NAME_STATUS';" ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
	    		SET configuration_title = 'Metatag Titel Standardeinstellung - Buchtitel',
	    		configuration_description = 'Soll der Buchtitel im Metatag Titel angezeigt werden<br/>'
	    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_NAME_STATUS' AND languages_id = '43';" ;
	    		$db->Execute($sql);

	    		// update SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS
	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']}
	    		SET configuration_title = 'Show Metatags Title Default - Website Title',
	    		configuration_description = 'Display Website Title in Meta Tags Title.'
	    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS';" ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
	    		SET configuration_title = 'Metatag Titel Standardeinstellung - Webseitentitel',
	    		configuration_description = 'Soll der Titel der Webseite im Metatag Titel angezeigt werden<br/>'
	    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS' AND languages_id = '43';" ;
	    		$db->Execute($sql);

	    		// update SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS
	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT']}
	    		SET configuration_title = 'Show Metatags Title Default - Website Tagline'
	    		configuration_description = 'Display Website Tagline in Meta Tags Title.',
	    		sort_order = '505'
	    		WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS';" ;
	    		$db->Execute($sql);

	    		$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
	    		SET configuration_title = 'Metatag Titel Standardeinstellung - Webseiten-Tagline',
    			configuration_description = 'Soll die Tagline der Webseite im Metatag Titel angezeigt werden<br/>'
    			WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS' AND languages_id = '43';" ;
    			$db->Execute($sql);*/

	    		// insert
    			if (!empty($type_id)) {
		    		$sql = <<<EOT
		    		REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT']} (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, last_modified, date_added, use_function, set_function )
	                              VALUES
	                        ('Product Listing: Show ISBN', 'SHOW_PRODUCT_BOOKX_LISTING_ISBN', '1', 'Display ISBN on Product Listing.', {$type_id}, '15', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),")
                            ,('Product Detail: Show ISBN', 'SHOW_PRODUCT_BOOKX_INFO_ISBN', '1', 'Display ISBN on Product Info.', {$type_id}, '277', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),")
                            ,('Product Listing: Show only Authors with Type Sort Oder below', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_WITH_TYPE_BELOW_SORT_ORDER', '1000', 'Display only Authors on Product Listing which are of an Author Type with a Sort Order smaller than this value. Example: Default value of "1000" means that authors of type e.g. "Illustrator" will not be shown on product listing, if the author type "Illustrator" has a sort order of "1000" or greater. This way multiple authors can be given more or less "importance". If you enter a value "0" then this setting is ignored.', {$type_id}, '122', now(), now(), NULL, NULL)
		                    ,('Filter Sidebox - Link to Author List', 'SHOW_PRODUCT_BOOKX_LINK_AUTHOR_LIST', '1', 'Show a link to display the list of all Authors in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		                    ,('Filter Sidebox - Link to Series List', 'SHOW_PRODUCT_BOOKX_LINK_SERIES_LIST', '1', 'Show a link to display the list of all Seies in the Bookx Filter Sidebox.', {$type_id}, '696', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")

	                       #ignored ,('Show Metatags Title Default - Product Title', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_TITLE_STATUS', '1', 'Display Product Title in Meta Tags Title.', {$type_id}, '510', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),")
	                       #ignored ,('Show Metatags Title Default - Product Subtitle', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_SUBTITLE_STATUS', '1', 'Display Product Subtitle in Meta Tags Title.', {$type_id}, '515', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),")
							;
EOT;
		    		$db->Execute($sql);

		    		if ($german_installed) {
			    		$sql = <<<EOT
	                        REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']} (configuration_title, configuration_key, languages_id, configuration_description, last_modified, date_added)
	                              VALUES
	                        	  ('Artikelliste: ISBN anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_ISBN', 43, 'ISBN in der Artikelliste anzeigen.', now(), now())
	                        	  ,('Artikeldetails: ISBN anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_ISBN', 43, 'Soll auf der Produktseite die ISBN anzeigt werden <br/> ', now(), now())
	                        	  ,('Artikelliste: nur Autoren anzeigen mit Typ Sortierung unter', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_WITH_TYPE_BELOW_SORT_ORDER', 43, 'Nur solche Autoren auf der Artikelliste anzeigen, die einen Autorentyp haben, dessen Sortierung kleiner ist als der hier eingestellte Wert. Beispiel: Grundeinstellung "1000" bedeutet, dass ein Autor mit dem Typ "Illustrator" in der Artikelliste nicht angezeigt wird, wenn der Autorentyp eine Sortierung von "1000" oder mehr hat. So kann man die Autorentypen priorisieren, und z.B. nur einen "Hauptautor" in der Artikelliste anzeigen lassen. Bei einem Wert von "0" wird diese Einstellung ignoriert.', now(), now())
	                        	  ,('Filter Sidebox - Link zur Autorenliste', 'SHOW_PRODUCT_BOOKX_LINK_AUTHOR_LIST', '43', 'Link zur Liste aller Autoren in der Bookx Filter Sidebox anzeigen.', now(), now())
			                      ,('Filter Sidebox - Link zur Serienliste', 'SHOW_PRODUCT_BOOKX_LINK_SERIES_LIST', '43', 'Link zur Liste aller Serien in der Bookx Filter Sidebox anzeigen.', now(), now())

	                             #ignored ,('Metatag Titel Standardeinstellung - Buchtitel', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_TITLE_STATUS', 43, 'Soll der Buchtitel im Metatag Titel angezeigt werden<br/>', now(), now())
	                        	 #ignored ,('Metatag Titel Standardeinstellung - Untertitel', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_SUBTITLE_STATUS', 43, 'Soll der Untertitel im Metatag Titel angezeigt werden<br/>', now(), now())
	                        	  ;
EOT;
		    			$db->Execute($sql);
		    		}

    			} else {
    				$messageStack->add(BOOKX_MS_PRODUCT_TYPE_BOOKX_MISSING, 'error');
    			}

    			if (!empty($cf_gid)) {
		    		$sql = <<<EOT
				    	REPLACE INTO {$const['TABLE_CONFIGURATION']} (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
				    		VALUES
				    		 ('Author Listing: Max. number of Authors per page', 'MAX_DISPLAY_BOOKX_AUTHOR_LISTING', '30', '<br />Maximum number of listed authors on author listing. No value defaults to 20 rows per page.', {$cf_gid}, 145, NOW(), NOW(), NULL, NULL)
				    		,('Author Listing Photo: Maximum Height', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for author photo on author listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 150, NOW(), NOW(), NULL, NULL)
						    ,('Author Listing Photo: Maximum Width', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for author photo on author listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 160, NOW(), NOW(), NULL, NULL)
						    ,('Series Listing: Max. number of Series per page', 'MAX_DISPLAY_BOOKX_SERIES_LISTING', '30', '<br />Maximum number of listed series on series listing. No value defaults to 20 rows per page.', {$cf_gid}, 170, NOW(), NOW(), NULL, NULL)
		    				,('Series Listing Image: Maximum Height', 'BOOKX_SERIES_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for series image on series listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 180, NOW(), NOW(), NULL, NULL)
		    				,('Series Listing Image: Maximum Width', 'BOOKX_SERIES_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for series image on series listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 190, NOW(), NOW(), NULL, NULL)
						    ;
EOT;
		    		$db->Execute($sql);

		    		if ($german_installed) {
			    		$sql = <<<EOT
			    			INSERT INTO {$const['TABLE_CONFIGURATION_LANGUAGE']} (configuration_title, configuration_key, configuration_description, configuration_language_id)
			    				VALUES
								 ('Autorenliste: Anzahl Autoren pro Seite', 'MAX_DISPLAY_BOOKX_AUTHOR_LISTING', '<br />Maximale Anzahl von Autoren pro Seite in der Autorenliste. Bei "0" oder keinem Wert, werden 20 Autoren pro Seite angezeigt.', 43)
			    				,('Autorenbild in Autorenliste: Maximale Höhe', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Autorenbilds in der Liste aller Autoren. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
							    ,('Autorenbild in Autorenliste: Maximale Breite', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Autorenbilds in der Liste aller Autoren. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
							    ,('Serienliste: Anzahl Serien pro Seite', 'MAX_DISPLAY_BOOKX_SERIES_LISTING', '<br />Maximale Anzahl von Serien pro Seite in der Serienliste. Bei "0" oder keinem Wert, werden 20 Serien pro Seite angezeigt.', 43)
			    				,('Serienbild in Serienliste: Maximale Höhe', 'BOOKX_SERIES_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Serienbilds in der Liste aller Serien. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    				,('Serienbild in Serienliste: Maximale Breite', 'BOOKX_SERIES_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Serienbilds in der Liste aller Serien. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    				;
EOT;
		    			$db->Execute($sql);
		    		}
    			}
			// we don't break here

	    	case '0.9.1':
	    		// insert
	    		if (!empty($cf_gid)) {
	    			$sql = <<<EOT
					REPLACE INTO {$const['TABLE_CONFIGURATION']} (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
					    		VALUES
						    	 ('New Products: Base on Publication Date', 'BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS', '90', 'Base "New Products" List on publication date. Enter number of days to look back in time for published books. A value of "0" turns off this option. Example: Default value of "90" will list all books with publication dates within the last 90 days. Note: If you use partial publication dates in the format "2013-04-00" to only indicate the month of publication, these dates are considered to be at the <u>beginning</u> of the month.<br /><br />', {$cf_gid}, 200, NOW(), NOW(), NULL, NULL)
							    ,('Upcoming Products: Base on Publication Date', 'BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS', '180', 'Base "Upcoming Products" List on publication date instead of date available. Enter number of days to look ahead in time for books to be published. A value of "0" turns off this option. Example: Default value of "180" will list all books with publication dates within the next 180 days. Note: If you use partial publication dates in the format "2013-04-00" to only indicate the month of publication, these dates are considered to be at the <u>beginning</u> of the month.<br /><br />', {$cf_gid}, 210, NOW(), NOW(), NULL, NULL)
		    					,('Author Listing: Show only authors of stocked books', 'BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those authors in the author listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the author listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 165,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    					,('Author Listing: Sort authors by', 'BOOKX_AUTHOR_LISTING_ORDER_BY', '1', '<br />Sort authors in listing by:', {$cf_gid}, 167,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    					,('Series Listing: Show only series with stocked books', 'BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those series in the series listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the series listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 195,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    					,('Series Listing: Sort series by', 'BOOKX_SERIES_LISTING_ORDER_BY', '1', '<br />Sort series in series listing by:', {$cf_gid}, 197,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    					;
EOT;
	    			$db->Execute($sql);

	    			if ($german_installed) {
		    			$sql = <<<EOT
	 					REPLACE INTO {$const['TABLE_CONFIGURATION_LANGUAGE']} (configuration_title, configuration_key, configuration_description, configuration_language_id)
						    		VALUES
						    		('Neue Artikel: Auswahl durch Erscheinungsdatum', 'BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS', '"Neue Artikel" werden nach Erscheinungsdatum ausgewählt. Ein Wert von "0" schaltet diese Option aus. Beispiel: Der Standardwert von "90" listet alle Bücher auf, deren Erscheinungsdatum innerhalb den letzten 90 Tage liegt. Achtung: Wenn unvollständige Erscheinungsdaten im Format "2013-04-00" verwendet werden, um nur den Erscheinungsmonat anzugeben, dann wird dieses Erscheinugsdatum am <u>Anfang</u> des Monats verortet.', 43)
						    		,('Artikelankündigungen: Auswahl durch Erscheinungsdatum', 'BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS', '<br />"Artikelankündigungen" werden nach Erscheinungsdatum ausgewählt. Ein Wert von "0" schaltet diese Option aus. Beispiel: Der Standardwert von "180" listet alle Bücher auf, deren Erscheinungsdatum innerhalb der nächsten 180 Tage liegt. Achtung: Wenn unvollständige Erscheinungsdaten im Format "2013-04-00" verwendet werden, um nur den Erscheinungsmonat anzugeben, dann wird dieses Erscheinugsdatum am <u>Anfang</u> des Monats verortet.', 43)
			    					,('Autorenliste: Nur lieferbare Bücher zeigen', 'BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED', '<br />In der Autorenliste nur Autoren anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Autenliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Autoren ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    					,('Autorenliste: Autoren sortieren nach:', 'BOOKX_AUTHOR_LISTING_ORDER_BY', '<br />Autoren in der Autorenliste werden sortiert nach:', 43)
	 								,('Serienliste: Nur lieferbare Bücher zeigen', 'BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED', '<br />In der Liste aller Serien nur Serien anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Autenliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Autoren ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    					,('Serienliste: Serien sortieren nach:', 'BOOKX_SERIES_LISTING_ORDER_BY', '<br />Serien in der Serienliste werden sortiert nach:', 43)
	 							;
EOT;
		    			$db->Execute($sql);
	    			}
	    		} else {
	    			$messageStack->add(BOOKX_MS_PRODUCT_TYPE_BOOKX_MISSING, 'error');
	    		}
	    		// we don't break here

	    		case '0.9.2':
	        		if (!empty($type_id)) {
			    		$sql = <<<EOT
			    		REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT']} (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, last_modified, date_added, use_function, set_function )
	                              VALUES
                             ('Product Listing: Group Products by availability', 'GROUP_PRODUCT_BOOKX_LISTING_BY_AVAILABILITY', '1', 'Group products in any product listing according to availability. Order: <br />1) Upcoming products <br />2) New products <br />3) Published / available products 4) Out of print <br /><br />Criteria for "new" and "upcoming" books are set in Admin -> Configuration -> BookX Configuration.', {$type_id}, '150', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
                             ;
EOT;
		    		$db->Execute($sql);

			    	if ($german_installed) {
			    		$sql = <<<EOT
	                        REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']} (configuration_title, configuration_key, languages_id, configuration_description, last_modified, date_added)
	                              VALUES
	                        	('Artikelliste: Bücher nach Lieferbarkeit gruppieren', 'GROUP_PRODUCT_BOOKX_LISTING_BY_AVAILABILITY', 43, 'Gruppiere Bücher in Artikelliste nach Lieferbarkeit: Reihenfolge: <br />1) Noch nicht lieferbare Bücher <br />2) Neue Bücher <br />3) Lieferbare Bücher <br />4) Vergriffene Bücher  <br /><br />Kriterien für "Neue" und "noch nicht lieferbare" Bücher werden einegstellt unter Admin -> Konfiguration -> BookX.', now(), now())

	                        	;
EOT;
		    			$db->Execute($sql);
			    	}
    			} else {
    				$messageStack->add(BOOKX_MS_PRODUCT_TYPE_BOOKX_MISSING, 'error');
    			}

	    			// we don't break here

	    			case '0.9.3':
			    	    if (defined('TABLE_ADMIN_PAGES') && defined('TABLE_ADMIN_PAGES_TO_PROFILES')) {
			    	    	zen_register_admin_page('bookxProduct', 'BOX_CATALOG_PRODUCT_BOOKX', 'FILENAME_BOOKX_PRODUCT', '', 'catalog', 'Y', 2);

					        $sql = "SELECT profile_id FROM {$const['TABLE_ADMIN_PAGES_TO_PROFILES']} WHERE page_key = 'product'";
					        $profile_ids = $db->Execute($sql);

					         while (!$profile_ids->EOF) {
					         	$db->Execute("REPLACE INTO {$const['TABLE_ADMIN_PAGES_TO_PROFILES']} (profile_id, page_key) VALUES ('{$profile_ids->fields['profile_id']}', 'bookxProduct')");
					         	$profile_ids->MoveNext();
					         }
	    				}
	    				
	    				$sql = "REPLACE INTO {$const['TABLE_GET_TERMS_TO_FILTER']} (get_term_name, get_term_table, get_term_name_field) VALUES ('bookx_author_type_id', 'TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION', 'type_description');";
	    				$db->Execute($sql);
	    				 
	    				$sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHORS']} ADD author_image_copyright VARCHAR(64) NULL DEFAULT NULL AFTER author_image;";
	    				$db->Execute($sql);

	    				$sql = "CREATE INDEX bookx_author_id_index ON {$const['TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS']} (bookx_author_id)";
	    				$db->Execute($sql);

	    				$sql = "CREATE INDEX products_id_index ON {$const['TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS']} (products_id)";
	    				$db->Execute($sql);

	    				//*** correct meaningless date entries
	    				$sql = "UPDATE {$const['TABLE_PRODUCTS']} SET products_date_available = null WHERE products_date_available = '0000-00-00 00:00:00'";
	    				$db->Execute($sql);
	    				
	    				//*** correct sort oder, make room for more settings
	    				$sql = "UPDATE {$const['TABLE_CONFIGURATION']} SET sort_order = 178 WHERE configuration_key = 'MAX_DISPLAY_BOOKX_SERIES_LISTING'";
	    				$db->Execute($sql);
	    				$sql = "UPDATE {$const['TABLE_CONFIGURATION']} SET sort_order = 192 WHERE configuration_key = 'BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED'";
	    				$db->Execute($sql);
	    				$sql = "UPDATE {$const['TABLE_CONFIGURATION']} SET sort_order = 193 WHERE configuration_key = 'BOOKX_SERIES_LISTING_ORDER_BY'";
	    				$db->Execute($sql);

	    				if (!empty($cf_gid)) {
	    					$sql = <<<EOT
								REPLACE INTO {$const['TABLE_CONFIGURATION']} (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
					    			VALUES
							    	 	('New Products: Show Product Description', 'BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', '150', 'Show (part of) the product description in the "New Products" module. Enter the number of characters after which the description will be truncated. A value of "0" disables the display and a value of "-1" shows the entire description without truncating it.<br /><br />', {$cf_gid}, 201, NOW(), NOW(), NULL, NULL)
									   ,('Upcoming Products: Show Product Image', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_IMAGE', '1', 'Show product image in "Upcoming Products" module', {$cf_gid}, 220, NOW(), NOW(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
									   ,('Upcoming Products Image: Maximum Height', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_HEIGHT', '120', '<br />Maximum height in pixels for product images in upcoming products module. A value of 0 will not constrain the height of the image.', {$cf_gid}, 222, NOW(), NOW(), NULL, NULL)
									   ,('Upcoming Products Image: Maximum Width', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_WIDTH', '80', '<br />Maximum width in pixels for product images in upcoming products module. A value of 0 will not constrain the width of the image.', {$cf_gid}, 223, NOW(), NOW(), NULL, NULL)
									   ,('Upcoming Products: Show Product Description', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', '150', 'Show (part of) the product description in the "Upcoming Products" module. Enter the number of characters after which the description will be truncated. A value of "0" disables the display and a value of "-1" shows the entire description without truncating it.<br /><br />', {$cf_gid}, 230, NOW(), NOW(), NULL, NULL)
                            		    ,('Imprint Listing: Max. number of imprints per page', 'MAX_DISPLAY_BOOKX_IMPRINT_LISTING', '30', '<br />Maximum number of listed imprints on imprint listing. No value defaults to 20 rows per page.', {$cf_gid}, 168, NOW(), NOW(), NULL, NULL)
                            		    ,('Imprint Listing Logo: Maximum Height', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for imprint logo on imprint listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 169, NOW(), NOW(), NULL, NULL)
                            		    ,('Imprint Listing Logo: Maximum Width', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for imprint logo on imprint listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 170, NOW(), NOW(), NULL, NULL)
                            		    ,('Imprint Listing: Show only imprints with books in stock', 'BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those imprints in the imprint listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the imprint listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 171,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
                            		    ,('Imprint Listing: Sort imprints by', 'BOOKX_IMPRINT_LISTING_ORDER_BY', '1', '<br />Sort imprints in imprint listing by:', {$cf_gid}, 172,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
                            		    ,('Publisher Listing: Max. number of publishers per page', 'MAX_DISPLAY_BOOKX_PUBLISHER_LISTING', '30', '<br />Maximum number of listed publishers on publisher listing. No value defaults to 20 rows per page.', {$cf_gid}, 173, NOW(), NOW(), NULL, NULL)
                            		    ,('Publisher Listing Logo: Maximum Height', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for publisher logo on publisher listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 174, NOW(), NOW(), NULL, NULL)
                            		    ,('Publisher Listing Logo: Maximum Width', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for publisher logo on publisher listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 175, NOW(), NOW(), NULL, NULL)
                            		    ,('Publisher Listing: Show only publishers with books in stock', 'BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those publishers in the publisher listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the publisher listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 176,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
                            		    ,('Publisher Listing: Sort publishers by', 'BOOKX_PUBLISHER_LISTING_ORDER_BY', '1', '<br />Sort publishers in publisher listing by:', {$cf_gid}, 177,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
                            		    ,('Genre Listing: Max. number of genres per page', 'MAX_DISPLAY_BOOKX_GENRE_LISTING', '30', '<br />Maximum number of listed genres on genre listing. No value defaults to 20 rows per page.', {$cf_gid}, 195, NOW(), NOW(), NULL, NULL)
                            		    ,('Genre Listing Image: Maximum Height', 'BOOKX_GENRE_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for genre image on genre listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 196, NOW(), NOW(), NULL, NULL)
                            		    ,('Genre Listing Image: Maximum Width', 'BOOKX_GENRE_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for genre image on genre listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 197, NOW(), NOW(), NULL, NULL)
                            		    ,('Genre Listing: Show only genres with books in stock', 'BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those genres in the genre listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the genre listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 198,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
                            		    ,('Genre Listing: Sort genres by', 'BOOKX_GENRE_LISTING_ORDER_BY', '1', '<br />Sort genres in genre listing by:', {$cf_gid}, 198,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
                            		        
                            		        ;
EOT;
	    					$db->Execute($sql);

	    					if ($german_installed) {
	    						$sql = <<<EOT
		 							REPLACE INTO {$const['TABLE_CONFIGURATION_LANGUAGE']} (configuration_title, configuration_key, configuration_description, configuration_language_id)
							    	  VALUES
								    	 ('Neue Artikel: Artikelbeschreibung anzeigen', 'BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', 'Im Modul "Neue Artikel" soll die Artikelbeschreibung (teilweise) angezeigt werden. Anzahl der Zeichen nach denen die Beschreibung abgeschnitten wird. Bei einem Wert von "0" wird die Beschreibung nicht angezeigt und bei einem Wert von "-1" wird die gesamte Beschreibung ungekürzt angezeigt.<br /><br />', 43)
								    	,('Artikelankündigungen: Artikelbild anzeigen', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_IMAGE', 'Im Modul "Artikelankündigungen" soll das Artikelbild angezeigt werden.<br /><br />', 43)
									    ,('Artikelankündigungen Artikelbild: Maximale Höhe', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) der Artikelbilder im Modul „Artikelankündigungen”. Bei einem Wert von 0 wird die Höhe der Bilder nicht begrenzt.', 43)
									    ,('Artikelankündigungen Artikelbild: Maximale Breite', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) der Artikelbilder in der Liste aller Serien. Bei einem Wert von 0 wird die Breite der Bilder nicht begrenzt.', 43)
		 								,('Artikelankündigungen: Artikelbeschreibung anzeigen', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', 'Im Modul "Artikelankündigungen" soll die Artikelbeschreibung (teilweise) angezeigt werden. Anzahl der Zeichen nach denen die Beschreibung abgeschnitten wird. Bei einem Wert von "0" wird die Beschreibung nicht angezeigt und bei einem Wert von "-1" wird die gesamte Beschreibung ungekürzt angezeigt.<br /><br />', 43)
                        			    ,('Unterlabelliste: Anzahl Unterlabel pro Seite', 'MAX_DISPLAY_BOOKX_IMPRINT_LISTING', '<br />Maximale Anzahl von Unterlabel pro Seite in der Unterlabelliste. Bei "0" oder keinem Wert, werden 20 Unterlabel pro Seite angezeigt.', 43)
                        			    ,('Unterlabellogo in Unterlabelliste: Maximale Höhe', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Unterlabellogos in der Liste aller Unterlabel. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
                        			    ,('Unterlabellogo in Unterlabelliste: Maximale Breite', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Unterlabellogos in der Liste aller Unterlabel. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
                        			    ,('Unterlabelliste: Nur lieferbare Bücher zeigen', 'BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED', '<br />In der Unterlabelliste nur Unterlabel anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Unterlabelliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Unterlabel ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
                        			    ,('Unterlabelliste: Unterlabel sortieren nach:', 'BOOKX_IMPRINT_LISTING_ORDER_BY', '<br />Unterlabel in der Unterlabelliste werden sortiert nach:', 43)
                        			    ,('Verlagsliste: Anzahl Verlage pro Seite', 'MAX_DISPLAY_BOOKX_PUBLISHER_LISTING', '<br />Maximale Anzahl von Verlagen pro Seite in der Verlagsliste. Bei "0" oder keinem Wert, werden 20 Verlage pro Seite angezeigt.', 43)
                        			    ,('Verlagslogo in Verlagsliste: Maximale Höhe', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Verlagslogos in der Liste aller Verlage. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
                        			    ,('Verlagslogo in Verlagsliste: Maximale Breite', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Verlagslogos in der Liste aller Verlage. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
                        			    ,('Verlagsliste: Nur lieferbare Bücher zeigen', 'BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED', '<br />In der Verlagsliste nur Verlage anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Verlagsliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Verlage ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
                        			    ,('Verlagsliste: Verlage sortieren nach:', 'BOOKX_PUBLISHER_LISTING_ORDER_BY', '<br />Verlage in der Verlagsliste werden sortiert nach:', 43)
                        		        ,('Genreliste: Anzahl Genres pro Seite', 'MAX_DISPLAY_BOOKX_GENRE_LISTING', '<br />Maximale Anzahl von Genres pro Seite in der Genreliste. Bei "0" oder keinem Wert, werden 20 Genres pro Seite angezeigt.', 43)
                        			    ,('Genrelogo in Genreliste: Maximale Höhe', 'BOOKX_GENRE_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Genrelogos in der Liste aller Genres. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
                        			    ,('Genrelogo in Genreliste: Maximale Breite', 'BOOKX_GENRE_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Genrelogos in der Liste aller Genres. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
                        			    ,('Genreliste: Nur lieferbare Bücher zeigen', 'BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED', '<br />In der Genreliste nur Genres anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Genreliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Genres ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
                        			    ,('Genreliste: Genres sortieren nach:', 'BOOKX_GENRE_LISTING_ORDER_BY', '<br />Genres in der Genreliste werden sortiert nach:', 43)		 							    
		 							    ;
EOT;
	    						
	    						$db->Execute($sql);    				
	    							    						
	    					}
	    				} else {
	    					$messageStack->add(BOOKX_MS_CONFIG_TYPE_BOOKX_MISSING, 'error');
	    				}

	    				if (!empty($type_id)) {
	    					if ($german_installed) {
	    						$sql = "UPDATE {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']}
	    						SET configuration_title = 'Artikelliste: Bandnummer anzeigen',
	    						configuration_description = 'Bandnummer in der Artikelliste anzeigen.'
	    						WHERE configuration_key = 'SHOW_PRODUCT_BOOKX_LISTING_VOLUME' AND languages_id = '43';" ;
	    						$db->Execute($sql);
	    					}
	    					
	    					$sql = <<<EOT
			    				REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT']} (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, last_modified, date_added, use_function, set_function )
	                              VALUES
		                                ('Filter Sidebox - Filter Author Type', 'SHOW_PRODUCT_BOOKX_FILTER_AUTHOR_TYPE', '1', 'Display a filter for Author Type in the Bookx Filter Sidebox.', {$type_id}, '655', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		                                ,('Filter Sidebox - Link to Imprint List', 'SHOW_PRODUCT_BOOKX_LINK_IMPRINT_LIST', '1', 'Show a link to display the list of all Imprints in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		                                ,('Filter Sidebox - Link to Publisher List', 'SHOW_PRODUCT_BOOKX_LINK_PUBLISHER_LIST', '1', 'Show a link to display the list of all Publishers in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		                                ,('Filter Sidebox - Link to Genres List', 'SHOW_PRODUCT_BOOKX_LINK_GENRES_LIST', '1', 'Show a link to display the list of all Genres in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		                                ,('Filter Sidebox - Allow multiple filters active', 'ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE', '0', 'Allow multiple filters to be active in the Bookx Filter Sidebox. Otherwise setting one filter will cancel the previous filter. EXCEPT: The combination of filters "Author" and "Author Type" is always enabled.', {$type_id}, '699', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		                                    ;
EOT;
	    					$db->Execute($sql);

	    					if ($german_installed) {
	    						$sql = <<<EOT
	                        REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']} (configuration_title, configuration_key, languages_id, configuration_description, last_modified, date_added)
	                              VALUES
								    	 ('Filter Sidebox - Link zur Autorenliste', 'SHOW_PRODUCT_BOOKX_LINK_AUTHOR_LIST', '43', 'Link zur Liste aller Autoren in der Bookx Filter Sidebox anzeigen.', now(), now())
	                                    ,('Filter Sidebox - Link zur Serienliste', 'SHOW_PRODUCT_BOOKX_LINK_SERIES_LIST', '43', 'Link zur Liste aller Serien in der Bookx Filter Sidebox anzeigen.', now(), now())
                                        ,('Filter Sidebox - Link zur Unterlabelliste', 'SHOW_PRODUCT_BOOKX_LINK_IMPRINT_LIST', '43', 'Link zur Liste aller Unterlabelliste in der Bookx Filter Sidebox anzeigen.', now(), now())
                                        ,('Filter Sidebox - Link zur Verlagsliste', 'SHOW_PRODUCT_BOOKX_LINK_PUBLISHER_LIST', '43', 'Link zur Liste aller Verlage in der Bookx Filter Sidebox anzeigen.', now(), now())
                           		        ,('Filter Sidebox - Link zur Genreliste', 'SHOW_PRODUCT_BOOKX_LINK_GENRES_LIST', '43', 'Link zur Liste aller Genres in der Bookx Filter Sidebox anzeigen.', now(), now())                            
                                        ,('Filter Sidebox - Mehrere Filter zulassen', 'ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE', '43', 'Erlaubt es, mehrere Filter in der Bookx Filter Sidebox zu setzen. Anderfalls ersetzt eine Filterauswahl einen ggf. vorher gesetzten Filter. AUSNAHME: Die Kombination der Filter "Autor" und "Autorentyp" ist immer erlaubt.', now(), now())
	                            ;
EOT;
	    						$db->Execute($sql);
	    					}
	    				} else {
	    					$messageStack->add(BOOKX_MS_PRODUCT_TYPE_BOOKX_MISSING, 'error');
	    				}

	    				// we don't break here
	    				
	    				case '0.9.4':
	    				    
	    				    $sql = "UPDATE {$const['TABLE_GET_TERMS_TO_FILTER']} SET get_term_table = 'TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION' WHERE get_term_table = 'TABLE_PRODUCT_BOOKX_BINDING';";
	    				    $db->Execute($sql);

	    				    $sql = "UPDATE {$const['TABLE_GET_TERMS_TO_FILTER']} SET get_term_table = 'TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION' WHERE get_term_table = 'TABLE_PRODUCT_BOOKX_CONDITIONS';";
	    				    $db->Execute($sql);
	    				    
	    				    $sql = "UPDATE {$const['TABLE_GET_TERMS_TO_FILTER']} SET get_term_table = 'TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION' WHERE get_term_table = 'TABLE_PRODUCT_BOOKX_PRINTING';";
	    				    $db->Execute($sql);

	    				    $sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS']} ADD INDEX ( products_id );";
                            $db->Execute($sql);

                            $sql = "ALTER TABLE {$const['TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS']} ADD INDEX ( bookx_genre_id );";
                            $db->Execute($sql);

                            if (!empty($cf_gid)) {
	    				        $sql = <<<EOT
								REPLACE INTO {$const['TABLE_CONFIGURATION']} (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
					    			VALUES
							    	 	 ('Breadcrumbs: Use Bookx instead of ZC Categories', 'BOOKX_BREAD_USE_BOOKX_NO_CATEGORIES', '1', 'Let BookX fill the "Breadcrumb" navigation instead of letting ZenCart populate the "Breadcrumb" navigation with the category path. This only affects the product info page for BookX products or product listings resulting from applying a BookX filter.', {$cf_gid}, 240, NOW(), NOW(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
                            		    ,('Breadcrumbs: Insert Publisher on Product Detail Page', 'BOOKX_BREAD_ADD_PUBLISHER', '10', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Publisher and a number above zero determines the order in which the Publisher is inserted in the "Breadcrumb" navigation trail.', {$cf_gid}, 250, NOW(), NOW(), NULL, NULL)
                            		    ,('Breadcrumbs: Insert Imprint on Product Detail Page', 'BOOKX_BREAD_ADD_IMPRINT', '20', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Imprint and a number above zero determines the order in which the Imprint is inserted in the "Breadcrumb" navigation trail.', {$cf_gid}, 260, NOW(), NOW(), NULL, NULL)
                            		    ,('Breadcrumbs: Insert Series on Product Detail Page', 'BOOKX_BREAD_ADD_SERIES', '30', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Series and a number above zero determines the order in which the Series is inserted in the "Breadcrumb" navigation trail.', {$cf_gid}, 270, NOW(), NOW(), NULL, NULL)
                            		    ,('Breadcrumbs: Insert Genre on Product Detail Page', 'BOOKX_BREAD_ADD_GENRE', '0', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Genre and a number above zero determines the order in which the Genre is inserted in the "Breadcrumb" navigation trail. ATTENTION: This may produce unexpected results when multiple Genres are assigned to a book, as only one Genre can be shown.', {$cf_gid}, 280, NOW(), NOW(), NULL, NULL)
                            		    ,('Breadcrumbs: Insert Author on Product Detail Page', 'BOOKX_BREAD_ADD_AUTHOR', '0', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Author and a number above zero determines the order in which the Author is inserted in the "Breadcrumb" navigation trail. ATTENTION: This may produce unexpected results when multiple Authors are assigned to a book, as only one author can be show.', {$cf_gid}, 290, NOW(), NOW(), NULL, NULL)					    				    				
		                                ,('Product Info: "Previous"/"Next Buttons" based on active BookX Filter', 'BOOKX_NEXT_PREVIOUS_BASED_ON_FILTER', '1', 'If this feature is enabled, then the buttons "next", "previous", "back to listing" on the product info page will no longer navigate back an fourth in the ZC <strong>Category</b> containing the product, but rather navigate within the set of products as determined by the active BookX filter (e.g. Author).', {$cf_gid}, 300, NOW(), NOW(), NULL, NULL)
                            		    ;
EOT;
	    				        	
	    				        $db->Execute($sql);
	    				
	    				        if ($german_installed) {
	    				            $sql = <<<EOT
		 							REPLACE INTO {$const['TABLE_CONFIGURATION_LANGUAGE']} (configuration_title, configuration_key, configuration_description, configuration_language_id)
							    	  VALUES
								    	 ('"Brotkrümel" Navigation: Ausfüllen durch BookX', 'BOOKX_BREAD_USE_BOOKX_NO_CATEGORIES', 'BookX soll die "Brotkrümel" Navigation ausfüllen und nicht Zen Cart mit den angelegten Produktkategorien. Dies betrifft nur die Artikeldetails-Seite für BookX-Produkte und Artikellisten die Ergebnisse eines BookX-Filters zeigen<br /><br />', 43)
                        			    ,('"Brotkrümel" Navigation: Verlag hinzufügen', 'BOOKX_BREAD_ADD_PUBLISHER', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird der Verlag dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der der Verlag dem Krümelpfad hinzugefügt wird./><br />', 43)
                        			    ,('"Brotkrümel" Navigation: Label hinzufügen', 'BOOKX_BREAD_ADD_IMPRINT', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird das Label dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der das Label dem Krümelpfad hinzugefügt wird./><br />', 43)
                        			    ,('"Brotkrümel" Navigation: Serie hinzufügen', 'BOOKX_BREAD_ADD_SERIES', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird die Serie dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der die Serie dem Krümelpfad hinzugefügt wird./><br />', 43)
                        			    ,('"Brotkrümel" Navigation: Genre hinzufügen', 'BOOKX_BREAD_ADD_GENRE', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird das Genre dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der das Genre dem Krümelpfad hinzugefügt wird. ACHTUNG: Wenn einem Buch mehrere Genres zugewiesen sind, kann leider nur eines im Krümelpfad gezeigt werden./><br />', 43)
                        			    ,('"Brotkrümel" Navigation: Autor hinzufügen', 'BOOKX_BREAD_ADD_AUTHOR', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird der Autor dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der der Autor dem Krümelpfad hinzugefügt wird. ACHTUNG: Wenn einem Buch mehrere Autoren zugewiesen sind, kann leider nur einer im Krümelpfad gezeigt werden/><br />', 43)	
			                            ,('Artikeldetails: Buttons "vorheriger / nächster Artikel" navigiert in Bookx Kategorie', 'BOOKX_NEXT_PREVIOUS_BASED_ON_FILTER', 'Wenn diese Einstellung aktiviert ist, navigieren die Buttons "Nächster Artikel", "Vorheriger Artikel" und "Zurück zur Liste" nicht mehr hin und her zwischen den Artikeln in der gleichen ZC Kategorie, sondern vor und zurück in der Ergebnisliste eines aktiven Bookx Filters.<br /><br />', 43)	
		 							    ;
EOT;
	    				            	
	    				            $db->Execute($sql);
	    				
	    				        }
	    				    } else {
	    				        $messageStack->add(BOOKX_MS_CONFIG_TYPE_BOOKX_MISSING, 'error');
	    				    }
	    				    
	    				break;

    		case $version:
    			$messageStack->add(sprintf(BOOKX_MS_VERSION_ALREADY_UP_TO_DATE, $version), 'warning');
    			$install_incomplete = true;;
    			break;



	    }

	    if (!$install_incomplete) {
	    	$sql = 'UPDATE ' . TABLE_CONFIGURATION . ' SET configuration_value = "' . $version . '", last_modified="' . date('Y-m-d H:i:s') . '" WHERE configuration_key = "BOOKX_VERSION";';
	    	$db->Execute($sql);
	    	$messageStack->add('' . BOOKX_MS_DB_UPDATE_SUCCESS . '', 'success');
	    }

		break;

	case ('reset' == $bookx_install AND !$login_page AND $already_installed):
	    
	    $cf_gid = null;
	    $sql = "SELECT configuration_group_id FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_title = 'BookX';";
	     
	    $config_groups = $db->Execute($sql);

	    if ($config_groups->EOF) {
	       $sql = "REPLACE INTO {$const['TABLE_CONFIGURATION_GROUP']} (configuration_group_title, configuration_group_description, sort_order, visible) VALUES
   				('BookX', 'Configure BookX Product Type settings', '1', '1')";
    	    $db->Execute($sql);
    	    
    	    $sql = "SELECT configuration_group_id FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_title = 'BookX';";
    	    
    	    $config_groups = $db->Execute($sql);
	    }	    

	    while (!$config_groups->EOF) {
	        $cf_gid = $config_groups->fields['configuration_group_id'];
	        $config_groups->MoveNext();
	    }
	    
	    
	    $type_id = null;
	    $sql = "SELECT type_id FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler = 'product_bookx';";
	    $product_type = $db->Execute($sql);
	    
	    if ($product_type->EOF) {
	        $sql = "REPLACE INTO {$const['TABLE_PRODUCT_TYPES']} (type_name, type_handler, type_master_type, allow_add_to_cart, date_added, last_modified)
	                      VALUES ( 'Products - Bookx', 'product_bookx', 1,  'Y', now(), now())";
	        $db->Execute($sql);
	        
	        $sql = "SELECT type_id FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler = 'product_bookx';";
	        $product_type = $db->Execute($sql);
	    }
	    while (!$product_type->EOF) {
	        $type_id = (int)$product_type->fields['type_id'];
	        $product_type->MoveNext();
	    }
	    
	    
	    if (!empty($cf_gid)) {
	       /* $sql = "DELETE FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_id = {$cf_gid}";
	        $db->Execute($sql);*/ //we keep this an don't delete when resetting
	    
	        $sql = "DELETE FROM {$const['TABLE_CONFIGURATION']} WHERE configuration_group_id = {$cf_gid} AND configuration_group_id != 0";
	        $db->Execute($sql);
	    
	        if(defined('TABLE_CONFIGURATION_LANGUAGE')) {
	            $sql = "DELETE FROM {$const['TABLE_CONFIGURATION_LANGUAGE']} WHERE configuration_key LIKE '%BOOKX%'";
	            $db->Execute($sql);
	        }
	    
	    }
	    
	    
	    // ======================================================
	    //
	    // remove Layout option descriptions
	    //
	    // ======================================================
	    if (!empty($type_id)) {
    	    $sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT']} WHERE product_type_id = $type_id";
    	    $db->Execute($sql);
	    }

	    //** This should not be necessary, but you never know
        $sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT']} WHERE configuration_key LIKE '%BOOKX%'";
        $db->Execute($sql);
        //*** eof not necessary?
    	    
        $sql = "DELETE FROM {$const['TABLE_GET_TERMS_TO_FILTER']} WHERE get_term_table LIKE 'TABLE_PRODUCT_BOOKX%'";
        $db->Execute($sql);
    	    
        if(defined('TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE')) {
    	        $sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']} WHERE configuration_key LIKE '%BOOKX%'";
    	        $db->Execute($sql);
    	}
    	
    	//if (defined('TABLE_ADMIN_PAGES')) zen_deregister_admin_pages($admin_page_keys);
    	
    	$sql = 'SELECT configuration_value AS version FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key = "BOOKX_VERSION";';
    	$result = $db->Execute($sql); /* @var $result queryFactoryResult */
    	
    	if (!$result->EOF) { // someone may reset their BookX installation BEFORE updating, so we don't want to accidentally update the BookX version in the DB
    	    $version = $result->fields['version'];
    	} else {
    	    
    	}
    	 
	    //******* we don't break here!
	case ('install' == $bookx_install AND !$login_page AND !$already_installed):
		//=======================================
		// INSTALL
		//=======================================

	    // ======================================================
	    //
	    // register BookX in admin pages for Zen 1.5
	    //
	    // ======================================================

	    if (defined('TABLE_ADMIN_PAGES') && defined('TABLE_ADMIN_PAGES_TO_PROFILES'))
	    {
	         zen_deregister_admin_pages($admin_page_keys);

	         zen_register_admin_page('configBookXTools','TOOLS_MENU_PRODUCT_BOOKX','FILENAME_BOOKX_TOOLS','','tools','Y',20);
	         zen_register_admin_page('bookxAuthors','BOX_CATALOG_PRODUCT_BOOKX_AUTHORS','FILENAME_BOOKX_AUTHORS','','extras','Y',20);
	         zen_register_admin_page('bookxAuthorTypes', 'BOX_CATALOG_PRODUCT_BOOKX_AUTHOR_TYPES', 'FILENAME_BOOKX_AUTHOR_TYPES', '', 'extras', 'Y', 25);
	         zen_register_admin_page('bookxBinding', 'BOX_CATALOG_PRODUCT_BOOKX_BINDING', 'FILENAME_BOOKX_BINDING', '', 'extras', 'Y', 30);
	         zen_register_admin_page('bookxConditions', 'BOX_CATALOG_PRODUCT_BOOKX_CONDITIONS', 'FILENAME_BOOKX_CONDITIONS', '', 'extras', 'Y', 50);
	         zen_register_admin_page('bookxGenres', 'BOX_CATALOG_PRODUCT_BOOKX_GENRES', 'FILENAME_BOOKX_GENRES', '', 'extras', 'Y', 60);
	         zen_register_admin_page('bookxImprints', 'BOX_CATALOG_PRODUCT_BOOKX_IMPRINTS', 'FILENAME_BOOKX_IMPRINTS', '', 'extras', 'Y', 80);
	         zen_register_admin_page('bookxPrinting', 'BOX_CATALOG_PRODUCT_BOOKX_PRINTING', 'FILENAME_BOOKX_PRINTING', '', 'extras', 'Y', 40);
	         zen_register_admin_page('bookxPublishers', 'BOX_CATALOG_PRODUCT_BOOKX_PUBLISHERS', 'FILENAME_BOOKX_PUBLISHERS', '', 'extras', 'Y', 70);
	         zen_register_admin_page('bookxSeries', 'BOX_CATALOG_PRODUCT_BOOKX_SERIES', 'FILENAME_BOOKX_SERIES', '', 'extras', 'Y', 90);
	         zen_register_admin_page('bookxProduct', 'BOX_CATALOG_PRODUCT_BOOKX', 'FILENAME_BOOKX_PRODUCT', '', 'catalog', 'Y', 2);

	         $sql = "SELECT profile_id FROM {$const['TABLE_ADMIN_PAGES_TO_PROFILES']} WHERE page_key = 'product'";
	         $profile_ids = $db->Execute($sql);

	         while (!$profile_ids->EOF) {
	         	$db->Execute("REPLACE INTO {$const['TABLE_ADMIN_PAGES_TO_PROFILES']} (profile_id, page_key) VALUES ('{$profile_ids->fields['profile_id']}', 'bookxProduct')");
	         	$profile_ids->MoveNext();
	         }

	    } else {
	        $messageStack->add(sprintf(BOOKX_MS_TABLE_DOESNT_EXIST, 'TABLE_ADMIN_PAGES'), 'warning');
	    }

	    // ======================================================
	    //
	    // insert mysql tables
	    //
	    // ======================================================



	    $sql = "REPLACE INTO {$const['TABLE_GET_TERMS_TO_FILTER']} (get_term_name, get_term_table, get_term_name_field) VALUES
			    	('bookx_author_id', 'TABLE_PRODUCT_BOOKX_AUTHORS', 'author_name'),
	    			('bookx_author_type_id', 'TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION', 'type_description'),
	    			('bookx_binding_id', 'TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION', 'binding_description'),
	    			('bookx_condition_id', 'TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION', 'condition_description'),
	    			('bookx_genre_id', 'TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION', 'genre_description'),
	    			('bookx_imprint_id', 'TABLE_PRODUCT_BOOKX_IMPRINTS', 'imprint_name'),
	    			('bookx_printing_id', 'TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION', 'printing_description'),
	    			('bookx_publisher_id', 'TABLE_PRODUCT_BOOKX_PUBLISHERS', 'publisher_name'),
	    			('bookx_series_id', 'TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION', 'series_name')";
	    $db->Execute($sql);
	    
	    if ('install' == $bookx_install) { // could also be "reset" !

	        $sql = "REPLACE INTO {$const['TABLE_PRODUCT_TYPES']} (type_name, type_handler, type_master_type, allow_add_to_cart, date_added, last_modified)
	                   VALUES ( 'Products - Bookx', 'product_bookx', 1,  'Y', now(), now())";
	       $db->Execute($sql);

	    $sql = <<<EOT
	                #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_EXTRA']};
	               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_EXTRA']} (
	                 products_id int(11) NOT NULL default '0' PRIMARY KEY,
	                 bookx_publisher_id int(11) default NULL,
	                 bookx_series_id int(11)  default NULL,
	                 bookx_imprint_id int(11) NULL default NULL,
	                 bookx_binding_id int(11) NULL default NULL,
	                 bookx_printing_id int(11) NULL default NULL,
	              	 bookx_condition_id int(11) NULL default NULL,
	                 publishing_date datetime default NULL,
	                 pages VARCHAR(16) DEFAULT NULL,
	                 volume VARCHAR(16) DEFAULT NULL,
	                 size VARCHAR(16) DEFAULT NULL,
	               	 isbn VARCHAR(13) DEFAULT NULL,
	                 INDEX  (products_id)
	               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
	    $db->Execute($sql);

	    $sql = <<<EOT

	               # Table structure for table product_bookx_extra_description
	               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION']};
	               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION']} (
	                 products_id int(11) NOT NULL DEFAULT 0,
	                 languages_id int(11) NOT NULL DEFAULT 0,
	                 products_subtitle VARCHAR(255) DEFAULT NULL,
	                 PRIMARY KEY  (products_id, languages_id)
	               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
	    $db->Execute($sql);

	    $sql = <<<EOT
	               # Table structure for table product_bookx_authors
	               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHORS']};
	               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHORS']} (
	                 bookx_author_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	                 author_name VARCHAR(64) DEFAULT NULL,
	                 author_image VARCHAR(64) DEFAULT NULL,
	               	 author_image_copyright VARCHAR(64) DEFAULT NULL,
	               	 author_default_type int(11) DEFAULT NULL,
	                 author_sort_order int(11) DEFAULT NULL,
	               	 author_url VARCHAR(255) DEFAULT NULL,
	               	 date_added datetime DEFAULT NULL,
	               	 last_modified datetime DEFAULT NULL,
	                 INDEX (bookx_author_id)
	               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
	    $db->Execute($sql);

	    $sql = <<<EOT

	               # Table structure for table product_bookx_authors_description
	               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION']};
	               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION']} (
	                 bookx_author_id int(11) NOT NULL DEFAULT 0,
	                 languages_id int(11) NOT NULL DEFAULT 0,
	                 author_description TEXT,
	                 PRIMARY KEY  (bookx_author_id, languages_id)
	               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
	    $db->Execute($sql);

	    $sql = <<<EOT
	               # Table structure for table product_bookx_authors_to_products
	               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS']};
	               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS']} (
	               	 primary_id int(11) NOT NULL AUTO_INCREMENT,
	                 bookx_author_id int(11) NOT NULL DEFAULT 0,
	                 products_id int(11) NOT NULL DEFAULT 0,
	                 bookx_author_type_id int(11) NOT NULL DEFAULT 0,
	                 PRIMARY KEY  (primary_id),
	                 INDEX  (bookx_author_id),
	                 INDEX  (bookx_author_id)
	               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT
               # Table structure for table product_bookx_author_types
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHOR_TYPES']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHOR_TYPES']} (
                 bookx_author_type_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 type_sort_order int(11) DEFAULT NULL,
                 INDEX (bookx_author_type_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8  AUTO_INCREMENT=2;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_author_types_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION']} (
                 bookx_author_type_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 type_description VARCHAR(64) DEFAULT NULL,
                 type_image VARCHAR(64) DEFAULT NULL,
                 PRIMARY KEY  (bookx_author_type_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);



    $sql = <<<EOT

               # Table structure for table product_bookx_binding
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_BINDING']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_BINDING']} (
                 bookx_binding_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 binding_sort_order int(11) DEFAULT NULL,
                 INDEX (bookx_binding_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
EOT;
    $db->Execute($sql);



    $sql = <<<EOT

               # Table structure for table product_bookx_binding_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION']} (
                 bookx_binding_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 binding_description VARCHAR(64) DEFAULT NULL,
                 PRIMARY KEY  (bookx_binding_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);



    $sql = <<<EOT

               # Table structure for table product_bookx_conditions
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_CONDITIONS']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_CONDITIONS']} (
                 bookx_condition_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 condition_sort_order int(11) DEFAULT NULL,
                 INDEX (bookx_condition_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_conditions_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION']} (
                 bookx_condition_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 condition_description VARCHAR(64) DEFAULT NULL,
                 PRIMARY KEY  (bookx_condition_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_genres
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_GENRES']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_GENRES']} (
                 bookx_genre_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 genre_sort_order int(11) DEFAULT NULL,
               	 date_added datetime DEFAULT NULL,
               	 last_modified datetime DEFAULT NULL,
               	 INDEX (bookx_genre_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;
EOT;
    $db->Execute($sql);



    $sql = <<<EOT

               # Table structure for table product_bookx_genres_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION']} (
                 bookx_genre_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 genre_description VARCHAR(64) DEFAULT NULL,
                 genre_image VARCHAR(64) DEFAULT NULL,
                 PRIMARY KEY  (bookx_genre_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);


    $sql = <<<EOT

               # Table structure for table product_bookx_genres_to_products
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS']} (
               	 primary_id int(11) NOT NULL AUTO_INCREMENT,
                 bookx_genre_id int(11) NOT NULL DEFAULT 0,
                 products_id int(11) NOT NULL DEFAULT 0,
                 PRIMARY KEY  (primary_id),
                 INDEX (products_id, bookx_genre_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_imprints
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_IMPRINTS']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_IMPRINTS']} (
                 bookx_imprint_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
               	 imprint_name VARCHAR(64) DEFAULT NULL,
                 imprint_sort_order int(11) DEFAULT NULL,
               	 imprint_image VARCHAR(64) DEFAULT NULL,
               	 date_added datetime DEFAULT NULL,
               	 last_modified datetime DEFAULT NULL,
                 INDEX  (bookx_imprint_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_imprints_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION']} (
                 bookx_imprint_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 imprint_description TEXT,
                 PRIMARY KEY  (bookx_imprint_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_printing
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PRINTING']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_PRINTING']} (
                 bookx_printing_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 printing_sort_order int(11) DEFAULT NULL,
                 INDEX (bookx_printing_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;
EOT;
    $db->Execute($sql);



    $sql = <<<EOT

               # Table structure for table product_bookx_printing_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION']} (
                 bookx_printing_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 printing_description VARCHAR(64) DEFAULT NULL,
                 PRIMARY KEY  (bookx_printing_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);



    $sql = <<<EOT

               # Table structure for table product_bookx_publishers
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS']} (
                 bookx_publisher_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 publisher_name VARCHAR(64) DEFAULT NULL,
                 publisher_image VARCHAR(64) DEFAULT NULL,
                 publisher_sort_order int(11) DEFAULT NULL,
               	 date_added datetime DEFAULT NULL,
               	 last_modified datetime DEFAULT NULL,
               	 INDEX (bookx_publisher_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_publishers_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION']} (
                 bookx_publisher_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 publisher_url VARCHAR(255) DEFAULT NULL,
                 publisher_description TEXT,
                 PRIMARY KEY  (bookx_publisher_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_series
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_SERIES']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_SERIES']} (
                 bookx_series_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 series_sort_order int(11) DEFAULT NULL,
               	 date_added datetime DEFAULT NULL,
               	 last_modified datetime DEFAULT NULL,
               	 INDEX (bookx_series_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);

    $sql = <<<EOT

               # Table structure for table product_bookx_series_description
               #DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION']};
               CREATE TABLE {$const['TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION']} (
                 bookx_series_id int(11) NOT NULL DEFAULT 0,
                 languages_id int(11) NOT NULL DEFAULT 0,
                 series_image VARCHAR(64) DEFAULT NULL,
                 series_name VARCHAR(64) DEFAULT NULL,
               	 series_description TEXT,
                 PRIMARY KEY  (bookx_series_id, languages_id)
               ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOT;
    $db->Execute($sql);


    $messageStack->add('' . BOOKX_MS_DB_TABLES_SUCCESS . '', 'success');
	    } // eof create DB tables

    $sql = "SELECT type_id FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler= 'product_bookx'";

    $product_type = $db->Execute($sql);
    $type_id = null;

    while (!$product_type->EOF) {
    	$type_id = $product_type->fields['type_id'];
    	$product_type->MoveNext();
    }

    if (!empty($type_id)) {
    $sql = <<<EOT

          REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT']} (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, last_modified, date_added, use_function, set_function )
                              VALUES
                               # settings for product type bookx only
                                         ('Product Listing: Show Model Number', 'SHOW_PRODUCT_BOOKX_LISTING_MODEL', '1', 'Display Model Number on Product Listing.', {$type_id}, '10', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show ISBN', 'SHOW_PRODUCT_BOOKX_LISTING_ISBN', '1', 'Display ISBN on Product Listing.', {$type_id}, '15', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Subtitle', 'SHOW_PRODUCT_BOOKX_LISTING_SUBTITLE', '1', 'Display Subtitle on Product Listing.', {$type_id}, '20', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show No. of Pages', 'SHOW_PRODUCT_BOOKX_LISTING_PAGES', '1', 'Display Number of Pages on Product Listing.', {$type_id}, '30', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Printing Type', 'SHOW_PRODUCT_BOOKX_LISTING_PRINTING', '1', 'Display Type of Printing on Product Listing.', {$type_id}, '40', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Binding Type', 'SHOW_PRODUCT_BOOKX_LISTING_BINDING', '1', 'Display Type of Binding on Product Listing.', {$type_id}, '50', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Size', 'SHOW_PRODUCT_BOOKX_LISTING_SIZE', '1', 'Display Size on Product Listing.', {$type_id}, '60', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Volume No.', 'SHOW_PRODUCT_BOOKX_LISTING_VOLUME', '1', 'Display Volume Number on Product Listing.', {$type_id}, '70', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Publishing Date', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISH_DATE', '1', 'Display Publishing Date on Product Listing.', {$type_id}, '80', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Publisher', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER', '1', 'Display Publisher on Product Listing.', {$type_id}, '90', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Publisher as Link', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_AS_LINK', '1', 'Display Publisher on Product Listing as clickable link, which will list all products for this publisher.', {$type_id}, '90', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Listing: Show Publisher Image/Logo', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_IMAGE', '1', 'Display Publisher Image on Product Listing. In case of an undefined Image, the Publishers Name will be shown.', {$type_id}, '91', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Publisher Url', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_URL', '0', 'Display Publisher URL on Product Listing.', {$type_id}, '92', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Publisher Description', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_DESCRIPTION', '0', 'Display Publisher Description on Product Listing.', {$type_id}, '93', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Imprint', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT', '1', 'Display Imprint/Sublabel on Product Listing.', {$type_id}, '100', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                        ('Product Listing: Show Imprint as Link', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT_AS_LINK', '1', 'Display Imprint on Product Listing as clickable link, which will list all products for this Imprint.', {$type_id}, '90', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Listing: Show Imprint Image', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT_IMAGE', '1', 'Display Imprint/Sublabel Image on Product Listing. In case of an undefined image, the name will be shown.', {$type_id}, '101', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Imprint Description', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT_DESCRIPTION', '0', 'Display Imprint/Sublabel Description on Product Listing.', {$type_id}, '102', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Series', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES', '1', 'Display Series on Product Listing.', {$type_id}, '110', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                        ('Product Listing: Show Series as Link', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES_AS_LINK', '1', 'Display Series on Product Listing as clickable link, which will list all products for this Series.', {$type_id}, '90', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),

                                         ('Product Listing: Show Series Image', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES_IMAGE', '1', 'Display Series Image on Product Listing. In case of an undefined image, the name will be shown.', {$type_id}, '111', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Series Description', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES_DESCRIPTION', '0', 'Display Series Description on Product Listing.', {$type_id}, '112', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Authors', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS', '1', 'Display Authors on Product Listing.', {$type_id}, '117', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show only Authors with Type Sort Oder below', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_WITH_TYPE_BELOW_SORT_ORDER', '1000', 'Display only Authors on Product Listing which are of an Author Type with a Sort Order smaller than this value. Example: Default value of "1000" means that authors of type e.g. "Illustrator" will not be shown on product listing, if the author type "Illustrator" has a sort order of "1000" or greater. This way multiple authors can be given more or less "importance". If you enter a value "0" then this setting is ignored.', {$type_id}, '122', now(), now(), NULL, NULL),
                                         ('Product Listing: Show Authors as Link', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_AS_LINK', '1', 'Display Authors on Product Listing as clickable link, which will list all products for this Author.', {$type_id}, '120', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Listing: Show Authors Image', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_IMAGE', '0', 'Display Authors image on Product Listing. In case of an undefined Image, the Authors Name will be shown.', {$type_id}, '121', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Authors Url', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_URL', '0', 'Display Authors URL on Product Listing.', {$type_id}, '122', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Authors Description', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_DESCRIPTION', '0', 'Display Authors description on Product Listing.', {$type_id}, '123', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Author Type', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHOR_TYPE', '1', 'Display Author Type on Product Listing.', {$type_id}, '124', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Author Type Image', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHOR_TYPE_IMAGE', '1', 'Display Author Type Image on Product Listing.', {$type_id}, '125', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Genres', 'SHOW_PRODUCT_BOOKX_LISTING_GENRES', '1', 'Display Genres on Product Listing.', {$type_id}, '130', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                        ('Product Listing: Show Genres as Link', 'SHOW_PRODUCT_BOOKX_LISTING_GENRES_AS_LINK', '1', 'Display Genres on Product Listing as clickable link, which will list all products for this Genre.', {$type_id}, '90', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Listing: Show Genre Image', 'SHOW_PRODUCT_BOOKX_LISTING_GENRE_IMAGE', '1', 'Display Genre Image on Product Listing. In case of an undefined image, the name will be shown.', {$type_id}, '131', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Show Condition', 'SHOW_PRODUCT_BOOKX_LISTING_CONDITION', '1', 'Display Book Condition on Product Listing.', {$type_id}, '140', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Listing: Group Products by availability', 'GROUP_PRODUCT_BOOKX_LISTING_BY_AVAILABILITY', '1', 'Group products in any product listing according to availability. Order: <br />1) Upcoming products <br />2) New products <br />3) Published / available products 4) Out of print <br /><br />Criteria for "new" and "upcoming" books are set in Admin -> Configuration -> BookX Configuration.', {$type_id}, '150', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),

                                         ('Product Detail: Show Subtitle', 'SHOW_PRODUCT_BOOKX_INFO_SUBTITLE', '1', 'Display Subtitle on Product Info.', {$type_id}, '150', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show No. of Pages', 'SHOW_PRODUCT_BOOKX_INFO_PAGES', '1', 'Display Number of Pages on Product Info.', {$type_id}, '160', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Printing Type', 'SHOW_PRODUCT_BOOKX_INFO_PRINTING', '1', 'Display Type of Printing on Product Info.', {$type_id}, '170', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Binding Type', 'SHOW_PRODUCT_BOOKX_INFO_BINDING', '1', 'Display Type of Binding on Product Info.', {$type_id}, '180', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Size', 'SHOW_PRODUCT_BOOKX_INFO_SIZE', '1', 'Display Size on Product Info.', {$type_id}, '190', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Volume No.', 'SHOW_PRODUCT_BOOKX_INFO_VOLUME', '1', 'Display Volume Number on Product Info.', {$type_id}, '200', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Publishing Date', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISH_DATE', '1', 'Display Publishing Date on Product Info.', {$type_id}, '210', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Publisher', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER', '1', 'Display Publisher on Product Info.', {$type_id}, '220', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Publisher as Link', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_AS_LINK', '1', 'Display Publisher on Product Info as clickable link, which will list all products for this publisher.', {$type_id}, '221', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Detail: Show Publisher Image/Logo', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_IMAGE', '1', 'Display Publisher Image/Logo on Product Info. In case of an undefined image, the name will be shown.', {$type_id}, '222', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Publisher URL', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_URL', '1', 'Display Publisher URL on Product Info.', {$type_id}, '223', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Publisher Description', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_DESCRIPTION', '1', 'Display Publisher Description on Product Info.', {$type_id}, '224', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Imprint', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT', '1', 'Display Imprint/Sublabel on Product Info.', {$type_id}, '230', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Imprint as Link', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT_AS_LINK', '1', 'Display Imprint on Product Info as clickable link, which will list all products for this Imprint.', {$type_id}, '231', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Detail: Show Imprint Image', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT_IMAGE', '1', 'Display Imprint/Sublabel Image on Product Info. In case of an undefined image, the name will be shown.', {$type_id}, '232', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Imprint Description', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT_DESCRIPTION', '1', 'Display Imprint/Sublabel Description  on Product Info.', {$type_id}, '233', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Series', 'SHOW_PRODUCT_BOOKX_INFO_SERIES', '1', 'Display Series on Product Info.', {$type_id}, '240', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Series as Link', 'SHOW_PRODUCT_BOOKX_INFO_SERIES_AS_LINK', '1', 'Display Series on Product Info as clickable link, which will list all products for this Series.', {$type_id}, '241', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Detail: Show Series Image', 'SHOW_PRODUCT_BOOKX_INFO_SERIES_IMAGE', '1', 'Display Series Image Product Info. In case of an undefined image, the name will be shown.', {$type_id}, '242', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Series Description', 'SHOW_PRODUCT_BOOKX_INFO_SERIES_DESCRIPTION', '1', 'Display Series Descriptionon Product Info.', {$type_id}, '243', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Authors', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS', '1', 'Display Authors on Product Info.', {$type_id}, '250', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Authors as Link', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_AS_LINK', '1', 'Display Authors on Product Info as clickable link, which will list all products for this Author.', {$type_id}, '251', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Detail: Show Authors Image', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_IMAGE', '1', 'Display Authors image on Product Info. In case of an undefined image, the name will be shown.', {$type_id}, '252', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Authors Url', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_URL', '1', 'Display Authors URL on Product Info.', {$type_id}, '253', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Authors Description', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_DESCRIPTION', '1', 'Display Authors Description on Product Info.', {$type_id}, '254', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Author Type', 'SHOW_PRODUCT_BOOKX_INFO_AUTHOR_TYPE', '1', 'Display Authors Type  on Product Info.', {$type_id}, '255', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Authors Type Image', 'SHOW_PRODUCT_BOOKX_INFO_AUTHOR_TYPE_IMAGE', '1', 'Display Authors Type Image on Product Info.', {$type_id}, '256', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Authors related books', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_RELATED_PRODUCTS', '1', 'Display other books by the same Author on Product Info.', {$type_id}, '257', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Order Authors by', 'ORDER_PRODUCT_BOOKX_INFO_AUTHORS', '1', 'Order Authors on Product Info page by: ', {$type_id}, '258', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'), array('id'=>'3', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_NAME')), array('id'=>'4', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_TYPE_SORT_ORDER'))), "),
                                         ('Product Detail: Show Genres', 'SHOW_PRODUCT_BOOKX_INFO_GENRES', '1', 'Display Genres on Product Info.', {$type_id}, '260', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Genres as Link', 'SHOW_PRODUCT_BOOKX_INFO_GENRES_AS_LINK', '1', 'Display Genres on Product Info as clickable link, which will list all products for this Genre.', {$type_id}, '261', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
                                         ('Product Detail: Show Genre Image', 'SHOW_PRODUCT_BOOKX_INFO_GENRE_IMAGES', '1', 'Display Genre Images on Product Info. In case of an undefined image, the name will be shown.', {$type_id}, '262', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Order Genres by', 'ORDER_PRODUCT_BOOKX_INFO_GENRES', '1', 'Order Genres on Product Info page by: ', {$type_id}, '263', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),"),
                                         ('Product Detail: Show Condition', 'SHOW_PRODUCT_BOOKX_INFO_CONDITION', '1', 'Display Book Condition on Product Info.', {$type_id}, '270', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),


                               # settings for all products
                                        ('Product Detail: Show Model Number', 'SHOW_PRODUCT_BOOKX_INFO_MODEL', '1', 'Display Model Number on Product Info.', {$type_id}, '275', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show ISBN', 'SHOW_PRODUCT_BOOKX_INFO_ISBN', '1', 'Display ISBN on Product Info.', {$type_id}, '277', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),

                                         ('Product Detail: Show Weight', 'SHOW_PRODUCT_BOOKX_INFO_WEIGHT', '1', 'Display Weight on Product Info.', {$type_id}, '280', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Attribute Weight', 'SHOW_PRODUCT_BOOKX_INFO_WEIGHT_ATTRIBUTES', '1', 'Display Attribute Weight on Product Info.', {$type_id}, '290', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Manufacturer', 'SHOW_PRODUCT_BOOKX_INFO_MANUFACTURER', '1', 'Display Manufacturer Name on Product Info.', {$type_id}, '300', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Quantity in Shopping Cart', 'SHOW_PRODUCT_BOOKX_INFO_IN_CART_QTY', '1', 'Display Quantity in Current Shopping Cart on Product Info.', {$type_id}, '310', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Quantity in Stock', 'SHOW_PRODUCT_BOOKX_INFO_QUANTITY', '1', 'Display Quantity in Stock on Product Info.', {$type_id}, '320', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Product Reviews Count', 'SHOW_PRODUCT_BOOKX_INFO_REVIEWS_COUNT', '1', 'Display Product Reviews Count on Product Info.', {$type_id}, '330', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Product Reviews Button', 'SHOW_PRODUCT_BOOKX_INFO_REVIEWS', '1', 'Display Product Reviews Button on Product Info.', {$type_id}, '340', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Date Available', 'SHOW_PRODUCT_BOOKX_INFO_DATE_AVAILABLE', '1', 'Display Date Available on Product Info.', {$type_id}, '350', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Date Added', 'SHOW_PRODUCT_BOOKX_INFO_DATE_ADDED', '1', 'Display Date Added on Product Info.', {$type_id}, '360', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Product URL', 'SHOW_PRODUCT_BOOKX_INFO_URL', '1', 'Display URL on Product Info.', {$type_id}, '370', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
                                         ('Product Detail: Show Starting At text on Price', 'SHOW_PRODUCT_BOOKX_INFO_STARTING_AT', '1', 'Display Starting At text on products with attributes Product Info.', {$type_id}, '380', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Product Tell a Friend button', 'SHOW_PRODUCT_BOOKX_INFO_TELL_A_FRIEND', '1', 'Display the Tell a Friend button on Product Info<br /><br />Note: Turning this setting off does not affect the Tell a Friend box in the columns and turning off the Tell a Friend box does not affect the button<br />0= off 1= on', {$type_id}, '390', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Show Product Additional Images', 'SHOW_PRODUCT_BOOKX_INFO_ADDITIONAL_IMAGES', '1', 'Display Additional Images on Product Info.', {$type_id}, '395', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Detail: Product Free Shipping Image Status - Catalog', 'SHOW_PRODUCT_BOOKX_INFO_ALWAYS_FREE_SHIPPING_IMAGE_SWITCH', '0', 'Show the Free Shipping image/text in the catalog?', {$type_id}, '400', now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(''id''=>''1'', ''text''=>''Yes''), array(''id''=>''0'', ''text''=>''No'')), '),

                              # settings for admin
		                                ('Product Price Tax Class Default - When adding new products?', 'DEFAULT_PRODUCT_BOOKX_TAX_CLASS_ID', '0', 'What should the Product Price Tax Class Default ID be when adding new products?', {$type_id}, '410', now(), now(), NULL, ''),
		                                ('Product Virtual Default Status - Skip Shipping Address - When adding new products?', 'DEFAULT_PRODUCT_BOOKX_PRODUCTS_VIRTUAL', '0', 'Default Virtual Product status to be ON when adding new products?', {$type_id}, '420', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Product Free Shipping Default Status - Normal Shipping Rules - When adding new products?', 'DEFAULT_PRODUCT_BOOKX_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', '0', 'What should the Default Free Shipping status be when adding new products?', {$type_id}, '430', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),

		                        #settings for meta tags
		                               # ('Show Metatags Title Default - Website Title', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS', '1', 'Display Website Title in Meta Tags Title.', {$type_id}, '500', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Website Tagline', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS', '1', 'Display Website Tagline in Meta Tags Title.', {$type_id}, '505', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),

		                               # ('Show Metatags Title Default - Product Title', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_TITLE_STATUS', '1', 'Display Product Title in Meta Tags Title.', {$type_id}, '510', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Subtitle', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_SUBTITLE_STATUS', '1', 'Display Product Subtitle in Meta Tags Title.', {$type_id}, '515', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product ISBN', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_MODEL_STATUS', '1', 'Display Book ISBN in Meta Tags Title.', {$type_id}, '520', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Price', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRICE_STATUS', '1', 'Display Book Price in Meta Tags Title.', {$type_id}, '530', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Author', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_AUTHOR_STATUS', '1', 'Display Book Author in Meta Tags Title.', {$type_id}, '550', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Publisher', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_PUBLISHER_STATUS', '1', 'Display Book Publisher in Meta Tags Title.', {$type_id}, '560', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Genre', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_GENRE_STATUS', '1', 'Display Book Genre in Meta Tags Title.', {$type_id}, '570', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Series', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_SERIES_STATUS', '1', 'Display Book Series in Meta Tags Title.', {$type_id}, '580', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                               # ('Show Metatags Title Default - Product Imprint', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_IMPRINT_STATUS', '1', 'Display Book Imprint in Meta Tags Title.', {$type_id}, '590', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),

		                       #settings show bookx filters in sidebox
		                                ('Filter Sidebox - Filter Author', 'SHOW_PRODUCT_BOOKX_FILTER_AUTHOR', '1', 'Display a filter for Author in the Bookx Filter Sidebox.', {$type_id}, '650', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Filter Author Type', 'SHOW_PRODUCT_BOOKX_FILTER_AUTHOR_TYPE', '1', 'Display a filter for Author Type in the Bookx Filter Sidebox.', {$type_id}, '655', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Filter Publisher', 'SHOW_PRODUCT_BOOKX_FILTER_PUBLISHER', '1', 'Display a filter for Publisher in the Bookx Filter Sidebox.', {$type_id}, '660', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Filter Imprint', 'SHOW_PRODUCT_BOOKX_FILTER_IMPRINT', '1', 'Display a filter for Imprint in the Bookx Filter Sidebox.', {$type_id}, '670', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Filter Genre', 'SHOW_PRODUCT_BOOKX_FILTER_GENRE', '1', 'Display a filter for Genre in the Bookx Filter Sidebox.', {$type_id}, '660', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Filter Series', 'SHOW_PRODUCT_BOOKX_FILTER_SERIES', '1', 'Display a filter for Series in the Bookx Filter Sidebox.', {$type_id}, '690', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Link to Authors List', 'SHOW_PRODUCT_BOOKX_LINK_AUTHOR_LIST', '1', 'Show a link to display the list of all Authors in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Link to Imprint List', 'SHOW_PRODUCT_BOOKX_LINK_IMPRINT_LIST', '1', 'Show a link to display the list of all Imprints in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Link to Publisher List', 'SHOW_PRODUCT_BOOKX_LINK_PUBLISHER_LIST', '1', 'Show a link to display the list of all Publishers in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Link to Genres List', 'SHOW_PRODUCT_BOOKX_LINK_GENRES_LIST', '1', 'Show a link to display the list of all Genres in the Bookx Filter Sidebox.', {$type_id}, '695', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Link to Series List', 'SHOW_PRODUCT_BOOKX_LINK_SERIES_LIST', '1', 'Show a link to display the list of all Seies in the Bookx Filter Sidebox.', {$type_id}, '696', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),
		                                ('Filter Sidebox - Allow multiple filters active', 'ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE', '0', 'Allow multiple filters to be active in the Bookx Filter Sidebox. Otherwise setting one filter will cancel the previous filter. EXCEPT: The combination of filters "Author" and "Author Type" is always enabled.', {$type_id}, '699', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),"),

		                        #settings extra info on top of search results
		                                ('Filter Results - Author: Show extra Info', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_AUTHOR', '1', 'Display extra info for Author on top of search results when Filter active.', {$type_id}, '700', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Filter Results - Publisher: Show extra Info', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_PUBLISHER', '1', 'Display extra info for Publisher on top of search results when Filter active.', {$type_id}, '710', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Filter Results - Imprint: Show extra Info', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_IMPRINT', '1', 'Display extra info for Imprint on top of search results when Filter active.', {$type_id}, '720', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Filter Results - Series: Show extra Info', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_SERIES', '1', 'Display extra info for Series on top of search results when Filter active.', {$type_id}, '730', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),"),
		                                ('Filter Results - Genre: Show extra Info', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_GENRE', '1', 'Display extra info for Genre on top of search results when Filter active.', {$type_id}, '740', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))),")
		                                ;
EOT;
	$db->Execute($sql);

    if ($german_installed) {
	    $sql = <<<EOT
                        REPLACE INTO {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']} (configuration_title, configuration_key, languages_id, configuration_description, last_modified, date_added)
                              VALUES
                              # settings for product type bookx only
                                         ('Artikelliste: Artikelnummer anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_MODEL', 43, 'Artikelnummer in der Artikelliste anzeigen.', now(), now()),
                        				 ('Artikelliste: ISBN anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_ISBN', 43, 'ISBN in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Untertitel anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_SUBTITLE', 43, 'Untertitel in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Seitenzahl anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PAGES', 43, 'Seitenzahl in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Druck anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PRINTING', 43, 'Druck in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Bindung anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_BINDING', 43, 'Druck in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Abmessungen anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_SIZE', 43, 'Abmessungen in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Bandnummer anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_VOLUME', 43, 'Bandnummer in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Erscheinungsdatum anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISH_DATE', 43, 'Erscheinungsdatum in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Verlag anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER', 43, 'Verlag in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Verlag als Link anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_AS_LINK', 43, 'Verlag in der Artikelliste als Link anzeigen. Klick auf den Link listet alle Bücher für diesen Verlag.', now(), now()),
                        				 ('Artikelliste: Verlag Bild/Logo anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_IMAGE', 43, 'Verlag Bild/Logo in der Artikelliste anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        		         ('Artikelliste: Verlag URL anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_URL', 43, 'Verlag URL in der Artikelliste anzeigen.', now(), now()),
                        		         ('Artikelliste: Verlag Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_PUBLISHER_DESCRIPTION', 43, 'Verlag Beschreibung in der Artikelliste anzeigen.', now(), now()),
                        				 ('Artikelliste: Unterlabel anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT', 43, 'Unterlabel in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Unterlabel als Link anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT_AS_LINK', 43, 'Unterlabel in der Artikelliste als Link anzeigen. Klick auf den Link listet alle Bücher für dieses Unterlabel.', now(), now()),
                        				('Artikelliste: Unterlabel Bild anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT_IMAGE', 43, 'Unterlabel-Bild in der Artikelliste anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        			     ('Artikelliste: Unterlabel Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_IMPRINT_DESCRIPTION', 43, 'Unterlabel Beschreibung in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Serie anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES', 43, 'Serie in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Serie als Link anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES_AS_LINK', 43, 'Serie in der Artikelliste als Link anzeigen. Klick auf den Link listet alle Bücher für diese Serie.', now(), now()),
                        				('Artikelliste: Serienbild anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES_IMAGE', 43, 'Serienbild in der Artikelliste anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        				 ('Artikelliste: Serienbeschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_SERIES_DESCRIPTION', 43, 'Serienbeschreibung in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Autoren anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS', 43, 'Autoren in der Artikelliste anzeigen.', now(), now()),
                        		('Artikelliste: nur Autoren anzeigen mit Typ Sortierung unter', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_WITH_TYPE_BELOW_SORT_ORDER', 43, 'Nur solche Autoren auf der Artikelliste anzeigen, die einen Autorentyp haben, dessen Sortierung kleiner ist als der hier eingestellte Wert. Beispiel: Grundeinstellung "1000" bedeutet, dass ein Autor mit dem Typ "Illustrator" in der Artikelliste nicht angezeigt wird, wenn der Autorentyp eine Sortierung von "1000" oder mehr hat. So kann man die Autorentypen priorisieren, und z.B. nur einen "Hauptautor" in der Artikelliste anzeigen lassen. Bei einem Wert von "0" wird diese Einstellung ignoriert.', now(), now()),
                        				('Artikelliste: Autoren als Link anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_AS_LINK', 43, 'Autor in der Artikelliste als Link anzeigen. Klick auf den Link listet alle Bücher für diesen Autor.', now(), now()),
                        				('Artikelliste: Autorenbild anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_IMAGE', 43, 'Autorenbild in der Artikelliste anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        				 ('Artikelliste: Autoren URL anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_URL', 43, 'URLs der Autoren in der Artikelliste anzeigen.', now(), now()),
                        				 ('Artikelliste: Autorenbeschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHORS_DESCRIPTION', 43, 'Autorenbeschreibung in der Artikelliste anzeigen.', now(), now()),
                        				 ('Artikelliste: Autorentyp anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHOR_TYPE', 43, 'Autorentyp in der Artikelliste anzeigen.', now(), now()),
                        				 ('Artikelliste: Autorentyp Bild anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_AUTHOR_TYPE_IMAGE', 43, 'Autorentyp Bild in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Genres anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_GENRES', 43, 'Genres in der Artikelliste anzeigen.', now(), now()),
                                         ('Artikelliste: Genres als Link anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_GENRES_AS_LINK', 43, 'Genres in der Artikelliste als Link anzeigen. Klick auf den Link listet alle Bücher für dieses Genre.', now(), now()),
                        				('Artikelliste: Genre-Bild anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_GENRE_IMAGE', 43, 'Genre-Bild in der Artikelliste anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                                         ('Artikelliste: Zustand anzeigen', 'SHOW_PRODUCT_BOOKX_LISTING_CONDITION', 43, 'Zustand in der Artikelliste anzeigen.', now(), now()),
                        				('Artikelliste: Bücher nach Lieferbarkeit gruppieren', 'GROUP_PRODUCT_BOOKX_LISTING_BY_AVAILABILITY', 43, 'Gruppiere Bücher in Artikelliste nach Lieferbarkeit: Reihenfolge: <br />1) Noch nicht lieferbare Bücher <br />2) Neue Bücher <br />3) Lieferbare Bücher <br />4) Vergriffene Bücher <br /><br />Kriterien für "Neue" und "noch nicht lieferbare" Bücher werden einegstellt unter Admin -> Konfiguration -> BookX.', now(), now()),

                                         ('Artikeldetails: Untertitel anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_SUBTITLE', 43, 'Untertitel auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Seitenzahl anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PAGES', 43, 'Seitenzahl auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Druck anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PRINTING', 43, 'Druck auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Bindung anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_BINDING', 43, 'Druck auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Abmessungen anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_SIZE', 43, 'Abmessungen auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Reihennummer anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_VOLUME', 43, 'Reihennummer auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Erscheinungsdatum anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISH_DATE', 43, 'Erscheinungsdatum auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Verlag anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER', 43, 'Verlag auf der Artikeldetailseite anzeigen.', now(), now()),
                        				 ('Artikeldetails: Verlag also Link anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_AS_LINK', 43, 'Verlag auf der Artikeldetailseite als Link anzeigen. Klick auf den Link listet alle Bücher für diesen Verlag.', now(), now()),
                        		         ('Artikeldetails: Verlag Bild/Logo anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_IMAGE', 43, 'Verlag auf der Artikeldetailseite anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        		         ('Artikeldetails: Verlag URL anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_URL', 43, 'Verlag auf der Artikeldetailseite anzeigen.', now(), now()),
                        		  		 ('Artikeldetails: Verlag Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_PUBLISHER_DESCRIPTION', 43, 'Verlag auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Unterlabel anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT', 43, 'Unterlabel auf der Artikeldetailseite anzeigen.', now(), now()),
                        				 ('Artikeldetails: Unterlabel als Link anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT_AS_LINK', 43, 'Unterlabel auf der Artikeldetailseite als Link anzeigen. Klick auf den Link listet alle Bücher für dieses Unterlabel.', now(), now()),
                        				 ('Artikeldetails: Unterlabel-Bild anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT_IMAGE', 43, 'Unterlabel-Bild auf der Artikeldetailseite anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        				 ('Artikeldetails: Unterlabel Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_IMPRINT_DESCRIPTION', 43, 'Unterlabel Beschreibung auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Serie anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_SERIES', 43, 'Serie auf der Artikeldetailseite anzeigen.', now(), now()),
                        				 ('Artikeldetails: Serie als Link anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_SERIES_AS_LINK', 43, 'Serie auf der Artikeldetailseite als Link anzeigen. Klick auf den Link listet alle Bücher für diese Serie.', now(), now()),
                        				 ('Artikeldetails: Serienbild anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_SERIES_IMAGE', 43, 'Serienbild auf der Artikeldetailseite anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        			     ('Artikeldetails: Serienbeschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_SERIES_DESCRIPTION', 43, 'Serienbeschreibung auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Autoren anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS', 43, 'Autoren auf der Artikeldetailseite anzeigen.', now(), now()),
                        				 ('Artikeldetails: Autoren als Link anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_AS_LINK', 43, 'Autoren auf der Artikeldetailseite als Link anzeigen. Klick auf den Link listet alle Bücher für diesen Autor.', now(), now()),
                        				 ('Artikeldetails: Autorenbild anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_IMAGE', 43, 'Autorenbild auf der Artikeldetailseite anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
                        		         ('Artikeldetails: Autoren URL anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_URL', 43, 'URLs der Autoren auf der Artikeldetailseite anzeigen.', now(), now()),
                        		         ('Artikeldetails: Autorenbeschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_DESCRIPTION', 43, 'Autorenbeschreibung auf der Artikeldetailseite anzeigen.', now(), now()),
                        		         ('Artikeldetails: Autorentyp anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHOR_TYPE', 43, 'Autorentyp auf der Artikeldetailseite anzeigen.', now(), now()),
		                        		 ('Artikeldetails: Autorentyp Bild anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHOR_TYPE_IMAGE', 43, 'Autorentyp Bild auf der Artikeldetailseite anzeigen.', now(), now()),
		                        		 ('Artikeldetails: Autoren sortieren nach', 'ORDER_PRODUCT_BOOKX_INFO_AUTHORS', 43, 'Autoren auf der Artikeldetailseite sortieren nach: ', now(), now()),
                        				 ('Artikeldetails: Weitere Bücher der Autoren anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_AUTHORS_RELATED_PRODUCTS', 43, 'Weitere Bücher des selben Autors auf der Artikeldetailseite anzeigen.', now(), now()),
                                         ('Artikeldetails: Genres anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_GENRES', 43, 'Genres auf der Artikeldetailseite anzeigen.', now(), now()),
                        				 ('Artikeldetails: Genres als Link anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_GENRES_AS_LINK', 43, 'Genres auf der Artikeldetailseite als Link anzeigen. Klick auf den Link listet alle Bücher für dieses Genre.', now(), now()),
                        				 ('Artikeldetails: Genre-Bilder anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_GENRE_IMAGES', 43, 'Genres auf der Artikeldetailseite anzeigen. Falls kein Bild vorhanden, wir der Name angezeigt.', now(), now()),
		                        		 ('Artikeldetails: Genres sortieren nach', 'ORDER_PRODUCT_BOOKX_INFO_GENRES', 43, 'Genres auf der Artikeldetailseite sortieren nach: ', now(), now()),
                        				 ('Artikeldetails: Zustand anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_CONDITION', 43, 'Zustand auf der Artikeldetailseite anzeigen.', now(), now()),

                              # settings for all products
                                        ('Artikeldetails: Artikelnummer anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_MODEL', 43, 'Soll auf der Produktseite die Artikelnummer anzeigt werden <br/> ', now(), now()),
                        				('Artikeldetails: ISBN anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_ISBN', 43, 'Soll auf der Produktseite die ISBN anzeigt werden <br/> ', now(), now()),
                                        ('Artikeldetails: Gewicht anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_WEIGHT', 43, 'Soll das Gewicht auf der Artikeldetailseite angezeigt werden<br/> ', now(), now()),
                                        ('Artikeldetails: Attribut Gewicht anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_WEIGHT_ATTRIBUTES', 43, 'Soll das Attribut Gewicht auf der Artikeldetailseite angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: Hersteller anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_MANUFACTURER', 43, 'Soll der Hersteller auf der Artikeldetailseite angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: Menge im Warenkorb anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_IN_CART_QTY', 43, 'Soll die bereits im Warenkorb vorhandene Menge diese Artikels auf der Artikeldetailseite angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: Lagermenge anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_QUANTITY', 43, 'Soll die aktuelle Lagermenge auf der Artikeldetailseite angezeigt werden<br/> ', now(), now()),
                                        ('Artikeldetails: Anzahl der Artikelbewertungen anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_REVIEWS_COUNT', 43, 'Soll die Anzahl der Artikelbewertungen auf der Artikeldetailseite angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: Button "Artikel bewerten" anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_REVIEWS', 43, 'Soll der Button "Artikel bewerten" auf der Artikeldetailseite angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: "Verfügbar am" anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_DATE_AVAILABLE', 43, 'Soll auf der Artikeldetailseite "Verfügbar am" angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: "Hinzugefügt am" anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_DATE_ADDED', 43, 'Soll auf der Artikeldetailseite "Hinzugefügt am" angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: Artikel URL anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_URL', 43, 'Soll die Artikel URL auf der Artikeldetailseite angezeigt werden? ', now(), now()),
                                        ('Artikeldetails: Preis "ab.." anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_STARTING_AT', 43, 'Soll bei Büchern mit Attributen die Preisanzeige mit "ab" beginnen?<br/> ', now(), now()),
                                        ('Artikeldetails: Button "Einem Freund empfehlen" anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_TELL_A_FRIEND', 43, 'Soll der Button "Einem Freund empfehlen" auf der Artikeldetailseite angezeigt werden?<br /><br />HINWEIS: Das Deaktivieren dieser Einstellung hat keine Auswirkungen auf die entsprechende Sidebox. Das Deaktivieren der Sidebox deaktiviert nicht diesen Button<br />', now(), now()),
                                        ('Artikeldetails: Zusätzliche Artikelbilder anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_ADDITIONAL_IMAGES', 43, 'Sollen auf der Artikeldetailseite zusätzliche Artikelbilder angezeigt werden?<br/> ', now(), now()),
                                        ('Artikeldetails: Bild "Versandkostenfreie Lieferung" anzeigen', 'SHOW_PRODUCT_BOOKX_INFO_ALWAYS_FREE_SHIPPING_IMAGE_SWITCH', 43, 'Soll das Bild bzw. der Text für "Versandkostenfreie Lieferung" im Shop angezeigt werden?', now(), now()),

                              # settings for admin
                                        ('Artikelpreis Steuerklasse - Standardeinstellung', 'DEFAULT_PRODUCT_BOOKX_TAX_CLASS_ID', 43, 'Welche Steuerklasse soll jeder neu angelegte Artikel haben<br/>Bitte geben Sie die ID der Steuerklasse ein.', now(), now()),
                                        ('Artikel ist virtuell - Standardeinstellung', 'DEFAULT_PRODUCT_BOOKX_PRODUCTS_VIRTUAL', 43, 'Soll jeder neu angelegte Artikel ein virtueller sein?', now(), now()),
                                        ('Artikel "immer versandkostenfrei" - Standardeinstellung', 'DEFAULT_PRODUCT_BOOKX_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', 43, 'Welche Einstellung soll beim Anlegen eines neuen Artikels standardmäßig aktiviert werden?<br />JA, Immer versandkostenfrei AN<br />NEIN, Immer versandkostenfrei AUS<br />Spezial, Artikel/Download benötigt Versand', now(), now()),

                              #settings for image and meta tags
                                       # ('Metatag Titel Standardeinstellung - Webseitentitel', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_STATUS', 43, 'Soll der Titel der Webseite im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       # ('Metatag Titel Standardeinstellung - Webseiten-Tagline', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_TAGLINE_STATUS', 43, 'Soll die Tagline der Webseite im Metatag Titel angezeigt werden<br/>', now(), now()),

                        				# ('Metatag Titel Standardeinstellung - Buchtitel', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_TITLE_STATUS', 43, 'Soll der Buchtitel im Metatag Titel angezeigt werden<br/>', now(), now()),
                        				# ('Metatag Titel Standardeinstellung - Untertitel', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRODUCTS_SUBTITLE_STATUS', 43, 'Soll der Untertitel im Metatag Titel angezeigt werden<br/>', now(), now()),
                                        # ('Metatag Titel Standardeinstellung - ISBN', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_MODEL_STATUS', 43, 'Soll die ISBN im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       #  ('Metatag Titel Standardeinstellung - Artikelpreis', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_PRICE_STATUS', 43, 'Soll der Artikelpreis im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       # ('Metatag Titel Standardeinstellung - Artikel Autor', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_AUTHOR_STATUS', 43, 'Soll der Buchautor im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       # ('Metatag Titel Standardeinstellung - Artikel Verlag', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_PUBLISHER_STATUS', 43, 'Soll der Buchverlag im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       # ('Metatag Titel Standardeinstellung - Artikel Genre', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_GENRE_STATUS', 43, 'Soll das Buchgenre im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       # ('Metatag Titel Standardeinstellung - Artikel Reihe', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_SERIES_STATUS', 43, 'Soll die Buchreihe Tagline im Metatag Titel angezeigt werden<br/>', now(), now()),
                                       # ('Metatag Titel Standardeinstellung - Artikel Label', 'SHOW_PRODUCT_BOOKX_INFO_METATAGS_TITLE_IMPRINT_STATUS', 43, 'Soll das Buchlabel Tagline im Metatag Titel angezeigt werden<br/>', now(), now()),

                        	#settings show bookx filters in sidebox
		                                ('Filter Sidebox - Filter Autor', 'SHOW_PRODUCT_BOOKX_FILTER_AUTHOR', '43', 'Filter für Autor in der Bookx Filter Sidebox anzeigen.', now(), now()),
		                                ('Filter Sidebox - Filter Autorentyp', 'SHOW_PRODUCT_BOOKX_FILTER_AUTHOR_TYPE', '43', 'Filter für Autorentyp in der Bookx Filter Sidebox anzeigen.', now(), now()),
                                        ('Filter Sidebox - Filter Verlag', 'SHOW_PRODUCT_BOOKX_FILTER_PUBLISHER', '43', 'Filter für Verlag in der Bookx Filter Sidebox anzeigen.', now(), now()),
		                                ('Filter Sidebox - Filter Unterlabel', 'SHOW_PRODUCT_BOOKX_FILTER_IMPRINT', '43', 'Filter für Unterlabel in der Bookx Filter Sidebox anzeigen.', now(), now()),
		                                ('Filter Sidebox - Filter Reihe', 'SHOW_PRODUCT_BOOKX_FILTER_SERIES', '43', 'Filter für Reihe in der Bookx Filter Sidebox anzeigen.', now(), now()),
		                                ('Filter Sidebox - Filter Genre', 'SHOW_PRODUCT_BOOKX_FILTER_GENRE', '43', 'Filter für Genre in der Bookx Filter Sidebox anzeigen.', now(), now()),
		                                ('Filter Sidebox - Link zur Autorenliste', 'SHOW_PRODUCT_BOOKX_LINK_AUTHOR_LIST', '43', 'Link zur Liste aller Autoren in der Bookx Filter Sidebox anzeigen.', now(), now()),
                                        ('Filter Sidebox - Link zur Unterlabelliste', 'SHOW_PRODUCT_BOOKX_LINK_IMPRINT_LIST', '43', 'Link zur Liste aller Unterlabelliste in der Bookx Filter Sidebox anzeigen.', now(), now()),
                                        ('Filter Sidebox - Link zur Verlagsliste', 'SHOW_PRODUCT_BOOKX_LINK_PUBLISHER_LIST', '43', 'Link zur Liste aller Verlage in der Bookx Filter Sidebox anzeigen.', now(), now()),
                           		        ('Filter Sidebox - Link zur Genreliste', 'SHOW_PRODUCT_BOOKX_LINK_GENRES_LIST', '43', 'Link zur Liste aller Genres in der Bookx Filter Sidebox anzeigen.', now(), now()),
                                        ('Filter Sidebox - Link zur Serienliste', 'SHOW_PRODUCT_BOOKX_LINK_SERIES_LIST', '43', 'Link zur Liste aller Serien in der Bookx Filter Sidebox anzeigen.', now(), now()),
                                        ('Filter Sidebox - Mehrere Filter zulassen', 'ALLOW_PRODUCT_BOOKX_FILTER_MULTIPLE', '43', 'Erlaubt es, mehrere Filter in der Bookx Filter Sidebox zu setzen. Anderfalls ersetzt eine Filterauswahl einen ggf. vorher gesetzten Filter. AUSNAHME: Die Kombination der Filter "Autor" und "Autorentyp" ist immer erlaubt.', now(), now()),

                        #settings extra info on top of search results
                        			    ('Filter Resultate - Autor: Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_AUTHOR', 43, 'Beschreibung für Autor oben auf der Resultate-Seite anzeigen, wenn der Filter „Autor” aktiviert ist?', now(), now()),
                        				('Filter Resultate - Verlag: Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_PUBLISHER', 43, 'Beschreibung für Verlag oben auf der Resultate-Seite anzeigen, wenn der Filter „Autor” aktiviert ist?', now(), now()),
		                        		('Filter Resultate - Unterlabel: Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_IMPRINT', 43, 'Beschreibung für Unterlabel oben auf der Resultate-Seite anzeigen, wenn der Filter „Autor” aktiviert ist?', now(), now()),
		                        		('Filter Resultate - Reihe: Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_SERIES', 43, 'Beschreibung für Reihe oben auf der Resultate-Seite anzeigen, wenn der Filter „Autor” aktiviert ist?', now(), now()),
		                        		('Filter Resultate - Genre: Beschreibung anzeigen', 'SHOW_PRODUCT_BOOKX_FILTER_EXTRA_INFO_GENRE', 43, 'Beschreibung für Genre oben auf der Resultate-Seite anzeigen, wenn der Filter „Autor” aktiviert ist?', now(), now())

                        		;
EOT;
	    	$db->Execute($sql);
    	}
    } else {
    	$messageStack->add('' . BOOKX_MS_PRODUCT_LAYOUT_CONFIGS_NOT_INSTALLED . '','error');
    }


    //*********** Menu item for Config menu ********//////////
    if ('install' == $bookx_install) { // could also be "reset" !
        $sql = "REPLACE INTO {$const['TABLE_CONFIGURATION_GROUP']} (configuration_group_title, configuration_group_description, sort_order, visible) VALUES
   				('BookX', 'Configure BookX Product Type settings', '1', '1')";
        $db->Execute($sql);
    }

    $sql = "SELECT configuration_group_id FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_title = 'BookX';";

    $config_groups = $db->Execute($sql);
    $cf_gid = null;

    while (!$config_groups->EOF) {
	    $cf_gid = $config_groups->fields['configuration_group_id'];
	    $config_groups->MoveNext();
    }

    if (!empty($cf_gid)) {
    	///*********  Register for Admin Access Control ********////
    	zen_register_admin_page('configProdTypeBookX','CONFIG_MENU_PRODUCT_BOOKX','FILENAME_CONFIGURATION','gID='. $cf_gid,'configuration','Y',$cf_gid);

    	$sql = <<<EOT
		    UPDATE {$const['TABLE_CONFIGURATION_GROUP']} SET sort_order = {$cf_gid} WHERE configuration_group_id = {$cf_gid};
EOT;
    	$db->Execute($sql);

		$sql = <<<EOT
    	REPLACE INTO {$const['TABLE_CONFIGURATION']} (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function)
    		VALUES
    		('BookX Version', 'BOOKX_VERSION', '{$version}', 'BookX Version is stored but not editable', 0, 10000, NOW(), NOW(), NULL, NULL)
		    ,('Filter list: Maximum width', 'BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN', '30', '<br />Sets the maximum width for an option list in the Book X filter sidebox.<br /><br /><b>Default: 30</b><br />', {$cf_gid}, 90, NOW(), NOW(), NULL, NULL)
		    ,('Filter list: Size/Style', 'BOOKX_MAX_SIZE_FILTER_LIST', '0', '<br />Sets the maximum length for an option list in the Book X filter sidebox. Settings this value to 0 or 1 will display a dropdown list.', {$cf_gid}, 100, NOW(), NOW(), NULL, NULL)
		    ,('BookX Icons: Maximum Height', 'BOOKX_ICONS_MAX_HEIGHT', '32', '<br />Maximum height in pixels for icons used for genre, publisher (logo), imprint, series, author <u>type</u>. A value of 0 will show all icons at their actual size without any scaling.', {$cf_gid}, 110, NOW(), NOW(), NULL, NULL)
		    ,('BookX Icons: Maximum Width', 'BOOKX_ICONS_MAX_WIDTH', '120', '<br />Maximum width in pixels for icons used for genre, publisher (logo), imprint, series, author <u>type</u>. A value of 0 will show all icons at their actual size without any scaling.', {$cf_gid}, 120, NOW(), NOW(), NULL, NULL)
		    ,('Product Info Page Author Photo: Maximum Height', 'BOOKX_AUTHOR_IMAGE_MAX_HEIGHT', '180', '<br />Maximum height in pixels for author photo on product info page. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 130, NOW(), NOW(), NULL, NULL)
		    ,('Product Info Page Author Photo: Maximum Width', 'BOOKX_AUTHOR_IMAGE_MAX_WIDTH', '150', '<br />Maximum width in pixels for author photo on product info page. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 140, NOW(), NOW(), NULL, NULL)
		    ,('Author Listing: Max. number of Authors per page', 'MAX_DISPLAY_BOOKX_AUTHOR_LISTING', '30', '<br />Maximum number of listed authors on author listing. No value defaults to 20 rows per page.', {$cf_gid}, 145, NOW(), NOW(), NULL, NULL)
		    ,('Author Listing Photo: Maximum Height', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for author photo on author listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 150, NOW(), NOW(), NULL, NULL)
		    ,('Author Listing Photo: Maximum Width', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for author photo on author listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 160, NOW(), NOW(), NULL, NULL)
		    ,('Author Listing: Show only authors of stocked books', 'BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those authors in the author listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the author listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 165,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Author Listing: Sort authors by', 'BOOKX_AUTHOR_LISTING_ORDER_BY', '1', '<br />Sort authors in author listing by:', {$cf_gid}, 167,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    ,('Imprint Listing: Max. number of imprints per page', 'MAX_DISPLAY_BOOKX_IMPRINT_LISTING', '30', '<br />Maximum number of listed imprints on imprint listing. No value defaults to 20 rows per page.', {$cf_gid}, 168, NOW(), NOW(), NULL, NULL)
		    ,('Imprint Listing Logo: Maximum Height', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for imprint logo on imprint listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 169, NOW(), NOW(), NULL, NULL)
		    ,('Imprint Listing Logo: Maximum Width', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for imprint logo on imprint listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 170, NOW(), NOW(), NULL, NULL)
		    ,('Imprint Listing: Show only imprints with books in stock', 'BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those imprints in the imprint listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the imprint listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 171,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Imprint Listing: Sort imprints by', 'BOOKX_IMPRINT_LISTING_ORDER_BY', '1', '<br />Sort imprints in imprint listing by:', {$cf_gid}, 172,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    ,('Publisher Listing: Max. number of publishers per page', 'MAX_DISPLAY_BOOKX_PUBLISHER_LISTING', '30', '<br />Maximum number of listed publishers on publisher listing. No value defaults to 20 rows per page.', {$cf_gid}, 173, NOW(), NOW(), NULL, NULL)
		    ,('Publisher Listing Logo: Maximum Height', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for publisher logo on publisher listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 174, NOW(), NOW(), NULL, NULL)
		    ,('Publisher Listing Logo: Maximum Width', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for publisher logo on publisher listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 175, NOW(), NOW(), NULL, NULL)
		    ,('Publisher Listing: Show only publishers with books in stock', 'BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those publishers in the publisher listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the publisher listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 176,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Publisher Listing: Sort publishers by', 'BOOKX_PUBLISHER_LISTING_ORDER_BY', '1', '<br />Sort publishers in publisher listing by:', {$cf_gid}, 177,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    ,('Series Listing: Max. number of Series per page', 'MAX_DISPLAY_BOOKX_SERIES_LISTING', '30', '<br />Maximum number of listed series on series listing. No value defaults to 20 rows per page.', {$cf_gid}, 178, NOW(), NOW(), NULL, NULL)
		    ,('Series Listing Image: Maximum Height', 'BOOKX_SERIES_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for series image on series listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 180, NOW(), NOW(), NULL, NULL)
		    ,('Series Listing Image: Maximum Width', 'BOOKX_SERIES_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for series image on series listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 190, NOW(), NOW(), NULL, NULL)
		    ,('Series Listing: Show only series with stocked books', 'BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those series in the series listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the series listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 192,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Series Listing: Sort series by', 'BOOKX_SERIES_LISTING_ORDER_BY', '1', '<br />Sort series in series listing by:', {$cf_gid}, 193,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    ,('Genre Listing: Max. number of genres per page', 'MAX_DISPLAY_BOOKX_GENRE_LISTING', '30', '<br />Maximum number of listed genres on genre listing. No value defaults to 20 rows per page.', {$cf_gid}, 195, NOW(), NOW(), NULL, NULL)
		    ,('Genre Listing Image: Maximum Height', 'BOOKX_GENRE_LISTING_IMAGE_MAX_HEIGHT', '90', '<br />Maximum height in pixels for genre image on genre listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 196, NOW(), NOW(), NULL, NULL)
		    ,('Genre Listing Image: Maximum Width', 'BOOKX_GENRE_LISTING_IMAGE_MAX_WIDTH', '100', '<br />Maximum width in pixels for genre image on genre listing. A value of 0 will show all images at their actual size without any scaling.', {$cf_gid}, 197, NOW(), NOW(), NULL, NULL)
		    ,('Genre Listing: Show only genres with books in stock', 'BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED', '1', '<br />Show only those genres in the genre listing, which have a book in the shop that is in stock (i.e. product is visible <u>and</u> stock is greater than "0"). If this setting is turned on, a checkbox is displayed on top of the genre listing, which allows users to override this setting. If this is not desired, set CSS "display: none" to hide it.', {$cf_gid}, 198,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Genre Listing: Sort genres by', 'BOOKX_GENRE_LISTING_ORDER_BY', '1', '<br />Sort genres in genre listing by:', {$cf_gid}, 198,  now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_NAME')), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ORDER_BY_SORT_ORDER'))),")
		    ,('New Products: Base on Publication Date', 'BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS', '90', 'Base "New Products" List on publication date. Enter number of days to look back in time for published books. A value of "0" turns off this option. Example: Default value of "90" will list all books with publication dates within the last 90 days. Note: If you use partial publication dates in the format "2013-04-00" to only indicate the month of publication, these dates are considered to be at the <u>beginning</u> of the month.<br /><br />', {$cf_gid}, 200, NOW(), NOW(), NULL, NULL)
		    ,('New Products: Show Product Description', 'BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', '150', 'Show (part of) the product description in the "New Products" module. Enter the number of characters after which the description will be truncated. A value of "0" disables the display and a value of "-1" shows the entire description without truncating it.<br /><br />', {$cf_gid}, 201, NOW(), NOW(), NULL, NULL)
		    ,('Upcoming Products: Base on Publication Date', 'BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS', '180', 'Base "Upcoming Products" List on publication date instead of date available. Enter number of days to look ahead in time for books to be published. A value of "0" turns off this option. Example: Default value of "180" will list all books with publication dates within the next 180 days. Note: If you use partial publication dates in the format "2013-04-00" to only indicate the month of publication, these dates are considered to be at the <u>beginning</u> of the month.<br /><br />', {$cf_gid}, 210, NOW(), NOW(), NULL, NULL)
		    ,('Upcoming Products: Show Product Image', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_IMAGE', '1', 'Show product image in "Upcoming Products" module', {$cf_gid}, 220, NOW(), NOW(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Upcoming Products Image: Maximum Height', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_HEIGHT', '120', '<br />Maximum height in pixels for product images in upcoming products module. A value of 0 will not constrain the height of the image.', {$cf_gid}, 222, NOW(), NOW(), NULL, NULL)
		    ,('Upcoming Products Image: Maximum Width', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_WIDTH', '80', '<br />Maximum width in pixels for product images in upcoming products module. A value of 0 will not constrain the width of the image.', {$cf_gid}, 223, NOW(), NOW(), NULL, NULL)
		    ,('Upcoming Products: Show Product Description', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', '150', 'Show (part of) the product description in the "Upcoming Products" module. Enter the number of characters after which the description will be truncated. A value of "0" disables the display and a value of "-1" shows the entire description without truncating it.<br /><br />', {$cf_gid}, 230, NOW(), NOW(), NULL, NULL)
		    ,('Breadcrumbs: Use Bookx instead of ZC Categories', 'BOOKX_BREAD_USE_BOOKX_NO_CATEGORIES', '1', 'Let BookX fill the "Breadcrumb" navigation instead of letting ZenCart populate the "Breadcrumb" navigation with the category path. This only affects the product info page for BookX products or product listings resulting from applying a BookX filter.', {$cf_gid}, 240, NOW(), NOW(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'))),")
		    ,('Breadcrumbs: Insert Publisher on Product Detail Page', 'BOOKX_BREAD_ADD_PUBLISHER', '10', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Publisher and a number above zero determines the order in which the Publisher is inserted in the "Breadcrumb" navigation trail.', {$cf_gid}, 250, NOW(), NOW(), NULL, NULL)
		    ,('Breadcrumbs: Insert Imprint on Product Detail Page', 'BOOKX_BREAD_ADD_IMPRINT', '20', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Imprint and a number above zero determines the order in which the Imprint is inserted in the "Breadcrumb" navigation trail.', {$cf_gid}, 260, NOW(), NOW(), NULL, NULL)
		    ,('Breadcrumbs: Insert Series on Product Detail Page', 'BOOKX_BREAD_ADD_SERIES', '30', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Series and a number above zero determines the order in which the Series is inserted in the "Breadcrumb" navigation trail.', {$cf_gid}, 270, NOW(), NOW(), NULL, NULL)
		    ,('Breadcrumbs: Insert Genre on Product Detail Page', 'BOOKX_BREAD_ADD_GENRE', '0', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Genre and a number above zero determines the order in which the Genre is inserted in the "Breadcrumb" navigation trail. ATTENTION: This may produce unexpected results when multiple Genres are assigned to a book, as only one Genre can be shown.', {$cf_gid}, 280, NOW(), NOW(), NULL, NULL)
		    ,('Breadcrumbs: Insert Author on Product Detail Page', 'BOOKX_BREAD_ADD_AUTHOR', '0', 'If "Use Bookx instead of ZC Categories" is enabled, then the "Breadcrumb" navigation is filled automatically by BookX for a product info page, even if the user got there directly e.g. via a search. A value of "0" disables the inclusion of the Author and a number above zero determines the order in which the Author is inserted in the "Breadcrumb" navigation trail. ATTENTION: This may produce unexpected results when multiple Authors are assigned to a book, as only one author can be show.', {$cf_gid}, 290, NOW(), NOW(), NULL, NULL)
		    ,('Product Info: "Previous"/"Next Buttons" based on active BookX Filter', 'BOOKX_NEXT_PREVIOUS_BASED_ON_FILTER', '1', 'If this feature is enabled, then the buttons "next", "previous", "back to listing" on the product info page will no longer navigate back an fourth in the ZC <strong>Category</b> containing the product, but rather navigate within the set of products as determined by the active BookX filter (e.g. Author).', {$cf_gid}, 300, NOW(), NOW(), NULL, NULL)
		        ;
EOT;
    	$db->Execute($sql);

		///********   Add values for German admin  ******/////////
		if ($german_installed) {

			$sql = <<<EOT
			    REPLACE INTO {$const['TABLE_CONFIGURATION_GROUP']} (configuration_group_id, language_id, configuration_group_title, configuration_group_description, sort_order, visible ) VALUES
			    ({$cf_gid}, 43, 'BookX', 'BookX Einstellungen', '1', '1');
EOT;
	    	$db->Execute($sql);

			$sql = <<<EOT
			    REPLACE INTO {$const['TABLE_CONFIGURATION_LANGUAGE']} (configuration_title, configuration_key, configuration_description, configuration_language_id)
			    		VALUES
			    ('Filter Liste: Maximale Breite', 'BOOKX_MAX_DISPLAY_FILTER_DROPDOWN_LEN', '<br />Maximale Breite in Buchstaben für eine Optionen-Liste in der BookX Filter Sidebox.<br /><br /><b>Voreinstellung: 30', 43)
			    ,('Filter Liste: Listenfeld Größe/Stil', 'BOOKX_MAX_SIZE_FILTER_LIST', '<br />Anzahl der Einträge, die im Listenfeld der Book X Filter Sidebox angezeigt werden sollen. Bei einer Eingabe von 0 oder 1 wird eine Dropdown Liste angezeigt.', 43)
			    ,('BookX Piktogramme: Maximale Höhe', 'BOOKX_ICONS_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) der Piktogramme/Bilder für Genre, Sublabel, Verlag, Serie und Autoren-<u>Typ</u>. Bei einer Eingabe von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('BookX Piktogramme: Maximale Breite', 'BOOKX_ICONS_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) der Piktogramme/Bilder für Genre, Sublabel, Verlag, Serie und Autoren-<u>Typ</u>. Bei einer Eingabe von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Autorenbild auf Seite Artikeldetails: Maximale Höhe', 'BOOKX_AUTHOR_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Autorenbilds auf der Seite Artikeldetails. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Autorenbild auf Seite Artikeldetails: Maximale Breite', 'BOOKX_AUTHOR_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Autorenbilds auf der Seite Artikeldetails. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Autorenliste: Anzahl Autoren pro Seite', 'MAX_DISPLAY_BOOKX_AUTHOR_LISTING', '<br />Maximale Anzahl von Autoren pro Seite in der Autorenliste. Bei "0" oder keinem Wert, werden 20 Autoren pro Seite angezeigt.', 43)
			    ,('Autorenbild in Autorenliste: Maximale Höhe', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Autorenbilds in der Liste aller Autoren. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Autorenbild in Autorenliste: Maximale Breite', 'BOOKX_AUTHOR_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Autorenbilds in der Liste aller Autoren. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Autorenliste: Nur lieferbare Bücher zeigen', 'BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED', '<br />In der Autorenliste nur Autoren anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Autorenliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Autoren ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    ,('Autorenliste: Autoren sortieren nach:', 'BOOKX_AUTHOR_LISTING_ORDER_BY', '<br />Autoren in der Autorenliste werden sortiert nach:', 43)
			    ,('Unterlabelliste: Anzahl Unterlabel pro Seite', 'MAX_DISPLAY_BOOKX_IMPRINT_LISTING', '<br />Maximale Anzahl von Unterlabel pro Seite in der Unterlabelliste. Bei "0" oder keinem Wert, werden 20 Unterlabel pro Seite angezeigt.', 43)
			    ,('Unterlabellogo in Unterlabelliste: Maximale Höhe', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Unterlabellogos in der Liste aller Unterlabel. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Unterlabellogo in Unterlabelliste: Maximale Breite', 'BOOKX_IMPRINT_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Unterlabellogos in der Liste aller Unterlabel. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Unterlabelliste: Nur lieferbare Bücher zeigen', 'BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED', '<br />In der Unterlabelliste nur Unterlabel anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Unterlabelliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Unterlabel ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    ,('Unterlabelliste: Unterlabel sortieren nach:', 'BOOKX_IMPRINT_LISTING_ORDER_BY', '<br />Unterlabel in der Unterlabelliste werden sortiert nach:', 43)
			    ,('Verlagsliste: Anzahl Verlage pro Seite', 'MAX_DISPLAY_BOOKX_PUBLISHER_LISTING', '<br />Maximale Anzahl von Verlagen pro Seite in der Verlagsliste. Bei "0" oder keinem Wert, werden 20 Verlage pro Seite angezeigt.', 43)
			    ,('Verlagslogo in Verlagsliste: Maximale Höhe', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Verlagslogos in der Liste aller Verlage. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Verlagslogo in Verlagsliste: Maximale Breite', 'BOOKX_PUBLISHER_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Verlagslogos in der Liste aller Verlage. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Verlagsliste: Nur lieferbare Bücher zeigen', 'BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED', '<br />In der Verlagsliste nur Verlage anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Verlagsliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Verlage ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    ,('Verlagsliste: Verlage sortieren nach:', 'BOOKX_PUBLISHER_LISTING_ORDER_BY', '<br />Verlage in der Verlagsliste werden sortiert nach:', 43)
			    ,('Serienliste: Anzahl Serien pro Seite', 'MAX_DISPLAY_BOOKX_SERIES_LISTING', '<br />Maximale Anzahl von Serien pro Seite in der Serienliste. Bei "0" oder keinem Wert, werden 20 Serien pro Seite angezeigt.', 43)
			    ,('Serienbild in Serienliste: Maximale Höhe', 'BOOKX_SERIES_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Serienbilds in der Liste aller Serien. Bei einem Wert von 0 wird die Höhe der Bilder nicht begrenzt.', 43)
			    ,('Serienbild in Serienliste: Maximale Breite', 'BOOKX_SERIES_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Serienbilds in der Liste aller Serien. Bei einem Wert von 0 wird die Breite der Bilder nicht begrenzt.', 43)
			    ,('Serienliste: Nur lieferbare Bücher zeigen', 'BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED', '<br />In der Liste aller Serien nur Serien anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Autenliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Unterlabel ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    ,('Serienliste: Serien sortieren nach:', 'BOOKX_SERIES_LISTING_ORDER_BY', '<br />Serien in der Serienliste werden sortiert nach:', 43)
		        ,('Genreliste: Anzahl Genres pro Seite', 'MAX_DISPLAY_BOOKX_GENRE_LISTING', '<br />Maximale Anzahl von Genres pro Seite in der Genreliste. Bei "0" oder keinem Wert, werden 20 Genres pro Seite angezeigt.', 43)
			    ,('Genrelogo in Genreliste: Maximale Höhe', 'BOOKX_GENRE_LISTING_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) des Genrelogos in der Liste aller Genres. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Genrelogo in Genreliste: Maximale Breite', 'BOOKX_GENRE_LISTING_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) des Genrelogos in der Liste aller Genres. Bei einem Wert von 0 werden Bilder in voller Größe angezeigt und nicht skaliert.', 43)
			    ,('Genreliste: Nur lieferbare Bücher zeigen', 'BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED', '<br />In der Genreliste nur Genres anzeigen, für die ein lieferbares Buch im Shop existiert (d.h. der Artikel ist sichtbar <u>und</u> Bestand ist größer "0"). Wenn eingeschaltet, wird über der Genreliste eine Checkbox angezeigt, die es Shopbesuchern erlaubt auch Genres ohne lieferbare Bücher anzuzeigen. Ist diese Checkbox nicht gewünscht, kann diese via CSS "display: none" versteckt werden.', 43)
			    ,('Genreliste: Genres sortieren nach:', 'BOOKX_GENRE_LISTING_ORDER_BY', '<br />Genres in der Genreliste werden sortiert nach:', 43)
			    ,('Neue Artikel: Auswahl durch Erscheinungsdatum', 'BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS', '"Neue Artikel" werden nach Erscheinungsdatum ausgewählt. Ein Wert von "0" schaltet diese Option aus. Beispiel: Der Standardwert von "90" listet alle Bücher auf, deren Erscheinungsdatum innerhalb den letzten 90 Tage liegt. Achtung: Wenn unvollständige Erscheinungsdaten im Format "2013-04-00" verwendet werden, um nur den Erscheinungsmonat anzugeben, dann wird dieses Erscheinugsdatum am <u>Anfang</u> des Monats verortet.', 43)
		    	,('Neue Artikel: Artikelbeschreibung anzeigen', 'BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', 'Im Modul "Neue Artikel" soll die Artikelbeschreibung (teilweise) angezeigt werden. Anzahl der Zeichen nach denen die Beschreibung abgeschnitten wird. Bei einem Wert von "0" wird die Beschreibung nicht angezeigt und bei einem Wert von "-1" wird die gesamte Beschreibung ungekürzt angezeigt.<br /><br />', 43)
			    ,('Artikelankündigungen: Auswahl durch Erscheinungsdatum', 'BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS', '<br />"Artikelankündigungen" werden nach Erscheinungsdatum ausgewählt. Ein Wert von "0" schaltet diese Option aus. Beispiel: Der Standardwert von "180" listet alle Bücher auf, deren Erscheinungsdatum innerhalb der nächsten 180 Tage liegt. Achtung: Wenn unvollständige Erscheinungsdaten im Format "2013-04-00" verwendet werden, um nur den Erscheinungsmonat anzugeben, dann wird dieses Erscheinugsdatum am <u>Anfang</u> des Monats verortet.', 43)
		    	,('Artikelankündigungen: Artikelbild anzeigen', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_IMAGE', 'Im Modul "Artikelankündigungen" soll das Artikelbild angezeigt werden.<br /><br />', 43)
			    ,('Artikelankündigungen Artikelbild: Maximale Höhe', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_HEIGHT', '<br />Maximale Höhe (in Pixeln) der Artikelbilder im Modul „Artikelankündigungen”. Bei einem Wert von 0 wird die Höhe der Bilder nicht begrenzt.', 43)
			    ,('Artikelankündigungen Artikelbild: Maximale Breite', 'BOOKX_UPCOMING_PRODUCT_IMAGE_MAX_WIDTH', '<br />Maximale Breite (in Pixeln) der Artikelbilder in der Liste aller Serien. Bei einem Wert von 0 wird die Breite der Bilder nicht begrenzt.', 43)
			    ,('Artikelankündigungen: Artikelbeschreibung anzeigen', 'BOOKX_UPCOMING_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS', 'Im Modul "Artikelankündigungen" soll die Artikelbeschreibung (teilweise) angezeigt werden. Anzahl der Zeichen nach denen die Beschreibung abgeschnitten wird. Bei einem Wert von "0" wird die Beschreibung nicht angezeigt und bei einem Wert von "-1" wird die gesamte Beschreibung ungekürzt angezeigt.<br /><br />', 43)
			    ,('"Brotkrümel" Navigation: Ausfüllen durch BookX', 'BOOKX_BREAD_USE_BOOKX_NO_CATEGORIES', 'BookX soll die "Brotkrümel" Navigation ausfüllen und nicht Zen Cart mit den angelegten Produktkategorien. Dies betrifft nur die Artikeldetails-Seite für BookX-Produkte und Artikellisten die Ergebnisse eines BookX-Filters zeigen.<br /><br />', 43)
			    ,('"Brotkrümel" Navigation: Verlag hinzufügen', 'BOOKX_BREAD_ADD_PUBLISHER', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird der Verlag dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der der Verlag dem Krümelpfad hinzugefügt wird.<br /><br />', 43)
			    ,('"Brotkrümel" Navigation: Label hinzufügen', 'BOOKX_BREAD_ADD_IMPRINT', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird das Label dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der das Label dem Krümelpfad hinzugefügt wird.<br /><br />', 43)
			    ,('"Brotkrümel" Navigation: Serie hinzufügen', 'BOOKX_BREAD_ADD_SERIES', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird die Serie dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der die Serie dem Krümelpfad hinzugefügt wird.<br /><br />', 43)
			    ,('"Brotkrümel" Navigation: Genre hinzufügen', 'BOOKX_BREAD_ADD_GENRE', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird das Genre dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der das Genre dem Krümelpfad hinzugefügt wird. ACHTUNG: Wenn einem Buch mehrere Genres zugewiesen sind, kann leider nur eines im Krümelpfad gezeigt werden.<br /><br />', 43)
			    ,('"Brotkrümel" Navigation: Autor hinzufügen', 'BOOKX_BREAD_ADD_AUTHOR', 'Wenn "Brotkrümel Navigation: Ausfüllen durch BookX" aktiviert ist, befüllt BookX automatisch den Krümelpfad, auch wenn der Kunde direkt zur Artikeldetailseite gelangt ist z.B. über die Suchfunktion. Bei einem Wert von "0" wird der Autor dem Krümelpfad nicht hinzugefügt. Ein höherer Wert legt die Reihenfolge fest, in der der Autor dem Krümelpfad hinzugefügt wird. ACHTUNG: Wenn einem Buch mehrere Autoren zugewiesen sind, kann leider nur einer im Krümelpfad gezeigt werden.<br /><br />', 43)	
			    ,('Artikeldetails: Buttons "vorheriger / nächster Artikel" navigiert in Bookx Kategorie', 'BOOKX_NEXT_PREVIOUS_BASED_ON_FILTER', 'Wenn diese Einstellung aktiviert ist, navigieren die Buttons "Nächster Artikel", "Vorheriger Artikel" und "Zurück zur Liste" nicht mehr hin und her zwischen den Artikeln in der gleichen ZC Kategorie, sondern vor und zurück in der Ergebnisliste eines aktiven Bookx Filters.<br /><br />', 43)	
			    ;

EOT;
 		   	$db->Execute($sql);
		}

    } else {
			$messageStack->add('' . BOOKX_MS_ADMIN_CONFIG_MENU_NOT_INSTALLED . '','error');
		}


    // ======================================================
    //
    // delete the auto-loader
    //
    // ======================================================
    if(file_exists(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.product_type_bookx.php'))
    {
        /*if(!unlink(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.product_type_bookx.php'))
     {*/
         // $messageStack->add('' . BOOKX_MS_AUTOLOADER_NOTDELETED . '','error');
     /*};*/
    }
    if ('reset' == $bookx_install) { 
        $messageStack->add('' . BOOKX_MS_RESET_SUCCESS . '', 'success');
        
    } else {
        $messageStack->add('' . BOOKX_MS_SUCCESS . '', 'success');
    }

    break;





	case ($bookx_install == 'uninstall' AND !$login_page):

// ======================================================
//
// Uninstall
//
// ======================================================

    // ======================================================
    //
    // remove the menu items
    //
    // ======================================================


	// let's see what we should do with the existing products

	$sql = "SELECT type_id FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler = 'product_bookx';";
	$product_type = $db->Execute($sql);
	$type_id = null;

	while (!$product_type->EOF) {
		$type_id = (int)$product_type->fields['type_id'];
		$product_type->MoveNext();
	}

	if (isset($_GET['convert_bookx_products']) && '1' == $_GET['convert_bookx_products']) {

	    $sql = "SELECT type_id FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler = 'product';";
	    $product_general_type = $db->Execute($sql);
	    $general_type_id = null;

	    while (!$product_general_type->EOF) {
	    	$general_type_id = (int)$product_general_type->fields['type_id'];
	    	$product_general_type->MoveNext();
	    }

   		if (!empty($type_id) && !empty($general_type_id)) {
   			$languages = zen_get_languages();
   			for ($i=0, $n=sizeof($languages); $i<$n; $i++) {

   				$sql = <<<EOT
	   						SELECT p.products_id, pd.products_name, bed.products_subtitle, pd.language_id FROM {$const['TABLE_PRODUCTS']} p
	   						LEFT JOIN {$const['TABLE_PRODUCTS_DESCRIPTION']} pd ON pd.products_id = pd.products_id AND pd.language_id = "{$languages[$i]['id']}"
	   						LEFT JOIN {$const['TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION']} bed ON bed.products_id = p.products_id AND bed.languages_id = "{$languages[$i]['id']}"
	   						WHERE p.products_type = "$type_id";
EOT;
	   			$bookx_products_extra_descriptions = $db->Execute($sql);

   				while (!$bookx_products_extra_descriptions->EOF) {

   					if (!empty($bookx_products_extra_descriptions->fields['products_subtitle']) && !empty($bookx_products_extra_descriptions->fields['products_name'])) {
   						$divider = ' - ';
   					} else {
   						$divider = '';
   					}

   					$new_products_name = $bookx_products_extra_descriptions->fields['products_name'] . $divider . $bookx_products_extra_descriptions->fields['products_subtitle'];

   					$sql = "UPDATE {$const['TABLE_PRODUCTS_DESCRIPTION']} SET products_name = '" . zen_db_input($new_products_name) . "'
   							WHERE products_id = {$bookx_products_extra_descriptions->fields['products_id']} AND language_id = {$bookx_products_extra_descriptions->fields['language_id']};";
   					$db->Execute($sql);
   					$bookx_products_extra_descriptions->MoveNext();
   				}
   			}

   			$sql = "UPDATE {$const['TABLE_PRODUCTS']} SET products_type = $general_type_id WHERE products_type = $type_id;";
   			$db->Execute($sql);
   		}

		$convert_products_to_general = true;
	} elseif (!empty($type_id)) {
		$sql = "SELECT products_id FROM {$const['TABLE_PRODUCTS']} WHERE products_type = $type_id;";
		$products_bookx = $db->Execute($sql);

		while (!$products_bookx->EOF) {
			bookx_delete_product($products_bookx->fields['products_id']);
			$products_bookx->MoveNext();
		}
		$convert_products_to_general = false;
	}

    if (defined('TABLE_ADMIN_PAGES')) zen_deregister_admin_pages($admin_page_keys);

    /////// *********** Remove Configuration menu items   *********** //////////
    $sql = "SELECT configuration_group_id FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_title = 'BookX';";

    $config_groups = $db->Execute($sql);
    $cf_gid = null;

    while (!$config_groups->EOF) {
    	$cf_gid = $config_groups->fields['configuration_group_id'];
    	$config_groups->MoveNext();
    }

    if (!empty($cf_gid)) {
    	$sql = <<<EOT
		    DELETE FROM {$const['TABLE_CONFIGURATION_GROUP']} WHERE configuration_group_id = {$cf_gid};
EOT;
    	$db->Execute($sql);

    	$sql = <<<EOT
		    DELETE FROM {$const['TABLE_CONFIGURATION']} WHERE configuration_group_id = {$cf_gid} AND configuration_group_id != 0;
EOT;
    	$db->Execute($sql);

    	if(defined('TABLE_CONFIGURATION_LANGUAGE')) {    	     
        	$sql = "DELETE FROM {$const['TABLE_CONFIGURATION_LANGUAGE']} WHERE configuration_key LIKE '%BOOKX%'";
        	$db->Execute($sql);
    	}

    	$sql = <<<EOT
		    DELETE FROM {$const['TABLE_ADMIN_PAGES']} WHERE page_key='configProdTypeBookX';
EOT;
    	//$db->Execute($sql); // already taken care of by zen_deregister_admin_pages() ?
    }


    // ======================================================
    //
    // remove Layout option descriptions
    //
    // ======================================================
    if (!empty($type_id)) {
    	$sql = <<<EOT
		    DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT']} WHERE product_type_id = $type_id;
EOT;
    	$db->Execute($sql);
    }

    //** This should not be necessary, but you never know
    $sql = <<<EOT
		    DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT']} WHERE configuration_key LIKE '%BOOKX%';
EOT;
    $db->Execute($sql);
    //*** eof not necessary?

    $sql = <<<EOT
            DELETE FROM {$const['TABLE_GET_TERMS_TO_FILTER']}
                WHERE get_term_table LIKE 'TABLE_PRODUCT_BOOKX%';
EOT;
                $db->Execute($sql);

    if(defined('TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE')) {
        $sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPE_LAYOUT_LANGUAGE']} WHERE configuration_key LIKE '%BOOKX%'";
        $db->Execute($sql);
    }

      $sql = "DELETE FROM {$const['TABLE_PRODUCT_TYPES']} WHERE type_handler = 'product_bookx';";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHORS']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHOR_TYPES']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_BINDING']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_CONDITIONS']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_EXTRA']};";
      $db->Execute($sql);

      $sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_GENRES']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_IMPRINTS']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PRINTING']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_SERIES']};";
      $db->Execute($sql);

		$sql = "DROP TABLE IF EXISTS {$const['TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION']};";

      $db->Execute($sql);

      //@TODO delete the sample catagory BookX if emtpy

    // ======================================================
    //
    // rollback corefiles to default versions
    //
    // ======================================================

   /* foreach($rollback_files as $cf)
    {
        if(xxxx_install_replace($cf[0],$cf[1]))
        {
                if($message_type=='session'){
                    $messageStack->add_session('ROLLBACK  : '.$cf[0].' ' . BOOKX_MS_ROLLBACK_OK . '', 'success');
                }else{
                    $messageStack->add('ROLLBACK  : '.$cf[0].' ' . BOOKX_MS_ROLLBACK_OK . '', 'success');
                }
          @unlink($cf[1]);

        }else{
                if($message_type=='session'){
                    $messageStack->add_session('ROLLBACK : '.$cf[0].' ' . BOOKX_MS_ROLLBACK_NOT_OK . ' ', 'warning');
                }else{
                    $messageStack->add('ROLLBACK : '.$cf[0].' ' . BOOKX_MS_ROLLBACK_NOT_OK . ' ', 'warning');
                }
        }
    }


    // delete the non-core files
    foreach($files as $f)
    {
        if(file_exists($f))
        {
            if(unlink($f))
            {
            //$messageStack->add_session('deleted - '.$f,'success');
            }else{
                if($message_type=='session'){
                    $messageStack->add_session('not deleted - '.$f,'error');
                }else{
                    $messageStack->add('not deleted - '.$f,'error');
                }
            }
        }
    }

    // delete the template files
    foreach($template_files as $f)
    {
        if(file_exists($f[0]))
        {
            if(unlink($f[0]))
            {
            //$messageStack->add_session('deleted - '.$f[0],'success');
            }else{
                if($message_type=='session'){
                    $messageStack->add_session('not deleted - '.$f[1],'error');
                }else{
                    $messageStack->add('not deleted - '.$f[1],'error');
                }
            }
        }

        if(file_exists($f[1])) // may not need to do this but what the heck.
        {
            if(unlink($f[1]))
            {
            //$messageStack->add_session('deleted - '.$f[1],'success');
            }else{
                if($message_type=='session'){
                    $messageStack->add_session('not deleted - '.$f[1],'error');
                }else{
                    $messageStack->add('not deleted - '.$f[1],'error');
                }
            }
        }

    }*/


     if(isset($message_type) && $message_type=='session'){
              $messageStack->add_session('' . BOOKX_MS_UNINSTALL_OK . '', 'success');
              //$messageStack->add_session('' . BOOKX_MS_BACKUP_INFO . '', 'warning');
     } else{
              $messageStack->add('' . BOOKX_MS_UNINSTALL_OK . '', 'success');
              //$messageStack->add('' . BOOKX_MS_BACKUP_INFO . '', 'warning');
     }
     break;
}


