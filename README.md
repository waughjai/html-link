HTML Link
=========================

Simple class for encapsulating link info and autogenerating the HTML for it.

The 1st 2 mandatory arguments to pass into the constructor are the URL & the HTML value that will represent the link on the page ( the part that goes 'tween the opening & closing a tags ). This can be any printable object, including not only the usual string for text, but also other HTML content generators.

3rd is an optional hash map o' attributes. In addition to all the valid HTML5 attributes an a tag can have, which will automatically be added if given, adding an external attribute & setting it to true will automatically generate the HTML to securely make it open in a new tab, & adding an anchor attribute will automatically add an anchor/bookmark link to the URL ( the part after the # in a URL ).

4th is an optional hash map o' URL GET parameters that will be automatically added to the URL.
