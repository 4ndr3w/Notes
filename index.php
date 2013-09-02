<?php
require_once("markdown.php");
$basePath = "notebook";
$files = scandir($basePath);
require_once("authentication.php");
doAuthFor($_GET['file']);

function processDirectory($path, $dirName, $isTopLevel = false)
{
	global $basePath;
	$files = scandir($path);
	if ( !$isTopLevel )
	{
	?>
	  <li class="dropdown-submenu">
	      <a tabindex="-1" href="#"><?php echo $dirName; ?></a>
	      <ul class="dropdown-menu">
	<?php
	}
	
	foreach ($files as $file)
	{
		if ( $file[0] == "." )
		{
			// do nothing
		}
		else if ( is_dir($path."/".$file) )
			processDirectory($path."/".$file, $file);
		else if ( substr($file, -3) == ".md" )
			echo "<li><a href=\"index.php?file=".str_replace($basePath."/", "", $path)."/".$file."\">".substr($file, 0, -3)."</a></li>";
	}

	if ( !$isTopLevel )
	{?>
    	</ul></li>
	<?php
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Notes</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="index.php">Notes</a>
			
            	<ul class="nav">
				    
						  <?php
						  if ( !$guestUser )
						  {
							  foreach ( $files as $file )
							  {
								  if ( is_dir($basePath."/".$file) && $file != "." && $file != ".." && $file[0] != "." )
								  {
								  ?>
			  				    <li class="dropdown">
			  				      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<?php echo $file; ?>
			  				        <b class="caret"></b>
			  				      </a>
			  				      <ul class="dropdown-menu">
									  <?php processDirectory($basePath."/".$file, $file, true); ?>
								  </ul>
							  	</li>
								<?php
								  }
							  }
						  }
						  ?>
  				</ul>
			</div>
		</div>
	</div>

    <div class="container">
		<br><br><br><br>
		<div class="well">
			<?php
			if ( array_key_exists("file", $_GET) && $_GET['file'][0] != "/" && strpos($_GET['file'], "..") === false )
			{
				$data = @file_get_contents($basePath."/".$_GET['file']);
				if ( $data )
					echo markdown($data);
				else
					echo "Unable to open ".$_GET['file'];
			}
			?>
		</div>
    </div><!-- /.container -->

    <script src="http://getbootstrap.com/assets/js/jquery.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
  </body>
</html>
