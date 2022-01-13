<?php
    session_start();
    include_once('config.php');

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];


        $sql = mysqli_query($db_con,"SELECT * FROM tbluser WHERE username = '$username' AND password = '$password'");


        $row = mysqli_fetch_array($sql);

        if($row){
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            if(!empty($_POST['remember'])){
                setcookie('user_login', $_POST['username'], time() + (10 * 365 * 26 * 60 * 60));
                setcookie('user_password' ,$_POST['password'], time() + (10 * 365 * 26 * 60 * 60));
            }else{
                if(isset($_COOKIE['user_login'])){
                    setcookie('user_login','');

                    if(isset($_COOKIE['user_password'])){
                        setcookie('user_password','');
                    }
                }
            }
            header("location:welcome.php");
        }else{
            $msg = "Invalid login";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login Page</title>
</head>
<body>
    <div class="container ">
        <h1 class="display-4 mt-5">Login Page</h1>
        <hr>
        <form method="post">
            <?php if(isset($msg)) { ?> 
        <div class="alert alert-danger" role="alert">
            <?php echo $msg; ?>
        </div>
        <?php } ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" value="<?php if(isset($_COOKIE['user_login'])) { echo $_COOKIE['user_login'] ;} ?>" id="username" name="username" aria-describedby="username">
        
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" value="<?php if(isset($_COOKIE['user_password'])){echo $_COOKIE['user_password'] ;}?>">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox"name="remember"<?php if(isset($_COOKIE['user_login'])){?> checked <?php } ?> class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
</div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>