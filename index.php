<?php

function loadPics($pics)
{
  if ($dir = @opendir("."))
  {
    while($file = readdir($dir))
    {
    if(preg_match('/(.jpg)|(.gif)|(.png)/', $file))
      array_push($pics, $file);
  }

    closedir($dir);
  }

  sort($pics);
  return $pics;
}

function listPics($pics)
{
  foreach($pics as $num => $pic)
  {
    echo "<li><a href='".$_SERVER['PHP_SELF']."?c=$num'>".getPicName($num, $pics)."</a></li>\n";
  }
}

function showPic($c, $pics)
{
  $pic = $pics[$c];
  echo "<!-- $c -->\n";
  echo "<img id=\"image\" src=\"$pic\" alt=\"".getPicName($_REQUEST['c'], $pics)."\" title=\"".getPicName($_REQUEST['c'], $pics)."\">";
}

function srcOnly($c, $pics)
{
  $pic = $pics[$c];
  echo "\n";
  echo "$pic";
}

function getPrev($c, $pics)
{
  $len = count($pics);
  $ret = 0;
  if($len > 1)
  {
    if($c == 0)
      $ret = $len - 1;
    else
      $ret = $c - 1;
  }
  else
  {
    $ret = $c;
  }
  return $ret;
}

function getNext($c, $pics)
{
  $len = count($pics);
  $ret = 0;
  if($len > 1)
  {
    if($c == $len -1)
        $ret = 0;
    else
        $ret = $c + 1;
  }
  else
  {
    $ret = $c;
  }
  return $ret;
}

function getPicName($c, $pics)
{
  return preg_replace("/\.jpg$|\.gif$|\.png$/i", "", $pics[$c]);
}

$pics = array();
$pics = loadPics($pics);

if(!isset($_REQUEST['c'])) $_REQUEST['c'] = 0;

