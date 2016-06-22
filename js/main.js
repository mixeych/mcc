jQuery(document).bind('gform_confirmation_loaded', function(event, formId){

    if(formId == 6){
    	$('#popmake-118').css('position','fixed');
    	$('#popmake-742').css('position','fixed');
    	setTimeout(function(){
    		window.location = window.location.href; 
    	}, 3000);
    }
});

jQuery(document).ready(function($) {

	if($("body").hasClass("page-id-126")||$("body").hasClass("page-id-747")){
		
                var bizUserRole = $("#accordion-1").attr("data-bizrole");
                $("#input_2_13 option").each(function(){
                   $(this).removeAttr("selected");
                   if($(this).val() === bizUserRole){
                       $(this).prop('selected', true);
                   }
                });
        
                $.ajax({
			url: ajaxurl+"?action=getSubCat",
			type: 'GET',
			dataType: 'json',
			success: function(data){
                                if(data.success){
                                        var res = data.result;
                                        if(res.length>0){
                                                var inputs = $("#gform_fields_10").find(".sub_categ_premium");

                                                for (var i = 0; i<res.length; i++){
                                                        $(inputs[i]).find("select option").each(function(){

                                                                var val = $(this).val();
                                                                if(val == res[i]){

                                                                        $(this).attr("selected", "selected");
                                                                }
                                                        });

                                                }
                                        }
                                }
			}
		})
	}

	$(".disable_select").find("select").attr("disabled", "disabled");
	
	$(".disable_input input").attr('disabled','disabled');
	
	$(".add_cover_photo_button").click(function() {
		photo_id = $(this).attr("rel");
		$("#"+photo_id).click();
	});
	
	$(".pay-button.upgrade").click(function(e){
		e.preventDefault();
                var checked = $(this).parent().siblings(".body-sentence-item").find(".checkbox-sentence .terms").prop("checked");
                if(!checked){
                    return false;
                }
                var payForYear = $(this).parent().siblings(".body-sentence-item").find(".pay-for-year").prop("checked");
                var price;
                var currentPack = $(this).attr('data-currentPack');
                if(currentPack==='Basic'&&payForYear){
                    price = 570;
                }else if(payForYear&&$(this).parents(".premium-sentence").length&&currentPack !== 'Basic'){
                    price = 600;
                }else if(currentPack==='Basic'&&!payForYear){
                    price = 20;
                }else{
                    price = $(this).parent().siblings(".body-sentence-item").find(".price").text();
                }
                price = "sum="+price;
                var url = $(".popup-content iframe").attr("src");
                var newUrl = url.replace(/sum=([0-9]+)/, price);
                $(".custom-popup .popup-content iframe").attr("src", newUrl);
		$(".popmake-overlay").css("background-color", "rgba( 12, 12, 12, 0.8 )").fadeIn(200);
		$(".custom-popup").fadeIn(200);
                
	});
        
        $(".pay-button.stop-paying").click(function(e){
            e.preventDefault();
            var res = confirm("Are you sure?");
            if(!res){
                return false;
            }
            $.ajax({
                url: ajaxurl+"?action=stopPaying",
                type: 'POST',
                dataType: 'json',
                success: function(res){
                    if(res.success){
                        alert("stoped");
                    }
                }
            });
        });
        
        $(".pay-button.downgrade").click(function(e){
            e.preventDefault();
            var res = confirm("Are you sure?");
            if(!res){
                return false;
            }
            $.ajax({
                url: ajaxurl+"?action=downgrade",
                type: 'POST',
                dataType: 'json',
                success: function(res){
                    if(res.success){
                        alert("downgraded");
                    }
                }
            });
        });
        
	$(".popup-close").click(function(){
		$(".popmake-overlay").fadeOut(200);
		$(this).parents(".popup").fadeOut(200);
	})
        
        $(".btn-by-package").click(function(e){
            e.preventDefault();
            var price = $(this).attr("data-price");
            if($(".message-popup").length){
                var number;
                switch(price){
                    case '20': number = 1000;
                        break;
                    case '30': number = 2000;
                        break;
                    case '100': number = 10000;
                        break;
                    case '60': number = 5000;
                        break;
                }
                $(".message-popup span.number").html(number);
                $(".message-popup input.sum").val(price);
                $(".message-popup").fadeIn(200);
                $(".popmake-overlay").css("background-color", "rgba( 12, 12, 12, 0.8 )").fadeIn(200);
            }else{
                price = "sum="+price;
                var url = $(".popup-content iframe").attr("src");
                var newUrl = url.replace(/sum=([0-9]+)/, price);

                newUrl = newUrl.replace(/product=package/, 'product=messages');
                $(".custom-popup .popup-content iframe").attr("src", newUrl);
		$(".popmake-overlay").css("background-color", "rgba( 12, 12, 12, 0.8 )").fadeIn(200);
		$(".custom-popup").fadeIn(200);
            }
        });
        
        $(".message-popup .popup-close").click(function(){
            $(".message-popup").fadeOut(200);
            $(".popmake-overlay").fadeOut(200);
        });
        
        $("#remove-credit-card").click(function(){
           var res = confirm('Are you sure?');
           if(!res){
                return false;
            }
            $.ajax({
                url: ajaxurl+"?action=removeCreditCard",
                type: 'POST',
                dataType: 'json',
                success: function(res){
                    if(res.success){
                        alert("card removed");
                    }
                }
            });
        });
        $("#change-credit-card").click(function(){
           var res = confirm('Are you sure?');
           if(!res){
                return false;
            }
            $.ajax({
                url: ajaxurl+"?action=removeCreditCard",
                type: 'POST',
                dataType: 'json',
                success: function(res){
                    if(res.success){
                        window.location.reload();
                    }
                }
            });
        });
        
	/*change logo*/
	
	$(".main-logo input").change(function(){
		var button = $(this);
		var mainLogo = this.files;
		var logoData = $(".main-logo").attr("data-logo");
		var photoData =  $(".main-logo").attr("data-photo");
		$('#ModalLoadBackground').modal('show');
		var categoryData = $("#accordion-2").attr("data-category");
		var data = new FormData();
		if(mainLogo){
			$.each(mainLogo, function(key, value){
				data.append( key, value );
			});
		}else{
			data.append( 'mainLogo', '' );
		}
		$.ajax({
			url: ajaxurl+"?action=changeMainLogo",
			type: 'POST',
			cache: false,
			data: data,
        	//dataType: 'json',
        	processData: false,
        	contentType: false,
        	success: function(res){
        		if(res != "error"){

        			alert("Your logo has been updated successfully");
        			$('#ModalLoadBackground').modal('hide');
        			if(logoData == 0){
        				$(".main-logo").attr("data-logo", "1");
        			}
        			var title=button.parents(".accordion-section").find(".accordion-section-title");
        			if(title.hasClass("err") && photoData != 0 && categoryData != 0){
						title.removeClass("err");
					}
        		}
        	}
		});
	});

	$(".business_gallery_img").change(function() {
		var div = $(this).parent();
		var main = false;

		if(div.parent().attr("id") == 'main_photo_block'){
			main = true;
		}
		var button = $(this).parent().children(".add_cover_photo_button");
		photo_id = $(this).attr("id");
		business_id = $(this).attr("rel");
		img = $("#"+photo_id)[0].files[0];
		var formData = new FormData();
		formData.append("file", img);
		formData.append("photo_id", photo_id);
		formData.append("business_id", business_id);

		jQuery('#ModalLoadBackground').modal('show');
		$.ajax({
			url: ajaxurl + "?action=update_business_gallery",
			type: 'POST',
			cache: false,
			contentType: false,
			data: formData,
			processData: false, 
			success: function(data) {
				if(data != 'error') {
					if(button.text() != "Change Main Photo"){
						button.text("Change Main Photo");
					}
					if(div.children("img").length){
						div.children("img").attr("src", data);
					}else{
						div.append("<img class='business_small_preview' alt='' src='"+data+"'>");
					}
					if(div.children("a").length){
						div.children("a").attr("href", data);
					}else{
						div.append("<a target='_blank' href='"+data+"'>Click HERE to preview Photo</a>");
					}
					if(!main){
						var arr = photo_id.split('_');

						var del = '<span class="add-photo-remove" data-id="'+arr[1]+'" data-biz="'+business_id+'" >remove</span>';
						if(div.children(".add-photo-remove").length == 0){
							div.append(del);
							div.find(".add-photo-remove").click(delete_additional_photo);
						}
						if(button.text() != "Change Photo #"+arr[1]){
							button.text("Change Photo #"+arr[1]);
						}

					}else{
						if(button.text() != "Change Main Photo"){
							button.text("Change Main Photo");
						}
						var title=div.parents(".accordion-section").find(".accordion-section-title");
						var logo = $(".main-logo").attr("data-logo");
						var photoData = div.parent().attr("data-photo");
						var categoryData = $("#accordion-2").attr("data-category");
						if(photoData == 0){
							div.parent().attr("data-photo", "1");
						}
						if(title.hasClass("err") && logo != 0 && categoryData !=0 ){
							title.removeClass("err");
						}
					}
					div.children("a").attr("href", data);
					alert("Your Photo has been updated successfully");
					jQuery('#ModalLoadBackground').modal('hide');
				} else{
					alert("ERROR!");
				}
			},
			error: function(data) {
				console.log('failed');
			}
		});
	});
	
	$('.accordion-section-title').click(function(e) {
		if($(this).hasClass("blocked")){
			e.preventDefault();
			return;
		}
		// Grab current anchor value
		var currentAttrValue = $(this).attr('title');
		$(this).toggleClass('active');
		
		$('#accordion-' + currentAttrValue).slideToggle(); 
		e.preventDefault();
	});
	
	$(".main_category_gf select").change(function() {
		val = $(this).val();
		$.ajax({
			url: ajaxurl + "?action=get_sub_businesses_cats",
			type: 'POST',
			data: { "pcatid" : val },
			success: function(data) {
				var options = '';
				$.each(data, function(key, val) {
					options += '<option value="' +data[key].value+ '">' +data[key].text+ '</option>';
				});

				$(".allowed_select_sub_cat select").html(options);
			},
			error: function(data) {
				console.log('failed');
			}
		});
	});
	
	$(".disable_nl textarea").keypress(function (e) {
		if (e.keyCode == '13') { e.preventDefault(); }
	});
// set cookie for checking active section
			
	$(".accordion-section-padding .gform_button").click(function(){
		var cook = getCookie("active");
		var activeId = $(this).attr("id").split("_");
		var active = activeId[activeId.length-1];
		if(!cook){
			var d = new Date(new Date().getTime() + 10 * 1000);
			document.cookie = "active="+active+"; path=/; expires="+d.toUTCString();
		}else{
			if(cook != active){
				var d = new Date(new Date().getTime() + 10 * 1000);
				document.cookie = "active="+active+"; path=/; expires="+d.toUTCString();
			}
		}
	});

	/*google maps*/
	$("#popmake-1360 .popmake-content").css("height", "500px");

	/*add city placeholder*/
	var city = $(".user-city").val();
	$(".disable_input.biz-city input").attr("placeholder", city);

	/*delete additional photo*/
	$(".add-photo-remove").click(delete_additional_photo);

	/* delete benefit from favorite */

	$(".delFavBenefit").click(delBenefitFromFav);
	/*add benefit to favorite*/
	$(".addFavBenefit").click(addBenefitTofav);

	/*business to favorite*/
	$(".addFavBusiness").click(addBusinessToFav);
			
	$(".delFavBusiness").click(delBusinessFromFav);

	/* change benefits*/

	$(".choose-fav-type a").click(function(){
		if($(this).hasClass("ben")){
			if(!$(".favorite-bens div").length){
				$.ajax({
					url: ajaxurl,
					data: {
						action: "getFavBenefits",
					},
					success: function(res){
						$(".favorite-bens").html(res);
						$(".favorite-bizs").hide();
						$(".favorite-bens").show();
					}
				});
			}else{
				$(".favorite-bizs").hide();
				$(".favorite-bens").show();
			}
		}
		if($(this).hasClass("biz")){
			$(".favorite-bens").hide();
			$(".favorite-bizs").show();
		}

	});

	/*validate main photo/logo*/

	$("#gform_submit_button_11").click(function(e){
		e.preventDefault();
		var validPhoto = false;
		var validLogo = false
		if(!$("#main_photo_block .business_gallery_image img").length){
			if(!$("#main_photo_block").hasClass("gfield_error")){
				$("#main_photo_block").addClass("gfield_error");
			}
			if(!$("#main_photo_block .validation_message").length){
				$("#main_photo_block").append("<div class='validation_message'>This field is required.</div>");
			}
			 $('html, body').animate({
                    scrollTop: $(".logo-choose").offset().top
                }, 200);
			 validPhoto = true;
		}
		var logo = $(".main-logo").attr("data-logo");
		if(logo == 0){
			validLogo = true;
			if(!$(".logo-choose").hasClass("err")){
				$(".logo-choose").addClass("err");
			}
			$('html, body').animate({
                    scrollTop: $(".logo-choose").offset().top
                }, 200);
		}
		if(!validLogo && !validPhoto){
			$("#gform_11").submit();
			return;
		}else{
			return;
		}
	});

	/*set expiration date*/

	
	var timestamp = Date.now();
	var defaultTime = timestamp+(86400000*30);
	var defaultDate = new Date (defaultTime);
	var day = defaultDate.getDate();
	if(day<10){
		day = "0"+day;
	}
	var month = defaultDate.getMonth();
	month++;
	if(month<10){
		month = "0"+month;
	}
	var year = defaultDate.getFullYear();
	var defVal = day+"/"+month+"/"+year;
	$( "#input_7_8" ).val(defVal);



	gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
	    
	    if((formId == 7 && fieldId == 8)){
	    	
	    	optionsObj['defaultDate'] = 30;
	    	optionsObj['gotoCurrent'] = true;
	    	optionsObj['minDate'] = new Date();
	    	optionsObj['altFormat '] = "dd/mm/yy";
	    }
	    if((formId == 14 && fieldId == 4)){
	    	optionsObj['defaultDate'] = new Date();
	    	optionsObj['minDate'] = new Date();
	    	optionsObj['altFormat '] = "dd/mm/yy";
	    }

	    if((formId == 8 && fieldId == 5)){
	    	optionsObj['defaultDate'] = new Date();
	    	optionsObj['minDate'] = new Date();
	    	optionsObj['altFormat '] = "dd/mm/yy";
	    }
		if((formId == 8 && fieldId == 6)){
			    	optionsObj['defaultDate'] = new Date();
			    	optionsObj['minDate'] = new Date();
			    	optionsObj['altFormat '] = "dd/mm/yy";
			    }



	    return optionsObj;
	} );

	/*edit add benefits*/
	var row;
	$(".popmake-edit-additional-benefit").click(editPopup);

	var benefitImage;

	$("#input_14_3").change(function(){
		benefitImage = this.files;
	});

	var mainBenefitImage;

	$("#input_9_2").change(function(){
		mainBenefitImage = this.files;
	});


	$("#gform_submit_button_14").click(function(e){
		e.stopPropagation();
		e.preventDefault();
		var benefitId = $("#field_14_6 input").val();
		var benefitTitle = $("#input_14_1").val();
		var benefitDesc = $("#input_14_7").val();
		var benefitArea = $("#input_14_5").val();
		var expDate = $("#input_14_4").val();
		var popup = $(this).parents(".popmake")
		var data = new FormData();
		data.append('benefitId', benefitId);
		data.append('benefitTitle', benefitTitle);
		data.append('benefitDesc', benefitDesc);
		data.append('benefitArea', benefitArea);
		data.append('expDate', expDate);
		if(benefitImage){
			$.each(benefitImage, function(key, value){
				data.append( key, value );
			});
		}else{
			data.append( 'benefitImage', '' );
		}
		
		$.ajax({
			url: ajaxurl+"?action=editAddbenefit",
			type: 'POST',
			cache: false,
			data: data,
        	dataType: 'json',
        	processData: false,
        	contentType: false,
        	success: function(respond, textStatus, jqXHR){
        		if(respond.success){
        			window.row.find("td:nth-child(3)").children(".ben-title").text(benefitTitle);
        			window.row.find("td:nth-child(3)").children(".ben-desc").text(benefitDesc);
        			window.row.next().find(".desc").text(benefitDesc);
        			window.row.find("td:nth-child(5)").text(expDate);
        			window.row.find("td:nth-child(6)").text(respond.area);
        			popup.popmake('close');
        		}
        	}
		});
	});

	/*add additional benefit*/
	$("#manage_business_benefits > div #add_benefit").removeClass("popmake-add-benefit");
	$("#manage_business_benefits > div #add_benefit").click(function(e){
		e.preventDefault();
		var number = $("#manage_business_benefits > div table tbody tr.drop-down").length;
		if(number > 10){
			
			$("#popmake-1818").popmake('open');
			return;
		}else{
			if($("#popmake-304").length){
				$("#popmake-304").popmake('open');
			}else if($("#popmake-758").length){
				$("#popmake-758").popmake('open');
			}
			$("#input_7_1").val('');
			$("#input_7_10").val('');
			var timestamp = Date.now();
			var defaultTime = timestamp+(86400000*30);
			var defaultDate = new Date (defaultTime);
			var day = defaultDate.getDate();
			if(day<10){
				day = "0"+day;
			}
			var month = defaultDate.getMonth();
			month++;
			if(month<10){
				month = "0"+month;
			}
			var year = defaultDate.getFullYear();
			var defVal = day+"/"+month+"/"+year;
			$( "#input_7_8" ).val(defVal);
		}
	});

	$("#input_7_2").change(function(){
		benefitImage = this.files;
	});

	$("#gform_submit_button_7").click(function(e){
		e.stopPropagation();
		e.preventDefault();
		var popup = $(this).parents(".popmake");

		var benefitTitle = $("#input_7_1").val();
		var benefitDesc = $("#input_7_10").val();
		
		var benefitArea = $("#input_7_9").val();
		var expDate = $("#input_7_8").val();
		if(!benefitTitle){
			if(!$("#field_7_1").hasClass("gfield_error")){
				$("#field_7_1").addClass("gfield_error");
			}
		}else{
			if($("#field_7_1").hasClass("gfield_error")){
				$("#field_7_1").removeClass("gfield_error");
			}
		}
		if(!benefitDesc){
			if(!$("#field_7_10").hasClass("gfield_error")){
				$("#field_7_10").addClass("gfield_error");
			}
		}else{
			if($("#field_7_10").hasClass("gfield_error")){
				$("#field_7_10").removeClass("gfield_error");
			}
		}
		if(!expDate){
			if(!$("#field_7_8").hasClass("gfield_error")){
				$("#field_7_8").addClass("gfield_error");
			}
		}else{
			if($("#field_7_8").hasClass("gfield_error")){
				$("#field_7_8").removeClass("gfield_error");
			}
		}
		if(!benefitTitle||!benefitDesc||!expDate){
			return false
		}
		var data = new FormData();
		data.append('benefitTitle', benefitTitle);
		data.append('benefitDesc', benefitDesc);
		data.append('benefitArea', benefitArea);
		data.append('expDate', expDate);
		if(benefitImage){
			$.each(benefitImage, function(key, value){
				data.append( key, value );
			});
		}else{
			data.append( 'benefitImage', '' );
		}
		$.ajax({
			url: ajaxurl+"?action=addAddbenefit",
			type: 'POST',
			cache: false,
			data: data,
        	dataType: 'json',
        	processData: false,
        	contentType: false,
        	success: function(respond, textStatus, jqXHR){
        		if(respond.success){
        			if(respond.main){
	        			window.location = window.location.href;
	        		}
        			popup.popmake('close');
        			$("#manage_business_benefits > div table tbody").append(respond.row);
        			$("#manage_business_benefits > div table tbody tr:nth-last-child(2)").children("td:first-child").children('a').click(deleteAddBenefit);

        			$("#manage_business_benefits > div table tbody tr:nth-last-child(2)").children("td:last-child").children(".benefitStatusAction").click(updateBenefitStatus);
        			$("#manage_business_benefits > div table tbody tr:nth-last-child(2)").children("td:last-child").children(".popmake-edit-additional-benefit").click(editPopup);
        			$("#manage_business_benefits > div table tbody tr:nth-last-child(2)").find(".ben-title").click(openDescription);
        		}
        		
        	}
		});
	});

	$(".benefitDelete").click(deleteAddBenefit);

	/*edit main benefit*/

	$("#gform_submit_button_9").click(function(e){
		var benefitId = $("#input_9_3").val();
		e.stopPropagation();
		e.preventDefault();
		var row = $("table.main-benefit tr:nth-child(3)");
		var benefitTitle = $("#input_9_1").val();
		var benefitDesc = $("#input_9_9").val();
		var data = new FormData();
		data.append('benefitId', benefitId);
		data.append('benefitTitle', benefitTitle);
		data.append('benefitDesc', benefitDesc);
		if(mainBenefitImage){
			$.each(mainBenefitImage, function(key, value){
				data.append( key, value );
			});
		}else{
			data.append( 'mainBenefitImage', '' );
		}
		$.ajax({
			url: ajaxurl+"?action=editMainBenefit",
			type: 'POST',
			cache: false,
			data: data,
        	dataType: 'json',
        	processData: false,
        	contentType: false,
        	success: function(respond, textStatus, jqXHR){
        			row.find("td:nth-child(3)").find(".ben-title").text(benefitTitle);
        			row.next().find(".desc").text(benefitDesc);
        			$("#popmake-412").popmake('close');
        	}
		});
	});

	$(".benefitStatusAction").click(updateBenefitStatus);

	$("#manage_business_benefits .ben-title").click(openDescription);

	$("#accordion-4 table .content .details").click(openDescription);

	/*add message*/

	/*$( "#input_8_15" ).datepicker({
		defaultDate: new Date(),
  		minDate: new Date(),
  		dateFormat: "dd/mm/yy",
	});

	$("#input_8_16").datepicker({
		defaultDate: +7,
		minDate: new Date(),
		dateFormat: "dd/mm/yy",
	});*/

	jQuery("#input_8_15").datetimepicker({
		"minDate": 0,
		format:'d/m/Y H:i:s',
	});
	$("#input_8_16").datetimepicker({
		"minDate": 0,
		format:'d/m/Y H:i:s',
	});

	$(".popmake-notification-clients-message-popup").click(clearMessagesPopup);
	var messageImg;

	$("#input_8_2").change(function(){
		window.messageImg = this.files;
	});

	$("#gform_submit_button_8").click(addNewMessage);

	$(".messageDelete").click(deleteMessage);

	$(".messageAction").click(changeMessageStatus);

	$(".businessTableButton.extDuration").click(editMessage);

