// JavaScript Document
//js for the Donate Button of the SteemBackeD plugin

	
	//open a window to complete the transacdtion
	function steemBackedDonation(uniqueItemsRand) {
		var backedAmount1 = document.getElementById('backedAmount-' + uniqueItemsRand).value;
		//var backedAmount1 = $('#backedAmount-' + uniqueItemsRand).val();
		if(backedAmount1.length > 0){
				backedAmount = Number(backedAmount1);
				backedCurrency = document.getElementById('backedCurrency-' + uniqueItemsRand).value;
				steemBackedHandle = document.getElementById('steemBackedHandle-' + uniqueItemsRand).value;
				steemBackedMemo = document.getElementById('steemBackedMemo-' + uniqueItemsRand).value;
				
				//close the overlay
				steemBackedDonateClose(uniqueItemsRand);
				
				//open window to make the donation
				sc2_pay.requestPayment('Donation', steemBackedHandle, backedAmount, backedCurrency, steemBackedMemo, function(trans) {
					if(trans) {
						 //if the user makes a donation, code added here will be triggered
						//JSON.stringify(trans) - trans holds the json response which includes the transaction details
						var callBack = document.getElementById('steemBackedCallback-' + uniqueItemsRand).value;
						if(callBack == '1'){
							//redirect to the specified URL
							window.location.href = document.getElementById('steemBackedCallbackUrlMemo-' + uniqueItemsRand).value;
						}else{
							//show the Thank You Bubble
							document.getElementById('steemBackedCallbackUrlMemoB-' + uniqueItemsRand).style.display='block';
							setTimeout(function(){ 
								document.getElementById('steemBackedCallbackUrlMemoB-' + uniqueItemsRand).style.display='none';
							}, 5000);
						}
						
					} else {
						//if user cancels the donation, code added here will be triggered
						
					}
				})
		}else{
				alert('You must enter an amount.');
		}
	}
	
	
	



	/*change the z-index of the overlay to be higher than any other defined div tag z-index on the page */
	function backedzIndexRange(uniqueItemsRand) {
			var highestZ; var onefound = false; var divs = document.getElementsByTagName('*');
			if( ! divs.length ) { highestZ = 100000; }
			for( var i=0; i<divs.length; i++ ) {
			   if(divs[i].style.zIndex) {
					  if( ! onefound ) { 
							 highestZ = parseInt(divs[i].style.zIndex); onefound = true;
					  }else {
							 var ii = parseInt(divs[i].style.zIndex); if( ii > highestZ ) { highestZ = ii; }
					 }
			  }
			}
			if(highestZ < 100000){ highestZ = 100000; }else{ highestZ = highestZ+1; }
			//update the z-index and show the overlay
			document.getElementById('steemBackedOverlay-' + uniqueItemsRand).style.zIndex=highestZ;
			document.getElementById('steemBackedOverlay-' + uniqueItemsRand).style.display='block';
	}
	
	/* close the donate overlay window */
	function steemBackedDonateClose(uniqueItemsRand){
			//hide the donate overlay
			document.getElementById('steemBackedOverlay-' + uniqueItemsRand).style.display = 'none';   
	}



