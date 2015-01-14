<?php

if (empty($_GET['p']))
{
	header('location: ?p=Home');
}

$settings = parse_ini_file('db.ini', true);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php
echo $settings['general']['sitename'];
?> - <?php
echo strip_tags(str_replace('-', ' ', $_GET['p']));
?></title>

    <!-- Bootstrap -->
    <link href="dpnd/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	<?php
	
		echo $settings['themes'][$settings['themesetting']['theme']];
	
	?>
	</style>
  </head>
  <body>
  
  
  <?php
  if($settings['general']['isbanner'] == "true")
  {
  ?>
  <a href="./" style="background-image:url('<?php if(!empty($settings['general']['sitenamebanner'])) { echo $settings['general']['sitenamebanner']; } else { echo 'dpnd/titlehead(modern).jpg'; } ?>');" class="titlehead">&nbsp;<?php

if (empty($settings['general']['logo']))
{
	echo $settings['general']['sitename'];
}
else
{
	echo '<img height="100px;" src="' . $settings['general']['logo'] . '"/>';
}

?></a>
<?php } else { echo '<style>#fill { padding-top: 36px; }</style>'; } ?>
  
  
  <nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./"><span><?php echo $settings['general']['sitename']; ?></span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<?php
		
$firlinks = $settings['firlinks'];

foreach($firlinks as $linkadd => $link)
{
	if($link !== 'Home')
	{
		if(!empty($link))
		{
			if (isset($_GET['p']) and $_GET['p'] == $link)
			{
				echo '<li class="active"><a href="?p=' . $linkadd . '">' . $link . '</a></li>';
			}
			else
			{
				echo '<li><a href="?p=' . $linkadd . '">' . $link . '</a></li>';
			}
		}
	}
	
}

?>
		<?php
$links = $settings['extrapages'];

foreach($links as $link => $links)
{
	if (strpos($link, '-') == false)
	{
	$linkdash = str_replace(' ', '-', $link);
	}
	else
	{
	$linkdash = $link;
	}
	$linktext = $link;
	if (!in_array($linkdash,$firlinks) and isset($_GET['p']) and $_GET['p'] == $linkdash)
	{
		echo '<li class="active"><a href="?p=' . $linkdash . '">' . $linktext . '</a></li>';
	}
	elseif(!in_array($link,$firlinks))
	{
		echo '<li><a href="?p=' . $linkdash . '">' . $linktext . '</a></li>';
	}
}

?>
      </ul>
	    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Login <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <form method="post" name="input" action="./function/Admin.php" class="navbar-form navbar-left" role="Login">
				<div class="form-group">
					<input type="text" name="Username" class="form-control" placeholder="Username"><br><br>
					<input type="password" name="Password" class="form-control" placeholder="Password"><br><br>
				</div>
				<button type="submit" class="btn btn-default">Login</button>
			</form>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="content">
<?php

if (isset($_GET['p']))
{

	// Extra Pages
	if (strpos($_GET['p'], ' ') !== false)
	{
		$pnodash = $_GET['p'];
	}
	else
	{
		$pnodash = str_replace('-', ' ', $_GET['p']);
	}
	if (isset($settings['extrapages'][$pnodash]))
	{
		echo $settings['extrapages'][$pnodash];
	}

	// Home Page

	elseif (empty($settings['extrapages']['home']) and $_GET['p'] == 'Home')
	{
		include ('function/Home.php');

	}

	// News Page

	elseif (empty($settings['extrapages']['home']) and $_GET['p'] == 'News')
	{
		include ('function/News.php');

	}

	// Gallery Page

	elseif (empty($settings['extrapages']['home']) and $_GET['p'] == 'Gallery')
	{
		include ('function/Gallery.php');

	}
	
	//404 page
	else
	{
		echo '<center style="font-size:30px;">The page you requested is not found! 404<br> <div style="font-size:100px;">=(</div></center>';
	}
	
}

?>
		</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="dpnd/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dpnd/js/bootstrap.min.js"></script>
	<!-- Slideshow update speed -->
	<script type="text/javascript">
	var $ = jQuery.noConflict();
	$(document).ready(function() { 
      $('#this-carousel-id').carousel({ interval: 5000, cycle: true });
	}); 
	</script>
	<!-------------->
	
	
  </body>
</html>

<!-- This guy here is important for me... I use it to collect data on how many hits all my code gets! Yay for stats. Please don't erase it ='( I will cry.. -->
<div id="response"><!-- Script Built by Below Average! Krisdb2009. The phonehome analytic engine did not respond... --></div>
<script>
$(document).ready(function() {
$("#response").load("<?php $actual_link = 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'."{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; echo '//belowaverage.ga/PhoneHome/index.php?url='.$actual_link.'&version=1.4.2b&product=phpMC'; ?>");
});
</script>