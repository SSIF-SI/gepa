<DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=PAGE_TITLE_PREFIX?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link  href="http://fonts.googleapis.com/css?family=Cabin:400,500,600,bold" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="<?=HTTP_ROOT?>css/gepa.css">
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.9/js/bootstrap-dialog.min.js"></script>

</head>
<body>
<div id="title">Gestione pacchi<br/></div>
<nav id="leftnav">
	<ul>
		<li>
			<a id="pacchiInEntrata" href="#pacchiInEntrata" title="Pacchi in Entrata">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="pacchiInEntrata circleBase type1 front"></div>
					  </div>
					  <div class="back face center">
							<div class="pacchiInEntrata circleBase type1 back"></div>
					  </div>
					</div>
				</div>
			</a>
		</li>
		<li>
			<a id="pacchiInUscita" href="#pacchiInUscita" title="Pacchi in uscita">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="pacchiInUscita circleBase type1 front"></div>
					  </div>
					  <div class="back face center">
							<div class="pacchiInUscita circleBase type1 back"></div>
					  </div>
					</div>
				</div>
			</a>
		</li>
		<li>
			<a id="registro" href="#registro" title="Registro">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="registro circleBase type1 front"></div>
					  </div>
					  <div class="back face center">
							<div class="registro circleBase type1 back"></div>
					  </div>
					</div>
				</div>
			</a>
		</li>
		<li>
			<a id="corrieri" href="#corrieri" title="Registro">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="corrieri circleBase type1 front"></div>
					  </div>
					  <div class="back face center">
							<div class="corrieri circleBase type1 back"></div>
					  </div>
					</div>
				</div>
			</a>
		</li>
	</ul>
</nav>
<section id="s_operatore"><?=$operatore?></section>
<section id="main">
<?php if(isset($view)) include($view);?>
</section>
<script>var BUSINESS_HTTP_PATH = "<?=BUSINESS_HTTP_PATH ?>";</script>
<script src="<?=SCRIPTS_PATH?>index.js"></script>
</body>
</html>

