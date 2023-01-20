<?php

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
                where login = ".$login."
            ");

            session_start();

            while ($row = mysqli_fetch_assoc($res)) {
                $_SESSION['user_id'] = $row['id'];
            }
            
            //echo $_SESSION['user_id'].'<br>';

            header('Location: index.php');
            // ob_end_flush();
        } else {
            $error = '<div class="error">Такой логин уже существует</div>';
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
      href="https://cdn-icons-png.flaticon.com/512/1687/1687357.png"
    />
    <link rel="stylesheet" href="/CSS/register.css" />
</head>
<body>
    <header>
      <span>ZOO WALKING</span>
    </header>
    <main>
    <form method="post">
    <div class="auth">
      <h1 title="Форма регистрации на сайте">Регистрация</h1>
      <div class="group">
        <label for="login"></label>
        <input type="text" placeholder="Логин" id="login" name="login" />
      </div>
      <div class="group">
        <label for="password"></label>
        <input
          type="password"
          placeholder="Пароль"
          id="password"
          name="password"
        />
      </div>
      <div class="group">
        <label for="password"></label>
        <input
          type="password"
          placeholder="Повторите пароль"
          id="password"
          name="password"
        />
      </div>
      <div class="group">
        <input type="checkbox" id="rememberMe" name="rememberMe" />
        <span>Запомнить меня</span>
      </div>
      <div class="group">
        <button type="submit" name="reg">Зарегестрироваться</button>
      </div>
      </div>
    </form>
    <?=$error?>
    </main>
    <footer>
      <span></span>
    </footer>
    
</body>
</html>