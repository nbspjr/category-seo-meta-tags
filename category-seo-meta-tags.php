<?php
/**
 * @package Category SEO Meta Tags
 * @author Bala Krishna
 * @version 2.5
 */
/*
Plugin Name: Category SEO Meta Tags
Plugin URI: http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/
Description: Add ability to add meta tags for category,tag pages and custom taxonomies. This plugin specially designed to work with All In One SEO plugin. <br /><a href="options-general.php?page=csmt">Settings</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=krishna711%40gmail%2ecom&item_name=WP Plugin Support Donation&item_number=Support%20Forum&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">Donate</a> | <a href="http://www.bala-krishna.com/forum/" >Support Forum</a> 
Author: Bala Krishna, Sergey Yakovlev
Version: 2.5
Author URI: http://www.bala-krishna.com
*/

/*
Copyright (C) 2009-2010 Balkrishna Verma, bala-krishna.com (krishna711@gmail.com)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$csmt_domain = "category-seo-meta-tags";
$csmt_version = '2.5';
$csmt_is_setup = 0;

function csmt_setup(){
  global $csmt_domain, $csmt_is_setup;

/*  if($csmt_is_setup) {
    return;
  }
*/
  if (function_exists('load_plugin_textdomain')) {
    //load_plugin_textdomain($csmt_domain, PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)) . 'locale');
    load_plugin_textdomain($csmt_domain, false, dirname(plugin_basename(__FILE__)) . '/locale');
  }
}

register_activation_hook(__FILE__,'csmt_activation');

function csmt_activation(){
	global $csmt_domain;
	if(!get_option('csmt_options')){
		$csmt_options = get_option('csmt_options');
		$csmt_options['csmt_enabled'] = "1";
		$csmt_options['csmt_cat_title_format'] = _e("%category_title% | %blog_title%", $csmt_domain);
		$csmt_options['csmt_cat_paged_format'] = _e(" - Page %page_num%", $csmt_domain);
		$csmt_options['csmt_tag_title_format'] = _e("%tag_title% | %blog_title%", $csmt_domain);
		$csmt_options['csmt_tag_paged_format'] = _e(" - Page %page_num%", $csmt_domain);
		update_option('csmt_options',$csmt_options);
	}
}

function cat_seo_title_tag()
{
	show_category_meta_title();
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] and isset($_REQUEST['csmt_cat_title_format'])) {
		if(isset($_REQUEST['csmt_enabled'])) {
			$csmt_options['csmt_enabled'] = "1";
		} else {
			$csmt_options['csmt_enabled'] = "0";
		}
		$csmt_options['csmt_cat_title_format'] = $_REQUEST['csmt_cat_title_format'];
		$csmt_options['csmt_cat_paged_format'] = $_REQUEST['csmt_cat_paged_format'];
		$csmt_options['csmt_tag_title_format'] = $_REQUEST['csmt_tag_title_format'];
		$csmt_options['csmt_tag_paged_format'] = $_REQUEST['csmt_tag_paged_format'];
		$csmt_options['csmt_taxonomies'] = $_REQUEST['csmt_taxonomies'];
		update_option('csmt_options',$csmt_options);
}

if(isset($_POST['action']) && $_POST['action']=="editedtag" && $_POST['taxonomy']=="category") {
    $cat_meta_setting['page_title']=$_POST['cat_title'];
    $cat_meta_setting['description']=$_POST['cat_desc'];
    $cat_meta_setting['metakey']=$_POST['cat_keywords'];
	if(!empty($cat_meta_setting['page_title'])) {
		 update_option('cat_meta_key_'.$_POST['tag_ID'],$cat_meta_setting);
	}	 
}

