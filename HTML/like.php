<?php

include "connect_db.php";

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
  // echo 'user_id = '.$user_id.'<br>';
}

// echo $_SESSION['user_id'].'<br>';
// foreach($_POST as $k => $v) echo $k.' => "'.$v.'"<br>';

if (isset($_POST['like'])) {
  $area_id = $_POST['area_id'];
  $query = "
    insert into my_area (user_id, area_id)
    values
    (".$user_id.", ".$area_id.")
  ";
  // echo $query;
  mysqli_query($connection, $query);
}

if (isset($_POST['delete'])) {
  mysqli_query($connection,"
  delete from my_area
  where area_id = ".$_POST['delete']."
  ");
}


$res = mysqli_query($connection,"
  select * from open_data
  where id in (
    select area_id from my_area
    where user_id = ".$user_id."
  )
");

$areas_html = '';

while ($row = mysqli_fetch_assoc($res)) {
  $areas_html .= '
  <div class="block">
   '.$row['location'].'<br><br>
  <form action="like.php" method="post">
  <input type="hidden" name="delete" value="'.$row['id'].'">
  <button type="submite" class="buttonDelete">Удалить</button>
  </form>
  </div>
  ';
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
    <title>Услуги</title>
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/7784/7784436.png"
    />
    <link rel="stylesheet" href="<?php echo ($theme==0)?'/CSS/like.css':'/CSS/like-dark.css'?>" />
</head>
<body>
    <header>
      <b>PETS WALKING</b>
      <p class="text">В данном разделе вы можете увидеть понравившиеся вам площадки</p>
    </header>
    <div class="container-wrap">
        <div class="left"></div>
        <div class="container">
          <?=$areas_html?>
        </div>
        <div class="right">
            <div class="accountIcon">
                <form action="<?php echo ($user_id == null)?'auth.php':'index.php'?>" class="account" method="post">
                    <img class="iconAuth" src="<?=$icon_path?>" alt="Иконка входа">
                    <?php echo ($user_id != null)?'<input type="hidden" name="out">':''?>
                    <button class="account_btn" name="account"><?=$auth_btn_text?></button>
                </form>
                <a href="services.php"><button class="account_btn">Услуги / Магазин</button></a>
                <?php echo (($user_id == null)?'':'<a href="like.php"><button class="account_btn" style="background-color:#909090; border-radius:15px">'.$my_area.'</button></a>');?>
                    <a href="index.php"><button class="account_btn">Основная страница</button></a>
                <form method="post">
                    <button name="change_theme" class="theme">Сменить тему</button>
                </form>
            </div>
        </div>
    </div>  
    <footer>
      <span></span>
    </footer>
</body>
</html>