<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('app/views/default/link.html'); ?>

<head>
    <title>Rentco</title>

    <?php require_once('app/views/default/head.html'); ?>
    <?php require_once('app/views/default/script_h.html'); ?>
    <style>
        .may {
            -webkit-border-radius: 10px 10px;
            /* Safari  */
            -moz-border-radius: 10px 10px;
            /* Firefox */
        }

        #may {
            padding: 1px 77px;
            background: #FF0;
            box-shadow: 8px 9px 4px #a5a5a5;
            border-radius: 37px;
            color: #fff;
        }

        .bg-gradient-primary {
            background-color: #ffffff !important;
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(10%, #4e73df), to(#f5f6f9)) !important;
            background-image: linear-gradient(180deg, #002daf 10%, #002daf 100%) !important;
            background-size: cover !important;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#checador').attr('href', "index.php?action=checador&token=" + $("#token").val());
            $('#comedor').attr('href', "index.php?action=comedor&token=" + $("#token").val());
            $("#may").hide();

            $("#usr, #pass").keyup(function(event) {
                var tecla = event.keyCode;
                if (tecla == 13) {
                    Login();
                }
            });

            $("#btnLogin").click(function(e) {
                //Alert("boton login");
                Login();
            });

            $('#pass').keypress(function(e) {
                kc = e.keyCode ? e.keyCode : e.which;
                sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
                if (((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk)) {
                    $("#may").show();
                } else {
                    $("#may").hide();
                }
            });

        });

        function Login() {
            var jsonDatos = {
                "usr": $("#usr").val(),
                "pass": $("#pass").val(),
                "accion": "LOGIN"
            };

            $.ajax({
                data: jsonDatos,
                type: "post",
                dataType: "json",
                url: "app/views/default/modules/login/m.login_procesa.php",
                beforeSend: function() {},
                success: function(datos) {
                    if (datos.valido === true) {
                        Alert("Bienvenido", "", "success");
                        document.location = datos.msg;
                    } else
                        Alert("Error acceso", datos.msg, "error");
                }

            });
        }

        function srnPc() {
            var d = new Date();
            var dateint = d.getTime();
            var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            var total = letters.length;
            var keyTemp = "";
            for (var i = 0; i < 6; i++) {
                keyTemp += letters[parseInt((Math.random() * (total - 1) + 1))];
            }
            keyTemp += dateint;
            return keyTemp;
        }

        function saveSrnPc() {
            localStorage.setItem("srnPc", srnPc());
            //    saveToken();
            //    localStorage.removeItem("srnPc");
        }

        function Alert(tit, msg, iconn) {
            swal({
                title: tit,
                text: msg,
                icon: iconn,
            })
        }
    </script>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-5 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="row d-flex justify-content-center">
                                <div class="col-12">
                                    <div class="card" style="border-radius: 1rem;">
                                        <div class="row g-0">
                                            <div class="col-md-6 col-lg-5 d-none d-md-block" style="left: 5%;">
                                                <img src="app/views/default/img/rentco.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; width: 100%;height: 100%;">
                                            </div>
                                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                                <div class="card-body p-4 p-lg-5 text-black">

                                                    <form>
                                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Iniciar sesión en su cuenta</h5>

                                                        <div class="form-outline mb-4">
                                                            <input type="text" id="usr" name="usr" class="form-control form-control-lg">
                                                            <label class="form-label" for="usr" style="margin-left: 0px;">Correo</label>
                                                            <div class="form-notch">
                                                                <div class="form-notch-leading" style="width: 9px;"></div>
                                                                <div class="form-notch-middle" style="width: 88.8px;"></div>
                                                                <div class="form-notch-trailing"></div>
                                                            </div>
                                                        </div>

                                                        <div class="form-outline mb-4">
                                                            <input type="password" id="pass" name="pass" class="form-control form-control-lg">
                                                            <label class="form-label" for="pass" style="margin-left: 0px;">Contraseña</label>
                                                            <div class="form-notch">
                                                                <div class="form-notch-leading" style="width: 9px;"></div>
                                                                <div class="form-notch-middle" style="width: 64px;"></div>
                                                                <div class="form-notch-trailing"></div>
                                                            </div>
                                                        </div>

                                                        <div class="pt-1 mb-4">
                                                            <input type="button" id="btnLogin" class="btn btn-dark btn-lg btn-block" name="btnLogin" value="Login" style="color:#000;">
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" name="token" id="token">
        </div>
        <div class="navbar-default navbar-fixed-bottom">
            <div class="text-center footer" style="color:#000;">Copyright © <script>
                    document.write(new Date().getFullYear());
                </script> Angel Contreras. All Right Reserved.</div>
        </div>
    </div>
    <?php require_once('app/views/default/script_f.html'); ?>
    <script>
        //localStorage.removeItem("srnPc");
        if (localStorage.getItem("srnPc") === null) {
            localStorage.setItem("srnPc", srnPc());
            //saveSrnPc();
        } else {
            $("#token").val(localStorage.getItem("srnPc"));
        }
    </script>
</body>

</html>