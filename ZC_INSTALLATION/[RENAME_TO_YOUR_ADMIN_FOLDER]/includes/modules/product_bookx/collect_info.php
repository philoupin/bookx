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
 * @version $Id: collect_info.php 2016-02-02 philou $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$sql = 'SELECT configuration_group_id FROM ' . TABLE_CONFIGURATION_GROUP . ' WHERE configuration_group_title = "BookX";';

$config_groups = $db->Execute($sql);

$boox_configuration_group_id = null;

while (!$config_groups->EOF) {
	$boox_configuration_group_id = $config_groups->fields['configuration_group_id'];
	$config_groups->MoveNext();
}

$sql = 'SELECT configuration_id FROM '. TABLE_CONFIGURATION . ' WHERE configuration_key = "BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS";';

$config = $db->Execute($sql);

$boox_configuration_pubdate_look_back_id = null;

while (!$config->EOF) {
	$boox_configuration_pubdate_look_back_id = $config->fields['configuration_id'];
	$config->MoveNext();
}

$sql = 'SELECT configuration_id FROM '. TABLE_CONFIGURATION . ' WHERE configuration_key = "BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS";';

$config = $db->Execute($sql);

$boox_configuration_pubdate_look_ahead_id = null;

while (!$config->EOF) {
    $boox_configuration_pubdate_look_ahead_id = $config->fields['configuration_id'];
    $config->MoveNext();
}

/* @var $db queryFactory */
$parameters = array('products_name' => '',
                   'products_description' => '',
                   'products_url' => '',
                   'products_id' => '',
    		'products_subtitle' => '',
    		'bookx_publisher_id' => '',
    		'bookx_series_id' => '',
    		'bookx_imprint_id' => '',
    		'bookx_binding_id' => '',
    		'bookx_condition_id' => '',
    		'publishing_date' => '',
    		'pages' => '',
    		'volume' => '',
    		'size' => '',
    		'isbn' => '',
    		'isbn_display' => '',
                   'products_quantity' => '',
                   'products_model' => '',
                   'products_image' => '',
                   'products_price' => '',
                   'products_virtual' => DEFAULT_PRODUCT_BOOKX_PRODUCTS_VIRTUAL,
                   'products_weight' => '',
                   'products_date_added' => '',
                   'products_last_modified' => '',
                   'products_date_available' => '',
                   'products_status' => '',
                   'products_tax_class_id' => DEFAULT_PRODUCT_BOOKX_TAX_CLASS_ID,
                   'manufacturers_id' => '',
                   'products_quantity_order_min' => '',
                   'products_quantity_order_units' => '',
                   'products_priced_by_attribute' => '',
                   'product_is_free' => '',
                   'product_is_call' => '',
                   'products_quantity_mixed' => '',
                   'product_is_always_free_shipping' => DEFAULT_PRODUCT_BOOKX_PRODUCTS_IS_ALWAYS_FREE_SHIPPING,
                   'products_qty_box_status' => SHOW_PRODUCT_BOOKX_INFO_QUANTITY,
                   'products_quantity_order_max' => '0',
                   'products_sort_order' => '0',
                   'products_discount_type' => '0',
                   'products_discount_type_from' => '0',
                   'products_price_sorter' => '0',
                   'master_categories_id' => ''
                   );

$pInfo = new objectInfo($parameters);

if (isset($_GET['pID']) && !empty($_GET['pID'])) {
	$pID = (int)$_GET['pID'];
} else {
	$pID = null;
}

$product_assigned_authors = array();
$product_assigned_genres = array();


