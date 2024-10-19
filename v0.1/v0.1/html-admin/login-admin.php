
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="shortcut icon" type="image/png" href="../assets/images/logos/LOGO.png" />
	<link rel="stylesheet" href="../assets/css/styles.min.css" />
        <link rel="stylesheet" href="../assets/css/background.css" />
        <link rel="stylesheet" href="../assets/css/boton.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9f8b2b376f.js" crossorigin="anonymous"></script>
</head>
<body>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
	<div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
		<div class="d-flex align-items-center justify-content-center w-100">
		  	<div class="row justify-content-center w-100">
				<div class="col-md-8 col-lg-6 col-xxl-3">
			  		<div class="card mb-0" style="flex-direction: column;">
						<div class="card-body" style="background-color: black; opacity: 0.8;">
							<h2 style="color:azure; flex-direction: column; display: flex; text-align: center;">Login Admin</h2>
							<div style="display: flex; margin-top: 1rem;">
							<a href="../html-usuarios/login-user.html" class="links">Login User</a>
							</div><br>
							<form action="../php-admin/login-admin.php" method="post" class="links">
								<label for="email">Email:</label>
								<input type="email" id="email" name="email" style="margin-bottom: .4rem;"required>
								<label for="psw">Contraseña:</label>
								<input type="password" id="psw" name="psw" required>
								<input type="submit" class="btn-submit" value="Iniciar sesión">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
</body>
</html>
