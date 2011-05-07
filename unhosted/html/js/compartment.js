$().ready(function() {
	var scope = document.location.searchParameter('scope');
	var compartment = '';
	scope = scope.replace(/\/(.*)/, function(match, c) {
		compartment = c;
	});

	if(!compartment) return;

	var params = {
		user_name: document.location.searchParameter('user_name'),
		scope: document.location.searchParameter('scope'),
		sharedCompartment: compartment
	};

	var infoBox = $('.compartmentInfo');

	$.post('/unhosted_ajax/getCompartmentInfo.php', params, function(data) {
		if(!data.exists) {
			infoBox.append($('<p>').text('This compartment needs to be created.'));
		} else {
			infoBox.append($('<p>').text('This compartment was created by "' + data.creator + '".'));
			if(data.usages.length == 0) {
				infoBox.append($('<p>').text('No clients have access to it right now.'));
			} else {
				infoBox.append($('<p>').text('These clients have access to it right now:'));

				var ul = $('<ul>');
				console.dir(data.usages);
				$.each(data.usages, function(key, scopeName) {
					ul.append($('<li>').text(scopeName));
				});
				infoBox.append(ul);
			}
		}
	}, 'json');
});