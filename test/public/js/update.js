var current_page = $(location).attr('pathname');
var userID = current_page.split("/")[4];

$(document).on("click", function() {
	doCall(updatePage);
});

function doCall(callback) {
	$.ajax({
		url : current_page,
		type : 'PATCH',
		data : userID,
	}).done(function(data, status, xhr) {
		callback(data);
	}).fail(function(xhr, status, error) {
		alert(error);
	})
};

function updatePage(data) {
	document.getElementById('info').innerHTML = data;
}

/*
 *
 * TODO;
 * make the updatePage function change data on the page, and not just put some new stuff there...
 *
 */