// edit message popup
	var messRow;
	$("#gform_submit_button_15").on("click", function(e){
		if(jQuery("#popmake-1945").length){
			var popup = jQuery("#popmake-1945");
		}else{
			var popup = jQuery("#popmake-1947");
		}
		e.preventDefault();
		
		var endDate = $("#input_15_6").val();
		if(!endDate){
			return false;
		}
		var id = jQuery(this).attr("data-id");
		if(!id){
			return false;
		}
		$.ajax({
			url: ajaxurl+"?action=editMessage",
			type: 'POST',
			data: {
				id: id,
				endDate: endDate,
			},
        	dataType: 'json',
        	success: function(respond){
        		if(respond.success){
        			window.messRow.children("td:nth-child(5)").text(respond.newDate);
        			
        		}else{
        			alert("error");
        		}
        		popup.popmake('close');
        	}
		});

	});

	$(".delMessage").click(function(){

		var id = $(this).attr('rel');
		var mess = $(this).parents(".business_page_benefit");
		$.ajax({
			url: ajaxurl+"?action=deleteMessage",
			type: 'POST',
			data: {
				id: id,

			},
        	dataType: 'json',
        	success: function(respond){
        		if(respond.success){
        			mess.remove();
        			
        		}else{
        			alert("error");
        		}

        	}
		});

	});

	$(".soldOut").click(soldOut);
});

