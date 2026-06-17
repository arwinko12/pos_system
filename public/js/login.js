
 function showpassword() {
		let user_password = document.getElementById('user_password');

	if (user_password.type === 'password') {
		user_password.type = 'text';
	}else{
		user_password.type = 'password';
	}

	$('#icons').toggleClass('fas fa-eye-slash fas fa-eye');
}
