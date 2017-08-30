<? // picviewer.php

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
    while(list($num, $pic) = each($pics))
    {
        echo "<li><a href='".$PHP_SELF."?c=$num'>".getPicName($num, $pics)."</a></li>\n";
    }
}

function showPic($c, $pics)
{
    $pic = $pics[$c];
    echo "<!-- $c -->\n";
    echo "<img src=\"$pic\" alt=\"".getPicName($_REQUEST['c'], $pics)."\" title=\"".getPicName($_REQUEST['c'], $pics)."\">";
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

<!DOCTYPE HTML>
<html>

    <head>

        <title><?=getPicName($_REQUEST['c'], $pics)?></title>

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <style type="text/css">
        body { background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAIElEQVQoU2NUUVH5z0AEYAQpvHPnDkGlowrxBhHRwQMAYtQlbUStXfMAAAAASUVORK5CYII=); margin: 0; font-family: sans-serif; overflow-x: hidden; line-height: 1; }
        body, a { text-decoration: none; color: #333; }
        a, a img, .image-dropdown { -webkit-transition: all 150ms ease-in-out; transition: all 150ms ease-in-out; }
        a:hover { color: #1961a4; }
        #top-nav { background: -webkit-gradient(linear, left top, right top, from(#f8f8f8), to(#ccc)); background: -webkit-linear-gradient(top, #f8f8f8, #ccc); background: linear-gradient(top, #f8f8f8, #ccc); background-color: #ccc; border-top: 1px solid #fff; display: table; width: 100%; position: relative; z-index: 99; }
        h1, #prev, #image-select, #next { display: table-cell; vertical-align: middle; }
        #prev a, #next a { display: block; padding: 10px; font-size: 0.875em; }
        #prev a, #next a, #image-select, #footer { font-size: 0.8125em; }
        h1 { width: 60%; font-size: 1.2em; font-weight: normal; margin: 0; padding: 10px 10px 10px 20px; }
        #prev, #next { width: 5%; white-space: nowrap; }
        #prev { text-align: right; }
        #next { text-align: left; }
        #top-nav span { font-weight: bold; position: relative; top: 1px; }
        #image { text-align: center; padding: 20px; }
        #image img { -webkit-box-shadow: 0 0 30px #000; box-shadow: 0 0 30px #000;}
        #footer { padding: 10px 10px 30px 20px;  line-height: 1.4; text-align: center; }
        #footer, #footer a { color: #999; }
        #footer a { text-decoration: underline; }
        #footer a:hover { color: #fff; }
        img { border: 0; max-width: 100%; height: auto; }
        #image-select { *zoom: 1; font-weight: bold; width: 30%; }
        #image-select:after { clear: both; content: ""; display: table; }
        .image-dropdown { background: #f8f8f8; position: relative; width: 90%; margin: 10px auto; padding: 10px 15px; border-radius: 3px; cursor: pointer; outline: none; }
        .image-dropdown:after { content: ""; width: 0; height: 0; position: absolute; top: 50%; right: 15px; margin-top: -3px; border-width: 6px 6px 0 6px; border-style: solid; border-color: #333 transparent; }
        .dropdown, .dropdown li { margin: 0; padding: 0; list-style: none; }
        .dropdown { background: #ededed; position: absolute; top: 100%; left: 0; right: 0; text-align: left; border-radius: 0 0 5px 5px; border: 1px solid rgba(0,0,0,0.2); border-top: none; border-bottom: none; list-style: none; max-height: 0; overflow-y: scroll; }
        .dropdown li a { display: block; text-decoration: none; color: #333; padding: 10px; transition: all 0.3s ease-out; border-bottom: 1px solid #e6e8ea; }
        .dropdown li:last-of-type a { border: none; }
        .dropdown li i { margin-right: 5px; color: inherit; vertical-align: middle; }
        .dropdown li:hover a { background: #fff; color: #1961a4; }
        .image-dropdown.active { background: #1961a4; border-radius: 5px 5px 0 0; box-shadow: none; border-bottom: none; color: white; }
        .image-dropdown.active:after { border-color: #fff transparent; }
        .image-dropdown.active .dropdown { border-bottom: 1px solid rgba(0,0,0,0.2); max-height: 300px; }
        @media (min-width: 0px) and (max-width: 768px) {
            #top-nav, h1, #image-select { display: block; text-align: center; width: 100%; }
            h1 { padding: 10px 10px 0 10px; }
            #prev,#next { display: none; }
            .image-dropdown { padding: 12px; width: 85%; }
            #image { padding: 0; }
        }
        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://use.fontawesome.com/26e6ac0a2e.js"></script>
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

            });
        </script>

    </head>

<body>

    <div id="top-nav">

        <h1><?=getPicName($_REQUEST['c'], $pics)?></h1>

        <div id="prev"><a href="<?=$PHP_SELF?>?c=<?=getPrev($_REQUEST['c'], $pics)?>"><i class="fa fa-angle-left fa-lg"></i>&nbsp;<span>PREV</span></a></div>

        <div id="image-select">
            <div id="dd" class="image-dropdown" tabindex="1">Select image ...
                <ul class="dropdown">
                    <? listPics($pics); ?>
                </ul>
            </div><!-- .image-dropdown -->
        </div><!-- #image-select -->

        <div id="next"><a href="<?=$PHP_SELF?>?c=<?=getNext($_REQUEST['c'], $pics)?>"><span>NEXT</span>&nbsp;<i class="fa fa-angle-right fa-lg"></i></a></div>

    </div><!-- #top-nav -->

    <div id="image">
        <a href="<?=$PHP_SELF?>?c=<?=getNext($_REQUEST['c'], $pics)?>">
        <?
            if(isset($_REQUEST['c']))
            showPic($_REQUEST['c'], $pics);
        ?>
        </a>
    </div><!-- #image -->

    <div id="footer">
        All images are copyright &copy; <a href="http://edwardrobirds.com" target="_blank">Edward Robirds/Sharp New Media</a> and are for sample use and display only.<br>
        Distribution and/or duplication is not allowed without permission.
    </div><!-- #footer -->

</body>
</html>
