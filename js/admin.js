jQuery(document).ready(function($) {

	/* change country of country-manager  */
	$(".button.country-managment").click(function(e){
		e.preventDefault();
		var data = {};
		$(".coutry-select").each(function(){
			var id = $(this).attr("data-user");
			var val = $(this).val();
			data[id] = val;
		});
		var json = JSON.stringify(data);
		$.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: "manageCountry",
				data: json
			}
		}).done(function(res){
			location.reload();
		});
	});

	/* change city of city-manager  */

	$(".button.city-managment").click(function(e){
		e.preventDefault();
		var data = {};
		var cities = {};
		$(".city-select").each(function(){
			var id = $(this).attr("data-user");
			var val = $(this).val();
			if(!data['user_'+id]){
				data['user_'+id] = [];
			}
			if(val != '0'){
				data['user_'+id].push(val);
			}
		});
		var json = JSON.stringify(data);
		$.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: "manageCity",
				data: json
			}
		}).done(function(res){
			location.reload(true);
		});
	});

	/* select category benefit */
	$("#select-category").change(function(){
		var cat = $( this ).val();
		var search = window.location.search;
		var loc = window.location.href;

		if(search.indexOf('cat') === -1){
			window.location = loc+'&cat='+cat;
		}else{
			var arr = search.split('&');
			var newSearch = '';
			for(var i=0; i<arr.length; i++){
				if(arr[i].indexOf('cat') === -1){
					newSearch += arr[i]+'&';
				}else{
					newSearch +='cat='+cat;
				}
			}
			window.location.search = newSearch;
		}



		/*$.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: "selectBenefitsByCat",
				cat: cat,
				city: city
			},
			success: function(res){
				$(".table-benefit").html(res);
				$(".select-caps").change(changeCaps);
				$(".star").each(function(){
					if($(this).hasClass("promo")){
						$(this).click(removePromo);
					}else{
						$(this).click(addPromo);
					}
				});
			}
		});*/
	});
	$(".star").each(function(){
		if($(this).hasClass("promo")){
			$(this).click(removePromo);
		}else{
			$(this).click(addPromo);
		}
	});
	/* add more city to city manager */

	$(".button.add-city").click(function(){

		var row = $(this).parents("tr");
		var select = row.find(".city-select");
		if(select.length > 1){
			select = $(select[0]);
		}
		select.clone().appendTo(select.parent());
	});	


});

/*promotion businesses*/
function addPromo(){
	var button = jQuery(this);
	var bizId = button.attr("data-biz");
//	var area = (button.hasClass("main-promo"))?'mainPromo':'categoryPromo';
	var city = button.parent().attr("class");
	var area = (jQuery(this).attr("data-cat"))?jQuery(this).attr("data-cat"):'mainPromo';
	console.log(area);
	jQuery.ajax({
		url: ajaxurl,
		method: 'post',
		data: {
			action: 'addPromoBusiness',
			bizId: bizId,
			area: area,
			city: city
		},
		success: function(res){
			if(res.success){
				button.addClass("promo");
				button.unbind();
				button.click(removePromo);
			}else{
				if(res.message){
					alert(res.message);
				}else{
					console.log("error");
				}
			}
		}
	});
}

function removePromo(){
	var button = jQuery(this);
	var bizId = button.attr("data-biz");
	var area = (jQuery(this).attr("data-cat"))?jQuery(this).attr("data-cat"):'mainPromo';
	var city = button.parent().attr("class");
	jQuery.ajax({
		url: ajaxurl,
		method: 'post',
		data: {
			action: 'removePromoBusiness',
			bizId: bizId,
			area: area,
			city: city
		},
		success: function(res){
			if(res.success){
				button.removeClass("promo");
				button.unbind();
				button.click(addPromo);
			}else{
				console.log('error');
			}
		}
	});
}

function changeCaps(){
	var city = jQuery(this).val();
	jQuery(this).parents("tr").find(".star").parent().removeAttr("class").addClass(city);

	var buttonMain = jQuery(this).parents("tr").find(".star.main-promo");
	var buttonCateg = jQuery(this).parents("tr").find(".star.category-promo");
	buttonMain
	var bizId = buttonMain.attr("data-biz");
	console.log(bizId);
	jQuery.ajax({
		url: ajaxurl,
		method: 'post',
		data: {
			action: 'checkPromoBusiness',
			bizId: bizId,
			city: city
		},
		success: function(res){
			if(res.success){
				if(res.main){
					if(!buttonMain.hasClass("promo")){
						buttonMain.addClass("promo");
						buttonMain.unbind();
						buttonMain.click(removePromo);
					}
				}else{
					if(buttonMain.hasClass("promo")){
						buttonMain.removeClass("promo");
						buttonMain.unbind();
						buttonMain.click(addPromo);
					}
				}
				if(res.category){
					if(!buttonCateg.hasClass("promo")){
						buttonCateg.addClass("promo");
						buttonCateg.unbind();
						buttonCateg.click(removePromo);
					}
				}else{
					if(buttonCateg.hasClass("promo")){
						buttonCateg.removeClass("promo");
						buttonCateg.unbind();
						buttonCateg.click(addPromo);
					}
				}
			}else{
				if(buttonMain.hasClass("promo")){
					buttonMain.removeClass("promo");
					buttonMain.unbind();
					buttonMain.click(addPromo);
				}
				if(buttonCateg.hasClass("promo")){
					buttonCateg.removeClass("promo");
					buttonCateg.unbind();
					buttonCateg.click(addPromo);
				}
			}
		}
	});
}