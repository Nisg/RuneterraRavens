var spinner = new Spinner();

$body = $('body');
$(document).on({
	ajaxStart : function() {
		$('body').addClass("loading");
		spinner.spin();
		document.getElementById('modal').appendChild(spinner.el);
	},
	ajaxStop : function() {
		$('body').removeClass("loading");
		spinner.stop();
	}
});
