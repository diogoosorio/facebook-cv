function FacebookCV(url, admin, $){
	
	// AJAX calls URL
	this.url = url;
	
	// Is the user logged in? This is obviously double checked
	// on the server, it's just to avoid unnecessary AJAX requests
	this.isAdmin = admin;
	
	// What elements should trigger an action?
	var trigger = '.facebookcv-action';
	
	// FacebookCV object
	var me = this;
	
	// Current modal window
	var currentModal;
	
	// Was the slider initialized?
	var sliderInit = false;
	
	// What's the routable function trigger?
	this.setTrigger = function(name){
		
		if(typeof name === 'string'){
			trigger = name;
		}
		
	};
	
	// Gets the current trigger
	this.getTrigger = function(){
		return trigger;
	};
	
	
	this.showError = function(message){
		console.log("SHOWERROR: " + message);
	};
	
	
	// Scrolls to a certain location on the DOM
	this.goToYear = function(params){
		var year = params.year;
		var el   = $('.year-' + year).get(0);
		$.scrollTo(el, 'slow');
		$('.cronogolia-actual').removeClass('cronogolia-actual');
		console.log($('#year-' + year));
		$('#year-' + year).addClass('cronogolia-actual');
	};
	
	
	// Switch between timelines
	this.timeline = function(params){
		var type = params.type;
		var hits = 0;
		
		$('.timeline-separator').css('display', 'none');
		$('.type-' + type).css('display', 'block');
		
		$('.caixa-timeline:visible').each(function(k, v){
			if(hits > 0){
				if(hits % 2 === 0){
					$(v).removeClass('col-direita').addClass('col-esquerda');
				} else {
					$(v).removeClass('col-esquerda').addClass('col-direita');
				};
			};
			hits = hits + 1;
		});
	};
	
	// Reloads the user information on the DOM
	//
	// @todo This method should be revised as its too binded with DOM elements 
	this.reloadUser = function(){
		var req  = url + 'get_user';
		$.get(req, {}, function(data){
			
			if(typeof data !== 'undefined'){
				try{
					
					data = $.parseJSON(data);
					
					if(data.result){
						
						data = data.data;
						
						$.each(data, function(v){
							
							if(v === 'user_page_title'){
								document.title = data[v];
							};
							
							if($('#' + v).length > 0){
								$('#' + v).html(data[v]);
							};
						});
						
					};
					
					currentModal.close();
					
				} catch(err){
					console.log(err);
					// Something went wrong, simply refresh the page to update
					// the user info 
					window.location.reload();
				};
			};
			
		});
	};
	
	// Show the edit user interface
	this.editUser = function(params){
		
		if(isAdmin){
			
			// Is this a submission, or a request for the form?
			if(typeof params === 'undefined' || !params.hasOwnProperty('submit')){
	
				// Get the form
				var req = url + 'edit_user';
				$.get(req, {}, function(data){
					
					currentModal = $('<div></div>');
					$(currentModal).html(data).appendTo('body');
					
					currentModal.dialog({
						close: function(){
							currentModal.remove();
						},
						modal: true,
						title: 'Editar Utilizador',
						width: 500
					});
				});
				
			} else {
				
				var fields = {};
				
				$('input[type="text"]', '#edit-user').each(function(k, v){
					
					// Collect form fields
					fields[$(v).attr('name')] = $(v).val();
					
				});
				
				// Save it to the database
				var req = url + 'edit_user';
				$.post(req, fields, function(){
					me.reloadUser();
				});
			};
		
		};
	};
	
	
	// Goes to a certain element and triggers a click
	this.goToAndClick = function(params){
		if(typeof params === 'undefined' || !params.hasOwnProperty("id")){
			return false;
		};
		
		
		var el 		= params.id;
		var click	= typeof( params.click === 'string' ) ? params.click : el;
		$.scrollTo('#' + el, function(){
			console.log(click);
			$('#' + click).focus();
		});
	};
	
	// Sends a message
	this.sendMessage = function(params){
		if(typeof params !== 'object' || !params.hasOwnProperty('submit')){
			
			// Show the dialog
			var req  	= url + 'get_contact_form';
			var message = params.hasOwnProperty('area') ? $('#' + params.area).val() : '';
			
			$.post(req, {'message': message}, function(data){
				currentModal = $('<div></div>');
				$(currentModal).html(data).appendTo('body');
				
				currentModal.dialog({
					close: function(){
						currentModal.remove();
					},
					modal: true,
					title: 'Entrar em Contacto',
					width: 500
				});
			});
		} else {
			
			// Quick validation
			var id;
			var submit 		= true;
			var postInfo = {};
			
			$('textarea, input', '#formulario-contacto').each(function(k, v){
				if($(v).val().length === 0){
					id = $(v).attr('id');
					$('#' + id + '-erro').html('Não pode estar vazio');
					submit = false;
				} else {
					$('#' + id + '-erro').html('');
					postInfo[$(v).attr('name')] = $(v).val();
				};
			});
			
			// Submit it
			if(submit){
				var req = url + 'submit_contact';
				$.post(req, postInfo, function(data){
					try{
						data = $.parseJSON(data);
						if(data.result){
							$('#formulario-contacto').html('A sua mensagem foi enviada com sucesso. Obrigado!');
						} else {
							$('#formulario-contacto').prepend($('<p class="formulario-fb-erro">Ocorreu um erro. Por favor entre em contacto via email.</p>'));
						};
					} catch(err){
						$('#formulario-contacto').prepend($('<p class="formulario-fb-erro">Ocorreu um erro. Por favor entre em contacto via email.</p>'));
					};
				});
			};
		};
	};
	

	// Slide 
	this.slide = function(params){
		if( typeof params === 'undefined' || !params.hasOwnProperty("id") ){
			return false;
		};
		
		var el = params.id;
		
		// Initialize slider
		if(!sliderInit){
			var totalWidth = 0;
			var tempWidth;
			var tempMargin;
			var leftMargin;
			var rightMargin;
			
			// Compute what should be the UL total width
			$('li', '#' + el).each(function(){
				
				tempMargin = 0;
				
				// Add left margin
				leftMargin = parseInt($(this).css('margin-left').replace('px', ''));					
				
				// Add right margin
				rightMargin = parseInt($(this).css('margin-right').replace('px', ''));
				
				// Total margin
				tempMargin = leftMargin + rightMargin;
				
				// Total width
				tempWidth  = $(this).width();
				totalWidth = totalWidth + (tempWidth + tempMargin);
				
			});
			
			totalWidth = totalWidth + 100;
			$('#' + el).css('width', totalWidth + 'px');
			sliderInit = true;
		};
		
		// Compute animation
		var currentMargin	= Math.abs(parseInt($('#' + el).css('margin-left').replace('px', '')));
		var maxWidth		= $('#' + el).width();
		var slideIncrement	= $('#' + el).parent().width();
		var nextWidth		= 0;
		
		//console.log(maxWidth);
		//console.log((currentMargin + slideIncrement));
		
		if((currentMargin + slideIncrement) <= maxWidth){
			var nextWidth = '-' + (currentMargin + slideIncrement);
		};
		
		$('#' + el).animate({
			'margin-left': nextWidth
		}, 'slow');
	};
	
	
	// Parses the request and calls the correct 
	// method
	function route(event){
		
		// Collect the method and parameters from the DOM element
		var method 		= $(this).attr('method');
		var rawParams	= $(this).attr('params') ? $(this).attr('params') : false;
		var params		= {};
		
		if(rawParams){
			
			// Parameters should be separated by ,
			rawParams = rawParams.split(',');
			
			// Each parameter should contain a key => val, separated by :
			$.each(rawParams, function(k, v){
				var param = v.split(':');
				params[param[0]] = param[1];
			});
			
		};
		
		
		// If the method exists, call it
		if(typeof me[method] === 'function'){
			me[method](params);
		};
		
	};
	
	// Bind the class to the DOM
	$(trigger).live('click', route);
};


