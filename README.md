#Functionality

* Rotate an image clockwise
* Rotate an image counter clockwise
* Clear the resampled images from your site
* Check if an image is landscape
* Check if an image is portrait
* Generate a padded image by width
* Get the EXIF data for an image
* Create a grey scale version of an image

# Installation
    git clone git://github.com/gordonbanderson/weboftalent-image-util.git
    cd weboftalent-image-util
    git checkout stable24

The name of the output directory does not matter

# Usage

Note that in cases where chaining was not possible (e.g. to set the width) an extra parameter has been added.

## Rotating an Image Clockwise
Assuming the Image in your model is called Photo

		<% control ThePhoto.RotateClockwise  %>
		<img src="$URL"/>
		<% end_control %>

## Checking for Picture Being Portrait
Check for a photograph being landscape in a template as follows:

	<% if ThePhoto.IsPortrait %>
	This picture is portrait
	<% end_if %>

An example application can be found at http://www.tripodtravel.co.nz/galleries/nonthaburi/cycling-west-of-the-river/ , where a CSS class is added if the image is vertical to allow modern browsers to show EXIF data rotated.

## Checking for Picture Being Landscape
Check for a photograph being landscape in a template as follows:

	<% if ThePhoto.IsLandscape %>
	This picture is landscape
	<% end_if %>

## Generate a Padded Image with Configurable Background Color
Silverstripe's default is to show a white background when padding an image, which does not always fit with the design.  This method allows the background padding color to be configured.  The following example sets the background to #C9B and ensures the image fits within 300 by 100 pixels.

	<% control ThePhoto.PaddedImageWithColor(CC99BB 300 100 ) %>
    <img src="$URL"/>
    <% end_control %>

A suitable place to use this might be in a rotating carousel.

## Extract EXIF data
Exif data is returned in a manner suitable for renering as part of a template.  The sets are nested by sections.  Example template for rendering below:

	<% control ServicePhoto.ExifData %>
	<h3>Section : $Name</h3>
	<ul>
	<% control Value %>
	<li>$Name -> $Value</li>
	<% end_control %>
	</ul>
	<% end_control %>

## Making a Greyscale Image
A similar effect is possible with modern browsers using CSS and Javascript, but it may be necessary to generate server side monochrome images.  The parameters are the relative densities of red, green and blue followed by the width in pixels.

		<% control Greyscale(200 30 80 200) %>
		<img class="greyscale" src="$URL"/>
		<% end_control %>


## Silverstripe Version Compatibility
2.4 only (tested with 2.4.5+) - stable24 branch