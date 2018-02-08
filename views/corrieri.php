<h1>Gestione Corrieri</h1>

<button class="new btn btn-success"><i class="fa fa-plus"> </i> Nuovo corriere</button>
<table id="corrieri_view" class="table table-striped">
	<thead>
		<tr>
			<th><?=Corrieri::ID_CORRIERE?></th>
			<th><?=Corrieri::CORRIERE?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($rows as $row):?>
		<tr id="<?=$row[Corrieri::ID_CORRIERE];?>">
			<td><?=$row[Corrieri::ID_CORRIERE];?></td>
			<td class="corriere"><?=$row[Corrieri::CORRIERE];?></td>
			<td class="action-buttons">
				<button type="button" class="edit btn btn-primary"><i class="fa fa-edit"> </i> Modifica</button>
				<button type="button" class="delete btn btn-danger"><i class="fa fa-trash-alt"> </i> Elimina</button>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<script>
$(document).ready(function(){
	refreshButtons();
	
	function refreshButtons(){
		$(".edit,.delete,.new").unbind();
		
		$(".delete").click(function(e){
			var id = $(this).parent().parent().attr("id");
			var corriere =$("#"+id+" .corriere").first().html();
			BootstrapDialog.show({
	            title: '<i class="fa fa-info"> </i> Conferma',
	            message: 'Sei sicuro di voler eliminare il corriere '+corriere+"?",
	            buttons: [
	                {
		            	label: '<i class="fa fa-check"> </i> Ok',
		                // no title as it is optional
		                cssClass: 'btn-success',
		                action: function(dialog){
		                	$.ajax({
		     		           type: "POST",
		     		           url: "?action=deleteCorriere",
		     		           data: {idCorriere: id},
		     				   dataType: "json",
		     		           success: function(data)
		     		           {
		     		        	   if(!data.errors){
		     		        		  $("#"+id).remove();
		     		        		   new BootstrapDialog()
		     						 	.setTitle('<i class="fa fa-info"> </i> Informazione')
		     				            .setMessage("Corriere eliminato")
		     				            .setType(BootstrapDialog.TYPE_SUCCESS)
		     				            .onHide(function(dialogRef){
	  	     				            	dialog.close();	
			     				           
		     	            			})
		     	            			.open();	
		     		               } else {
		     		            	   new BootstrapDialog()
		     						 	.setTitle("<i class='fa fa-exclamation-triangle'> </i> Errore durante l'operazione")
		     				            .setMessage(data.errors)
		     				            .setType(BootstrapDialog.TYPE_DANGER)
		     				            .open();
		     		               }
		     		           },		          
		     		           error: function(){ 
		     		        	   new BootstrapDialog()
		     					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
		     			            .setMessage("Errore di connessione")
		     			            .setType(BootstrapDialog.TYPE_DANGER)
		     			            .open();
		     			       }
		     		         });
		                }
	            	},
	                {
		                label: '<i class="fa fa-times"> </i> Annulla',
		                // no title as it is optional
		                cssClass: 'btn-danger',
		                action: function(dialogItself){
		                    dialogItself.close();
		                }
	                }
	            ]
	        });
		});
	
		$(".edit").click(function(e){
			var id = $(this).parent().parent().attr("id");
			displayForm($(this).html(),id);
		});

		$(".new").click(function(e){
			displayForm($(this).html(), null);
		});
			
	}
	
	function displayForm(title, id){
		BootstrapDialog.show({
			title: title,
            message: $('<div></div>').load('?action=editCorriere&idCorriere='+id),
            buttons: [
                      {
      	            	label: '<i class="fa fa-save"> </i> Salva',
      	                // no title as it is optional
      	                cssClass: 'btn-success',
      	                action: function(dialog){
      	                	$.ajax({
      	     		           type: "POST",
      	     		           url: "?action=editCorriere",
      	     		           data: $('form').first().serialize(),
      	     				   dataType: "json",
      	     		           success: function(data)
      	     		           {
      	     		        	   if(!data.errors){
      	     		        			var corriere = $("#corriere").val();
									
	      	     		        		if(id != null){
		     				            	$("#"+id+" .corriere").first().html(corriere);
		     				            } else {
			     				            var newId = data.otherData.lastInsertId;
			     				            var html = ''+ 
				     				            '<tr id="'+newId+'">'+
				     							'   <td>'+newId+'</td>' +
				     							'   <td class="corriere">'+corriere+'</td>'+
				     							'   <td class="action-buttons">'+
				     							'	   <button type="button" class="edit btn btn-primary"><i class="fa fa-edit"> </i> Modifica</button>'+
				     							'	   <button type="button" class="delete btn btn-danger"><i class="fa fa-trash-alt"> </i> Elimina</button>'+
				     							'   </td>'+
			     								'</tr>';
			     							$("#corrieri_view").append(html);
			     							refreshButtons();
		     				            }
	  	     				           new BootstrapDialog()
      	     						 	.setTitle('<i class="fa fa-info"> </i> Informazione')
      	     				            .setMessage("Salvataggio avvenuto con successo")
      	     				            .setType(BootstrapDialog.TYPE_SUCCESS)
      	     				            .onHide(function(dialogRef){
      	     				            	dialog.close();	
      	     				            	
          	     				            
      	     	            			})
      	     	            			.open();
     	     	            			
      	     		               } else {
      	     		            	   new BootstrapDialog()
      	     						 	.setTitle("<i class='fa fa-exclamation-triangle'> </i> Errore durante l'operazione")
      	     				            .setMessage(data.errors)
      	     				            .setType(BootstrapDialog.TYPE_DANGER)
      	     				            .open();
      	     		               }
      	     		           },		          
      	     		           error: function(){ 
      	     		        	   new BootstrapDialog()
      	     					 	.setTitle('<i class="fa fa-exclamation-triangle"> </i> Attenzione')
      	     			            .setMessage("Errore di connessione")
      	     			            .setType(BootstrapDialog.TYPE_DANGER)
      	     			            .open();
      	     			       }
      	     		         });
      	                }
                  	},
                      {
      	                label: '<i class="fa fa-times"> </i> Annulla',
      	                // no title as it is optional
      	                cssClass: 'btn-danger',
      	                action: function(dialogItself){
      	                    dialogItself.close();
      	                }
                      }
                  ]
            
        });
	}

});
</script>