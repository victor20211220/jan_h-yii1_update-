"use strict";

$(document).ready(function(){
    $('li.disabled').click(function(){
        return false;
    });

    $("table.index-table").each(function(){
        var td = $(this).find("tr:last td");
        if(td.length == 0) {
            $(this).find("tr:last").remove();
        }
    });
});