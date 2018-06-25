// On fixe les div grâce à jquery
var fixed = $('.makefix').offset().top;
$(window).scroll(function() {
    var cursorScroll = $(window).scrollTop();
    if(cursorScroll >= fixed) {
        $('.makefix').css({position: 'fixed', left: '0', top: '0'});
    }
    else{
        $('.makefix').css({position: 'static'});
    }
});

function showSearchPanel() {
    document.getElementById("search_panel").style = "right:0;";
}

function hideSearchPanel() {
    document.getElementById("search_panel").style = "right:-400px;";
}

// function updateSearchPanel() {} dans user js
// fonction pour actualiser les messages non lus et état en ligne dans user js aussi