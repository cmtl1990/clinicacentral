$(function(){
	if ($('.message').text()!='') showMessage($('.message').text());
	$('table tbody td.phide a, a[rel=tooltip], span[rel=tooltip]').tooltip();
});
function showMessage(msg){
	if ($('body').find('.message').length==0){
		$('body').append('<div class="message">'+msg+'</div>');
	}else $('body .message').text(msg);
	var w = $('body .message').width()*-1;
	$('body .message').css('margin-left',(w/2)+'px');
	$('.message').fadeIn('slow');
	setTimeout(function(){
		$('.message').fadeOut('slow');
	}, 5000);
}
function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}
function trim(x){
	return x.replace(/^\s+|\s+$/gm,'');
}