// Animations and whatnot
$(document).ready(function(){
	var myObj 	= new FacebookCV(ajaxUrl, isAdmin, jQuery);
	
	// Show edit buttons
	/*$('.editable').hover(function(){
		$('.admin-edit', this).css('display', 'block');
	}, function(){
		$('.admin-edit', this).css('display', 'none');
	});*/
	
	// Contact area
	$('textarea', '#contacto-caixa').focus(function(){
		$(this).css('height', '90px').html('');
	}).blur(function(){
		if($(this).val().length === 0){
			$(this).val('Entre em contacto comigo aqui...').css('height', '25px');
		}
	});
	
	
	// Friend Request
	var fr = false;
	$('#friend-request').hover(function(){ fr = true; }, function(){ fr = false; });
	$('body').mouseup(function(){
		if(!fr){
			$('#amigos').css('display', 'none');
			$('#friend-request').removeClass('seleccionado');
		};
	});
	$('#friend-request').click(function(){
		$('#amigos').css('display', 'block');
		$('#friend-request').addClass('seleccionado');
	});
	
	
	// Datepicker
	$('.datepicker').live('click', function(){
		$(this).datepicker({
			showOn: 'focus',
			dateFormat: 'yy-mm-dd'
		}).focus();
	});
	
	
	var originalPosition = false;
	
	// Scroll
	$(window).scroll(function(){
	
		var y 		= $(window).scrollTop();
		var pos		= $('#cronologia').offset().top;
		
		if(!originalPosition) originalPosition = $('#cronologia').offset().top;
		
		if(y >= originalPosition - 60){
			$('#cronologia').css({
				position: 'fixed',
				top:	  '40px'
			});
		} else {
			$('#cronologia').css({
				position: 'relative',
				top: 0
			});
		};
		
	});
});