function editMessage(){
	if(jQuery("#popmake-1945").length){
		var popup = jQuery("#popmake-1945");
	}else{
		var popup = jQuery("#popmake-1947");
	}

	var button = jQuery(this);
	var row = button.parents("tr");
	window.messRow = row;
	var message = row.children("td:nth-child(3)").text();
	var matches = row.find("span.matches").text();
	var target = row.find("span.target").text();
	console.log(target);
	var meters = row.find("span.meters").text();
	var id = button.attr("rel");
	jQuery("#gform_submit_button_15").attr('data-id', id);

	if(!meters){
		jQuery("#field_15_4").hide();
	}else{
		jQuery("#input_15_4").val(meters);
	}
	var startDate = row.children("td:nth-child(4)").text().split(' ');
	startDate = startDate[0];
	var endtDate = row.children("td:nth-child(5)").text().split(' ');
	endtDate = endtDate[0]+' 00:00:00';
	var number = row.children("td:nth-child(7)").text();

	popup.find("textarea").val(message).attr("disabled", "disabled");
	popup.find("select").attr("disabled", "disabled");
	popup.find("input").each(function(){
		if(jQuery(this).attr("id") != 'input_15_6'&&jQuery(this).attr("id") != 'gform_submit_button_15'){
			jQuery(this).attr("disabled", "disabled");
		}
		if(jQuery(this).attr("type") == "radio"){
			if(jQuery(this).val() == target){
				jQuery(this).attr("checked", "checked");
			}
		}
	});

	jQuery("#input_15_7").val(number);
	jQuery("#input_15_6").val(endtDate).datetimepicker({
		"minDate": 0,
		format:'d/m/Y H:i:s',
	});
	jQuery("#input_15_5").val(startDate);

	popup.find("option").each(function(){
		if(jQuery(this).val() == matches){
			jQuery(this).attr("checked", "checked");
		}

	});
	

	popup.popmake("open");
}

