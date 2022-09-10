<?php

require_once("header.php");

?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                          <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()"
                          data-toggle="modal" data-target="#usuarioModal" >
                            <i class="fa fa-plus" arial-hidden="true"></i> Nuevo Usuario</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                      <table id="usuario_data" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Cedula</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Cargo</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Direccion</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th width="100%">Editar</th>
                            <th width="100%">Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>

                    </div>

                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php

  require_once("footer.php");
?>

<script type="text/javascript" src="js/usuarios.js"></script>
