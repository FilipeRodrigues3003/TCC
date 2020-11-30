<!doctype html>
<html lang="pt-br">

<head>
    <title>Adicionar Nova Turma</title>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <link rel="stylesheet" href="../view/style/main.css">
</head>

<body>
    <div class="center-loading">
        <div class="spinner-border text-primary m-5" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php
    
    include 'conection.php';

    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory; //classe responsável pelo load dos arquivos de planilha

    use PhpOffice\PhpSpreadsheet\Spreadsheet; //classe responsável pela manipulação da planilha


    use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

	session_start();
    function readData($arquivo)
    {
    	
    	
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");

        $spreadsheet = $reader->load($arquivo);

        //$sheet = $spreadsheet->getActiveSheet();
        $sheet_count = $spreadsheet->getSheetCount();
        $loadedSheetNames = $spreadsheet->getSheetNames();
        $pdo = conect();


        //Coluna - Retira o título(2)
        for ($i = 0; $i < $sheet_count; $i++) {
            $sheet = $spreadsheet->getSheet($i);
			
            $insere_turma = $pdo->prepare("INSERT INTO turma(nome_turma, id_workspace) VALUES(:turma, :workspace)");
            $insere_turma->bindValue(":turma", $loadedSheetNames[$i]);
            $insere_turma->bindValue(":workspace", id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
            $insere_turma->execute();
            
            $busca_turma = $pdo->prepare("SELECT id_turma FROM turma WHERE nome_turma=:turma AND id_workspace=:workspace");
            $busca_turma->bindValue(":turma", $loadedSheetNames[$i]);
            $busca_turma->bindValue(":workspace", id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
            $busca_turma->execute();
            
            $id_turma = $busca_turma->fetchAll();
            $cellA = "";
			// $cellA1 = $sheet->getCell('A1')->getValue(); 
			$k=0; 
			do{
				$a = 'A' . ($k + 2);
				$b = 'B' . ($k + 2);
				
				$cellA = $sheet->getCell($a)->getValue(); // Nome
				$cellB = $sheet->getCell($b)->getValue(); // Matricula
				$turmas_alunos[$loadedSheetNames[$i]][$k] = $cellB;
				if($cellA != "" && $cellB != ""){
					$insere_aluno = $pdo->prepare("INSERT IGNORE INTO aluno(matricula, nome_aluno) VALUES(:matricula, :nome)");
		            $insere_aluno->bindValue(":matricula", $cellB);
		            $insere_aluno->bindValue(":nome", $cellA);
		            $insere_aluno->execute();
		            $busca_aluno = $pdo->prepare("SELECT id_aluno FROM aluno WHERE matricula=:matricula");
		            $busca_aluno->bindValue(":matricula", $cellB);
		            $busca_aluno->execute();
		            $id_aluno = $busca_aluno->fetchAll(0);
		            
		            //if($id_aluno[0][0]>0){
			        $relaciona = $pdo->prepare("INSERT INTO turma_aluno(id_turma, id_aluno) VALUES(:id_turma,:id_aluno)");
			        $relaciona->bindValue(":id_turma", $id_turma[0][0]);
			        $relaciona->bindValue(":id_aluno", $id_aluno[0][0]);
			        $relaciona->execute();
               }
               $k++;
			}while($sheet->getCell('A' . ($k + 2))->getValue() != "");



           /* foreach ($sheet->getRowIterator(2) as $row) {
                $cellInterator = $row->getCellIterator();
                $cellInterator->setIterateOnlyExistingCells(false);
                $j++;
                foreach ($cellInterator as $cell) {
                    if (!is_null($cell) && $cell != "") {
                        $value = $cell->getCalculatedValue();
                        $turmas_alunos[$loadedSheetNames[$i]][$j] = $value;

                        $insere_aluno = $pdo->prepare("INSERT IGNORE INTO aluno(matricula) VALUES(:matricula)");
                        $insere_aluno->bindValue(":matricula", $value);
                        $insere_aluno->execute();
                        $busca_aluno = $pdo->prepare("SELECT id_aluno FROM aluno WHERE matricula=:matricula");
                        $busca_aluno->bindValue(":matricula", $value);
                        $busca_aluno->execute();
                        $id_aluno = $busca_aluno->fetchAll();
                        $relaciona = $pdo->prepare("INSERT INTO turma_aluno(id_turma, id_aluno) VALUES(:id_turma,:id_aluno)");
                        $relaciona->bindValue(":id_turma", $id_turma[0][0]);
                        $relaciona->bindValue(":id_aluno", $id_aluno[0][0]);
                        $relaciona->execute();
                    }
                }
            }*/
            // $str = implode(':', $turmas_alunos[$loadedSheetNames[$i]]);





            /*echo ('<div class="drag btn-group" id="' . $loadedSheetNames[$i] . '" draggable="true" ondragstart="return dragStart(event)" data-value="' . $str . '"><i class="material-icons" style="float: left; margin-top: 12px;">drag_indicator</i>' . $loadedSheetNames[$i] . '</div>');
         echo ('<table border="1" cellpadding="8" style="margin-left:100px;">');
        foreach ($sheet->getRowIterator(2) as $row) {
            $cellInterator = $row->getCellIterator();
            $cellInterator->setIterateOnlyExistingCells(false);

            echo ('<tr>');
            //Linha
            foreach ($cellInterator as $cell) {
                if (!is_null($cell)) {
                    $value = $cell->getCalculatedValue();
                    echo ('<td>' . $value . '</td>');
                }
            }
            echo ('</tr>');
        }
        echo ("</table>");*/
        }
        return $turmas_alunos;
    }

    $dados = $_FILES['file'];

    //var_dump($dados);
    $turmas_alunos[] = array();

    $route = $_FILES['file']['tmp_name'];
    try {
        $turmas_alunos = readData($route);
        //$route = 'spreadsheet1.xlsx';
    } catch (\Throwable $th) {
        throw $th;
        header('Location: ../view/error.html');
    }
    header('Location: ../view/home.php?q=' . base64_encode($_SESSION['workspace']));
    ?>
</body>

</html>
