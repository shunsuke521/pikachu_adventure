<?php

  ini_set('log_errors','on');
  ini_set('error_log','php.log');
  session_start();

  //自分ポケモンデータ
  $myMonster = array(
    'name' => 'ピカチュウ',
    'hp' => 300,
    'img' => 'img/pika.png'
  );

  //相手ポケモン格納用
  $enemies = array();

  $enemies[] = array(
    'count' => 1,
    'name' => 'ニョロボン',
    'hp' => 300,
    'img' => 'img/bon.png',
    'attack_max' => 50,
    'attack_min' => 10,
    'bg' => 'img/bg_sea.jpg',
    'type' => 1,
    'attack_name' => 'ハイドロポンプ'
  );

  $enemies[] = array(
    'count' => 2,
    'name' => 'サイドン',
    'hp' => 350,
    'img' => 'img/don.png',
    'attack_max' => 60,
    'attack_min' => 10,
    'bg' => 'img/bg_mount.png',
    'type' => 2,
    'attack_name' => 'いわなだれ'
  );

  $enemies[] = array(
    'count' => 3,
    'name' => 'ナッシー',
    'hp' => 380,
    'img' => 'img/nashi.png',
    'attack_max' => 60,
    'attack_min' => 20,
    'bg' => 'img/bg_grass.jpg',
    'type' => 3,
    'attack_name' => 'タネばくだん'
  );

  $enemies[] = array(
    'count' => 4,
    'name' => 'リザードン',
    'hp' => 400,
    'img' => 'img/riza.png',
    'attack_max' => 60,
    'attack_min' => 30,
    'bg' => 'img/bg_mars.jpg',
    'type' => 4,
    'attack_name' => 'かえんほうしゃ'
  );

  $enemies[] = array(
    'count' => 5,
    'name' => 'ミュウツー',
    'hp' => 500,
    'img' => 'img/myu.png',
    'attack_max' => 70,
    'attack_min' => 50,
    'bg' => 'img/bg_cosmo.jpg',
    'type' => 5,
    'attack_name' => 'サイコキネシス'
  );

  function createFirstEnemy(){
    global $enemies;
    $viewEnemies = $enemies[0];
    $_SESSION['count'] = $viewEnemies['count'];
    $_SESSION['name'] = $viewEnemies['name'];
    $_SESSION['hp'] = $viewEnemies['hp'];
    $_SESSION['hp_base'] = $viewEnemies['hp'];
    $_SESSION['img'] = $viewEnemies['img'];
    $_SESSION['attack_max'] = $viewEnemies['attack_max'];
    $_SESSION['attack_min'] = $viewEnemies['attack_min'];
    $_SESSION['attack_name'] = $viewEnemies['attack_name'];
    $_SESSION['bg'] = $viewEnemies['bg'];
    $_SESSION['type'] = $viewEnemies['type'];
    $_SESSION['hitpoint'] = $viewEnemies['hp'];
    error_log('$_SESSIONの中身：'.print_r($_SESSION,true));
  }

  function createNextEnemy(){
    global $enemies;
    $enemyCount = $_SESSION['count'];
    unset($viewEnemies);
    $viewEnemies = $enemies[$enemyCount];
    unset($_SESSION['count']);
    unset($_SESSION['name']);
    unset($_SESSION['hp']);
    unset($_SESSION['img']);
    unset($_SESSION['bg']);
    unset($_SESSION['attack_max']);
    unset($_SESSION['attack_min']);
    unset($_SESSION['attack_name']);
    unset($_SESSION['type']);
    $_SESSION['count'] = $viewEnemies['count'];
    $_SESSION['name'] = $viewEnemies['name'];
    $_SESSION['hp'] = $viewEnemies['hp'];
    $_SESSION['hp_base'] = $viewEnemies['hp'];
    $_SESSION['hitpoint'] = $viewEnemies['hp'];
    $_SESSION['img'] = $viewEnemies['img'];
    $_SESSION['attack_max'] = $viewEnemies['attack_max'];
    $_SESSION['attack_min'] = $viewEnemies['attack_min'];
    $_SESSION['attack_name'] = $viewEnemies['attack_name'];
    $_SESSION['bg'] = $viewEnemies['bg'];
    $_SESSION['type'] = $viewEnemies['type'];
    error_log('$_SESSIONの中身：'.print_r($_SESSION,true));
  }

  function init(){
    global $myMonster;
    createFirstEnemy();
    $_SESSION['history'] = $_SESSION['name'].'が現れた！<br>';
    $_SESSION['myhp'] = $myMonster['hp'];
    $_SESSION['myhitpoint'] = $myMonster['hp'];
  }

  //post送信されていた場合
  if (!empty($_POST)) {
    $attack1Flg = (!empty($_POST['attack1'])) ? 1 : 0;
    $attack2Flg = (!empty($_POST['attack2'])) ? 1 : 0;
    $attack3Flg = (!empty($_POST['attack3'])) ? 1 : 0;
    $attack4Flg = (!empty($_POST['attack4'])) ? 1 : 0;
    $defenseFlg = (!empty($_POST['defense'])) ? true : false;
    $recoverFlg = (!empty($_POST['recover'])) ? 1 : 0;
    $startFlg = (!empty($_POST['start'])) ? true : false;
    $nextFlg = (!empty($_POST['next'])) ? true : false;
    $resetFlg = (!empty($_POST['reset'])) ? true : false;
    if (!empty($_SESSION['hp'])) {
      $_SESSION['hp'] = $_SESSION['hitpoint'];
    }
    if (!empty($_SESSION['myhp'])) {
      $_SESSION['myhp'] = $_SESSION['myhitpoint'];
    }


    if ($startFlg) {
      init();
    }elseif ($attack1Flg) {//10まんボルト
      $_SESSION['history'] = 'ピカチュウの10まんボルト！<br>';

      //ランダムで相手に攻撃を与える
      $attackPoint = mt_rand(50,60);
      if ($_SESSION['type'] == 1 || $_SESSION['type'] == 4) {
        $attackPoint *= 2;
        $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
      }elseif($_SESSION['type'] == 2) {
        $_SESSION['history'] .= '相手の'.$_SESSION['name'].'には効果がないようだ...<br>';
      }elseif ($_SESSION['type'] == 3) {
        $attackPoint /= 2;
        $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      }else {
        $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      }

      //攻撃力が相手のHP以上だったら
      if ($_SESSION['hp'] <= $attackPoint) {
        $_SESSION['hitpoint'] = 0;
        $_SESSION['history'] .= '相手の'.$_SESSION['name'].'は倒れた<br>';
      }elseif ($_SESSION['type'] == 2) {
        $_SESSION['hitpoint'] = $_SESSION['hitpoint'];
      }else {
        $_SESSION['hitpoint'] -= $attackPoint;
      }

    }elseif ($attack2Flg) {//アイアンテール
      $_SESSION['history'] = 'ピカチュウのアイアインテール！<br>';

      $attackPoint = mt_rand(40,50);
      if ($_SESSION['type'] == 2) {
        $attackPoint *= 2;
        $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
      }elseif($_SESSION['type'] == 1) {
        $attackPoint /= 2;
        $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      }else{
        $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      }

      //攻撃力が相手のHP以上だったら
      if ($_SESSION['hp'] <= $attackPoint) {
        $_SESSION['hitpoint'] = 0;
        $_SESSION['history'] .= '相手の'.$_SESSION['name'].'は倒れた<br>';
      }else {
        $_SESSION['hitpoint'] -= $attackPoint;
      }

    }elseif ($attack3Flg) {//なみのり
      $_SESSION['history'] = 'ピカチュウのなみのり！<br>';

      //ランダムで相手に攻撃を与える
      $attackPoint = mt_rand(40,50);
      if ($_SESSION['type'] == 2 || $_SESSION['type'] == 4) {
        $attackPoint *= 2;
        $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
      }elseif($_SESSION['type'] == 1 || $_SESSION['type'] == 3) {
        $attackPoint /= 2;
        $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      }else{
        $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      }

      //攻撃力が相手のHP以上だったら
      if ($_SESSION['hp'] <= $attackPoint) {
        $_SESSION['hitpoint'] = 0;
        $_SESSION['history'] .= '相手の'.$_SESSION['name'].'は倒れた<br>';
      }else {
        $_SESSION['hitpoint'] -= $attackPoint;
      }

    }elseif ($attack4Flg) {//そらをとぶ
      $_SESSION['history'] = 'ピカチュウのそらをとぶ！<br>';

      //ランダムで相手に攻撃を与える
      $attackPoint = mt_rand(40,50);
      if ($_SESSION['type'] == 3) {
        $attackPoint *= 2;
        $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
      }elseif($_SESSION['type'] == 2) {
        $attackPoint /= 2;
        $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      }else{
        $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      }

      //攻撃力が相手のHP以上だったら
      if ($_SESSION['hp'] <= $attackPoint) {
        $_SESSION['hitpoint'] = 0;
        $_SESSION['history'] .= '相手の'.$_SESSION['name'].'は倒れた<br>';
      }else {
        $_SESSION['hitpoint'] -= $attackPoint;
      }
    }elseif ($defenseFlg) {
      $_SESSION['history'] = 'ピカチュウは防御の体制に入った<br>';
    }elseif ($recoverFlg) {
      $recover = mt_rand(60,100);
      if (($myMonster['hp'] - $_SESSION['myhitpoint']) <= $recover) {
        $recover = $myMonster['hp'] - $_SESSION['myhitpoint'];
      }
      $_SESSION['myhitpoint'] += $recover;
      $_SESSION['history'] = 'ピカチュウはキズぐすりで'.$recover.'回復した<br>';
      if ($_SESSION['myhitpoint'] >= 300) {
        $_SESSION['myhitpoint'] = 300;
      }
    }elseif ($nextFlg) {
      if (empty($enemyCount)) {
        error_log('$enemyCountがemptyだよ');
        createNextEnemy();
        $_SESSION['history'] = $_SESSION['name'].'が現れた！<br>';
      }
    }elseif ($resetFlg) {
      unset($_SESSION);
    }

    if (!$recoverFlg && !$resetFlg && !$startFlg && !$nextFlg && $_SESSION['hitpoint'] > 0) {
      $_SESSION['history'] .= '相手の'.$_SESSION['name'].'の'.$_SESSION['attack_name'].'<br>';
      if ($defenseFlg) {
        $_SESSION['history'] .= 'ピカチュウは相手の'.$_SESSION['name'].'の攻撃を防いだ';
      }else {
        $enemyAttackPoint = mt_rand($_SESSION['attack_min'],$_SESSION['attack_max']);
        $_SESSION['history'] .= 'ピカチュウに'.$enemyAttackPoint.'のダメージ ';
        $_SESSION['myhitpoint'] -= $enemyAttackPoint;
      if ($_SESSION['myhitpoint'] <= 0) {
          $_SESSION['myhitpoint'] = 0;
          $_SESSION['history'] .= 'ピカチュウは倒れた';
        }
      }
    }

  }








   ?>
