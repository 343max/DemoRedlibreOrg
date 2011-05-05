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
	$.each(['client_id', 'user_name', 'scope', 'redirect_uri', 'compartment'], function(i, key) {
		var value = document.location.searchParameter(key);
		$('.' + key).text(value);
	});

	$('.unhostedSettings_domain').text(unhostedSettings.domain);

	$('.accessCompartment').toggle(!!document.location.searchParameter('compartment'));
});

function errorMessage(message) {
	if(message) {
		$('#error').text(message).show();
	} else {
		$('#error').hide();
	}
}