<html>
<head>
	<title><?php echo $this->escape($this->title); ?></title>
	<link rel="stylesheet" type="text/css" media="screen" href="/zf-tutorial/public/styles/site.css" />
</head>
<body>
	<div id="content">
	<?php echo $this->render($this->actionTemplate); ?>
	</div>
</body>
</html>