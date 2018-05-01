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
 * @version $Id: [ZC INSTALLATION]/[ADMIN]/bookx_series.php 2016-02-02 philou $
 */

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (zen_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($_GET['mID'])) $bookx_series_id = zen_db_prepare_input($_GET['mID']);
        $series_sort_order = zen_db_prepare_input($_POST['series_sort_order']);

        $sql_data_array = array('series_sort_order' => $series_sort_order, 'last_modified' => 'now()');

        if ($action == 'insert') {
          $insert_sql_data = array('date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          zen_db_perform(TABLE_PRODUCT_BOOKX_SERIES, $sql_data_array);
          $bookx_series_id = zen_db_insert_id();
        } elseif ($action == 'save') {
          /*$update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);*/

          zen_db_perform(TABLE_PRODUCT_BOOKX_SERIES, $sql_data_array, 'update', "bookx_series_id = '" . (int)$bookx_series_id . "'");
        }

        $languages = zen_get_languages();
        $series_name_array = $_POST['series_name'];
        $series_description_array = $_POST['series_description'];
        $series_image_manual_array = $_POST['series_image_manual'];
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        	$language_id = $languages[$i]['id'];
        	$series_image_name = null;

        	if ($series_image_manual_array[$language_id] != '') {
        		// add image manually
        		$series_image_name = zen_db_input($_POST['img_dir'] . $series_image_manual_array[$language_id]);
        		/*$db->Execute("update " . TABLE_PRODUCT_BOOKX_SERIES . "
                      set series_image = '" .  $series_image_name . "'
                      where bookx_series_id = '" . (int)$bookx_series_id . "'");*/
        	} else {
        		$series_image = new upload('series_image-' . $language_id);
        		$series_image->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir']);
        		if ( $series_image->parse() &&  $series_image->save()) {
        			// remove image from database if none
        			if ($series_image->filename != 'none') {
        				// remove image from database if none
        				$series_image_name = zen_db_input($_POST['img_dir'] . $series_image->filename);
        			}
        		}
        	}


          $sql_data_array = array('series_name' => zen_db_prepare_input($series_name_array[$language_id]),
          						  'series_description' => zen_db_prepare_input($series_description_array[$language_id]),
          						  'series_image' => $series_image_name);

          if ($action == 'insert' ||
          	  ($action == 'save' && null === bookx_get_series_description($bookx_series_id, $language_id))) {
            $insert_sql_data = array('bookx_series_id' => $bookx_series_id,
                                     'languages_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            zen_db_perform(TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'save') {
            zen_db_perform(TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION, $sql_data_array, 'update', "bookx_series_id = '" . (int)$bookx_series_id . "' and languages_id = '" . (int)$language_id . "'");
          }
        }

        //**** apply/remove multiple assignments
        if (isset($_POST['products_to_apply_series']) && !empty($_POST['products_to_apply_series']) && $bookx_series_id){
            $selected_products = $_POST['products_to_apply_series'];
            $values = '';
            $delimiter = '';
            foreach ($selected_products as $products_id) {
                $query = 'UPDATE ' . TABLE_PRODUCT_BOOKX_EXTRA . ' SET bookx_series_id = "' . $bookx_series_id . '" WHERE products_id = "' . zen_db_prepare_input($products_id) . '" LIMIT 1;';
            }
        
            $db->Execute($query);
        
        }
        
        if (isset($_POST['products_to_remove_series']) && !empty($_POST['products_to_remove_series']) && $bookx_series_id){
            $selected_products = $_POST['products_to_remove_series'];
            foreach ($selected_products as $products_id) {
                $query = 'UPDATE ' . TABLE_PRODUCT_BOOKX_EXTRA . ' SET bookx_series_id = NULL WHERE products_id = "' . zen_db_prepare_input($products_id) . '" LIMIT 1;';
                $db->Execute($query);
            }
        
        }
        
        if (isset($_POST['multiple_apply']) && $_POST['multiple_apply']) {
            // we are coming from the "multiple apply" part of the form, so we now continue with the "edit" part of the script
            $action = 'edit';
        } else {
            zen_redirect(zen_href_link(FILENAME_BOOKX_SERIES, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'mID=' . $bookx_series_id. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')));
        }

        break;
      case 'deleteconfirm':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page']));
        }
        $bookx_series_id = zen_db_prepare_input($_POST['mID']);

        if (isset($_POST['delete_image']) && ($_POST['delete_image'] == 'on')) {
          $series = $db->Execute("select series_image
                                        from " . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . "
                                        where bookx_series_id = '" . (int)$bookx_series_id . "'");

          while (!$series->EOF) {
          	$image_location = DIR_FS_CATALOG_IMAGES . $series->fields['series_image'];

          	if (file_exists($image_location)) @unlink($image_location);
          	$series->MoveNext();
          }

        }

        $db->Execute("delete from " . TABLE_PRODUCT_BOOKX_SERIES . "
                      where bookx_series_id = '" . (int)$bookx_series_id . "'");
        $db->Execute("delete from " . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION . "
                      where bookx_series_id = '" . (int)$bookx_series_id . "'");

        if (isset($_POST['delete_products']) && ($_POST['delete_products'] == 'on')) {
          $products = $db->Execute("select p.products_id
                                             from " . TABLE_PRODUCT_BOOKX_EXTRA . " p
                                             where p.bookx_series_id = '" . (int)$bookx_series_id . "'");

          while (!$products->EOF) {
             bookx_delete_product((int)$products->fields['products_id']);
            $products->MoveNext();
          }
        } else {
          $db->Execute("UPDATE " . TABLE_PRODUCT_BOOKX_EXTRA . "
                        SET bookx_series_id = NULL
                        WHERE bookx_series_id = '" . (int)$bookx_series_id . "'");
        }

        zen_redirect(zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page']. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')));
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
        <td width="100%">
                <?php
            echo zen_draw_form('search', FILENAME_BOOKX_SERIES, '', 'get');
			// show reset search
		    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
		      echo '<a href="' . zen_href_link(FILENAME_BOOKX_SERIES) . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>&nbsp;&nbsp;';
		    }
		    echo HEADING_TITLE_SEARCH_DETAIL . ' ' . zen_draw_input_field('search') . zen_hide_session_id();
		    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
		      $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
		      echo '<br />' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
		    }
		    echo '</form>';
    ?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SERIES; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SORT_ORDER; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
	if (isset($_GET['search'])) {
		$search = zen_db_prepare_input($_GET['search']);
		$series_query_raw = 'SELECT s.*, sd.series_name, sd.series_image from ' . TABLE_PRODUCT_BOOKX_SERIES . ' s
 							 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION. ' sd ON sd.bookx_series_id = s.bookx_series_id AND sd.languages_id = ' . $_SESSION['languages_id']
						  . ' WHERE sd.series_name LIKE "%' . zen_db_input($search) . '%" ORDER BY s.series_sort_order, sd.series_name';
	} else {
		$series_query_raw = 'SELECT s.*, sd.series_name, sd.series_image from ' . TABLE_PRODUCT_BOOKX_SERIES . ' s
 							 LEFT JOIN ' . TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION. ' sd ON sd.bookx_series_id = s.bookx_series_id AND sd.languages_id = ' . $_SESSION['languages_id']
						  . ' ORDER BY s.series_sort_order, sd.series_name';
	}
  $series_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $series_query_raw, $series_query_numrows);
  $series = $db->Execute($series_query_raw);

  while (!$series->EOF) {

    if ((!isset($_GET['mID']) || (isset($_GET['mID']) && ($_GET['mID'] == $series->fields['bookx_series_id']))) && !isset($aInfo) && (substr($action, 0, 3) != 'new')) {
	  $series_products = $db->Execute("select count(p.products_id) as products_count
                                             from " . TABLE_PRODUCT_BOOKX_EXTRA . " p
                                             where p.bookx_series_id = '" . (int)$series->fields['bookx_series_id'] . "'");


      $aInfo_array = array_merge($series->fields, $series_products->fields);
      $aInfo = new objectInfo($aInfo_array);
    }

    if (isset($aInfo) && is_object($aInfo) && ($series->fields['bookx_series_id'] == $aInfo->bookx_series_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $series->fields['bookx_series_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $series->fields['bookx_series_id'] . '&action=edit') . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $series->fields['series_name']; ?></td>
                <td class="dataTableContent"><?php echo $series->fields['series_sort_order']; ?></td>
                <td class="dataTableContent" align="right">
                  <?php echo '<a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $series->fields['bookx_series_id'] . '&action=edit'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>
                  <?php echo '<a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $series->fields['bookx_series_id'] . '&action=delete'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>'; ?>
                  <?php if (isset($aInfo) && is_object($aInfo) && ($series->fields['bookx_series_id'] == $aInfo->bookx_series_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_BOOKX_SERIES, zen_get_all_get_params(array('mID')) . 'mID=' . $series->fields['bookx_series_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                </td>
              </tr>
<?php
    $series->MoveNext();
  }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $series_split->display_count($series_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SERIES); ?></td>
                    <td class="smallText" align="right"><?php echo $series_split->display_links($series_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="3" class="smallText"><?php echo '<a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . /*$aInfo->bookx_series_id .*/ '&action=new'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_SERIES . '</b>');

      $contents = array('form' => zen_draw_form('series', FILENAME_BOOKX_SERIES, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $dir = @dir(DIR_FS_CATALOG_IMAGES);
      $dir_info[] = array('id' => '', 'text' => "Main Directory");
      while ($file = $dir->read()) {
        if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
          $dir_info[] = array('id' => $file . '/', 'text' => $file);
        }
      }
      $dir->close();

      $default_directory = 'bookx_series/';

      $series_image_fields = '';
      $series_manual_image_fields = '';
      $series_name_inputs = '';
      $series_description_textareas = '';
      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
		$language_image = zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']);
		$series_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_file_field('series_image-' . $languages[$i]['id']);

		$series_manual_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('series_image_manual[' . $languages[$i]['id'] . ']', '', zen_set_field_length(TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION, 'series_image'));
      	$series_name_inputs .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('series_name[' . $languages[$i]['id'] . ']', '', zen_set_field_length(TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION, 'series_name'));
      	$series_description_textareas .= '<br>' . $language_image . '&nbsp;' . zen_draw_textarea_field('series_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '15', '' );
	  }
	  $contents[] = array('text' => '<br>' . TEXT_SERIES_NAME . $series_name_inputs);

	  $contents[] = array('text' => '<BR />' . TEXT_SERIES_IMAGE_DIR . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));

	  $contents[] = array('text' => '<br>' . TEXT_SERIES_IMAGE . '<br>' . $series_image_fields);
	  $contents[] = array('text' => '<br />' . TEXT_SERIES_IMAGE_MANUAL . '&nbsp;' . $series_manual_image_fields);

	  $contents[] = array('text' => '<br>' . TEXT_SERIES_DESCRIPTION . $series_description_textareas);

      $contents[] = array('text' => '<br />' . TEXT_SERIES_SORT_ORDER . '<br>' . zen_draw_input_field('series_sort_order'));

      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_SERIES . '</b>');

      $contents = array('form' => zen_draw_form('series', FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_series_id . '&action=save'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : ''), 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      //$contents[] = array('text' => '<br />' . TEXT_SERIES_IMAGE . '<br>' . zen_draw_file_field('series_image') . '<br />' . $aInfo->series_image);
      $dir = @dir(DIR_FS_CATALOG_IMAGES);
      $dir_info[] = array('id' => '', 'text' => "Main Directory");
      while ($file = $dir->read()) {
        if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
          $dir_info[] = array('id' => $file . '/', 'text' => $file);
        }
      }
      $dir->close();
      $default_directory = substr( $series->fields['series_image'], 0,strpos( $series->fields['series_image'], '/')+1);
      if (empty($default_directory)) {
			$default_directory = 'bookx_series/';
		 }

      $series_image_fields = '';
      $series_manual_image_fields = '';
      $series_name_inputs = '';
      $series_description_textareas = '';
      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
		$language_image = zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']);
		$series_name = bookx_get_series_name($aInfo->bookx_series_id, $languages[$i]['id']);
		$series_description = bookx_get_series_description($aInfo->bookx_series_id, $languages[$i]['id']);
		$series_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_file_field('series_image-' . $languages[$i]['id']);

		$series_manual_image_url = bookx_get_series_image_url($aInfo->bookx_series_id, $languages[$i]['id']);
		$series_manual_image_name = substr( $series_manual_image_url, strpos( $series_manual_image_url, '/')+1);
		$series_manual_image_fields .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('series_image_manual[' . $languages[$i]['id'] . ']', $series_manual_image_name, zen_set_field_length(TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION, 'series_image'));
		$series_manual_image_fields .= '<br />' . (null != $series_manual_image_url && '' != $series_manual_image_url ? zen_info_image($series_manual_image_url, $series_description, '250') : TEXT_SERIES_IMAGE_NOT_DEFINED);
		$series_name_inputs .= '<br>' . $language_image . '&nbsp;' . zen_draw_input_field('series_name[' . $languages[$i]['id'] . ']', $series_name, zen_set_field_length(TABLE_PRODUCT_BOOKX_SERIES_DESCRIPTION, 'series_name'));
		$series_description_textareas .= '<br>' . $language_image . '&nbsp;' . zen_draw_textarea_field('series_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '15', htmlspecialchars(bookx_get_series_description($aInfo->bookx_series_id, $languages[$i]['id']), ENT_COMPAT, CHARSET, TRUE) );

      }
      $contents[] = array('text' => '<br>' . TEXT_SERIES_NAME . $series_name_inputs);

      $contents[] = array('text' => '<BR />' . TEXT_SERIES_IMAGE_DIR . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));
      $contents[] = array('text' => '<br>' . TEXT_SERIES_IMAGE . '<br>' . $series_image_fields);
      $contents[] = array('text' => '<br />' . TEXT_SERIES_IMAGE_MANUAL . '&nbsp;' . $series_manual_image_fields);
     // $contents[] = array('text' => '<br />' . (null != $aInfo->series_image && '' != $aInfo->series_image ? zen_info_image($aInfo->series_image, $aInfo->series_description) : TEXT_SERIES_IMAGE_NOT_DEFINED));

      $contents[] = array('text' => '<br>' . TEXT_SERIES_DESCRIPTION . $series_description_textareas);

      $contents[] = array('text' => '<br />' . TEXT_SERIES_SORT_ORDER . '<br>' . zen_draw_input_field('series_sort_order', $aInfo->series_sort_order));

      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_series_id. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      
      ///***** multiple apply / remove series
      $contents[] = array('params' => 'class="infoBoxHeading"', 'text' => '<strong>' . TEXT_APPLY_SERIES . '</strong>');
      
      $extra_fields = '';
      $extra_having_clause = '';
      if (isset($_POST['apply_series_list_all_products']) && 'on' == $_POST['apply_series_list_all_products'] &&
          isset($_POST['remove_series_list_all_products']) && 'on' == $_POST['remove_series_list_all_products']) {
              $flag_apply_series_list_all_products = true;
          } else {
              $flag_apply_series_list_all_products = false;
          }
      
          if (!$flag_apply_series_list_all_products) {
              $extra_fields = ' , p.products_quantity,  p.products_date_available ';
              // $extra_in_stock_join_clause = ' LEFT JOIN ' . TABLE_PRODUCTS . ' p ON p.products_id = batp.products_id AND p.products_status > 0';
              $extra_having_clause = ' HAVING (p.products_quantity > 0 OR p.products_date_available >= "' . date('Y-m-d H:i:s', time()- (86400*60)) . '") '; // 86400 * 60 = 60 days
          }
      
          $contents[] = array('text' => '<label>' . zen_draw_checkbox_field('apply_series_list_all_products',true, $flag_apply_series_list_all_products,'', 'id="apply_series_list_all_products" onClick="document.getElementById(\'remove_series_list_all_products\').checked=this.checked; document.getElementById(\'multiple_apply\').value=true; this.form.submit()"') . TEXT_APPLY_SERIES_LIST_OUT_OF_STOCK . '</label>'
              . zen_draw_hidden_field('multiple_apply', false, 'id="multiple_apply"')
          );
      
          $select_string_products = '<select name="products_to_apply_series[]" size="10" multiple="multiple" style="width: 100%;">';
      
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
                                    WHERE pt.type_handler = "product_bookx" AND be.bookx_series_id  != "' . $aInfo->bookx_series_id . '"'
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
      
          $contents[] = array('text' =>  $select_string_products . zen_draw_hidden_field('bookx_series_id', $aInfo->bookx_series_id) . '<input type="submit" value="' . TEXT_BUTTON_SUBMIT_APPLY_SERIES . '" style="margin: 10px 50px;" onClick="document.getElementById(\'multiple_apply\').value=true; this.form.submit()"/>');
      
          //**** Show books to which series is already assigned ***//
          $contents[] = array('params' => 'class="infoBoxHeading"', 'text' => '<strong>' . TEXT_REMOVE_SERIES . '</strong>');
      
          $contents[] = array('text' => '<label>' . zen_draw_checkbox_field('remove_series_list_all_products',true, $flag_apply_series_list_all_products,'', 'id="remove_series_list_all_products" onClick="document.getElementById(\'apply_series_list_all_products\').checked=this.checked; document.getElementById(\'multiple_apply\').value=true; this.form.submit()"') . TEXT_APPLY_SERIES_LIST_OUT_OF_STOCK . '</label>');
      
          $select_string_products = '<select name="products_to_remove_series[]" size="10" multiple="multiple" style="width: 100%;">';
      
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
                                    WHERE pt.type_handler = "product_bookx" AND be.bookx_series_id  = "' . $aInfo->bookx_series_id . '"'
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
      
          $contents[] = array('text' => $select_string_products . zen_draw_hidden_field('bookx_series_id', $aInfo->bookx_series_id) . '<input type="submit" value="' . TEXT_BUTTON_SUBMIT_REMOVE_SERIES . '" style="margin: 10px 50px;" onClick="document.getElementById(\'multiple_apply\').value=true; this.form.submit()"/>');
      
      
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_SERIES . '</b>');

      $contents = array('form' => zen_draw_form('series', FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&action=deleteconfirm'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . zen_draw_hidden_field('mID', $aInfo->bookx_series_id));
      $contents[] = array('text' => sprintf(TEXT_DELETE_INTRO, $aInfo->series_description));
      $contents[] = array('text' => '<br><b>' . $aInfo->series_description . '</b>');
      $contents[] = array('text' => '<br>' . zen_draw_checkbox_field('delete_image', '', true) . ' ' . TEXT_DELETE_IMAGE);

      if ($aInfo->products_count > 0) {
        $contents[] = array('text' => '<br>' . zen_draw_checkbox_field('delete_products') . ' ' . sprintf(TEXT_DELETE_PRODUCTS, $aInfo->series_description));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $aInfo->products_count, $aInfo->series_description));
      }

      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_series_id. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($aInfo) && is_object($aInfo)) {
        $heading[] = array('text' => '<b>' . $aInfo->series_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_series_id . '&action=edit'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_BOOKX_SERIES, 'page=' . $_GET['page'] . '&mID=' . $aInfo->bookx_series_id . '&action=delete'. ((isset($_GET['search']) && !empty($_GET['search'])) ? '&search=' . $_GET['search'] : '')) . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . zen_date_short($aInfo->date_added));
        if (zen_not_null($aInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . zen_date_short($aInfo->last_modified));
        $contents[] = array('text' => '<br>' . zen_info_image($aInfo->series_image, $aInfo->series_name, '250'));
        $contents[] = array('text' => '<br>' . TEXT_PRODUCTS . ' ' . $aInfo->products_count);
      }
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
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
