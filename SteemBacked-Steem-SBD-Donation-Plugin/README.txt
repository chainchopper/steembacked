Adjust Settings

Navigating to the "settings" menu in your wp-admin console, and then choose "SteemBacked".  There is more documentation on how to use this plugin on this page.


How to Use

To add the donate button, add the shortcode [steemBackedButton] to any page on your wordpress website.

You can also override the default settings mentioned above by adding the follow attributes to the shortcode:

handle: handle="your handle"
button color: bc="#FFF"
button text color: tc="#000"
button border color: bbc="#000"
transaction memo: memo="your transaction memo"
button text: bt="Donate Text"
donation amount: amount="2.0"
what to do on success (0=thnkYuMessage, 1=redirctToUrl): call="0"
thank you message or redirct url: success="Thank You!!"

EXAMPLE: [steemBackedButton handle="your handle" bc="#FFF" tc="#000" bbc="#000" memo="your transaction memo" bt="Donate Text" amount="2.0" call="0" success="Thank You!!"]



Get a Link instead of a Button

If you want to place a link in some text instead of using a button, just include the attribute link="1" in your shortcode. The shortcode attributes related to style will be ignored.
EXAMPLE: [steemBackedButton link="1"]

Change what happens upon a successful donation:

In the file, sbdJs.js, you will find an if/else statement in the steemBackedDonation function.  If the donation is successful, the code in the [if] section is executed.  If the donation is cancelled (payment window is closed by user), the code in the [else] section is executed.  You can add your own code here to change the default functionality of showing a thank you message or redirecting visitor to another page.
