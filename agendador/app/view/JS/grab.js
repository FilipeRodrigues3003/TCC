// ---------------------------------------------------------------------------------
var turmas = [];
var arr_aux = [];
var dataGraph = new Map();
// Quando o usuário inicia um drag, guardamos no dataset do evento
// o id do objeto sendo arrastado

function dragStart(ev) {
	ev.dataTransfer.setData("ID", ev.target.getAttribute("id"));
}
// Quando o usuário arrasta sobre um dos painéis, retornamos
// false para que o evento não se propague para o navegador, o
// que faria com que o conteúdo fosse selecionado.
function dragOver(ev) {
	return false;
}
// Quando soltamos o elemento sobre um painel, movemos o
// elemento, lendo seu id do dataset do evento
function dragDrop(ev) {
	var idelt = ev.dataTransfer.getData("ID");
	var rm = 0;
	if(ev.target.id == "turmas" || ev.target.id.match(/horario/) == "horario"){
	    ev.target.appendChild(document.getElementById(idelt));
	    
	    if(document.getElementById(idelt).value != undefined){
		    var index = turmas[document.getElementById(idelt).value].indexOf(idelt);
		    if (index > -1) {
			    turmas[document.getElementById(idelt).value].splice(index, 1);
		    }
		    
		    
		    index = arr_aux.indexOf(document.getElementById(idelt).value);
		    if (index > -1) {
			    arr_aux.splice(index, 1);
		    }
		    dataGraph.delete(document.getElementById(idelt).value);
		    
		    if(turmas[document.getElementById(idelt).value].length == 0){
			    delete turmas[document.getElementById(idelt).value];
		    }else{
			    dataGraph.set(document.getElementById(idelt).value, turmas[document.getElementById(idelt).value]);
		    }
	    }
	    
	    if(ev.target.id.match(/horario/)  == "horario"){
		    
		    if (!turmas[ev.target.id]) {
			    turmas[ev.target.id] = new Array();
		    }
		    turmas[ev.target.id].push(idelt);
		    arr_aux.push(ev.target.id);
		    dataGraph.set(ev.target.id, turmas[ev.target.id]);
		    
		    document.getElementById(idelt).value = ev.target.id;
	    }else{
		    document.getElementById(idelt).value = undefined;
	    }
	    
	    
	    if (arr_aux.length <= 0) {
		    var element = document.getElementById("circulo");
		    if (!element.classList.contains("d-none")) {
			    element.classList.add("d-none");
		    }
	    }
	    mostra(turmas, ev.target.id, arr_aux);
	}
}

function compara(arr_a, arr_b) {
	var i = 0;
	for (a of arr_a) {
		for (b of arr_b) {
			if (a == b) {
				//alert(a + " ferrou tudo!");
				i++;
			}
		}
	}
	return i;
}

function combina(arr_a) {
	var i = 0;
	var j = 1;
	var sum = 0;
	var c = 0;

	for (i = 0; i < arr_a.length - 1; i++) {
		for (j = i + 1; j < arr_a.length; j++) {
			c = compara(arr_a[i], arr_a[j]);
			sum = sum + c;
		}
	}
	return sum;
}

function find_duplicates(arr) {
	// alert("PROCURA DUPLICATA");
	var aux = arr;
	var outro = new Array(aux[0]);
	var ele = {};
	var rep = 0;
	for (i = 1; i < aux.length; i++) {
		for (j = 0; j < outro.length; j++) {
			if (outro[j] == aux[i]) {
				rep++;
			}
		}
		if (rep == 0) {
			outro.push(aux[i]);
		}
		rep = 0;
	}
	return outro;
}

function pior(tur, arr_aux) {
	var i = 0;
	var aux = new Array();
	//  alert("PIOR");
	for (a of arr_aux) {
		// Todos os horarios de prova
		//alert(a)
		for (t of tur[a]) {
			// Todas as turmas T no horario A

			aux[i] = document
				.getElementById(t)
				.getAttribute("data-value")
				.split(":");
			i++;
		}
	}
	return combina(aux);
}

function limpa(){
	cy.remove(cy.nodes());
	cy.remove(cy.edges());
}