if(isset($_POST['action']) && $_POST['action']=="editedtag" && $_POST['taxonomy']=="post_tag") {
    $tag_meta_setting['page_title']=$_POST['tag_title'];
    $tag_meta_setting['description']=$_POST['tag_desc'];
    $tag_meta_setting['metakey']=$_POST['tag_keywords'];
	if(!empty($tag_meta_setting['page_title'])) {
		 update_option('tag_meta_key_'.$_POST['tag_ID'],$tag_meta_setting);
	}	 
}
$csmt_options = get_option('csmt_options');
$taxonomies = $csmt_options['csmt_taxonomies'];
if(is_array($taxonomies)) {
foreach ($taxonomies as $taxonomy ) {
	if(isset($_POST['action']) && $_POST['action']=="editedtag" && $_POST['taxonomy']==$taxonomy) {
		$tag_meta_setting['page_title']=$_POST['tag_title'];
		$tag_meta_setting['description']=$_POST['tag_desc'];
		$tag_meta_setting['metakey']=$_POST['tag_keywords'];
		if(!empty($tag_meta_setting['page_title'])) {
			 update_option($taxonomy.'_meta_key_'.$_POST['tag_ID'],$tag_meta_setting);
		}	 
	}
}
}
// Meta Placement for category and tag pages

function show_category_meta() {
	global $wp_query, $wpsc_query;
	$is_wpsc_bk = 0;
	$csmt_options = get_option('csmt_options');
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	if(is_category($cur_cat_id)) {
		get_current_cat_meta($cur_cat_id);
	}

	if(is_tag()) {
		$cur_tag_id = get_query_var('tag_id');
		get_current_tag_meta($cur_tag_id);
	}
	
	if (isset($wpsc_query->query_vars['wpsc_product_category']) && !isset($wpsc_query->query_vars['wpsc-product'])) {
		$current_taxonomy = 'wpsc_product_category';
		$tag = get_term_by('slug', $wpsc_query->query_vars['wpsc_product_category'], 'wpsc_product_category');
		$cur_tag_id = $tag->term_id;
		$tag_meta_data = get_option($current_taxonomy.'_meta_key_'.$cur_tag_id); 
		$current_taxonomy_val =	$wpsc_query->query_vars[$current_taxonomy];
		get_current_tax_meta($current_taxonomy,$cur_tag_id);	
	} else if(is_tax()) { // 4
		//echo "TAX TRUE";
		$taxonomies = $csmt_options['csmt_taxonomies'];
		if(is_array($taxonomies)) { // 3
			foreach ($taxonomies as $taxonomy ) { // 2
				$taxonomy_val =	get_query_var($taxonomy);
				if(is_tax($taxonomy,$taxonomy_val)) { // 1
					$tag = get_term_by('slug', $taxonomy_val, $taxonomy);
					$cur_tag_id = $tag->term_id;
					get_current_tax_meta($taxonomy,$cur_tag_id);	
				} // 1
			} // 2
		} // 3	
	} // 4
}

function show_category_meta_title() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	if(is_category($cur_cat_id)) {
		show_category_title($cur_cat_id);
	}
}

function show_category_title() {
	$cur_cat_id = get_cat_id( single_cat_title("",false) );
	$csmt_options = get_option('csmt_options');
	if(get_option('cat_meta_key_'.$cur_cat_id) && $csmt_options['csmt_enabled']) {
		$cat_meta_data = get_option('cat_meta_key_'.$cur_cat_id);
		$title = "";
		$title2 = "";
		$csmt_options = get_option('csmt_options');
		$title = str_replace('%category_title%', $cat_meta_data['page_title'], $csmt_options['csmt_cat_title_format']);
		$title = str_replace('%blog_title%', get_bloginfo('name'), $title);
		if(is_paged())
		{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$title2 = str_replace('%page_num%', $paged, $csmt_options['csmt_cat_paged_format']);
		}
		$title = $title.$title2;
	} else {
		$title = str_replace('%category_title%', single_cat_title("",false), $csmt_options['csmt_cat_title_format']);
		$title = str_replace('%blog_title%', get_bloginfo('name'), $title);
		if(is_paged())
		{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$title2 = str_replace('%page_num%', $paged, $csmt_options['csmt_cat_paged_format']);
		}
		$title = $title.$title2;
	}
	return $title;
}

