<?php
session_start();

include 'connect_db.php';

$error = '';

if (isset($_POST['reg'])) {

    $login = $_POST['login'];
    $login = trim($login);
    $password = $_POST['password'];

    if ($login == null) {
        $error = '<div class="error">Заполните необходимые поля</div>';
    } else {
        $query = "
            select login from user
            where login = '".$login."'
        ";
        $response = mysqli_query($connection, $query);
        
        if (mysqli_num_rows($response) == 0) {
            $query = "
                insert into user (login, hash)
                values
                ('".$login."', '".md5($password)."')
            ";
            mysqli_query($connection, $query);

            $res = mysqli_query($connection, "
                select id from user
                where login = '".$login."'
            ");

            $row = @mysqli_fetch_assoc($res);
            
            //echo 'row[id] = '.$row['id'];
            $_SESSION['user_id'] = $row['id'];
            

            header('Location: index.php');

        } else {
            $error = '<div class="error">Заполните необходимые поля</div>';
        }
    }

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/7784/7784436.png"
    />
    <link rel="stylesheet" href="/CSS/register.css" />
</head>
<body>
    <header>
      <b>PETS WALKING</b>
      <p>Здесь вы можете зарегестрировать свой аккаунт</p>
    </header>
    <main>
    <div class="auth">
        <form method="post">
        <h1 title="Форма регистрации на сайте">Регистрация</h1>
            <div class="group">
                <label for="login"></label>
                <input type="text" placeholder="Логин" name="login" />
            </div>
            <div class="group">
                <label for="password"></label>
                <input type="password" placeholder="Пароль" name="password"/>
            </div>
            <div class="group">
                <label for="password"></label>
                <input type="password" placeholder="Повторите пароль" name="password"/>
            </div>
            <div class="group">
                <input type="checkbox" id="rememberMe" name="rememberMe" />
                <span>Запомнить меня</span>
            </div>
            <div class="group">
                <button type="submit" name="reg">Зарегистрироваться</button>
                <span><?=$error?></span>
            </div>
            </form>
            <a href="index.php" ><button class="exit" type="submit">На главную</button></a>
    </div>
    </main>
    <footer>
      <span></span>
    </footer>
    
</body>
</html>