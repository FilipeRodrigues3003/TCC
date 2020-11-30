function home(end){
	window.location.href = "home.php?q=" + end;
}

function criar(q) {
	window.location.href = "turmas.cadastrar.php?q=" + q;
}

function ver(turma, q) {
	window.location.href = "turmas.exibir.php?turma=" + turma + "&q=" + q;
}

function editar(turma, q) {
	window.location.href = "turmas.editar.php?turma=" + turma + "&q=" + q;
}

function apagar(turma, q) {
	window.location.href = "../model/turmas.remover.php?turma=" + turma + "&q=" + q;
}

function exclui_workspace(workspace, login) {
	window.location.href = "../model/exclui_workspace.php?w=" + workspace + "&u=" + login;
}


function gerenciar(end) {
	window.location.href = "turmas.gerenciar.php?q=" + end;
}

function alocar(q) {
	window.location.href = "workspace.php?q=" + q;
}

function importar(q) {
	window.location.href = "turmas.importar.php?q=" + q;
}

function atualizar(q) {
	window.location.href = "turmas.atualizar.php?q=";
}

function robo(q) {
	window.location.href = "resultado.php?q=" + q;
}

function dashboard() {
	window.location.href = "dashboard.php";
}

function export_planilha(q){
	window.location.href = "../controller/salvar.php?q=" + q;
}

function exit(){
	window.location.href = "../controller/exit.php";
}

function view_cadastro(){
	window.location.href = "cadastro_usuario.php";
}

function view_login(){
	window.location.href = "login.php";
}


// -------------------------------------------------------------------
function search_p(word){
	window.open("https://pt.wikipedia.org/wiki/" + word, "Wikipédia", "height=550,width=1100,left="+(window.innerWidth-1100)/2 +", top="+(window.innerHeight-550)/2);
	//alert('Esta funcionalidade está em desenvolvimento no momento!');
}



function sobre_robo(){
	$('#roboModal').modal('show');
	//alert('Esta funcionalidade está em desenvolvimento no momento!');
}

function save_some(q){
	alert('Esta funcionalidade está em desenvolvimento no momento!');
}

function contato(){
 	$('#contatoModal').modal('show');
	//alert('Esta funcionalidade está em desenvolvimento no momento!');
}

function info(){
	$('#sobreModal').modal('show');
	// alert('Esta funcionalidade está em desenvolvimento no momento!');
}

function closemodal(id){
	$('body').removeClass('modal-open');
	$('.modal-backdrop').remove();
	$('#sobreModal').modal().hide();
	$('.modal').modal().hide();
	$(id).remove();
}


