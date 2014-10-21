function doCall(playerid, callback) {
	$.ajax({
		url : current_page,
		type : 'PATCH',
		data : playerid,
	}).done(function(data, status, xhr) {
		callback(data);
	}).fail(function(xhr, status, error) {
		alert("An error occured");
	})

};

$(document).on("click", function() {
	doCall(current_page.split("/")[6], updatePage);
});

function updatePage(data) {
	document.getElementById('info').innerHTML = data;
}

/*
 * 
 * TODO;
 * make the updatePage function change data on the page, and not just put some new stuff there...
 * 
 */