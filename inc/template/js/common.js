function dispSomeHelp(textDisp) {
    document.getElementById('top_help').style = '';
    document.getElementById('top_help_disp').innerHTML = textDisp;
}

function dispLoadingIcon(infos = '') {
    setTimeout(function(){
        document.getElementById('loading_icon').style = '';
    }, 200);
    setTimeout(function(){
        document.getElementById('toolong').style = 'opacity:1;';
    }, 4500);
    setTimeout(function(){
        document.getElementById('loading_info').innerHTML = infos;
    }, 300);
}