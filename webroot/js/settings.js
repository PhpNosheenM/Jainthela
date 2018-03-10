var site_settings = '';

$(document).ready(function(){
/*
    $.get("assets/settings.html",function(data){        
        $("body").append($(data));
    });*/
    
    /* Default settings */
    var theme_settings = {
        st_head_fixed: 0,
        st_sb_fixed: 1,
        st_sb_scroll: 1,
        st_sb_right: 0,
        st_sb_custom: 0,
        st_sb_toggled: 0,
        st_layout_boxed: 0
    };
    /* End Default settings */
    
    set_settings(theme_settings,false);    
    
    
    /* End open/hide settings */
});

function set_settings(theme_settings,option){
    
   
    /* End states for options */
    
    /* Call resize window */
    $(window).resize();
    /* End call resize window */
}

function set_settings_checkbox(name,value){
    
   
}