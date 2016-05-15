<?php include "core/dandelion.php"; $dcms = new Dandelion; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<title><?php $dcms->show_site_title(); ?></title>
	<base href="<?php echo $dcms->settings['site_url']; ?>" target="_self" />
  <link rel="icon" href="favicon.png" />
	<link href="styles/default.css" rel="stylesheet" type="text/css" />
</head>
<body>

  <div id="all">

    <header>

      <div id="logo">
        <h1><?php echo $dcms->settings['site_title']; ?></h1>
        <?php if ($dcms->settings['site_tagline'] != "") { echo "<p>".$dcms->settings['site_tagline']."</p>"; } ?>
      </div>

      <nav>
        <ul id="main-menu">
        <?php $dcms->show_menu('main-menu'); ?>
        </ul>
      </nav>

    </header>

    <div id="contents">

      <div id="main-contents">

        <?php $dcms->load_page($dcms->current_page); ?>

      </div><!-- #main-contents -->

      <div id="sidebar">

        <h2>Sidebar</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <h2>Sidebar</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <h2>Sidebar</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <h2>Sidebar</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

      </div><!-- #sidebar -->

      <div class="cleaner"></div>

    </div><!-- #contents -->

    <footer>
			<div id="footer-contents">
				<p>Powered by Dandelion alpha 0.4</p>
			</div>
    </footer>

  </div><!-- #all -->

</body>
</html>
