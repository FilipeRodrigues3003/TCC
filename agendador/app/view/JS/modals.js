function modais(){
	var content1 =  $('#areamodal1').load('modal/modal.sobre.html');
	$('#areamodal1').append(content1);
	
	var content2 =  $('#areamodal2').load('modal/modal.contato.html');
	$('#areamodal2').append(content2);
	
	var content3 =  $('#areamodal3').load('modal/modal.robo.html');
	$('#areamodal3').append(content3);
	
	var content5 =  $('#areamodalsearch').load('modal/search.php');
	$('#areamodalsearch').append(content5);
}
modais();
