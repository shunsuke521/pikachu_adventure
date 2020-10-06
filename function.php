<?php

ini_set('log_errors','on');
ini_set('error_log','php.log');
session_start();
error_log('hahaha');

//自分ポケモンデータ
$myMonster = array(
  'name' => 'ピカチュウ',
  'hp' => 300,
  'img' => 'img/pika.png'
);

//相手ポケモン格納用
$enemies = array();

class Type{
  const WATER = 1;
  const ROCK = 2;
  const GRASS = 3;
  const FIRE = 4;
  const ESPER = 5;
}

class Enemy{
  //プロパティ
  public $count;
  public $name;
  public $hp;
  public $img;
  public $attack_max;
  public $attack_min;
  public $bg;
  public $type;
  public $attack_name;

  //コンストラクタ
  public function __construct($count, $name, $hp, $img, $attack_max, $attack_min, $bg, $type, $attack_name){
    $this->count = $count;
    $this->name = $name;
    $this->hp = $hp;
    $this->img = $img;
    $this->attack_max = $attack_max;
    $this->attack_min = $attack_min;
    $this->bg = $bg;
    $this->type = $type;
    $this->attack_name = $attack_name;
  }

  //メソッド
  public function attack(){
    $enemyAttackPoint = mt_rand($_SESSION['enemy']->attack_min,$_SESSION['enemy']->attack_max);
    $_SESSION['history'] .= 'ピカチュウに'.$enemyAttackPoint.'のダメージ';
    $_SESSION['myhitpoint'] -= $enemyAttackPoint;
  if ($_SESSION['myhitpoint'] <= 0) {
      $_SESSION['myhitpoint'] = 0;
      $_SESSION['history'] .= 'ピカチュウは倒れた';
    }
  }
}

//インスタンス生成
$enemies[] = new Enemy(1, 'ニョロボン', 300, 'img/bon.png', 50, 10, 'img/bg_sea.jpg', Type::WATER, 'ハイドロポンプ');
$enemies[] = new Enemy(2, 'サイドン', 350, 'img/don.png', 60, 10, 'img/bg_mount.png', Type::ROCK, 'いわなだれ');
$enemies[] = new Enemy(3, 'ナッシー', 380, 'img/nashi.png', 60, 20, 'img/bg_grass.jpg', Type::GRASS, 'タネばくだん');
$enemies[] = new Enemy(4, 'リザードン', 400, 'img/riza.png', 60, 30, 'img/bg_mars.jpg', Type::FIRE, 'かえんほうしゃ');
$enemies[] = new Enemy(5, 'ミュウツー', 500, 'img/myu.png',70, 50, 'img/bg_cosmo.jpg', Type::ESPER, 'サイコキネシス');


function createFirstEnemy(){
  global $enemies;
  $enemy = $enemies[0];
  $_SESSION['enemy'] = $enemy;
  $_SESSION['hp_base'] = $enemy->hp;
  $_SESSION['hitpoint'] = $enemy->hp;
  $_SESSION['hp'] = $enemy->hp;
  $_SESSION['history'] = $enemy->name.'が現れた！<br>';
}

function createNextEnemy(){
  global $enemies;
  unset($enemy);
  $enemy = $enemies[$_SESSION['enemy']->count];
  $_SESSION['enemy'] = $enemy;
  $_SESSION['hp_base'] = $enemy->hp;
  $_SESSION['hitpoint'] = $enemy->hp;
  $_SESSION['hp'] = $enemy->hp;
  $_SESSION['history'] = $enemy->name.'が現れた！<br>';
}

function init(){
  global $myMonster;
  $_SESSION['myhp'] = $myMonster['hp'];
  $_SESSION['myhitpoint'] = $myMonster['hp'];
  createFirstEnemy();
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
    if ($_SESSION['enemy']->type == Type::WATER || $_SESSION['enemy']->type == Type::FIRE) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
    }elseif($_SESSION['enemy']->type == Type::ROCK) {
      $_SESSION['history'] .= '相手の'.$_SESSION['name'].'には効果がないようだ...<br>';
    }elseif ($_SESSION['enemy']->type == Type::GRASS) {
    $attackPoint = floor($attackPoint / 2);
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
    }else {
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
    }

    //攻撃力が相手のHP以上だったら
    if ($_SESSION['hitpoint'] <= $attackPoint) {
      error_log('hahaha');
      $_SESSION['hitpoint'] = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }elseif ($_SESSION['enemy']->type == Type::ROCK) {
      $_SESSION['hitpoint'] = $_SESSION['hitpoint'];
    }else {
      error_log('fufufu');
      $_SESSION['hitpoint'] -= $attackPoint;
    }

  }elseif ($attack2Flg) {//アイアンテール
    $_SESSION['history'] = 'ピカチュウのアイアインテール！<br>';

    $attackPoint = mt_rand(40,50);
    if ($_SESSION['enemy']->type == Type::ROCK) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
    }elseif($_SESSION['enemy']->type == Type::WATER) {
      $attackPoint = floor($attackPoint / 2);
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
    }else{
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
    }

    //攻撃力が相手のHP以上だったら
    if ($_SESSION['hitpoint'] <= $attackPoint) {
      $_SESSION['hitpoint'] = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }else {
      $_SESSION['hitpoint'] -= $attackPoint;
    }

  }elseif ($attack3Flg) {//なみのり
    $_SESSION['history'] = 'ピカチュウのなみのり！<br>';

    //ランダムで相手に攻撃を与える
    $attackPoint = mt_rand(40,50);
    if ($_SESSION['enemy']->type == Type::ROCK || $_SESSION['enemy']->type == Type::FIRE) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
    }elseif($_SESSION['enemy']->type == Type::WATER || $_SESSION['enemy']->type == Type::GRASS) {
    $attackPoint = floor($attackPoint / 2);
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
    }else{
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
    }

    //攻撃力が相手のHP以上だったら
    if ($_SESSION['hitpoint'] <= $attackPoint) {
      $_SESSION['hitpoint'] = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }else {
      $_SESSION['hitpoint'] -= $attackPoint;
    }

  }elseif ($attack4Flg) {//そらをとぶ
    $_SESSION['history'] = 'ピカチュウのそらをとぶ！<br>';

    //ランダムで相手に攻撃を与える
    $attackPoint = mt_rand(40,50);
    if ($_SESSION['enemy']->type == Type::GRASS) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
    }elseif($_SESSION['enemy']->type == Type::ROCK) {
    $attackPoint = floor($attackPoint / 2);
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
    }else{
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
    }

    //攻撃力が相手のHP以上だったら
    if ($_SESSION['hitpoint'] <= $attackPoint) {
      $_SESSION['hitpoint'] = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
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
      $_SESSION['history'] = $_SESSION['enemy']->name.'が現れた！<br>';
    }
  }elseif ($resetFlg) {
    unset($_SESSION);
  }

  //相手の攻撃
  if (!$recoverFlg && !$resetFlg && !$startFlg && !$nextFlg && $_SESSION['hitpoint'] > 0) {
    $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'の'.$_SESSION['enemy']->attack_name.'<br>';
    if ($defenseFlg) {
      $_SESSION['history'] .= 'ピカチュウは相手の'.$_SESSION['enemy']->name.'の攻撃を防いだ';
    }else {
      $_SESSION['enemy']->attack();
      }
    }
  }






 ?>
