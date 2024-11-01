# WP Company Info

This is a Wordpress plugin that allows the user to specify various company information such as a logo, favicon, and various contact information.  There are various shortcodes and template tags available for outputting the information.  See the FAQ for the available shortcodes and template tags.

## Shortcodes

* **Logo**: `[logo size="thumbnail|medium|large"]`  where the size parameter is a Wordpress image size.  Default is medium.
* **Address**: `[address]` OR `[address field="address-1|address-2|city|state|zip"]`
* **Phone Number**: `[phone link="true|false"]`
* **Fax Number**: `[fax]`
* **Social Links**: `[social-networks class="class-name-here" icons="true|false" size="lg|2x|3x|4x|5x" square="true|false" styles="true|false"]`

You may also specify additional contact information as well.  A shortcode will be created for each of the additional fields you add via the options page.  To output that additional field, use the ID you specified as a shortcode.  For example, if the ID you specified is `cell-phone`, the shortcode created would be `[cell-phone]`.

## Template Tags

Here are a list of the available template tags:

`wpci_get_option( $key )`

Returns the value for the specific key/field.

`wpci_has_option( $key )`

Checks whether the value for the specific key/field exists.

`wpci_the_option( $key )`

Outputs the value for the specific key/field.

`wpci_get_logo( $size = 'full', $icon = NULL, $atts = NULL, $src = false )`

Outputs the logo.  The first 3 parameters are the same parameters as the wp_get_attachment_image function. The last parameter controls whether an `<img>` tag is returned, or if the actual image URL is returned.

* $size = Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
* $icon = Use a media icon to represent the attachment.  Default is false.
* $atts = Query string or array of attributes.
* $src = Whether to return the full `<img>` tag or just the URL to the image.

`wpci_the_logo( $size = 'full', $atts = NULL )`

Outputs the logo as an `<img>` tag.   Parameters are as follows:

* $size = Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
* $atts = Query string or array of attributes.