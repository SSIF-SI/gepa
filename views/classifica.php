<?=classifica($rows['all'],10,"Globale");?>
<?=classifica($rows['week'],3,"Ultimi 7 giorni");?>

<?php 
function classifica($data,$count,$suffix){
?>
<h1>TOP <?=$count." ".$suffix?></h1>

<table id="classifica_view" class="table table-striped">
	<thead>
		<tr>
			<th><?=Registro::DESTINATARIO?></th>
			<th>Totali</th>
		</tr>
	</thead>
	<tbody>
		<?php for($k=0, $pos=0, $n=0; $k<count($data); $k++): $pp=false;$row = $data[$k]; if($n != $row['tot']){ $n = $row['tot']; $pos++; $pp = true;} if($pos > $count) break;?>
		<tr <?php if($k==0) echo 'style="background-color:#ffa"'?>>
			<td><?=($pp?$pos.". ":"<span style='color:transparent'>$pos. </span>").Personale::getInstance()->getNominativo($row[Registro::DESTINATARIO]).($k==0? '&nbsp;&nbsp;<img src="css/images/Crown.png" style="width:24px"/>' : '')?></td>
			<td><?=$row['tot'];?></td>
		</tr>
		<?php endfor;?>
	</tbody>
</table>
<?php 
}
?>