function addNewMessage(e){
	e.preventDefault();
	var data = new FormData();
	var messageImg = window.messageImg;

	if(messageImg){
		jQuery.each(messageImg, function(key, value){
			data.append( key, value );
		});
	}else{
		data.append( 'messageImg', '' );
	}
	var details = jQuery("#input_8_1").val();
	var matches = jQuery("#input_8_3").val();
	var target = jQuery("#input_8_4 input:checked").val();
	var meters = '';
	if(target == "Clients near to the business"){
		meters = jQuery("#input_8_14").val();
	}
	var number = +jQuery("#gform_8 .message-number").text();
	var amount = +jQuery("#input_8_13").val();
	var startDate = jQuery("#input_8_15").val();
	var endDate = jQuery("#input_8_16").val();
	var popup = jQuery(this).parents(".popmake");
	if(!number){
		alert("You have not enough messages");
	}
	if(!details){
		if(!jQuery("#field_8_1").hasClass("gfield_error")){
			jQuery("#field_8_1").addClass("gfield_error");
		}
	}else{
		if(jQuery("#field_8_1").hasClass("gfield_error")){
			jQuery("#field_8_1").removeClass("gfield_error");
		}
	}
	if(!startDate){
		if(!jQuery("#field_8_15").hasClass("gfield_error")){
			jQuery("#field_8_15").addClass("gfield_error");
		}
	}else{
		if(jQuery("#field_8_15").hasClass("gfield_error")){
			jQuery("#field_8_15").removeClass("gfield_error");
		}
	}
	if(!endDate){
		if(!jQuery("#field_8_16").hasClass("gfield_error")){
			jQuery("#field_8_16").addClass("gfield_error");
		}
	}else{
		if(jQuery("#field_8_6").hasClass("gfield_error")){
			jQuery("#field_8_6").removeClass("gfield_error");
		}
	}
	if(!amount){
		if(!jQuery("#field_8_13").hasClass("gfield_error")){
			jQuery("#field_8_13").addClass("gfield_error");
		}
	}else{
		if(jQuery("#field_8_13").hasClass("gfield_error")){
			jQuery("#field_8_13").removeClass("gfield_error");
		}
	}
	if(!number||!details||!startDate||!endDate||!amount){
		return false;
	}

	if(amount > number||!number){
		//jQuery("#gform_8").submit();
                alert("You have not enough messages");
		return false;
	}
	
	data.append( 'details', details );
	data.append( 'matches', matches );
	data.append( 'target', target );
	data.append( 'meters', meters );
	data.append( 'amount', amount );
	data.append( 'startDate', startDate );
	data.append( 'endDate', endDate );
        if($("#popmake-2868").length){
            $("#popmake-2868").popmake("open");
        }else{
            $("#popmake-2915").popmake("open");
        }
        
	jQuery.ajax({
		url: ajaxurl+"?action=addMessage",
		type: 'POST',
		cache: false,
		data: data,
		dataType: 'json',
    	processData: false,
    	contentType: false,
	}).done(function(res) {
		if(res.success){
			popup.popmake("close");
                        if($("#popmake-2868").length){
                            $("#popmake-2868").popmake("close");
                        }else{
                            $("#popmake-2915").popmake("close");
                        }
			jQuery("#gform_8 .message-number").text(res.messageHave);
			jQuery("#accordion-4 tbody").append(res.row);
			jQuery("#accordion-4 tbody tr:nth-last-child(2)").find(".messageDelete").click(deleteMessage);
			jQuery("#accordion-4 tbody tr:nth-last-child(2)").find(".messageAction").click(changeMessageStatus);
			jQuery("#accordion-4 tbody tr:nth-last-child(2)").find(".extDuration").click(editMessage);
			jQuery("#accordion-4 tbody tr:nth-last-child(2)").find(".content .details").click(openDescription);
			jQuery("#accordion-4 tbody tr:nth-last-child(2)").find(".soldOut").click(soldOut);
                        jQuery("#input_8_3").prop("selectedIndex", "0");
                        //clearFileInputField("input_8_2");
                        document.getElementById("input_8_2").value = "";
		}
		if(!res.success){
			if(res.message){
				alert(res.message);
			}
			popup.popmake("close");
                        if($("#popmake-2868").length){
                            $("#popmake-2868").popmake("close");
                        }else{
                            $("#popmake-2915").popmake("close");
                        }
		}
	}).fail(function(res){
		console.log(res);
                popup.popmake("close");
                if($("#popmake-2868").length){
                    $("#popmake-2868").popmake("close");
                }else{
                    $("#popmake-2915").popmake("close");
                }
	})
				
}

