<?php

session_start();

$icon_path = '../imgs/icon_auth.png';
$auth_btn_text = 'Вход / Регистрация';
$user_id = null;

if (isset($_POST['out'])) {
  // echo 'out = '.$_POST['out'];
  unset($_SESSION['user_id']);
}

if (isset($_SESSION['user_id'])) {
  // echo 'uid = '.$_SESSION['user_id'];
  $icon_path = '../imgs/icon_acc.png';
  $auth_btn_text = 'Выход';
  $user_id = $_SESSION['user_id'];
}

// echo $_SESSION['user_id'].'<br>';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/7784/7784436.png"
    />
    <link rel="stylesheet" href="/CSS/market.css" />
</head>
<body>
    <header>
      <span>ZOO WALKING</span>
      <p class="text">В данном разделе можно воспользоваться нашими услугами или приобрести нужный вам товар</p>
    </header>
    <nav class="nav">
    <a class="link" href="services.php"><div class="nav1">Услуги</div></a>
        <div class="nav2" style="background-color:#b2b2b2; border-radius:15px">Товары</div>
    </nav>
    <div class="container-wrap">
        <div class="left"></div>
        <div class="container">
            <div class="by">
                <p class="nomer">Для заказа и уточнения товара, обращайтесь по номеру: 8 (987) 415-16-63</p>
            </div>
            <div class="block">
                <div class="block1">
                    <img class="img1" src="/imgs/corm.png" alt="">
                    <div class="block1-1">
                        <b>Корм для собак</b>
                        <p>Цена: 199 рублей</p>
                    </div>
                </div>
                <div class="block1">
                    <img class="img1" src="/imgs/miska.png" alt="">
                    <div class="block1-1">
                        <b>Миска для собак</b>
                        <p>Цена: 499 рублей</p>
                    </div>
                </div>
                <div class="block1">
                    <img class="img1" src="/imgs/osh.png" alt="">
                    <div class="block1-1">
                        <b>Ошейник для собак</b>
                        <p>Цена: 399 рублей</p>
                    </div>
                </div>
                <div class="block1">
                    <img class="img1" src="/imgs/povod.png" alt="">
                    <div class="block1-1">
                        <b>Поводок для собак</b>
                        <p>Цена: 899 рублей</p>
                    </div>
                </div>
                <div class="block1">
                    <img class="img1" src="/imgs/vitamin.png" alt="">
                    <div class="block1-1">
                        <b>Витамины для собак</b>
                        <p>Цена: 1199 рублей</p>
                    </div>
                </div>
                <div class="block1">
                    <img class="img1" src="/imgs/perenos.png" alt="">
                    <div class="block1-1">
                        <b>Переноска для собак</b>
                        <p>Цена: 1999 рублей</p>
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
                    <a href="index.php"><button class="account_btn">Главная страница</button></a>
                </div>
            </div>
    </div>
    <footer>
      <span></span>
    </footer>
</body>
</html>