function mostra(tur, dest, arr_aux) {
	// alert(tur + " no " + dest);
	
	if(arr_aux.length > 0){
	
	
	var i = 0;
	//  alert("ENTROU NO MOSTRA");
	var total = 0;
	// alert(arr_aux);
	arr_aux = find_duplicates(arr_aux);
	//alert(arr_aux);

	for (a of arr_aux) {
		//alert(a)
		var aux = new Array();

		tur[a] = find_duplicates(tur[a]);
		if (tur[a].length > 1) {
			// alert("AS turmas: " + tur[a] + " estoa em " + a);
			for (t of tur[a]) {
				// Split tur pela virgula
				//alert(tur[a]);

				//alert("i = " + i + " em " + t + " no " + a);
				aux[i] = document
					.getElementById(t)
					.getAttribute("data-value")
					.split(":");
				//alert(aux[i] + " estão no " + a);
				i++;
				// alert(" i = "+ i);
				//alert("ENTROU NO IF TUR");
			}
			total = total + combina(aux);
		}
		i = 0;
		// alert(combina(aux) + " iguais em " + a);
	}

	var p = pior(tur, arr_aux);
	if (p > 0) {
		var indice = Math.round((total / p) * 100);
	} else {
		var indice = 0;
	}

	//alert(total + " com pior " + p);

	resultado(total, p);
	var element = document.getElementById("circulo");
	if (element.classList.contains("d-none")) {
		element.classList.remove("d-none");
	}
	$("#inters-s").val(total);
	$("#inters-t").val(indice + "%");
	// document.getElementById("progress-bar").innerHTML =
	// indice + "% dos alunos que estão em mais de uma turma farão segunda chamada!";
	document.getElementById("progress-bar").style.width = indice + "%";
	if (indice < 25) {
		//border: 3px solid
		document.getElementById("icon").innerHTML = "sentiment_very_satisfied";
		document.getElementById("i-s").style.color = "#FFFFFF"; //"#00C853"; // Verde
		document.getElementById("inters-s").style.color = "#FFFFFF"; //"#00C853"; // Verde
		document.getElementById("i-t").style.color =  "#00C853"; // Verde
		document.getElementById("inters-t").style.color =  "#00C853"; // Verde
		document.getElementById("circulo").style.border = "3px solid #00C853"; // Verde
		document.getElementById("circulo").style.background = "#00C853"; // Verde
		document.getElementById("progress-bar").style.background = "#00C853";
		document.getElementById("semi-circulo").style.background = "#FFFFFF";
		//width:40%
	} else if (indice < 50) {
		document.getElementById("icon").innerHTML = "sentiment_satisfied";
		document.getElementById("inters-s").style.color = "#FFFFFF"; //"#FDD835"; // Amarelo
		document.getElementById("i-s").style.color = "#FFFFFF"; //"#FDD835";
		document.getElementById("inters-t").style.color = "#FDD835"; // Amarelo
		document.getElementById("i-t").style.color = "#FDD835";
		document.getElementById("circulo").style.border = "3px solid #FDD835"; // Amarelo
		document.getElementById("circulo").style.background = "#FDD835"; // Amarelo
		document.getElementById("progress-bar").style.background = "#FDD835";
		document.getElementById("semi-circulo").style.background = "#FFFFFF";
	} else if (indice < 75) {
		document.getElementById("icon").innerHTML = "sentiment_dissatisfied";
		document.getElementById("inters-s").style.color = "#FFFFFF"; //"#ff6100"; // Laranja
		document.getElementById("i-s").style.color = "#FFFFFF"; //"#ff6100";
		document.getElementById("inters-t").style.color =  "#ff6100"; // Laranja
		document.getElementById("i-t").style.color = "#ff6100";
		document.getElementById("circulo").style.border = "3px solid #ff6100"; // Laranja
		document.getElementById("circulo").style.background = "#ff6100"; // Laranja
		document.getElementById("progress-bar").style.background = "#ff6100";
		document.getElementById("semi-circulo").style.background = "#FFFFFF";
	} else {
		document.getElementById("icon").innerHTML = "sentiment_very_dissatisfied";
		document.getElementById("inters-s").style.color = "#FFFFFF"; // "#e80000"; // Vermelho
		document.getElementById("i-s").style.color = "#FFFFFF"; //"#e80000";
		document.getElementById("inters-t").style.color =   "#e80000"; // Vermelho
		document.getElementById("i-t").style.color =  "#e80000";
		document.getElementById("circulo").style.border = "3px solid #e80000"; // Vermelho
		document.getElementById("circulo").style.background = "#e80000"; // Vermelho
		document.getElementById("semi-circulo").style.background = "#FFFFFF";
		document.getElementById("progress-bar").style.background = "#e80000";
	}
	}else{
		limpa();
	}
	// alert("ATUALIZOU O CIRCULO");
}