function deleteMessage(){
	var row = jQuery(this).parents("tr");
	var dropDown = row.next();
	var id = jQuery(this).attr('rel');
	var res = confirm('are you sure?');
	if(!res){
		return false;
	}
	jQuery.ajax({
		url: ajaxurl+"?action=deleteMessage",
		type: 'POST',
		data: {
			id: id,
		},
		dataType: 'json',

	}).done(function(res) {
		if(res.success){
                    row.remove();
                    dropDown.remove();
                    if(res.newMessagesHave){
                        jQuery(".message-number").text(res.newMessagesHave);
                    }
		}
	}).fail(function(res){
		console.log(res);
	});
}

function changeMessageStatus(){
	var button = jQuery(this);
	var id = button.attr('rel');
	var row = jQuery(this).parents("tr");
	var currentStatus = row.children("td:nth-child(2)").text();
	var res = confirm('are you sure?');
	if(!res){
		return false;
	}
	jQuery.ajax({
		url: ajaxurl+"?action=changeMessageStatus",
		type: 'POST',
		cache: false,
		data: {
			id: id,
			currentStatus: currentStatus,
		},
		dataType: 'json',
	}).done(function(res) {
		if(res.success){
			row.children("td:nth-child(2)").text(res.newStatus);
			if(res.newStatus == 'Disabled'){
                row.removeClass("active");
				row.addClass("err");
			} else if(res.newStatus == 'Active'){
                row.removeClass("err");
                row.addClass("active");
            } /*else{
				row.removeClass("err");
			}*/
			button.text(res.newButton);
		}
	}).fail(function(res){
		console.log(res);
	})

}

