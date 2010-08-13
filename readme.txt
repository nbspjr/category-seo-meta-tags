=== Category SEO Meta Tags ===
Contributors: Bala Krishna
Donate link:  I will add later
Tags: post,google,seo,meta,meta keywords,meta description,title,posts,plugin, search engine optimization
Requires at least: 3.0
Tested up to: 3.0 and Above
Stable tag: 1.1


== Description ==
Allow you to add custom meta tags for category pages. This plugin specially designed to work with All In One SEO plugin. If you are using other seo plugin such as HeadSpace2 or SEO Title Tags plugin then this plugin is not for you because this plugin already supporting meta tags for category pages. 

Optimized for Wordpress 3.0 and above. 

== Upgrade Notice == 
Version 1.1 optimized for wordpress 3.0 and above. Do not upgrade if you are using wordpress version earlier then 3.0. Peoples using wordpress lower then 3.0 should use 1.0 version. 

== Follow Me ==
Follow me on Twitter to keep up with the latest updates [Bala Krishna](http://twitter.com/balakrishna/)


== Installation ==
You can use the built in installer and upgrader, or you can install the plugin manually.

1. You can either use the automatic plugin installer or your FTP program to upload it to your wp-content/plugins directory the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Under Appearacne -> Theme Editor in the WordPress admin, select "Header" from the list and replace `<title><?php bloginfo('name'); wp_title(); ?></title>` (or whatever you have in your `<title>` container) with `<title><?php if (function_exists('cat_seo_title_tag')) { cat_seo_title_tag(); } else { if (is_category()) { single_cat_title(); wp_title(); } else { wp_title(); } } ?></title>`

4. (Only required if you want to use this plugin with All In One SEO Pack and Title Rewrite Option is on)
   Download and open aioseop.class.php file and find following line "if ($aioseop_options['aiosp_rewrite_titles']) {". It is around line number 105. Replace entire line with "if ($aioseop_options['aiosp_rewrite_titles'] && !is_category()) {". Below are the changed before and after change.
   
   Before the change:
   
	if ($aioseop_options['aiosp_rewrite_titles']) {
			ob_start(array($this, 'output_callback_for_title'));
	}
	}
	function aioseop_mrt_exclude_this_page(){
	
	After the change:
	
	if ($aioseop_options['aiosp_rewrite_titles'] && !is_category()) {
			ob_start(array($this, 'output_callback_for_title'));
	}
	}
	function aioseop_mrt_exclude_this_page(){

	Want to do these change manually? Download patched all in one seo pack zip package. Extract and upload all files in `/wp-content/plugins/all-in-one-seo-pack/` folder. 


3. Visit your Category List page and then edit desired category. You will notice new meta title, description, keywords fields on each category page. Update meta-tags and click on save button to save options.

4. That's it!

== Frequently Asked Questions == 

Please read these **[FAQs](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** here.

== Changelog == 

Please read these **[Changelog](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** here.

== Screenshots ==

Please read these **[Screenshots](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** here.





