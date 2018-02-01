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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=HTTP_ROOT?>css/gepa.css">
</head>
<body>
<div id="title">Gestione pacchi</div>
<nav id="leftnav">
	<ul>
		<li>
			<a href="#pacchiInEntrata" title="Pacchi in Entrata">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="circleBase type1 front pacchiIn active"></div>
					  </div>
					  <div class="back face center">
							<div class="circleBase type1 back pacchiIn active"></div>
					  </div>
					</div>
				</div>
			</a>
		</li>
		<li>
			<a href="#pacchiInUscita" title="Pacchi in uscita">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="circleBase type1 front pacchiOut"></div>
					  </div>
					  <div class="back face center">
							<div class="circleBase type1 back pacchiOut"></div>
					  </div>
					</div>
				</div>
			</a>
		</li>
	</ul>
</nav>
<section id="main">
</section>
<script>
$(document).ready(function(){
	$("nav a").click(function(e){
		e.preventDefault();
		var href=$(this).attr("href").replace("#","");
		href += ".php";
		$("#main").html("<h2>Attendere...</h2>");
		$("#main").load("<?=BUSINESS_HTTP_PATH?>"+href);
	});
});
</script>
</body>
</html>

