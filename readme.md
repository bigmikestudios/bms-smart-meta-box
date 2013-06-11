Bigmike Studios Smart Meta Box Wordpress Plugin
===============================================

_Man, Oh Man, does this ever need more documentation._

Validation
----------

        'validate' => 'numeric'

It doesn't _really_ validate, but it does add an alert to the top of a saved page if a saved value for a field isn't numeric. I'd like to think later that could work a little more robustly, and it would be nice to make it extensible to add other validation options. I like how fields are handled as seperate files; perhaps validation filters could happen the same way.

Sanitization
------------

		'sanitize' => 'make_into_float'

Using that in a field array, you will callback a function by the same name. Here's an example of how that might work:

		// sanitize to float 
		function make_into_float( $new, $meta_key, $id ) {
			if (!empty($new)) {
   		 		return floatval( $new );
			} else {
				return $new;
			}
		}
		
To come:
--------

Later in this file, I'd like to document all the the parameters of the various fields we've developed. That is a project for another day. In the meantime, if you are looking for an example, check out the bms_smart_meta_box_demo.php plugin.

I'd also like to document how the template parameter works for using custom page templates. It's on the list to do.