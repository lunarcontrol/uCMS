  <div id="desc">
  <div id="this-carousel-id" class="carousel slide"><!-- class of slide for animation -->
  <div class="carousel-inner">      
      <div class="item active">
	    <h1><center>Welcome to <?php echo $settings['general']['sitename']; ?></center></h1>
	    //This looks in db.ini under 'general' and then it graps the data from 'sitename'
	    <p><?php
echo $settings['Home']['description'];
?></p>
//This looks in db.ini under 'general' and then it graps the data from 'sitename'
      </div>
  
  <?php
        $allFiles = scandir('function/img/HomeSlides'); // Any Directory will work
        $files    = array_diff($allFiles, array(
            '.',
            '..'
        ));
        foreach ($files as $file) {
          echo '
      <div id="slide" class="item">
      <img style="margin: 0 auto;" src="function/img/HomeSlides/'.$file.'" alt="" />
      <div class="carousel-caption">
      <p>'.$file.'</p>
      </div>
      </div>
            ';
        }

	
	?>
	
  </div><!-- /.carousel-inner -->
  <!--  Next and Previous controls below
        href values must reference the id for this carousel -->
    <a class="carousel-control left" href="#this-carousel-id" data-slide="prev"><--</a>
    <a class="carousel-control right" href="#this-carousel-id" data-slide="next">--></a>
</div><!-- /.carousel -->
</div>
<br>
<center>
<div id="half" class="panel panel-default">
  <div class="panel-body">
    <?php
$i = 1;
if(!empty($settings['News']))
{
echo '<center><h3>Recent News Articles</h3></center>';
$settings['News'] = array_reverse($settings['News']);
foreach($settings['News'] as $artical => $cont)
{
$cont = strip_tags(substr($cont,0,60).'...');
echo '<a id="artlink" href="?p=News&article='.$artical.'"><b>'.$artical.'</b> - '.$cont.'</a><br>';
if ($i++ == 3) break;
}}
?>
  </div>
</div>
</center>
