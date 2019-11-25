<?php

	session_start();

	$conex1 = pg_connect ("host= 127.0.0.1 port = 5432 dbname = teste user = leonardo password = qwert")
	or die ("Falha na conexão!".pg_last_error());

	$id = '';
	$nome = '';
	$quantidade = '';
	$criado_em = '';
	$atualizado_em= '';
	
	if(isset($_POST['salvar'])){
		$nome = $_POST['nome'];
		$quantidade = $_POST['qtde'];
		$criado_em = date('d/m/Y');

		$query = "INSERT INTO estoque (nome, quantidade, criado_em)
				VALUES ('$nome', '$quantidade', '$criado_em')" or die ("Falha na conexão!".pg_last_error());
		$resultado = pg_exec($conex1, $query);

		$_SESSION['mensagem'] = "Novo produto cadastrado com sucesso!";
		$_SESSION["msg_tipo"] = "success";

		header("location: index.php");
	}

	elseif(isset($_POST['atualizar'])){
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$quantidade = $_POST['quantidade'];
		$criado_em = $_POST['criado_em'];
		$atualizado_em = date('d/m/Y');

		$query = "UPDATE estoque SET nome = '$nome', quantidade = '$quantidade', criado_em = '$criado_em', atualizado_em = '$atualizado_em' WHERE id = $id" or die ("Falha na conexão!".pg_last_error());
		$resultado = pg_exec($conex1, $query);


		$_SESSION['mensagem'] = "Produto atualizado com sucesso!";
		$_SESSION["msg_tipo"] = "success";


		header("location: index.php");
	}

	elseif (isset($_GET['deletar'])){
		$id = $_GET['deletar'];
		$query = "DELETE FROM estoque WHERE id = $id" or die ("Falha na conexão!".pg_last_error());
		$resultado = pg_exec($conex1, $query);

		$_SESSION['mensagem'] = "O produto foi excluido com sucesso!";
		$_SESSION["msg_tipo"] = "danger";
		header("location: index.php");
	}

	elseif(isset($_GET['editar'])){
		$id = $_GET['editar'];
		$query = "SELECT * FROM estoque WHERE id = $id" or die ("Falha na conexão!".pg_last_error());
		$resultado = pg_exec($conex1, $query);
		if(count($resultado) == 1){
			$row = $resultado->pg_fetch_assoc();
			$id = $row['id'];
			$nome = $row['nome'];
			$quantidade = $row['quantidade'];
			$criado_em = $row['criado_em'];
			$atualizado_em = $row['atualizado_em'];
		}

	}

?>