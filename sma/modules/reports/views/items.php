<?php
if($this->input->post('submit')) {
		   
		  $v = "";
		  if($this->input->post('name')){
			   $v .= "&name=".$this->input->post('name');
		   } 
		   if($this->input->post('reference_no')){
			   $v .= "&reference_no=".$this->input->post('reference_no');
		   }
		   if($this->input->post('customer')){
			   $v .= "&customer=".$this->input->post('customer');
		   }
		   if($this->input->post('biller')){
			   $v .= "&biller=".$this->input->post('biller');
		   } 
		   if($this->input->post('warehouse')){
			   $v .= "&warehouse=".$this->input->post('warehouse');
		   } 
		   if($this->input->post('user')){
			   $v .= "&user=".$this->input->post('user');
		   }
		   if($this->input->post('start_date')){
			   $v .= "&start_date=".$this->input->post('start_date');
		   }
		   if($this->input->post('end_date')) {
			    $v .= "&end_date=".$this->input->post('end_date');
		   }
	  
}
?>
<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<style type="text/css">
.text_filter { width: 100% !important; font-weight: normal !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; font-size: 1em !important;}
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
.table td { width: 12.5%; display: table-cell; }
.table th { text-align: center; }
.table td:nth-child(5), .table tfoot th:nth-child(5), .table td:nth-child(6), .table tfoot th:nth-child(6), .table td:nth-child(7), .table tfoot th:nth-child(7) { text-align:right; }
</style>
<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/query-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#start_date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});

		$( "#end_date" ).datepicker({
        	format: "<?php echo JS_DATE; ?>",
			autoclose: true
    	});
		<?php if(!isset($_POST['submit'])) { echo '$( "#end_date" ).datepicker("setDate", new Date());'; } ?>
		<?php if($this->input->post('submit')) { echo "$('.form').hide();"; } ?>
        $(".toggle_form").slideDown('slow');
 
		$('.toggle_form').click(function(){
			$(".form").slideToggle();
		});
		
	});
</script>
<script>
             $(document).ready(function() {
				function currencyFormate(x) {
					var parts = x.toString().split(".");
				   return  parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(parts[1] ? "." + parts[1] : ".00");
					 
				}
                $('#fileData').dataTable( {
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "aaSorting": [[ 0, "desc" ]],
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,
					'bProcessing'    : true,
					'bServerSide'    : true,
					'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=reports&view=getSales<?php 
					if($this->input->post('submit')) { echo $v; } ?>',
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
						"sSwfPath": "smlib/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
								{
									"sExtends": "csv",
									"sFileName": "<?php echo $this->lang->line("sales"); ?>.csv",
                   		 			"mColumns": [ 0, 1, 2, 3, 4 ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("sales"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 0, 1, 2, 3, 4 ]
								},
								"print"
						]
					},
					"aoColumns": [ 
					  null,  null,  null, null, null, null, null,
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
					},
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
							$('td:eq(4)', nRow).html( currencyFormate(aData[4]) );
							$('td:eq(5)', nRow).html( currencyFormate(aData[5]) );
							$('td:eq(6)', nRow).html( currencyFormate(aData[6]) );
							return nRow;
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

<link href="<?php echo $this->config->base_url(); ?>assets/css/datepicker.css" rel="stylesheet">

<h3 class="title"><?php echo $page_title; ?> <a href="#" class="btn btn-mini toggle_form"><?php echo $this->lang->line("show_hide"); ?></a></h3>

<div class="form">
<p>Please customise the report below.</p>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=reports&view=sales", $attrib); ?>
<div class="control-group">
  <label class="control-label" for="reference_no"><?php echo $this->lang->line("reference_no"); ?></label>
  <div class="controls"> <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="span4" id="reference_no"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("product_name"); ?></label>
  <div class="controls"> <?php echo form_input('name', (isset($_POST['name']) ? $_POST['name'] : ""), 'class="span4" id="name"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="user"><?php echo $this->lang->line("user"); ?></label>
  <div class="controls"> <?php 
	   		$us[""] = "";
	   		foreach($users as $user){
				$us[$user->id] = $user->first_name." ".$user->last_name;
			}
			echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="span4" id="user" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("user").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="customer"><?php echo $this->lang->line("customer"); ?></label>
  <div class="controls"> <?php 
	   		$cu[""] = "";
	   		foreach($customers as $customer){
				$cu[$customer->id] = $customer->name;
			}
			echo form_dropdown('customer', $cu, (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="span4" id="customer" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("customer").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="biller"><?php echo $this->lang->line("biller"); ?></label>
  <div class="controls"> <?php 
	   		$bl[""] = "";
	   		foreach($billers as $biller){
				$bl[$biller->id] = $biller->name;
			}
			echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="span4" id="biller" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("biller").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="warehouse"><?php echo $this->lang->line("warehouse"); ?></label>
  <div class="controls"> <?php 
	   		$wh[""] = "";
	   		foreach($warehouses as $warehouse){
				$wh[$warehouse->id] = $warehouse->name;
			}
			echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="span4" id="warehouse" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("warehouse").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="start_date"><?php echo $this->lang->line("start_date"); ?></label>
  <div class="controls"> <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="span4" id="start_date"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="end_date"><?php echo $this->lang->line("end_date"); ?></label>
  <div class="controls"> <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="span4" id="end_date"');?> </div>
</div>
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?>

</div>
<div class="clearfix"></div>

<?php if($this->input->post('submit')) { ?>

	<table id="fileData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px;">
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
            	<td colspan="8" class="dataTables_empty">Loading data from server</td>
			</tr>
            
        </tbody>
        <tfoot>

        <tr>
            <th>[<?php echo $this->lang->line("date"); ?>]</th>
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

<?php } ?>
<p>&nbsp;</p>
