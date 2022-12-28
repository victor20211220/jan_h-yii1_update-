"use strict";

$(document).ready(function(){
   $(".badge").each(function(){
       var num = parseInt($(this).html());
       if(num === 0) {
           $(this).hide();
       }
   });

    $("#delete_user, #block_user, #unblock_user").click(function(){
        var id = $(this).attr("id");
        return confirm(translation[id]);
    });
});