?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">

    <title><?php echo getPicName($_REQUEST['c'], $pics)?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <script type="text/javascript">
      jQuery(document).ready(function($) {
        function DropDown(el) {
          this.dd = el;
          this.initEvents();
        }
        DropDown.prototype = {
          initEvents : function() {
            var obj = this;

            obj.dd.on('click', function(event){
              $(this).toggleClass('active');
              event.stopPropagation();
            });
          }
        }
        $(function() {
          var dd = new DropDown( $('#dd') );
          $(document).click(function() {
            $('.image-dropdown').removeClass('active');
          });
        });

        var mq = window.matchMedia( "(max-width: 768px)" );
        if (mq.matches) {
        }
        else {
          $("#image").click(function() {
            $(this).toggleClass("zoom");
          });
        }

      });
    </script>

    <style type="text/css">
    :root {
      --base: #333;
      --link: rgba(246, 246, 243, 0.8);
      --semi-01: rgba(255,255,255,0.1);
      --semi-02: rgba(255,255,255,0.2);
      --semi-03: rgba(255,255,255,0.3);
      --semi-06: rgba(246,246,243,0.6);
      --semi-dark: rgba(0,0,0,0.2);
      --shadow: rgba(0,0,0,0.5);
      --hover: #f6f6f3;
      --white: #fff;
      --main: #555;
      --dark-main: #222;
      }
    * {
      vertical-align: baseline;
      font-weight: inherit;
      font-family: inherit;
      font-style: inherit;
      line-height: 1;
      font-size: 100%;
      border: none;
      outline: none;
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      transition: all 150ms ease-in-out;
    }
    ::selection {
      background-color: var(--main);
      color: var(--white);
    }
    body {
      background: var(--base);
      color: var(--white);
      margin: 0 1rem 1rem 1rem;
      font: 14px "Inter", sans-serif;
      font-optical-sizing: auto;
      overflow-x: hidden;
    }
    img {
      max-width: 100%;
      height: auto;
    }
    img:hover { filter: brightness(1.02); }
    a {
      color: var(--link);
      text-decoration: none;
    }
    a:hover { color: var(--hover); }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    h1 {
      font-size: 1.25rem;
      font-weight: normal;
      margin-left: 0.5rem;
    }
    h1, #select-nav { flex: 50%; }
    h2, p {
      margin: 0 0 2rem 0;
      line-height: 1.3;
    }
    h2 {
      font-size: 1.2rem;
      font-weight: normal;
    }

    h1, #prev a, #next a, .image-dropdown { padding: 1rem; }

    #top-nav {
      background: var(--main);
      box-shadow: 0 0 15px var(--shadow);
      color: var(--white);
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      border-radius: 0 0 5px 5px;
      position: relative;
      z-index: 4;
      animation: fadeIn ease-in 150ms;
    }
    #select-nav {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }

    #prev a, #next a {
      display: block;
      margin: 0 0.25rem;
      opacity: 0.8;
    }
    #prev a:hover, #next a:hover { opacity: 1.0; }
    #prev span { margin-left: 0.5rem; }
    #next span { margin-right: 0.5rem; }
    #prev { text-align: right; }
    #next { text-align: left; }
    #top-nav span, #top-nav i, #footer i {
      position: relative;
      top: 1px;
    }
    #image-select { flex-grow: 2; }
    .image-dropdown {
      background: var(--semi-01);
      position: relative;
      margin: 0.5rem auto;
      border-radius: 3px;
      cursor: pointer;
    }
    .image-dropdown:after {
      content: "\f078";
      font-family: "Font Awesome 5 Free";
      font-style: normal;
      font-weight: 900;
      position: absolute;
      right: 17px;
      top: 16px;
      opacity: 0.6;
    }
    .image-dropdown:hover {
      background: var(--semi-02);
      color: var(--hover);
    }
    .image-dropdown:hover:after { opacity: 1.0; }
    .dropdown, .dropdown li {
      margin: 0;
      padding: 0;
      list-style: none;
    }
    .dropdown {
      background: var(--hover);
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      text-align: left;
      border-radius: 0 0 5px 5px;
      border: 1px solid var(--hover);
      border-top: none;
      border-bottom: none;
      max-height: 0;
      overflow-y: scroll;
    }
    .dropdown li a {
      background: var(--link);
      color: var(--base);
      display: block;
      padding: 1rem;
    }
    .dropdown li:last-of-type a { border: none; }
    .dropdown li i {
      margin-right: 5px;
      color: inherit;
      vertical-align: middle;
    }
    .dropdown li:hover a {
      background: var(--white);
      color: var(--main);
    }
    .image-dropdown.active {
      background: var(--base);
      border-radius: 5px 5px 0 0;
      color: var(--white);
    }
    .image-dropdown.active:after { border-color: var(--white); }
    .image-dropdown.active .dropdown { max-height: 400px; }
    #image-container {
      text-align: center;
      margin: 1rem auto;
      position: relative;
      z-index: 1;
      animation: fadeIn ease-in 300ms;
    }
    #top-nav, #image-container {
      opacity: 0;
      animation-fill-mode: forwards;
    }
    #image a {
      display: inline-block;
      position: relative;
    }
    img#image {
      box-shadow: 0 0 15px var(--shadow);
      display: inline-block;
      border-radius: 6px;
      z-index: 2;
      position: relative;
      width: auto;
    }
    #footer {
      text-align: center;
      padding: 1rem;
      color: var(--semi-06);
    }
    #footer p:last-child { margin-bottom: 0; }
    .btn {
      background: var(--semi-02);
      display: inline-block;
      padding: 0.875rem 1rem;
      border-radius: 5px;
      margin: 0 auto 1rem auto;
    }
    .btn i {
      position: relative;
      top: -1px;
      margin-left: 12px;
    }
    .btn:hover { background: var(--semi-03); }

    .mobile-show { display: none; }
    .mobile-hide { display: inherit; }

    #github { margin: 1.5rem 1rem 0.5rem 1rem; }
    #github { font-size: 0.785rem; }
    #github a {
      opacity: 0.5;
      padding: 0.5rem;
      display: inline-block;
    }
    #github a:hover { color: var(--white); }
    #github i {
      position: relative;
      margin-right: 5px; top: 0;
    }

    #imgview { margin: 0.5rem 1rem 0 1rem; }
    #imgview a { padding: 0.5rem; }
    #imgview img { max-width: 24px; }
    #imgview a img { filter: grayscale(100%); }
    #imgview a:hover img {
      filter: grayscale(0%);
      transform: scale(1.2);
    }

    @media (min-width: 0) and (max-width: 768px) {
      .mobile-show { display: inherit; }
      .mobile-hide { display: none; }
      #top-nav {
        margin: 0;
        border-radius: 0;
      }
      #top-nav, h1, #image-select {
        display: block;
        width: auto;
      }
      #top-nav, h1, #image-select, .dropdown { text-align: center; }
      #select-nav, h1 { flex: auto; }
      #prev span { margin-left: 0; }
      #next span { margin-right: 0; }
      h1 {
        display: inherit;
        margin: 0;
        padding-bottom: 0.5rem;
      }
      #prev span, #next span { display: none; }
      .image-dropdown {
        padding: 1rem;
        width: 85%;
      }
      img#image, img#image.zoom {
        height: auto;
        max-width: 100%;
        cursor: default;
      }
    }
    </style>

  </head>

  <body class="c-<?php echo getNext($_REQUEST['c'], $pics)?>">

    <div id="top-nav">
      <h1><?php echo getPicName($_REQUEST['c'], $pics)?></h1>
      <div id="select-nav">
        <div id="prev"><a href="<?php echo $_SERVER['PHP_SELF']?>?c=<?php echo getPrev($_REQUEST['c'], $pics)?>" title="Previous Image"><i class="fas fa-chevron-left"></i><span>PREV</span></a></div>
        <div id="image-select">
          <div id="dd" class="image-dropdown" tabindex="1">Select image ...
            <ul class="dropdown">
              <?php listPics($pics); ?>
            </ul>
          </div>
        </div>
        <div id="next"><a href="<?php echo $_SERVER['PHP_SELF']?>?c=<?php echo getNext($_REQUEST['c'], $pics)?>" title="Next Image"><span>NEXT</span><i class="fas fa-chevron-right"></i></a></div>
      </div>
    </div>

    <div id="image-container">

      <div><a href="<?php echo $_SERVER['PHP_SELF']?>?c=<?php echo getNext($_REQUEST['c'], $pics)?>"><?php if(isset($_REQUEST['c'])) showPic($_REQUEST['c'], $pics); ?></a></div>

    </div>

    <div id="footer">

      <h2>&quot; <?php echo getPicName($_REQUEST['c'], $pics)?> &quot;</h2>

      <p><a class="btn" href="<?php srcOnly($_REQUEST['c'], $pics); ?>" download="<?php srcOnly($_REQUEST['c'], $pics); ?>">Download Image<i class="fas fa-save"></i></a></p>

    </div>

  </body>
</html>
