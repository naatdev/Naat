<?php
if(!isset($_SESSION)){die("alert('impossible');");}
?>
function updateSearchPanel(search_str) {
    document.getElementById("search_results").innerHTML = '<p style="text-align:center;"><img src="<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/icons/ajax-loader.gif" width="15px" /> &nbsp;&nbsp; chargement des résultats ...</p>';
    $.get('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/search.php?search_str=' + search_str, function(data) {
        $('#search_results').html(data);
      });
}

$(document).ready(function () {
    changeTitle();
    var refreshId_ = setInterval(function () {
    var body = document.getElementsByTagName('body')[0];
    var script = document.createElement('script');
    script.type= 'text/javascript';
    script.src= "<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/msgCount.php?code";
    body.appendChild(script);
    changeTitle();
    }, 10000);
    $.ajaxSetup({
        cache: false
    });
    $("#counterSpanMsg").load("<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/msgCount.php?nbr");
    var refreshId_ = setInterval(function () {
        $("#counterSpanMsg").load("<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/msgCount.php?nbr");
    }, 10000);
    $.ajaxSetup({
        cache: false
    });
    var refreshId_ = setInterval(function () {
        $.ajax({
            url : '<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/updateOnlineState.php',
            type : 'GET',
            dataType : 'html'
        });
    }, 15000);
});

var urlMessageCount = "<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/msgCount.php?nbr";

$.get(urlMessageCount).done(function( data ) {
    localStorage.setItem("nbrMessages", data);
});

var messagePop = setInterval(function () {
    $.get(urlMessageCount).done(function( data ) {
        localStorage.setItem("nbrMessages_", data);
    });
    var Messages_ = localStorage.getItem("nbrMessages_");
    if(parseInt(Messages_) != parseInt(localStorage.getItem("nbrMessages")) && Messages_ != 0) {
        console.log("ok play sound");
        var audio = new Audio('<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/template/sounds/pop.mp3');
        audio.play();
    }
    localStorage.setItem("nbrMessages", localStorage.getItem("nbrMessages_"));
}, 10000);

function comment(user, post_id) {
    document.getElementById("comment_panel").style = "right:0;";
    document.getElementById("comment_panel_iframe").src = "<?php echo $_SESSION['NAAT_ORIGIN_DIRECTORY']; ?>/inc/comment.php?user=" + user + "&post_id=" + post_id;
}