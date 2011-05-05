
$().ready(function() {
	var userId = document.location.searchParameter('user_name');

	if(userId) {
		var userName = userId.match(/^[^@]+/);
		$('#user_name').val(userName);
	}
});

$('#register').live('submit', function(event) {
	event.preventDefault();

	errorMessage();

	if($('#pwd').val() != $('#pwd2').val()) {
		errorMessage('Please enter the same password twice.');
		return false;
	}

	if(!$('#pwd').val()) {
		errorMessage('Please enter the same password twice.');
		return false;
	}

	if($('#user_name').val() == '') {
		errorMessage('Please choose a user nick');
		return false;
	}

	var params = {
		pwd: $('#pwd').val(),
		user_name: $('#user_name').val(),
		scope: document.location.searchParameter('scope')
	}

	$('#pwd,#pwd2').val('');

	$.post('unhosted_ajax/register.php', params, function(data) {
		if(data.error) {
			$('#error').text(data.errorMessage).show();
		} else {
			console.dir(data);
			var redirectUri = document.location.searchParameter('redirect_uri');
			if(redirectUri) {
				if(data.token) {
					redirectUri += (redirectUri.match(/\?/) ? '&' : '?') + 'token=' + encodeURIComponent(data.token);
				}
				$('#success>p.redirect').show().find('a').attr('href', redirectUri);
			}
			$('#success').show();
			$('#register').hide();
		}
	}, 'json');

	return false;
});
