// JavaScript Document
//js for the WP options page form of the SteemBackeD Donation Button
jQuery(document).ready(function($){
	var steemBackedOptionsColor = {
		// a callback to fire whenever the color changes to a valid color
	   change: function(event, ui){
		   			var color = ui.color.toString();
		   			$('.steemBackedDonateButtonP').css('background-color', color);
					$('.steemBackedDonateBarP').css('background-color', color);
					$('.steemBackedSubmitP').css('background-color', color);
				}
    };
	
    $('.my-color-fieldColor').wpColorPicker(steemBackedOptionsColor);
	
	var steemBackedOptionsText = {
		// a callback to fire whenever the color changes to a valid color
	   change: function(event, ui){
		   			var color = ui.color.toString();
		   			$('.steemBackedDonateButtonTextP').css('color', color);
					$('.steemBackedSubmitP').css('color', color);
					$('.steemBackedDonateBarXP').css('color', color);
					$('.steemBackedDonateBarXLeftP').css('color', color);
				}
    };
	
	$('.my-color-fieldText').wpColorPicker(steemBackedOptionsText);
	
	var steemBackedButtonBorderColor = {
		// a callback to fire whenever the color changes to a valid color
	   change: function(event, ui){
		   			var color = ui.color.toString();
		   			$('#steemBackedDonateButton').css('border', '1px solid ' + color);
					$('.steemBackedSubmitP').css('border', '1px solid ' + color);
				}
    };
	
    $('.my-color-fieldBorder').wpColorPicker(steemBackedButtonBorderColor);
	
    
	
	$('#steemBackedHandle').blur(function(){
		var newHandle = $(this).val();
		$('#steemBackedHandleImageP').attr("src", "https://img.busy.org/@" + newHandle);
		 
	});
	
	$('#steemBackedDefaultAmount').blur(function(){
		var newAmount = $(this).val();
		$('#backedAmountP').val(newAmount);
		 
	});
	
	$('#steemBackedButtonText').blur(function(){
		var newText = $(this).val();
		$('.steemBackedDonateButtonTextP').html(newText);
		$('.steemBackedDonateBarXLeftP').html(newText);
		 
	});
	
	
	
	
	
		
	
});