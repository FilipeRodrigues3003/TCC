int verificaVizinhos(int cor, int** G, int n, int v){
	int i, soma = 0;
	
	for(i=0;i<n;i++){
	    if(cor[i] == cor && i != v){
    		soma += G[i][v];
		}
	}
	return soma;
}

int coloriVertice(int** G, int cores[], int v, int w, 
                    int k, int n){
    
    int cor, soma, min_cor, min_soma = G[v][w];
    
    if(cor[v]==-1){
        for(cor=0;cor<k;cor++){
            soma = verificaVizinhos(cor, G, n, v);
            if(soma==0){
                cores[v] = cor;
                return 0;
            }else{
                if(min_soma >= soma){
                    min_cor = cor;
                }
            }
        }
        cores[v] = min_cor;
        return 1;
    } 
    return -1;
}

int somaConflitos(int cores[], int** G, int n){
	int soma = 0, i, j;
	
	for(i=0;i<n-1;i++){
		for(j=i+1;j<n;j++){
			if(cores[i] == cores[j]){
				soma += G[i][j];
			}
		}
	}
	return soma;
}

int buscaAresta(int** G, int cores[], int k, int n){
    int v, w, result_v, result_w, maior_aresta = 0;
    int cont = 0;
    
    for(i=0;i<n-1;i++){
        for{j=i+1;j<n;j++){
            if(G[i][j] > maior_aresta && cores[i]==-1 
                || cores[j]==-1){
                maior_aresta = G[i][j];
                v = i;
                w = j;
            }
        }
    }
    
    result_v = coloriVertice(G, cores, v, w, k, n);
    result_w = coloriVertice(G, cores, w, v, k, n);
    
    for(i=0;i<n;i++){
        if(cores[i]==-1){
            cont++;
        }
    }
    if(cont>0){
        return buscaAresta(G, cores, k, n);
    }
    return somaConflitos(cores, G, n);
}