if ($pID && empty($_POST)) { //" . DATE_FORMAT_SHORT . "
  $sql = 'SELECT pd.products_name, pd.products_description, pd.products_url,
                                  p.products_id, p.products_quantity, p.products_model, p.manufacturers_id,
                                  p.products_image, p.products_price, p.products_virtual, p.products_weight,
                                  p.products_date_added, p.products_last_modified,
                                  DATE_FORMAT(p.products_date_available, "%Y-%m-%d") AS
                                  products_date_available, p.products_status, p.products_tax_class_id,

                                  be.bookx_publisher_id, be.bookx_series_id, be.bookx_imprint_id, be.bookx_binding_id, be.bookx_printing_id, be.bookx_condition_id,
  								  DATE_FORMAT(be.publishing_date, "%Y-%m-%d") AS publishing_date, be.pages, be.volume, be.size, be.isbn,
								  CONCAT_WS("-", SUBSTRING(be.isbn,1,3), SUBSTRING(be.isbn,4,1), SUBSTRING(be.isbn,5,6), SUBSTRING(be.isbn,11,2), SUBSTRING(be.isbn,13,1)) AS isbn_display,
  								  DATEDIFF("' . date('Y-m-d') . '",
										  CONCAT_WS("-",
											        SUBSTRING(be.publishing_date, 1,4 ),
											        IF(SUBSTRING(be.publishing_date, 6,2 ) = "00", "01", SUBSTRING(be.publishing_date, 6,2 ) ),
											        IF(SUBSTRING(be.publishing_date, 9,2 )  = "00", "01", SUBSTRING(be.publishing_date, 9,2 )))) AS pub_date_diff,

                                  p.products_quantity_order_min, p.products_quantity_order_units, p.products_priced_by_attribute,
                                  p.product_is_free, p.product_is_call, p.products_quantity_mixed,
                                  p.product_is_always_free_shipping, p.products_qty_box_status, p.products_quantity_order_max,
                                  p.products_sort_order,
                                  p.products_discount_type, p.products_discount_type_from,
                                  p.products_price_sorter, p.master_categories_id
                          FROM ' . TABLE_PRODUCTS . ' p
                          LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON p.products_id = pd.products_id AND pd.language_id = "' . (int)$_SESSION['languages_id'] . '"
                          LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON p.products_id = be.products_id
                          WHERE p.products_id = "' . $pID . '"';
  $product = $db->Execute($sql);

  $pInfo->objectInfo($product->fields);

  $assigned_authors =  $db->Execute('SELECT * FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS_TO_PRODUCTS . ' WHERE products_id = ' . $pID);
  

  while (!$assigned_authors->EOF) {
  	$product_assigned_authors[] = array('primary_id' => $assigned_authors->fields['primary_id'], 'bookx_author_id' => $assigned_authors->fields['bookx_author_id'], 'bookx_author_type_id' => $assigned_authors->fields['bookx_author_type_id']);
  	$assigned_authors->MoveNext();
  }

  $assigned_genres =  $db->Execute('SELECT * FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' WHERE products_id = ' . $pID);

  while (!$assigned_genres->EOF) {
  	$product_assigned_genres[] = array('primary_id' => $assigned_genres->fields['primary_id'], 'bookx_genre_id' => $assigned_genres->fields['bookx_genre_id']);
  	$assigned_genres->MoveNext();
  }

} elseif (zen_not_null($_POST)) {
  $pInfo->objectInfo($_POST);
  $products_name = $_POST['products_name'];
  $products_descriptions = $_POST['products_description'];
  $products_url = $_POST['products_url'];
  // bookx extra fields
  $products_subtitle = $_POST['products_subtitle'];

  if (isset($_POST['bookx_genre_id']) && is_array($_POST['bookx_genre_id']) && !empty($_POST['bookx_genre_id'])) {
  	$bookx_genre_ids = $_POST['bookx_genre_id'];
  	foreach ($bookx_genre_ids as $genre_id) {
  		$product_assigned_genres[] = array('primary_id' => '', 'bookx_genre_id' => $genre_id);
  	}
  }

  if (isset($_POST['bookx_author_id']) && is_array($_POST['bookx_author_id']) && !empty($_POST['bookx_author_id'])) {
  	$bookx_author_ids = $_POST['bookx_author_id'];
  	foreach ($bookx_author_ids as $key => $author_id) {
  		$bookx_author_type_id = (isset($_POST['bookx_author_type_id']) && is_array($_POST['bookx_author_type_id']) && !empty($_POST['bookx_author_type_id']) ? $_POST['bookx_author_type_id'][$key] : '');
  		$product_assigned_authors[] = array('primary_id' => '', 'bookx_author_id' => $author_id, 'bookx_author_type_id' => $bookx_author_type_id);
  	}
  }
}

//** look for additional custom collect_info*.php files and include now **//
$incl_dir = @dir(DIR_FS_ADMIN . '/includes/modules/product_bookx');
while ($file = $incl_dir->read()) {
	if ('collect_info_' == substr($file, 0, 13) && 'collect_info_metatags.php' != $file) {
		include_once DIR_FS_ADMIN . '/includes/modules/product_bookx/' . $file; // This should fill variable $extra_html which will be included below
	}
}
$incl_dir->close();

/*$pub_date_month_has_no_day = 'true';
if (isset($pInfo->publishing_date) && '00' != substr($pInfo->publishing_date, 8, 2)) {
	$pub_date_month_has_no_day = 'false';
}*/

$authors_array = array(array('id' => '', 'text' => TEXT_NONE));
$authors = $db->Execute('SELECT bookx_author_id, author_name, author_default_type
                         FROM ' . TABLE_PRODUCT_BOOKX_AUTHORS . ' order by author_sort_order, author_name');
while (!$authors->EOF) {
  $authors_array[] = array('id' => $authors->fields['bookx_author_id'],
                           'text' => $authors->fields['author_name'],
  						   'default_type' => $authors->fields['author_default_type']);
  $authors->MoveNext();
}

$author_types_array = array(array('id' => '', 'text' => TEXT_NONE));
$author_types = $db->Execute('SELECT at.bookx_author_type_id, atd.type_description
                               FROM ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES . ' at
							  LEFT JOIN ' . TABLE_PRODUCT_BOOKX_AUTHOR_TYPES_DESCRIPTION . ' atd ON at.bookx_author_type_id = atd.bookx_author_type_id AND atd.languages_id = "' . $_SESSION['languages_id'] . '" ORDER BY at.type_sort_order, atd.type_description');

while (!$author_types->EOF) {
	$author_types_array[] = array('id' => $author_types->fields['bookx_author_type_id'],
								  'text' => $author_types->fields['type_description']);
	$author_types->MoveNext();
}

$publisher_array = array(array('id' => '', 'text' => TEXT_NONE));
$publisher = $db->Execute("select bookx_publisher_id, publisher_name
                               from " . TABLE_PRODUCT_BOOKX_PUBLISHERS . " ORDER BY publisher_name ASC");
while (!$publisher->EOF) {
  $publisher_array[] = array('id' => $publisher->fields['bookx_publisher_id'],
                                 'text' => $publisher->fields['publisher_name']);
  $publisher->MoveNext();
}

$imprint_array = array(array('id' => '', 'text' => TEXT_NONE));
$imprint = $db->Execute("select bookx_imprint_id, imprint_name
                               from " . TABLE_PRODUCT_BOOKX_IMPRINTS . " ORDER BY imprint_name ASC");
while (!$imprint->EOF) {
	$imprint_array[] = array('id' => $imprint->fields['bookx_imprint_id'],
			'text' => $imprint->fields['imprint_name']);
	$imprint->MoveNext();
}

$genre_array = array(array('id' => '', 'text' => TEXT_NONE));
$genre = $db->Execute('SELECT g.bookx_genre_id, gd.genre_description
                       FROM ' . TABLE_PRODUCT_BOOKX_GENRES . ' g
					   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . ' gd ON g.bookx_genre_id = gd.bookx_genre_id AND gd.languages_id = "' . $_SESSION['languages_id'] . '" ORDER BY gd.genre_description ASC');

while (!$genre->EOF) {
  $genre_array[] = array('id' => $genre->fields['bookx_genre_id'],
                                 'text' => $genre->fields['genre_description']);
  $genre->MoveNext();
}

$series_array = array(array('id' => '', 'text' => TEXT_NONE));
$series = $db->Execute('SELECT s.bookx_series_id, sd.series_name
                       FROM ' . TABLE_PRODUCT_BOOKX_SERIES . ' s
					   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . ' sd ON s.bookx_series_id = sd.bookx_series_id AND sd.languages_id = "' . $_SESSION['languages_id'] . '" ORDER BY sd.series_name ASC');

while (!$series->EOF) {
	$series_array[] = array('id' => $series->fields['bookx_series_id'],
			'text' => $series->fields['series_name']);
	$series->MoveNext();
}

$binding_array = array(array('id' => '', 'text' => TEXT_NONE));
$binding = $db->Execute('SELECT b.bookx_binding_id, bd.binding_description
                       FROM ' . TABLE_PRODUCT_BOOKX_BINDING . ' b
					   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_BINDING_DESCRIPTION . ' bd ON b.bookx_binding_id = bd.bookx_binding_id AND bd.languages_id = "' . $_SESSION['languages_id'] . '" ORDER BY b.binding_sort_order, bd.binding_description');

while (!$binding->EOF) {
	$binding_array[] = array('id' => $binding->fields['bookx_binding_id'],
			'text' => $binding->fields['binding_description']);
	$binding->MoveNext();
}

$printing_array = array(array('id' => '', 'text' => TEXT_NONE));
$printing = $db->Execute('SELECT p.bookx_printing_id, pd.printing_description
                       FROM ' . TABLE_PRODUCT_BOOKX_PRINTING . ' p
					   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_PRINTING_DESCRIPTION . ' pd ON p.bookx_printing_id = pd.bookx_printing_id AND pd.languages_id = "' . $_SESSION['languages_id'] . '" ORDER BY p.printing_sort_order, pd.printing_description');

while (!$printing->EOF) {
	$printing_array[] = array('id' => $printing->fields['bookx_printing_id'],
			'text' => $printing->fields['printing_description']);
	$printing->MoveNext();
}

$condition_array = array(array('id' => '', 'text' => TEXT_NONE));
$condition = $db->Execute('SELECT c.bookx_condition_id, cd.condition_description
                       FROM ' . TABLE_PRODUCT_BOOKX_CONDITIONS . ' c
					   LEFT JOIN ' . TABLE_PRODUCT_BOOKX_CONDITIONS_DESCRIPTION . ' cd ON c.bookx_condition_id = cd.bookx_condition_id AND cd.languages_id = "' . $_SESSION['languages_id'] . '" ORDER BY c.condition_sort_order, cd.condition_description');

while (!$condition->EOF) {
	$condition_array[] = array('id' => $condition->fields['bookx_condition_id'],
			'text' => $condition->fields['condition_description']);
	$condition->MoveNext();
}

$manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
$manufacturers = $db->Execute("select manufacturers_id, manufacturers_name
                               from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
while (!$manufacturers->EOF) {
	$manufacturers_array[] = array('id' => $manufacturers->fields['manufacturers_id'],
			'text' => $manufacturers->fields['manufacturers_name']);
	$manufacturers->MoveNext();
}

$tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
$tax_class = $db->Execute("select tax_class_id, tax_class_title
                                 from " . TABLE_TAX_CLASS . " order by tax_class_title");
while (!$tax_class->EOF) {
  $tax_class_array[] = array('id' => $tax_class->fields['tax_class_id'],
                             'text' => $tax_class->fields['tax_class_title']);
  $tax_class->MoveNext();
}

$languages = zen_get_languages();

if (!isset($pInfo->products_status)) $pInfo->products_status = '1';
switch ($pInfo->products_status) {
  case '0': $in_status = false; $out_status = true; break;
  case '1':
  default: $in_status = true; $out_status = false;
    break;
}
// set to out of stock if categories_status is off and new product or existing products_status is off
if (zen_get_categories_status($current_category_id) == '0' and $pInfo->products_status != '1') {
  $pInfo->products_status = 0;
  $in_status = false;
  $out_status = true;
}

// Virtual Products
    if (!isset($pInfo->products_virtual)) $pInfo->products_virtual = DEFAULT_PRODUCT_MUSIC_PRODUCTS_VIRTUAL;
    switch ($pInfo->products_virtual) {
      case '0': $is_virtual = false; $not_virtual = true; break;
      case '1': $is_virtual = true; $not_virtual = false; break;
      default: $is_virtual = false; $not_virtual = true;
    }
// Always Free Shipping
    if (!isset($pInfo->product_is_always_free_shipping)) $pInfo->product_is_always_free_shipping = DEFAULT_PRODUCT_MUSIC_PRODUCTS_IS_ALWAYS_FREE_SHIPPING;
    switch ($pInfo->product_is_always_free_shipping) {
      case '0': $is_product_is_always_free_shipping = false; $not_product_is_always_free_shipping = true; $special_product_is_always_free_shipping = false; break;
      case '1': $is_product_is_always_free_shipping = true; $not_product_is_always_free_shipping = false; $special_product_is_always_free_shipping = false; break;
      case '2': $is_product_is_always_free_shipping = false; $not_product_is_always_free_shipping = false; $special_product_is_always_free_shipping = true; break;
      default: $is_product_is_always_free_shipping = false; $not_product_is_always_free_shipping = true;$special_product_is_always_free_shipping = false; break;
    }
// products_qty_box_status shows
    if (!isset($pInfo->products_qty_box_status)) $pInfo->products_qty_box_status = PRODUCTS_QTY_BOX_STATUS;
    switch ($pInfo->products_qty_box_status) {
      case '0': $is_products_qty_box_status = false; $not_products_qty_box_status = true; break;
      case '1': $is_products_qty_box_status = true; $not_products_qty_box_status = false; break;
      default: $is_products_qty_box_status = true; $not_products_qty_box_status = false;
    }
// Product is Priced by Attributes
    if (!isset($pInfo->products_priced_by_attribute)) $pInfo->products_priced_by_attribute = '0';
    switch ($pInfo->products_priced_by_attribute) {
      case '0': $is_products_priced_by_attribute = false; $not_products_priced_by_attribute = true; break;
      case '1': $is_products_priced_by_attribute = true; $not_products_priced_by_attribute = false; break;
      default: $is_products_priced_by_attribute = false; $not_products_priced_by_attribute = true;
    }
// Product is Free
    if (!isset($pInfo->product_is_free)) $pInfo->product_is_free = '0';
    switch ($pInfo->product_is_free) {
      case '0': $in_product_is_free = false; $out_product_is_free = true; break;
      case '1': $in_product_is_free = true; $out_product_is_free = false; break;
      default: $in_product_is_free = false; $out_product_is_free = true;
    }
// Product is Call for price
    if (!isset($pInfo->product_is_call)) $pInfo->product_is_call = '0';
    switch ($pInfo->product_is_call) {
      case '0': $in_product_is_call = false; $out_product_is_call = true; break;
      case '1': $in_product_is_call = true; $out_product_is_call = false; break;
      default: $in_product_is_call = false; $out_product_is_call = true;
    }
// Products can be purchased with mixed attributes retail
    if (!isset($pInfo->products_quantity_mixed)) $pInfo->products_quantity_mixed = '0';
    switch ($pInfo->products_quantity_mixed) {
      case '0': $in_products_quantity_mixed = false; $out_products_quantity_mixed = true; break;
      case '1': $in_products_quantity_mixed = true; $out_products_quantity_mixed = false; break;
      default: $in_products_quantity_mixed = true; $out_products_quantity_mixed = false;
    }

// set image overwrite
  $on_overwrite = true;
  $off_overwrite = false;
// set image delete
  $on_image_delete = false;
  $off_image_delete = true;
?>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<style>
<!--
.bookx-data {
	background-color: #ffdb94;
}

.bookx_article_status_explain {
	margin-left: 15px;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script type="text/javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "products_date_available","btnDate1","<?php echo $pInfo->products_date_available; ?>",scBTNMODE_CUSTOMBLUE);
  var datePublished = new ctlSpiffyCalendarBox("datePublished", "new_product", "publishing_date","btnDate2","<?php echo $pInfo->publishing_date; ?>",scBTNMODE_CUSTOMBLUE);

//--></script>
<script type="text/javascript">
var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo 'tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . zen_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}

function getTaxRate() {
  var selected_value = document.forms["new_product"].products_tax_class_id.selectedIndex;
  var parameterVal = document.forms["new_product"].products_tax_class_id[selected_value].value;

  if ( (parameterVal > 0) && (tax_rates[parameterVal] > 0) ) {
    return tax_rates[parameterVal];
  } else {
    return 0;
  }
}

function updateGross() {
  var taxRate = getTaxRate();
  var grossValue = document.forms["new_product"].products_price.value;

  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }

  document.forms["new_product"].products_price_gross.value = doRound(grossValue, 4);
}

function updateNet() {
  var taxRate = getTaxRate();
  var netValue = document.forms["new_product"].products_price_gross.value;

  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }

  document.forms["new_product"].products_price.value = doRound(netValue, 4);
}

var authorDefaulTypes = {
<?php $divider = '';
	foreach ($authors_array as $author) {
		if (array_key_exists('default_type', $author)) {
			echo  $divider, $author['id'] . ': ' . ($author['default_type'] ? $author['default_type'] : 'null');
			if ('' == $divider) $divider = ',';
		}
	}?>
};

function setAuthorDefaultType(authorSelect) {
	var authorSelectId = authorSelect.getAttribute("id");
	var authorTypeSelectId = "selecttype" + authorSelectId.substring(6);
	var authorId = authorSelect.options[authorSelect.selectedIndex].value;
	if (authorId in authorDefaulTypes) {
		var authorTypeSelect = document.getElementById(authorTypeSelectId);
		var opts = authorTypeSelect.options.length;
		for (var i=0; i<opts; i++){
		    if (authorTypeSelect.options[i].value == authorDefaulTypes[authorId]){
		    	authorTypeSelect.options[i].selected = true;
		        break;
		    }
		}
	}
}

var authorCounter = null;
function addAuthorPulldown(counter) {
	if (null != authorCounter) {
		counter = authorCounter+1;
	}

	if (0 == counter) {
		counter = 1;
	}
	var br = document.createElement("br");

	var authorLabel = document.createTextNode(<?php echo '"' . TEXT_PRODUCTS_BOOKX_AUTHOR . ' "'; ?>);
	var newAuthorSelect = document.getElementById("blank_bookx_author_id").cloneNode(true);

	newAuthorSelect.setAttribute("name", "bookx_author_id["+counter+"]");
	newAuthorSelect.setAttribute("id", "select"+counter);

	document.getElementById("author_pulldowns").appendChild(authorLabel);
	document.getElementById("author_pulldowns").appendChild(newAuthorSelect);

	<?php if (1 < count($author_types_array)) { //**** don't even include this code if there are zero author typed defined'?>
	var newAuthorTypeSelect = document.getElementById("blank_bookx_author_type_id").cloneNode(true);

	if (newAuthorTypeSelect.options.length > 1) {
		var authorTypeLabel = document.createTextNode(<?php echo '"  ' . TEXT_PRODUCTS_BOOKX_AUTHOR_TYPE . ' "'; ?>);
		newAuthorTypeSelect.setAttribute("name", "bookx_author_type_id["+counter+"]");
		newAuthorTypeSelect.setAttribute("id", "selecttype"+counter);

		document.getElementById("author_pulldowns").appendChild(authorTypeLabel);
		document.getElementById("author_pulldowns").appendChild(newAuthorTypeSelect);
	}
	<?php }?>
	document.getElementById("author_pulldowns").appendChild(br);

	authorCounter = counter;
}

var genreCounter = null;
function addGenrePulldown(counter) {
	if (null != genreCounter) {
		counter = genreCounter+1;
	}

	if (0 == counter) {
		counter = 1;
	}
	var br = document.createElement("br");

	var newGenreSelect = document.getElementById("blank_bookx_genre_id").cloneNode(true);

	newGenreSelect.setAttribute("name", "bookx_genre_id["+counter+"]");
	newGenreSelect.setAttribute("id", "select"+counter);

	document.getElementById("genre_pulldowns").appendChild(newGenreSelect);

	document.getElementById("genre_pulldowns").appendChild(br);

	genreCounter = counter;
}

function checkISBN() {
	  var isbnOrig = document.forms["new_product"].isbn.value;
		if (isbnOrig != "") {
			var isbnTXT = isbnOrig;

			while (isbnTXT.lastIndexOf("-") > 0 ) {
				isbnTXT = isbnTXT.replace(/-/,"");
				}

			isbnTXT = isbnTXT.substring(0,13);
			
			document.forms["new_product"].isbn.value = isbnTXT;
			
			var checkDigit = isbnTXT.charAt(12);

			checkDigit = parseInt(checkDigit);

	 		var calculatedCheckDigit = 10-((parseInt(isbnTXT.charAt(0)) + parseInt(isbnTXT.charAt(1))*3 + parseInt(isbnTXT.charAt(2)) + parseInt(isbnTXT.charAt(3))*3 + parseInt(isbnTXT.charAt(4)) + parseInt(isbnTXT.charAt(5))*3 + parseInt(isbnTXT.charAt(6)) + parseInt(isbnTXT.charAt(7))*3 + parseInt(isbnTXT.charAt(8))+ parseInt(isbnTXT.charAt(9))*3 + parseInt(isbnTXT.charAt(10))+ parseInt(isbnTXT.charAt(11))*3) %10);

			if (calculatedCheckDigit == "10") {
				calculatedCheckDigit = "0";
			}

			if (calculatedCheckDigit != checkDigit) {
				alert (<?php echo '"' . sprintf(TEXT_JAVASCRIPT_ISBN_WRONG_CHECKDIGIT, ' + isbnTXT + ', '+ calculatedCheckDigit +') . '"'; ?>);
			}

			if (13 == isbnTXT.length) {
				// CONCAT_WS("-", SUBSTRING(pe.isbn,1,3), SUBSTRING(pe.isbn,4,1), SUBSTRING(pe.isbn,5,6), SUBSTRING(pe.isbn,11,2), SUBSTRING(pe.isbn,13,1)) AS isbn_display,
				document.getElementById("isbn_display").innerHTML =  isbnTXT.substring(0,3) + '-' + isbnTXT.substring(3,4) + '-' + isbnTXT.substring(4,10) + '-' + isbnTXT.substring(10,12) + '-' + isbnTXT.substring(12);
			}
		}
	}

var localeMonthNames=new Array();
localeMonthNames[0]= "<?php echo strftime( '%B', mktime( 0, 0, 0, 1, 1 ) );?>";
localeMonthNames[1]="<?php echo strftime( '%B', mktime( 0, 0, 0, 2, 1 ) );?>";
localeMonthNames[2]="<?php echo strftime( '%B', mktime( 0, 0, 0, 3, 1 ) );?>";
localeMonthNames[3]="<?php echo strftime( '%B', mktime( 0, 0, 0, 4, 1 ) );?>";
localeMonthNames[4]="<?php echo strftime( '%B', mktime( 0, 0, 0, 5, 1 ) );?>";
localeMonthNames[5]="<?php echo strftime( '%B', mktime( 0, 0, 0, 6, 1 ) );?>";
localeMonthNames[6]="<?php echo strftime( '%B', mktime( 0, 0, 0, 7, 1 ) );?>";
localeMonthNames[7]="<?php echo strftime( '%B', mktime( 0, 0, 0, 8, 1 ) );?>";
localeMonthNames[8]="<?php echo strftime( '%B', mktime( 0, 0, 0, 9, 1 ) );?>";
localeMonthNames[9]="<?php echo strftime( '%B', mktime( 0, 0, 0, 10, 1 ) );?>";
localeMonthNames[10]="<?php echo strftime( '%B', mktime( 0, 0, 0, 11, 1 ) );?>";
localeMonthNames[11]="<?php echo strftime( '%B', mktime( 0, 0, 0, 12, 1 ) );?>";


function previewDisplayDate () {
	var dateDisplayString = '';
	var dateFormatShort = '<?php echo DATE_FORMAT_SHORT; ?>';
	var dateFormatMonthAndYear = '<?php echo DATE_FORMAT_MONTH_AND_YEAR; ?>';

	var dateString = document.forms["new_product"].publishing_date.value;
	var yearString = dateString.substring(0,4);
	var monthString = dateString.substring(5,7);
	var dayString = dateString.substring(8,10);

	var parsedDate = new Date(yearString, monthString, dayString);

	switch (true) {
		case ('00' == monthString):
			dateDisplayString = yearString;
			break;

		case ('00' == dayString):
			var mo = localeMonthNames[parsedDate.getMonth()];
			dateDisplayString = dateFormatMonthAndYear.replace('%Y', yearString).replace('%M', localeMonthNames[parsedDate.getMonth()]);
			break;

		default:
			dateDisplayString = dateFormatShort.replace('%Y', yearString).replace('%m', monthString).replace('%d', dayString);
		break;
	}
	document.getElementById("publishing_date_display").innerHTML =  dateDisplayString;
}

Date.daysBetween = function( date1, date2 ) {
	  //Get 1 day in milliseconds
	  var one_day=1000*60*60*24;

	  // Convert both dates to milliseconds
	  var date1_ms = date1.getTime();
	  var date2_ms = date2.getTime();

	  // Calculate the difference in milliseconds
	  var difference_ms = date2_ms - date1_ms;
	    
	  // Convert back to days and return
	  return Math.round(difference_ms/one_day); 
	}

Date.addDays = function( date1, numOfDays ) {
      var returnDate = new Date();
	 	    
	  // Add days and return
      returnDate.setDate(date1.getDate() + parseInt(numOfDays))
	  return returnDate; 

	}

function formatDateYmd(d) {
    	
    month = '' + (d.getMonth() + 1);
    day = '' + d.getDate();
    year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}


function determineBookxProductStatusMessage() {
	var statusMessage = '';
	
	var lookBackNoOfDays = <?php echo BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS; ?>;
	var lookAheadNoOfDays = <?php echo BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS; ?>;

	var zcProductStatus = document.forms["new_product"].products_status.value;
	var zcDateAvailable = document.forms["new_product"].products_date_available.value;
	var zcProductsQuantity = document.forms["new_product"].products_quantity.value;
	
	var publishingDate = document.forms["new_product"].publishing_date.value;
	var publishingDateObject = null;
	var dateDiff = null;
	var dateToday = new Date();

	var upcomingCutoffDate = Date.addDays(dateToday, <?php echo BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS; ?>);
	
	if ('' != publishingDate && publishingDate.length == 10) {
    	var publishingDateArray = [parseInt(publishingDate.substr(0,4)), parseInt(publishingDate.substr(5,2))-1, parseInt(publishingDate.substr(8,2))];
    	if (-1 == publishingDateArray[1]) publishingDateArray[1] = 0; /* Javascript months go from 0 to 11 */
    	if (0 == publishingDateArray[2]) publishingDateArray[2] = 1;
    	publishingDateObject = new Date(publishingDateArray[0], publishingDateArray[1], publishingDateArray[2], 1, 0, 0, 0);
    	dateDiff = Date.daysBetween(new Date(), publishingDateObject);
	}				        

	switch(true) {
		case (1 != zcProductStatus):
			/* Product status is set to not display */
			statusMessage = '<span class="alert"><?php echo TEXT_PRODUCT_STATUS_NOT_DISPLAYED_DUE_TO_PRODUCT_STATUS ; ?></span>';
		break;

		case (0 < zcProductsQuantity && '' != publishingDate && dateDiff !== null && dateDiff <= 0 && dateDiff > -1*lookBackNoOfDays):
			/* Product has a set Publishing Date and that date is in the past but within the range of a "new book". It also has available stock, so we treat as "new" */
			statusMessage = '<span class="bookx_article_status_explain"><?php printf(TEXT_PRODUCT_STATUS_DISPLAYED_AS_NEW, BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS) ; ?></span>';				
			break;

		case (0 == zcProductsQuantity && '' != publishingDate && dateDiff !== null && dateDiff <= 0 && dateDiff > -1*lookBackNoOfDays):
			/* There's no available stock and Product has a set Publishing Date and that date is in the past within the range of a "new book" */
			if ('' != zcDateAvailable && zcDateAvailable > formatDateYmd(dateToday)) {
				/* Product has a "Date Available" which is in the future, so we show it as coming soon */
				statusMessage = '<span class="bookx_article_status_explain"><?php echo TEXT_PRODUCT_STATUS_CONSIDERED_TEMPORARILY_UNAVAILABLE ; ?></span>';
			} else {
				/* We treat this book as still upcoming, since it is in the "new" range, but not yet in stock */
				statusMessage = '<span class="bookx_article_status_explain"><?php echo TEXT_PRODUCT_STATUS_CONSIDERED_NEW_BUT_UPCOMING_WITHOUT_STOCK ; ?></span>';
			}
			break;
		
		case (0 == zcProductsQuantity && ('' == publishingDate || ('' != publishingDate && dateDiff !== null && dateDiff < -1*lookBackNoOfDays)) ):	
			/* There's no available stock and Publishing Date is not set or older than range for "new" books  */

			if ('' != zcDateAvailable && zcDateAvailable > formatDateYmd(dateToday)) {
				/* Product has a "Date Available" which is in the future, so we show it as coming soon */
				statusMessage = '<span class="bookx_article_status_explain"><?php echo TEXT_PRODUCT_STATUS_CONSIDERED_TEMPORARILY_UNAVAILABLE ; ?></span>';
			} else {
				/* We treat this book as permanently out of stock */
				statusMessage = '<span class="bookx_article_status_explain"><?php echo TEXT_PRODUCT_STATUS_CONSIDERED_OUT_OF_PRINT ; ?></span>';
			}
			break;

		case (0 < zcProductsQuantity && ('' == publishingDate || ('' != publishingDate && dateDiff !== null && dateDiff < -1*lookBackNoOfDays)) ):	
			/* This book is in stock and Publishing Date is not set or older than range for "new" books, so we treat it as "available"  */
			statusMessage = '<span class="bookx_article_status_explain"><?php printf(TEXT_PRODUCT_STATUS_CONSIDERED_REGULAR_IN_STOCK, BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS) ; ?></span>';
		break;
			
		case ('' != publishingDate && dateDiff !== null && 0 < dateDiff && dateDiff <= lookAheadNoOfDays):
			/* Product has a set Publishing Date and that date is in the future but within the range of an "upcoming book", so we treat it as upcoming */
			statusMessage = '<?php printf(TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING, zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $boox_configuration_group_id . '&cID=' . $boox_configuration_pubdate_look_ahead_id), BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS) ; ?>';	

			if (0 < zcProductsQuantity) {
				/* This book also has available stock, so it can be (pre-)ordered */
				statusMessage = statusMessage + '<?php echo TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING_PREORDER_OPTION ; ?>';
			}

			statusMessage = '<span class="bookx_article_status_explain">' + statusMessage + '</span>';	
			break;

		case ('' != publishingDate && dateDiff !== null && dateDiff > lookAheadNoOfDays):
			/* Product has a set Publishing Date and that date is in the future but beyond the range of an "upcoming book", so Bookx will NOT display it */
			statusMessage = '<span class="bookx_article_status_explain"><?php printf(TEXT_PRODUCT_STATUS_NOT_DISPLAYED_SINCE_BEYOND_UPCOMING, BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS); ?>' + upcomingCutoffDate.toDateString() + '</span>';
			break;
			
		default:
			statusMessage = '<span class="bookx_article_status_explain"><?php echo TEXT_PRODUCT_STATUS_DEFAULT_CASE ; ?></span>';
	}

	if ( <?php echo SHOW_NEW_PRODUCTS_LIMIT ; ?> !== 0) {
		<?php $sql_config_value = 'SELECT * FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key="SHOW_NEW_PRODUCTS_LIMIT"';
              $check_configure = $db->Execute($sql_config_value);?>
		statusMessage += '<span class="bookx_article_status_explain"><?php printf(TEXT_ZC_NEW_PRODUCTS_LIMIT_WARNING, 
		                                                                          $check_configure->fields['configuration_title'], 
		                                                                          $check_configure->fields['configuration_value'],
		                                                                          zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $check_configure->fields['configuration_group_id'] . '&cID=' . $check_configure->fields['configuration_id'])
		                                                                         ); ?></span>';
		}
	
	document.getElementById("bookxProductStatusDisplay").innerHTML =  statusMessage;
}

$(document).ready(function() {
    determineBookxProductStatusMessage();
    previewDisplayDate();
    $( "input[name='products_date_available']" ).change(function(e) { determineBookxProductStatusMessage()});
    $( "input[name='publishing_date']" ).change(function(e) { determineBookxProductStatusMessage()});
    $( "input[name='products_status']" ).change(function(e) { determineBookxProductStatusMessage()});
    $( "input[name='products_quantity']" ).change(function(e) { determineBookxProductStatusMessage()});
	});


</script>
    <?php
//  echo $type_admin_handler;
echo zen_draw_form('new_product', $type_admin_handler , 'cPath=' . $cPath . (isset($_GET['product_type']) ? '&product_type=' . $_GET['product_type'] : '') . ($pID ? '&pID=' . $pID : '') . '&action=new_product_preview' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . ( (isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '') . ( (isset($_POST['search']) && !empty($_POST['search']) && empty($_GET['search'])) ? '&search=' . $_POST['search'] : ''), 'post', 'enctype="multipart/form-data"');
    ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td>
        	<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, zen_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
          <tr>
            <td id="bookxProductStatusDisplay" class="bookx-data">
            <?php
	            /*$bookx_new_product_look_back_number_of_days = BOOKX_NEW_PRODUCTS_LOOK_BACK_NUMBER_OF_DAYS;
	            $bookx_upcoming_products_look_ahead_number_of_days = BOOKX_UPCOMING_PRODUCTS_LOOK_AHEAD_NUMBER_OF_DAYS;

	            switch (true) {
	            	case (empty($pInfo->products_status)):
	            		echo '<span class="alert">' . TEXT_PRODUCT_STATUS_NOT_DISPLAYED_DUE_TO_PRODUCT_STATUS . '</span>';
	            	break;

	            	case (0 == $pInfo->products_quantity && !empty($pInfo->publishing_date) && $pInfo->pub_date_diff >= -intval($bookx_upcoming_products_look_ahead_number_of_days)):
	            		echo '<span class="bookx_article_status_explain">' . sprintf(TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING, $bookx_upcoming_products_look_ahead_number_of_days) . '</span>';
	            	break;

	            	case (0 == $pInfo->products_quantity && !empty($pInfo->products_date_available) && $pInfo->products_date_available > date('Y-m-d')):
	            		echo '<span class="bookx_article_status_explain">' . sprintf(TEXT_PRODUCT_STATUS_DISPLAYED_AS_UPCOMING_WITH_DATE_AVAILABLE) . '</span>';
	            		break;

	            	case (0 < $pInfo->products_quantity && !empty($pInfo->publishing_date) && 0 < $pInfo->pub_date_diff && abs($pInfo->pub_date_diff) <= intval($bookx_new_product_look_back_number_of_days)):
	            		echo '<span class="bookx_article_status_explain">' . sprintf(TEXT_PRODUCT_STATUS_DISPLAYED_AS_NEW, $bookx_new_product_look_back_number_of_days) . '</span>';
	            		break;

            		case (0 == $pInfo->products_quantity && empty($pInfo->date_available) && (empty($pInfo->publishing_date) || (!empty($pInfo->publishing_date) && 0 < $pInfo->pub_date_diff && abs($pInfo->pub_date_diff) > intval($bookx_new_product_look_back_number_of_days) ))):
            			echo '<span class="bookx_article_status_explain">' . TEXT_PRODUCT_STATUS_CONSIDERED_OUT_OF_PRINT . '</span>';
            			break;

        			case (0 < $pInfo->products_quantity):
        			    echo '<span class="bookx_article_status_explain">' . TEXT_PRODUCT_STATUS_CONSIDERED_REGULAR_IN_STOCK . '</span>';        			     
        			    break;
            			    
	            	default:
	            	    echo '<span class="bookx_article_status_explain">' . TEXT_PRODUCT_STATUS_DEFAULT_CASE . '</span>';
	            	break;
	            }*/
            ?>
            </td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right"><?php echo zen_draw_hidden_field('products_date_added', (zen_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . zen_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . ($pID ? '&pID=' . $pID : '') . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . ( (isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '') . ( (isset($_POST['search']) && !empty($_POST['search']) && empty($_GET['search'])) ? '&search=' . $_POST['search'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
<?php
// show when product is linked
if ($pID && zen_get_product_is_linked($pID) == 'true' && $pID > 0) {
?>
          <tr>
            <td class="main"><?php echo TEXT_MASTER_CATEGORIES_ID; ?></td>
            <td class="main">
              <?php
                // echo zen_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id);
                echo zen_image(DIR_WS_IMAGES . 'icon_yellow_on.gif', IMAGE_ICON_LINKED) . '&nbsp;&nbsp;';
                echo zen_draw_pull_down_menu('master_category', zen_get_master_categories_pulldown($pID), $pInfo->master_categories_id); ?>
            </td>
          </tr>
<?php } else { ?>
          <tr>
            <td class="main"><?php echo TEXT_MASTER_CATEGORIES_ID; ?></td>
            <td class="main"><?php echo TEXT_INFO_ID . ($pID > 0 ? $pInfo->master_categories_id  . ' ' . zen_get_category_name($pInfo->master_categories_id, $_SESSION['languages_id']) : $current_category_id  . ' ' . zen_get_category_name($current_category_id, $_SESSION['languages_id'])); ?></td>
          </tr>
<?php } ?>
          <tr>
            <td colspan="2" class="main"><?php echo TEXT_INFO_MASTER_CATEGORIES_ID; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '100%', '2'); ?></td>
          </tr>
<?php
// hidden fields not changeable on products page
echo zen_draw_hidden_field('master_categories_id', $pInfo->master_categories_id);
echo zen_draw_hidden_field('products_discount_type', $pInfo->products_discount_type);
echo zen_draw_hidden_field('products_discount_type_from', $pInfo->products_discount_type_from);
echo zen_draw_hidden_field('products_price_sorter', $pInfo->products_price_sorter);
?>
          <tr>
            <td colspan="2" class="main" align="center"><?php echo (zen_get_categories_status($current_category_id) == '0' ? TEXT_CATEGORIES_STATUS_INFO_OFF : '') . ($out_status == true ? ' ' . TEXT_PRODUCTS_STATUS_INFO_OFF : ''); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_status', '1', $in_status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . zen_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php if (isset($extra_html)) echo $extra_html; // this was possibly filled by an included file above ?>
          <tr>
            <td class="main" id="date_available_field"><?php echo TEXT_DATE_AVAILABLE; ?><br /><small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?><script type="text/javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php if (count($manufacturers_array) > 1) { ?>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php }

          		for ($i=0, $n=sizeof($languages); $i<$n; $i++) { ?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_NAME; ?></td>
            <td class="main"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('products_name[' . $languages[$i]['id'] . ']', htmlspecialchars(isset($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : zen_get_products_name($pInfo->products_id, $languages[$i]['id']), ENT_COMPAT, CHARSET, TRUE), zen_set_field_length(TABLE_PRODUCTS_DESCRIPTION, 'products_name')); ?></td>
          </tr>
		  <?php    } ?>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

		<!-- *** Field "Subtitle" starts here *** -->
          <?php for ($i=0, $n=sizeof($languages); $i<$n; $i++) { ?>
          <tr class="bookx-data">
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_BOOKX_SUBTITLE; ?></td>
            <td class="main"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('products_subtitle[' . $languages[$i]['id'] . ']', htmlspecialchars(isset($products_subtitle[$languages[$i]['id']]) ? stripslashes($products_subtitle[$languages[$i]['id']]) : bookx_get_products_subtitle($pInfo->products_id, $languages[$i]['id']), ENT_COMPAT, CHARSET, TRUE), zen_set_field_length(TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION, 'products_subtitle')); ?></td>
          </tr>
		  <?php    } ?>

          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!-- *** Field "Subtitle" ends here *** -->


          <!-- *** Field "Volume" starts here *** -->
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_VOLUME; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('volume', $pInfo->volume); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!-- *** Field "Volume" ends here *** -->



          <!-- *** Field "Series" starts here *** -->
			<?php if (1 < count($series_array)) { // no bindings defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_SERIES; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('bookx_series_id', $series_array, $pInfo->bookx_series_id); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php  } // end if loop ?>
			<!-- *** Field "Series" ends here *** -->


          <!-- *** Field "Authors" starts here *** -->
			<?php if (1 < count($authors_array)) { // no authors defined?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_AUTHORS; ?></td>
            <td class="main">
            	<div style="display: none;">
            		<?php
            			echo zen_draw_pull_down_menu('blank_bookx_author_id', $authors_array,'', 'id="blank_bookx_author_id" onChange="setAuthorDefaultType(this);"');
            			if (1 < count($author_types_array)) {
					  		echo zen_draw_pull_down_menu('blank_bookx_author_type_id', $author_types_array,'', 'id="blank_bookx_author_type_id"');
					  	}?>
            	</div>
            	<div id="author_pulldowns">
	            	<?php
	            	$author_counter = 0;
	            	/*if (null != $product_assigned_authors) {
					   while (!$product_assigned_authors->EOF) {*/
					foreach ($product_assigned_authors as $product_assigned_author) {
						  echo '<div class="drop_down_div">';
						  echo zen_draw_hidden_field('assigned_author_db_id[' . $author_counter . ']', $product_assigned_author['primary_id']);
						  echo TEXT_PRODUCTS_BOOKX_AUTHOR . '&nbsp;' . zen_draw_pull_down_menu('bookx_author_id[' . $author_counter . ']', $authors_array, $product_assigned_author['bookx_author_id']);
						  if (1 < count($author_types_array)) {
							  echo TEXT_PRODUCTS_BOOKX_AUTHOR_TYPE . '&nbsp;' . zen_draw_pull_down_menu('bookx_author_type_id[' . $author_counter . ']', $author_types_array, $product_assigned_author['bookx_author_type_id']);
						  };
						  echo '</div>';
						  $author_counter++;
					    }
					//}
				    ?>
			    </div>
			    <a href="javascript:void(0);" onclick="addAuthorPulldown(<?php echo $author_counter; ?>);"><?php echo TEXT_PRODUCTS_BOOKX_ADD_AUTHOR; ?></a>
			</td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php } // end if loop ?>
			<!-- *** Field "Authors" ends here *** -->


          <!-- *** Field "Publisher" starts here *** -->
          <?php if (1 < count($publisher_array)) { // no publishers defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_PUBLISHER; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('bookx_publisher_id', $publisher_array, $pInfo->bookx_publisher_id); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php } // end if loop ?>
           <!-- *** Field "Publisher" ends here *** -->


          <!-- *** Field "Imprint" starts here *** -->
				<?php if (1 < count($imprint_array)) { // no imprints defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_IMPRINT; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('bookx_imprint_id', $imprint_array, $pInfo->bookx_imprint_id); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php  } // end if loop ?>
			<!-- *** Field "Imprint" ends here *** -->



          <!-- *** Field "Publishing Date" starts here *** -->
          <tr class="bookx-data">
            <td class="main"><a id="publishing_date_field"></a><?php echo TEXT_PRODUCTS_BOOKX_PUBLISHING_DATE; ?><br /><small>(YYYY-MM-DD)</small></td>
            <td class="main">
            	<?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>
            	<script type="text/javascript">
            			datePublished.writeControl();
            			datePublished.dateFormat="yyyy-MM-dd";
                        var textInput = document.getElementsByName("publishing_date")[0];
                        if(textInput.addEventListener){
                        	textInput.addEventListener("change", previewDisplayDate, false);
                        } else if(textInput.attachEvent){
                        	textInput.attachEvent("change", previewDisplayDate);
                        }

                </script>
            	<?php
            		$bookx_np_number_of_days_edit_url = '<a href="' . zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $boox_configuration_group_id . '&cID=' . $boox_configuration_pubdate_look_back_id) . '" target="_admin_blank">' . TEXT_PRODUCTS_BOOKX_NEW_PRODUCTS_LOOK_BACKWARD_SETTING_LINK . '</a>';
            	echo '&nbsp; ' . TEXT_PRODUCTS_BOOKX_ISBN_DISPLAY . ' <span id="publishing_date_display"></span><br />' . zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_BOOKX_USE_PARTIAL_PUBLISHING_DATE . '<br />'. sprintf(TEXT_PRODUCTS_BOOKX_INFO_PUBLISHING_DATE_INFLUENCES_NEW_PRODUCT_DISPLAY, $bookx_new_product_look_back_number_of_days, $bookx_np_number_of_days_edit_url); ?>
            </td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!-- *** Field "Publishing Date" ends here *** -->


          <!-- *** Field "ISBN" starts here *** -->
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_ISBN; ?><br /></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('isbn', $pInfo->isbn, 'onchange="checkISBN()" size="15" maxlength= "20"');
            					   echo '&nbsp; ' . TEXT_PRODUCTS_BOOKX_ISBN_DISPLAY . '<span id="isbn_display">' . $pInfo->isbn_display . '</span>';
            					   ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!-- *** Field "ISBN" ends here *** -->


          <!-- *** Field "No. of pages" starts here *** -->
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_PAGES; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('pages', $pInfo->pages); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!-- *** Field "No. of pages" ends here *** -->


          <!-- *** Field "size" starts here *** -->
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_SIZE; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('size', $pInfo->size); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!-- *** Field "size" ends here *** -->




          <!-- *** Field "Binding" starts here *** -->
			<?php if (1 < count($binding_array)) { // no bindings defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_BINDING; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('bookx_binding_id', $binding_array, $pInfo->bookx_binding_id); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php  } // end if loop ?>
			<!-- *** Field "Binding" ends here *** -->


          <!-- *** Field "Printing" starts here *** -->
			<?php if (1 < count($printing_array)) { // no printings defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_PRINTING; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('bookx_printing_id', $printing_array, $pInfo->bookx_printing_id); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php  } // end if loop ?>
			<!-- *** Field "Printing" ends here *** -->


          <!-- *** Field "Condition" starts here *** -->
			<?php if (1 < count($condition_array)) { // no printings defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_CONDITION; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('bookx_condition_id', $condition_array, $pInfo->bookx_condition_id); ?></td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php  } // end if loop ?>
          <!-- *** Field "Condition" ends here *** -->


          <!-- *** Field "Genres" starts here *** -->
			<?php if (1 < count($genre_array)) { // no genres defined ?>
          <tr class="bookx-data">
            <td class="main"><?php echo TEXT_PRODUCTS_BOOKX_GENRES; ?></td>
            <td class="main">
            	<div style="display: none;">
            		<?php echo zen_draw_pull_down_menu('blank_bookx_genre_id', $genre_array,'', 'id="blank_bookx_genre_id"'); ?>
            	</div>
            	<div id="genre_pulldowns">
	            	<?php
	            	$genre_counter = 0;
	            	/*if (null != $product_assigned_genres) {
					    while (!$product_assigned_genres->EOF) {*/
					foreach ($product_assigned_genres as $product_assigned_genre) {
						  echo '<div class="drop_down_div">';
						  echo zen_draw_hidden_field('assigned_genre_db_id[' . $genre_counter . ']', $product_assigned_genre['primary_id']);
						  echo zen_draw_pull_down_menu('bookx_genre_id[' . $genre_counter . ']', $genre_array, $product_assigned_genre['bookx_genre_id']);
						  echo '</div>';
						  $genre_counter++;
					    }
					//}
				    ?>
			    </div>
			    <a href="javascript:void(0);" onclick="addGenrePulldown(<?php echo $genre_counter; ?>);"><?php echo TEXT_PRODUCTS_BOOKX_ADD_GENRE; ?></a>
			</td>
          </tr>
          <tr class="bookx-data">
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php } // end if loop ?>
			<!-- *** Field "Genres" ends here *** -->

		  <tr>
			<td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
		  </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_IS_FREE; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_free', '1', ($in_product_is_free==1)) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('product_is_free', '0', ($in_product_is_free==0)) . '&nbsp;' . TEXT_NO . ' ' . ($pInfo->product_is_free == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_IS_FREE_EDIT . '</span>' : ''); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_IS_CALL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_call', '1', ($in_product_is_call==1)) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('product_is_call', '0', ($in_product_is_call==0)) . '&nbsp;' . TEXT_NO . ' ' . ($pInfo->product_is_call == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_IS_CALL_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_priced_by_attribute', '1', $is_products_priced_by_attribute) . '&nbsp;' . TEXT_PRODUCT_IS_PRICED_BY_ATTRIBUTE . '&nbsp;&nbsp;' . zen_draw_radio_field('products_priced_by_attribute', '0', $not_products_priced_by_attribute) . '&nbsp;' . TEXT_PRODUCT_NOT_PRICED_BY_ATTRIBUTE . ' ' . ($pInfo->products_priced_by_attribute == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id, 'onchange="updateGross()"'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_price', $pInfo->products_price, 'onKeyUp="updateGross()"'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_price_gross', $pInfo->products_price, 'OnKeyUp="updateNet()"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_VIRTUAL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_virtual', '1', $is_virtual) . '&nbsp;' . TEXT_PRODUCT_IS_VIRTUAL . '&nbsp;' . zen_draw_radio_field('products_virtual', '0', $not_virtual) . '&nbsp;' . TEXT_PRODUCT_NOT_VIRTUAL . ' ' . ($pInfo->products_virtual == 1 ? '<br /><span class="errorText">' . TEXT_VIRTUAL_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING; ?></td>
            <td class="main" valign="top"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_always_free_shipping', '1', $is_product_is_always_free_shipping) . '&nbsp;' . TEXT_PRODUCT_IS_ALWAYS_FREE_SHIPPING . '&nbsp;' . zen_draw_radio_field('product_is_always_free_shipping', '0', $not_product_is_always_free_shipping) . '&nbsp;' . TEXT_PRODUCT_NOT_ALWAYS_FREE_SHIPPING  . '<br />' . zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_always_free_shipping', '2', $special_product_is_always_free_shipping) . '&nbsp;' . TEXT_PRODUCT_SPECIAL_ALWAYS_FREE_SHIPPING . ' ' . ($pInfo->product_is_always_free_shipping == 1 ? '<br /><span class="errorText">' . TEXT_FREE_SHIPPING_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QTY_BOX_STATUS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_qty_box_status', '1', $is_products_qty_box_status) . '&nbsp;' . TEXT_PRODUCTS_QTY_BOX_STATUS_ON . '&nbsp;' . zen_draw_radio_field('products_qty_box_status', '0', $not_products_qty_box_status) . '&nbsp;' . TEXT_PRODUCTS_QTY_BOX_STATUS_OFF . ' ' . ($pInfo->products_qty_box_status == 0 ? '<br /><span class="errorText">' . TEXT_PRODUCTS_QTY_BOX_STATUS_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY_MIN_RETAIL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity_order_min', ($pInfo->products_quantity_order_min == 0 ? 1 : $pInfo->products_quantity_order_min)); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY_MAX_RETAIL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity_order_max', $pInfo->products_quantity_order_max); ?>&nbsp;&nbsp;<?php echo TEXT_PRODUCTS_QUANTITY_MAX_RETAIL_EDIT; ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY_UNITS_RETAIL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity_order_units', ($pInfo->products_quantity_order_units == 0 ? 1 : $pInfo->products_quantity_order_units)); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MIXED; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_quantity_mixed', '1', $in_products_quantity_mixed) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('products_quantity_mixed', '0', $out_products_quantity_mixed) . '&nbsp;' . TEXT_NO; ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<script language="javascript"><!--
updateGross();
//--></script>
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td colspan="2"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" width="25" valign="top"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main" width="100%"><?php echo zen_draw_textarea_field('products_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '30', htmlspecialchars((isset($products_descriptions[$languages[$i]['id']])) ? stripslashes($products_descriptions[$languages[$i]['id']]) : zen_get_products_description($pInfo->products_id, $languages[$i]['id']), ENT_COMPAT, CHARSET, TRUE)); //,'id="'.'products_description' . $languages[$i]['id'] . '"'); ?></td>
              </tr>
            </table></td>
          </tr>
<?php
    }
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><a id="product_quantity_field"></a><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity', $pInfo->products_quantity); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_model', htmlspecialchars(stripslashes($pInfo->products_model), ENT_COMPAT, CHARSET, TRUE), zen_set_field_length(TABLE_PRODUCTS, 'products_model')); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
  $dir = @dir(DIR_FS_CATALOG_IMAGES);
  $dir_info = array();
  $dir_info[] = array('id' => '', 'text' => "Main Directory");
  while ($file = $dir->read()) {
    if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
      $dir_info[] = array('id' => $file . '/', 'text' => $file);
    }
  }
  $dir->close();
  sort($dir_info);

  $default_directory = substr( $pInfo->products_image, 0,strpos( $pInfo->products_image, '/')+1);
?>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_black.gif', '100%', '3'); ?></td>
          </tr>

          <tr>
            <td class="main" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo TEXT_PRODUCTS_IMAGE; ?></td>
                <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_file_field('products_image') . '&nbsp;' . ($pInfo->products_image !='' ? TEXT_IMAGE_CURRENT . $pInfo->products_image : TEXT_IMAGE_CURRENT . '&nbsp;' . NONE) . zen_draw_hidden_field('products_previous_image', $pInfo->products_image); ?></td>
                <td valign = "center" class="main"><?php echo TEXT_PRODUCTS_IMAGE_DIR; ?>&nbsp;<?php echo zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory); ?></td>
						  </tr>
              <tr>
                <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15'); ?></td>
                <td class="main" valign="top"><?php echo TEXT_IMAGES_DELETE . ' ' . zen_draw_radio_field('image_delete', '0', $off_image_delete) . '&nbsp;' . TABLE_HEADING_NO . ' ' . zen_draw_radio_field('image_delete', '1', $on_image_delete) . '&nbsp;' . TABLE_HEADING_YES; ?></td>
	  	    	  </tr>

              <tr>
                <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15'); ?></td>
                <td colspan="3" class="main" valign="top"><?php echo TEXT_IMAGES_OVERWRITE  . ' ' . zen_draw_radio_field('overwrite', '0', $off_overwrite) . '&nbsp;' . TABLE_HEADING_NO . ' ' . zen_draw_radio_field('overwrite', '1', $on_overwrite) . '&nbsp;' . TABLE_HEADING_YES; ?>
                  <?php echo '<br />' . TEXT_PRODUCTS_IMAGE_MANUAL . '&nbsp;' . zen_draw_input_field('products_image_manual'); ?></td>
              </tr>
            </table></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_black.gif', '100%', '3'); ?></td>
          </tr>
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_URL . '<br /><small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
            <td class="main"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('products_url[' . $languages[$i]['id'] . ']', htmlspecialchars(isset($products_url[$languages[$i]['id']]) ? $products_url[$languages[$i]['id']] : zen_get_products_url($pInfo->products_id, $languages[$i]['id']), ENT_COMPAT, CHARSET, TRUE), zen_set_field_length(TABLE_PRODUCTS_DESCRIPTION, 'products_url')); ?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_weight', $pInfo->products_weight); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_SORT_ORDER; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_sort_order', $pInfo->products_sort_order); ?></td>
          </tr>
                          <?php if (isset($extra_html_end)) echo $extra_html_end; // this was possibly filled by an included file above ?>

        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

      <tr>
        <td class="main" align="right"><?php echo zen_draw_hidden_field('products_date_added', (zen_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . ( (isset($_GET['search']) && !empty($_GET['search'])) ? zen_draw_hidden_field('search', $_GET['search']) : '') . ( (isset($_POST['search']) && !empty($_POST['search']) && empty($_GET['search'])) ? zen_draw_hidden_field('search', $_POST['search']) : '') . zen_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . ($pID ? '&pID=' . $pID : '') . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . ( (isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '') . ( (isset($_POST['search']) && !empty($_POST['search']) && empty($_GET['search'])) ? '&search=' . $_POST['search'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
    </table></form>
