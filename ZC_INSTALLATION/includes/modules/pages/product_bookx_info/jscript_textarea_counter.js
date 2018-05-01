/**
 * This file is part of the ZenCart add-on Book X which
 * introduces a new product type for books to the Zen Cart
 * shop system. Tested for compatibility on ZC v. 1.5
 *
 * For latest version and support visit:
 * https://sourceforge.net/p/zencartbookx
 *
 * @package page
 * @author  Philou
 * @copyright Copyright 2013
 * @copyright Portions Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.gnu.org/licenses/gpl.txt GNU General Public License V2.0
 *
 * @version BookX V 0.9.4-revision8 BETA
 * @version $Id: [ZC INSTALLATION]/includes/modules/pages/product_bookx_info/jscript_textarea_counter.php 2016-02-02 philou $
 */

/* javascript function to update form field
 *  field		form field that is being counted
 *  count		form field that will show characters left
 *  maxchars 	maximum number of characters
*/
function characterCount(field, count, maxchars) {
  var realchars = field.value.replace(/\t|\r|\n|\r\n/g,'');
  var excesschars = realchars.length - maxchars;
  if (excesschars > 0) {
		field.value = field.value.substring(0, maxchars);
		alert("Error:\n\n- You are only allowed to enter up to"+maxchars+" characters.");
	} else {
		count.value = maxchars - realchars.length;
	}
}