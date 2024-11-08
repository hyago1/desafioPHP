<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<link rel="stylesheet" href="styles/styleCadastro.css">
	<meta charset="UTF-8">
	<title>Cadastros</title>
</head>


<body>
	<a href="/desafiophp/index.php"><button type="submit" class="cadastrar" id="cadastrar" name="enviarAnu">Voltar</button>
</a>
	<form method="POST" action="/desafiophp/cadastro.php">
		<Span>Cadastro de associado</Span>
		<label>Nome</label>
		<input type="text" name="nome" required>
		<br><br>
		<label>Email</label>
		<input type="text" name="email" required>
		<br><br>
		<label>Cpf</label>
		<input type="text" placeholder="###.###.###-##" style="color: black;" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" maxlength="14" required>
		<br><br>
		<label>Data de afiliação</label>
		<input type="date" name="data" required>
		<br><br>
		<button type="submit" class="cadastrar"  name="enviarAsso">Cadastrar</button>
	</form>
	<hr>
	<form method="POST" action="/desafiophp/cadastro.php">
		<Span>Cadastro de anuidade</Span>
		<label>Ano</label>
		<input type="number" name="ano" id="ano" required>
		<br><br>
		<label>valor</label>
		<input type="number" name="valor" id="valor" required>
		<br><br>
		<button type="submit" class="cadastrar" name="enviarAnu">Cadastrar</button>
	</form>






	<?php

require_once './controller/bd.php';
require_once './models/anuidade.php';
require_once './models/associado.php';
require_once './models/checkout.php';
	function  cadastrarAnui($ano, $valor)
	{
		$anuidade = new anuidade($ano, $valor);
		$res = $anuidade->getDataAnuidade('*','=');

		if (pg_num_rows($res) == 0) {
			$insert = $anuidade->insertAnuidade();

			$resAnui = getDataAssociado("select id from associado where ano <= '$ano'");


			//insere na tabela pagamento um novo registro
			if ($insert) {
				if (pg_num_rows($resAnui) > 0) {

					$resAss =  $anuidade->getDataAnuidade("id","=");
					$idAnu = pg_fetch_result($resAss, 0, "id");

					while ($ids = pg_fetch_assoc($resAnui)) {

						$idAsso = $ids["id"];
						insertPagamento("insert into pagamento (id_associado, id_anuidade, pago) values ($idAsso,$idAnu, false )");
						
					}
				}
				//insere na tabela pagamento um novo registro
				

				
				header('Location: /desafiophp/index.php');
			} else {
				echo "<h1>deu errado</h1>";
			}
		} else {

			echo "<h2>Ja existe uma anuidade com este ano</h2>";
		}
	}
	function  cadastrarAssoci($nome, $email, $cpf, $data)
	{
		
		$anoY = date("Y", strtotime($data));
		$anuidade = new anuidade($anoY, null);
		$insert = insertAssociado("insert into associado (nome, email, cpf, datafiliacao, ano) values ('$nome', '$email','$cpf','$data','$anoY')");
		$resAnui=  $anuidade->getDataAnuidade("id",">=");



		if ($insert) {
			if (pg_num_rows($resAnui) > 0) {
				$resAss = getDataAssociado("select id from associado where ano = '$anoY' and cpf = '$cpf'");
				$idAsso = pg_fetch_result($resAss, 0, "id");

				while ($ids = pg_fetch_assoc($resAnui)) {

					$idAnu = $ids["id"];
					//para fazer o teste de anuidades em dia, troque false por true em pago ----------------------				
					$insert = insertPagamento("insert into pagamento (id_associado, id_anuidade, pago) values ($idAsso,$idAnu, false )");
				}
			}

			
			header('Location: /desafiophp/index.php');
		} else {
			echo "<h1>deu errado</h1>";
		}
	}


	if (isset($_POST['enviarAnu'])) {

		$ano = $_POST['ano'];
		$valor = $_POST['valor'];
		cadastrarAnui($ano, $valor);
	}
	if (isset($_POST['enviarAsso'])) {
		echo '<h1>Apertou</h1>';
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$cpf = $_POST['cpf'];
		$data = $_POST['data'];
		cadastrarAssoci($nome, $email, $cpf, $data);
	}



	?>
</body>

</html>