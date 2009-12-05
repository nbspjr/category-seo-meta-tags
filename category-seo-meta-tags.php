<?php
/**
 * @package Category SEO Meta Tags
 * @author Bala Krishna
 * @version 1.0
 */
/*
Plugin Name: Category SEO Meta Tags
Plugin URI: http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/
Description: Add ability to add meta tags for category pages. This plugin specially designed to work with All In One SEO plugin.
Author: Bala Krishna
Version: 1.0
Author URI: http://www.bala-krishna.com
*/
/*
Copyright (C) 2009-2010 Balkrishna Verma, bala-krishna.com (krishna711@gmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


function cat_seo_title_tag()
{
	show_category_meta_title();
}

if(isset($_POST['action']) && $_POST['action']=="editedcat") {
    $cat_meta_setting['page_title']=$_POST['cat_title'];
    $cat_meta_setting['description']=$_POST['cat_desc'];
    $cat_meta_setting['metakey']=$_POST['cat_keywords'];
	if(!empty($cat_meta_setting['page_title']) && !empty($cat_meta_setting['description']) && !empty($cat_meta_setting['metakey'])) {
		 update_option('cat_meta_key_'.$_POST['cat_ID'],$cat_meta_setting);
	}	 
}

// Meta Placement for category pages

function show_category_meta() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	if(is_category($cur_cat_id)) {
		get_current_cat_meta($cur_cat_id);
	}
}

function show_category_meta_title() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	if(is_category($cur_cat_id)) {
		show_category_title($cur_cat_id);
	}
}

function show_category_title($cur_cat_id) {
	if(get_option('cat_meta_key_'.$cur_cat_id)) {
	  $cat_meta_data = get_option('cat_meta_key_'.$cur_cat_id);
	  //ob_start('output_callback_for_title');
	  echo $cat_meta_data['page_title'];
	} else {
	  echo wp_title(' ', true, 'right');
	  echo " - ";
	  echo bloginfo("name");
	}
}

function get_current_cat_meta($cur_cat_id) {
	if(get_option('cat_meta_key_'.$cur_cat_id)) {
	  $cat_meta_data = get_option('cat_meta_key_'.$cur_cat_id);
	  //echo '<title>'.$cat_meta_data['page_title'].'</title>'."\r\n";
	  echo '<meta name="description" content="'.$cat_meta_data['description'].'" />'."\r\n";
	  echo '<meta name="keywords" content="'.$cat_meta_data['metakey'].'" />'."\r\n";
	}
}


function category_meta_form() {
if(isset($_GET['action']) && $_GET['action']=="edit") {
?>
<h2>Category Meta Setting</h2>
<?php $cat_meta = get_option('cat_meta_key_'.$_GET['cat_ID']); //print_r( $cat_meta); ?>
<table width="100%" border="1" cellspacing="3" cellpadding="3">
  <tr>
    <td width="33%"><div align="right"><strong>Page Title:</strong></div></td>
    <td><input name="cat_title" type="text" style="width:95%" value="<?php echo $cat_meta['page_title']; ?>" /></td>
  </tr>
    <tr>
    <td width="33%"><div align="right"><strong>Description:</strong></div></td>
    <td><textarea name="cat_desc" style="width:95%" rows="4"><?php echo $cat_meta['description']; ?></textarea></td>
  </tr>
    <tr>
    <td width="33%"><div align="right"><strong>Keywords:</strong></div></td>
    <td><input name="cat_keywords" type="text" style="width:95%" value="<?php echo $cat_meta['metakey']; ?>" /></td>
  </tr>
</table>
<?php
}
}

add_action ('edit_category_form', 'category_meta_form' );
add_action ('wp_head','show_category_meta'); 

?>