function show_tag_title() {
	$csmt_options = get_option('csmt_options');
	$taxonomies = $csmt_options['csmt_taxonomies'];
	//echo "TAX TRUE";
	global $wp_query, $wpsc_query;
	$is_wpsc_bk = 0;
	if (isset($wpsc_query->query_vars['wpsc_product_category']) && !isset($wpsc_query->query_vars['wpsc-product'])) {
		$taxonomy = 'wpsc_product_category';
		$tag = get_term_by('slug', $wpsc_query->query_vars['wpsc_product_category'], 'wpsc_product_category');
		$cur_tag_id = $tag->term_id;
		$tag_meta_data = get_option($taxonomy.'_meta_key_'.$cur_tag_id); 
		$current_taxonomy = $taxonomy;
		//$current_taxonomy_val =	get_query_var($taxonomy); 	
		$current_taxonomy_val =	$wpsc_query->query_vars['wpsc_product_category'];
		$is_wpsc_bk = 1; 	
	} else if(is_tax()) {
		if(is_array($taxonomies)) {
			foreach ($taxonomies as $taxonomy ) {
				$taxonomy_val =	get_query_var($taxonomy);
				if(is_tax($taxonomy,$taxonomy_val)) {
					$tag = get_term_by('slug', $taxonomy_val, $taxonomy);
					$cur_tag_id = $tag->term_id;
					$tag_meta_data = get_option($taxonomy.'_meta_key_'.$cur_tag_id); 
					$current_taxonomy = $taxonomy;
					$current_taxonomy_val =	get_query_var($taxonomy); 	
				}
			}
		}	
	} else {
		$cur_tag_id = get_query_var('tag_id');
		$tag_meta_data = get_option('tag_meta_key_'.$cur_tag_id);
	}
	if($is_wpsc_bk && get_option($current_taxonomy.'_meta_key_'.$cur_tag_id) && $csmt_options['csmt_enabled']) {
		$title = "";
		$title2 = "";
		$title = str_replace('%tag_title%', $tag_meta_data['page_title'], $csmt_options['csmt_tag_title_format']);
		$title = str_replace('%blog_title%', get_bloginfo('name'), $title);
		if(is_paged())
		{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$title2 = str_replace('%page_num%', $paged, $csmt_options['csmt_tag_paged_format']);
		}
		$title = $title.$title2;
	} else if(is_tax() && get_option($current_taxonomy.'_meta_key_'.$cur_tag_id) && $csmt_options['csmt_enabled']) {
		$title = "";
		$title2 = "";
		$title = str_replace('%tag_title%', $tag_meta_data['page_title'], $csmt_options['csmt_tag_title_format']);
		$title = str_replace('%blog_title%', get_bloginfo('name'), $title);
		if(is_paged())
		{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$title2 = str_replace('%page_num%', $paged, $csmt_options['csmt_tag_paged_format']);
		}
		$title = $title.$title2;
	} else if(get_option('tag_meta_key_'.$cur_tag_id) && $csmt_options['csmt_enabled']) {
		$title = "";
		$title2 = "";
		$title = str_replace('%tag_title%', $tag_meta_data['page_title'], $csmt_options['csmt_tag_title_format']);
		$title = str_replace('%blog_title%', get_bloginfo('name'), $title);
		if(is_paged())
		{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$title2 = str_replace('%page_num%', $paged, $csmt_options['csmt_tag_paged_format']);
		}
		$title = $title.$title2;
	} else {
		$title = str_replace('%tag_title%', ucwords(single_tag_title("", false)), $csmt_options['csmt_tag_title_format']);
		$title = str_replace('%blog_title%', get_bloginfo('name'), $title);
		if(is_paged())
		{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$title2 = str_replace('%page_num%', $paged, $csmt_options['csmt_tag_paged_format']);
		}
		$title = $title.$title2;
	}
	//$title = $current_taxonomy." ".$current_taxonomy_val." ".$cur_tag_id." ".$title;
	//$title = $cur_tag_id." ".$title;
	return $title;
}


function get_current_cat_meta($cur_cat_id) {
	$csmt_options = get_option('csmt_options');
	global $csmt_version;
	if(get_option('cat_meta_key_'.$cur_cat_id) && $csmt_options['csmt_enabled']) {
	  $cat_meta_data = get_option('cat_meta_key_'.$cur_cat_id);
	  echo '<!-- Category SEO Meta Tags '.$csmt_version.' by Bala Krishna (http://www.bala-krishna.com) -->'."\r\n";
	  echo '<meta name="description" content="'.$cat_meta_data['description'].'" />'."\r\n";
	  echo '<meta name="keywords" content="'.$cat_meta_data['metakey'].'" />'."\r\n";
	  echo '<!-- /Category SEO Meta Tags '.$csmt_version.' -->'."\r\n";
	}
}

