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
 * @version $Id: [ZC INSTALLATION]/includes/classes/observers/class.bookx_observers.php 2016-02-02 philou $
 */

/***
 * Some observers for the product type bookx  which insert variables into the script flow
 */
class productTypeFilterObserver extends base {
	var $flag_show_product_bookx_listing_subtitle = false;
	var $flag_show_product_bookx_listing_pages = false;
	var $flag_show_product_bookx_listing_printing = false;
	var $flag_show_product_bookx_listing_binding = false;
	var $flag_show_product_bookx_listing_size = false;
	var $flag_show_product_bookx_listing_isbn = false;
	var $flag_show_product_bookx_listing_model = false;
	var $flag_show_product_bookx_listing_volume = false;
	var $flag_show_product_bookx_listing_publishing_date = false;

	var $flag_show_product_bookx_listing_publisher = false;
	var $flag_show_product_bookx_listing_publisher_as_link = false;
	var $flag_show_product_bookx_listing_publisher_image = false;
	var $flag_show_product_bookx_listing_publisher_url = false;
	var $flag_show_product_bookx_listing_publisher_description = false;

	var $flag_show_product_bookx_listing_imprint = false;
	var $flag_show_product_bookx_listing_imprint_as_link = false;
	var $flag_show_product_bookx_listing_imprint_image = false;
	var $flag_show_product_bookx_listing_imprint_description = false;
	var $flag_show_product_bookx_listing_series = false;
	var $flag_show_product_bookx_listing_series_as_link = false;
	var $flag_show_product_bookx_listing_series_image = false;
	var $flag_show_product_bookx_listing_series_description = false;
	var $flag_show_product_bookx_listing_authors = false;
	var $flag_show_product_bookx_listing_authors_with_type_below_sort_order = false;
	var $flag_show_product_bookx_listing_authors_as_link = false;
	var $flag_show_product_bookx_listing_authors_image = false;
	var $flag_show_product_bookx_listing_authors_url = false;
	var $flag_show_product_bookx_listing_authors_description = false;
	var $flag_show_product_bookx_listing_author_type = false;
	var $flag_show_product_bookx_listing_author_type_image = false;
	var $flag_show_product_bookx_listing_genres = false;
	var $flag_show_product_bookx_listing_genres_as_link = false;
	var $flag_show_product_bookx_listing_genre_image = false;
	var $flag_show_product_bookx_listing_condition = false;
	var $flag_group_product_bookx_listing_by_availability = false;

	var $flag_show_product_bookx_filter_author = false;
	var $flag_show_product_bookx_filter_autho_typer = false;
	var $flag_show_product_bookx_filter_publisher = false;
	var $flag_show_product_bookx_filter_imprint = false;
	var $flag_show_product_bookx_filter_series = false;
	var $flag_show_product_bookx_filter_genre = false;

	var $flag_show_product_bookx_filter_author_extra_info = false;
	var $flag_show_product_bookx_filter_author_type_extra_info = false;
	var $flag_show_product_bookx_filter_publisher_extra_info  = false;
	var $flag_show_product_bookx_filter_imprint_extra_info  = false;
	var $flag_show_product_bookx_filter_series_extra_info  = false;
	var $flag_show_product_bookx_filter_genre_extra_info  = false;

	var $bookx_filter_active = 0;
	var $filtered_author_id = null;
	var $filtered_author_type_id = null;
	var $filtered_publisher_id = null;
	var $filtered_imprint_id = null;
	var $filtered_series_id = null;
	var $filtered_genre_id = null;
	var $filtered_condition_id = null;
	var $filtered_printing_id = null;
	var $filtered_binding_id = null;

	var $filtered_values_loaded = false;

