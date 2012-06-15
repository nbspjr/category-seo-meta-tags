=== Category SEO Meta Tags ===
Contributors: Bala Krishna, Sergey Yakovlev
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=krishna711%40gmail%2ecom&item_name=WP Plugin Support Donation&item_number=Support%20Forum&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: post,google,seo,meta,meta keywords,meta description,title,posts,plugin, search engine optimization
Requires at least: 3.0
Tested up to: 3.0 and Above
Stable tag: 2.3

== Description ==

Localization support added.

Fixed meta title bug in 2.1. Thanks to phil who reported this bug.
Added meta tags support for tag pages. 

Allow you to add custom meta tags for category and tag pages. This plugin specially designed to work with All In One SEO plugin. If you are using other seo plugin such as HeadSpace2 or SEO Title Tags plugin then this plugin is not for you because this plugin already supporting meta tags for category pages. 

Note before upgraded:
Title tags implemented in a completely new way. If you are previous user and want to upgrade then you need to edit all-in-one-seo-pack again. Old editing will not work with this version. see installation tab for more details. 

Version 1.1 optimized for wordpress 3.0 and above. Do not upgrade if you are using wordpress version earlier then 3.0. 
Peoples are using wordpress lower then 3.0 should use 1.0 version. 

<h4>Translators</h4>
<ul>
<li>Russian (ru_RU) - Sergey Yakovlev</li>
</ul>

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
	
5. Trouble implementing above change? feel free to download already patch version from here: Always download latest patched version from here.
	http://bala-krishna.com/dl/all-in-one-seo-pack.zip	[1.6.13.1]

5. Visit your Category List page and then edit desired category. You will notice new meta title, description, keywords fields on each category page. Update meta-tags and click on save button to save options.

6. Same will apply to tag pages. Go to tag pages and edit tag to enter meta tags.

7. Go to Setting -> Categor SEO Meta Tags to enable/disable plugin and other option.

8. That's it!

== Frequently Asked Questions == 

Please read these **[FAQs](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** here.

== Changelog == 

2.3 
---
Localization support added. Support russian language. Translated by Sadhooklay (sadhooklay@gmail.com)

2.2 
---
Fixed meta title bug. Reported by Phil

2.1 
---
Added setting page to enable/disable plugin without unstalling.
Title format setting added to category and tag pages.
Now you can add prefix and suffix in title. 

2.0 
---
Added tag page meta support
Fixed support for blank keyword and description. title must be entered.
Filter implementaion for less editing of all in one seo pack 

1.1 
---
Added support for wordpress 3.0 and above

1.0
---
Startup version

== Screenshots ==

1. Category SEO Meta Tags option page.
2. Category Meta Entry screenshot.
3. Tag Meta Entry form screenshot.

For more details **[visit plugin page.](http://www.bala-krishna.com/wordpress-plugins/category-seo-meta-tags/)** 