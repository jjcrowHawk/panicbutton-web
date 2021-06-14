
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BeSafe - Log de Alarmas</title>
    <style>
        p {
            font-family: Arial, Helvetica, sans-serif;
        }
        h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 16pt;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
        }
        .table th {
            font-weight: bold;
            padding: 8px 8px;
            border:1px solid #000000;
            text-align: center;
        }
        .table td {
            padding: 3px 3px;
            border:1px solid #000000;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">
        <h1>Informe de Registro de Alarmas - BeSafe </h1>
        <br>
        <p>Fecha de Generación : <?= date('d/m/Y H:i:s'); ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tipo de Informe</th>
					<th>Alertante</th>
					<th>Número de Teléfono</th>
					<th>Coordenadas (Lat/Lon)</th>
					<th>Hora del informe</th>
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
    </section>
</body>
</html>