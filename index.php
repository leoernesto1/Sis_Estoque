<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema de Gestão de Estoque</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



</head>


<script>
$(document).ready(function(){
  $(document).on('click', '.edit', function(){
    var row=$(this).parent().parent().children();
 
    $('#myModal_1').modal('show');
    $('#id').val($(row[0]).text());
    $('#id_1').val($(row[0]).text());
    $('#nome').val($(row[1]).text());
    $('#quantidade').val($(row[2]).text());
    $('#criado_em').val($(row[3]).text());

  });
});
</script>


<body>
  <?php require_once 'processo.php'; ?>

  <?php
    if(isset($_SESSION['mensagem'])):
  ?>
    <div class="alert alert-<?=$_SESSION['msg_tipo']?>">
    <?php
      echo $_SESSION['mensagem'];
      unset($_SESSION['mensagem']); 
    ?>
    </div>
  <?php endif?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Sistema de Gestão de Estoque</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <div class="container">
  <?php 
    $conex1 = pg_connect ("host= 127.0.0.1 port = 5432 dbname = teste user = leonardo password = qwert")
    or die ("Falha na conexão!".pg_last_error()); 
    $query = "SELECT * FROM estoque" or die ("Falha na conexão!".pg_last_error());
    $resultado = pg_exec($conex1, $query); 
?>

    <div class = "row justify-content-center">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Data de Inserção </th>
            <th>Data da Atualização</th>
            <th colspan="2">Opções</th>
          </tr>
        </thead>
    <?php 
        while($row = pg_fetch_assoc($resultado)): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nome']; ?></td>
            <td><?php echo $row['quantidade']; ?></td>
            <td><?php echo tranforma($row['criado_em']); ?></td>
            <td><?php echo tranforma($row['atualizado_em']); ?></td>
            <td>
              <input  type="button" class="btn btn-info edit" value="Editar" />
              <a href="processo.php?deletar=<?php echo $row['id']; ?>" class="btn btn-danger">Deletar</a>
            </td>
          </tr>
        <?php endwhile;?>

      </table>
    </div>
    </div>





  <?php 
    function pre_r( $array ){
      echo '<pre>';
      print_r($array);
      echo '<pre>';
    }; ?>


  <?php
    function tranforma( $data ){
      if(empty($data)){
        return $data;
      }else{
        return date("d/m/Y", strtotime($data));
      }
    }
  ?>




  <div class="container">
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Inserir Produto</button>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
           <div class = "row justify-content-center">
              <form action = "processo.php" method="POST">
                <div class = "form-group">
                <label> Nome do Produto</label>
                <input type="text" name="nome" class="form-control">
                </div>
                <div class = "form-group">
                <label> Quantidade </label>
                <input type="number" name="qtde" class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary" name="salvar"> Salvar </button>
                </div>
              </form>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="myModal_1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
           <div class = "row justify-content-center">
              

              <form action = "processo.php" method="POST">
                 <div class = "form-group">
                <label> ID do Produto</label>
                <input type="integer" name="id_1"  id="id_1" class="form-control" disabled="disabled">
                <input type="hidden" name="id"  id="id" class="form-control">
                </div>
                <div class = "form-group">
                <label> Nome do Produto</label>
                <input type="text" name="nome" id="nome"  class="form-control">
                </div>
                <div class = "form-group">
                <label> Quantidade </label>
                <input type="number" name="quantidade" id="quantidade" class="form-control">
                </div>
                <div class = "form-group">
                <label> Data de Criação </label>
                <input type="text" name="criado_em" id="criado_em" class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-warning" name="atualizar"> Atualizar </button>
                </div>
              </form>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
      </div>
      
    </div>
  </div>
  
  




 

</body>

</html>
