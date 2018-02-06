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
</head>
<body>
<div id="title">Gestione pacchi</div>
<nav id="leftnav">
	<ul>
		<li>
			<a id="pacchiInEntrata" href="#pacchiInEntrata" title="Pacchi in Entrata">
				<div class="f1_container">
					<div class="f1_card">
					  <div class="front face">
							<div class="pacchiInEntrata circleBase type1 front pacchiIn"></div>
					  </div>
					  <div class="back face center">
							<div class="pacchiInEntrata circleBase type1 back pacchiIn"></div>
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
							<div class="pacchiInUscita circleBase type1 front pacchiOut"></div>
					  </div>
					  <div class="back face center">
							<div class="pacchiInUscita circleBase type1 back pacchiOut"></div>
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
	</ul>
</nav>
<section id="main">
</section>
<script>
$(document).ready(function(){
	$("nav a").click(function(e){
		e.preventDefault();
		var href=$(this).attr("href").replace("#","");
		$(".circleBase").removeClass("active");
		$("."+href).addClass("active");
		
		href += ".php";
		$("#main").html("<h2>Attendere...</h2>");
		$("#main").load("<?=BUSINESS_HTTP_PATH?>"+href);
		
	});
});
</script>
</body>
</html>

