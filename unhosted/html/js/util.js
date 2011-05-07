document.location.searchParameter = function(parameterName) {
	var re = new RegExp("[?&]" + parameterName + "[=]([^&]*)");
	var matches = document.location.search.match(re);
	if(!matches) return undefined;

	return unescape(matches[1]);
}

document.location.searchParameter = function(parameterName) {
	var re = new RegExp("[?&]" + parameterName + "[=]([^&]*)");
	var matches = document.location.search.match(re);
	if(!matches) return undefined;

	return unescape(matches[1]);
}
$().ready(function() {
	var scope = document.location.searchParameter('scope');
	var compartment = '';
	scope = scope.replace(/\/(.*)/, function(match, c) {
		compartment = c;
	});

	$.each(['client_id', 'user_name', 'redirect_uri'], function(i, key) {
		var value = document.location.searchParameter(key);
		$('.' + key).text(value);
	});

	$('.scope').text(scope);
	$('.compartment').text(compartment);

	$('.unhostedSettings_domain').text(unhostedSettings.domain);

	$('.accessCompartment').toggle(!!compartment);
});

function errorMessage(message) {
	if(message) {
		$('#error').text(message).show();
	} else {
		$('#error').hide();
	}
}