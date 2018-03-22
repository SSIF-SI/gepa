<h1>Registro</h1>

<table id="registro_view" class="display" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th><?=Registro::ID_PACCO?></th>
			<th><?=Corrieri::CORRIERE?></th>
			<th><?=Registro::CODICE?></th>
			<th><?=Registro::DESTINATARIO?></th>
			<th><?=Registro::DATA_ARRIVO?></th>
			<th><?=Registro::RICEVENTE?></th>
			<th><?=Registro::DATA_CONSEGNA?></th>
			<th><?=Registro::PRIVATO?></th>
			<th><?=Registro::MEPA?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?=Registro::ID_PACCO?></th>
			<th><?=Corrieri::CORRIERE?></th>
			<th><?=Registro::CODICE?></th>
			<th><?=Registro::DESTINATARIO?></th>
			<th><?=Registro::DATA_ARRIVO?></th>
			<th><?=Registro::RICEVENTE?></th>
			<th><?=Registro::DATA_CONSEGNA?></th>
			<th><?=Registro::PRIVATO?></th>
			<th><?=Registro::MEPA?></th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($rows as $row):?>
		<tr>
			<td><?=$row[Registro::ID_PACCO];?></td>
			<td><?=$row[Corrieri::CORRIERE];?></td>
			<td><?=$row[Registro::CODICE];?></td>
			<td><?=Personale::getInstance()->getNominativo($row[Registro::DESTINATARIO]);?></td>
			<td><?=Utils::convertDateFormat($row[Registro::DATA_ARRIVO],DB_DATE_FORMAT,"d/m/Y H:i");?></td>
			<td><?=Personale::getInstance()->getNominativo($row[Registro::RICEVENTE]);?></td>
			<td><?=Utils::convertDateFormat($row[Registro::DATA_CONSEGNA],DB_DATE_FORMAT,"d/m/Y H:i");?></td>
			<td><?=$row[Registro::PRIVATO] ? "Si" : "";?></td>
			<td><?=$row[Registro::MEPA];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<script src="<?=SCRIPTS_PATH?>registro.js"></script>