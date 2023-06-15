function saveSearchResult(){
    console.log(my_ajax_object.ajax_url);
    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {action: "get_data"},
        success: function(msg){
            console.log(msg);
        }
    });
    
}