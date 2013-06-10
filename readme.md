h1.Bigmike Studios Smart Meta Box Wordpress Plugin

Man, Oh Man, does this ever need documentation.

But for now, I just want to note that you can now pass another parameter into all fields:

'validate' => 'numeric'

It doesn't _really_ validate, but it does add an alert to the top of a saved page if a saved value for a field isn't numeric. I'd like to think later that could work a little more robustly, and it would be nice to make it extensible to add other validation options. I like how fields are handled as seperate files; perhaps validation filters could happen the same way.

Later in this file, I'd like to document all the the parameters of the various fields we've developed. That is a project for another day. In the meantime, if you are looking for an example, check out the bms_smart_meta_box_demo.php plugin.

I'd also like to document how the template parameter works for using custom page templates. It's on the list to do.