function resultado(total, pior) {
	var obj = "";
	for (var [key, value] of dataGraph) {
		obj = obj + key + ":" + value + ";";
	}
	// document.getElementById("graph").innerHTML = obj;
	$("#graph").val(obj);
	var obj2 = total + " ; " + pior;
	$("#infos").val(obj2);

	var cores = [
		"#F44336",
		"#2196F3",
		"#4CAF50",
		"#FFEB3B",
		"#9C27B0",
		"#3E2723",
		"#E91E63",
		"#01579B",
		"#B71C1C",
		"#CDDC39",
		"#00E5FF",
		"#8BC34A",
		"#FF9800",
		"#673AB7",
		"#009688",
		"#FFC107",
		"#FF5722",
		"#2962FF",
		"#1B5E20",
		"#AA00FF",
		"#76FF03",
		"#BF360C",
		"#F48FB1",
		"#E6EE9C",
		"#9FA8DA",
		"#33691E",
		"#FFCC80",
		"#80CBC4",
		"#000000",
		"#FFFF00"
	];
	var cursos = [];
	var cores_t = [];
	var aux = new Array();

	for (var [key, value] of dataGraph) {
		for (j = 0; j < value.length; j++) {
			cursos.push(value[j]);
		}
		for (var turma of value) {
			cores_t[turma] = cores[key.substr(-1) - 1];
		}
	}

	cy.remove(cy.nodes());
	cy.remove(cy.edges());
	for (var turma of cursos) {
		cy.add({
			group: "nodes",
			data: {
				id: turma,
				color: cores_t[turma],
				weight: 1
			}
		});
	}
	for (j = 0; j < cursos.length - 1; j++) {
		for (k = j + 1; k < cursos.length; k++) {
			var cor = "#ccc";
			var sum = 0;
			aux[0] = document
				.getElementById(cursos[j])
				.getAttribute("data-value")
				.split(":");
			aux[1] = document
				.getElementById(cursos[k])
				.getAttribute("data-value")
				.split(":");
			sum = compara(aux[0], aux[1]);

			if (sum > 0) {
				if (cores_t[cursos[j]] == cores_t[cursos[k]]) {
					cor = cores_t[cursos[j]];
					
				}
				var str = cursos[j] + "-" + cursos[k];
				cy.add({
					group: "edges",
					data: {
						id: str,
						source: cursos[j],
						target: cursos[k],
						color: cor,
						label: sum
					}
				});
			}
		}
	}
	var layout = cy.layout({
		name: "circle",
		//radius: 120,
		radius: 110,
		animate: false,
		//animationDuration: 10,
		animationThreshold: 250,
		refresh: 20,
		fit: true,
		 nodeRepulsion: function(node) {
    return 400000;
  },
  gravity: 80,
  minTemp: 1.0,
  initialTemp: 200,
		sort: function(a, b) {
			return a.data("weight") - b.data("weight");
		},
		center: {
        eles: cy.filter('#123')
    },
		padding: 30
	});

	 layout.run();
	//layout.update();
}

/*

elements: [ // list of graph elements to start with
			
				{ 
					data: 
					{ 
						id: '', 
						color: ''
					} 
				},
			
			for ($i = 0; $i < count($cursos) - 1; $i++) {
				for ($j = $i + 1; $j < count($cursos); $j++) {
					if ($matrix[$i][$j] != 0) {
						$cor = '#ccc';
						if ($cores_t[$cursos[$i]] == $cores_t[$cursos[$j]]) {
							$cor = 'red';
						}
						{ data: { id: '" . $cursos[$i] . "-" . $cursos[$j] . "', source: '" . $cursos[$i] . "', target: '" . $cursos[$j] . "', color: '" . $cor . "', label: '" . $matrix[$i][$j] . "'} },
					}
				}
			}

			

			 { // node a
				data: { id: 'a'}
			}, { // node b  
				data: { id: 'b' }
			}, { // edge ab
				data: { id: 'ab', source: 'a', target: 'b'}
			}
		],

		style: [ // the stylesheet for the graph
			{
				selector: 'node',
				style: {
					'background-color': 'data(color)', // '#666',
					'label': 'data(id)'
				}
			},

			{
				selector: 'edge',
				style: {
					'width': 3,
					'line-color': 'data(color)', // '#ccc',
					'target-arrow-color': '#ccc',
					'target-arrow-shape': 'triangle',
					'label': 'data(label)'
				}
			}
		],

*/
