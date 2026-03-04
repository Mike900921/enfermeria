<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - CDTI</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logoSena.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Paleta de colores:
        Verde Oscuro (SENA): #26A743 (Principal)
        Verde Lima Brillante: #A7F920 (Degradado/Efecto)
        */

        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: url("{{ asset('img/fondomm.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            background: #fff;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #26A743, #A7F920);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 40px;
            text-align: center;
        }

        .login-left h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .login-left p {
            font-size: 1.1rem;
            font-weight: 300;
            margin-bottom: 25px;
        }

        .login-left img {
            max-width: 80%;
            opacity: 0.95;
        }

        .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffffff;
        }

        @keyframes pulse-border {
            0% {
                border-color: #26A743;
                box-shadow: 0 0 10px rgba(38, 167, 67, 0.3);
            }

            50% {
                border-color: #A7F920;
                box-shadow: 0 0 20px rgba(167, 249, 32, 0.7);
            }

            100% {
                border-color: #26A743;
                box-shadow: 0 0 10px rgba(38, 167, 67, 0.3);
            }
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            text-align: center;
            border: 3px solid #26A743;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(38, 167, 67, 0.3);
            background: #fff;
            animation: pulse-border 3s infinite alternate;
        }

        .login-card img.logo-sena {
            width: 80px;
            height: 80px;
            margin-bottom: 25px;
        }

        .login-card h3 {
            font-weight: 700;
            margin-bottom: 8px;
            color: #26A743;
            font-size: 1.8rem;
        }

        .login-card p {
            margin-bottom: 35px;
            color: #777;
            font-size: 1rem;
        }

        /* --- AJUSTES PARA ESTILO DE ICONO INTEGRADO Y COLORES SENA --- */

        .input-group {
            position: relative;
            /* Aplicamos el radio de borde al contenedor */
            border-radius: 10px;
            overflow: hidden; 
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        /* Efecto de foco para todo el grupo (borde verde SENA) */
        .input-group:focus-within {
            border-color: #A7F920; /* Borde más brillante en foco */
            box-shadow: 0 0 0 0.25rem rgba(38, 167, 67, 0.25);
        }

        .form-control {
            border-radius: 0;
            border: none;
            padding: 12px 15px;
            font-size: 1rem;
            height: 50px;
        }

        .form-control:focus {
            border-color: transparent;
            box-shadow: none;
            z-index: 3;
        }
        
        .input-group-text.custom-icon {
            /* Estilo del área del icono */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px; 
            background-color: #f8f9fa; /* Fondo gris claro (puedes cambiarlo a blanco si quieres) */
            border: none;
            color: #26A743; /* Color SENA en estado normal */
            font-size: 1.2rem;
            
            /* Borde de división */
            border-right: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        /* Cambiar el color del icono y fondo en foco (verde lima) */
        .input-group:focus-within .custom-icon {
            color: #fff; /* Color blanco para el ícono en foco */
            background-color: #26A743; /* Fondo Verde SENA en foco */
            border-right-color: #26A743; /* Borde de división verde SENA */
        }

        .mb-3.input-group {
            margin-bottom: 20px !important;
        }
        /* --- FIN DE AJUSTES PARA ESTILO DE ICONO INTEGRADO Y COLORES SENA --- */


        .btn-custom {
            background: linear-gradient(to right, #26A743, #A7F920);
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
            color: #fff;
            margin-top: 15px;
            letter-spacing: 0.5px;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #1E8E3E, #A7F920);
            box-shadow: 0 8px 25px rgba(38, 167, 67, 0.5);
            color: #fff;
        }

        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }

            .login-left {
                padding: 30px;
                order: -1;
                border-radius: 20px 20px 0 0;
            }

            .login-left img {
                max-width: 50%;
                margin-top: 5px;
            }

            .login-right {
                padding: 30px;
                border-radius: 0 0 20px 20px;
            }

            .login-card {
                padding: 20px;
                border: 3px solid #26A743;
                box-shadow: 0 8px 25px rgba(38, 167, 67, 0.3);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <h2>¡Bienvenido al CDTI!</h2>
            <p>Seguridad, innovación y control en cada ingreso.</p>
            <img src="{{ asset('img/seguridadd.png') }}" alt="Seguridad CDTI">
        </div>

        <div class="login-right">
            <div class="login-card">
                <img src="{{ asset('img/LogoSena.png') }}" alt="Logo SENA" class="logo-sena">

                <h3>Acceso al Sistema</h3>
                <p>Ingresa tus credenciales para continuar.</p>

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="mb-3 input-group">
                        <span class="input-group-text custom-icon" id="email-addon"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Correo Electrónico"
                            aria-label="Correo Electrónico" aria-describedby="email-addon"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <div class="mb-3 input-group">
                        <span class="input-group-text custom-icon" id="password-addon"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña"
                            aria-label="Contraseña" aria-describedby="password-addon" required>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <button type="submit" class="btn btn-custom">Ingresar <i class="bi bi-box-arrow-in-right"></i></button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
