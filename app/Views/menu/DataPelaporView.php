<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Usuarios Alarmantes</h1>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header bg-green">
							<h3 class="card-title">Tabla de Usuarios</h3>
						</div>
						<div class="card-body">
							<table id="example1" class="table table-striped">
								<thead>
									<tr>
										<th style="width: 10px">No.</th>
										<th>Nombre</th>
										<th>Usuario</th>
										<th>Número de Teléfono</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no = 1;
										foreach ($dataPelapor as $pelapor) { 
										?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $pelapor->namaUser; ?></td>
										<td><?php echo $pelapor->idUser; ?></td>
										<td><?php echo $pelapor->noHP; ?></td>
										<td>
											<div class="btn-group">
												<a href="#" class="btn btn-success" title="Edit" data-toggle="modal" 
													data-target="#modal-edit-<?php echo $pelapor->idUser; ?>"><i class="nav-icon fas fa-edit"></i></button></a>
												<a href="#" class="btn btn-danger" title="Hapus" data-toggle="modal"
													data-target="#modal-delete-<?php echo $pelapor->idUser; ?>"><i class="nav-icon fas fa-trash"></i></button></a>
											</div>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
		<?php
		foreach ($dataPelapor as $pelapor) {?>
		<div class="modal fade" id="modal-edit-<?php echo $pelapor->idUser ?>">
			<div class="modal-dialog modal-default">
				<form action="<?php echo base_url(); ?>/datapelapor/edit" method="post">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Edición de datos</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group row">
								<label for="namaUser" class="col-sm-2 col-form-label">Nombres</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="namaUser" name="namaUser" value="<?php echo $pelapor->namaUser; ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="idUser" class="col-sm-2 col-form-label">Usuario</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="idUser" name="idUser" value="<?php echo $pelapor->idUser; ?>" disabled>
									<input type="hidden" class="form-control" id="idUser" name="idUser" value="<?php echo $pelapor->idUser; ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="noHP" class="col-sm-2 col-form-label">Teléfono</label>
								<div class="col-sm-10">
									<input type="number" class="form-control" id="noHP" name="noHP" value="<?php echo $pelapor->noHP; ?>" min="0" required>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn bg-green">Aceptar</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</form>
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<div class="modal fade" id="modal-delete-<?php echo $pelapor->idUser; ?>">
			<div class="modal-dialog modal-default">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Confirmar la eliminación de datos</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>¿Está seguro de que desea eliminar los datos del usuario?</p>
						<input type="text" class="form-control" id="idUser" name="idUser" hidden>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<a href="<?php echo base_url(); ?>/datapelapor/delete/<?php echo $pelapor->idUser; ?>" class="btn bg-green">Ok</a>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<?php } ?>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
