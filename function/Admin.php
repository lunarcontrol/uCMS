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
<!DOCTYPE HTML>
<html>

<head>
  <title>Admin Panel</title>
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="../dpnd/admin.css" />
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <h1><a href="../">Admin Panel - <span class="logo_colour">phpMC</span></a></h1>
          <h2>Script Designed by Below Average - v1.4.2b</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
		  <?php
$firlinks = array(
    'Home',
    'News',
    'Gallery',
    'General',
	'Themes',
    'Extra Pages'
);
foreach ($firlinks as $link) {
    if (isset($_GET['p']) and $_GET['p'] == $link) {
        echo '<li class="selected"><a href="Admin.php?p=' . $link . '">' . $link . '</a></li>';
    } else {
        echo '<li><a href="Admin.php?p=' . $link . '">' . $link . '</a></li>';
    }
}
?>
			<li><a href="Admin.php?logout">Logout</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
      <div id="content">
       <h1><?php
if (isset($_GET['p'])) {
    echo $_GET['p'];
}
?></h1>
	   <?php
if (empty($_GET['p'])) {
    echo '<h2>Select a tab to edit!</h2>';
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
			<td align="right">News Button:</td>
			<td align="left"><input type="radio" name="firlinks[News]" value="News">On<br><input type="radio" name="firlinks[News]" value="">Off</td>
			</tr>
			<tr>
			<td align="right">Gallery Button:</td>
			<td align="left"><input type="radio" name="firlinks[Gallery]" value="Gallery">On<br><input type="radio" name="firlinks[Gallery]" value="">Off</td>
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
    //Gallery
    if ($_GET['p'] == 'Gallery') {
        echo '<h2>Gallery Page</h2>';
        //upload
        
        if (isset($_FILES['file'])) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
                echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                echo "Type: " . $_FILES["file"]["type"] . "<br>";
                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                move_uploaded_file($_FILES["file"]["tmp_name"], "img/" . $_FILES["file"]["name"]);
            }
        }
        //endupl
        
        //Delete
        if (isset($_GET['Delete'])) {
            echo '<span style="color:red;">Deleted, ' . $_GET['Delete'] . '</span>';
            unlink('img/' . $_GET['Delete']);
        }
        //enddElete
        
        $allFiles = scandir('img'); // Or any other directory
        $files    = array_diff($allFiles, array(
            '.',
            '..',
			'Home Page Slides'
        ));
        echo '<table>';
        foreach ($files as $file) {
            
            
            echo '<tr><td>' . $file . '</td><td><a href="./img/' . $file . '">Download</a></td><td><a href="Admin.php?p=Gallery&Delete=' . $file . '">Delete</a></td></tr>';
            
            
        }
        echo '</table>
		<fieldset style="padding:10px;">
		<legend>Upload File</legend>
		<form action="Admin.php?p=Gallery" method="post"
		enctype="multipart/form-data">
		<label for="file">Upload Image:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit">
		</form>
		</fieldset>
		';
		
		echo '<h2>Home Page Slide Show</h2>';
		//upload
        
        if (isset($_FILES['file2'])) {
            if ($_FILES["file2"]["error"] > 0) {
                echo "Error: " . $_FILES["file2"]["error"] . "<br>";
            } else {
                echo "Upload: " . $_FILES["file2"]["name"] . "<br>";
                echo "Type: " . $_FILES["file2"]["type"] . "<br>";
                echo "Size: " . ($_FILES["file2"]["size"] / 1024) . " kB<br>";
                move_uploaded_file($_FILES["file2"]["tmp_name"], "img/Home Page Slides/" . $_FILES["file2"]["name"]);
            }
        }
        //endupl
        
        //Delete
        if (isset($_GET['Delete2'])) {
            echo '<span style="color:red;">Deleted, ' . $_GET['Delete2'] . '</span>';
            unlink('img/Home Page Slides/' . $_GET['Delete2']);
        }
        //enddElete
        
        $allFiles = scandir('img/Home Page Slides/'); // Or any other directory
        $files    = array_diff($allFiles, array(
            '.',
            '..'
        ));
        echo '<table>';
        foreach ($files as $file) {
            
            
            echo '<tr><td>' . $file . '</td><td><a href="./img/Home Page Slides/' . $file . '">Download</a></td><td><a href="Admin.php?p=Gallery&Delete2=' . $file . '">Delete</a></td></tr>';
            
            
        }
        echo '</table>
		<fieldset style="padding:10px;">
		<legend>Upload File</legend>
		<form action="Admin.php?p=Gallery" method="post"
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
                $settings['extrapages'][$_GET['edit']] = "<iframe src='".$_POST['pointurl']."' id='fill'>Needs iframe support on this page!</iframe>";
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
    <div id="content_footer"></div>
    <div id="footer">
      <p>Copyright &copy; Royce Whitaker & github.com/DatRoyce | <a href="http://github.com/DatRoyce">Designed By Royce W!</a></p>
    </div>
    <p>&nbsp;</p>
  </div>
</body>
</html>
