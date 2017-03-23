/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {  
    $(".alert").alert();

    $("[data-hide]").on("click", function(){
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
    
    $(".x-ing").click(function(e){
        if($(".x-ing:checked").length>5){
            //alert('You cannot choose more than 5 ingredients');
            $("#alertTooManyIngredients").show();
            e.preventDefault();
        }
    });
});    
