<!doctype html>
<html lang="pt-br">

<head>
    <title>Alocar Turmas em Horários de Prova</title>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
		<meta name="viewport" content="width=1024" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
   <link rel="stylesheet" href="src/bootstrap.min.css" />
   <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="src/roboto.css" />
        <link rel="stylesheet" href="src/icon.css" />
        <link rel="stylesheet" href="style/main.css" />
		<link rel="stylesheet" href="style/tests.css" />
    <style>
        .custom-file-input~.custom-file-label::after {
            content: "Buscar Turmas";
        }

        .custom-file-label {
            text-align: left;
        }
    </style>
</head>

<body>
	<?php
		include '../model/conection.php';
		include '../controller/ini_session.php';
		identidade(workspace_name(base64_decode($_GET['q'])));
	?>

    <form enctype="multipart/form-data" action="../model/import_turmas_from_file.php" method="post">
        <div id="dropzone" style="height: 100%; background-color: rgb(185, 246, 202); line-height: 100px; text-align: center; color: white; font-weight: bold">
            <div class="a" id="a">
                <img src="img/excel_logo.png" width="140px" style="margin-top: 0%;" />
                <div class="file-drag" lang="pt-br">
                    <input type="file" class="custom-file-input" id="customFile" name="file" accept=".xlsx" onchange="avalia()" required />
                    <label class="custom-file-label" id="envio-label" for="customFile">Escolha um arquivo com as turmas e seus respectivos alunos.</label>
                    <br>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-dark btn-lg" onclick="gerenciar('<?php echo($_GET['q']); ?>');">
                        <i class="material-icons" style="transform:translateY(-10%);">
                            cancel
                        </i> Cancelar</button>
                    <button type="submit" class="btn btn-light btn-lg" value="Importar Turmas" data-placement="right" data-toggle="tooltip" title="Confirmar envio!" id="inputlg">
                        <i class="material-icons" style="transform:translateY(-10%);">
                            backup
                        </i> Enviar

                    </button>
                </div>
            </div>
    </form>
   <script type="text/javascript" src="src/jquery.js"></script>
   	<script type="text/javascript" src="src/popper.js"></script>
   	<script type="text/javascript" src="src/bootstrap.js"></script>
    <script src="JS/route.js"></script>
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $('.btn-number').click(function(e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function() {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function() {
            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function(e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                (e.keyCode == 65 && e.ctrlKey === true) ||
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        function avalia() {
            var validExts = new Array(".xlsx", ".xls");
            var fileExt = document.getElementById("customFile").value;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if (validExts.indexOf(fileExt) < 0) {
                alert("Tipo inválido de arquivo selecionado, selecione apenas os tipos: " + validExts.toString());
                return false;
            }
            
            document.getElementById("envio-label").innerHTML = document.getElementById("customFile").files[0]["name"];
             return true;
        }

        function checkfile(sender) {
            var validExts = new Array(".xlsx", ".xls");
            var fileExt = sender;
            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
            if (validExts.indexOf(fileExt) < 0) {
                alert("Tipo inválido de arquivo selecionado, selecione apenas os tipos: " + validExts.toString());
                return false;
            } else return true;
        }
        var $zone = $('#dropzone');
        $zone.on('dragover', function(e) {
            document.getElementById("a").style.opacity = '1';
        })
        $zone.on('dragleave', function(e) {
            document.getElementById("a").style.opacity = '1';
        })
        $zone.on('dragover drop', function(e) {
            document.getElementById("a").style.opacity = '0.6';
            e.preventDefault();
        }).on('drop', function(e) {
            document.getElementById("a").style.opacity = '1';
            if (checkfile(e.originalEvent.dataTransfer.files.item(0).name)) {
                console.log(e.originalEvent.dataTransfer.files);
                // alert(e.originalEvent.dataTransfer.files[0]["name"]);
                $('#customFile')[0].files = e.originalEvent.dataTransfer.files;
                document.getElementById("envio-label").innerHTML = e.originalEvent.dataTransfer.files[0]["name"];
            }
            
        });
        
       
    </script>
</body>

</html>