function soldOut(e){
	e.preventDefault();
        var res = confirm('are you sure?');
	if(!res){
            return false;
	}
	var mesId = jQuery(this).attr('rel');
	var row = jQuery(this).parents("tr");
	var currentStatus = row.children("td:nth-child(2)").text();
        var statusButton = jQuery(this).siblings(".messageAction");
	jQuery.ajax({
		url: ajaxurl + "?action=soldOut",
		type: 'POST',
                dataType: 'json',
		data: {
			mesId: mesId,
			currentStatus: currentStatus,
		},
		success: function(data) {
			if(data.success == true) {
                                console.log(data.newStatus);
				row.removeClass("active");
				row.addClass("err");
				row.children("td:nth-child(2)").text(data.newStatus);
                                statusButton.text("Resume");
			}
		},
		error: function(data) {
			alert("FAILED");
		}
	});
}

function clearMessagesPopup(){
	jQuery("#input_8_1").val('');
	var timestamp = Date.now();
	
	var defaultDate = new Date ();
	var day = defaultDate.getDate();
	if(day<10){
		day = "0"+day;
	}
	var month = defaultDate.getMonth();
	month++;
	if(month<10){
		month = "0"+month;
	}
	var year = defaultDate.getFullYear();
	var defVal = day+"/"+month+"/"+year+" 00:00:00";
	jQuery( "#input_8_15" ).val(defVal);

	var validThruTime = timestamp+(86400000*7);
	validThruDate = new Date (validThruTime);
	day = validThruDate.getDate();
	if(day<10){
		day = "0"+day;
	}
	month = validThruDate.getMonth();
	month++;
	if(month<10){
		month = "0"+month;
	}
	year = validThruDate.getFullYear();
	var validThruVal = day+"/"+month+"/"+year+" 00:00:00";;
	jQuery( "#input_8_16" ).val(validThruVal);
	jQuery( "#input_8_14" ).val("1000");
	jQuery( "#input_8_13" ).val("");

}

