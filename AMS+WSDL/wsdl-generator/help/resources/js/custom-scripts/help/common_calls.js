// js for "public-api-calls" page...

var headerArr = new Array();
headerArr['soap-transmit-response'] = 'transmit';
headerArr['soap-create-user-account'] = 'createUserAccount';
headerArr['soap-change-password'] = 'changePassword';
headerArr['soap-request-new-password'] = 'requestNewPassword';
headerArr['soap-get-batch-status'] = 'getBatchStatus';
headerArr['soap-get-all-batch-numbers'] = 'getAllBatchNumbers';
headerArr['soap-get-batch-details'] = 'getBatchDetails';
headerArr['soap-get-payer-recipient-details'] = 'getPayerRecipientDetails';
headerArr['soap-make-batch-payment'] = 'makeBatchPayment';

$(document).ready(function() {
	
	// while page-load with some hash value...
	var type = window.location.hash.substr(1);
	if( type!='' ) {
		perform(type);
		window.scrollTo(0, 0);
	}
	
	$('a.api-sidebar').on('click', function() {
		
		var selected_id = $(this).attr('id');
		if(window.location.href.indexOf("public-api-calls") > -1) {
			perform(selected_id);
			window.scrollTo(0, 0);
		} else
			window.location.href = doc_base_url +'public-api-calls#'+ selected_id;
		
	});
	
	// for scroll toTop...
	$('body').scrollToTop({skin: 'cycle'});
	
});

	
// function to perform div display...
function perform(selectedID) {

	var div_to_show = '#div-'+ selectedID;
	var selected_href = 'a#'+ selectedID;
	$('div[id^="div-"]').fadeOut('slow', function() {
		$('a.api-sidebar').removeClass('active-trail active'); // remove all active class from href(s)
		$(selected_href).addClass('active-trail active');  // add active class to selected href
		console.log(selectedID);
		// change in header-part...
		$('#h1_header').html( headerArr[selectedID] );
		$(div_to_show).show();	// display the required div
	});
	
}
