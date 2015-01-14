<?php
if(isset($_GET['article']))
{
echo '<br><a id="backln" href="./?p=News"><span class="glyphicon glyphicon-arrow-left"></span> Back</a><br><br>';
echo '<div id="newsart"><h3>'.$_GET['article'].'</h3>';
echo '<hr>';
echo $settings['News'][$_GET['article']].'</div>';
}
else
{
echo '<center><h1>Recent News</h1></center>';
if(!empty($settings['News']))
{
$settings['News'] = array_reverse($settings['News']);
foreach($settings['News'] as $artical => $cont)
{
$cont = strip_tags(substr($cont,0,60).'...');
echo '<a id="artlink" href="?p=News&article='.$artical.'"><b>'.$artical.'</b> - '.$cont.'</a><br>';
}





}
}
?>
