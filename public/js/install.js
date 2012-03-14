(function($){
	
	var CVInstall = (function(){
		
		// Is Facebook SDK here?
		var fbObj = false;
		
		
		// Retrieves the user information from the FB API
		var fetchInformation = function(){
			
			// Show the loading div
			$('#loading').css('display', 'block');
			
			
			// Obtain the user information
			fbObj.api('/me', function(response){
				
				// Pass the info directly to the corresponding controller
				$.ajax({
					url: base_url + 'install/add_user',
					type: 'POST',
					data: {data: response },
					success: function(data){
						$('#loading').css('display', 'none');
						$('#verify-success').css('display', 'block');
					}
				});
			});
		};
		
		
		// Displays an error box after the main h1 tag
		// @param errors mixed		Either a string or a list of strings containing
		//							the error messages
		var triggerError = function(errors){
			
			// Does the error element already exists on the DOM?
			var div = $('<div class="errors"></div>');
			
			// Append error messages
			if(typeof errors === 'object'){
				$.each(errors, function(k){
					$(div).append('<p>' + errors[k] + '</p>');
				});
			} else {
				$(div).append('<p>' + errors + '</p>');
			}
			
			// Append the errors to the DOM
			$('h1', 'body').after(div);
			
			// Wait a couple of seconds and clear the error
			setTimeout(function(){
				$(div).slideUp('slow');
			}, 3000);
		};
		
		
		// Public methods
		return {
			
			// Initialize Facebook SDK
			initFacebook: function(){
				
				// Get the SDK and append it as a property of this object
				$.getScript('http://connect.facebook.net/pt_PT/all.js', function(){
					fbObj = FB;
					fbObj.init({
						appId:	appID,
						cookie: true,
						status: true
					});
				});
				
			},
			
			
			// Logs in to Facebook
			fbLogin: function(){
				
				if(fbObj !== false){					
					fbObj.login(function(response){
						if(response.status === 'connected'){
							fetchInformation();
						} else {
							triggerError('Não foi possível autenticá-lo junto do Facebook.');
						}
					}, {scope: 'user_about_me,user_birthday,user_education_history,user_location,email'});
				}
			},
			
			
			// Show next step
			next: function(e){
				
				// Get the current and next step
				var current = $('.passo:visible').get(0);
				var currID	= $(current).attr('id');
				var nextID	= currID.split('-');
				nextID		= parseInt(nextID[1]) + 1;
				
				// Show the next step
				$('.passo').css('display', 'none');
				$('#passo-' + nextID).css('display', 'block');
			}
		}
	})();
	
	
	// DOM Bindings
	$(document).ready(function(){
		$('.next').click(CVInstall.next);
		
		// Should I initialize Facebook?
		if(typeof appID !== 'undefined' && typeof appSecret !== 'undefined'){
			
			// Initialize Facebook SDK
			CVInstall.initFacebook();
			
			// Facebook Bindings
			$('#fb-connect').click(CVInstall.fbLogin);
		}
	});
	
}(jQuery));