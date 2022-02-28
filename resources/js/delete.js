$(document).ready(function(){
    $('.btn-delete').click(function(){
        return confirm($(".btn-delete").attr("data-confirm"));    
    }); 
});
