jQuery(document).ready(function() {
	jQuery('.tg_contact_form').each(function(){
		var elementID = jQuery(this).attr('data-raw-id');
		var hasCaptcha = jQuery(this).attr('data-captcha');

		jQuery('form#contact_form_'+elementID).submit(function() {
			jQuery('#reponse_msg_'+elementID+' ul li.error').remove();
			
			var hasError = false;
			jQuery('.required_field').each(function() {
				if(jQuery.trim(jQuery(this).val()) == '' && !jQuery(this).hasClass('gdpr')) {
					var labelText = jQuery(this).prev('label').text();
					jQuery('#reponse_msg_'+elementID+' ul').append('<li class="error">'+tgContactParams.please_enter+' '+labelText+'</li>');
					hasError = true;
				} else if(jQuery(this).hasClass('gdpr') && !jQuery(this).is(':checked')) {
					var labelText = jQuery(this).next('label').text();
					jQuery('#reponse_msg_'+elementID+' ul').append('<li class="error">'+tgContactParams.please_check+' '+labelText+'</li>');
					hasError = true;
				} else if(jQuery(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,13})?$/;
					if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
						var labelText = jQuery(this).prev('label').text();
						jQuery('#reponse_msg_'+elementID+' ul').append('<li class="error">'+tgContactParams.please_enter_valid+' '+labelText+'</li>');
						hasError = true;
					}
				}
			});
			
			if(!hasError) {
				var contactData = jQuery('#contact_form_'+elementID).serialize();

				//If checking captcha first
				if(hasCaptcha) 
				{
					jQuery.ajax({
					    type: 'GET',
					    url: tgContactParams.ajaxurl+'?action=photography_script_get_captcha&check=true',
					    data: jQuery('#contact_form_'+elementID).serialize(),
					    success: function(msg){
					    	if(msg == 'true')
					    	{
					    		jQuery('#contact_submit_'+elementID).fadeOut('normal', function() {
									jQuery(this).parent().append('<i class="fa fa-circle-o-notch fa-spin"></i>');
								});
								
					    		jQuery.ajax({
								    type: 'POST',
								    url: tgContactParams.ajaxurl+'?action=photography_contact_mailer',
								    data: contactData+'&tg_security='+tgContactParams.ajax_nonce,
								    success: function(results){
								    	jQuery('#contact_form_'+elementID).hide();
										jQuery('#reponse_msg_'+elementID).html(results);
								    }
								});
					    	}
					    	else
					    	{
					    		alert(msg);
					    		return false;
					    	}
					    }
					});
				}
				else
				{
					jQuery('#contact_submit_btn'+elementID).fadeOut('normal', function() {
						jQuery(this).parent().append('<i class="fa fa-circle-o-notch fa-spin"></i>');
					});
		 			
		 			jQuery.ajax({
					    type: 'POST',
					    url: tgContactParams.ajaxurl+'?action=photography_contact_mailer',
					    data: contactData+'&tg_security='+tgContactParams.ajax_nonce,
					    success: function(results){
					    	jQuery('#contact_form_'+elementID).hide();
					    	jQuery('#reponse_msg_'+elementID).html(results);
					    }
					});
				}
	 		}
			
			return false;
			
		});
	});
});