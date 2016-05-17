<?php
//
// Created by Grégoire JONCOUR on 27/07/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $app->getName() ?> | <?= $title ?></title>
    <link rel="shortcut icon" href="<?= ROOT ?>dist/img/favicon.png" type="image/png">
    <link rel="icon" href="<?= ROOT ?>dist/img/favicon.png" type="image/png">
<?php foreach($css['external'] as $cs): ?>
    <link rel="stylesheet" href="<?= $cs ?>" type="text/css"/>
<?php endforeach; ?>
<?php foreach($css['internal'] as $cs): ?>
    <link rel="stylesheet" href="<?= ROOT ?>dist/css/<?= $cs ?>" type="text/css"/>
<?php endforeach; ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55961594-2', 'auto');
  ga('send', 'pageview');
  ga('send', 'social', 'Facebook', 'share', 'http://www.gregoirejoncour.xyz');
  ga('send', 'social', 'Twitter', 'Tweet', 'http://www.gregoirejoncour.xyz');
</script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $app->urlFor('home') ?>"><?= $app->getName() ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?= $app->urlFor('Lo') ?>">Utilisateurs</a></li>
                <li><a href="<?= $app->urlFor('groups_index') ?>">Groupes</a></li>
                <li><a href="<?= $app->urlFor('add') ?>">Ajouter un utilisateur</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="content container-fluid">

    <ul class="breadcrumb">
        <?php
        foreach ($breadcrumb as $key=>$value) {
            if($value!=''){
                ?>
                <li><a href="<?=$value; ?>"><?=$key; ?></a></li>
            <?php }else{?>
                <li class="active"><?=$key; ?></li>
            <?php }
        }
        ?>
    </ul>

    <div class="starter-template">

        <?= $content; ?>

    </div>

</div><!-- /.container -->


<footer class="footer">
    <div class="container">
        <p>Copyright &copy; <?= date("Y") ?> Grégoire JONCOUR.<br>
		<a href="https://validator.w3.org/nu/?doc=https%3A%2F%2Fwww.gregoirejoncour.xyz%2F">W3C validation</a><br>
		<a href="https://www.ssllabs.com/ssltest/analyze.html?d=gregoirejoncour.xyz">SSL LAbs</a>
		</p>
    </div>
</footer><!-- /footer -->

<?php foreach($js['internal'] as $j): ?>
<script src="<?= ROOT ?>dist/js/<?= $j ?>" type="application/javascript"></script>
<?php endforeach; ?>
<?php foreach($js['external'] as $j): ?>
<script src="<?= $j ?>" type="application/javascript"></script>
<?php endforeach; ?>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({html:true,placement:"right"});
        // scroll config
        //$(window).load(function(){
        //    $.mCustomScrollbar.defaults.theme="inset"; //set "inset" as the default theme
        //    $.mCustomScrollbar.defaults.scrollButtons.enable=true; //enable scrolling buttons by default
        //    $("body").mCustomScrollbar({
        //        setTop: 0,
        //        alwaysShowScrollbar: 1
        //    });
        //    console.log('ghjgk')
        //});
    });
</script>

</body>
</html>