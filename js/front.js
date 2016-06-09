jQuery(document).ready(function($) {
    /**/
    $("#gform_submit_button_16").click(function(e){
        
        e.preventDefault();
        var email = $("#input_16_1").val();
        if(!email){
            $("#input_16_1").parents("li").addClass("gfield_error");
            return false;
        }
        $.ajax({
          url: ajaxurl+"?action=resendVerificationLink",
            type: 'POST',
            data: {
              email: email
            },
            dataType: 'json',
            success: function(data){
                if(data.success){
                    $("#gform_16").submit();
                    setTimeout(function(){
                        window.location = window.location.href;
                    }, 2000);
                }else{
                    alert(data.message)
                }
            } 
       }); 
    });
    /**/
    $(".header-display-name").click(function(){
        $(".header-menu").slideToggle();
    })
    $(document).click(function(event) {
        if ($(event.target).closest(".header-menu").length||$(event.target).closest(".header-display-name").length){
            return;
        }
        $(".header-menu").slideUp();
        event.stopPropagation();
    });
    /**/
});


