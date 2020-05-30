<?php 
    if($_SESSION["tipo_sbp"]!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION["tipo_sbp"]);
    }
?>
<div class="container-fluid">
  <div class="page-header">
    <h1 class="text-titles"><i class="zmdi zmdi-book-image zmdi-hc-fw"></i> REPORTES</h1>
  </div>
  <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

  <table class="table table-sm" >
     <tr>
      <th>
        <th class="col-xs-12 col-sm-3"><a href="<?php echo SERVERURL; ?>reportes/reportAdmin.php" target="_blank" onclick="window.open(this.href,this.target);return false;" class="btn btn-info">
          <i class="zmdi zmdi-accounts-list "></i> &nbsp; ADMINISTRADORES </a>
       </th>
       <th class="col-xs-12 col-sm-3"><a href="<?php echo SERVERURL; ?>reportes/reportBook.php" target="_blank" onclick="window.open(this.href,this.target);return false;" class="btn btn-info">
          <i class="zmdi zmdi-book-image"></i> &nbsp; LIBROS </a>
       </th>
       <th class="col-xs-12 col-sm-3"><a href="<?php echo SERVERURL; ?>reportes/reportClient.php" target="_blank" onclick="window.open(this.href,this.target);return false;" class="btn btn-info">
          <i class="zmdi zmdi-male-female zmdi-hc-fw"></i> &nbsp; ESTUDIANTES </a>
       </th>
       <th class="col-xs-12 col-sm-3"><a href="<?php echo SERVERURL; ?>reportes/reportCateg.php" target="_blank" onclick="window.open(this.href,this.target);return false;" class="btn btn-info">
              <i class="zmdi zmdi-labels zmdi-hc-fw"></i> &nbsp; CATEGORIAS </a>
        </th>   
      </th>
    </tr>
  
  </table>
  <br><br><br><br><br><br><br>

