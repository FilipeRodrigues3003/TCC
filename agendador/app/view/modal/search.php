
<div class="modal fade " id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog  " id="teste" role="document" > 
	<div class="modal-content  " style="top: 0%; left: 0%; transform: translate(0%, 0%); width: 100%; padding: 0; margin:0;"> 
	  <div class="modal-header  "> 
		<h5 class="modal-title" id="exampleModalLabel">Pesquisa</h5> 
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
		  <span aria-hidden="true">&times;</span> 
		</button> 
	  </div> 
	  <div class="modal-body "> 
	        <p id="res-search">
	        a
	        </p>
	        <script>
	            function testinput(re, tags) {
                  for(i=0;tags.length();i++){
                      if (tags[i].search(re) != -1) {
//                        document.getElementClassName("modal-body").append(tags[i]);
                        console.write(tags[i]);
                      } 
                  }
                }
                var str = document.getElementById("search").value;
                var tags = {
                    "grafo", "turma", "agenda", "aluno"
                };
                testinput(str, tags);
                
                document.getElementByID("res-search").append("a");
       
	        </script>
 			
	  </div> 
	  <div class="modal-footer"> 
		<button type="button" class="btn btn-dark" data-dismiss="modal">Fechar</button> 
	  </div> 
	</div> 
</div>
</div>