	function loadFilterValues() {
		if(!$this->filtered_values_loaded) {
			// Bookx specific flags
			$this->flag_show_product_bookx_listing_subtitle = bookx_get_show_product_switch('subtitle', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_pages = bookx_get_show_product_switch('pages', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_printing = bookx_get_show_product_switch('printing', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_binding = bookx_get_show_product_switch('binding', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_size = bookx_get_show_product_switch('size', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_isbn = bookx_get_show_product_switch('isbn', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_model = bookx_get_show_product_switch('model', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_volume = bookx_get_show_product_switch('volume', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_publishing_date = bookx_get_show_product_switch('publish_date', 'SHOW_', '_LISTING');

			$this->flag_show_product_bookx_listing_publisher = bookx_get_show_product_switch('publisher', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_publisher_as_link = bookx_get_show_product_switch('publisher_as_link', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_publisher_image = bookx_get_show_product_switch('publisher_image', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_publisher_url = bookx_get_show_product_switch('publisher_url', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_publisher_description = bookx_get_show_product_switch('publisher_description', 'SHOW_', '_LISTING');

			$this->flag_show_product_bookx_listing_imprint = bookx_get_show_product_switch('imprint', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_imprint_as_link = bookx_get_show_product_switch('imprint_as_link', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_imprint_image = bookx_get_show_product_switch('imprint_image', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_imprint_description = bookx_get_show_product_switch('imprint_description', 'SHOW_', '_LISTING');

			$this->flag_show_product_bookx_listing_series = bookx_get_show_product_switch('series', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_series_as_link = bookx_get_show_product_switch('series_as_link', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_series_image = bookx_get_show_product_switch('series_image', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_series_description = bookx_get_show_product_switch('series_description', 'SHOW_', '_LISTING');

			$this->flag_show_product_bookx_listing_authors = bookx_get_show_product_switch('authors', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_authors_with_type_below_sort_order = bookx_get_show_product_switch('authors_with_type_below_sort_order', 'SHOW_', '_LISTING');

			$this->flag_show_product_bookx_listing_authors_as_link = bookx_get_show_product_switch('authors_as_link', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_authors_image = bookx_get_show_product_switch('authors_image', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_authors_url = bookx_get_show_product_switch('authors_url', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_authors_description = bookx_get_show_product_switch('authors_description', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_author_type = bookx_get_show_product_switch('author_type', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_author_type_image = bookx_get_show_product_switch('author_type_image', 'SHOW_', '_LISTING');

			$this->flag_show_product_bookx_listing_genres = bookx_get_show_product_switch('genres', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_genres_as_link = bookx_get_show_product_switch('genres_as_link', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_genre_image = bookx_get_show_product_switch('genre_image', 'SHOW_', '_LISTING');
			$this->flag_show_product_bookx_listing_condition = bookx_get_show_product_switch('condition', 'SHOW_', '_LISTING');
			$this->flag_group_product_bookx_listing_by_availability = bookx_get_show_product_switch('by_availability', 'GROUP_', '_LISTING');

			$this->filtered_values_loaded = true;
		}
	}

	function productTypeFilterObserver() {
	   	global $zco_notifier;

	   	$zco_notifier->attach($this, array('NOTIFY_HEADER_INDEX_MAIN_TEMPLATE_VARS_RELEASE_PRODUCT_TYPE_VARS'
	   									  ,'NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT'
	   									  ,'NOTIFY_TEMPLATE_PRODUCT_LISTING_TABULAR_DISPLAY_BEGIN'
	   	                                  ,'NOTIFY_TPL_TABULAR_DISPLAY_START'
	   	                                  /*,'NOTIFY_TEMPLATE_PRODUCT_LISTING_COLUMNAR_DISPLAY_BEGIN'*/
	   									  ,'NOTIFY_HEADER_START_INDEX_MAIN_TEMPLATE_VARS'
	   									  ,'NOTIFIER_CART_GET_PRODUCTS_END'
	   									  ,'NOTIFY_HEADER_END_SHOPPING_CART'
	   									  ,'NOTIFY_SEARCH_WHERE_STRING'
	   									  ,'NOTIFY_MODULE_NEW_PRODUCTS_QUERY_BUILT'
	   									  ,'NOTIFY_MODULE_NEW_PRODUCTS_END'
	   									  ,'NOTIFY_MODULE_UPCOMING_PRODUCTS_QUERY_BUILT'
	   									  ,'NOTIFIER_CART_GET_PRODUCTS_END'
	   	                                  ,'NOTIFY_MODULE_PRODUCT_LISTING_ALPHA_SORTER_BEGIN'
	   									   )
	   						 );
    }

	function update(&$callingClass, $notifier, $paramsArray) {
		switch ($notifier) {
			case 'NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT':
				$this->update_product_listing_with_bookx_attributes($callingClass, $notifier, $paramsArray);
			break;

			case 'NOTIFIER_CART_GET_PRODUCTS_END':
				$this->update_shopping_cart_with_bookx_attributes($callingClass, $notifier, $paramsArray);
				break;

			case 'NOTIFY_HEADER_INDEX_MAIN_TEMPLATE_VARS_RELEASE_PRODUCT_TYPE_VARS':
				$this->check_pType_filters_and_reset($callingClass, $notifier, $paramsArray);
			break;

			case 'NOTIFY_TEMPLATE_PRODUCT_LISTING_TABULAR_DISPLAY_BEGIN':
			case 'NOTIFY_TPL_TABULAR_DISPLAY_START': // This notifier was added in ZC v.1.5.5
			//case 'NOTIFY_TEMPLATE_PRODUCT_LISTING_COLUMNAR_DISPLAY_BEGIN':
				$this->insert_extra_bookx_attributes($callingClass, $notifier, $paramsArray);
				break;

			case 'NOTIFY_HEADER_START_INDEX_MAIN_TEMPLATE_VARS':
				$this->insert_search_term_special_bookx_info($callingClass, $notifier, $paramsArray);
				break;

			//case 'NOTIFIER_CART_GET_PRODUCTS_END':
			case 'NOTIFY_HEADER_END_SHOPPING_CART':
				$this->insert_extra_bookx_attributes_to_cart_display($callingClass, $notifier, $paramsArray);
				break;

			case 'NOTIFY_SEARCH_WHERE_STRING':
				$this->insert_bookx_attributes_into_search_query($callingClass, $notifier, $paramsArray);
				break;

			case 'NOTIFY_MODULE_NEW_PRODUCTS_QUERY_BUILT':
				$this->insert_bookx_attributes_into_new_products_query($callingClass, $notifier, $paramsArray);
				break;

			case 'NOTIFY_MODULE_NEW_PRODUCTS_END':
				$this->insert_bookx_attributes_into_new_products_listing($callingClass, $notifier, $paramsArray);
				break;

			case 'NOTIFY_MODULE_UPCOMING_PRODUCTS_QUERY_BUILT':
				$this->insert_bookx_attributes_into_upcoming_products_query($callingClass, $notifier, $paramsArray);
				break;
				
			case 'NOTIFY_MODULE_PRODUCT_LISTING_ALPHA_SORTER_BEGIN':
			    $this->insert_bookx_hidden_field_into_alpha_sorter($callingClass, $notifier, $paramsArray);
			    break;
				
		}
	}

	/**
	 * This function gets triggered by the file "includes/modules/product_listing.php"
	 * and it replaces the splitPageResults with a query that also contains the extra
	 * bookx fields based on Admin preference settings
	 */
	function update_product_listing_with_bookx_attributes(&$callingClass, $notifier, $paramsArray) {
		/*$bookx_filter = false;
		if (isset($_GET['typefilter']) && 'bookx' == $_GET['typefilter']) {
			// we don't add anything to the listing_sql query since the bookx filter already did
			$bookx_filter = $_GET['bookxfilter'];
			$this->bookx_filter_active = true;
			$this->bookx_filter_type = $bookx_filter;
			$this->bookx_filter_value = $_GET[$this->bookx_filter_type];
		}*/
		//$test = $_GET['typefilter'];
		//$test = $_GET['bookxfilter'];

		global $listing_split;
		global $listing_sql;

		$listing_sql_old = $listing_sql;

		$additional_fields = '';
		$additional_joins = '';
		$additional_where = '';

		$join_bx_extra = false;
		$join_bx_extra_desc = false;
		$join_author = false;
		$join_author_type = false;
		$join_genres = false;
		$join_publisher = false;
		$join_imprint = false;
		$join_series = false;

/*
 * ('Product Listing: Show ISBN', 'SHOW_PRODUCT_BOOKX_LISTING_MODEL', '1', 'Display ISBN on Product Listing.', {$type_id}, '10', now(), now(), NULL, "zen_cfg_select_drop_down(array(array('id'=>'1', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED_ONLY_IF_NOT_EMPTY')), array('id'=>'0', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_DISABLED'), array('id'=>'2', 'text'=>constant('BOOKX_LAYOUT_SETTINGS_ENABLED'))) "),

 */
	$this->loadFilterValues();

		if ($this->flag_show_product_bookx_listing_subtitle) {
			$additional_fields .= ', bed.products_subtitle';
			$join_bx_extra = true;
			$join_bx_extra_desc = true;
		}

		if ($this->flag_show_product_bookx_listing_pages) {
			$additional_fields .= ', be.pages';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_size) {
			$additional_fields .= ', be.size';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_isbn) {
			$additional_fields .= ', CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1)) AS isbn_display';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_volume) {
			$additional_fields .= ', be.volume';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_publishing_date) {
			//$additional_fields .= ', IF(DAYOFMONTH(be.publishing_date), DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_SHORT . '"), DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_MONTH_AND_YEAR . '")) AS publishing_date';
			$additional_fields .= ', CASE WHEN DAYOFMONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_SHORT . '")
										  WHEN MONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_MONTH_AND_YEAR . '")
										  ELSE YEAR(be.publishing_date)
									 END AS publishing_date';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_printing) {
			$additional_fields .= ', printd.printing_description';
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION . ' printd ON printd.bookx_printing_id = be.bookx_printing_id AND printd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_binding) {
			$additional_fields .= ', bindd.binding_description';
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION . ' bindd ON bindd.bookx_binding_id = be.bookx_binding_id AND bindd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_condition) {
			$additional_fields .= ', conditd.condition_description';
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION . ' conditd ON conditd.bookx_condition_id = be.bookx_condition_id AND conditd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
			$join_bx_extra = true;
		}

		//** author
		$additional_author_join_condition = '';
		if ($this->flag_show_product_bookx_listing_authors) {
			if ($this->flag_show_product_bookx_listing_author_type ) {
				$additional_fields .= ', GROUP_CONCAT(DISTINCT CONCAT_WS("", IF("" = IFNULL(batd.type_description,""), "", CONCAT_WS("", "<span class=\"bookxLabel\">", batd.type_description , ": </span>")), ba.author_name) ORDER BY bat.type_sort_order ASC SEPARATOR " &middot; ") AS authors';
				$join_author_type = true;

			} else {
				$additional_fields .= ', GROUP_CONCAT(DISTINCT ba.author_name ORDER BY ba.author_name ASC SEPARATOR " &middot; ") AS authors';
			}
			$join_author = true;
			$join_bx_extra = true;

			if ($this->flag_show_product_bookx_listing_authors_with_type_below_sort_order ) {
				$join_author_type = true;
				$additional_author_join_condition = ' AND bat.type_sort_order < "' . $this->flag_show_product_bookx_listing_authors_with_type_below_sort_order . '" ';
			}
		}

		if ($this->flag_show_product_bookx_listing_authors_image) {
			$additional_fields .= ', ba.author_image';
			$join_author = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_authors_url) {
			$additional_fields .= ', ba.author_url';
			$join_author = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_authors_description) {
			$additional_fields .= ', bad.author_description';
			$join_author = true;
			$join_bx_extra = true;
		}

		//**** publisher
		if ($this->flag_show_product_bookx_listing_publisher) {
			$additional_fields .= ', bp.publisher_name';
			$join_publisher = true;
			$join_bx_extra = true;
		}

		/*if ($this->flag_show_product_bookx_listing_publisher_as_link) {
		 $additional_fields .= ', IF("" = IFNULL(bp.publisher_name,""), "", CONCAT_WS("","<a href=\���' . zen_href_link(FILENAME_DEFAULT, '&bookxfilter=bookx_publisher&bookx_bookx_publisher_id=') .'", bp.bookx_publisher_id, " class=\'bookx_searchlink\'>", bp.publisher_name, "</a>")) AS publisher_searchlink';
		$join_publisher = true;
		}*/
		if ($this->flag_show_product_bookx_listing_publisher_image) {
			$additional_fields .= ', bp.publisher_image';
			$join_publisher = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_publisher_url) {
			$additional_fields .= ', bpd.publisher_url';
			$join_publisher = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_publisher_description) {
			$additional_fields .= ', bpd.publisher_description';
			$join_publisher = true;
			$join_bx_extra = true;
		}


		if ($this->flag_show_product_bookx_listing_imprint) {
			$additional_fields .= ', bi.imprint_name';
			$join_imprint = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_imprint_image) {
			$additional_fields .= ', bi.imprint_image';
			$join_imprint = true;
			$join_bx_extra = true;
		}


		if ($this->flag_show_product_bookx_listing_imprint_description) {
			$additional_fields .= ', bid.imprint_description';
			$join_imprint = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_series) {
			$additional_fields .= ', bsd.series_name';
			$join_series = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_series_image) {
			$additional_fields .= ', bsd.series_image';
			$join_series = true;
			$join_bx_extra = true;
		}


		if ($this->flag_show_product_bookx_listing_series_description) {
			$additional_fields .= ', bsd.series_description';
			$join_series = true;
			$join_bx_extra = true;
		}

		//** genres
		if ($this->flag_show_product_bookx_listing_genres) {
			$additional_fields .= ', GROUP_CONCAT(DISTINCT bgd.genre_description ORDER BY bg.genre_sort_order ASC SEPARATOR "' . BOOKX_GENRE_SEPARATOR . '")  AS genres';
			if ($this->flag_show_product_bookx_listing_genres_as_link) {
				$genre_link_atag_firstpart = '<a href="' .  zen_href_link(FILENAME_DEFAULT, '&typefilter=bookx&bookxfilter=bookx_genre_id&bookx_genre_id=');
				$genre_link_atag_middlepart =  '" class="bookx_searchlink">';
				$additional_fields .= ", GROUP_CONCAT(DISTINCT CONCAT_WS('', '" . $genre_link_atag_firstpart . "', bgd.bookx_genre_id, '" . $genre_link_atag_middlepart . "', bgd.genre_description, '</a>') ORDER BY bg.genre_sort_order ASC SEPARATOR ' | ')  AS genres_as_links";
			}
			$join_genres = true;
			$join_bx_extra = true;
		}

		if ($this->flag_show_product_bookx_listing_genre_image) {
			$additional_fields .= ', bgd.genre_image';
			$join_genres = true;
			$join_bx_extra = true;
		}

		//**** extra joins

		if ($join_bx_extra_desc) {
			$additional_joins = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = be.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"' . $additional_joins;
		}

		//** this is always joined if any bookx attribute is flagged for listing. we test for an active bookx filter, since it would already be joined by the filter
		if (!$this->bookx_filter_active && $join_bx_extra) {
			/* the first join must be via WHERE clause, so we join "products" again and then use LEFT JOINS */
			$additional_joins = ', ' . TABLE_PRODUCTS . ' pbxjoin
								   LEFT JOIN ' . TABLE_PRODUCT_TYPES . ' prodt ON prodt.type_id = pbxjoin.products_type
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = pbxjoin.products_id ' . "\n" . $additional_joins;

			$additional_where .= ' AND pbxjoin.products_id = p.products_id ';

			$additional_fields .= ', prodt.type_handler AS product_type_handler, be.publishing_date AS flag_date ';
		}

		if ($join_author) { //&& empty($this->filtered_author_id // we don't check for this, since the author filter only filters products, not authors
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.products_id = be.products_id
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON batp.bookx_author_id = ba.bookx_author_id
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' bad ON bad.bookx_author_id = ba.bookx_author_id AND bad.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		}

		if ($join_author_type) {
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' bat ON bat.bookx_author_type_id = batp.bookx_author_type_id ' . $additional_author_join_condition
							   . '  LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' batd ON batd.bookx_author_type_id = batp.bookx_author_type_id AND batd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';

		}

		if ($join_genres  && empty($this->filtered_genre_id)) {
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' bgtp ON bgtp.products_id = be.products_id
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES . ' bg ON bgtp.bookx_genre_id = bg.bookx_genre_id
								   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' bgd ON bgd.bookx_genre_id = bgtp.bookx_genre_id AND bgd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		}

		if ($join_publisher && empty($this->filtered_publisher_id)) {
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' bp ON bp.bookx_publisher_id = be.bookx_publisher_id
    							   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . ' bpd ON bpd.bookx_publisher_id = be.bookx_publisher_id AND bpd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		}

		if ($join_imprint && empty($this->filtered_imprint_id)) {
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' bi ON bi.bookx_imprint_id = be.bookx_imprint_id
    							   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . ' bid ON bid.bookx_imprint_id = bi.bookx_imprint_id AND bid.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		}

		if ($join_series && empty($this->filtered_series_id)) {
			$additional_joins .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' bsd ON bsd.bookx_series_id = be.bookx_series_id AND bsd.languages_id = "' . (int)$_SESSION['languages_id'] . '" ';
		}

		$listing_sql_new = preg_replace('/\b(' . preg_quote('order') . ')\b/i', $additional_where. ' GROUP BY p.products_id $1 ', $listing_sql_old);

		$listing_sql_new = preg_replace('/\b(' . preg_quote('from') . ')\b/i', $additional_fields . ' $1 ', $listing_sql_new);
		$listing_sql_new = preg_replace('/\b(' . preg_quote('where') . ')\b/i', $additional_joins . ' $1 ', $listing_sql_new);

		//$listing_sql_new = str_replace('products p', 'products p' . ' ' . $additional_joins . ' ', $listing_sql_new);

		$listing_split = new splitPageResults($listing_sql_new, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');

	}

	/**
	 * This function gets triggered by the file "includes/classes/shopping_cart.php"
	 * It adds some bookx specific data to the 'product_name' variable.
	 */
	function update_shopping_cart_with_bookx_attributes(&$callingClass, $notifier, $paramsArray) {
		global $products_array;
		//global $content;
		//global $productArray;
		global $db;
		
		//$const = get_defined_constants();
		include_once DIR_FS_CATALOG . 'includes/languages/' . $_SESSION['language'] . '/product_bookx_info.php';
		include_once DIR_FS_CATALOG . 'includes/languages/' . $_SESSION['language'] . '/extra_definitions/product_bookx.php';
		//include_once DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/product_bookx_info.php';
		//include_once DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/extra_definitions/product_bookx.php';
		
		if (!empty($products_array)) {
			$ids = array();
			foreach ($products_array as $key => $product) {
				if (!empty($product['attributes'])) {
					//*** this product with attributes, so ID needs to be cleaned
					$id_parts = explode(':', $product['id']);
					$ids[$id_parts[0]] = $key;
				} else {
					$ids[$product['id']] = $key;
				}
			}
		
			$sql = 'SELECT be.products_id, be.volume, bed.products_subtitle
					FROM ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be
					LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = be.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
					WHERE be.products_id IN (' . implode(',', array_keys($ids)) . ')
					GROUP BY be.products_id';
		
			$bookx_products_in_cart = $db->Execute($sql);
		
			while (!$bookx_products_in_cart->EOF) {
				$products_array[$ids[$bookx_products_in_cart->fields['products_id']]]['name'] .= zen_trunc_string(
					(!empty($bookx_products_in_cart->fields['volume']) ? '&nbsp;' . $bookx_products_in_cart->fields['volume'] : '') .
					(!empty($bookx_products_in_cart->fields['products_subtitle']) ? ' &ndash; ' . $bookx_products_in_cart->fields['products_subtitle'] : '')
						, 50
					);
				// overkill ? . (strstr($bookx_products_in_cart->fields['authors'], '|') ? LABEL_BOOKX_AUTHORS : LABEL_BOOKX_AUTHOR) . ': ' .
				$bookx_products_in_cart->MoveNext();
			}
		}

	}

	/**
	 * This function gets triggered by the file "includes/templates/[ACTIVE TEMPLATE or DEFAULT]/common/tpl_tabular_display.php"
	 * and it adds some bookx specific data to the $list_box_contents array
	 */
	function insert_extra_bookx_attributes(&$callingClass, $notifier, $paramsArray) {
		global $list_box_contents;
		global $listing; /* @var $listing queryFactoryResult */
		global $column_list;
		global $zco_notifier;

		$zco_notifier->notify('NOTIFY_BOOKX_ADD_EXTRA_INFO_TO_PRODUCT_LISTING_TABULAR_DISPLAY_BEGIN');

		$bookx_upcoming_products_look_ahead_number_of_days = BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS;
		$bookx_new_products_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;

		$upcoming_products_array = array();
		$new_products_array = array();

        $keywords = null;
		if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $keywords = explode(' ', trim($_GET['keyword']));
            if ( ! is_array($keywords)) {
                $keywords = array($keywords);
            }
        }

		if (!$listing->EOF || $listing->cursor) {

			$product_name_column = null;
            $product_image_column = null;
			for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
				if ('PRODUCT_LIST_NAME' == $column_list[$col]) {
					$product_name_column = $col;
				}
                if ('PRODUCT_LIST_IMAGE' == $column_list[$col]) {
                    $product_image_column = $col;
                }
			}

			if ($product_name_column) {
				$listing->Move(0);
				
		        if (1 <= intval(PROJECT_VERSION_MAJOR) && '5.5' < floatval(PROJECT_VERSION_MINOR)) {
				// don't understand why this is necessary, but without it shows the first entry twice ?!
				    $listing->cursor = 0;
				    $listing->MoveNext();
				}
				// eof ?!!?

				$rows = 0;
				$extra_row = 0;
				while (!$listing->EOF) {
					$publishing_date_flag = null;

					if($this->flag_group_product_bookx_listing_by_availability && isset($listing->fields['flag_date']) && !empty($listing->fields['flag_date'])) {
						$date_diff_days = (int)((strtotime($listing->fields['flag_date']) - time()) / 86400);

						switch (true) {
							case $listing->fields['products_quantity'] < 1 && $listing->fields['flag_date'] <= date('Y-m-d 00:00:00', time() + 86400 * intval($bookx_upcoming_products_look_ahead_number_of_days)) : // publishing less than "look ahead days" in future and not yet in stock
							//case $date_diff_days >= 0 && $listing->fields['products_quantity'] < 1 : // publishing date today or in future and not yet in stock
								$publishing_date_flag = 'upcoming-product';
								break;

							case $listing->fields['products_quantity'] > 0 && $listing->fields['flag_date'] >= date('Y-m-d 00:00:00', time() - 86400 * intval($bookx_new_products_look_back_number_of_days)) : // product in stock and publishing date within range of "new" products
								$publishing_date_flag = 'new-product';
								break;

							default:
								;
								break;
						}
					}

					$rows++;

					//*** only add extra bookx info if product is in fact of type bookx
					if (isset($listing->fields['product_type_handler']) && 'product_bookx' == $listing->fields['product_type_handler']) {

						$new_product_text = '';

						$products_name = '<span class="bookxTitle">' . bookx_highlight_search_terms($keywords, $listing->fields['products_name']) .
																	(($this->flag_show_product_bookx_listing_volume && !empty($listing->fields['volume'])) ? ' <span class="bookxProdVolume">' . sprintf(LABEL_BOOKX_VOLUME, $listing->fields['volume']) . '</span>' : '') .
												   					(($this->flag_show_product_bookx_listing_subtitle && !empty($listing->fields['products_subtitle'])) ? ' - <span class="bookxProdSubtitle">' . bookx_highlight_search_terms($keywords, $listing->fields['products_subtitle']) . '</span>' : '') .
														'</span>';

						$active_boox_get_filters = '';

						if (isset($_GET['typefilter']) && 'bookx' == $_GET['typefilter']) {
							$active_boox_get_filters .= '&typefilter=bookx';

							if (isset($_GET['bookx_author_id']) && zen_not_null($_GET['bookx_author_id'])) {
								$active_boox_get_filters .= '&bookx_author_id=' . $_GET['bookx_author_id'];
							}

							if (isset($_GET['bookx_publisher_id']) && zen_not_null($_GET['bookx_publisher_id'])) {
								$active_boox_get_filters .= '&bookx_publisher_id=' . $_GET['bookx_publisher_id'];
							}

							if (isset($_GET['bookx_imprint_id']) && zen_not_null($_GET['bookx_imprint_id'])) {
								$active_boox_get_filters .= '&bookx_imprint_id=' . $_GET['bookx_imprint_id'];

							}

							if (isset($_GET['bookx_series_id']) && zen_not_null($_GET['bookx_series_id'])) {
								$active_boox_get_filters .= '&bookx_series_id=' . $_GET['bookx_series_id'];
							}

							if (isset($_GET['bookx_genre_id']) && zen_not_null($_GET['bookx_genre_id'])) {
								$active_boox_get_filters .= '&bookx_genre_id=' . $_GET['bookx_genre_id'];
							}
						}

						$url_cpath = (($_GET['manufacturers_id'] > 0 AND $_GET['filter_id'] > 0) ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id'])));
						$url_keywords = (isset($_GET['keyword']) ? '&keyword=' . $_GET['keyword'] : '')
                                      . (isset($_GET['search_in_description']) ? '&search_in_description=' . $_GET['search_in_description'] : '')
                                      . (isset($_GET['inc_subcat']) ? '&inc_subcat=' . $_GET['inc_subcat'] : '')
                                      . (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '');
						$product_info_url =  zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . $url_cpath . '&products_id=' . $listing->fields['products_id'] . $active_boox_get_filters . $url_keywords) ;

						$new_product_text .= '<h1 class="itemTitle"><a href="' . $product_info_url . '" class="bookx_product_name">' . bookx_highlight_search_terms($keywords, $products_name) . '</a></h1>';

						if ($this->flag_show_product_bookx_listing_authors) {
							$new_product_text .= '<h2 class="bookxAuthors">' . bookx_highlight_search_terms($keywords, $listing->fields['authors']) . '</h2>';
						}

						$bookx_extra_attributes = array();
						if ($this->flag_show_product_bookx_listing_pages && (!empty($listing->fields['pages']) || 2 == $this->flag_show_product_bookx_info_pages)) $bookx_extra_attributes[] = sprintf(LABEL_BOOKX_PAGES, $listing->fields['pages']);
						if ($this->flag_show_product_bookx_listing_binding && (!empty($listing->fields['binding_description']) || 2 == $this->flag_show_product_bookx_info_binding)) $bookx_extra_attributes[] = $listing->fields['binding_description'];
						if ($this->flag_show_product_bookx_listing_printing && (!empty($listing->fields['printing_description']) || 2 == $this->flag_show_product_bookx_info_printing)) $bookx_extra_attributes[] = $listing->fields['printing_description'];
						if ($this->flag_show_product_bookx_listing_size && (!empty($listing->fields['size']) || 2 == $this->flag_show_product_bookx_info_size)) $bookx_extra_attributes[] = $listing->fields['size'];

						if (0 < count($bookx_extra_attributes)) {
							$new_product_text .= '<div id="bookxExtraAttributes">' . implode(' | ', $bookx_extra_attributes) . '</div>';
						}
						if ($this->flag_show_product_bookx_listing_isbn && !empty($listing->fields['isbn_display']) || 2 == $this->flag_show_product_bookx_listing_isbn) $new_product_text .= '<div class="bookxISBN"><span class="bookxLabel">' . LABEL_BOOKX_ISBN . ' </span>' . $listing->fields['isbn_display'] . '</div>';
						if ($this->flag_show_product_bookx_listing_model && !empty($listing->fields['products_model']) || 2 == $this->flag_show_product_bookx_listing_model) $new_product_text .= '<div class="bookxModel"><span class="bookxLabel">' . LABEL_BOOKX_MODEL . ' </span>' . bookx_highlight_search_terms($keywords, $listing->fields['products_model']) . '</div>';


						if ($this->flag_show_product_bookx_listing_publishing_date && !empty($listing->fields['publishing_date']) || 2 == $this->flag_show_product_bookx_listing_publishing_date) $new_product_text .= '<div class="bookxPublishingDate"><span class="bookxLabel">' . LABEL_BOOKX_PUBLISHING_DATE . '</span>' . $listing->fields['publishing_date'] . '</div>';

						if ($this->flag_show_product_bookx_listing_condition && !empty($listing->fields['condition_description']) || 2 == $this->flag_show_product_bookx_listing_condition) $new_product_text .= '<div class="bookxCondition"><span class="bookxLabel">' . LABEL_BOOKX_CONDITION . ':</span> ' . $listing->fields['condition_description'] . '</div>';


						$new_product_text .= '<div class="listingDescription">' . bookx_highlight_search_terms($keywords, bookx_truncate_paragraph(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION)) . '</div>';

						if ($this->flag_show_product_bookx_listing_genres && !empty($listing->fields['genres']) || 2 == $this->flag_show_product_bookx_listing_genres) {
							$new_product_text .= '<div class="bookxGenres"><span class="bookxLabel">' . LABEL_BOOKX_GENRE . ':</span> ';
							if ($this->flag_show_product_bookx_listing_genres_as_link) {
								$new_product_text .= $listing->fields['genres_as_links'];
							} else {
							 $new_product_text .= $listing->fields['genres'];
							}
							$new_product_text .= '</div>';
						}

						$list_box_contents[$rows]['date_flag'] = $publishing_date_flag;
						$list_box_contents[$rows][$product_name_column]['text'] = $new_product_text;
                        $list_box_contents[$rows][$product_image_column]['text'] = str_replace('&amp;products_id=', $active_boox_get_filters . $url_keywords . '&amp;products_id=', $list_box_contents[$rows][$product_image_column]['text']);

						switch ($publishing_date_flag) {
							case 'upcoming-product':
							    $begin_prodlink = strpos($list_box_contents[$rows][2]['text'], '<br /><br />');
							    $end_prodlink = strpos($list_box_contents[$rows][2]['text'], '<br /><br />', $begin_prodlink +1);
								$list_box_contents[$rows]['params'] = str_replace('class="', 'class="upcoming-product ', $list_box_contents[$rows]['params']);
								//$list_box_contents[$rows][2]['text'] = str_replace('<span class="cssButton button_sold_out_sm"', zen_image_button(BUTTON_IMAGE_BOOKX_UPCOMING, BUTTON_IMAGE_BOOKX_UPCOMING_ALT) .'<span class="cssButton button_sold_out_sm"', $list_box_contents[$rows][2]['text']);
								//$list_box_contents[$rows][2]['text'] = str_replace('<span class="cssButton button_sold_out_sm"', bookx_get_buy_now_button($listing->fields['products_id'], zen_image_button(BUTTON_IMAGE_BOOKX_UPCOMING, BUTTON_IMAGE_BOOKX_UPCOMING_ALT)) .'<span class="cssButton button_sold_out_sm"', $list_box_contents[$rows][2]['text']);
								$list_box_contents[$rows][2]['text'] = substr($list_box_contents[$rows][2]['text'], 0, $begin_prodlink) . (0 < $listing->fields['products_quantity'] ? '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' :'') . bookx_get_buy_now_button($listing->fields['products_id'], zen_image_button(BUTTON_IMAGE_BOOKX_UPCOMING, BUTTON_IMAGE_BOOKX_UPCOMING_ALT)) . substr($list_box_contents[$rows][2]['text'], $end_prodlink) . (0 < $listing->fields['products_quantity'] ? '</a>' : '');
								
								$upcoming_products_array[] = $list_box_contents[$rows];
								unset($list_box_contents[$rows]);
								break;

							case 'new-product':
							    $begin_prodlink = strpos($list_box_contents[$rows][2]['text'], '<br /><br />');
							    $end_prodlink = strpos($list_box_contents[$rows][2]['text'], '<br /><br />', $begin_prodlink +1);
							    $list_box_contents[$rows]['params'] = str_replace('class="', 'class="new-product ', $list_box_contents[$rows]['params']);
								$standard_buy_now_button = zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"');
								//$list_box_contents[$rows][2]['text'] = str_replace($standard_buy_now_button, bookx_get_buy_now_button($listing->fields['products_id'],zen_image_button(BUTTON_IMAGE_BOOKX_NEW, BUTTON_IMAGE_BOOKX_NEW_ALT)), $list_box_contents[$rows][2]['text']);
								$list_box_contents[$rows][2]['text'] = substr($list_box_contents[$rows][2]['text'], 0, $begin_prodlink) . '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . bookx_get_buy_now_button($listing->fields['products_id'],zen_image_button(BUTTON_IMAGE_BOOKX_NEW, BUTTON_IMAGE_BOOKX_NEW_ALT)) . substr($list_box_contents[$rows][2]['text'], $end_prodlink) . '</a>';
								$new_products_array[] = $list_box_contents[$rows];
								unset($list_box_contents[$rows]);
								break;

						}
					}
					$listing->MoveNext();
				}
			}
		}

		$heading_row = array();

		if (!empty($new_products_array) || !empty($upcoming_products_array)) {
			$heading_row[0] = $list_box_contents[0];
			unset($list_box_contents[0]);
			if (count($list_box_contents) > 0) {
				$published_prod_heading_row = array('params' => 'class="bookxList-publishedProductsHeading"', '0' => array('align' => 'left', 'params' => 'colspan="3"', 'text' => '<h3 class="bookxPublishedProduct"><label>' . TEXT_BOOKX_PUBLISHED_PRODUCTS_LABEL . '</label></h3>'));
				array_unshift($list_box_contents, $published_prod_heading_row);
			}
		} elseif (count($list_box_contents) > 0) {
			$published_prod_heading_row = array('params' => 'class="bookxList-publishedProductsHeading"', '0' => array('align' => 'left', 'params' => 'colspan="3"', 'text' => '<h3 class="bookxPublishedProduct"><label>' . TEXT_BOOKX_PUBLISHED_PRODUCTS_LABEL . '</label></h3>'));
			array_unshift($list_box_contents, $published_prod_heading_row);
		}

		if (!empty($new_products_array)) {
			$new_prod_heading_row = array('params' => 'class="bookxList-newProductsHeading"', '0' => array('align' => 'left', 'params' => 'colspan="3"', 'text' => '<h3 class="bookxNewProduct"><label>' . TEXT_BOOKX_NEW_PRODUCTS_LABEL . '</label></h3>'));
			array_unshift($new_products_array, $new_prod_heading_row);
			$list_box_contents = array_merge($new_products_array, $list_box_contents);
		}

		if (!empty($upcoming_products_array)) {
			$upcoming_prod_heading_row = array('params' => 'class="bookxList-upcomingProductsHeading"', '0' => array('align' => 'left', 'params' => 'colspan="3"', 'text' => '<h3 class="bookxUpcomingProduct"><label>' . TEXT_BOOKX_UPCOMING_PRODUCTS_LABEL . '</label></h3>'));
			array_unshift($upcoming_products_array, $upcoming_prod_heading_row);
			$list_box_contents = array_merge($upcoming_products_array, $list_box_contents);
		}

		if (!empty($heading_row)) {
			$list_box_contents = array_merge($heading_row, $list_box_contents);
		}

		$zco_notifier->notify('NOTIFY_BOOKX_ADD_EXTRA_INFO_TO_PRODUCT_LISTING_TABULAR_DISPLAY_END');
	}


	/**
	 * This function gets triggered at the end of the header.php inside modules/pages/shopping_cart.
	 * It adds some bookx specific data to the 'product_name' variable.
	 */
	function insert_extra_bookx_attributes_to_cart_display(&$callingClass, $notifier, $paramsArray) {
		global $productArray;
		global $db;

		//$const = get_defined_constants();
		include_once DIR_FS_CATALOG . 'includes/languages/' . $_SESSION['language'] . '/product_bookx_info.php';
		include_once DIR_FS_CATALOG . 'includes/languages/' . $_SESSION['language'] . '/extra_definitions/product_bookx.php';
		//include_once DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/product_bookx_info.php';
		//include_once DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/extra_definitions/product_bookx.php';

		if (!empty($productArray)) {
			$ids = array();
			foreach ($productArray as $key => $product) {
				if (!empty($product['attributes'])) {
					//*** this product with attributes, so ID needs to be cleaned
					$id_parts = explode(':', $product['id']);
					$ids[$id_parts[0]] = $key;
				} else {
					$ids[$product['id']] = $key;
				}
			}

			$sql = 'SELECT be.products_id, be.volume, bed.products_subtitle,
					CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1)) AS isbn_display,
					GROUP_CONCAT(DISTINCT a.author_name ORDER BY a.author_name ASC SEPARATOR " | ") AS authors
					FROM ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be
					LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = be.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
				    LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' atp ON atp.products_id = be.products_id
    				LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' a ON atp.bookx_author_id = a.bookx_author_id
					WHERE be.products_id IN (' . implode(',', array_keys($ids)) . ')
					GROUP BY be.products_id';

			$bookx_products_in_cart = $db->Execute($sql);

			while (!$bookx_products_in_cart->EOF) {
				$productArray[$ids[$bookx_products_in_cart->fields['products_id']]]['productsName'] .= /* seems to already be included // (!empty($bookx_products_in_cart->fields['volume']) ? ' ' . $bookx_products_in_cart->fields['volume'] : '') . */
																									  (!empty($bookx_products_in_cart->fields['products_subtitle']) ? ' &ndash; ' . $bookx_products_in_cart->fields['products_subtitle'] : '') .
																									  (!empty($bookx_products_in_cart->fields['authors']) ? '<br />' .  $bookx_products_in_cart->fields['authors'] : '') .
																									  (!empty($bookx_products_in_cart->fields['isbn_display']) ? '<br />' . LABEL_BOOKX_ISBN . ': ' . $bookx_products_in_cart->fields['isbn_display'] : '');
																									 // overkill ? . (strstr($bookx_products_in_cart->fields['authors'], '|') ? LABEL_BOOKX_AUTHORS : LABEL_BOOKX_AUTHOR) . ': ' .
																									 
				$bookx_products_in_cart->MoveNext();
			}
		}
	}

	/**
	 * This function gets triggered by the file "modules/pages/index/main_template_vars.php"
	 * and checks to see if a bookx filter is active and whether we need to insert
	 * any special bookx info
	 */
	function insert_search_term_special_bookx_info(&$callingClass, $notifier, $paramsArray) {
		if (isset($_GET['typefilter']) && 'bookx' == $_GET['typefilter']) {
			/*$bookx_filter = $_GET['bookxfilter'];
			$this->bookx_filter_active = true;
			$this->bookx_filter_type = $bookx_filter;
			$this->bookx_filter_value = $_GET[$this->bookx_filter_type];*/

			global $extra_bookx_filter_term_info;
			global $db;
			
			$extra_show_only_stocked_html = '';
			
			if (BOOKX_AUTHOR_LISTING_SHOW_ONLY_STOCKED ||
			    BOOKX_GENRE_LISTING_SHOW_ONLY_STOCKED ||
			    BOOKX_IMPRINT_LISTING_SHOW_ONLY_STOCKED ||
			    BOOKX_PUBLISHER_LISTING_SHOW_ONLY_STOCKED ||
			    BOOKX_SERIES_LISTING_SHOW_ONLY_STOCKED) {
			        
			        $checked = ( isset($_GET['bookx_include_out_of_stock']) && $_GET['bookx_include_out_of_stock'] ? 'checked' : '');
			        
			        $extra_show_only_stocked_html = '
					<script type="text/javascript">
					<!--
					function handleInStockOnlyCheckbox() {
						var n = window.location.href.indexOf("&bookx_include_out_of_stock=");
						var listOutOfStock = bookxFilterOnlyStockedCheckbox.checked;
						var newGetParameter = (listOutOfStock ? "&bookx_include_out_of_stock=true" : "");
						if (0 > n) {
							window.location.href = window.location.href + newGetParameter;
						} else {
							window.location.href = window.location.href.replace("&bookx_include_out_of_stock=true", newGetParameter);
						}
					}
					-->
					</script>
					<div id="bookxFilterOnlyStockedCheckboxContainer">
						<label><input id="bookxFilterOnlyStockedCheckbox" type="checkbox" ' . $checked . ' onClick="handleInStockOnlyCheckbox()" /> ' . TEXT_BOOKX_FILTERS_STOCKCHECKBOX_LABEL . '</label>
					</div>';
			    }		

			$extra_html = '';

			if(isset($_GET['bookx_author_id']) && !empty($_GET['bookx_author_id'])) {
				$this->bookx_filter_active ++;
				$this->filtered_author_id = (int)$_GET['bookx_author_id'];

				$this->flag_show_product_bookx_filter_author_extra_info  = bookx_get_show_product_switch('author', 'SHOW_', '_FILTER_EXTRA_INFO');
				if (BOOKX_LAYOUT_FLAG_OPTION_DONT_DISPLAY < (int)$this->flag_show_product_bookx_filter_author_extra_info ) {
					$sql = 'SELECT ba.author_name, ba.author_image, bad.author_description, ba.author_url
							FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' bad ON bad.bookx_author_id = ba.bookx_author_id AND bad.languages_id = "' . (int)$_SESSION['languages_id'] . '"
							WHERE ba.bookx_author_id = "' . (int)$this->filtered_author_id . '"';
					$author = $db->Execute($sql);

					if (!empty($author->fields['author_image']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_author_extra_info) {
						$extra_html .= '<div id="bookx_filter_author_image">' . zen_image(DIR_WS_IMAGES . $author->fields['author_image'], $author->fields['author_name'], BOOKX_AUTHOR_IMAGE_WIDTH, BOOKX_AUTHOR_IMAGE_MAX_HEIGHT) . '</div>';
					}

					if (!empty($author->fields['author_description']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_author_extra_info) {
						$extra_html .= '<div id="bookx_filter_author_description">' . zen_html_entity_decode($author->fields['author_description']) . '</div>';
					}

					if (!empty($author->fields['author_url']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_author_extra_info) {
					    $author_url = strpos($author->fields['author_url'], 'http') ? $author->fields['author_url'] : 'http://' . $author->fields['author_url'];
						$extra_html .= '<a id="bookx_filter_author_url" href="' .  $author_url . '" target="_blank">' . BOOKX_URL_LINK_TEXT_AUTHOR . '</a>';
					}
				}
			}
			
			if(isset($_GET['bookx_author_type_id']) && !empty($_GET['bookx_author_type_id'])) {
			    $this->bookx_filter_active ++;
			    $this->filtered_author_type_id = (int)$_GET['bookx_author_type_id'];
			
			    $this->flag_show_product_bookx_filter_author_type_extra_info  = bookx_get_show_product_switch('author_type', 'SHOW_', '_FILTER_EXTRA_INFO');
			    if (BOOKX_LAYOUT_FLAG_OPTION_DONT_DISPLAY < (int)$this->flag_show_product_bookx_filter_author_type_extra_info ) {
			        $sql = 'SELECT atd.type_description, atd.type_image
		                    FROM ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . '
							WHERE atd.bookx_author_type_id = "' . (int)$this->filtered_author_type_id . '" AND atd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
			        $author_type = $db->Execute($sql);
			
			        if (!empty($author_type->fields['type_image']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_author_type_extra_info) {
			            $extra_html .= '<div id="bookx_filter_author_type_image">' . zen_image(DIR_WS_IMAGES . $author_type->fields['type_image'], $author_type->fields['type_description'], BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</div>';
			        }
			
			        if (!empty($author_type->fields['type_description']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_author_type_extra_info) {
			            $extra_html .= '<div id="bookx_filter_author_type_description">' . zen_html_entity_decode($author_type->fields['type_description']) . '</div>';
			        }
			
			    }
			}

			if(isset($_GET['bookx_publisher_id']) && !empty($_GET['bookx_publisher_id'])) {
				$this->bookx_filter_active ++;
				$this->filtered_publisher_id = (int)$_GET['bookx_publisher_id'];

				$this->flag_show_product_bookx_filter_publisher_extra_info  = bookx_get_show_product_switch('publisher', 'SHOW_', '_FILTER_EXTRA_INFO');
				if (BOOKX_LAYOUT_FLAG_OPTION_DONT_DISPLAY < (int)$this->flag_show_product_bookx_filter_publisher_extra_info ) {
					$sql = 'SELECT pub.publisher_name, pub.publisher_image, pubd.publisher_description, pubd.publisher_url
							FROM ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' pub
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS_DESCRIPTION . ' pubd ON pubd.bookx_publisher_id = pub.bookx_publisher_id AND pubd.languages_id = "' . (int)$_SESSION['languages_id'] . '"
							WHERE pub.bookx_publisher_id = "' . (int)$this->filtered_publisher_id . '"';
					$publisher = $db->Execute($sql);
					if (!empty($publisher->fields['publisher_image']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_publisher_extra_info) {
						$extra_html .= '<div id="bookx_filter_publisher_image">' . zen_image(DIR_WS_IMAGES . $publisher->fields['publisher_image'], $publisher->fields['publisher_name'], BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</div>';
					}

					if (!empty($publisher->fields['publisher_description']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_publisher_extra_info) {
						$extra_html .= '<div id="bookx_filter_publisher_description">' . zen_html_entity_decode($publisher->fields['publisher_description']) . '</div>';
					}

					if (!empty($publisher->fields['publisher_url']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_publisher_extra_info) {
					    $publisher_url = strpos($publisher->fields['publisher_url'], 'http') ? $publisher->fields['publisher_url'] : 'http://' . $publisher->fields['publisher_url'];
						$extra_html .= '<a id="bookx_filter_publisher_url" href="' . $publisher_url . '" target="_blank">' . BOOKX_URL_LINK_TEXT_PUBLISHER . '</a>';
					}
				}
			}

			if(isset($_GET['bookx_imprint_id']) && !empty($_GET['bookx_imprint_id'])) {
				$this->bookx_filter_active ++;
				$this->filtered_imprint_id = (int)$_GET['bookx_imprint_id'];

				$this->flag_show_product_bookx_filter_imprint_extra_info  = bookx_get_show_product_switch('imprint', 'SHOW_', '_FILTER_EXTRA_INFO');
				if (BOOKX_LAYOUT_FLAG_OPTION_DONT_DISPLAY < (int)$this->flag_show_product_bookx_filter_imprint_extra_info ) {
					$sql = 'SELECT i.imprint_name, i.imprint_image, id.imprint_description
							FROM ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' i
							LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS_DESCRIPTION . ' id ON id.bookx_imprint_id = i.bookx_imprint_id AND id.languages_id = "' . (int)$_SESSION['languages_id'] . '"
							WHERE i.bookx_imprint_id = "' . (int)$this->filtered_imprint_id . '"';
					$imprint = $db->Execute($sql);
					if (!empty($imprint->fields['imprint_image']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_imprint_extra_info) {
						$extra_html .= '<div id="bookx_filter_imprint_image">' . zen_image(DIR_WS_IMAGES . $imprint->fields['imprint_image'], $imprint->fields['imprint_name'], BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</div>';
					}

					if (!empty($imprint->fields['imprint_description']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_imprint_extra_info) {
						$extra_html .= '<div id="bookx_filter_imprint_description">' . zen_html_entity_decode($imprint->fields['imprint_description']) . '</div>';
					}
				}
			}

			if(isset($_GET['bookx_series_id']) && !empty($_GET['bookx_series_id'])) {
				$this->bookx_filter_active ++;
				$this->filtered_series_id = (int)$_GET['bookx_series_id'];

				$this->flag_show_product_bookx_filter_series_extra_info  = bookx_get_show_product_switch('series', 'SHOW_', '_FILTER_EXTRA_INFO');
				if (BOOKX_LAYOUT_FLAG_OPTION_DONT_DISPLAY < (int)$this->flag_show_product_bookx_filter_series_extra_info ) {
					$sql = 'SELECT sd.series_name, sd.series_image, sd.series_description
							FROM ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' sd
							WHERE sd.bookx_series_id = "' . (int)$this->filtered_series_id . '" AND sd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
					$series = $db->Execute($sql);
					if (!empty($series->fields['series_image']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_series_extra_info) {
						$extra_html .= '<div id="bookx_filter_series_image_container">' . zen_image(DIR_WS_IMAGES . $series->fields['series_image'], $series->fields['series_name'],'','','id="bookx_filter_series_image"') . '</div>';
					}

					if (!empty($series->fields['series_description']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_series_extra_info) {
						$extra_html .= '<div id="bookx_filter_series_description">' . zen_html_entity_decode($series->fields['series_description']) . '</div>';
					}
				}
			}

			if(isset($_GET['bookx_genre_id']) && !empty($_GET['bookx_genre_id'])) {
				$this->bookx_filter_active ++;
				$this->filtered_genre_id = (int)$_GET['bookx_genre_id'];

				$this->flag_show_product_bookx_filter_genre_extra_info  = bookx_get_show_product_switch('genre', 'SHOW_', '_FILTER_EXTRA_INFO');
				if (BOOKX_LAYOUT_FLAG_OPTION_DONT_DISPLAY < (int)$this->flag_show_product_bookx_filter_genre_extra_info ) {
					$sql = 'SELECT gd.genre_description AS genre_name, gd.genre_image
							FROM ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' gd
							WHERE gd.bookx_genre_id = "' . (int)$this->filtered_genre_id . '" AND gd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
					$genre = $db->Execute($sql);

					if (!empty($genre->fields['genre_image']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_genre_extra_info) {
						$extra_html .= '<div id="bookx_filter_genre_image">' . zen_image(DIR_WS_IMAGES . $genre->fields['genre_image'], $genre->fields['genre_name'], BOOKX_ICONS_MAX_WIDTH, BOOKX_ICONS_MAX_HEIGHT) . '</div>';
					}

					/*if (!empty($genre->fields['genre_description']) || BOOKX_LAYOUT_FLAG_OPTION_ALWAYS_DISPLAY == (int)$this->flag_show_product_bookx_filter_genre_extra_info) {
						$extra_html .= '<div id="bookx_filter_genre_description">' . $genre->fields['genre_description'] . '</div>';
					}*/
				}
			}

			if (1 == $this->bookx_filter_active) {
				//** only one filter is active, so it makes sense to insert filter specific info
				$extra_bookx_filter_term_info .= $extra_html;
			} else {
				$extra_bookx_filter_term_info = null;
			}
			
			$extra_bookx_filter_term_info .= $extra_show_only_stocked_html;
		}

	}

	function check_pType_filters_and_reset(&$callingClass, $notifier, $paramsArray) {
		$all_filters_blank = false;
		// release bookx_author_id when nothing is there so a blank filter is not setup.
		// this will result in the home page, if used
		if (isset ( $_GET ['bookx_author_id'] ) && empty($_GET ['bookx_author_id'])) {
			unset ( $_GET ['bookx_author_id'] );
			unset ( $callingClass->bookx_author_id );
			$all_filters_blank = true;
		}

		// release bookx_author_type_id when nothing is there so a blank filter is not setup.
		// this will result in the home page, if used
		if (isset ( $_GET ['bookx_author_type_id'] ) && empty($_GET ['bookx_author_type_id'])) {
			unset ( $_GET ['bookx_author_type_id'] );
			unset ( $callingClass->bookx_author_type_id );
		} else {
			$all_filters_blank = false;
		}

		// release bookx_author_type_id when nothing is there so a blank filter is not setup.
		// this will result in the home page, if used
		if (isset ( $_GET ['bookx_author_type_id'] ) && empty($_GET ['bookx_author_type_id'])) {
			unset ( $_GET ['bookx_author_type_id'] );
			unset ( $callingClass->bookx_author_type_id );
		} else {
			$all_filters_blank = false;
		}

		// only release bookxfilter if all bookx filters are blank
		// this will result in the home page, if used
		/*if ($all_filters_blank) {
			unset ( $_GET ['bookxfilter'] );
			unset ( $callingClass->bookxfilter );
		}*/
	}

	function insert_bookx_attributes_into_search_query(&$callingClass, $notifier, $paramsArray) {
		global $db, $from_str, $where_str, $keywords, $search_keywords;

		$extra_from = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' srchbe ON srchbe.products_id = p.products_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' srchbed ON srchbed.products_id = p.products_id AND srchbed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' srchbatp ON srchbatp.products_id = p.products_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' srchba ON srchba.bookx_author_id = srchbatp.bookx_author_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' srchbi ON srchbi.bookx_imprint_id = srchbe.bookx_imprint_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' srchbpub ON srchbpub.bookx_publisher_id = srchbe.bookx_publisher_id
				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' srchbsd ON srchbsd.bookx_series_id = srchbe.bookx_series_id
				     	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' srchbgtp ON srchbgtp.products_id = srchbe.products_id
				     	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' srchbgd ON srchbgd.bookx_genre_id = srchbgtp.bookx_genre_id ';

		$from_str .= $extra_from;

		for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
			//$extra_where = '';
			switch ($search_keywords[$i]) {
				case '(':
				case ')':
				case 'and':
				case 'or':
					//$extra_where .= " " . $search_keywords[$i] . " ";
					break;
				default:

					$extra_where = " OR srchbed.products_subtitle LIKE '%:keywords%'
									  OR srchba.author_name LIKE '%:keywords%'
									  OR srchbpub.publisher_name LIKE '%:keywords%'
									  OR srchbsd.series_name LIKE '%:keywords%'
									  OR srchbgd.genre_description LIKE '%:keywords%'
									  OR srchbi.imprint_name LIKE '%:keywords%'";

					$isbn_test = str_replace('-', '', $search_keywords[$i]);
					if (ctype_digit($isbn_test)) {
						$extra_where .= " OR srchbe.isbn LIKE '%" . $isbn_test . "%'";
					}

					$extra_where = $db->bindVars($extra_where, ':keywords', $search_keywords[$i], 'noquotestring');

					$where_str = str_replace("pd.products_name LIKE '%" . $search_keywords[$i] . "%'", "pd.products_name LIKE '%" . $search_keywords[$i] . "%'" . $extra_where, $where_str);
					break;
			}
		}
	}

	/**
	 * This function gets triggered by the file "includes/modules/[ACTIVE TEMPLATE]/new_products.php"
	 * and it adds some bookx specific query items to the database query
	 */
	function insert_bookx_attributes_into_new_products_query(&$callingClass, $notifier, $paramsArray) {
		global $db, $new_products_query, $new_products;

		// @TODO New stuff added by phill, check this
		if (!empty($new_products_query)) {
    		$this->loadFilterValues();
    
    		$extra_having = '';
    		$extra_join_condition = '';
    		$additional_bookx_fields = '';
    		$extra_join = '';
    		$group_by = '';
    		
    		$bookx_new_products_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;
    		if (!empty($bookx_new_products_look_back_number_of_days)) {
    		    $additional_bookx_fields .= ',p.products_quantity, be.publishing_date,p.products_date_available,
    		                                 DATEDIFF("' . date('Y-m-d') . '",
													  CONCAT_WS("-",
														        SUBSTRING(be.publishing_date, 1,4 ),
														        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
														        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))
                                                               )
                                                      ) AS pubdate_diff_today';
    			/*$extra_join_condition = ' AND (be.publishing_date IS NOT NULL) AND (DATEDIFF("' . date('Y-m-d') . '",
    																						  CONCAT_WS("-",
    																							        SUBSTRING(be.publishing_date, 1,4 ),
    																							        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
    																							        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))
    			                                                                                       )
    			                                                                             )
    																				BETWEEN 0 AND ' . intval($bookx_new_products_look_back_number_of_days) . ') ';*/
    			//$extra_having .= ' AND (be.publishing_date IS NOT NULL) AND p.products_quantity > 0 ';
    		    $extra_having = ' HAVING (be.publishing_date IS NOT NULL)  /* we have a BookX publishing date enterd */
    		                      AND (   		                            
    		                             /* pub date is less than "number of days to look BACK" into the past (i.e. a "new" product) and stock is more than zero or date expected is set */
    		                             (( pubdate_diff_today BETWEEN 0 AND ' . intval($bookx_new_products_look_back_number_of_days) . ') AND (p.products_quantity > 0 OR (p.products_date_available IS NOT NULL AND p.products_date_available >= "' . date('Y-m-d') . '")))
    		                          )';
    		}
    
    		$extra_join = ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = pd.products_id ' . $extra_join_condition
    				     .' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = pd.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
    
    						///****** keep these commented JOINs here in case we want to implement more fields later
    
    				        /*LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' srchbatp ON srchbatp.products_id = p.products_id
    				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' srchba ON srchba.bookx_author_id = srchbatp.bookx_author_id
    				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_IMPRINTS . ' srchbi ON srchbi.bookx_imprint_id = srchbe.bookx_imprint_id
    				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PUBLISHERS . ' srchbpub ON srchbpub.bookx_publisher_id = srchbe.bookx_publisher_id
    				        LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' srchbsd ON srchbsd.bookx_series_id = srchbe.bookx_series_id
    				     	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' srchbgtp ON srchbgtp.products_id = srchbe.products_id
    				     	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' srchbgd ON srchbgd.bookx_genre_id = srchbgtp.bookx_genre_id ';*/
    
    		$name_replacement_field = 'pd.products_description, CONCAT_WS(""
    											  ,pd.products_name
    											  ,IF(NULLIF(be.volume, "") IS NOT NULL, CONCAT_WS("", " <span class=\'bookxProdVolume\'>", REPLACE("' . LABEL_BOOKX_VOLUME . '", "%s", be.volume), "</span>"), "")
    											  ,IF(NULLIF(bed.products_subtitle, "") IS NOT NULL, CONCAT_WS("", " &ndash; <span class=\'bookxProdSubtitle\'>", bed.products_subtitle, "</span>"), "")
    											  ) AS products_name';
    
    		//** authors
    		if ($this->flag_show_product_bookx_listing_authors) {
    			if ($this->flag_show_product_bookx_listing_authors_with_type_below_sort_order ) {
    				$additional_author_join_condition = ' AND bat.type_sort_order < "' . $this->flag_show_product_bookx_listing_authors_with_type_below_sort_order . '" ';
    			} else {
    				$additional_author_join_condition = '';
    			}
    
    			$extra_join .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.products_id = be.products_id
    							 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON batp.bookx_author_id = ba.bookx_author_id ';
    						/* .' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' bat ON bat.bookx_author_type_id = batp.bookx_author_type_id ' . $additional_author_join_condition .
    						   ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' batd ON batd.bookx_author_type_id = batp.bookx_author_type_id AND batd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';		*/
    
    		//	if ($this->flag_show_product_bookx_listing_author_type ) {
    		//		$additional_bookx_fields .= ', GROUP_CONCAT(DISTINCT CONCAT_WS("", IF("" = IFNULL(batd.type_description,""), "", CONCAT_WS("", "<span class=\"bookxLabel\">", batd.type_description , ": </span>")), ba.author_name) ORDER BY bat.type_sort_order ASC SEPARATOR " &middot; ") AS authors';
    
    		//	} else {
    				$additional_bookx_fields .= ', GROUP_CONCAT(DISTINCT ba.author_name ORDER BY ba.author_name ASC SEPARATOR " &middot; ") AS authors';
    		//	}
    
    			$group_by .= ' GROUP BY p.products_id ';
    		}
    
    		$new_products_query = str_replace('pd.products_name', $name_replacement_field . $additional_bookx_fields, $new_products_query);
    		$new_products_query = str_replace(' where ', $extra_join . ' where ', $new_products_query);
    		$new_products_query .= $group_by . $extra_having;
    		$new_products_query .= ' ORDER BY be.publishing_date DESC, p.products_date_available DESC';
		}
    }

	/**
	 * This function gets triggered by the file "includes/modules/[ACTIVE TEMPLATE]/new_products.php"
	 * and it adds some bookx specific data to the $list_box_contents array
	 */
	function insert_bookx_attributes_into_new_products_listing(&$callingClass, $notifier, $paramsArray) {
		global $list_box_contents, $productsInCategory, $title, $new_products_category_id;
		global $new_products; /* @var $new_products queryFactoryResult */


		if(!empty($new_products)) {
		    $num_products_count = $new_products->RecordCount();
		
		    // show only when 1 or more
		    if ($num_products_count > 0) {
		
		        if (isset($new_products_category_id) && $new_products_category_id != 0) {
		            $category_title = zen_get_categories_name((int)$new_products_category_id);
		            $title = '<h3 class="bookxNewProduct"><label>' . sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')) . ($category_title != '' ? ' - ' . $category_title : '' ) . '</label></h3>';
		        } else {
		            $title = '<h3 class="bookxNewProduct"><label>' . sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')) . '</label></h3>';
		        }
		
		        if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS == 0 ) {
		            $col_width = floor(100/$num_products_count);
		        } else {
		            $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS);
		        }
		
		
		        $new_products->Move(0);
		        
		        // This seemed to be necessary in ZC Versions up to 1.5.3, but not anymore in 1.5.5
		        if (1 <= intval(PROJECT_VERSION_MAJOR) && '5.5' < floatval(PROJECT_VERSION_MINOR)) {
		        
    		        // don't understand why this is necessary, but without it shows the first entry twice ?!
    		        $new_products->cursor = 0;
    		        $new_products->MoveNext();
    		        // eof ?!!?
		        }
		
		        $row = 0;
		        $col = 0;
		        while (!$new_products->EOF) {
		            $products_price = zen_get_products_display_price($new_products->fields['products_id']); //zen_get_products_actual_price($products_id)
		            if (!isset($productsInCategory[$new_products->fields['products_id']])) $productsInCategory[$new_products->fields['products_id']] = zen_get_generated_category_path_rev($new_products->fields['master_categories_id']);
					// DO we need to add this to the url ? It messes if using url rewrite
		            $product_detail_url = zen_href_link(zen_get_info_page($new_products->fields['products_id']), 'cPath=' . $productsInCategory[$new_products->fields['products_id']] . '&products_id=' . $new_products->fields['products_id'] . '&typefilter=bookx&bookx_publishing_status=new');
		
		            $list_box_contents[$row][$col] = array('params' => 'class="centerBoxContentsNew centeredContent "' . ' ' . 'style="float: left; width:' . $col_width . '%;"',
		                'text' => (($new_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . $product_detail_url . '" class="bookxProductImage">' . zen_image(DIR_WS_IMAGES . $new_products->fields['products_image'], $new_products->fields['products_name'], IMAGE_PRODUCT_NEW_WIDTH, IMAGE_PRODUCT_NEW_HEIGHT) . '</a><br />')
		                . '<a href="' . $product_detail_url . '" class="bookxProductName">' . $new_products->fields['products_name'] . '</a><br />'
		                . '<h2 class="bookxAuthors">' . $new_products->fields['authors'] . '</h2>'
		                . ('-1' == BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS || '0' < BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS ?
		                    '    <div class="newDescriptionCell">' . ( '-1' == BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS ? $new_products->fields['products_description'] : bookx_truncate_paragraph($new_products->fields['products_description'], BOOKX_NEW_PRODUCTS_SHOW_PRODUCT_DESCRIPTION_NUMOFCHARS)) . ' <a href="' . $product_detail_url . '">' . TEXT_BOOKX_MORE_PRODUCT_INFO . '</a></div>'
		                    : '' )
		                . $products_price);
		
		            $col ++;
		            if ($col > (SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS - 1)) {
		                $col = 0;
		                $row ++;
		            }
		
		            $new_products->MoveNext();
		        }	
		    }
		}
	}

	/**
	 * This function gets triggered by the file "includes/modules/[ACTIVE TEMPLATE]/upcoming_products.php"
	 * and it adds some bookx specific query items to the database query
	 */
	function insert_bookx_attributes_into_upcoming_products_query(&$callingClass, $notifier, $paramsArray) {
		global $db, $expected_query, $expected;
		
		if (!empty($expected_query)) {
    		$this->loadFilterValues();
			
			// @TODO new stuff added by phill. Check this
			
			$additional_bookx_fields = '';
    		$extra_join = '';
    		$extra_having = '';
    		$extra_where_condition = '';
    		$group_by = '';
    		$bookx_upcoming_products_look_ahead_number_of_days = BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS;
    		$bookx_new_products_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;
    		
    		if (!empty($bookx_upcoming_products_look_ahead_number_of_days)) {
    			//*** WHERE condition: publishing_date is set and with maximum days into the future and past as set by Admin values "look ahead" and "look back"
    			
    		    $additional_bookx_fields .= ',p.products_quantity,
    		                                 DATEDIFF("' . date('Y-m-d') . '",
													  CONCAT_WS("-",
														        SUBSTRING(be.publishing_date, 1,4 ),
														        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
														        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))
                                                               )
                                                      ) AS pubdate_diff_today';
    			/*$extra_where_condition = ' OR ((be.publishing_date IS NOT NULL) AND ((DATEDIFF("' . date('Y-m-d') . '",
    																						  CONCAT_WS("-",
    																							        SUBSTRING(be.publishing_date, 1,4 ),
    																							        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
    																							        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 ))
    			                                                                                       )
    			                                                                              )
    																				 BETWEEN -' . intval($bookx_upcoming_products_look_ahead_number_of_days) . ' AND ' . '0' . // replaced by '0' : intval($bookx_new_products_look_back_number_of_days) 
    			                                                                    ')
    			                                                                    )
    			                                                                 )) '; */
    			
    			//$extra_having = ' AND p.products_quantity < 1';
    		    $extra_having = ' HAVING (be.publishing_date IS NOT NULL)  /* we have a BookX publishing date entered */
    		                      AND (
    		                              /* pub date is less than "number of days to look AHEAD" into the future */
    		                             (pubdate_diff_today BETWEEN -' . intval($bookx_upcoming_products_look_ahead_number_of_days) . ' AND 0)
    		                           OR
    		                             /* pub date is less than "number of days to look BACK" into the past (i.e. a "new" product) but stock is still zero and no date expected is set or in the past*/
    		                             (( pubdate_diff_today BETWEEN 0 AND ' . intval($bookx_new_products_look_back_number_of_days) . ') AND p.products_quantity < 1 AND (date_expected IS NULL OR date_expected < "' . date('Y-m-d') . '"))
    		                          )';
    		}
    
    		$extra_join .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON be.products_id = pd.products_id
    						 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON bed.products_id = pd.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
    
    		$name_replacement_field = ' be.publishing_date, pd.products_description, p.products_image,
    									 CONCAT_WS(""
    											  ,pd.products_name
    											  ,IF(NULLIF(be.volume, "") IS NOT NULL, CONCAT_WS("", " <span class=\'bookxProdVolume\'>", REPLACE("' . LABEL_BOOKX_VOLUME . '", "%s", be.volume), "</span>"), "")
    											  ,IF(NULLIF(bed.products_subtitle, "") IS NOT NULL, CONCAT_WS("", " &ndash; <span class=\'bookxProdSubtitle\'>", bed.products_subtitle, "</span>"), "")
    											  ) AS products_name,
    									CASE WHEN DAYOFMONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_SHORT . '")
    										  WHEN MONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_MONTH_AND_YEAR . '")
    										  ELSE YEAR(be.publishing_date)
    									 END AS formatted_publishing_date';
    		/*$date_replacement_field = ' IF((p.products_date_available IS NULL) OR (p.products_date_available = "0000-00-00 00:00:00"), be.publishing_date, p.products_date_available) AS date_expected,
    									CASE WHEN DAYOFMONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_SHORT . '")
    															  WHEN MONTH(be.publishing_date) THEN DATE_FORMAT(be.publishing_date, "' . DATE_FORMAT_MONTH_AND_YEAR . '")
    															  ELSE YEAR(be.publishing_date)
    									END AS formatted_publishing_date';*/
    
    		if ($this->flag_show_product_bookx_listing_authors) {
    			//$new_product_text = '<h2 class="bookxAuthors">' . $expectedItems[$i]['authors'] . '</h2>';
    		}
    
    		if ($this->flag_show_product_bookx_listing_pages) $additional_bookx_fields .= ', be.pages ';
    		if ($this->flag_show_product_bookx_listing_size) $additional_bookx_fields .= ', be.size ';
    
    		if ($this->flag_show_product_bookx_listing_isbn) $additional_bookx_fields .= ', CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1)) AS isbn_display ';
    		;
    
    		if ($this->flag_show_product_bookx_listing_printing) {
    			$additional_bookx_fields .= ', printd.printing_description ';
    			$extra_join .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION . ' printd ON printd.bookx_printing_id = be.bookx_printing_id AND printd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
    		}
    
    		if ($this->flag_show_product_bookx_listing_binding) {
    			$additional_bookx_fields .= ', bd.binding_description ';
    			$extra_join .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION . ' bd ON bd.bookx_binding_id = be.bookx_binding_id AND bd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
    		}
    
    		if ($this->flag_show_product_bookx_listing_condition) {
    			$additional_bookx_fields .= ', cd.condition_description ';
    			$extra_join .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION . ' cd ON cd.bookx_condition_id = be.bookx_condition_id AND cd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
    		}
    
    		if ($this->flag_show_product_bookx_listing_model) $additional_bookx_fields .= ', p.products_model ';;
    
    		//** authors
    		if ($this->flag_show_product_bookx_listing_authors) {
    			if ($this->flag_show_product_bookx_listing_authors_with_type_below_sort_order ) {
    				$additional_author_join_condition = ' AND bat.type_sort_order < "' . $this->flag_show_product_bookx_listing_authors_with_type_below_sort_order . '" ';
    			} else {
    				$additional_author_join_condition = '';
    			}
    
    			$extra_join .= ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' batp ON batp.products_id = be.products_id
    							 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' ba ON batp.bookx_author_id = ba.bookx_author_id
    							 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' bat ON bat.bookx_author_type_id = batp.bookx_author_type_id ' . $additional_author_join_condition .
    						   ' LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' batd ON batd.bookx_author_type_id = batp.bookx_author_type_id AND batd.languages_id = "' . (int)$_SESSION['languages_id'] . '"';
    
    		//	LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHORS_DESCRIPTION . ' bad ON bad.bookx_author_id = ba.bookx_author_id AND bad.languages_id = "' . (int)$_SESSION['languages_id'] . '"
    
    
    			if ($this->flag_show_product_bookx_listing_author_type ) {
    				$additional_bookx_fields .= ', GROUP_CONCAT(DISTINCT CONCAT_WS("", IF("" = IFNULL(batd.type_description,""), "", CONCAT_WS("", "<span class=\"bookxLabel\">", batd.type_description , ": </span>")), ba.author_name) ORDER BY bat.type_sort_order ASC SEPARATOR " &middot; ") AS authors';
    
    			} else {
    				$additional_bookx_fields .= ', GROUP_CONCAT(ba.author_name ORDER BY ba.author_name ASC SEPARATOR " &middot; ") AS authors';
    			}
    
    			$group_by .= ' GROUP BY p.products_id ';
    		}
    
    		$expected_query = str_replace('pd.products_name', $name_replacement_field . $additional_bookx_fields, $expected_query);
    		$expected_query = str_replace(' where ', $extra_join . ' where ', $expected_query);
    		$date_available_clause = zen_get_upcoming_date_range();
    		$expected_query = str_replace($date_available_clause, '', $expected_query);
    		
    		/*if(!empty($extra_where_condition)) {
    		  $expected_query = str_replace(' p.products_date_available ', ' (p.products_date_available ', $expected_query);
    		}*/
    		//$expected_query = str_replace('products_date_available as date_expected', $date_replacement_field, $expected_query);
    
    		//$expected_query = $extra_having;
    		$expected_query = str_replace(' order by date_expected ', $extra_where_condition . $group_by . $extra_having . ' ORDER BY date_expected, be.publishing_date, p.products_date_available ', $expected_query);
		}
	}
	
	/**
	 * This function gets triggered by the file "includes/modules/[ACTIVE TEMPLATE]/product_listing_alpha_sorter.php"
	 * and it adds a hidden field to the alpha sorter HTML form, so any active BookX filter will be kept active when sorting
	 */
	function insert_bookx_hidden_field_into_alpha_sorter(&$callingClass, $notifier, $paramsArray) {
	    if (isset($_GET['typefilter']) && 'bookx' == $_GET['typefilter']) {
			if (isset($_GET['bookx_author_id']) && '' != $_GET['bookx_author_id']) {
			   echo zen_draw_hidden_field('bookx_author_id', $_GET['bookx_author_id']);
			}

			if (isset($_GET['bookx_publisher_id']) && '' != $_GET['bookx_publisher_id']) {
			   echo zen_draw_hidden_field('bookx_publisher_id', $_GET['bookx_publisher_id']);
			}

			if (isset($_GET['bookx_imprint_id']) && '' != $_GET['bookx_imprint_id']) {
			  echo zen_draw_hidden_field('bookx_imprint_id', $_GET['bookx_imprint_id']);
			}

			if (isset($_GET['bookx_series_id']) && '' != $_GET['bookx_series_id']) {
			  echo zen_draw_hidden_field('bookx_series_id', $_GET['bookx_series_id']);
			}

			if (isset($_GET['bookx_genre_id']) && '' != $_GET['bookx_genre_id']){
			  echo zen_draw_hidden_field('bookx_genre_id', $_GET['bookx_genre_id']);
			}
		    if (isset($_GET['bookx_publishing_status']) && '' != $_GET['bookx_publishing_status']){
			    echo zen_draw_hidden_field('bookx_publishing_status', $_GET['bookx_publishing_status']);
		    }
	    }
	}
}