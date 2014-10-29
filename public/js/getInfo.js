$(document).ready(function (e) {
	$(".loading-modal").fadeIn(500);
	$(".loading-modal").html("Updating...");
	$.ajax({
		url : baseURL + '/updateRecentMatches/' + Ravenstorm.summonerId,
		type: 'GET',
		datatype: 'json'
	}).done(function (data) {
		if (data) {
			var message;
			if (data==1)
			{
				$(".loading-modal").html('Not enough data');
			}
			else if (data==2)
			{
				$(".loading-modal").html('Data was refreshed recently, please try again later');
			}
			else if (data==3)
			{
				$(".loading-modal").html('There was an error retrieving data from Riot');
			}
			else if (data==13)
			{
				$(".loading-modal").html('User not found');
			}
			else 
			{
				//update Chart data
				RavenstormChart.destroy();
				RavenstormChart = new Chart(ctx).Line(data.chartData, options);
				//Update recent matches
				var newrows;
				var table = $("#recent-matches-table");
			    table.find("tr:gt(0)").remove();
			    for(i=0; i < data.stats.length; i++){
			        newrows += "<tr><td class='" + data.stats[i].win + "'>" + data.stats[i].champion + "</td><td>" + data.stats[i].kills + "</td><td>" + data.stats[i].deaths + "</td><td>" + data.stats[i].assists + "</td><td>" + data.stats[i].ravenscore + "</td></tr>";
			    }
			    table.append(newrows);
				//Update averages
				var newrows = "";
			    var table = $("#averages-table");
			    table.find("tr:gt(0)").remove();
			    for(var field in data.fields){
			        newrows += "<tr><td>" + data.fields[field] + "</td><td>" + data.averages.total[field] + "</td><td>" + data.averages.recent[field] + "</td><td>" + (data.averages.total[field]-data.averages.recent[field]) + "</td></tr>";
			    }
			    table.append(newrows);
				$(".loading-modal").html('Refreshed data');
				//$(document).foundation('#recent-matches-table', 'reflow')
			}
			setTimeout(function() {
				$(".loading-modal").fadeOut(500);
				}, 1000
			);
		}
		else {
			$(".loading-modal").html('No data was returned');
			setTimeout(function() {
				$(".loading-modal").fadeOut(500);
				}, 1000
			);
		}
	}).fail(function (data) {
		$(".loading-modal").html('A server error was encountered');
		setTimeout(function() {
				$(".loading-modal").fadeOut(500);
				}, 1000
			);
	});
});