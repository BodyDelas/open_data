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

$_SESSION['theme'] = (isset($_SESSION['theme']))?$_SESSION['theme']:0;

if (isset($_POST['change_theme'])) {
  $_SESSION['theme'] = !$_SESSION['theme'];
}
$theme = $_SESSION['theme'];

// echo $_SESSION['user_id'].'<br>';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/7784/7784436.png"
    />
    <title>Maps</title>
    <link rel="stylesheet" href="<?php echo ($theme==0)?'/CSS/style.css':'/CSS/style-dark.css'?>" />
  </head>
  <body>
    <header>
      <b>PETS WALKING</b>
      <p>Мы поможем найти подходящую площадку рядом с вами</p>
    </header>
    <main>
    <div class="container">
      <div class="map" id="map"></div>
      <div class="buttons">
        <label>Есть освещение<input type="checkbox" class="has-lightning" value="yes" /></label>
        <label>Размер площадки</label>
        <select name="area" id="areaSelect">
          <option value="base">Все площадки</option>
          <option value="small">Маленькая</option>
          <option value="medium">Средняя</option>
          <option value="large">Большая</option>
        </select>
        <label>На площадке должно быть:</label>
        <select name="elements" id="elementsSelect">
          <option value="base">Не выбрано</option>
          <option value="barrier">Барьер</option>
          <option value="urn">Урна</option>
          <option value="chute">Горка</option>
        </select>
        <h2 class="places__title">Подходящие площадки</h2>
        <div class="places">
        </div>
      </div>
        <div class="accountIcon">
          <form action="<?php echo ($user_id == null)?'auth.php':'index.php'?>" class="account" method="post">
            <img class="iconAuth" src="<?=$icon_path?>" alt="Иконка входа">
            <?php echo ($user_id != null)?'<input type="hidden" name="out">':''?>
            <button class="account_btn" name="account"><?=$auth_btn_text?></button>
          </form>
            <a href="services.php"><button class="account_btn">Услуги / Магазин</button></a>
            <?php echo (($user_id == null)?'':'<a href="like.php"><button class="account_btn">'.$my_area.'</button></a>');?>
            <a href="index.php"><button class="account_btn" style="background-color:#808080; border-radius:15px">Основная страница</button></a>
              <form method="post">
                  <button name="change_theme" class="theme">Сменить тему</button>
              </form>
        </div>
    </div>
  </main>
    <script
      src="https://api-maps.yandex.ru/2.1/?apikey=5eca22fe-0a55-452a-8d5e-e64f4be09851&lang=ru_RU"
      type="text/javascript"
    ></script>
    <script src="JS/script.js"></script>

    
    <?php
      include "connect_db.php";

      echo ($user_id != null) ? "
      <script>
        user_id = ".$user_id."
      </script>
      " : '';

      $result = mysqli_query($connection, "
      select *
      from open_data
      ");

      $row = mysqli_fetch_assoc($result);
      $data = "['".$row['location']."', '".$row['area']."', '".$row['elements']."', '".$row['lightning']."', '".$row['geodata_center']."', '".$row['id']."']";
      
      while ($row = mysqli_fetch_assoc($result)) {
        $data .= ", ['".$row['location']."', '".$row['area']."', '".$row['elements']."', '".$row['lightning']."', '".$row['geodata_center']."', '".$row['id']."']";
      }
      
      

      echo "
      <script>
        getCenters([".$data."]);
        ymaps.ready(init);
      </script>
      ";
    ?>
      
    

    <!-- <script>
      act();
      console.log(111);
    </script> -->

    <footer>
      <span class="footer">Информация в приложении взята с открытых данных Москвы: https://data.mos.ru</span>
    </footer>
  </body>
</html>
