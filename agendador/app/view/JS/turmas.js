var turma = null;
var workspace = null;
var login = null;

function exclui(ev, q) {
	turma = ev.target.id;
}

function ev_workspace(ev, nome) {
	workspace = ev.target.id;
	login = nome;
	console.log(workspace + " de " + login);
}

var modalConfirm = function(callback) {
	$(".btn-confirm").on("click", function() {
		$("#mi-modal").modal("show");
	});
	$("#modal-btn-si").on("click", function() {
		callback(true);
		$("#mi-modal").modal("hide");
	});
	$("#modal-btn-no").on("click", function() {
		callback(false);
		$("#mi-modal").modal("hide");
	});
};
modalConfirm(function(confirm) {
	if (confirm) {
		//Acciones si el usuario confirma
		apagar(turma, q);
		turma = null;
	} else {
		//Acciones si el usuario no confirma
		//  $("#result").html("NO CONFIRMADO");
	}
});

var modalCad = function(callback) {
	$(".btn-cad").on("click", function() {
		$("#cad-modal").modal("show");
	});
	$("#modal-btn-si").on("click", function() {
		callback(true);
		$("#cad-modal").modal("hide");
	});
	$("#modal-btn-no").on("click", function() {
		callback(false);
		$("#cad-modal").modal("hide");
	});
};
modalCad(function(confirm) {
	if (confirm) {
		
	} else {
		
	}
});

var modalExcW = function(callback) {
	$(".btn-confirm-ws").on("click", function() {
	    console.log(workspace + " modalExcW");
		$("#modalExcW").modal("show");
	});
	$(".modal-btn-apaga").on("click", function() {
		callback(true);
		$("#modalExcW").modal("hide");
	});
	$(".modal-btn-cancela").on("click", function() {
		callback(false);
		$("#modalExcW").modal("hide");
	});
};

modalExcW(function(confirm) {
	if (confirm) {
		exclui_workspace(workspace, login);
	} else {
		alert("UFA!");
	}
});

$(function() {
	$('[data-toggle="tooltip"]').tooltip();
});
