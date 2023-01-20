<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход/Регистрация</title>
    <link rel="stylesheet" href="/CSS/auth.css" />
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/1687/1687357.png"
    />
</head>
<body>
    <header>
      <span>ZOO WALKING</span>
    </header>
    <main>
        <form action="" method="post">
            <div class="auth">
                <div>
                <h1 title="Форма входа на сайт">Вход</h1>
                    <div class="group">
                     <label for="login"></label>
                        <input type="text" placeholder="Логин" id="login" name="Login" />
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
                    <button class="btn_auth" type="submit">Войти</button>
                 </div>
                </div>
                </form>
                <form action="register.php" method="post">
                <div class="text">
                    <span class="text1">У вас ещё нет аккаунта?</span>
                    <div class="group">
                    <button class="btn_reg" type="submit">Зарегестрироваться</button>
                 </div>
                </div>
            <div>
        <form>   
    </main>
    <footer>
      <span></span>
    </footer>
</body>
</html>