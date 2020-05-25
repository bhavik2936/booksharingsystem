<?php
    session_start();
?>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="login_css.css" rel="stylesheet" id="bootstrap-css">
    
</head>
<!------ Include the above in your HEAD tag ---------->

<body>
    <div id="login" >
        <!-- <h3 class="text-center text-white pt-5">Login form</h3> -->
        <div class="container" >
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-dark">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-dark" >Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-dark">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <center><input type="submit" name="submit" class="btn btn-dark btn-md" value="submit" onclick="check(this.form)" ></center>
                            </div>
                        </form>
                        <script language="javascript">
                                function check(form)/*function to check userid & password*/
                                {
                                 /*the following code checkes whether the entered userid and password are matching*/
                                 if(form.username.value == "user" && form.password.value == "123")
                                  {  
                                     <?php
                                    $_SESSION['name'] = "user";
                                    // header("Location: https://booksharingsystem.000webhostapp.com/admin/secondpage.php");
                                    ?>
                                    // echo $_SESSION['name'];
                                        // if($_SESSION['name']=="user")
                                        //     echo "hello";
                                    window.open('secondpage.php')/*opens the target page while Id & password matches*/
                                  }
                                 else
                                 {
                                   alert("Error Password or Username is incorrect")/*displays error message*/
                                  }
                                }
                         </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>