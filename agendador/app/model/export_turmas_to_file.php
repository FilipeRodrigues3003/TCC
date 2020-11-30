<?php
	include 'conection.php';

	require '../../vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\IOFactory;
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet; //classe responsável pela manipulação da planilha

	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	
    use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
    	 
	 function export_turma_list($turmas, $nome_workspace, $login){
		$spreadsheet = new Spreadsheet();
		$locale = 'pt_br';
		$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
		for($i=0; $i<count($turmas); $i++){
			$spreadsheet->setActiveSheetIndex($i);
			$alunos = alunos_from_turma(id_from_nome_turma($turmas[$i], $nome_workspace, $login));
			
			$spreadsheet->setActiveSheetIndex($i)->setTitle($turmas[$i]);
			$aba = $spreadsheet->getSheet($i);
			
			$aba->setCellValue('A1', 'Nome');
			$aba->setCellValue('B1', 'Matricula');
			for($k=0; $k<count($alunos); $k++){
				$linha = $k+2;
				$a = 'A' . $linha;
				$b = 'B' . $linha;
				
				$aba->setCellValue($a, $alunos[$k][0]);
				$aba->setCellValue($b, $alunos[$k][1]);
			}
			if($i<count($turmas)-1){
				$spreadsheet->createSheet();
			}
		}
		// $sheet->setCellValue('A1', 'Nome');

	/**/
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $nome_workspace . '.xlsx"');
		header('Cache-Control: max-age=0');
	/**/	
		// If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		// header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		 header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header('Pragma: public'); // HTTP/1.0
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); // IOFactory::createWriter($spreadsheet, 'Xlsx');// new Xlsx($spreadsheet);

		$writer->save('php://output');
	 }
	 
	 
	 function export_turma($nome_turma, $nome_workspace, $login){
	 	$spreadsheet = new Spreadsheet();
		
		$i = 0;
		$spreadsheet->setActiveSheetIndex($i);
		$alunos = alunos_from_turma(id_from_nome_turma($nome_turma, $nome_workspace, $login));
		
		$spreadsheet->setActiveSheetIndex($i)->setTitle($nome_turma);
		$aba = $spreadsheet->getActiveSheet();
		
		$aba->setCellValue('A1', 'Nome');
		$aba->setCellValue('B1', 'Matricula');
		for($k=0; $k<count($alunos); $k++){
			$linha = $k+2;
			$a = 'A'.$linha;
			$b = 'B'.$linha;
			
			$aba->setCellValue($a, $alunos[$k][0]);
			$aba->setCellValue($b, $alunos[$k][1]);
		}
		
		// $sheet->setCellValue('A1', 'Nome');
		

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $nome_turma . '.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		 $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');// new Xlsx($spreadsheet);
		
		 $writer->save('php://output');
	 }
	 
	 function export_workspace($nome_workspace, $login){
		$turmas = nome_turmas_from_workspace(id_from_nome_workspace($nome_workspace, $login));
		//var_dump($turmas);
		export_turma_list($turmas, $nome_workspace, $login);
	 }
