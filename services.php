<?php

session_start();

$icon_path = '../imgs/icon_auth.png';
$auth_btn_text = 'Вход / Регистрация';
$user_id = null;
$my_area = 'Мои маршруты';

if (isset($_POST['out'])) {
  // echo 'out = '.$_POST['out'];
  unset($_SESSION['user_id']);
}

if (isset($_SESSION['user_id'])) {
  // echo 'uid = '.$_SESSION['user_id'];
  $icon_path = '../imgs/icon_acc.png';
  $auth_btn_text = 'Выход';
  $my_area = 'Мои маршруты';
  $user_id = $_SESSION['user_id'];
}

// echo $_SESSION['user_id'].'<br>';

$page = 'services';

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
    <title>Услуги</title>
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/7784/7784436.png"
    />
    <link rel="stylesheet" href="<?php echo ($theme==0)?'/CSS/services.css':'/CSS/services-dark.css'?>" />
</head>
<body>
    <header>
      <b>PETS WALKING</b>
      <p class="text">В данном разделе можно воспользоваться нашими услугами или приобрести нужный вам товар</p>
    </header>
    <nav class="nav">
        <div class="nav1" style="background-color:#b2b2b2; border-radius:15px">Услуги</div>
        <a class="link" href="market.php"><div class="nav2">Товары</div></a>
    </nav>
    
    <div class="container-wrap">
        <div class="left"></div>
        <div class="container">
            <div class="by">
                <p class="nomer">Для заказа и уточнения услуг, обращайтесь по номеру: 8 (987) 415-16-63</p>
            </div>
            <div class="block">
                <div class="block1">
                    
                    <img class="img1" src="/imgs/go.png" alt="">
                    <div class="block1-1">
                        <b>Выгул вашех питомцев в Москве</b>
                        <div class="placement1">
                            <p>Час - 300 рублей</p>
                            <p>Пол часа - 200 рублей</p>
                        </div>
                    </div>
                </div>
                <div class="block1">
                    <img class="img1" src="/imgs/go2.png" alt="">
                    <div class="block1-1">
                        <b>Доставка корма</b>
                        <p>Привезём корм в любую точку Москвы</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="accountIcon">
                <form action="<?php echo ($user_id == null)?'auth.php':'index.php'?>" class="account" method="post">
                    <img class="iconAuth" src="<?=$icon_path?>" alt="Иконка входа">
                    <?php echo ($user_id != null)?'<input type="hidden" name="out">':''?>
                    <button class="account_btn" name="account"><?=$auth_btn_text?></button>
                </form>
                <a href="market.php"><button class="account_btn" style="background-color:#808080; border-radius:15px">Услуги / Магазин</button></a>
                <?php echo (($user_id == null)?'':'<a href="like.php"><button class="account_btn">'.$my_area.'</button></a>');?>
                    <a href="index.php"><button class="account_btn">Основная страница</button></a>
                <form method="post">
                    <button name="change_theme" class="theme">Сменить тему</button>
                </form>
            </div>
        </div>
    </div>
    <footer>
      <span>Информация в приложении взята с открытых данных Москвы: https://data.mos.ru</span>
    </footer>
</body>
</html>