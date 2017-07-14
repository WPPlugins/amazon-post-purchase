=== Amazon Post Purchase ===
Contributors: heypublisher, aguywithanidea, loudlever
Donate link: https://www.literary-arts.org/contribute/
Tags: affiliate sales, Amazon, ASIN, Amazon Associate, monetize, heypublisher
Requires at least: 4.0
Tested up to: 4.7.3
Stable tag: 2.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily display Amazon Affiliate products related to a your post or page in a side-bar widget.

== Description ==
Amazon Post Purchase Plugin is based upon the "Amazon Product In a Post Plugin" developed by [Don Fischer](http://fischercreativemedia.com/).
This widget, however, is intended for use as a side-bar widget in themes that support dynamic side-bars.

The Plugin is useful for quickly displaying an Amazon product in the side-bar for an individual post.  The plugin only displays when the post or page has a custom field set, and that custom field's value is a valid Amazon ASIN (also known as the ISBN-10  for books).

**Usage Examples:**

* Interview an Author -- and allow readers to purchase the author's latest book.
* Review a Movie -- and allow readers to purchase the DVD.
* Blog about your latest trip to Greece -- and allow readers to purchase a Greek Travel Guide.
* Monetize your blog posts with the ability for readers to purchase ANY Product related to your post.

**How it Works:**
The plugin uses the newest Amazon Product Advertising API, ensuring full security on all transaction calls.

To use the plugin, we recommend that you first get an Amazon Affiliate Account.  Once you have an account, install the plugin, then enter your Amazon Associate ID and the keyname you will use in your post's Custom Field to track the ASIN.

*PLEASE NOTE:* If you DO NOT add your own custom Associate ID, you WILL NOT get credit for any purchases made from your product posts.  By default, this plugin uses our Affiliate Account ID -- so until you input your Affiliate Account ID, all referral $$ will go to us.  (If you're wishing to make a donation - there are easier ways to do it :) You have been warned!

== Installation ==
1. Upload the *amazon-post-purchase* folder (inside the zip file) to your */wp-content/plugins/* directory
2. Activate the plugin through the 'Plugins' menu in WordPress

After you have installed the plugin and loaded the widget into your side-bar, you will need to configure it.

Drag the "AmazonPostPurchase" widget to the appropriate side-bar container.  Where prompted, set the following fields:

* "Title" - this will be the title displayed above the widget in the side-bar.
- You can make this simple text, like "You Might Also Like", or
- You can make the title dynamically display the Author/Artist's name by using the keyword *#_AUTHORNAME_#*, like this: "Recently by #_AUTHORNAME_#".

* "Amazon Affiliate ID" - this should be _your_ Affiliate ID.  If you do not set this field, all referral $$ from Amazon will go to us.

* "Custom Field Name" - this is the 'name' you will use when you create a custom field in your post.  By default this value is set to 'ASIN'.

No additional adjustments are needed unless you want to configure your own CSS styles.

*WARNING: If you do not add your Amazon Affiliate ID, you will NOT get credit for purchases made using this Plugin.*

**Usage**

Once installed, adding a product to your post is a simple process:

*  Go into the full edit mode for the post (Post/Edit then select the post).
*  Under the Custom Fields, click on the link 'Enter New' (after you've done this the first time, you will simply select the value from the drop-down list).
*  Input the value you set in the widget "Custom Field Name" in the "Name" field.  (we recommend the word "ASIN").
*  Input the ASIN for the product you want displayed in the "Value" field.
*  Save or Publish the post.

*Yes -- it's that easy!*

== Styling ==

You can customize the look and feel of the displayed widget, including turning on or off the display of certain data elements, through CSS.  The following CSS describes the various data elements displayed in the Widget:

<pre>
#amazon-post-purchase-container {
  /* This is the container DIV for the displayed widget */
}
#amazon-post-purchase-image  {
  /* This is the container DIV for the product IMAGE.  Defaults are: */
  text-align:center;
}
#amazon-post-purchase-large-image-link {
  /* This controls the display of the text "See larger image"  Defaults are: */
  text-align:center;
}
#amazon-post-purchase-byline {
  /* This DIV contains the product 'title' and 'author' information.  Two sub elements are contained within this DIV: */
}
#amazon-post-purchase-byline H2 {
    /* This is where the product 'title' is contained */
}
#amazon-post-purchase-byline #amazon-post-purchase-author {
    /* This is where the product 'author' is contained */
}
#amazon-post-purchase-publication {
  /*  This Container displays the Format (ie: 'paperback'), Release Date, and Publisher information.
      If you turn 'off' display of this id, all 3 of those elements will not be displayed */
}
#amazon-post-purchase-price {
  /*  This is where the 'List Price', 'New Price' and 'Used Price' are displayed
      If you turn 'off' display of this id, all 3 of those elements will not be displayed */
}
#amazon-post-purchase-button {
  /*  This controls the display of the 'Buy Now at Amazon' button.
      By default, this displays the image "images/buyamzon-button.png" in the plugin directory.
      If you want to use a different 'buy' button, simply save a new image with the same name to this location. */
}
</pre>