function get_current_tag_meta($cur_tag_id) {
	$csmt_options = get_option('csmt_options');
	global $csmt_version;
	if(get_option('tag_meta_key_'.$cur_tag_id) && $csmt_options['csmt_enabled']) {
	  $tag_meta_data = get_option('tag_meta_key_'.$cur_tag_id);
	  echo '<!-- Category SEO Meta Tags '.$csmt_version.' by Bala Krishna (http://www.bala-krishna.com) -->'."\r\n";
	  echo '<meta name="description" content="'.$tag_meta_data['description'].'" />'."\r\n";
	  echo '<meta name="keywords" content="'.$tag_meta_data['metakey'].'" />'."\r\n";
	  echo '<!-- /Category SEO Meta Tags '.$csmt_version.' -->'."\r\n";
	}
}

function get_current_tax_meta($taxonomy,$cur_tag_id) {
	$csmt_options = get_option('csmt_options');
	global $csmt_version;
	if(get_option($taxonomy.'_meta_key_'.$cur_tag_id) && $csmt_options['csmt_enabled']) {
	  $tag_meta_data = get_option($taxonomy.'_meta_key_'.$cur_tag_id);
	  echo '<!-- Category SEO Meta Tags '.$csmt_version.' by Bala Krishna (http://www.bala-krishna.com) -->'."\r\n";
	  echo '<meta name="description" content="'.$tag_meta_data['description'].'" />'."\r\n";
	  echo '<meta name="keywords" content="'.$tag_meta_data['metakey'].'" />'."\r\n";
	  echo '<!-- /Category SEO Meta Tags '.$csmt_version.' -->'."\r\n";
	}
}

add_action('admin_menu', 'csmt_admin_menu');

function csmt_admin_menu() {
  global $csmt_domain;
  add_options_page(__('CSMT Settings', $csmt_domain), __('CSMT Settings', $csmt_domain), 'manage_options', 'csmt', 'csmt_admin_options');
  //add_options_page('CSMT Settings', 'CSMT Settings', 'manage_options', 'csmt', 'csmt_admin_options');

}

