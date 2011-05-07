
$('#allow').live('submit', function(event) {
	event.preventDefault();

	var scope = document.location.searchParameter('scope');
	var compartment = '';
	scope = scope.replace(/\/(.*)/, function(match, c) {
		compartment = c;
	});

	var params = {
		pwd: $('#pwd').val(),
		user_name: document.location.searchParameter('user_name'),
		scope: scope,
		sharedCompartment: compartment
	}

	errorMessage();
	$('#pwd').val('');

	$.post('authenticate.php', params, function(data) {
		if(data.error) {
			errorMessage(data.errorMessage);
		} else {
			var redirectUri = document.location.searchParameter('redirect_uri');
			redirectUri += (redirectUri.match(/\?/) ? '&' : '?') + 'token=' + encodeURIComponent(data.token);
			document.location.href = redirectUri;
		}
	}, 'json');

	return false;
});