If you have any questions about configuration or styling, please feel free to contact us at: [wordpress@heypublisher.com](mailto:wordpress@heypublisher.com)

== Frequently Asked Questions ==

= Do I Have to Pay Anything to Use this Plugin? =
No.  This widget is FREE for you to use in your blog, online magazine, or other Wordpress-powered website.  Have fun!

= Can I Make a Donation to HeyPublisher for Use of this Plugin? =
If you wish to make a donation for use of this plugin, please consider donating instead to the [Literary Arts](https://www.literary-arts.org/contribute/) organization.  Literary Arts introduces high school students to the craft of writing.  They are our kind of group!

= Can I Embed Amazon Products In My Post With This Plugin? =
No.  If you want to do that, we recommend the "Amazon Product In a Post Plugin".

= Can I Use This Widget More Than Once In My Sidebar? =
Since the plugin is activated off of a Custom Field in the post, and there will only be one custom field matching the configuration of the Plugin, you will get identical results if you use the Widget more than once in your side-bar.

= This Widget is Not Displaying on my Homepage? =
This is by design.  Since the widget acts upon an ASIN being set at the POST level, a homepage with more than one POST can yield inconsistent results.  An update is planned for late 04/2010 that will allow users to define homepage display parameters.  Look for this feature then.

== Screenshots ==

1. Widget as it will appear in the Widget manager.
2. Control screen for configuring the widget.
3. Custom Field in the Post Edit screen.  This is where you set the ASIN for the product you want to display.
4. How the widget will display on your website.

== Changelog ==

= 2.2.0 =
* Released 2017-04-06
* Added support for Italy and Spain
* Added external link to Affiliate Stores soyou can quickly get your account set up and validated

= 2.1.0 =
* Released 2017-04-05
* Tested up through WordPress 4.7.3
* This plugin is now owned and maintained by [HeyPublisher](https://www.heypublisher.com)
* Removed a bunch of kruft from the codebase.
* Prepping for a rewrite of the product search component for faster rendering.
* Updated stylesheet and enqueueing.

= 2.0.0 =
* WordPress 4.x compliant.
* Updated the query to Amazon to return default currency of store being queried.
* Added a Settings page and side-bar navigation to settings.
* All widget configuration except title is now in a Settings page.

= 1.1.3 =
* Fixed a bug regarding products that don't have sale data.

= 1.1.2 =
* Fixed a bug that was preventing activation on some hosting servers.
* Updating documentation to clarify that widget will not display on Homepage by default.

= 1.1.1 =
* Better documentation, including adding section on how to customize look of widget through CSS.
* Cleaned out some of the kruft in the code.
* This plugin is now owned and maintained by [Loudlever, Inc.](http://www.loudlever.com)

= 1.0.1 =
* Simplified the Admin configuration screen.
* Added ability to create dynamic widget titles through use of reserved word *#_AUTHORNAME_#*
* Cleaned up some cluttered parts of code.
* Updated readme.txt file to better explain installation process.

= 1.0 =
* Plugin Release (10/23/2009)
