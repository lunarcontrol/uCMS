<?php
session_start();
ob_start();
if (empty($_SESSION['Auth']) and empty($_POST['Username']) and empty($_POST['Password'])) {
    echo '<h1>What is your Secret Username and Password?</h1>
<form name="input" method="post">
Username: <input type="text" name="Username"><br>
Password: <input type="password" name="Password"><br>
<input type="submit" value="Submit">
</form>
';
    exit;
}
if (empty($_SESSION['Auth'])) {
    include('../SecretPassword.php');
    if ($Username == $_POST['Username'] and $Password == $_POST['Password']) {
        $_SESSION['Auth'] = true;
        
    } else {
        header('location: ../');
        exit;
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('location: ../');
    exit;
}
function arr2ini(array $a, array $parent = array())
{
    $out = '';
    foreach ($a as $k => $v) {
        if (is_array($v)) {
            //subsection case
            //merge all the sections into one array...
            $sec = array_merge((array) $parent, (array) $k);
            //add section information to the output
            $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
            //recursively traverse deeper
            $out .= arr2ini($v, $sec);
        } else {
            //plain key->value case
            $out .= "$k=\"$v\"" . PHP_EOL;
        }
    }
    return $out;
}
$settings = parse_ini_file('../db.ini', TRUE);
//Reset and update script goes here yo!
//it be generated here y'all, and executed else where cowboy
if(isset($_GET['reset']) and $_GET['reset'] == 'Reset')
{
$updatescript = file_get_contents('updateandreset.db');
file_put_contents('../update.php', $updatescript);
header('location: ../update.php?reset=Reset');
}
if(isset($_GET['update']) and $_GET['update'] == 'Update')
{
$updatescript = file_get_contents('updateandreset.db');
file_put_contents('../update.php', $updatescript);
header('location: ../update.php');
}
//Remember there is no turning back from this unfortunate decision
if(isset($_GET['update']) and $_GET['update'] == 'done')
{
unlink('../update.php');
header('location: Admin.php');
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span class="brand">uCMS Dashboard</span>

                <div class="nav-collapse collapse">

                    <ul class="nav">
                        <li class="active"><a href="#"><i class="icon-home icon-black"></i>Main Dashboard</a></li>
                        <!--<li><a href="#"><i class="icon-pencil icon-black"></i>Page Name</a></li>-->
                        <!--<li><a href="#"><i class="icon-file icon-black"></i>Page Name</a></li>-->
                        

                    </ul>

                    <ul class="nav pull-right settings">
                        <li class="dropdown">
                            <ul class="dropdown-menu">
                                <li><a href="#">Account Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="#">System Settings</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav pull-right settings">
                        <li><a href="#" class="tip icon logout" data-original-title="Settings"
                               data-placement="bottom"><i class="icon-large icon-cog"></i></a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="#" class="tip icon logout" data-original-title="Logout" data-placement="bottom"><i
                           class="icon-large icon-off"></i></a></li>
                    </ul>

                    <ul class="nav pull-right settings">
                        <li class="divider-vertical"></li>
                    </ul>

                    <p class="navbar-text pull-right">
                        Welcome <strong>Admin</strong>
                    </p>

                    <ul class="nav pull-right settings">
                        <li class="divider-vertical"></li>
                    </ul>

                    <div class="pull-right">
                        <form class="form-search form-inline" style="margin:5px 0 0 0;" method="post">
                            <div class="input-append">
                                <input type="text" name="keyword" class="span2 search-query" placeholder="Search">
                                <button type="submit" class="btn"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span2 pull-left">
        <div class="well sidebar-nav">
            <ul class="nav nav-tabs nav-stacked">
                <li class="nav-header">Navigation</li>
                <li class="active"><a href="#">Select One:</a></li>
                <li><a href="?p=General">General</a></li>
                <li><a href="?p=News">News</a></li>
                <li><a href="?p=Media">Media</a></li>
                <li><a href="?p=Themes">Themes</a></li>
                <li><a href="?p=Extra%20Pages">Extra Pages</a></li>
                <li><a href="?logout">Logout</a></li>
            </ul>
        </div>
    </div>
    <!--/.well -->
    <!--/span3-->

    <div class="span10 pull-left">

        <div class="well">
            <h1>The uCMS Dashboard</h1>
<!-- main area! -->
             
		<?php
if (isset($_GET['p'])) {
    echo $_GET['p'];
}
?></h1>
	   <?php
if (empty($_GET['p'])) {
    echo '<h2>Choose a tab to edit :)</h2>';
    echo'<a class="btn btn-primary btn-large" href="?p=General">General Tab &raquo;</a>';
} Else {
    
    //General Tab
    if ($_GET['p'] == 'General') {
        if (!empty($_POST)) {
            $settings = array_merge($settings, $_POST);
            file_put_contents('../db.ini', arr2ini($settings));
			echo '<span style="color:green;">Saved</span>';
        }
        echo '
		<form name="general" method="post">
		<table>
			<tr>
			<td align="right"><b>Website Title/Name</b>:</td>
			<td align="left"><input type="text" value="' . $settings['general']['sitename'] . '" name="general[sitename]" /></td>
			</tr>
			<tr>
			<td align="right"><b>Logo</b>: <br>(Replaces Title Text)<br>(Paste Image URL)</td>
			<td align="left"><input type="text" value="' . $settings['general']['logo'] . '" name="general[logo]" /></td>
			</tr>
			<tr>
			<td align="right"><b>Header Banner</b>:<br>Place an image URL</td>
			<td align="left"><input type="text" value="' . $settings['general']['sitenamebanner'] . '" name="general[sitenamebanner]" /></td>
			<tr>
			<td align="right"><b>Enable Header Banner</b>:</td>
			<td align="left"><input type="radio" name="general[isbanner]" value="true">True<br><input type="radio" name="general[isbanner]" value="">False</td>
			</tr>
		</table>
		
		<h1>Navigation Bar</h1>
		<table>
			<tr>
			<td align="right"><b>Please select all switches when applying or defaults will be set to off.</b></td>
			</tr>
			<tr>
			<td align="left">News Button:</td>
			<td align="left"><input type="radio" name="firlinks[News]" value="News">On<br><input type="radio" name="firlinks[News]" value="">Off</td>
			</tr>
		</table>
		
		<input type="submit" value="Submit">
		</form>
		<br><br><br><br><br><br><br>
		<form action="Admin.php" method="get">
		<h1>Update or Reset</h1>
		<table>
			<tr>
			<td align="left"><input type="submit" value="Update" name="update" /></td>
			<td align="left"><input type="submit" value="Reset" name="reset" /></td><td>Only update if you know there is a new version! - <a href="https://github.com/DatRoyce/uCMS/">GitHub</a></td>
			</tr>
		</table>
		</form>
		';
    }
    //End General Tab
    //HomePage
    if ($_GET['p'] == 'Home') {
        if (!empty($_POST)) {
            $settings = array_merge($settings, $_POST);
            file_put_contents('../db.ini', arr2ini($settings));
			Echo '<span style="color:green;">Saved</span>';
        }
        echo '
		<form name="general" method="post">
		<table>
			<tr>
			<td align="right">Main Description:</td>
			<td align="left"><textarea rows="4" cols="90" type="textarea" name="Home[description]">' . $settings['Home']['description'] . '</textarea></td>
			</tr>
		</table>
		<input type="submit" value="Submit">
		</form>
		';
    }
    //
    //Media
    if ($_GET['p'] == 'Media') {
        
        
        
		echo '<h2>Home Page Slides</h2>';
		//upload
        
        if (isset($_FILES['file2'])) {
            if ($_FILES["file2"]["error"] > 0) {
                echo "Error: " . $_FILES["file2"]["error"] . "<br>";
            } else {
                echo "Upload: " . $_FILES["file2"]["name"] . "<br>";
                echo "Type: " . $_FILES["file2"]["type"] . "<br>";
                echo "Size: " . ($_FILES["file2"]["size"] / 1024) . " kB<br>";
                move_uploaded_file($_FILES["file2"]["tmp_name"], "img/HomeSlides/" . $_FILES["file2"]["name"]);
            }
        }
        //endupl
        
        //Delete
        if (isset($_GET['Delete2'])) {
            echo '<span style="color:red;">Deleted, ' . $_GET['Delete2'] . '</span>';
            unlink('img/HomeSlides/' . $_GET['Delete2']);
        }
        //enddElete
        
        $allFiles = scandir('img/HomeSlides/'); // Or any other directory
        $files    = array_diff($allFiles, array(
            '.',
            '..'
        ));
        echo '<table>';
        foreach ($files as $file) {
            
            
            echo '<tr><td>' . $file . '</td><td><a href="./img/HomeSlides/' . $file . '">Download</a></td><td><a href="Admin.php?p=Media&Delete2=' . $file . '">Delete</a></td></tr>';
            
            
        }
        echo '</table>
		<fieldset style="padding:10px;">
		<legend>Upload File</legend>
		<form action="Admin.php?p=Media" method="post"
		enctype="multipart/form-data">
		<label for="file2">Upload Image:</label>
		<input type="file" name="file2" id="file2"><br>
		<input type="submit" name="submit" value="Submit">
		</form>
		</fieldset>
		';
    }
    //
    //News
    if ($_GET['p'] == 'News') {
        if (isset($_GET['delete'])) {
            echo '<span style="color:red">Deleted ' . $_GET['delete'] . '</span>';
            unset($settings['News'][$_GET['delete']]);
            file_put_contents('../db.ini', arr2ini($settings));
        }
        if (isset($_GET['create'])) {
			if(!empty($_POST['create']) and preg_match('/\S/', $_POST['create']))
			{
            $settings['News'][preg_replace('/[^A-Za-z0-9\-]/', ' ', $_POST['create'])] = 'This is default';
            file_put_contents('../db.ini', arr2ini($settings));
			}
        }
        if (!empty($_GET['edit'])) {
            if (!empty($_POST['edit'])) {
                $settings['News'][$_GET['edit']] = str_replace('"', '\'', $_POST['edit'] );
                file_put_contents('../db.ini', arr2ini($settings));
				header('location: ?p=News');
            }
            echo '<h2>' . $_GET['edit'] . '</h2>
		<form method="post" action="Admin.php?p=News&edit=' . $_GET['edit'] . '">
		<textarea rows="4" cols="90" name="edit">' . $settings['News'][$_GET['edit']] . '</textarea>
		<input value="Save" type="submit"/>
		</form>
		';
        }
        if (empty($_POST['edit']) and empty($_GET['edit'])) {
            echo '<table>';
            foreach ($settings['News'] as $title => $body) {
                echo '<tr><td>' . $title . '</td><td><a href="Admin.php?p=News&edit=' . $title . '">Edit</a></td><td><a href="Admin.php?p=News&delete=' . $title . '">Delete</a></td></tr>';
            }
            echo '</table>
		<form method="post" action="Admin.php?p=News&create">
		<input name="create" value="New News Article"/>
		<input type="submit" value="Create"/>
		</form>
		';
        }
    }
    //
    //Custom Themes
    if ($_GET['p'] == 'Themes') {
		if(isset($_GET['deletecon']))
		{
			echo 'Are you sure you want to delete '.$_GET['deletecon'].'? <a href="Admin.php?p=Themes&delete=' . $_GET['deletecon'] . '">(DELETE)</a>';
		}
        if (isset($_GET['delete'])) {
            echo '<span style="color:red">Deleted ' . $_GET['delete'] . '</span>';
            unset($settings['themes'][$_GET['delete']]);
            file_put_contents('../db.ini', arr2ini($settings));
        }
		if(isset($_POST['apply']))
		{
			$settings['themesetting']['theme'] = $_POST['apply'];
			file_put_contents('../db.ini', arr2ini($settings));
			echo '<br><span style="color:lime">Applied ' . $_POST['apply'] . '</span>';
			exit;
		}
        if (isset($_POST['create'])) {
			if(!empty($_POST['create']) and preg_match('/\S/', $_POST['create']))
			{
            $settings['themes'][preg_replace('/[^A-Za-z0-9\-]/', ' ', $_POST['create'])] = file_get_contents('../dpnd/defaulttheme.db');
            file_put_contents('../db.ini', arr2ini($settings));
			}
        }
        if (!empty($_GET['edit'])) {
            if (!empty($_POST['edit'])) {
                $settings['themes'][$_GET['edit']] = str_replace('"', '\'', $_POST['edit'] );
                file_put_contents('../db.ini', arr2ini($settings));
				header('location: ?p=Themes');
            }
            echo '<h2>' . $_GET['edit'] . '</h2>
		<form method="post" action="Admin.php?p=Themes&edit=' . $_GET['edit'] . '">
		<textarea rows="50" cols="90" name="edit">' . $settings['themes'][$_GET['edit']] . '</textarea>
		<input value="Save" type="submit"/>
		</form>
		';
        }
        if (empty($_POST['edit']) and empty($_GET['edit'])) {
            echo '<table><form method="post"><th></th><th>Theme</th><th>CSS/EDIT - Requires css knowledge to use!</th><th>Delete</th>';
            foreach ($settings['themes'] as $title => $body) {
                echo '<tr><td><button name="apply" value="'.$title.'">Apply</button></td><td>' . $title . '</td><td><a href="Admin.php?p=Themes&edit=' . $title . '">Edit</a></td><td><a href="Admin.php?p=Themes&deletecon=' . $title . '">Delete</a></td></tr>';
            }
            echo '</table>
		<form method="post" action="Admin.php?p=Themes&create">
		<input name="create" value="New theme"/>
		<input type="submit" value="Create"/>
		</form>
		';
        }
    }
    //
    //Extra Pages
    if ($_GET['p'] == 'Extra Pages') {
        if (isset($_GET['delete'])) {
            echo '<span style="color:red">Deleted ' . $_GET['delete'] . '</span>';
            unset($settings['extrapages'][$_GET['delete']]);
            file_put_contents('../db.ini', arr2ini($settings));
        }
        if (isset($_GET['create'])) {
			if(!empty($_POST['create']) and preg_match('/\S/', $_POST['create']))
			{
            $settings['extrapages'][preg_replace('/[^A-Za-z0-9\-]/', ' ', $_POST['create'])] = 'This is default';
            file_put_contents('../db.ini', arr2ini($settings));
			}
        }
		if (isset($_GET['mtt'])) {
			$settings['extrapages'] = array($_GET['mtt'] => $settings['extrapages'][$_GET['mtt']]) + $settings['extrapages'];
            file_put_contents('../db.ini', arr2ini($settings));
        }
        if (!empty($_GET['edit'])) {
            if (!empty($_POST['edit'])) {
                $settings['extrapages'][$_GET['edit']] = str_replace('"', '\'', $_POST['edit'] );
                file_put_contents('../db.ini', arr2ini($settings));
				echo '<span style="color:green;">Saved</span> - <a target="_blank" href="../?p='.$_GET['edit'].'">Preview your work!</a>';
            }
            if (!empty($_POST['pointurl'])) {
                $settings['extrapages'][$_GET['edit']] = "<iframe src='".$_POST['pointurl']."' id='fill'>You need a modern browser with iFrame support!</iframe>";
                file_put_contents('../db.ini', arr2ini($settings));
				echo '<span style="color:green;">Saved</span> - <a target="_blank" href="../?p='.$_GET['edit'].'">Preview your work!</a>';
            }
            echo '
		<center><h2>' . $_GET['edit'] . '</h2></center>
		<script type="text/javascript" src="../dpnd/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
		</script>
		<form method="post" action="Admin.php?p=Extra%20Pages&edit=' . $_GET['edit'] . '">
		<textarea class="ckeditor" style="width:850px;height:1000px;" name="edit">' . $settings['extrapages'][$_GET['edit']] . '</textarea>
		</form>
		<h2>Point this page at a URL? (iframe) - Full screen iframe.</h2>
		<form method="post">
		<input placeholder="http://something.com/" type="text" name="pointurl"/>
		<input type="submit" value="Set an iFrame"/>
		</form>
		';
        }
        if (empty($_POST['edit']) and empty($_GET['edit'])) {
			if(isset($_GET['deletecon']))
			{
				echo 'Are you sure you want to delete '.$_GET['deletecon'].'? <a href="Admin.php?p=Extra%20Pages&delete=' . $_GET['deletecon'] . '">(DELETE)</a>';
			}
            echo '<table>';
            foreach ($settings['extrapages'] as $title => $body) {
                echo '<tr><td>' . $title . '</td><td><a href="Admin.php?p=Extra%20Pages&edit=' . $title . '">Edit</a></td><td><a href="Admin.php?p=Extra%20Pages&deletecon=' . $title . '">Delete</a></td><td><a href="Admin.php?p=Extra%20Pages&mtt=' . $title . '">Top</a></td></tr>';
            }
            echo '</table>
		<form method="post" action="Admin.php?p=Extra%20Pages&create">
		<input name="create" value="New Page Title"/>
		<input type="submit" value="Create"/>
		</form>
		';
        }
    }
    //
    
    
}
?>
            
            
            
            
        </div>

    </div>
    <!--/span9-->

</div>
<!--/row-fluid-->

<hr>

<footer align="center">
    <p>Copyright &copy; 2015 <strong>Royce Whitaker (github.com/DatRoyce)</strong></p>
    <p>v0.1.1 Pre-Alpha Release (January 17, 2015)</p>
</footer>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script>
    // enable tooltips
    $(".tip").tooltip();
</script>

</body>
</html>