function csmt_admin_options() {
  global $csmt_domain;

  if (!current_user_can('manage_options'))  {
    wp_die( _e('You do not have sufficient permissions to access this page.', $csmt_domain) );
  }

  echo '<div class="wrap">';
  echo '<h2>' . __("Category SEO Meta Tags Settings", $csmt_domain) . '</h2>  by
<strong>Bala Krishna (<a href="http://www.bala-krishna.com" target="_blank">http://www.bala-krishna.com</a>)</strong>';
  if(isset($_REQUEST['submit']) and $_REQUEST['submit']) {
  echo '<div class="updated fade" id="message">';
  echo '<p>' . _e("Category SEO Meta Tags Settings Updated", $csmt_domai) . '</p>';
  echo '</div>';
  }
  echo '<div id="poststuff">';
  echo '<div id="postdiv" class="postarea">';

$csmt_options = get_option('csmt_options');
?>
<table>
<tbody>
<tr>
<td valign="top">
 
<form name="csmtform" id="csmtform" action="" method="post">
<input type="checkbox" name="csmt_enabled" value="1" id="csmt_enabled" <?php if($csmt_options['csmt_enabled']=='1') print " checked='checked'"; ?> />
<label for="<?php echo $option?>"> <?php echo _e("Enable CSMT", $csmt_domain); ?></label><br />

<br />
<?php echo _e("Category Title Format", $csmt_domain); ?> <br /><input name="csmt_cat_title_format" id="csmt_cat_title_format" value="<?php echo $csmt_options['csmt_cat_title_format']; ?>" style="width:290px;" /><br />
<em><span style="color:#F00"><?php echo _e("enter title tag format for category pages here. default: %category_title% | %blog_title%", $csmt_domain); ?></span></em>
<br /><br />
<?php echo _e("Category Paged Format", $csmt_domain); ?> <br /><input name="csmt_cat_paged_format" id="csmt_cat_paged_format" value="<?php echo $csmt_options['csmt_cat_paged_format']; ?>" style="width:290px;" /><br />
<em><span style="color:#F00"><?php echo _e("enter format for paged pages. it will be appended in above format on paged pages. default: - Page %page_num%", $csmt_domain); ?></span></em>
<br /><br />
<?php echo _e("Tag Title Format", $csmt_domain); ?> <br /><input name="csmt_tag_title_format" id="csmt_tag_title_format" value="<?php echo $csmt_options['csmt_tag_title_format']; ?>" style="width:290px;" /><br />
<em><span style="color:#F00"><?php echo _e("enter title tag format for tag pages here. default: %tag_title% | %blog_title%", $csmt_domain); ?></span></em>
<br /><br />
<?php echo _e("Tag Paged Format", $csmt_domain); ?> <br /><input name="csmt_tag_paged_format" id="csmt_tag_paged_format" value="<?php echo $csmt_options['csmt_tag_paged_format']; ?>" style="width:290px;" /><br />
<em><span style="color:#F00"><?php echo _e("enter format for paged pages. it will be appended in above format on paged pages. default: - Page %page_num%", $csmt_domain); ?></span></em>
<br /><br />

<?php echo _e("Custom Taxonomies Support", $csmt_domain); ?> <br />
<select name="csmt_taxonomies[]" MULTIPLE>
<?php 
$taxonomies=get_taxonomies('','names'); 
foreach ($taxonomies as $taxonomy ) {
  //echo '<p>'. $taxonomy. '</p>';
  	if($taxonomy=='category' || $taxonomy=='post_tag'  || $taxonomy=='nav_menu' || $taxonomy=='link_category' || $taxonomy=='post_format' ) { } else {
		echo "<option ";
		if(is_array($csmt_options['csmt_taxonomies']) && in_array($taxonomy,$csmt_options['csmt_taxonomies'])) echo "selected ";
		echo "name=\"taxonomies\">$taxonomy";
		echo "</option>";
	}
}
?>
</select>
<br /><br />
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
<span id="autosave"></span>
<input class="button-primary" type="submit" name="submit" value="<?php echo 'Save Options'; ?>" style="font-weight: bold;" />
</form>
</td>
<td valign="top">
<div style="margin:10px; width:300px; text-align:left;float:left;background-color:white;padding: 10px 10px 10px 10px;margin-right:15px;border: 1px solid #ddd;">
<?php echo _e("Join our mailing list for web development tips, tricks, and tech updates. Sign up today.", $csmt_domain); ?><br /> <br />
<!-- Begin MailChimp Signup Form --> 
<!--[if IE]>
<style type="text/css" media="screen">
	#mc_embed_signup fieldset {position: relative;}
	#mc_embed_signup legend {position: absolute; top: -1em; left: .2em;}
</style>
<![endif]--> 
 
<!--[if IE 7]>
<style type="text/css" media="screen">
	.mc-field-group {overflow:visible;}
</style>
<![endif]-->
<script type="text/javascript" src="http://bala-krishna.us1.list-manage.com/js/jquery-1.2.6.min.js"></script> 
<script type="text/javascript" src="http://bala-krishna.us1.list-manage.com/js/jquery.validate.js"></script> 
<script type="text/javascript" src="http://bala-krishna.us1.list-manage.com/js/jquery.form.js"></script> 
<script type="text/javascript" src="http://bala-krishna.us1.list-manage.com/subscribe/xs-js?u=65e3dfd2a866328925b5ab75b&amp;id=a872e5da54"></script> 
 
<div id="mc_embed_signup"> 
<form action="http://bala-krishna.us1.list-manage.com/subscribe/post?u=65e3dfd2a866328925b5ab75b&amp;id=a872e5da54" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" style="font: normal 100% Arial, sans-serif;font-size: 10px;"> 
	
<div class="indicate-required" style="text-align: left;font-style: italic;overflow: hidden;color: #000;margin: 0 0% 0 0;"><?php echo _e("* indicates required", $csmt_domain); ?></div> 
<div class="mc-field-group" style="margin: 1.3em 5%;clear: both;overflow: hidden;"> 
<label for="mce-FNAME" style="display: block;margin: .3em 0;line-height: 1em;font-weight: bold;"><?php echo _e("Name ", $csmt_domain); ?></label> 
<input type="text" value="" name="FNAME" size="41" class="" id="mce-FNAME" style="margin-right: 0em;padding: .2em .3em;float: left;z-index: 999;"> 
</div> 
<div class="mc-field-group" style="margin: 1.3em 5%;clear: both;overflow: hidden;"> 
<label for="mce-EMAIL" style="display: block;margin: .3em 0;line-height: 1em;font-weight: bold;"><?php echo _e("Email Address ", $csmt_domain); ?><strong class="note-required">*</strong> 
</label> 
<input type="text" value="" name="EMAIL" size="41" class="required email" id="mce-EMAIL" style="margin-right: 1.5em;padding: .2em .3em;float: left;z-index: 999;"> 
</div> 
 
 
		<div id="mce-responses" style="float: left;top: -1.4em;padding: 0em .5em 0em .5em;overflow: hidden;width: 90%;margin: 0 5%;clear: both;"> 
			<div class="response" id="mce-error-response" style="display: none;margin: 1em 0;padding: 1em .5em .5em 0;font-weight: bold;float: left;top: -1.5em;z-index: 1;width: 80%;background: #FBE3E4;color: #D12F19;"></div> 
			<div class="response" id="mce-success-response" style="display: none;margin: 1em 0;padding: 1em .5em .5em 0;font-weight: bold;float: left;top: -1.5em;z-index: 1;width: 80%;background: #E3FBE4;color: #529214;"></div> 
		</div> 
		<div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn" style="clear: both;width: auto;display: block;margin: 1em 0 1em 5%;"></div> 
      <a href="#" id="mc_embed_close" class="mc_embed_close" style="display: none;"><?php echo _e("Close", $csmt_domain); ?></a> 
</form> 
</div> 
<!--End mc_embed_signup-->
<?php echo _e("If you like this plugin and find it useful, help keep this plugin free and actively developed by clicking the donate button.", $csmt_domain); ?><br />
<a href="http://www.bala-krishna.com" target="_blank"><?php echo _e("Author Home Page", $csmt_domain); ?></a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=krishna711%40gmail%2ecom&item_name=WP Plugin Support Donation&item_number=Support%20Forum&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8" target="_blank"><?php echo _e("Donate", $csmt_domain); ?></a> | <a href="http://www.bala-krishna.com/contact-bala-krishna/" target="_blank"><?php echo _e("Contact Author", $csmt_domain); ?></a> | <a href="http://twitter.com/balakrishna" target="_blank"><?php echo _e("Follow me on Twitter", $csmt_domain); ?></a> | <a href="http://www.bala-krishna.com/wordpress-plugins/" target="_blank"><?php echo _e("Other Wordpress Plugins by author", $csmt_domain); ?></a>
</div>
</td>
</tr>
</tbody>
</table>


<?php 
  echo '</div>';
  echo '</div>';
  echo '</div>';
}

function category_meta_form() {
global $csmt_domain;
if(isset($_GET['action']) && $_GET['action']=="edit") {
?>
<div class="icon32" id="icon-edit"><br></div>
<h2><?php echo _e("Category Meta Setting", $csmt_domain); ?></h2>
<?php $cat_meta = get_option('cat_meta_key_'.$_GET['tag_ID']); //print_r( $cat_meta); ?>
<table class="form-table" >
<tbody>
  <tr class="form-field form-required">
  <th valign="top" scope="row"><label for="cat_title"><?php echo _e("Category Title", $csmt_domain); ?>:</label></th>
    <td><input name="cat_title" type="text" size="40" value="<?php echo $cat_meta['page_title']; ?>" />
    <p class="description"><?php echo _e("Enter category title tag here.", $csmt_domain); ?><span style="color:#F00"><?php echo _e(" (*required)", $csmt_domain); ?></span>
</p>
    </td>
  </tr>
  <tr class="form-field form-required">
  <th valign="top" scope="row"><label for="cat_title"><?php echo _e("Description", $csmt_domain); ?>:</label></th>
    <td><textarea name="cat_desc" size="40" rows="4"><?php echo $cat_meta['description']; ?></textarea>
    <p class="description"><?php echo _e("Enter category description text here.", $csmt_domain); ?><span style="color:#F00"><?php echo _e(" (can be left blank)", $csmt_domain); ?></span></p>
    </td>
  </tr>
  <tr class="form-field form-required">
  <th valign="top" scope="row"><label for="cat_title"><?php echo _e("Keywords", $csmt_domain); ?>:</label></th>
    <td><input name="cat_keywords" type="text" size="40" value="<?php echo $cat_meta['metakey']; ?>" />
    <p class="description"><?php echo _e("Enter category keywords here.", $csmt_domain); ?><span style="color:#F00"><?php echo _e(" (can be left blank)", $csmt_domain); ?></span></p></td>
  </tr>
 </tbody> 
</table>
<div style="margin:10px; text-align:center;">
<a href="http://www.bala-krishna.com" target="_blank"><?php echo _e("Author Home Page", $csmt_domain); ?></a> | <a href="http://www.bala-krishna.com/wordpress-plugins/" target="_blank"><?php echo _e("Wordpress Plugin Development", $csmt_domain); ?></a> | <a href="http://www.bala-krishna.com/contact-bala-krishna/" target="_blank"><?php echo _e("Contact Author", $csmt_domain); ?></a>
</div>
<?php
}
}

function tag_meta_form() {
global $csmt_domain;
if(isset($_GET['action']) && $_GET['action']=="edit") {
	//if(isset($_GET['taxonomy']) && ($_GET['taxonomy']=='post_tag')) $t="Tag"; else $t="Category";
?>
<div class="icon32" id="icon-edit"><br></div>
<h2><?php echo _e("Meta Settings", $csmt_domain); ?></h2>
<?php 
if(isset($_GET['taxonomy']) && ($_GET['taxonomy']!='post_tag') ) { 
	$cat_meta = get_option($_GET['taxonomy'].'_meta_key_'.$_GET['tag_ID']); 
} else {
	$cat_meta = get_option('tag_meta_key_'.$_GET['tag_ID']); 
}    
//print_r( $cat_meta); ?>
<table class="form-table" >
<tbody>
  <tr class="form-field form-required">
  <th valign="top" scope="row"><label for="tag_title"><?php echo _e("Meta Title:", $csmt_domain); ?></label></th>
    <td><input name="tag_title" type="text" size="40" value="<?php echo $cat_meta['page_title']; ?>" />
    <p class="description"><?php echo _e("Enter meta title tag here.", $csmt_domain); ?><span style="color:#F00"><?php echo _e(" (*required)", $csmt_domain); ?></span></p>
    </td>
  </tr>
  <tr class="form-field form-required">
  <th valign="top" scope="row"><label for="tag_desc"><?php echo _e("Description:", $csmt_domain); ?></label></th>
    <td><textarea name="tag_desc" size="40" rows="4"><?php echo $cat_meta['description']; ?></textarea>
    <p class="description"><?php echo _e("Enter meta description text here.", $csmt_domain); ?><span style="color:#F00"><?php echo _e(" (can be left blank)", $csmt_domain); ?></span></p>
    </td>
  </tr>
  <tr class="form-field form-required">
  <th valign="top" scope="row"><label for="tag_keywords"><?php echo _e("Keywords", $csmt_domain); ?></label></th>
    <td><input name="tag_keywords" type="text" size="40" value="<?php echo $cat_meta['metakey']; ?>" />
    <p class="description"><?php echo _e("Enter meta keywords here.", $csmt_domain); ?><span style="color:#F00"><?php echo _e(" (can be left blank)", $csmt_domain); ?></span></p></td>
  </tr>
 </tbody> 
</table>
<div style="margin:10px; text-align:center;">
<a href="http://www.bala-krishna.com" target="_blank"><?php echo _e("Author Home Page", $csmt_domain); ?></a> | <a href="http://www.bala-krishna.com/wordpress-plugins/" target="_blank"><?php echo _e("Wordpress Plugin Development", $csmt_domain); ?></a> | <a href="http://www.bala-krishna.com/contact-bala-krishna/" target="_blank"><?php echo _e("Contact Author", $csmt_domain); ?></a>
</div>

<?php
}
}


add_filter('aioseop_category_title',show_category_title);
add_filter('aioseop_tag_title',show_tag_title);
add_action ('edit_category_form', 'category_meta_form' );
add_action ('edit_tag_form', 'tag_meta_form' );
add_action ('wp_head','show_category_meta'); 
add_action('plugins_loaded', 'csmt_setup');
?>