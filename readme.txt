=== Email posts to subscribers ===
Contributors: gopiplus, www.gopiplus.com
Donate link: http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/
Author URI: http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/
Plugin URI: http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/
Tags: email newsletter, subscription Box, sendmail
Requires at least: 3.4
Tested up to: 4.1
Stable tag: 1.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin generate a newsletter with latest available posts in the blog and send to subscriber. We can easily schedule daily, weekly or monthly.

== Description ==

Check official website for live demo [http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/](http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/)

*   [Live Demo](http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/ "Live Demo")
*   [More Informations](http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/ "More Informations")
*   [Suggestion](http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/ "Suggestion")
*   [Video Tutorial](http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/ "Video Tutorial")

The aim of this plugin is One Time Configuration and Life Time Newsletter to subscribers. This plugin generate a newsletter with the latest available posts in the blog and send to your subscriber. We can easily schedule the newsletter daily, weekly or monthly. 10 default templates available with this plugin, also admin can create the templates using visual editor.

This plugin have subscription box and it allows users to publicly subscribe by submitting their email address. You can add subscriptions box to your sidebar (use widget). posts (use short code) and theme file (use php code).

Please use my Email Subscriber plugin if you want to send notification email to subscribers when new posts are published to your blog.

= Plugin Features: =

*   Subscription box for widget. And short code option for posts and pages.
*   Double opt-in and single opt-in facility for subscriber
*   Send subscription confirmation mail to user and admin (Optional).
*   Unsubscribe link in the newsletter.
*   Import/Export email address.
*   Support localization or internationalization
*   Provide links to schedule cron jobs.
*   Options to send newsletter manually.
*   Options to schedule auto mail for newsletters
*   Options to check newsletter status and when it was viewed.
*   Tinymce visual editor for newsletter theme creation.

= Frequently Asked Questions: =

*   Q1. What are all the steps to do after plugin activation?
*   Q2. How to setup subscription box widget?
*   Q3. How to import and export email address to subscriber list?
*   Q4. How to create/modify the template?
*   Q5. How to add subscription box in posts?
*   Q6. How to modify the existing mail (Opt-in mail, Welcome mail, Admin mail) content?
*   Q7. How to schedule cron job?
*   Q8. Hosting doesnt support cron jobs?
*   Q9. How to filter posts category in the newsletter?
*   Q10. How to configure number of emails send per day?
*   Q11. How to send newsletter manually?
*   Q12. Where to check sent mails?

== Installation ==

Installation Instruction and Configuration [Installation Instruction and Configuration] 
(http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/)

== Frequently Asked Questions ==

Q1. What are all the steps to do after plugin activation?

Q2. How to setup subscription box widget?

Q3. How to import and export email address to subscriber list?

Q4. How to create/modify the template?

Q5. How to add subscription box in posts?

Q6. How to modify the existing mail (Opt-in mail, Welcome mail, Admin mail) content?

Q7. How to schedule cron job?

Q8. Hosting doesnt support cron jobs?

Q9. How to filter posts category in the newsletter?

Q10. How to configure number of emails send per day?

Q11. How to send newsletter manually?

Q12. Where to check sent mails?

FAQ Answer [http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/]
(http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/)

== Screenshots ==

1. Front Page. Subscription box. http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/

2. Admin Page. Subscriber management page. http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/

3. Admin Page. Send Mail page. http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/

4. Admin Page. Setting page. http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/

== Changelog ==

= 1.0 =

1. First version

= 1.1 =

1. Security fix, removed all wp-config.php file direct include.
	a) job/optin.php, 	b) job/subscribe.php, c) job/unsubscribe.php, d) job/viewstatus.php
	e) cronjob/cronjob.php, f) export/ export-email-address.php
2. Minor text changes in all PHP files.
3. Added options to translate into other languages. 

= 1.2 =

1. Minor change in the register.php class

= 1.3 =

1. Tested up to 3.9
2. New link updated for documentation.

= 1.4 =

1. Small javascript issue fixed in the admin end.
2. Subscriber admin page, Check ALL & Uncheck All bug fixed.
3. Short code overlapping issue fixed.

= 1.5 =

1. Full post keyword (###POSTFULL###) added in the Template Compose page. Now using this keyword we can add full post in the newsletter.
2. In the Mail Configuration post count 1 has been added (Previously we don't have option to select single post in the newsletter). With this option we can create Mail Configuration for 1 post.
3. Formatted some mail content.

= 1.6 =

1. Tested up to WordPress 4.0
2. In view subscribers admin page, new option added to filter the email address based on status.
3. Paging option added on view subscribers admin page. In default it will show only first 200 emails, you have drop down box to navigate another page (i.e. 201 to 400 emails etc..).
4. Warning message fix on email address import page (i.e Strict standards: Only variables should be passed by reference)	- Fixed
5. Widget translation issue has been fixed
6. PHP warning message from Subscribers Export page has been removed.
7. Added check for Already Confirmed emails. This is to prevent user clicking optin email link multiple time.

= 1.7 =

1. Tested up to 4.1

== Upgrade Notice ==

= 1.0 =

1. First version

= 1.1 =

1. Security fix, removed all wp-config.php file direct include.
	a) job/optin.php, 	b) job/subscribe.php, c) job/unsubscribe.php, d) job/viewstatus.php
	e) cronjob/cronjob.php, f) export/ export-email-address.php
2. Minor text changes in all PHP files.
3. Added options to translate into other languages. 

= 1.2 =

1. Minor change in the register.php class

= 1.3 =

1. Tested up to 3.9
2. New link updated for documentation.

= 1.4 =

1. Small javascript issue fixed in the admin end.
2. Subscriber admin page, Check ALL & Uncheck All bug fixed.
3. Short code overlapping issue fixed.

= 1.5 =

1. Full post keyword (###POSTFULL###) added in the Template Compose page. Now using this keyword we can add full post in the newsletter.
2. In the Mail Configuration post count 1 has been added (Previously we don't have option to select single post in the newsletter). With this option we can create Mail Configuration for 1 post.
3. Formatted some mail content.

= 1.6 =

1. Tested up to WordPress 4.0
2. In view subscribers admin page, new option added to filter the email address based on status.
3. Paging option added on view subscribers admin page. In default it will show only first 200 emails, you have drop down box to navigate another page (i.e. 201 to 400 emails etc..).
4. Warning message fix on email address import page (i.e Strict standards: Only variables should be passed by reference)	- Fixed
5. Widget translation issue has been fixed
6. PHP warning message from Subscribers Export page has been removed.
7. Added check for Already Confirmed emails. This is to prevent user clicking optin email link multiple time.

= 1.7 =

1. Tested up to 4.1