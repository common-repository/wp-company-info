=== Plugin Name ===
Contributors: bdeleasa
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=9AJYKL3BHB6RS&lc=US&item_name=WP%20Company%20Info%20Wordpress%20Plugin&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: contact info, contact information, social network links, social links, social network widget, social network icons, company information, company info
Requires at least: 3.0.1
Tested up to: 4.9.4
Stable tag: 1.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to input information specific to the company/website such as a logo image, address, phone number and social network links.

== Description ==

This plugin allows you to specify various company information such as a logo, favicon, and various contact information.  There are various shortcodes and template tags available for outputting the information.  See the FAQ for the available shortcodes and template tags.

== Installation ==

1. Upload the `wp-company-info` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Input the branding information by going to Settings > Branding.
1. Input your contact information by going to Settings > Contact Information.
1. Input your social network links by going to Settings > Social Network Links.
1. See the FAQ for instructions on outputting all of the branding, contact information and social networks.
1. That's it! :)

== Frequently Asked Questions ==

= How do I embed the logo I uploaded? =

Using the `[logo]` shortcode will output the image uploaded via the Branding settings page.  There is one `size` parameter available for this shortcode:

`[logo size="thumbnail"]`

The size parameter refers to a registered Wordpress image size.  The default size is "medium".

= How do I embed the contact information? =

This plugin provides various shortcodes for outputting the contact information. The default shortcodes available are as follows:

* Address: [address] OR [address field="address-1|address-2|city|state|zip"]
* Phone Number: [phone]
* Fax Number: [fax]
* Email address: [email]
* Social Links: [social-networks class="class-name-here" icons="true|false" size="lg|2x|3x|4x|5x" square="true|false" styles="true|false"]

You may also specify additional contact information as well.  A shortcode will be created for each of the additional fields you add via the options page.  To output that additional field, use the ID you specified as a shortcode.  For example, if the ID you specified is `cell-phone`, the shortcode created would be `[cell-phone]`.

= Are there any template tags available? =

Yes, there are!  Here are a list of the available template tags:

**`wpci_get_option( $key )`**

Returns the value for the specific key/field.

**`wpci_has_option( $key )`**

Checks whether the value for the specific key/field exists.

**`wpci_the_option( $key )`**

Outputs the value for the specific key/field.

**`wpci_get_logo( $size = 'full', $icon = NULL, $atts = NULL, $src = false )`**

Outputs the logo.  The first 3 parameters are the same parameters as the wp_get_attachment_image function. The last parameter controls whether an `<img>` tag is returned, or if the actual image URL is returned.

* $size = Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
* $icon = Use a media icon to represent the attachment.  Default is false.
* $atts = Query string or array of attributes.
* $src = Whether to return the full `<img>` tag or just the URL to the image.

**`wpci_the_logo( $size = 'full', $atts = NULL )`**

Outputs the logo as an `<img>` tag.   Parameters are as follows:

* $size = Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
* $atts = Query string or array of attributes.

== Changelog ==

= 1.9.0

* Replacing the old CMB address class with an updated one that includes support for international addresses.
* Making the address field international by supporting countries.
* Adding support for the new country field in the address shortcode.

= 1.8.9 =

* Updating CMB2 to the latest version.

= 1.8.7 =

* Fixing an issue with the social links outputting all links even if the URL wasn't filled in.

= 1.8.6 =

* Fixing the placement of commas in the address shortcode to remove extra commas.

= 1.8.5 =

* Only including the address field if another plugin didn't already register a CMB2 address field.

= 1.8.4 =

* Adding support for adding classes to the phone number link.

= 1.8.3 =

* Adding the $output variable to fix an 'undefined variable' PHP notice.

= 1.8.2 =

* Adding a new pencil icon as an option.

= 1.8.1 =

* Adding nofollow to the social links output.

= 1.8.0 =

* Adding support for links in custom contact shortcodes.

= 1.7.7 =

* Fixing issue with the email link not being outputted properly when the schema tags are active.

= 1.7.6 =

* Adding schema tags around the email address if schema tags are enabled.

= 1.7.5 =

* Adding a schema tag around the site name if the schema tags are being used.
* Fixing an issue with the address field getting broken because of renamed functions.

= 1.7.4 =

* Updating address function prefixes again.

= 1.7.3 =

* Updating the function prefixes for the address field functions.

= 1.7.2 =

* Renaming the shortcode date function.

= 1.7.1 =

* Updating the changelogs.

= 1.7.0 =

* Adding a new class for creating generic shortcodes.

= 1.6.1 =

* Making sure a comma appears after the address line 1 in the unformatted shortcode output.

= 1.6.0 =

* Adding two new shortcodes: one for outputting the site name and another for outputting the site description.

= 1.5.0 =

* Adding a widget that outputs the custom logo uploaded by the user.

= 1.4.0 =

* Changing the customizer control from an image control to a media control so it saves the attachment ID instead of a URL.

= 1.3.1 =

* Fixing an issue with the address shortcode when not using any formatting.

= 1.3.0 =

* Adding Instagram to the list of social network options.

= 1.2.0 =

* Removing the wpautop reordering function because it interferes with the Gravity Forms shortcode output.

= 1.1.1 =

* Modifying the schema tags for the address so it uses a span tag instead of a div tag.

= 1.1.0 =

* Adding support for showing addresses not formatted (on one line).
* Adding a function that moves wpautop priority higher so shortcodes used within page/post content are formatted with paragraphs and line breaks.

= 1.0.1 =

* Adding a missing constant that was causing some PHP warnings and an issue with the social network links widget.

= 1.0.0 =

* Initial version of the official Wordpress plugin.