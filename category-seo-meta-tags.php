<?php
/**
 * @package Category SEO Meta Tags
 * @author Bala Krishna
 * @version 2.0
 */

/*

Plugin Name: Category SEO Meta Tags
Plugin URI: http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/
Description: Add ability to add meta tags for category pages. This plugin specially designed to work with All In One SEO plugin.
Author: Bala Krishna
Version: 2.0
Author URI: http://www.bala-krishna.com
*/

/*
Copyright (C) 2009-2010 Balkrishna Verma, bala-krishna.com (krishna711@gmail.com)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


function cat_seo_title_tag()
{
	show_category_meta_title();
}


if(isset($_POST['action']) && $_POST['action']=="editedtag" && $_POST['taxonomy']=="category") {
    $cat_meta_setting['page_title']=$_POST['cat_title'];
    $cat_meta_setting['description']=$_POST['cat_desc'];
    $cat_meta_setting['metakey']=$_POST['cat_keywords'];
	if(!empty($cat_meta_setting['page_title']) && !empty($cat_meta_setting['description']) && !empty($cat_meta_setting['metakey'])) {
		 update_option('cat_meta_key_'.$_POST['tag_ID'],$cat_meta_setting);
	}	 
}

if(isset($_POST['action']) && $_POST['action']=="editedtag" && $_POST['taxonomy']=="post_tag") {
    $tag_meta_setting['page_title']=$_POST['tag_title'];
    $tag_meta_setting['description']=$_POST['tag_desc'];
    $tag_meta_setting['metakey']=$_POST['tag_keywords'];
	if(!empty($tag_meta_setting['page_title']) && !empty($tag_meta_setting['description']) && !empty($tag_meta_setting['metakey'])) {
		 update_option('tag_meta_key_'.$_POST['tag_ID'],$tag_meta_setting);
	}	 
}

// Meta Placement for category pages

function show_category_meta() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	if(is_category($cur_cat_id)) {
		get_current_cat_meta($cur_cat_id);
	}

	if(is_tag()) {
		$cur_tag_id = get_query_var('tag_id');
		get_current_tag_meta($cur_tag_id);
	}

}

function show_category_meta_title() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	if(is_category($cur_cat_id)) {
		show_category_title($cur_cat_id);
	}
}

function show_category_title() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	$cat_meta_data = get_option('cat_meta_key_'.$cur_cat_id);
	return $cat_meta_data['page_title'];
}

function show_tag_title() {
	$cur_tag_id = get_query_var('tag_id');
	$tag_meta_data = get_option('tag_meta_key_'.$cur_tag_id);
	return $tag_meta_data['page_title'];
}



function get_current_cat_meta($cur_cat_id) {
	if(get_option('cat_meta_key_'.$cur_cat_id)) {
	  $cat_meta_data = get_option('cat_meta_key_'.$cur_cat_id);
	  add_filter('aioseop_category_title', show_category_title); 
	  echo '<meta name="description" content="'.$cat_meta_data['description'].'" />'."\r\n";
	  echo '<meta name="keywords" content="'.$cat_meta_data['metakey'].'" />'."\r\n";
	}
}

function get_current_tag_meta($cur_tag_id) {
	if(get_option('tag_meta_key_'.$cur_tag_id)) {
	  $tag_meta_data = get_option('tag_meta_key_'.$cur_tag_id);
	  add_filter('aioseop_tag_title', show_tag_title); 
	  echo '<meta name="description" content="'.$tag_meta_data['description'].'" />'."\r\n";
	  echo '<meta name="keywords" content="'.$tag_meta_data['metakey'].'" />'."\r\n";
	}
}

function category_meta_form() {
if(isset($_GET['action']) && $_GET['action']=="edit") {
?>
<div class="icon32" id="icon-edit"><br></div>
<h2>Category Meta Setting</h2>
<?php $cat_meta = get_option('cat_meta_key_'.$_GET['tag_ID']); //print_r( $cat_meta); ?>
<table class="form-table" >
<tbody>
  <tr class="form-field form-required">
    <th valign="top" scope="row"><label for="cat_title">Category Title:</label></th>
    <td><input name="cat_title" type="text" size="40" value="<?php echo $cat_meta['page_title']; ?>" />
    <p class="description">Enter category title tag here.</p>
    </td>
  </tr>
  <tr class="form-field form-required">
    <th valign="top" scope="row"><label for="cat_title">Description:</label></th>
    <td><textarea name="cat_desc" size="40" rows="4"><?php echo $cat_meta['description']; ?></textarea>
    <p class="description">Enter category description text here.</p>
    </td>
  </tr>
  <tr class="form-field form-required">
    <th valign="top" scope="row"><label for="cat_title">Keywords</label></th>
    <td><input name="cat_keywords" type="text" size="40" value="<?php echo $cat_meta['metakey']; ?>" />
    <p class="description">Enter category keywords here.</p></td>
  </tr>
 </tbody> 
</table>
<div style="margin:10px; text-align:center;">
<a href="http://www.bala-krishna.com" target="_blank">Author Home Page</a> | <a href="http://www.bala-krishna.com/wordpress-plugins/" target="_blank">Wordpress Plugin Development</a> | <a href="http://www.bala-krishna.com/contact-bala-krishna/" target="_blank">Contact Author</a>
</div>
<?php
}
}

function tag_meta_form() {
if(isset($_GET['action']) && $_GET['action']=="edit") {
?>
<div class="icon32" id="icon-edit"><br></div>
<h2>Tag Meta Setting</h2>
<?php $cat_meta = get_option('tag_meta_key_'.$_GET['tag_ID']); //print_r( $cat_meta); ?>
<table class="form-table" >
<tbody>
  <tr class="form-field form-required">
    <th valign="top" scope="row"><label for="tag_title">Tag Title:</label></th>
    <td><input name="tag_title" type="text" size="40" value="<?php echo $cat_meta['page_title']; ?>" />
    <p class="description">Enter tag title tag here.</p>
    </td>
  </tr>
  <tr class="form-field form-required">
    <th valign="top" scope="row"><label for="tag_desc">Description:</label></th>
    <td><textarea name="tag_desc" size="40" rows="4"><?php echo $cat_meta['description']; ?></textarea>
    <p class="description">Enter tag description text here.</p>
    </td>
  </tr>
  <tr class="form-field form-required">
    <th valign="top" scope="row"><label for="tag_keywords">Keywords</label></th>
    <td><input name="tag_keywords" type="text" size="40" value="<?php echo $cat_meta['metakey']; ?>" />
    <p class="description">Enter tag keywords here.</p></td>
  </tr>
 </tbody> 
</table>
<div style="margin:10px; text-align:center;">
<a href="http://www.bala-krishna.com" target="_blank">Author Home Page</a> | <a href="http://www.bala-krishna.com/wordpress-plugins/" target="_blank">Wordpress Plugin Development</a> | <a href="http://www.bala-krishna.com/contact-bala-krishna/" target="_blank">Contact Author</a>
</div>

<?php
}
}

add_action ('edit_category_form', 'category_meta_form' );
add_action ('edit_tag_form', 'tag_meta_form' );
add_action ('wp_head','show_category_meta'); 
?>