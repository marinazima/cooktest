/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function disableSelectedIngredients(){
    $('.x-ing:checked').prop('disabled', true);
}

$(document).ready(function () {  
    disableSelectedIngredients();
    
    $('#b-add-to-dish').click(function(){
        var toadd = $('.x-ing:checked:enabled').map(function() {return {id: $(this).val(), label: $(this).parent('label').text()} }).get();
        
        var $ing = [];
        for(var i=0; i<toadd.length; i++){
            var $e = $(".x-dish-ing:hidden").clone(true);
            $e.attr('data-ing_id', toadd[i].id);
            $e.find('.x-label').text(toadd[i].label);
            $e.css('display', 'inline-block');
            $ing.push($e);
        }
        $('.x-dish-ingredients').append($ing);
        
        disableSelectedIngredients();
        $('#modIngredients').modal('hide');
    });
    
    $('.x-dish-ing').on('click', '.x-delete', function(){
        var $e = $(this).parents('.x-dish-ing');
        
        $e.remove();

        $('.x-ing[value="'+$e.data('ing_id')+'"]').prop('checked', false).prop('disabled',false);
    });
    
    $('.x-dish-ing').on('click', '.x-state', function(){
        var $e = $(this).parents('.x-dish-ing');       
        var state = $e.data('state');
        var box = {0: 'dish-ing-default', 1:'dish-ing-success'};
        var icon = {0: 'glyphicon-eye-close', 1:'glyphicon-eye-open'};
        //class
        $e.removeClass(box[state]);
        $e.addClass(box[+!state]);
        //eye icon
        $e.find('.x-state span').removeClass(icon[state]);
        $e.find('.x-state span').addClass(icon[+!state]);
        //state
        $e.data('state', (state==1 ? 0 : 1) );
    });
    
    $('#modIngredients').on('hidden.bs.modal', function (e) {
        $(".x-ing:checked:enabled").prop('checked', false);
    });
    
    $('#create-form').on('beforeSubmit', function(e) {  
        var di = [];
        $('.x-dish-ing:visible').each(function(){
            di.push({id: $(this).data('id'), ingredient_id: $(this).data('ing_id'), isactive: $(this).data('state')});
        });
        
        //console.log(JSON.stringify(di));
        $('#dishform-dish_ingredients').val(JSON.stringify(di));
    }).on('submit', function(e){
        //e.preventDefault();
    });     
});    
