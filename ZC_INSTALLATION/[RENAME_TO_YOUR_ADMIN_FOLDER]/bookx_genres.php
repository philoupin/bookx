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
 * @version $Id: [admin]/bookx_genres.php 2016-02-02 philou $
 */

/**
 * Product Type Book (BookX) Genres
 *
 * This file handles creating, editing and deleting
 * genre infos
 *
 */


  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $bookx_genre_id = null;
  if (isset($_GET['mID'])) {
  	$bookx_genre_id = zen_db_prepare_input($_GET['mID']);
  } elseif(isset($_POST['bookx_genre_id'])) {
  	$bookx_genre_id = zen_db_prepare_input($_POST['bookx_genre_id']);

  }

  if (zen_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($_GET['mID'])) $bookx_genre_id = zen_db_prepare_input($_GET['mID']);
        $genre_sort_order = zen_db_prepare_input($_POST['genre_sort_order']);

        $sql_data_array = array('genre_sort_order' => (int)$genre_sort_order, 'last_modified' => 'now()');

        if ($action == 'insert') {
          $insert_sql_data = array('date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          zen_db_perform(TABLE_PRODUCT_BOOKX_GENRES, $sql_data_array);
          $bookx_genre_id = zen_db_insert_id();
        } elseif ($action == 'save') {
          /*$update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);*/

          zen_db_perform(TABLE_PRODUCT_BOOKX_GENRES, $sql_data_array, 'update', "bookx_genre_id = '" . (int)$bookx_genre_id . "'");
        }

        $languages = zen_get_languages();
        $genre_description_array = $_POST['genre_description'];
        $genre_image_manual_array = $_POST['genre_image_manual'];
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        	$language_id = $languages[$i]['id'];
        	$genre_image_name = null;

        	if ($genre_image_manual_array[$language_id] != '') {
        		// add image manually
        		$genre_image_name = zen_db_input($_POST['img_dir'] . $genre_image_manual_array[$language_id]);
        		/*$db->Execute("update " . TABLE_PRODUCT_BOOKX_GENRES . "
                      set genre_image = '" .  $genre_image_name . "'
                      where bookx_genre_id = '" . (int)$bookx_genre_id . "'");*/
        	} else {
        		$genre_image = new upload('genre_image-' . $language_id);
        		$genre_image->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir']);
        		if ( $genre_image->parse() &&  $genre_image->save()) {
        			// remove image from database if none
        			if ($genre_image->filename != 'none') {
        				// remove image from database if none
        				$genre_image_name = zen_db_input($_POST['img_dir'] . $genre_image->filename);
        			}
        		}
        	}


          $sql_data_array = array('genre_description' => zen_db_prepare_input($genre_description_array[$language_id]), 'genre_image' => $genre_image_name);

          if ($action == 'insert' ||
          	  ($action == 'save' && null === bookx_get_genre_image_url($bookx_genre_id, $language_id))) {
            $insert_sql_data = array('bookx_genre_id' => $bookx_genre_id,
                                     'languages_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            zen_db_perform(TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'save') {
            zen_db_perform(TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION, $sql_data_array, 'update', "bookx_genre_id = '" . (int)$bookx_genre_id . "' and languages_id = '" . (int)$language_id . "'");
          }
        }
        
        if (isset($_POST['products_to_apply_genre']) && !empty($_POST['products_to_apply_genre']) && $bookx_genre_id){
            $selected_products = $_POST['products_to_apply_genre'];
            $values = '';
            $delimiter = '';
            foreach ($selected_products as $product_id) {
                $values .= $delimiter . '(' . $product_id . ',' . $bookx_genre_id . ')';
                $delimiter = ', ';
            }
            $query = 'REPLACE INTO ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' (products_id, bookx_genre_id) VALUES ' . $values . ';';
        
            $db->Execute($query);
        }
        
        if (isset($_POST['products_to_remove_genre']) && !empty($_POST['products_to_remove_genre']) && $bookx_genre_id){
            $selected_products = $_POST['products_to_remove_genre'];
            foreach ($selected_products as $product_id) {
                $query = 'DELETE FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . ' WHERE products_id = ' . $product_id . ' AND bookx_genre_id = ' . $bookx_genre_id;
                $db->Execute($query);
            }
        }

        if (isset($_POST['multiple_apply']) && $_POST['multiple_apply']) {
            // we are coming from the "multiple apply" part of the form, so we now continue with the "edit" part of the script
            $action = 'edit';
        } else {
            zen_redirect(zen_href_link(FILENAME_BOOKX_GENRES, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'mID=' . $bookx_genre_id));
        }
        break;
      case 'deleteconfirm':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page']));
        }
        $bookx_genre_id = zen_db_prepare_input($_POST['mID']);

        if (isset($_POST['delete_image']) && ($_POST['delete_image'] == 'on')) {
          $genres = $db->Execute("select genre_image
                                        from " . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . "
                                        where bookx_genre_id = '" . (int)$bookx_genre_id . "'");

          while (!$genres->EOF) {
          	$image_location = DIR_FS_CATALOG_IMAGES . $genres->fields['genre_image'];

          	if (file_exists($image_location)) @unlink($image_location);
          	$genres->MoveNext();
          }

        }

        $db->Execute("delete from " . TABLE_PRODUCT_BOOKX_GENRES . "
                      where bookx_genre_id = '" . (int)$bookx_genre_id . "'");
        $db->Execute("delete from " . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION . "
                      where bookx_genre_id = '" . (int)$bookx_genre_id . "'");

        if (isset($_POST['delete_products']) && ($_POST['delete_products'] == 'on')) {
          $products = $db->Execute("select p.products_id
                                             from " . TABLE_PRODUCT_BOOKX_EXTRA . " p
											 left join " . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS ." ptg ON ptg.products_id = p.products_id
                                             where ptg.bookx_genre_id = '" . (int)$bookx_genre_id . "'");

          while (!$products->EOF) {
            bookx_delete_product((int)$products->fields['products_id']);
            $products->MoveNext();
          }
        } else {
          $db->Execute("DELETE FROM " . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . "
                        WHERE bookx_genre_id =  '" . (int)$bookx_genre_id . "'");
        }

        zen_redirect(zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<?php if ($editor_handler != '') include_once ($editor_handler); ?>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
</head>
<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_GENRE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SORT_ORDER; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $genre_query_raw = 'select g.*, gd.genre_description, gd.genre_image from ' . TABLE_PRODUCT_BOOKX_GENRES . ' g LEFT JOIN ' . TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION. ' gd ON gd.bookx_genre_id = g.bookx_genre_id AND gd.languages_id = ' . $_SESSION['languages_id'] . ' order by g.genre_sort_order, gd.genre_description';
  $genre_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $genre_query_raw, $genre_query_numrows);
  $genre = $db->Execute($genre_query_raw);

  while (!$genre->EOF) {

    if ((!isset($_GET['mID']) || (isset($_GET['mID']) && ($_GET['mID'] == $genre->fields['bookx_genre_id']))) && !isset($aInfo) && (substr($action, 0, 3) != 'new')) {
	  $genre_products = $db->Execute("select count(p.products_id) as products_count
                                             from " . TABLE_PRODUCT_BOOKX_EXTRA . " p
											 left join " . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS ." ptg ON ptg.products_id = p.products_id
                                             where ptg.bookx_genre_id = '" . (int)$genre->fields['bookx_genre_id'] . "'");


      $aInfo_array = array_merge($genre->fields, $genre_products->fields);
      $aInfo = new objectInfo($aInfo_array);
    }

    if (isset($aInfo) && is_object($aInfo) && ($genre->fields['bookx_genre_id'] == $aInfo->bookx_genre_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $genre->fields['bookx_genre_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $genre->fields['bookx_genre_id'] . '&action=edit') . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $genre->fields['genre_description']; ?></td>
                <td class="dataTableContent"><?php echo $genre->fields['genre_sort_order']; ?></td>
                <td class="dataTableContent" align="right">
                  <?php echo '<a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $genre->fields['bookx_genre_id'] . '&action=edit') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>
                  <?php echo '<a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $genre->fields['bookx_genre_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>'; ?>
                  <?php if (isset($aInfo) && is_object($aInfo) && ($genre->fields['bookx_genre_id'] == $aInfo->bookx_genre_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_BOOKX_GENRES, zen_get_all_get_params(array('mID')) . 'mID=' . $genre->fields['bookx_genre_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                </td>
              </tr>
<?php
    $genre->MoveNext();
  }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $genre_split->display_count($genre_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_GENRES); ?></td>
                    <td class="smallText" align="right"><?php echo $genre_split->display_links($genre_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="3" class="smallText"><?php echo '<a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_genre_id . '&action=new') . '">' . zen_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_GENRE . '</b>');

      $contents = array('form' => zen_draw_form('genre', FILENAME_BOOKX_GENRES, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $dir = @dir(DIR_FS_CATALOG_IMAGES);
      $dir_info[] = array('id' => '', 'text' => "Main Directory");
      while ($file = $dir->read()) {
        if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
          $dir_info[] = array('id' => $file . '/', 'text' => $file);
        }
      }
      $dir->close();

      $default_directory = 'bookx_genres/';

      $genre_image_fields = '';
      $genre_manual_image_fields = '';
      $genre_description_textareas = '';
      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
		$language_image = zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']);
		$genre_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_file_field('genre_image-' . $languages[$i]['id']);

		$genre_manual_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('genre_image_manual[' . $languages[$i]['id'] . ']', '', zen_set_field_length(TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION, 'genre_image'));
      	$genre_description_textareas .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('genre_description[' . $languages[$i]['id'] . ']', '', zen_set_field_length(TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION, 'genre_description'));
	  }
	  $contents[] = array('text' => '<br>' . TEXT_GENRE_DESCRIPTION . $genre_description_textareas);

	  $contents[] = array('text' => '<BR />' . TEXT_GENRE_IMAGE_DIR . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));

	  $contents[] = array('text' => '<br>' . TEXT_GENRE_IMAGE . '<br>' . $genre_image_fields);
	  $contents[] = array('text' => '<br />' . TEXT_GENRE_IMAGE_MANUAL . '&nbsp;' . $genre_manual_image_fields);

      $contents[] = array('text' => '<br />' . TEXT_GENRE_SORT_ORDER . '<br>' . zen_draw_input_field('genre_sort_order'));

      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
      

   case 'edit':        

      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_GENRE . '</b>');

      $contents = array('form' => zen_draw_form('genre', FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_genre_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      //$contents[] = array('text' => '<br />' . TEXT_GENRE_IMAGE . '<br>' . zen_draw_file_field('genre_image') . '<br />' . $aInfo->genre_image);
      $dir = @dir(DIR_FS_CATALOG_IMAGES);
      $dir_info[] = array('id' => '', 'text' => "Main Directory");
      while ($file = $dir->read()) {
        if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
          $dir_info[] = array('id' => $file . '/', 'text' => $file);
        }
      }
      $dir->close();
      $default_directory = substr( $genre->fields['genre_image'], 0,strpos( $genre->fields['genre_image'], '/')+1);
      if (!$default_directory) {
			$default_directory = 'bookx_genres/';
		 }

      $genre_image_fields = '';
      $genre_manual_image_fields = '';
      $genre_description_textareas = '';
      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
		$language_image = zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']);
		$genre_description = bookx_get_genre_description($aInfo->bookx_genre_id, $languages[$i]['id']);
		$genre_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_file_field('genre_image-' . $languages[$i]['id']);

		$genre_manual_image_url = bookx_get_genre_image_url($aInfo->bookx_genre_id, $languages[$i]['id']);
		$genre_manual_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('genre_image_manual[' . $languages[$i]['id'] . ']', $genre_manual_image_url, zen_set_field_length(TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION, 'genre_image'));
		$genre_manual_image_fields .= '<br />' . (null != $genre_manual_image_url && '' != $genre_manual_image_url ? zen_info_image($genre_manual_image_url, $genre_description) : TEXT_GENRE_IMAGE_NOT_DEFINED);
		$genre_description_textareas .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('genre_description[' . $languages[$i]['id'] . ']', $genre_description, zen_set_field_length(TABLE_PRODUCT_BOOKX_GENRES_DESCRIPTION, 'genre_description'));
      }
      $contents[] = array('text' => '<br>' . TEXT_GENRE_DESCRIPTION . $genre_description_textareas);

      $contents[] = array('text' => '<BR />' . TEXT_GENRE_IMAGE_DIR . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));
      $contents[] = array('text' => '<br>' . TEXT_GENRE_IMAGE . '<br>' . $genre_image_fields);
      $contents[] = array('text' => '<br />' . TEXT_GENRE_IMAGE_MANUAL . '&nbsp;' . $genre_manual_image_fields);
     // $contents[] = array('text' => '<br />' . (null != $aInfo->genre_image && '' != $aInfo->genre_image ? zen_info_image($aInfo->genre_image, $aInfo->genre_description) : TEXT_GENRE_IMAGE_NOT_DEFINED));



      $contents[] = array('text' => '<br />' . TEXT_GENRE_SORT_ORDER . '<br>' . zen_draw_input_field('genre_sort_order', $aInfo->genre_sort_order));

      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_genre_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      
      ///***** multiple genre apply / remove
      $contents[] = array('params' => 'class="infoBoxHeading"', 'text' => '<strong>' . TEXT_APPLY_GENRE . '</strong>');
      
      $extra_fields = '';
      $extra_having_clause = '';
      if (isset($_POST['apply_genres_list_all_products']) && 'on' == $_POST['apply_genres_list_all_products'] &&
          isset($_POST['remove_genres_list_all_products']) && 'on' == $_POST['remove_genres_list_all_products']) {
          $flag_apply_genres_list_all_products = true;
      } else {
          $flag_apply_genres_list_all_products = false;
      }
      
      if (!$flag_apply_genres_list_all_products) {
          $extra_fields = ' , p.products_quantity,  p.products_date_available ';
          // $extra_in_stock_join_clause = ' LEFT JOIN ' . TABLE_PRODUCTS . ' p ON p.products_id = batp.products_id AND p.products_status > 0';
          $extra_having_clause = ' HAVING (products_quantity > 0 OR products_date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '")'; // 86400 * 60 = 60 days
      }
      
      $contents[] = array('text' => '<label>' . zen_draw_checkbox_field('apply_genres_list_all_products',true, $flag_apply_genres_list_all_products,'', 'id="apply_genres_list_all_products" onClick="document.getElementById(\'remove_genres_list_all_products\').checked=this.checked; document.getElementById(\'multiple_apply\').value=true; this.form.submit()"') . TEXT_APPLY_GENRE_LIST_OUT_OF_STOCK . '</label>'
                                    . zen_draw_hidden_field('multiple_apply', false, 'id="multiple_apply"')
      );
      
      $select_string_products = '<select name="products_to_apply_genre[]" size="10" multiple="multiple" style="width: 100%;">';
      
      $products = $db->Execute('SELECT DISTINCT p.products_id, p.products_model, 
                                       CONCAT_WS(""
										  ,pd.products_name
										  ,IF(NULLIF(be.volume, "") IS NOT NULL, CONCAT_WS("", " ", REPLACE("' . LABEL_BOOKX_VOLUME . '", "%s", be.volume), " - "), "")
										  ,IF(NULLIF(bed.products_subtitle, "") IS NOT NULL, bed.products_subtitle, "")
										  ) AS products_name ' 
                                        . $extra_fields .
                              ' FROM ' . TABLE_PRODUCTS . ' p
        						LEFT JOIN ' . TABLE_PRODUCT_TYPES . ' pt ON p.products_type = pt.type_id
                                LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON p.products_id = pd.products_id AND pd.language_id = "' . (int)$_SESSION['languages_id'] . '"
                                LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON p.products_id = be.products_id 
                                LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON p.products_id = bed.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
				                WHERE pt.type_handler = "product_bookx" AND p.products_id NOT IN (SELECT products_id FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . '  WHERE bookx_genre_id = "' . $bookx_genre_id . '")'
                              . $extra_having_clause .
                                ' ORDER BY products_name');
      
      $product_array = array();
      
      while (!$products->EOF) {
          //$display_price = $products->fields['products_price']; // zen_get_products_display_price($product['products_id']);
          $select_string_products .= '<option value="' . $products->fields['products_id'] . '">';
          $select_string_products .= $products->fields['products_name'] . ' [' . $products->fields['products_model'] . '] - ID# ' . $products->fields['products_id'] . '</option>'; // (' . $display_price . ')
      
          $products->MoveNext();
      }
      
      $select_string_products .= '</select>';
      
      $contents[] = array('text' => $select_string_products . zen_draw_hidden_field('bookx_genre_id', $bookx_genre_id) . '<input type="submit" value="' . TEXT_BUTTON_SUBMIT_APPLY_GENRE . '" style="margin: 10px 50px;" onClick="document.getElementById(\'multiple_apply\').value=true; this.form.submit()"/>');
      
      //**** Show books to which genre is already assigned ***//
      $contents[] = array('params' => 'class="infoBoxHeading"', 'text' => '<strong>' . TEXT_REMOVE_GENRE . '</strong>');

      
      $contents[] = array('text' =>  '<label>' . zen_draw_checkbox_field('remove_genres_list_all_products',true, $flag_apply_genres_list_all_products,'', 'id="remove_genres_list_all_products" onClick="document.getElementById(\'apply_genres_list_all_products\').checked=this.checked; document.getElementById(\'multiple_apply\').value=true; this.form.submit()"') . TEXT_APPLY_GENRE_LIST_OUT_OF_STOCK . '</label>');
      
      $select_string_products = '<select name="products_to_remove_genre[]" size="10" multiple="multiple" style="width: 100%;">';
      
      $products = $db->Execute('SELECT DISTINCT p.products_id, p.products_model, 
                                       CONCAT_WS(""
										  ,pd.products_name
										  ,IF(NULLIF(be.volume, "") IS NOT NULL, CONCAT_WS("", " ", REPLACE("' . LABEL_BOOKX_VOLUME . '", "%s", be.volume), " - "), "")
										  ,IF(NULLIF(bed.products_subtitle, "") IS NOT NULL, bed.products_subtitle, "")
										  ) AS products_name ' 
                                        . $extra_fields .
                              ' FROM ' . TABLE_PRODUCTS . ' p
        						LEFT JOIN ' . TABLE_PRODUCT_TYPES . ' pt ON p.products_type = pt.type_id
                                LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON p.products_id = pd.products_id AND pd.language_id = "' . (int)$_SESSION['languages_id'] . '"
                                LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA . ' be ON p.products_id = be.products_id 
                                LEFT JOIN ' . TABLE_PRODUCT_BOOKX_EXTRA_DESCRIPTION . ' bed ON p.products_id = bed.products_id AND bed.languages_id = "' . (int)$_SESSION['languages_id'] . '"
				                WHERE pt.type_handler = "product_bookx" AND p.products_id IN (SELECT products_id FROM ' . TABLE_PRODUCT_BOOKX_GENRES_TO_PRODUCTS . '  WHERE bookx_genre_id = "' . $bookx_genre_id . '")'
		                      . $extra_having_clause .
		                      ' ORDER BY products_name');
      
      				                      $product_array = array();
      
      				                          while (!$products->EOF) {
      				                          //$display_price = $products->fields['products_price']; // zen_get_products_display_price($product['products_id']);
      				                          $select_string_products .= '<option value="' . $products->fields['products_id'] . '">';
      				                              $select_string_products .= $products->fields['products_name'] . ' [' . $products->fields['products_model'] . '] - ID# ' . $products->fields['products_id'] . '</option>'; // (' . $display_price . ')
      
      				                              $products->MoveNext();
      }
      
      $select_string_products .= '</select>';
      
      $contents[] = array('text' => $select_string_products . zen_draw_hidden_field('bookx_genre_id', $bookx_genre_id) . '<input type="button" value="' . TEXT_BUTTON_SUBMIT_REMOVE_GENRE . '" style="margin: 10px 50px;" onClick="document.getElementById(\'multiple_apply\').value=true; this.form.submit()"/>');
      
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_GENRE . '</b>');

      $contents = array('form' => zen_draw_form('genre', FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&action=deleteconfirm') . zen_draw_hidden_field('mID', $aInfo->bookx_genre_id));
      $contents[] = array('text' => sprintf(TEXT_DELETE_INTRO, $aInfo->genre_description));
      $contents[] = array('text' => '<br><b>' . $aInfo->genre_description . '</b>');
      $contents[] = array('text' => '<br>' . zen_draw_checkbox_field('delete_image', '', true) . ' ' . TEXT_DELETE_IMAGE);

      if ($aInfo->products_count > 0) {
        $contents[] = array('text' => '<br>' . zen_draw_checkbox_field('delete_products') . ' ' . sprintf(TEXT_DELETE_PRODUCTS, $aInfo->genre_description));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $aInfo->products_count, $aInfo->genre_description));
      }

      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_genre_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($aInfo) && is_object($aInfo)) {
        $heading[] = array('text' => '<b>' . $aInfo->genre_description . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_genre_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_BOOKX_GENRES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_genre_id . '&action=delete') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . zen_date_short($aInfo->date_added));
        if (zen_not_null($aInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . zen_date_short($aInfo->last_modified));
        $contents[] = array('text' => '<br>' . zen_info_image($aInfo->genre_image, $aInfo->genre_description));
        $contents[] = array('text' => '<br>' . TEXT_PRODUCTS . ' ' . $aInfo->products_count);
      }
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
	
	echo $box->infoBox($heading, $contents);
	
    echo '            </td><!-- eof box -->' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
