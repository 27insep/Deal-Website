<div id="main_inner"></div>
<script>
	reload_cart();
	function reload_cart()
	{
		$.ajax({
  			type: "POST",
  			url: "/shopping/reload_cart/",
  			cache: false,
  			data: { test: '<?echo $test;?>' }
  		}).done(function( msg ) {
  			$("#main_inner #div").remove();
  			$("#main_inner").html(msg);
  		});
	}
</script>