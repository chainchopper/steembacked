<?php
	/*
	Plugin Name: SteemBacked Steem/SBD Donation Plugin
	Plugin URI: https://steembacked.com/steem-backed-donation-plugin-download/
	description: A plugin to allow website visitors to make a donation to you using steem.
	Version: 1.1.4
	Author: thecodex (signordouglas), justinadams
	Author URI: https://steemit.com/@thecodex
	License: MIT
	*/
   
    //register scripts and css needed for the plugin and options page
	wp_register_style( 'bootstrap', plugin_dir_url(__FILE__) . 'bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap' );
	wp_register_script('jquery');
	wp_enqueue_script('steem', plugin_dir_url(__FILE__) . 'steem.min.js');
	wp_register_script('sc2', plugin_dir_url(__FILE__) . 'sc2.min.js');
	wp_enqueue_script('sc2');
	wp_register_script('sc2pay', plugin_dir_url(__FILE__) . 'sc2-pay.js', array('jquery','sc2'));
	wp_enqueue_script('sc2pay');
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script('sbdColorPicker', plugin_dir_url(__FILE__) . 'sbdColorPicker.js', array('wp-color-picker'));
	wp_enqueue_script('sbdJs', plugin_dir_url(__FILE__) . 'sbdJs.js?v=8', array('sc2pay','jquery'));
	wp_register_style('sbdCss', plugin_dir_url(__FILE__) . 'sbdCss.css');
	wp_enqueue_style('sbdCss');
   
	/** add a submenu to edit this plugin options under [Settings->SteemBacked Donate Button] of the wp-admin console */
	function steembackedMenu() {
		add_options_page( 'SteemBacked Steem/SBD Donation Plugin Options', 'SteemBacked', 'manage_options', 'steembacked-donate-button', 'steembacked_options' );
	}
	
	/** return plugin options page - this is the main function called to return the plugin's options page, located in [settings-> SteemBacked Donate Button] of 
	the wp-admin console */
	function steembacked_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		echo '<div>
				<form method="post" action="options.php">
  							  <h2>SteemBacked Donate Button Settings</h2>
			  
			  <p>Update the settings below to chose how the donate button will appear and function throughout your wordpress site.  You can override most of the settings below by defining attributes in the shortcode.</p>
			  <p>
			  <label for="steemBackedHandle">Steem Handle to Receive the Funds</label><br>
			  <input type="text" id="steemBackedHandle" name="steemBackedHandle" value="'.get_option('steemBackedHandle').'">
			  </p>
			  <p>
			  <label for="steemBackedButtonColor">Button Color</label><br>
			  <input type="text" id="steemBackedButtonColor" name="steemBackedButtonColor" class="my-color-fieldColor" value="'.get_option('steemBackedButtonColor').'">
			  </p>
			  <p>
			  <label for="steemBackedButtonTextColor">Button Text Color</label><br>
			  <input type="text" id="steemBackedButtonTextColor" name="steemBackedButtonTextColor" class="my-color-fieldText" value="'.get_option('steemBackedButtonTextColor').'">
			  </p>
			  <p>
			  <label for="steemBackedButtonBorderColor">Button Border Color</label><br>
			  <input type="text" id="steemBackedButtonBorderColor" name="steemBackedButtonBorderColor" class="my-color-fieldBorder" value="'.get_option('steemBackedButtonBorderColor').'">
			  </p>
			 <p>
			  <label for="steemBackedButtonText">Button Text (max 17 characters)</label><br>
			  <input type="text" id="steemBackedButtonText" maxlength="17" name="steemBackedButtonText" value="'.get_option('steemBackedButtonText').'">
			  </p>
			  <p>
			  <label for="steemBackedMemo">Transaction Memo</label><br>
			  <input type="text" maxlength="50" id="steemBackedMemo" name="steemBackedMemo" value="'.get_option('steemBackedMemo').'">
			  </p>
			  <p>
			  <label for="steemBackedButtonColor">Default Donation Amount</label><br>
			  <input type="text" id="steemBackedDefaultAmount" name="steemBackedDefaultAmount" value="'.get_option('steemBackedDefaultAmount').'">
			  </p>
			  <p>
			  <label for="steemBackedCallback">Successful Donation Callback</label><br>
			  <select id="steemBackedCallback" name="steemBackedCallback">';
		  $bubble = ''; $url = '';
		  if(get_option('steemBackedCallback') == 0){
			  $bubble = 'selected';
		  }else{
			  $url = 'selected';  
		  }
			  
			  
		  echo '<option value="0" '.$bubble.'>Thank You Bubble</option>
				<option value="1" '.$url.'>Redirect to a URL</option>
			  </select>
			  </p>
			  <p><label for="steemBackedCallbackUrlMemo">Thank You Message or Redirect URL</label><br>
			  <input type="text" id="steemBackedCallbackUrlMemo" name="steemBackedCallbackUrlMemo" value="'.get_option('steemBackedCallbackUrlMemo').'"><br>
			  <span style="font-size: 14px;">Max Message Size: 60 characters</span>
			  </p>
			  <p>
			  	  <h3>Preview</h3>
				  <div style="background-color: #f2f3f5; border-color: #CCC; border-radius: 5px; padding: 20px; width: auto;">
					<div class="steemBackedDonateButton steemBackedDonateButtonP" id="steemBackedDonateButton" style="z-index: 500; background-color: '.get_option('steemBackedButtonColor').'; color: '.get_option('steemBackedButtonTextColor').'; border: 1px solid '.get_option('steemBackedButtonBorderColor').';">
						
						<div class="steemBackedDonateButtonImg" id="steemBackedDonateButtonImg-'.$uniqueItemsRand.'" style="background-image: url(\''.plugin_dir_url( __FILE__ ).'steemBackedDonateImg.png\');"></div>
						<div class="steemBackedDonateButtonText steemBackedDonateButtonTextP" style="color: '.get_option('steemBackedButtonTextColor').';">'.get_option('steemBackedButtonText').'</div>
						<div style="clear: both;"></div>
					</div>
				    <div id="steemBackedInner" style="margin-top: 20px; position: relative; margin-left: 0px;">
							<div class="steemBackedDonateBar steemBackedDonateBarP" style="background-color: '.get_option('steemBackedButtonColor').';">
							
						<div class="steemBackedDonateBarXLeft steemBackedDonateBarXLeftP" style="color: '.get_option('steemBackedButtonTextColor').';">'.get_option('steemBackedButtonText').'</div>
							<div class="steemBackedDonateBarX steemBackedDonateBarXP" style="color: '.get_option('steemBackedButtonTextColor').';"">X</div>
						</div>
						<div style="width: 100%; text-align: center; margin-top: 10px;">
						
						<img id="steemBackedHandleImageP" src="https://img.busy.org/@'.get_option('steemBackedHandle').'" style="border: 1px solid #CCC; width: 40px; height: 40px; border-radius: 100%; overflow: hidden; margin-left: auto; margin-right: auto;">
						</div>
						<div class="steemBackedDonateBox">
							<div class="steemBackedDonateT">Amount</div>
								<div id="backedwrapper">
									<div class="backedAmountWrap">
									<input type="text" id="backedAmountP" class="backedAmount" min="0.1" value="'.get_option('steemBackedDefaultAmount').'">
									</div>
									<div class="backedCurrencyWrap">
									<select id="backedCurrency" class="backedCurrency">
											<option value="STEEM">STEEM</option>
											<option value="SBD">SBD</option>
									</select>
									</div>
								</div>
							</div>
							
							<button class="steemBackedSubmit steemBackedSubmitP" style="color: '.get_option('steemBackedButtonTextColor').'; background-color: '.get_option('steemBackedButtonColor').'; border: 1px solid '.get_option('steemBackedButtonBorderColor').';" onclick="return false;">NEXT</button>
						</div>
				  </div>
			  </p>';
			  
			  //finish the form	  
			do_settings_sections( 'steembackedOptionsGroupMain' );
			settings_fields( 'steembackedOptionsGroupMain' );
			submit_button();
			
			echo '</form></div>';
			  
			  echo '<p><h2>How to Use</h2>
			  To add the donate button, add the shortcode <strong>[steemBackedButton]</strong> to any page on your wordpress website.<br><br>
			  You can also override the default settings above by adding the follow attributes to the shortcode:<br>
			  <ul style="list-style-type: square; margin-left: 40px; margin-top: 10px;">
			  	<li><strong>handle:</strong> handle="your handle"</li>
			  	<li><strong>button color:</strong> bc="#FFF"</li>
				<li><strong>button text color:</strong> tc="#000"</li>
				<li><strong>button border color:</strong> bbc="#000"</li>
				<li><strong>transaction memo:</strong> memo="your transaction memo"</li>
				<li><strong>button text:</strong> bt="Donate Text"</li>
				<li><strong>donation amount:</strong> amount="2.0"</li>
				<li><strong>what to do on success (0=thnkYuMessage, 1=redirctToUrl):</strong> call="0"</li>
				<li><strong>thank you message or redirct url:</strong> success="Thank You!!"</li>
				<li><strong>EXAMPLE:</strong> [steemBackedButton handle="your handle" bc="#FFF" tc="#000" bbc="#000" memo="your transaction memo" bt="Donate Text" amount="2.0" call="0" success="Thank You!!"]
			</ul>
			</p>
			<h3>Get a <span style="text-decoration: underline;">Link</span> instead of a Button</h3>
			If you want to place a link in some text instead of using a button, just include the attribute link="1" in your shortcode. The shortcode attributes related to style will be ignored.
			<ul style="list-style-type: square; margin-left: 40px; margin-top: 10px;">
			  	<li><strong>EXAMPLE:</strong> [steemBackedButton link="1"]</li>
			</ul><div style="clear: both;"></div>'; 
			  
			  
			  
		
		
		echo '<p>Created by <a target="_blank" href="https://steemit.com/@thecodex">@theCodeX</a> and <a target="_blank" href="https://steemit.com/@justinadams">@justinadams</a><br />
				Click below to donate and help support this and other Wordpress Plugins for Steem.</p>';
				
				
		echo do_shortcode('[steemBackedButton handle="thecodex" bt="DONATE WITH STEEM" bc="#000" tc="#fff" bbc="#ccc" memo="Thanks for your donation!" call="0" success="Thank You!!"]');
		
		
    } 
		
		
		
	/*return the steembacked donate button - this is the main function called to display the button or link on the WP page */
	function getSteemBackedButton($atts){
		
		/* set the default options */
		$steemBackedHandle = get_option('steemBackedHandle');
		$steemBackedButtonColor = get_option('steemBackedButtonColor');
		$steemBackedButtonTextColor = get_option('steemBackedButtonTextColor');
		$steemBackedDefaultAmount = get_option('steemBackedDefaultAmount');
		$steemBackedMemo = get_option('steemBackedMemo');
		$steemBackedButtonText = get_option('steemBackedButtonText');
		$steemBackedButtonBorderColor = get_option('steemBackedButtonBorderColor');
		$steemBackedButtonLink = get_option('steemBackedButtonLink');
		$steemBackedCallback = get_option('steemBackedCallback');
		$steemBackedCallbackUrlMemo = get_option('steemBackedCallbackUrlMemo');
		
		/* override default options if attributes exist */
		if(isset($atts['handle'])){ $steemBackedHandle = $atts['handle'];	}
		if(isset($atts['bc'])){ $steemBackedButtonColor = $atts['bc'];	}
		if(isset($atts['tc'])){ $steemBackedButtonTextColor = $atts['tc'];	}
		if(isset($atts['amount'])){ $steemBackedDefaultAmount = $atts['amount'];	}
		if(isset($atts['memo'])){ $steemBackedMemo = $atts['memo'];	}
		if(isset($atts['bt'])){ $steemBackedButtonText = $atts['bt'];	}
		if(isset($atts['bbc'])){ $steemBackedButtonBorderColor = $atts['bbc'];	}
		if(isset($atts['link'])){ $steemBackedButtonLink = $atts['link'];	}
		if(isset($atts['call'])){ $steemBackedCallback = $atts['call'];	}
		if(isset($atts['success'])){ $steemBackedCallbackUrlMemo = $atts['success'];	}
		//restrict the length of the bubble popup.
		if($steemBackedCallback == 0){
			  $memoLength = strlen($steemBackedCallbackUrlMemo);
			  if($memoLength > 60){
					$steemBackedCallbackUrlMemo = substr($steemBackedCallbackUrlMemo,0,59).'...';  
			  }
		}
		
		//make unique in case of multiple buttons on a page
		$uniqueItemsRand = rand(10000000, 99999999999);
		
		$returnMe = '<div id="steemBackedOverlay-'.$uniqueItemsRand.'" class="steemBackedOverlay">
					<div id="steemBackedInner">
						<div class="steemBackedDonateBar" style="background-color: '.$steemBackedButtonColor.';" >
						<div class="steemBackedDonateBarXLeft" style="color: '.$steemBackedButtonTextColor.';">'.$steemBackedButtonText.'</div>
						<div class="steemBackedDonateBarX" style="color: '.$steemBackedButtonTextColor.';" onclick="steemBackedDonateClose(\''.$uniqueItemsRand.'\')">X</div>
					</div>
					<div style="width: 100%; text-align: center; margin-top: 10px;">
					<img src="https://img.busy.org/@'.$steemBackedHandle.'" style="border: 1px solid #CCC; width: 40px; height: 40px; border-radius: 100%; overflow: hidden; margin-left: auto; margin-right: auto;" />
					</div>
					<div class="steemBackedDonateBox">
						<div class="steemBackedDonateT">Amount</div>
							<div id="backedwrapper">
								<div class="backedAmountWrap">
								<input type="text" id="backedAmount-'.$uniqueItemsRand.'" class="backedAmount" value="'.$steemBackedDefaultAmount.'" />
								</div>
								<div class="backedCurrencyWrap">
								<select id="backedCurrency-'.$uniqueItemsRand.'" class="backedCurrency">
										<option value="STEEM">STEEM</option>
										<option value="SBD">SBD</option>
								</select>
								</div>
							</div>
						</div>
						<input type="hidden" name="steemBackedHandle" id="steemBackedHandle-'.$uniqueItemsRand.'" value="'.$steemBackedHandle.'" />
						<input type="hidden" name="steemBackedMemo" id="steemBackedMemo-'.$uniqueItemsRand.'" value="'.$steemBackedMemo.'" />
						
						<input type="hidden" name="steemBackedCallback" id="steemBackedCallback-'.$uniqueItemsRand.'" value="'.$steemBackedCallback.'" />
						<input type="hidden" name="steemBackedCallbackUrlMemo" id="steemBackedCallbackUrlMemo-'.$uniqueItemsRand.'" value="'.$steemBackedCallbackUrlMemo.'" />
						
						<button class="steemBackedSubmit" style="color: '.$steemBackedButtonTextColor.'; background-color: '.$steemBackedButtonColor.'; border: 1px solid '.$steemBackedButtonBorderColor.';" onclick="steemBackedDonation(\''.$uniqueItemsRand.'\')">NEXT</button>
					</div>
				</div>';
				
				
				
				if($steemBackedButtonLink == 0){
					//return a button
					$returnMe .= '<div class="steemBackedDonateButton" id="steemBackedDonateButton-'.$uniqueItemsRand.'" onclick="backedzIndexRange(\''.$uniqueItemsRand.'\')" style="z-index: 500; background-color: '.$steemBackedButtonColor.'; color: '.$steemBackedButtonTextColor.'; border: 1px solid '.$steemBackedButtonBorderColor.';">
					<div class="steemBackedDonateButtonImg" id="steemBackedDonateButtonImg-'.$uniqueItemsRand.'" style="background-image: url(\''.plugin_dir_url( __FILE__ ).'steemBackedDonateImg.png\');"></div>
					<div  class="steemBackedDonateButtonText" id="steemBackedDonateButtonText-'.$uniqueItemsRand.'" style="color: '.$steemBackedButtonTextColor.';">'.$steemBackedButtonText.'</div>
					<div style="clear: both;"></div>
					
					</div>';
					
					$returnMe .= '<div id="steemBackedCallbackUrlMemoB-'.$uniqueItemsRand.'" name="steemBackedCallbackUrlMemoB-'.$uniqueItemsRand.'" class="steemBackedCallBackUrlMemoB">'.$steemBackedCallbackUrlMemo.'<br>
								<img class="steemBackedDonateButtonChecked" id="steemBackedDonateButtonChecked-'.$uniqueItemsRand.'" src="'.plugin_dir_url( __FILE__ ).'steemedCheck.png" />
								</div>';
					
				}else{
					//return a link
					$returnMe .= '<a onclick="backedzIndexRange(\''.$uniqueItemsRand.'\')">'.$steemBackedButtonText.'</a>';
					
				}
				
				return $returnMe;
				
	}
	
	/*set the options available to the plugin */
	function steembackedRegisterSettings() {
		//set defaults
	   add_option( 'steemBackedHandle', 'steembacked');
	   add_option( 'steemBackedButtonColor', '#09F');
	   add_option( 'steemBackedButtonTextColor', '#FFF');
	   add_option( 'steemBackedDefaultAmount', '1.0');
	   add_option( 'steemBackedButtonText', 'DONATE WITH STEEM');
	   add_option( 'steemBackedMemo', 'Thanks for your donation!');
	   add_option( 'steemBackedButtonBorderColor', '#CCC');
	   add_option( 'steemBackedButtonLink', 0);
	   add_option( 'steemBackedCallback', 0);
	   add_option( 'steemBackedCallbackUrlMemo', 'Thank You!!');
	   //register settings to a group
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedHandle');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedButtonColor');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedButtonTextColor');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedDefaultAmount');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedButtonText');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedMemo');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedButtonBorderColor');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedButtonLink');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedCallback');
	   register_setting( 'steembackedOptionsGroupMain', 'steemBackedCallbackUrlMemo');

	}
	
	/* add init and other actions, along with shortcodes */
	add_action( 'admin_init', 'steembackedRegisterSettings' );
	add_action( 'admin_menu', 'steembackedMenu' );
	add_shortcode('steemBackedButton', 'getSteemBackedButton');
	
?>