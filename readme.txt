=== Category SEO Meta Tags ===
Contributors: Bala Krishna
Donate link:  I will add later
Tags: post,google,seo,meta,meta keywords,meta description,title,posts,plugin, search engine optimization
Requires at least: 3.0
Tested up to: 3.0 and Above
Stable tag: 2.0

== Description ==

Added meta tags support for tag pages. 

Allow you to add custom meta tags for category pages. This plugin specially designed to work with All In One SEO plugin. If you are using other seo plugin such as HeadSpace2 or SEO Title Tags plugin then this plugin is not for you because this plugin already supporting meta tags for category pages. 

Note before upgraded:
Title tags implemented in a completely new way. If you are previous user and want to upgrade then you need to edit all-in-one-seo-pack again. Old editing will not work with this version. see installation tab for more details. 

Version 1.1 optimized for wordpress 3.0 and above. Do not upgrade if you are using wordpress version earlier then 3.0. 
Peoples are using wordpress lower then 3.0 should use 1.0 version. 

== Upgrade Notice == 
Version 1.1 optimized for wordpress 3.0 and above. Do not upgrade if you are using wordpress version earlier then 3.0. Peoples using wordpress lower then 3.0 should use 1.0 version. 

== Follow Me ==
Follow me on Twitter to keep up with the latest updates [Bala Krishna](http://twitter.com/balakrishna/)


== Installation ==
You can use the built in installer and upgrader, or you can install the plugin manually.

1. You can either use the automatic plugin installer or your FTP program to upload it to your wp-content/plugins directory the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Compulary change in All In One SEO Pack (Required for category meta tag support)

   Download and open aioseop.class.php file and go to line number 711. Add below line after line number 711.

	$title = apply_filters('aioseop_category_title',$title);

	Before:
	
	$title = $this->paged_title($title);
	$header = $this->replace_title($header, $title);

	After: 

	$title = $this->paged_title($title);
	$title = apply_filters('aioseop_category_title',$title);
	$header = $this->replace_title($header, $title);
	
4. Compulary change in All In One SEO Pack(Required for tag pages meta support)

   Download and open aioseop.class.php file and go to line number 761 and 773. Add below line after line number 761 and 773.

	$title = apply_filters('aioseop_tag_title',$title);

	Before:
	
	$title = $this->paged_title($title);
	$header = $this->replace_title($header, $title);

	After: 

	$title = $this->paged_title($title);
	$title = apply_filters('aioseop_tag_title',$title);
	$header = $this->replace_title($header, $title);
	
5. Trouble implementing above change? feel free to download already patch version from here: 
	http://bala-krishna.com/dl/all-in-one-seo-pack.zip	

5. Visit your Category List page and then edit desired category. You will notice new meta title, description, keywords fields on each category page. Update meta-tags and click on save button to save options.

6. Same will apply to tag pages. Go to tag pages and edit tag to enter meta tags.

7. That's it!

== Frequently Asked Questions == 

Please read these **[FAQs](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** here.

== Changelog == 

2.0 
---
Added tag page meta support
Filter implementaion for less editing of all in one seo pack 

1.1 
---
Added support for wordpress 3.0 and above

1.0
---
Startup version



== Screenshots ==

Please read these **[Screenshots](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** here.





