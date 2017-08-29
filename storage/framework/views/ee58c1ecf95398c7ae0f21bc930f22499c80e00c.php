<?php $__env->startSection('titulo', 'Categorias'); ?>

<?php $__env->startSection('contenedor'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Categoría de productos</h1>
                    <div class="panel panel-primary">
            <div class="panel-heading">
                Listado de las categorías disponibles
            </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="container">
            		<div class="row">
            			<div class="col-sm-12">
            				<button class="btn btn-primary btn-forms" formulario="insertar_hardware" data-toggle="modal" data-target="#modal_forms">
            					 <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Crear
            				</button>
            			</div>
            		</div>
            	</div>
            	<br>

				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
                        <tr>
                            <th>Denominacón de la categoría</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php foreach($categorias as $categoria): ?>
                            <?php if( $categoria->edo_reg == 1): ?>
                                <tr class="odd gradeX user_field">
                                    <td><?php echo e($categoria->nombre_categoria); ?></td>
                                    <td>
                                        <button class="btn btn-danger usuario-option delete" token="<?php echo e(csrf_token()); ?>" data-id="<?php echo e($categoria->id); ?>" role="DELETE" >
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                       <!-- <button class="btn btn-success btn-forms usuario-option edit" formulario="editar_categoria" data-id="<?php echo e($categoria->id); ?>">
                                            <span class="glyphicon glyphicon-pencil "></span>
                                        </button>-->
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
				</table>

        	</div>

        </div>
         <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->

</div>
<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
<div class="modal fade" id="modal_hardware" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Gestión de usuarios <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <div id="formulario">
                    <form action="" method="post" id="insertar_datos" data-url="guardar">
                        <div class="col-sm-10">
<<<<<<< HEAD
                            <label for="nombre_catergoria">Nombre de la nueva categoría</label>
                            <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control">
=======
                            <label for="nombre_catergoria">Nombre de la nueva categoria</label>
                            <input type="text" onKeyUp="textoYNumero(event, this, 40)" onKeyDown="textoYNumero(event, this, 40)"  name="nombre_categoria" id="nombre_categoria" class="form-control">
>>>>>>> 6980015e514d1685fd039cf8eeda13a228337a82
                             <?php echo e(csrf_field()); ?>

                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <button type="button" class="btn btn-primary block" id="modal-click">Guardar datos</button>
                </div>
            </div>
        </div>

      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('jquery'); ?>
<script src="<?php echo e(asset('js/jquery.dataTables.js')); ?>"></script>
<script src=" <?php echo e(asset('js/dataTables.bootstrap.min.js')); ?> "></script>
<script src="<?php echo e(asset('js/dataTables.responsive.js')); ?>"></script>

<script src="<?php echo e(asset('js/hardware.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>