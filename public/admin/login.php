<?php
include("config.php");

## Login form submit
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
  
    

    # Sql query to login
    
    $sql = "SELECT * FROM logins where username = '$username' AND password = '$password'";
    
    $result = $conn->query($sql);
    if ($result->num_rows) {
        $_SESSION['is_user_loggedin'] = true;
        $_SESSION['user_data'] = mysqli_fetch_assoc(($result));
        echo "<script>window.location.href = 'index.php'</script>";        
    } else {
        
        $_SESSION['error'] = "Invalid login info";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="/site/admin/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/site/admin/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action="login.php">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" name="submit" class="btn btn-success">Login</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Angel High-Tech Polymers!</h1>
                  <p>© Angel Hi_tech Polymers, All Right Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        
      </div>
    </div>
  </body>
</html>
