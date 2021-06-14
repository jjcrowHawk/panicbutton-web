<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Log de Alarmas</h1>
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
							<h3 class="card-title">Tabla de Log de Alarmas</h3>
						</div>
						<div class="card-body">
							<a href="<?php echo base_url()?>/logalarm/laporan" class="btn btn-default bg-green" target="_blank">
							Imprimir Informe de Registro de Alarmas
							</a>
							<div class="card-body">
								<table id="example1" class="table table-striped">
									<thead>
										<tr>
											<th style="width: 10px">No</th>
											<th>Tipo de Informe</th>
											<th>Alarmante</th>
											<th>Número de Teléfono</th>
											<th>Coordenadas (Lat/Lon)</th>
											<th>Hora de Informe</th>
											<th>Estado</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($dataLogAlarm as $logAlarm) { 
										?>
										<tr>
											<td><?php echo $no++ ?></td>
											<td><?php echo $logAlarm->jenis ?></td>
											<td><?php echo $logAlarm->namaUser ?></td>
											<td><?php echo $logAlarm->noHP ?></td>
											<td><?php echo $logAlarm->latitude ?>, <?php echo $logAlarm->longitude ?></td>
											<td><?php echo $logAlarm->waktu ?></td>
											<td><?php echo $logAlarm->statusAlarm ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
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
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