function delBenefitFromFav(){
	var result = confirm("Are you sure you want to remove favorite?");
	if(result){
		var thisB = jQuery(this);
		var benefit_id = thisB.attr("data-benefit-id");
		var business_id = thisB.attr("data-business-id");
		var benefit = thisB.parents(".business_page_benefit");
		var del = jQuery(this).parents(".business_page_benefit");
		jQuery.ajax({
			url: ajaxurl + "?action=delete_benefit_fav",
			type: 'POST',
			data: { "business_id" : business_id, "benefit_id": benefit_id },
			success: function(data) {
				if(data.success == true) {
					alert("Benefit removed from favorites!");
					if(jQuery("body").hasClass("page-template-favorites")){
						del.remove();
					}
				}else{
					console.log("false");
				}
			}, error: function(data) {
				console.log("FAILED");
			}
		});
	}
}

function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function delete_additional_photo(){
	var rem = jQuery(this);
	var photoId = jQuery(this).attr("data-id");
	var bizId = jQuery(this).attr("data-biz");
	var photo = jQuery(this).parent().find("img");
	var preview = jQuery(this).parent().find("a");
	var del = jQuery(this);
	var button = jQuery(this).parent().children(".add_cover_photo_button");
	jQuery.ajax({
		url: ajaxurl,
		type: 'POST',
		data: { action: "deleteAdditionalPhoto", photoId : photoId, bizId: bizId },
		success: function(data) {
			if(data){
				if(button.text() != "Upload Photo #"+photoId){
					button.text("Upload Photo #"+photoId);
				}
				photo.remove();
				preview.remove();
				rem.remove();
				alert('image deleted');
			}
		},
		error: function(data) {
			console.log('failed');
		}
	});
}

function addBenefitTofav() {
	var thisB = jQuery(this);
	var benefit_id = thisB.attr("data-benefit-id");
	var business_id = thisB.attr("data-business-id");
	jQuery.ajax({
		url: ajaxurl + "?action=add_benefit_fav",
		type: 'POST',
		data: { business_id : business_id, benefit_id: benefit_id },
		success: function(data) {
			console.log(data);
			if(!data){
				return;
			}
			if(data.success == true) {
				alert("Benefit added to favorites!");
				if(thisB.hasClass("addFavBenefit")){
					thisB.removeClass("addFavBenefit")
					thisB.addClass("FavBenefit");
					thisB.unbind('click', addBenefitTofav);
				}
				
			} else {
				console.log("false");
			}
		}, error: function(data) {
			console.log("FAILED");
		}
	});
}

