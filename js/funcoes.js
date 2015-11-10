function mudaClasseMenuAtivado() {
	var path = window.location.href.split('/');
	/*console.log(window.location.href);
	console.log(path);
	console.log(path.length);
	console.log(path[path.length-1]);*/
	var path_fim = path[path.length-1];
	//console.log($("a[href='"+path_fim+"']").parent());
	$("a[href='"+path_fim+"']").parent().toggleClass("active");
	

}

$( document ).ready(function() {
	mudaClasseMenuAtivado();
	numeral.language('pt-br');
	
	var img = $("<img />").attr('src', './img/ajax-loader.gif').attr('style','margin: 0px 50%;');
	$.ajax({
					url: "./include/cliente_aviso.php",
					type: "POST",
					data: '',
					beforeSend: function(){
						$("#hist_cliente").html("");
						$("#hist_cliente").append(img)
					},
					complete: function(){
						//$("#hist_cliente").append(img);
					},
					success:function(result){
						$("#div-navbar").append(result);
					}
					}).done(function(result) {
						//alert(result);
					});
});