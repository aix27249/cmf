function login() {
	var login = $("#login").val();
	var pass = $("#password").val();

	$.post('/includes/ajax_login.php', {'uid': login, 'pass': pass}, function(data) {
		alert(data);
	});

	return true;

}
