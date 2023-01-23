<?php

session_start();

$error = '';
include "connect_db.php";

if (isset($_POST['enter'])) {
    // echo 1;
    $login = trim($_POST['login']);
    $hash = md5($_POST['password']);

    // echo $login.' '.$hash;

    $response = mysqli_query($connection, "
        select * from user
    ");

    while ($row = mysqli_fetch_assoc($response)) {
        // echo $hash.' '.$row['hash'].' '.$login.' '.$row['login'].'<br>';
        if ($hash == $row['hash'] && $login == $row['login']) {
            // echo 11;
            $_SESSION['user_id'] = $row['id'];

            header('Location: index.php');

        }
    }

    $error = '<div class="error group">Неверный логин или пароль</div>';
}

$_SESSION['theme'] = (isset($_SESSION['theme']))?$_SESSION['theme']:0;

if (isset($_POST['change_theme'])) {
  $_SESSION['theme'] = !$_SESSION['theme'];
}
$theme = $_SESSION['theme'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход/Регистрация</title>
    <link rel="stylesheet" href="<?php echo ($theme==0)?'/CSS/auth.css':'/CSS/auth-dark.css'?>" />
    <!-- <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/1687/1687357.png"
    /> -->
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/7784/7784436.png"
    />
</head>
<body>
    <header>
      <b>PETS WALKING</b>
      <p>Здесь вы можете войти в свой аккаунт</p>
    </header>
    <main>
    
        
        <div class="auth">
            <form method="post">
                <h1 title="Форма входа на сайт">Вход</h1>
                    <div class="group">
                        <label for="login"></label>
                        <input type="text" placeholder="Логин" id="login" name="login" />
                    </div>
                <div class="group">
                    <label for="password"></label>
                    <input type="password" placeholder="Пароль" id="password" name="password"/>
                </div>
                <div class="group">
                    <input type="checkbox" id="rememberMe" name="rememberMe" />
                    <span>Запомнить меня</span>
                </div>
                <div class="group">
                    <button class="btn_auth" type="submit" name="enter">Войти</button>
                </div>
                <?=$error?>
            </form>
            <form action="register.php" method="post">
                <div class="text">
                    <span class="text1">У вас ещё нет аккаунта?</span>
                    <div class="group">
                        <button class="btn_reg" type="submit">Зарегистрироваться</button>
                    </div>
                </div>
            </form>
            <a href="index.php" ><button class="exit" type="submit">На главную</button></a>
         </div>
    </main>
    <footer>
        <span class="footer">Информация в приложении взята с открытых данных Москвы: https://data.mos.ru</span>
    </footer>
</body>
</html>