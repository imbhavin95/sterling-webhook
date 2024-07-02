<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Login - Webhook </title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;600&display=swap" rel="stylesheet">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="assets/css/bootstrap.css" rel="stylesheet"/>
        <style>
            body{
                font-family: 'IBM Plex Sans', sans-serif;
                background: #3b4447;
            }
            .login-container{
                margin-top: 8%;
                margin-bottom: 5%;
            }
            .login-form-2{
                padding: 2%;
                background: #fff;
                border-radius: 3%;
                box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
            }
            .login-form-2 h3{
                text-align: center;
                color: #333;
            }
            .login-container form{
                padding: 5%;
            }
            .font-size-13{
                font-size: 13px;
            }

        </style>
    </head>
    <body>
        <div class="container login-container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 login-form-2">
                    <h3>Webhook Login</h3>
                    <form name="loginForm" id="loginForm" action="{{ route('loginProcess') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" required name="email" id="email" />
                            <span class="error font-size-13 text-danger" id="emailError"></span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" required name="password" id="password" />
                            <span class="error font-size-13 text-danger" id="passwordError"></span>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary w-100" id="submitLogin">
                                <span class="spinner-grow spinner-grow-sm" id="spinnerLogin" style="display: none" aria-hidden="true"></span>
                                &nbsp;Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script type="text/javascript">
            function isEmail(emailAdress){
                let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (emailAdress.match(regex))
                    return true;
                else
                    return false;
            }

            $(document).on('click', '#submitLogin', function (e){
                let email = $("#email").val();
                let password = $("#password").val();
                if(email === ''){
                    $("#emailError").html('Email is required');
                }else if(!isEmail(email)) {
                    $("#emailError").html('Please enter valid email');
                }else{
                    $("#emailError").html('');
                }
                if(password === ''){
                    $("#passwordError").html('Password is required');
                }else{
                    $("#passwordError").html('');
                }
                if(email !== '' && isEmail(email) && password !== ''){
                    $(this).addClass('disabled');
                    $('#spinnerLogin').show();
                }else{
                    e.preventDefault();
                }
            });

        </script>
    </body>
</html>