function addBusinessToFav(){
	var thisB = jQuery(this);
	var business_id = thisB.attr("rel");
	
	jQuery.ajax({
		url: ajaxurl + "?action=add_business_fav",
		type: 'POST',
		data: { "bid" : business_id },
		success: function(data) {
			if(data.success == true) {
				alert("Business added to favorites!");
				if(thisB.hasClass("addFavBusiness")){
					thisB.removeClass("addFavBusiness");
					thisB.addClass("FavBusiness");
					thisB.unbind("click", addBusinessToFav);
				}
			} else {
				console.log('false');
			}
		}, error: function(data) {
			console.log("FAILED");
		}
	});
}

function delBusinessFromFav(){
	var result = confirm("are you sure?");
	if(result){
		var thisB = jQuery(this);
		var business_id = thisB.attr("rel");

		var del = thisB.parents(".category-item");
		
		jQuery.ajax({
			url: ajaxurl + "?action=delete_business_fav",
			type: 'POST',
			data: { "bid" : business_id },
			success: function(data) {
				if(data.success == true) {
					alert("Business deleted from favorites!");
					if(jQuery("body").hasClass("page-template-favorites")){
						del.remove();
					}else{
						if(thisB.hasClass("delFavBusiness")){
							thisB.removeClass("delFavBusiness");
							thisB.addClass("addFavBusiness");
							thisB.unbind("click", delBusinessFromFav);
							thisB.click(addBusinessToFav);
						}
					}
				} else {
					console.log("error");
				}
			}, error: function(data) {
				console.log("FAILED");
			}
		});
	}
}

function deleteAddBenefit(e) {
	e.preventDefault();
	var benefitId = jQuery(this).attr("rel");
	var row = jQuery(this).parent().parent();
	var dropDown = row.next(".drop-down");
	jQuery.ajax({
		url: ajaxurl + "?action=delete_benefit",
		type: 'POST',
		data: { "benefitId": benefitId },
		success: function(data) {
			if(data.success == true) {
				alert("Benefit deleted!");
				row.remove();
				dropDown.remove();
			}
		},
		error: function(data) {
			alert("FAILED");
			
		}
	});
}

function updateBenefitStatus (e) {
	e.preventDefault();
	var currentStatus = jQuery(this).html();
	var benefitId = jQuery(this).attr("rel");
	var button = jQuery(this);
	var td = button.parent().siblings("td:nth-child(2)");
	var tr = button.parent().parent();
	var out;
	//var expDate = tr.children("td:nth-child(5)").text();

	jQuery.ajax({
		url: ajaxurl + "?action=update_benefit_status",
		type: 'POST',
		data: { "currentStatus": currentStatus, "benefitId": benefitId },
		success: function(data) {
			if(data.success == true) {
				alert("Benefit status updated!");
				if(tr.hasClass("err")){
					tr.removeClass("err");
					tr.addClass("active");
				}else{
					tr.removeClass("active");
					tr.addClass("err");
				}
				if(currentStatus == 'Resume'){
					button.html("Stop");
					td.html("Active");
					out = '<div class="note">Your business is visible.</div>';
				}
				if(currentStatus == 'Stop'){
					button.html("Resume");
					td.html("Disabled");
					out = '<div class="warning">Your business does not appear in the website and app. You must complete some details to appear.</div>';
				}
				if(!button.hasClass("additional")){
					jQuery(".notification").html(out);
					if(currentStatus == 'Resume'){
						jQuery("#a3 .accordion-section-title").removeClass("err");
					}else{
						jQuery("#a3 .accordion-section-title").addClass("err");
					}
				}
				if(data.newDate){
					tr.children("td:nth-child(5)").text(data.newDate);
				}
				
			}
		},
		error: function(data) {
			alert("FAILED");
		}
	});
}

function editPopup(e) {
	e.preventDefault();
	var benefitId = jQuery(this).attr("rel");
	var details = jQuery(this).parents("tr").find("td:nth-child(3)").children(".ben-title").text();
	var desc = jQuery(this).parents("tr").find("td:nth-child(3)").children(".ben-desc").text();
	var date = jQuery(this).parents("tr").find("td:nth-child(5)").text();
	var area = jQuery(this).parents("tr").find("td:nth-child(6)").text();
	if(area != 'All MCC Holders'){
		jQuery("#input_14_5 option:nth-child(2)").attr("selected", "selected");
	}else{
		jQuery("#input_14_5 option:nth-child(1)").attr("selected", "selected");
	}

	window.row = jQuery(this).parents("tr");
	jQuery("#input_14_1").val(details);
	jQuery("#input_14_7").val(desc);
	jQuery("#input_14_4").val(date);
	jQuery("#field_14_6 input").val(benefitId);
	jQuery("#field_14_6 input").val(benefitId);
}

function openDescription(){
	var dropDown = jQuery(this).parent().parent().next(".drop-down");
	if(!dropDown.hasClass("show")){
		dropDown.addClass("show");
		dropDown.show();
	}else{
		dropDown.removeClass("show");
		dropDown.hide();
	}
}

function clearFileInputField(Id) {
  document.getElementById(Id).innerHTML = document.getElementById(Id).innerHTML;
}

