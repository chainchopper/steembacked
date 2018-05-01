# steembacked


<center><a href="https://steembacked.com/wp-content/uploads/2018/04/SteemBacked-Steem-SBD-Donation-Plugin.zip"><img class="aligncenter wp-image-423" src="https://steemitimages.com/DQmPmgbQZYudbedpWcV53XhfVy9otQCVzfjAoL97Hq7ewws/WP-Press-kit-logo-med.png" alt="" width="276" height="149" /></a></center>


# SteemBackeD - STEEM/SBD Donation - WordPress Plugin
<strong>A WordPress Plugin That Allows You To Place A "Donate" Button Anywhere In Your Blog That Accepts Shortcodes. It Performs The Donation Transaction Via v2.steemconnect Without Redirecting The Visitor To Another URL For Confirmation, Thus Keeping The Process Seamless. There Are No Keys Required, Just The Username Of The Recipient.</strong>

# How To Install

To Install The Plugin, Simply Download The Zip File From This Repository. You Can Also Get It From Our Website <a href="https://steembacked.com/steem-backed-donate-button-download/">Steem Backed</a>. Once Your Download Has Completed, Locate The Downloaded Zip File And Upload It To Your WordPress Installation (i.e. http://yoursite/wp-admin/plugins.php ). After Installation Is Confirmed, Activate The Plugin. You Will Then Notice A New Tab In Settings---->SteemBacked----> From here You Can Configure The Button, Preview It In Real-Time, As Well As View Shortcode Examples And Instructions For Placing It In Your Blog.

# Adjust Settings

Navigate to the "settings" menu in your wp-admin console, and then choose "SteemBackeD Donate Button". There is more documentation on how to use this plugin on this page.

# How to Use

To add the donate button, add the shortcode [steemBackedButton] to any page on your wordpress website.

You can also override the default settings mentioned above by adding the follow attributes to the shortcode:

handle: handle="your handle" <br />
button color: bc="#FFF" <br />
button text color: tc="#000" <br />
button border color: bbc="#000" <br />
transaction memo: memo="your transaction memo" <br />
button text: bt="Donate Text" <br />
donation amount: amount="2.0" <br />
what to do on success (0=thnkYuMessage, 1=redirctToUrl): call="0" <br />
thank you message or redirct url: success="Thank You" <br />

EXAMPLE: [steemBackedButton handle="your handle" bc="#FFF" tc="#000" bbc="#000" memo="your transaction memo" bt="Donate Text" amount="2.0" call="0" success="Thank You!!"]

# Get a Link instead of a Button

If you want to place a link in some text instead of using a button, just include the attribute link="1" in your shortcode. The shortcode attributes related to style will be ignored.
EXAMPLE: [steemBackedButton link="1"]

Change what happens upon a successful donation:

In the file, sbdJs.js, you will find an if/else statement in the steemBackedDonation function. If the donation is successful, the code in the [if] section is executed. If the donation is cancelled (payment window is closed by user), the code in the [else] section is executed. You can add your own code here to change the default functionality of showing a thank you message or redirecting visitor to another page.

# About Steem Backed
SteemBacked Was Created By <a href="https://steemit.com/@justinadams">@Justin Adams</a> And <a href="https://steemit.com/@thecodex">The Codex</a> To Show Our Devotion To The STEEM community. We Are Still New To Steemit, And Though We Are Technically Adept, On Steemit, That Doesn't Matter Much When Your Voice Is Small. If You Like What We Are Doing, Consider Lending One Of Your Free Witness Votes To @justinadams on steemit.com . We Aim To Help Decentralize The Network By Providing Alternative Gateways And Nodes Rather Than Remain Reliant On Nodes Controlled By A Select Few That Have Already Prioritized Their Use To Other Services That May Or May Not Be Community Related Nor In It's Best Interest. Temporary Or Permanant SP Delegations Are Welcome As Well. Thanks For Checking Out Our Plugin Guys. With A Bit Of Support There Will Be Loads More To Come!
