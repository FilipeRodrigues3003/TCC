import networkx as nx

vertices={...}
cores={...}

def verificaVizinhos(no, cor, Grafo):
    for vizinho in Grafo.neighbors(no):
        corVizinho = Grafo.node[vizinho]['cor']
        if corVizinho == cor:
            return False
    return True

def atribuiCor(no, Grafo):
    for corCandidata in cores:
        if verificaVizinhos(no, corCandidata, Grafo):
            return corCandidata
            
if __name__ == "__main__":            
    Grafo = nx.Graph()
    
    for no in vertices:
        Grafo.add_node(no,cor=' ')
        for i in range(0,len(vertices[no])):
            Grafo.add_edge(no,vertices[no][i])
            
    for no in Grafo.node:
        Grafo.node[no]['cor']=atribuiCor(no, Grafo)
 