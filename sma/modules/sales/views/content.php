<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter {
	width: 100% !important;
	font-weight: normal !important;
	border: 0 !important;
	box-shadow: none !important;
	border-radius: 0 !important;
	padding:0 !important;
	margin:0 !important;
	font-size: 1em !important;
}
.select_filter {
	width: 100% !important;
	padding:0 !important;
	height: auto !important;
	margin:0 !important;
}
.table td {
	width: 12.5%;
	display: table-cell;
}
.table th {
	text-align: center;
}
.table td:nth-child(5), .table tfoot th:nth-child(5), .table td:nth-child(6), .table tfoot th:nth-child(6), .table td:nth-child(7), .table tfoot th:nth-child(7) {
	text-align:right;
}
</style>
<script>
             $(document).ready(function() {

                $('#slData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 1, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
                    <?php if(BSTATESAVE) { echo '"bStateSave": true,'; } ?>
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=sales&view=getdatatableajax',
					'fnServerData': function(sSource, aoData, fnCallback, fnFooterCallback)
					{
						aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash() ?>" } );
					  $.ajax
					  ({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : fnCallback
					  });
					},
					"oTableTools": {
						"sSwfPath": "assets/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
								{
									"sExtends": "csv",
									"sFileName": "<?php echo $this->lang->line("sales"); ?>.csv",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5, 6 ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("sales"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 0, 1, 2, 3, 4, 5, 6 ]
								},
								"print"
						]
					},
					"aoColumns": [ 
					  { "mRender": format_date },  null,  null, null, { "mRender": currencyFormate }, { "mRender": currencyFormate }, { "mRender": currencyFormate },
					  { "bSortable": false }
					],
					
					"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
						var row_total = 0; tax_total =0; tax2_total = 0;
						for ( var i=0 ; i<aaData.length ; i++ )
						{
							tax_total += parseFloat(aaData[ aiDisplay[i] ][4]);
							tax2_total += parseFloat(aaData[ aiDisplay[i] ][5]);
							row_total += parseFloat(aaData[ aiDisplay[i] ][6]);
						}
						
						var nCells = nRow.getElementsByTagName('th');
						nCells[4].innerHTML = currencyFormate(parseFloat(tax_total).toFixed(2));
						nCells[5].innerHTML = currencyFormate(parseFloat(tax2_total).toFixed(2));
						nCells[6].innerHTML = currencyFormate(parseFloat(row_total).toFixed(2));
					}
					
                } ).columnFilter({ aoColumns: [

						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						null, null, null, null
                     ]});
				
            } );
                    
</script>
<?php if($message) { echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>

<div class="btn-group pull-right" style="margin-left: 25px;"> <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("all_warehouses"); ?> <span class="caret"></span> </a>
  <ul class="dropdown-menu">
    <?php
	foreach($warehouses as $warehouse) {
		echo "<li><a href='index.php?module=sales&view=warehouse&warehouse_id=".$warehouse->id."'>".$warehouse->name."</a></li>";	
	}
	?>
  </ul>
</div>
<h3 class="title"><?php echo $page_title; ?></h3>
<p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>
<table id="slData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px;">
  <thead>
    <tr>
      <th><?php echo $this->lang->line("date"); ?></th>
      <th><?php echo $this->lang->line("reference_no"); ?></th>
      <th><?php echo $this->lang->line("biller"); ?></th>
      <th><?php echo $this->lang->line("customer"); ?></th>
      <th><?php echo $this->lang->line("tax1"); ?></th>
      <th><?php echo $this->lang->line("tax2"); ?></th>
      <th><?php echo $this->lang->line("total"); ?></th>
      <th style="width:115px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="8" class="dataTables_empty"><?php echo $this->lang->line("loading_data"); ?></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th>[<?php echo $this->lang->line("date"); ?> (yyyy-mm-dd)]</th>
      <th>[<?php echo $this->lang->line("reference_no"); ?>]</th>
      <th>[<?php echo $this->lang->line("biller"); ?>]</th>
      <th>[<?php echo $this->lang->line("customer"); ?>]</th>
      <th><?php echo $this->lang->line("tax1"); ?></th>
      <th><?php echo $this->lang->line("tax2"); ?></th>
      <th><?php echo $this->lang->line("total"); ?></th>
      <th style="width:115px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th>
    </tr>
  </tfoot>
</table>
<a href="<?php echo site_url('module=sales&view=add');?>" class="btn btn-primary"><?php echo $this->lang->line("add_sale"); ?></a>
<div class="btn-group dropup" style="margin-left: 25px;"> <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line("all_warehouses"); ?> <span class="caret"></span> </a>
  <ul class="dropdown-menu">
    <?php
	foreach($warehouses as $warehouse) {
		echo "<li><a href='index.php?module=sales&view=warehouse&warehouse_id=".$warehouse->id."'>".$warehouse->name."</a></li>";	
	}
	?>
  </ul>
</div>
