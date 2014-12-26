function mudaClasseMenuAtivado() {
	var path = window.location.href.split('/');
	console.log(window.location.href);
	console.log(path);
	console.log(path.length);
	console.log(path[path.length-1]);
	var path_fim = path[path.length-1];
	console.log($("a[href='"+path_fim+"']").parent());
	$("a[href='"+path_fim+"']").parent().toggleClass("active");
	

}

$( document ).ready(function() {
mudaClasseMenuAtivado();
numeral.language('pt-br');
});