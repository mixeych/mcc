jQuery(document).ready(function(){
    console.log("city");
    if($("body").hasClass("page-id-7")){
       setTimeout(function(){
          $("#popmake-4295").popmake('open'); 
       }, 300);
       
    }else{
        $("#popmake-4297").popmake('open'); 
    }
});


