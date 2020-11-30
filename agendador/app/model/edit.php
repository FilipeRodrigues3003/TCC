 <?php
    $turma = $_GET["turma"];

    $pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");

    try {


        $busca = $pdo->prepare("SELECT matricula FROM turma_aluno JOIN turma JOIN aluno WHERE turma_aluno.id_aluno=aluno.id_aluno AND  nome_turma=:turma AND turma.id_turma=turma_aluno.id_turma AND turma.id_workspace=:id_workspace ORDER BY matricula");
        $busca->bindValue(":turma", $turma);
        $busca->bindValue(":id_workspace", base64_decode($_GET['q']));
        $busca->execute();
        $data = $busca->fetchAll();
        $aluno = $_POST["aluno"];
        $nome = $_POST["nome"];
        
        print_r($nome);
        $fix[] = ""; 
        $add[] = ""; 
        $rem[] = ""; 

        $f = 0;
        $a = 0;
        $r = 0;


        $aluno = array_values(array_filter($aluno));
        $nome = array_values(array_filter($nome));

       // print_r($aluno);
        
        foreach ($data as $row) {

            $err = true;
            $i = 0;

            $id = $row['matricula'];
            
            
           // print_r($id);
            while ($err && $i < count($aluno)) {

                if ($aluno[$i] != $id) {
                    $i++;
                } else {
                    if ($aluno[$i] == $id) {
                        $fix[$f] = $id;
                        $f++;
                    }
                    $err = false;
                }
            }

            if ($i == count($aluno)) {
                $rem[$r] = $id;
                $r++;
            }
        }


        for ($i = 0; $i < count($aluno); $i++) {
            $errFix = false;
            $errRem = false;
            
             print_r($fix);
             echo(' - fix<br/>');
            // print_r($rem);
            // echo(' - rem<br/>');

            for ($f = 0; $f < count($fix); $f++) {
                if ($aluno[$i] == $fix[$f]) {
                    $errFix = true;
                }
            }

            for ($r = 0; $r < count($rem); $r++) {
                if ($aluno[$i] == $rem[$r]) {
                    $errRem = true;
                }
            }
            
            // echo($errFix . ' - errFix<br/>');
            // echo($errRem . ' - errRem<br/>');
           //  echo($aluno[$i] . ' - aluno[$i]<br/>');
            if (!$errFix && !$errRem && $aluno[$i] != "") {
                $add[$a] = $aluno[$i];
                $nome[$add[$a]] = $nome[$i];
                $a++;
            }
        //    echo('<br>');
         //   print_r($nome);
        }


        $find_id_turma = $pdo->prepare("SELECT id_turma FROM turma WHERE nome_turma=:turma AND turma.id_workspace=:id_workspace");
        $find_id_turma->bindValue(":turma", $turma);
        $find_id_turma->bindValue(":id_workspace", base64_decode($_GET['q']));
        $find_id_turma->execute();
        $id_turma = $find_id_turma->fetchAll();

        foreach ($rem as $value) {
            $busca_aluno = $pdo->prepare("SELECT id_aluno FROM aluno WHERE matricula=:matricula");
            $busca_aluno->bindValue(":matricula", $value);
            $busca_aluno->execute();
            $id_aluno = $busca_aluno->fetchAll();

            $apaga = $pdo->prepare("DELETE FROM turma_aluno WHERE id_turma=:id_turma AND id_aluno=:id_aluno");
            $apaga->bindValue(":id_turma", $id_turma[0][0]);
            $apaga->bindValue(":id_aluno", $id_aluno[0][0]);
            $apaga->execute();
        }


        foreach ($add as $value) {
           // echo($value. "matricula");
            $insere_aluno = $pdo->prepare("INSERT IGNORE INTO aluno(matricula, nome_aluno) VALUES(:matricula, :nome)");
            $insere_aluno->bindValue(":matricula", $value);
            $insere_aluno->bindValue(":nome", $nome[$value]);
            $insere_aluno->execute();
            $busca_aluno = $pdo->prepare("SELECT id_aluno FROM aluno WHERE matricula=:matricula");
            $busca_aluno->bindValue(":matricula", $value);
            $busca_aluno->execute();
            $id_aluno = $busca_aluno->fetchAll();
            $relaciona = $pdo->prepare("INSERT INTO turma_aluno(id_turma, id_aluno) VALUES(:id_turma,:id_aluno)");
         //   echo($id_turma[0][0]. "id");
            $relaciona->bindValue(":id_turma", $id_turma[0][0]);
            $relaciona->bindValue(":id_aluno", $id_aluno[0][0]);
            $relaciona->execute();
        }
    } catch (\Throwable $th) {
        throw $th;
        header('Location: ../view/error.html');
    }
  


   header('Location: ../view/turmas.gerenciar.php?q='.$_GET['q']);
   
