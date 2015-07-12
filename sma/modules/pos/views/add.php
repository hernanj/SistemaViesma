<?php

	$cajaIniciales=$this->pos_model->hayTurno();
	$cantidad=0;
	$id_caja_turno='';
	foreach($cajaIniciales as $cajaInicial)
		$cantidad=$cajaInicial->cantidad;
	//chequeamos si hay un turno abierto en el dia
	if($cantidad != 0){
		$rs=$this->pos_model->getIdCajaTurnoActual();
		$id_caja_turno=$rs[0]->id_caja_turno;
	}
	// asigna en el num de turno
	$num_turno=$this->pos_model->numeroTurno();
	if($num_turno[0]->cantidad != 0)
		$num_turno=$num_turno[0]->cantidad;
	else
		$num_turno=1;
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->lang->line('pos_module') . " | " . SITE_NAME; ?></title>
        <script type="text/javascript"> if (parent.frames.length !== 0) { top.location = '<?php echo $this->config->base_url(); ?>index.php?module=pos'; } </script>
        <base href="<?php echo $this->config->base_url(); ?>" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="shortcut icon" href="<?php echo $this->config->base_url(); ?>images/favicon.ico">
        <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-<?php echo THEME; ?>.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/pos/css/posajax.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/pos/css/print.css" type="text/css" media="print" />
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/pos/js/jquery-1.7.2.min.js"></script>
        <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>assets/css/ie.css" /><![endif]-->
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/pos/js/jquery.keyboard.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/pos/js/jquery.carouFredSel-6.2.1.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/pos/js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
        <style type="text/css">
            .navbar-fixed-top { position:static; }
            #content { padding-top: 10px; }
        </style>
    </head>
    <body   id="allwrapper">
        <div id="wrapper">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner" style="padding-left:10px;">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <button type="button" class="btn btn-navbar menu-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="brand" href="<?php echo $this->config->base_url(); ?>"><img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo LOGO; ?>" alt="<?php echo SITE_NAME; ?>" /></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php echo FIRST_NAME; ?>! <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=change_password"><?php echo $this->lang->line('change_password'); ?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=auth&amp;view=logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                </ul>
                            </li>
                            <!--<li class="visible-desktop"><a class="external" href="http://www.tecdiary.net/support/pos-module/" target="_blank"><i class="icon-question-sign icon-white"></i></a></li>-->
                        </ul>
                        <ul class="nav pull-right">
                            <li><a class="hdate"><span id="theTime"></span></a></li>
                            <li class="visible-desktop"><a href="index.php?module=home"><?php echo $this->lang->line('home'); ?></a></li>
                            <li class="visible-desktop"><a href="<?php echo $this->config->base_url(); ?>index.php?module=pos&amp;view=settings"><?php echo $this->lang->line('pos_settings'); ?></a></li>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('sales'); ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=sales"><?php echo $this->lang->line('sales'); ?></a></li>
                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php?module=pos&amp;view=suspended_sales"><?php echo $this->lang->line('suspended_sales'); ?></a></li>
                                </ul>
                            </li>
                            <li><a class="btn btn-success hbtn" href="#" id="todaySale"><?php echo $this->lang->line('today_sale'); ?></a></li>
                            <li><a class="btn btn-success hbtn"  id="cierreTurno" >Rendiciòn de turno</a></li>
                            <?php
                            /*if (ALERT_NO > 0) {
								
                                echo "<li class=\"visible-desktop\"><a class=\"btn btn-warning hbtn\" href=\"index.php?module=reports&view=products\">" . ALERT_NO . " " . $this->lang->line('product_alerts') . "</a></li>";
                            }
                            if (DEMO) {
                                echo '<li><a class="btn btn-success hbtn" href="http://codecanyon.net/item/pos-module-for-stock-manager-advance/4494018?ref=tecdiary" target="_blank">Buy Now</a></li>';
                            }*/
                            ?>
                            <li class="divider-vertical"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="content">
                <div class="c1">
                    <div>PUTO</div>
                    <div class="pos">
                                    <?php if ($message) {
                                        echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
                                    } ?>
<?php if ($success_message) {
    echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>";
} ?>
                        <div id="pos"> <?php echo form_open("module=pos"); ?>
						<input type="hidden" name="id_caja_turno" id='id_caja_turno' class="id_caja_turno" value="<?=$id_caja_turno?>"/>
                            <div id="leftdiv">
                                <div id="printhead">
                                    <h4 style="text-transform:uppercase;"><?php echo SITE_NAME; ?></h4>
<?php echo "<h5 style=\"text-transform:uppercase;\">" . $this->lang->line('order_list') . "</h5>";
echo $this->lang->line("date") . " " . date(PHP_DATE, strtotime('today'));
?>
                                </div>
                                <div id="lefttop">
                                    <div style="clear:left;"></div>
                                    <input value="Mostrador" id="customer" name="customer" class="customer" style="width:330px;float: left;" placeholder="Customer - Type 2 char for suggestions" onClick="this.select();">
                                   <!-- <input value="<?php echo $customer->name; ?>" id="customer" name="customer" class="customer" style="width:330px;float: left;" placeholder="Customer - Type 2 char for suggestions" onClick="this.select();">-->
                                    <a href="#" id="showCustomerModal" role="button" data-toggle="modal" style="float: right;width:22px;height:22px; margin-top:-1px; border: 0;"><img src="assets/pos/images/plus-icon.png" alt="+"></a>

                                    <div style="clear:left;"></div>
                                    <input id="scancode" name="code" class="scancode" style="width:370px; border: 1px solid #00ACED; color: #00ACED;" placeholder="<?php echo $this->lang->line('barcode_scanner'); ?>" autocomplete="off">
                                    <div style="clear:both;"></div>
                                </div>

                                <div id="print">
                                    <div id="prodiv">
                                        <div style="background-color:#333;">
                                            <table id="title_table" border="0" cellpadding="0" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 30px; color:#FFF;padding:5px 0; font-weight:normal;"><i class="icon-trash icon-white"></i></th>
                                                        <th style="width: 200px; color:#FFF;padding:5px 0; font-weight:normal;"><?php echo $this->lang->line('product'); ?></th>
                                                        <th style="width: 42px; color:#FFF;padding:5px 0; font-weight:normal;"><?php echo $this->lang->line('qty'); ?></th>
                                                        <th style="width: 82px; color:#FFF; padding:5px 0; font-weight:normal;"><?php echo $this->lang->line('price'); ?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div id="protbldiv">
                                            <table border="0" cellpadding="0" cellspacing="0" class="protable"  id="saletbl">
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <table id="totalTable" style="width:100%; float:right; border: 1px solid #666; padding:5px; font-size: 14px; color:#000; background: #FFF;">
                                        <tr>
                                            <td style="padding-left:10px; text-align:left; font-weight:normal;"><?php echo $this->lang->line('total_items'); ?></td>
                                            <td style="text-align:right; padding-right:10px; font-size: 14px; font-weight:bold;"><span id="count">0</span></td>
                                            <td style="padding-left:10px; text-align:left;"><?php echo $this->lang->line('total_x_tax'); ?></td>
                                            <td style="text-align:right; padding-right:10px; font-size: 14px; font-weight:bold;"><span id="total">0.00</span></td>
                                        </tr>
<?php if (TAX1 || TAX2) { ?>
                                            <tr>
                                                <?php if (TAX1 && !TAX2) { ?>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="padding-left:10px; text-align:left; font-weight:normal;"><?php echo $this->lang->line('tax1'); ?></td>
                                                    <td style="text-align:right; padding-right:10px; font-size: 14px; font-weight:bold;"><span id="tax">0.00</span></td>
                                                <?php } ?>
                                                <?php if (TAX2 && !TAX1) { ?>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="padding-left:10px; text-align:left; font-weight:normal;"><?php echo $tax_name2; ?></td>
                                                    <td style="text-align:right; padding-right:10px; font-size: 14px; font-weight:bold;"><span id="tax2">0.00</span></td>
    <?php } ?>
    <?php if (TAX1 && TAX2) { ?>
                                                    <td style="padding-left:10px; text-align:left; font-weight:normal;"><?php echo $this->lang->line('tax1'); ?></td>
                                                    <td style="text-align:right; padding-right:10px; font-size: 14px; font-weight:bold;"><span id="tax">0.00</span></td>
                                                    <td style="padding-left:10px; text-align:left; font-weight:normal;"><?php echo $tax_name2; ?></td>
                                                    <td style="text-align:right; padding-right:10px; font-size: 14px; font-weight:bold;"><span id="tax2">0.00</span></td>
    <?php } ?>
                                            </tr>
<?php } ?>
                                        <tr>
                                            <td style="padding-left:10px; text-align:left; " colspan="2"><?php echo $this->lang->line('discount'); ?></td>
                                            <td style="text-align:right; padding-right:10px; font-weight:bold;" colspan="2"><span id="ds">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0px 5px 10px; text-align:left; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;" colspan="2"><?php echo $this->lang->line('total_payable'); ?></td>
                                            <td style="text-align:right; padding:5px 10px 5px 0px; font-size: 14px;border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;" colspan="2"><span id="total-payable">0.00</span></td>
                                        </tr>
                                    </table>
                                </div>

                                <!--<div id="printfooter"> <?php /* echo BILL_FOOTER; */ ?> </div>-->
                                <div id="botbuttons" style="text-align:center;">
                                    <input type="hidden" name="biller" id="biller" value="<?php echo DBILLER; ?>" />
                                    <input type="hidden" name="warehouse" id="warehouse" value="<?php echo DEFAULT_WAREHOUSE; ?>" />
                                    <input type="hidden" name="paid_val" id="paid_val" value="" />
                                    <input type="hidden" name="cc_no_val" id="cc_no_val" value="" />
                                    <input type="hidden" name="cc_holder_val" id="cc_holder_val" value="" />
                                    <input type="hidden" name="cheque_no_val" id="cheque_no_val" value="" />
                                    <button type="button" class="red bot" id="cancel"><?php echo $this->lang->line('cancel'); ?></button>
                                    <button type="button" class="cyan bot" id="print" onClick="window.print(); return false;"><?php echo $this->lang->line('print'); ?></button>
                                    <button type="button" class="yellow bot" id="suspend" style="margin-right: 0;"><?php echo $this->lang->line('suspend'); ?></button>
                                    <button type="button" class="pg" id="payment" style="margin-left: auto; margin-right: auto; width:100%;"><?php echo $this->lang->line('payment'); ?></button>
                                </div>
                                <div style="clear:both; height:5px;"></div>
                                <div id="num">
                                    <div id="icon"></div>
                                </div>
                                <span id="hidesuspend"></span>
                                <input type="hidden" name="rpaidby" id="rpaidby" value="cash" style="display: none;" />
                                <input type="hidden" name="count" id="total_item" value="0" style="display: none;" />
                                <input type="submit" id="submit" value="Submit Sale" style="display: none;" />
                            </div>
<?php echo form_close(); ?>
                            <div id="cp">
                               <div id="cpinner">
                                    <div id="catContainer">
                                        <div class="list_carousel">
                                            <ul id="cats">
                                                    <?php echo $categories; ?>
                                            </ul>
                                            <a class="prev" id="prev2" href="#"><span>prev</span></a> <a class="next" id="next2" href="#"><span>next</span></a>
                                            <div class="pagination" id="pager2"></div>
                                        </div>
                                    </div>
                                    <div class="quick-menu">
                                        <div id="proContainer">
                                            <div id="ajaxproducts">
                                                <div id="proajax">
<?php
echo $products;

echo "</div><button id=\"previous\" type=\"button\" class=\"blue\" style='z-index:10002;'><i><img src='assets/pos/images/previous.png' alt='previous' /></i><span><span>" . $this->lang->line('previous') . "</span></span></button><button id=\"next\" type=\"button\" class=\"blue\" style='z-index:10003;'><i><img src='assets/pos/images/next.png' alt='next' /></i><span><span>" . $this->lang->line('next') . "</span></span></button></div>";
?>
                                                </div>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                </div> 
								
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
        </div>
        <div id="itemModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"></h3>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input type="hidden" id="itemRowId" value="">
                    <?php if (TAX1) { ?>
                        <div class="control-group">
                            <label class="control-label" for="tax1"><?php echo $this->lang->line("tax1"); ?></label>
                            <div class="controls">
    <?php
    foreach ($tax_rates as $tax) {
        $tr[$tax->id] = $tax->name;
    }
    echo form_dropdown('tax1', $tr, DEFAULT_TAX, 'id="item_tax"');
    ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (DISCOUNT_OPTION == 2) { ?>
                        <div class="control-group">
                            <label class="control-label" for="discount"><?php echo $this->lang->line("discount"); ?></label>
                            <div class="controls">
    <?php
    foreach ($discounts as $discount) {
        $ds[$discount->id] = $discount->name;
    }
    echo form_dropdown('discount', $ds, DEFAULT_DISCOUNT, 'id="item_discount" ');
    ?>
                            </div>
                        </div>
<?php } ?>
<?php if (PRODUCT_SERIAL) { ?>
                        <div class="control-group">
                            <label class="control-label" for="serial_no"><?php echo $this->lang->line("serial_no"); ?></label>
                            <div class="controls"> <?php echo form_input('serial_no', '', 'id="item_serial_no" '); ?> </div>
                        </div>
<?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
                <button class="btn btn-primary" id="updateRow"><?php echo $this->lang->line('save'); ?></button>
            </div>
        </div>
        <div id="paymentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="paymentModalLabel"><?php echo $this->lang->line('finalize_sale'); ?></h3>
            </div>
            <div class="modal-body">
                <div id="paymentdiv"></div>
                <div class="well form-horizontal" style="margin-bottom:0;"><div class="control-group" style="font-weight:bold;">
                        <div class="control-group">
                            <label class="control-label" id="warehouse_l"><?php echo $this->lang->line("warehouse"); ?></label>
                            <div class="controls">  <?php
                                $wh[''] = $this->lang->line("select") . ' ' . $this->lang->line("warehouse");
                                ;
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('s_warehouse', $wh, (isset($_POST['s_warehouse']) ? $_POST['s_warehouse'] : DEFAULT_WAREHOUSE), 'id="s_warehouse" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" required="required" data-error="' . $this->lang->line("warehouse") . ' ' . $this->lang->line("is_required") . '"');
                                ?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" id="s_biller"><?php echo $this->lang->line("biller"); ?></label>
                            <div class="controls">  <?php
                                $bl[""] = $this->lang->line("select") . ' ' . $this->lang->line("biller");
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->name;
                                }
                                echo form_dropdown('s_biller', $bl, (isset($_POST['s_biller']) ? $_POST['s_biller'] : DBILLER), 'id="s_biller" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("biller") . '" required="required" data-error="' . $this->lang->line("biller") . ' ' . $this->lang->line("is_required") . '"');
                                ?> </div>
                        </div>
                        <div class="control-label" style="padding-top:0;font-weight:bold;"><?php echo $this->lang->line("total_payable"); ?>:</div><div class="controls"><span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;"><span id="twt"></span></span></div></div> <div class="control-group" style="font-weight:bold;"><div class="control-label" style="padding-top:0;font-weight:bold;"><?php echo $this->lang->line("total_items"); ?>:</div><div class="controls"><span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;"><span id="item_count"></span></span></div></div> <div class="control-group"><label class="control-label" for="paid_by"><?php echo $this->lang->line("paid_by"); ?></label><div class="controls"><select name="paid_by" id="paid_by"><option value="cash"><?php echo $this->lang->line("cash"); ?></option><option value="CC"><?php echo $this->lang->line("cc"); ?></option><option value="Cheque"><?php echo $this->lang->line("cheque"); ?></option></select></div></div> <div class="pcash"><div class="control-group"><label class="control-label" for="paid-amount"><?php echo $this->lang->line("paid"); ?></label><div class="controls"><input type="text" id="paid-amount" class="pa"/></div></div> <div class="control-group" style="font-weight:bold;"><div class="control-label" style="padding-top:0;font-weight:bold;"><?php echo $this->lang->line("change"); ?>:</div><div class="controls"><span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;" id="balance"></span></div></div></div>
                            <div class="pcc" style="display:none;"><div class="control-group"><label class="control-label" for="paid-amount"><?php echo $this->lang->line("cc_no"); ?></label><div class="controls"><input type="text" id="pcc" /></div></div>
                                <div class="control-group"><label class="control-label" for="paid-amount"><?php echo $this->lang->line("cc_holder"); ?></label><div class="controls"><input type="text" id="pcc_holder" /></div></div>
                            </div>
            
             
              <div class="pcheque" style="display:none;">
                  <div class="control-group"><label class="control-label" for="paid-amount"><?php echo $this->lang->line("cheque_no"); ?></label><div class="controls"><input type="text" id="cheque_no" /></div></div>
              </div>
                        </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
                <button class="btn btn-primary" id="submit-sale"><?php echo $this->lang->line('submit'); ?></button>
            </div>
        </div>
		
		<!-- 
		caja modal - Rendicion de turno
		-->
		<div id="cajaModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">		

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="paymentModalLabel">Rendición del Turno</h3>
            </div>
            <div class="modal-body">
                <div id="paymentdiv"></div>
                <div class="well form-horizontal" style="margin-bottom:0;"><div class="control-group" style="font-weight:bold;">
				<div style="font-weight:bold;" class="control-group">
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Caja Inicial</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Ventas por Menor</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Ventas por Mayor</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Gastos</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Adelanto Mercaderia</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Adelanto Efectivo</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Caja pròximo Turno</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Sobrante -  Faltante</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>
					<div class="control-group">
						<label id="warehouse_l" class="control-label">Rendiciòn Efectivo</label>
							<div class="controls">  
							<span style="background: #FFFF99; border-radius:5px; padding: 5px 10px; color: #000;">
								<span id="twt">$ 1.5799,55</span>
							</span>
						</div>
					</div>	
				</div>    
				</div>
				</div>
			</div>
		</div>
		<!--
		fin de caja modal
		-->
		
		<!-- 
		caja modal - Rendicion de turno
		-->
		
		<div id="egresosModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">		

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="paymentModalLabel">Egresos de caja</h3>
            </div>
            <div class="modal-body">
                <div id="paymentdiv"></div>
                <div class="well form-horizontal" style="margin-bottom:0;">
					<div class="control-group" style="font-weight:bold;">
						<div style="font-weight:bold;" class="control-group">
							<div class="control-group">
								<label id="warehouse_l" class="control-label">Tipo</label>
								<div class="controls">  
									<select  id="egresos_id_tipo" name="s_egresos">
										<option value="" selected="selected">--Seleccione--</option>										
										<?php
											$tipo_egresos=$this->pos_model->get_tipos_egresos();
											foreach($tipo_egresos as $tipo_egreso)
												echo "<option  value='".$tipo_egreso->id_tipo."'>".$tipo_egreso->descripcion."</option>";
										?>
									</select> 
									
									
									<!--<span style=" border-radius:5px; padding: 5px 10px; color: #000;">-->
										<input id="egresos_monto" value='$ 0'/>
									<!--</span>-->
									<textarea rows="4" cols="50" id="observaciones">
									</textarea>
								</div>
							</div>	
						</div>    
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-primary" id="add_egresos">Agregar</button>
			</div>
		</div>
		
		
		<!--
		fin de caja modal
		-->
		
		<!-- 
		caja modal - cierre de turno
		-->
		
		<div id="cierreModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">		

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="paymentModalLabel">Rendición de turno Nº <?=$num_turno;?></h3>
            </div>
            <div class="modal-body">
                <div id="paymentdiv"></div>
                <div class="well form-horizontal" style="margin-bottom:0;">
					<div class="control-group" style="font-weight:bold;">
						<div style="font-weight:bold;" class="control-group">
							<div class="control-group">
								<!--<label id="warehouse_l" class="control-label">Tipo</label>-->
								<div class="controls"> 										
										<p>	
											<label id="warehouse_l" class="control-label">Total monto ventas turno</label>
											<span style=" border-radius:5px; padding: 5px 10px; color: #000;" id="totalVentasTurno">											
											</span>
										</p>
										<p>
											<label id="warehouse_l" class="control-label">Total egresos turno</label>
											<span style=" border-radius:5px; padding: 5px 10px; color: #000;" id="totalEgresosTurno">											
											</span>
										</p>
										<!--<p>
											<label id="warehouse_l" class="control-label"></label>
											<span style=" border-radius:5px; padding: 5px 10px; color: #000;" id="cajaInicio">											
											</span>
										</p>-->
										<p>
											<label id="warehouse_l" class="control-label">Retiro efectivo</label>
											&nbsp;<input style="width:100px" id="retiroCaja" value=''/>
										</p>
										<p>
											<label id="warehouse_l" class="control-label">Caja inicial</label>
											<span style=" border-radius:5px; padding: 5px 10px; color: #000;" id="cajaInicialTurno">											
											</span>
										</p>
										<p>
											<label id="warehouse_l" class="control-label">Total a rendir</label>
											<span style=" border-radius:5px; padding: 5px 10px; color: #000;" id="totalRendirTurno">											
											</span>
										</p>
										
								</div>
							</div>	
						</div>    
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-primary" id="cierre_turno">Cierre de turno</button>
			</div>
		</div>
		
		
		<!--
		fin de caja modal
		-->
		
		<!-- 
		caja modal - inicio de turno
		-->
		
		<div id="inicioModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">		

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="paymentModalLabel">Inicio de turno</h3>
            </div>
            <div class="modal-body">
                <div id="paymentdiv"></div>
                <div class="well form-horizontal" style="margin-bottom:0;">
					<div class="control-group" style="font-weight:bold;">
						<div style="font-weight:bold;" class="control-group">
							<div class="control-group">
								<!--<label id="warehouse_l" class="control-label">Tipo</label>-->
								<div class="controls"> 	
										<table>
											<tr>
												<td>
													<label style="padding-top: 5px;text-align: left;width: 160px;">Turno Nº </label>
												</td>
												<td>													
													: <?=$num_turno+1?>													
												</td>
											</tr>
											<tr>
												<td>
													<label style="padding-top: 5px;text-align: left;width: 160px;">Fecha de inicio de turno</label>
												</td>
												<td>													
													: <?=date("d/m/Y");?>													
												</td>
											</tr>
											<tr>
												<td>
													<label style="padding-top: 5px;text-align: left;width: 160px;">Hora de inicio de turno</label>
												</td>
												<td>													
													: <?=date("G:i");?>													
												</td>
											</tr>
											<tr>
												<td>
													<label style="padding-top: 5px;text-align: left;width: 160px;">Monto inicial de turno</label>
												</td>
												<td>													
													: <input id="caja_inicio" style="width:125px" />													
												</td>
											</tr>
										</table>																				
								</div>
							</div>	
						</div>    
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-primary" id="ini_turno">Iniciar turno</button>
			</div>
		</div>
		
		
		<!--
		fin de caja modal
		-->
		
		<!-- 
		caja modal - consulta de precio por cod o descripcion del articulo y la posibilidad de agregarlo
		-->
		
		<div id="consultaModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">		

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="paymentModalLabel">Consulta</h3>
            </div>
            <div class="modal-body">
                <div id="paymentdiv"></div>
                <div class="well form-horizontal" style="margin-bottom:0;">
					<div class="control-group" style="font-weight:bold;">
						<div style="font-weight:bold;" class="control-group">
							<div class="control-group">
								<!--<label id="warehouse_l" class="control-label">Tipo</label>-->
								<!--<div class="controls"> 	-->
										<table>
											<tr>												
												<td>													
													<input autocomplete="off" placeholder="Escaner Codigo de Barra" style="width:370px; border: 1px solid #00ACED; color: #00ACED;" class="codBarras" name="codBarras" id="codBarras">									
												</td>
											</tr>											
											
											<tr>
												<td>													
													<input autocomplete="off" placeholder="Nombre del Articulo" style="width:370px; border: 1px solid red; color: red;" class="nombreArticulo" name="nombreArticulo" id="nombreArticulo">									
												</td>
											</tr>
											<tr>
												<td>													
													<div style="padding:12px 0 0" class='respConsultaArticulo'></div>
												</td>
											</tr>
										</table>																				
								</div>
							<!--</div>	-->
						</div>    
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <span id="product"><button class="btn btn-primary" type="button"  id="product-xxxx">Agregar</button></span>
				<!--<button id="product-0206" type="button" value='1101' class="green" ><i><img src="assets/uploads/thumbs/default.png"></i><span><span>Asado</span></span></button>-->
			</div>
		</div>
		
		
		<!--
		fin de caja modal
		-->
		
        <div id="customerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="customerModalLabel"><?php echo $this->lang->line('new_customer'); ?></h3>
            </div>
            <div class="modal-body">
                <div id="customerError"></div>
                <div class="control-group">
                    <label class="control-label" for="company"><?php echo $this->lang->line("company") . ": " . $this->lang->line("bypass"); ?></label>
                    <div class="controls"> <?php echo form_input('company', '', 'class="input-block-level tip" title="' . $this->lang->line("bypass") . '" id="company" '); ?> </div>
                </div>
                <div style="width:100%">
                    <div style="width: 48%; float:left;">
                        <div class="control-group">
                            <label class="control-label" for="name"><?php echo $this->lang->line("name"); ?></label>
                            <div class="controls"> <?php echo form_input('name', '', 'class="input-block-level" id="name" '); ?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email_address"><?php echo $this->lang->line("email_address"); ?></label>
                            <div class="controls">
                                <input type="email" id="cusEmail" name="email" class="input-block-level" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>
                            <div class="controls">
                                <input type="tel" id="cusPhone" name="phone" class="input-block-level" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="postal_code"><?php echo $this->lang->line("postal_code"); ?></label>
                            <div class="controls"> <?php echo form_input('postal_code', '', 'class="input-block-level" id="postal_code" '); ?> </div>
                        </div>
                    </div>
                    <div style="width: 48%; float:right;">
                        <div class="control-group">
                            <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
                            <div class="controls"> <?php echo form_input('address', '', 'class="input-block-level" id="address" '); ?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="city"><?php echo $this->lang->line("city"); ?></label>
                            <div class="controls"> <?php echo form_input('city', '', 'class="input-block-level" id="city" '); ?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="state"><?php echo $this->lang->line("state"); ?></label>
                            <div class="controls"> <?php echo form_input('state', '', 'class="input-block-level" id="state" '); ?> </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="country"><?php echo $this->lang->line("country"); ?></label>
                            <div class="controls"> <?php echo form_input('country', '', 'class="input-block-level" id="country"'); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
                <button class="btn btn-primary" id="add-customer"><?php echo $this->lang->line('add_customer'); ?></button>
            </div>
        </div>
        <div id="saleModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="saleModalLabel"><?php echo $this->lang->line('today_sale'); ?></h3>
            </div>
            <div class="modal-body">
                <div id="salediv"></div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
        <div id="gmail_loading" style="display: none;">
            <div class="blackbg"></div>
            <div class="gmailLoader"> <img src="<?php echo $this->config->base_url(); ?>assets/pos/images/gmail-loader.gif" alt="Loading ..." /> <?php echo $this->lang->line('loading'); ?> </div>
        </div>
		
        <script type="text/javascript">
            $(document).ready(function() {
			var hayTurno=true;
											<?php
											if($cantidad == 0){
											?>	
											//iniciamos el turno
											$('#inicioModal').modal();
											<?php
											}
										?>
			var ctrlPressed = false;
			var teclaCtrl = 17, teclaC = 67 , teclaE = 69, teclaX = 88;

/*********mascara **********/
$('#egresos_monto').mask("000000000.00", {reverse: true});
/*******************/
			$( "#scancode" ).focus();
			//agregamos un evento al body para q capture el enter asi envia el pago directo
					/*$('#allwrapper').keypress(function (e) {
							 var key = e.which;
							 if(key == 13)  // the enter key code
							  {
								//$('input[name = butAssignProd]').click();	
									enviar_pago();
								return false;  
							  }
							}); 
						*/	
					$('#allwrapper').keydown(function(e){
					//alert(e.keyCode);
					
					// 112 = F1 para chequear precios
					// 113 = F2 
					if(e.keyCode==112){
						$('.respConsultaArticulo').text('');
						$('.nombreArticulo').val('');
						$('#consultaModal').modal();
					}
						
					
					  if (e.keyCode == teclaCtrl)
						ctrlPressed = true;
					//caja
					/*if (ctrlPressed && (e.keyCode == teclaC)){
						$('#cajaModal').modal();
						//alert("Has presionado Ctrl+C");
					}*/
					//ingreso de egresos o gastos
					if (ctrlPressed && (e.keyCode == teclaE)){
					   $('#egresosModal').modal();
						//alert("Has presionado Ctrl+C");
						}
					//Rendicion de turno
					if (ctrlPressed && (e.keyCode == teclaX)){
					   $('#cierreModal').modal();
						get_rendicion_turno();
						}

					});

					$('#allwrapper').keyup(function(e){
					  if (e.keyCode == teclaCtrl)
						ctrlPressed = false;
					});
					
					
					$('#cierreTurno').click(function(){
						$('#cierreModal').modal();
						get_rendicion_turno();
					});				
				var count_productos=0;
                var count = 1;
                var total = 0;
                var total_discount = 0;
                var an = 1;
                var discount_method = <?php echo DISCOUNT_METHOD; ?>;
                var tax_rates = <?php echo json_encode($tax_rates); ?>;
                var discounts = <?php echo json_encode($discounts); ?>;
                var DT = <?php echo DEFAULT_TAX; ?>;
                var pr_tax;
                <?php if (DISCOUNT_OPTION == 1) { ?>
                    var discount = <?php echo $discount_rate; ?>;
                    var discount_type = <?php echo $discount_type; ?>;
                <?php } ?>
                <?php if (DISCOUNT_OPTION == 2) { ?>
                    var discount2 = <?php echo $discount_rate2; ?>;
                    var discount_type2 = <?php echo $discount_type2; ?>;
                <?php } ?>
                <?php if (TAX1) { ?>
                    var tax_rate = <?php echo $tax_rate; ?>;
                    var tax_type = <?php echo $tax_type; ?>;
                <?php } ?>
                var tax_value = 0;
                <?php if (TAX2) { ?>
                    var tax_rate2 = <?php echo $tax_rate2; ?>;
                    var tax_type2 = <?php echo $tax_type2; ?>;
                <?php } ?>
                var tax_value2 = 0;
                var ids = new Array();
                var p_page = 0;
                var page = 0;
                var cat_id = <?php echo DCAT; ?>;
                var sproduct_name;
                var slast;
                var old_val;
                var new_val;
                var total_cp = <?php echo $total_cp; ?>;
                var total_cats = <?php echo $total_cats; ?>;
                var new_tax_rate;
                var new_tax_type;
                var old_tax_rate;
                var old_tax_type;
                var new_discount_rate;
                var new_discount_type;
                var old_discount_rate;
                var old_discount_type;
                add_row();
                loadProducts();

                function loadProducts() {
                    $('button[id^="category"]').click(function() {
                        if (cat_id != $(this).val()) {
                            $('#gmail_loading').show();
                            cat_id = $(this).val();
                            $.ajax({
                                type: "get",
                                url: "index.php?module=pos&view=ajaxproducts",
                                data: {category_id: cat_id, per_page: 'n'},
                                dataType: "html",
                                success: function(data) {
                                    $('#proajax').empty();
                                    var newPrs = $('<div></div>');
                                    newPrs.html(data);
                                    newPrs.appendTo("#proajax");
                                }
                            }).done(function() {
                                add_row();
                                $.ajax({
                                    type: "get",
                                    async: false,
                                    url: "index.php?module=pos&view=total_cp",
                                    data: {category_id: cat_id},
                                    dataType: "html",
                                    success: function(data) {
                                        total_cp = data;
                                    }
                                });
                                p_page = 'n';
                                $('#gmail_loading').hide();
                            });
                        }
                    });
                }

                $('#next').click(function() {
                    if (p_page == 'n') {
                        p_page = 0
                    }
                    p_page = p_page + <?php echo PLIMIT; ?>;
                    if (total_cp >= <?php echo PLIMIT; ?> && p_page < total_cp) {
                        $('#gmail_loading').show();
                        $.ajax({
                            type: "get",
                            url: "index.php?module=pos&view=ajaxproducts",
                            data: {category_id: cat_id, per_page: p_page},
                            dataType: "html",
                            success: function(data) {
                                $('#proajax').empty();
                                var newPrs = $('<div></div>');
                                newPrs.html(data);

                                newPrs.appendTo("#proajax");
                            }
                        }).done(function() {
                            add_row();
                            $('#gmail_loading').hide();
                        });
                    } else {
                        p_page = p_page - <?php echo PLIMIT; ?>;
                    }
                });

                $('#previous').click(function() {
                    if (p_page == 'n') {
                        p_page = 0;
                    }
                    if (p_page != 0) {
                        $('#gmail_loading').show();
                        p_page = p_page - <?php echo PLIMIT; ?>;
                        if (p_page == 0) {
                            p_page = 'n'
                        }
                        $.ajax({
                            type: "get",
                            url: "index.php?module=pos&view=ajaxproducts",
                            data: {category_id: cat_id, per_page: p_page},
                            dataType: "html",
                            success: function(data) {
                                $('#proajax').empty();
                                var newPrs = $('<div></div>');
                                newPrs.html(data);

                                newPrs.appendTo("#proajax");
                            }

                        }).done(function() {
                            add_row();
                            $('#gmail_loading').hide();
                        });

                    }
                });

                $("#saletbl").on("click", '.code', function() {
                    var delID = $(this).attr('id');
                    var dl_id = delID.split("-");
                    var rw_no = dl_id[1];
                    var q1 = $('#product-' + rw_no);					
                    var heading = $(this).text();
<?php if (PRODUCT_SERIAL) { ?>
            $('#item_serial_no').val($('#serial-' + rw_no).val());
                                $('#item_serial_no').keyboard({
                            autoAccept: true,
                            alwaysOpen: false,
                            usePreview: false
                        });
<?php } ?>
<?php if (TAX1) { ?> $('#item_tax').val($('#tax_rate-' + rw_no).val()); <?php } ?>
<?php if (DISCOUNT_OPTION == 2) { ?>
            $('#item_discount').val($('#discount-' + rw_no).val()); <?php } ?>
                    $('#itemRowId').val(rw_no);

                    $('#myModalLabel').text(heading);

                    $('#itemModal').modal();

                    return false;
                });

                $("#todaySale").click(function() {
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "index.php?module=pos&view=today_sale",
                        dataType: "html",
                        success: function(data) {
                            ts_data = data;
                        },
                        error: function() {
                            bootbox.alert('<?php echo $this->lang->line('request_failed'); ?>');
                            return false;
                        }
                    });
                    $('#salediv').empty();
                    var newTr = $('<div></div>');
                    newTr.html(ts_data);
                    newTr.appendTo("#salediv");
                    $('#saleModal').modal();
                    return false;
                });
                $("#updateRow").click(function() {
                    $(this).text('<?php echo $this->lang->line('saving'); ?>');
                    var rw_no = $('#itemRowId').val();
                    old_val = $('#tax_rate-' + rw_no).val();
                    old_ds = $('#discount-' + rw_no).val();
<?php if (PRODUCT_SERIAL) { ?> $('#serial-' + rw_no).val($('#item_serial_no').val()); <?php } ?>
<?php if (TAX1) { ?> $('#tax_rate-' + rw_no).val($('#item_tax').val()); <?php } ?>
<?php if (DISCOUNT_OPTION == 2) { ?>
            $('#discount-' + rw_no).val($('#item_discount').val()); <?php } ?>
                    var p = '#price-' + rw_no;				
                    var row_price = parseFloat($.trim($(p).val()));
<?php if (TAX1) { ?>
                        new_val = $('#item_tax').val();
                        $.each(tax_rates, function() {
                            if (this.id == new_val) {
                                new_tax_rate = parseFloat(this.rate);
                                new_tax_type = parseFloat(this.type);
                            }
                            if (this.id == old_val) {
                                old_tax_rate = parseFloat(this.rate);
                                old_tax_type = parseFloat(this.type);
                            }
                        });

                        if (new_tax_type == 2) {
                            new_pr_tax_rate = new_tax_rate;
                        }
                        if (new_tax_type == 1) {
                            new_pr_tax_rate = (row_price * new_tax_rate) / 100;
                        }
                        if (old_tax_type == 2) {
                            old_pr_tax_rate = old_tax_rate;
                        }
                        if (old_tax_type == 1) {
                            old_pr_tax_rate = (row_price * old_tax_rate) / 100;
                        }
                        tax_value -= old_pr_tax_rate;
                        tax_value += new_pr_tax_rate;
                        current_tax = Math.abs(tax_value).toFixed(2);
<?php } else { ?>
                        old_pr_tax_rate = 0;
                        new_pr_tax_rate = 0;
<?php } ?>
<?php if (DISCOUNT_OPTION == 2) { ?>
                        new_ds = $('#item_discount').val();
                        $.each(discounts, function() {
                            if (this.id == new_ds) {
                                new_discount_rate = parseFloat(this.discount);
                                new_discount_type = parseFloat(this.type);
                            }
                            if (this.id == old_ds) {
                                old_discount_rate = parseFloat(this.discount);
                                old_discount_type = parseFloat(this.type);
                            }
                        });


    <?php if (DISCOUNT_METHOD == 1) { ?>
                            if (new_discount_type == 2) {
                                new_pr_discount = new_discount_rate;
                            }
                            if (new_discount_type == 1) {
                                new_pr_discount = (row_price * new_discount_rate) / 100;
                            }
                            if (old_discount_type == 2) {
                                old_pr_discount = old_discount_rate;
                            }
                            if (old_discount_type == 1) {
                                old_pr_discount = (row_price * old_discount_rate) / 100;
                            }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                            if (new_discount_type == 2) {
                                new_pr_discount = new_discount_rate;
                            }
                            if (new_discount_type == 1) {
                                new_pr_discount = ((row_price + new_pr_tax_rate) * new_discount_rate) / 100;
                            }
                            if (old_discount_type == 2) {
                                old_pr_discount = old_discount_rate;
                            }
                            if (old_discount_type == 1) {
                                old_pr_discount = ((row_price + old_pr_tax_rate) * old_discount_rate) / 100;
                            }

    <?php } ?>
                        total_discount -= old_pr_discount;
                        total_discount += new_pr_discount;
                        current_discount = Math.abs(total_discount).toFixed(2);
                        var g_total = (total + tax_value + tax_value2) - total_discount;
<?php } else { ?>
                        var g_total = total + tax_value + tax_value2;
<?php } ?>
                    grand_total = Math.abs(g_total).toFixed(2);
                    $("#total-payable").empty();
                    $("#total-payable").append(grand_total);
<?php if (PRODUCT_SERIAL) { ?>$('#item_serial_no').val('');<?php } ?>
<?php if (TAX1) { ?>$("#tax").empty();
                                $("#tax").append(current_tax);
                                $('#item_tax').val('');<?php } ?>
<?php if (DISCOUNT_OPTION == 2) { ?>$("#ds").empty();
                                $("#ds").append(current_discount);
                                $('#item_discount').val('');<?php } ?>

                            $(this).text('<?php echo $this->lang->line('save'); ?>');
                            $('#itemModal').modal('hide');
                            return false;
                        });

                        $("#showCustomerModal").click(function() {
                            $('#customerModal').modal('show');
                        });

                        $("#add-customer").click(function() {
                            var newCustomer = new Array();
                            newCustomer[0] = $('#company').val();
                            newCustomer[1] = $('#name').val();
                            newCustomer[2] = $('#cusPhone').val();
                            newCustomer[3] = $('#cusEmail').val();
                            newCustomer[4] = $('#address').val();
                            newCustomer[5] = $('#city').val();
                            newCustomer[6] = $('#state').val();
                            newCustomer[7] = $('#postal_code').val();
                            newCustomer[8] = $('#country').val();
                            $.ajax({
                                type: "post",
                                async: false,
                                url: "index.php?module=pos&view=add_customer",
                                data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", data: newCustomer},
                                dataType: "html",
                                success: function(data) {
                                    result = data;
                                },
                                error: function() {
                                    bootbox.alert('<?php echo $this->lang->line('customer_request_failed'); ?>');
                                    result = false;
                                    return false;
                                }
                            });
                            if (result == '<?php echo $this->lang->line("customer_added"); ?>') {
                                $('#customerModal').modal('hide');
                                $('#company').val('');
                                $('#name').val('');
                                $('#cusPhone').val('');
                                $('#cusEmail').val('');
                                $('#address').val('');
                                $('#city').val('');
                                $('#state').val('');
                                $('#postal_code').val('');
                                $('#country').val('');
                                bootbox.alert('<?php echo$this->lang->line("customer_added"); ?>');
                            } else {
                                var error = $('<div class=\"alert alert-error\"></div>');
                                error.html("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" + result);
                                error.appendTo("#customerError");
                                return false;
                            }
                        });

                        var pprice;
                        $("#saletbl").on("click", 'input[id^="price"]', function() {
                            var delID = $(this).attr('id');
                            var dl_id = delID.split("-");
                            var rw_no = dl_id[1];
                            pprice = $(this).val();
                            var q1 = $('#quantity-' + rw_no);
                            q1.focus();
                            return false;
                        });


                        $("#saletbl").on("click", 'button[class^="del_row"]', function() {
						//alert('borrar');
                            var delID = $(this).attr('id');
                            var dl_id = delID.split("-");
                            var rw_no = dl_id[1];
                            var p1 = $('#price-' + rw_no);
                            var q1 = $('#quantity-' + rw_no);

<?php if (TAX1) { ?>
                                var t1 = $('#tax_rate-' + rw_no);
                                var t1_val = t1.val();
                                $.each(tax_rates, function() {
                                    if (this.id == t1_val) {
                                        new_tax_rate = parseFloat(this.rate);
                                        new_tax_type = parseFloat(this.type);
                                    }
                                });

<?php } else { ?>
                                new_pr_tax_rate = 0;
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>
                                var d1 = $('#discount-' + rw_no);
                                var d1_val = d1.val();
                                $.each(discounts, function() {
                                    if(this.id == d1_val){
                                            new_discount_rate = parseFloat(this.discount);
                                            new_discount_type = parseFloat(this.type);
                                    }
                                });
                                
<?php } ?>

                            var row_price = parseFloat(p1.val());
                            var row_quantity = parseInt(q1.val());
							
                            total = total - row_price;
                            current = parseFloat(total).toFixed(2);
							
                            count_productos = count_productos - row_quantity;
                            if (isNaN(count)) {
                                bootbox.alert('<?php echo $this->lang->line('pos_error'); ?>');
                                $('#cancel').trigger('click');
                                return false;
                            }
                            if (isNaN(current)) {
                                bootbox.alert('<?php echo $this->lang->line('pos_error'); ?>');
                                $('#cancel').trigger('click');
                                return false;
                            }
<?php if (TAX1) { ?>
                                if (new_tax_type == 2) {
                                    new_pr_tax_rate = new_tax_rate;
                                }
                                if (new_tax_type == 1) {
                                    new_pr_tax_rate = (row_price * new_tax_rate) / 100;
                                }
                                tax_value = tax_value - new_pr_tax_rate;
                                current_tax = Math.abs(tax_value).toFixed(2);
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                    if (new_discount_type == 2) {
                                        new_pr_discount = new_discount_rate;
                                    }
                                    if (new_discount_type == 1) {
                                        new_pr_discount = (row_price * new_discount_rate) / 100;
                                    }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                                    if (new_discount_type == 2) {
                                        new_pr_discount = new_discount_rate;
                                    }
                                    if (new_discount_type == 1) {
                                        new_pr_discount = ((row_price + new_pr_tax_rate) * new_discount_rate) / 100;
                                    }
    <?php } ?>
                                total_discount = total_discount - new_pr_discount;
<?php } else { ?>
                                new_pr_discount = 0;
<?php } ?>

<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                if (discount_type == 2) {
                                    new_discount_value = discount;
                                }
                                if (discount_type == 1) {
                                    new_discount_value = (total * discount) / 100;
                                }
                                total_discount = new_discount_value;
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                if (discount_type == 2) {
                                    new_discount_value = discount;
                                }
                                if (discount_type == 1) {
                                    new_discount_value = ((total + tax_value + tax_value2) * discount) / 100;
                                }
                                total_discount = new_discount_value;
<?php } ?>
<?php if (TAX2) { ?>
                                if (tax_type2 == 2) {
                                    tax_value2 = tax_rate2;
                                }
                                if (tax_type2 == 1) {
                                    tax_value2 = (total * tax_rate2) / 100;
                                }
                                current_tax2 = Math.abs(tax_value2).toFixed(2);
<?php } ?>
                            var g_total = (total + tax_value + tax_value2) - total_discount;
                            current_discount = Math.abs(total_discount).toFixed(2);
                            grand_total = Math.abs(g_total).toFixed(2);

                            $("#total-payable").empty();
                            $("#total-payable").append(grand_total);
                            $("#total").empty();
                            $("#total").append(current);
                            $("#count").empty();
                           // $("#count").append(count_productos);
                            $("#count").append($('#saletbl tbody > tr').length-1);
							//alert('866');
<?php if (TAX1) { ?>$("#tax").empty();
                                         $("#tax").append(current_tax);
<?php } ?>
<?php if (TAX2) { ?>$("#tax2").empty();
                                         $("#tax2").append(current_tax2);
<?php } ?>
<?php if (DISCOUNT_OPTION == 2) { ?>$("#ds").empty();
                                         $("#ds").append(current_discount);
<?php } ?>

                                     an--;
                                     row_id = $("#row_" + rw_no);
                                     row_id.remove();

                                 });

                                 $("#saletbl").on("focus", ".keyboard", function() {
                                     key_pad();
                                 });


                                 function add_row() {
									 //alert('aca');
                                     $('button[id^="product"]').click(function() {
                                         if (count >= 1000) {
                                             bootbox.alert("<?php echo $this->lang->line('qty_limit'); ?>");
                                             return false;
                                         }
                                         if (an >= 51) {
                                             bootbox.alert("<?php echo $this->lang->line('max_pro_reached'); ?>");
                                             $('#gmail_loading').hide();
                                             var divElement = document.getElementById('protbldiv');
                                             divElement.scrollTop = divElement.scrollHeight;
                                             return false;
                                         }
                                         $('#gmail_loading').show();
                                         var v = $(this).val();
                                         $.ajax({
                                             type: "get",
                                             async: false,
                                             url: "index.php?module=pos&view=price",
                                             data: {code: v},
                                             dataType: "json",
                                             success: function(data) {
                                                 item_price = parseFloat(data.price);
                                                 prod_name = data.name;
                                                 prod_code = data.code;
                                                 pr_tax = data.tax_rate;
                                             }
                                         });
                                         var leng = $(this).attr('id').length;
                                         var last = $(this).attr('id').substr(leng - 4);
                                         var pric = 'price' + last;
                                         var quan = 'quantity' + last;
                                         var code = 'code' + last;
										 count=$('#saletbl tbody > tr').length+1;
										 //alert(count+'/'+pric+' / '+quan+' / '+code);
                                         var prod_tax = 0;
                                         $.each(tax_rates, function() {
                                             if (pr_tax) {
                                                 if (this.id == pr_tax.id) {
                                                     prod_tax = this.id;
                                                 }
                                             }
                                         });
                                         var pt = prod_tax ? prod_tax : DT;										
                                         var newTr = $('<tr id="row_' + count + last + '"></tr>');
                                         newTr.html('<td id="satu" style="text-align:center; width: 27px;"><button type="button" class="del_row" id="del-' + count + last + '" value="' + item_price + '"><i class="icon-trash"></i></button></td><td><input type="hidden" name="product' + count + '" value="' + prod_code + '" id="product-' + count + last + '"><input type="hidden" name="serial' + count + '" value="" id="serial-' + count + last + '"><input type="hidden" name="tax_rate' + count + '" value="' + pt + '" id="tax_rate-' + count + last + '"><input type="hidden" name="discount' + count + '" value="<?php echo DEFAULT_DISCOUNT; ?>" id="discount-' + count + last + '"><a href="#" id="model-' + count + last + '" class="code">' + prod_name + '</a><input type="hidden" name="price' + count + '" value="' + parseFloat(item_price).toFixed(2) + '" id="oprice-' + count + last + '"></td><td style="text-align:center;"><input class="keyboard" onClick="this.select();" name="quantity' + count + '" type="text" value="1" autocomplete="off" id="quantity-' + count + last + '"></td><td style="padding-right: 10px; text-align:right;"><input type="text" class="price" name="unit_price' + count + '" value="' + parseFloat(item_price).toFixed(2) + '" id="price-' + count + last + '"></td>');
										count_productos++;
                                         newTr.appendTo("#saletbl");

                                         total += item_price;
                                         current = parseFloat(total).toFixed(2);
<?php if (TAX1) { ?>
                                             if (pr_tax) {
                                                 if (pr_tax.type == 2) {
                                                     pr_tax_rate = parseFloat(pr_tax.rate);
                                                 }
                                                 if (pr_tax.type == 1) {
                                                     pr_tax_rate = (item_price * parseFloat(pr_tax.rate)) / 100;
                                                 }
                                                 tax_value += pr_tax_rate;
                                             } else {
                                                 if (tax_type == 2) {
                                                     new_tax_value = tax_rate;
                                                 }
                                                 if (tax_type == 1) {
                                                     new_tax_value = (item_price * tax_rate) / 100;
                                                 }
                                                 tax_value += new_tax_value
                                             }
                                             current_tax = parseFloat(tax_value).toFixed(2);
<?php } ?>
<?php if (TAX2) { ?>
                                             if (tax_type2 == 2) {
                                                 tax_value2 = tax_rate2;
                                             }
                                             if (tax_type2 == 1) {
                                                 tax_value2 = (total * tax_rate2) / 100;
                                             }
                                             current_tax2 = parseFloat(tax_value2).toFixed(2);
<?php } ?>

<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                             if (discount_type == 2) {
                                                 new_discount_value = discount;
                                             }
                                             if (discount_type == 1) {
                                                 new_discount_value = (total * discount) / 100;
                                             }
                                             total_discount = new_discount_value;
                                             current_discount = parseFloat(total_discount).toFixed(2);
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                             if (discount_type == 2) {
                                                 new_discount_value = discount;
                                             }
                                             if (discount_type == 1) {
                                                 new_discount_value = ((total + tax_value + tax_value2) * discount) / 100;
                                             }
                                             total_discount = new_discount_value;
                                             current_discount = parseFloat(total_discount).toFixed(2);
<?php } ?>

<?php if (DISCOUNT_OPTION == 2 && DISCOUNT_METHOD == 1) { ?>
                                             if (discount_type2 == 2) {
                                                 new_discount_value2 = discount2;
                                             }
                                             if (discount_type2 == 1) {
                                                 new_discount_value2 = (item_price * discount2) / 100;
                                             }
                                             total_discount += new_discount_value2;
                                             current_discount = parseFloat(total_discount).toFixed(2);
<?php } elseif (DISCOUNT_OPTION == 2 && DISCOUNT_METHOD == 2) { ?>
                                             if (discount_type2 == 2) {
                                                 new_discount_value2 = discount2;
                                             }
                                             if (discount_type2 == 1) {
                                                 new_discount_value2 = ((item_price + new_tax_value) * discount2) / 100;
                                             }											 
                                             total_discount += new_discount_value2;
                                             current_discount = parseFloat(total_discount).toFixed(2);
<?php } ?>
                                         var g_total = total + tax_value + tax_value2 - total_discount;
                                         grand_total = parseFloat(g_total).toFixed(2);

                                         $("#total-payable").empty();
                                         $("#total-payable").append(grand_total);
                                         $("#total").empty();
                                         $("#total").append(current);
                                         $("#count").empty();
										 //count_productos++;
                                         //$("#count").append(count_productos);
											$("#count").append($('#saletbl tbody > tr').length);
										 
<?php if (TAX1) { ?>$("#tax").empty();
                                             $("#tax").append(current_tax);<?php } ?>
<?php if (TAX2) { ?>$("#tax2").empty(); $("#tax2").append(current_tax2);<?php } ?>
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>
                $("#ds").empty(); $("#ds").append(current_discount);
<?php } ?>

                                         count++;
                                         an++;
                                         var divElement = document.getElementById('protbldiv');
                                         divElement.scrollTop = divElement.scrollHeight;

                                         $('#gmail_loading').hide();
										 //oculta en el caso de q sea desde consulta
										$("#consultaModal").modal('hide');

                                     });

                                 }

                                 function key_pad() {
                                     $('.keyboard').keyboard({
                                         restrictInput: true,
                                         preventPaste: true,
                                         autoAccept: true,
                                         alwaysOpen: false,
                                         openOn: 'click',
                                         layout: 'costom',
                                         display: {
                                             'a': '\u2714:Accept (Shift-Enter)',
                                             'accept': 'Accept:Accept (Shift-Enter)',
                                             'b': '\u2190:Backspace',
                                             'bksp': 'Bksp:Backspace',
                                             'c': '\u2716:Cancel (Esc)',
                                             'cancel': 'Cancel:Cancel (Esc)',
                                             'clear': 'C:Clear'

                                         },
                                         position: {
                                             of: null,
                                             my: 'center top',
                                             at: 'center top',
                                             at2: 'center bottom'
                                         },
                                         usePreview: false,
                                         customLayout: {
                                             'default': [
                                                 '1 2 3 {b}',
                                                 '4 5 6 {clear}',
                                                 '7 8 9 0',
                                                 '{accept} {cancel} {dec}'
                                             ]
                                         },
                                         beforeClose: function(e, keyboard, el, accepted) {
											 
												//var new_pr_discount = 0;
												
                                             //var before_qty = parseInt(keyboard.originalContent);
                                             var before_qty = parseFloat(keyboard.originalContent);
                                             //var after_qty = parseInt(el.value);
                                             var after_qty = parseFloat(el.value);		
                                             var row_id = $(this).attr('id');
                                             var sp_id = row_id.split("-");
											 
                                             var id_no = sp_id[1];
											
                                             var p = '#price-' + id_no;
                                             var row_price = parseFloat($.trim($(p).val()));
											 var pp = '#oprice-' + id_no;
                                             var product_price = parseFloat($.trim($(pp).val()));
											 // alert(row_id+' | '+sp_id+' | '+id_no+' | '+before_qty+' | '+after_qty+'|'+product_price+'|'+row_price);
                                             /*
											 if (before_qty == 1) {
                                                 product_price = row_price;
                                             }
                                             if (before_qty > 1) {
                                                 product_price = (row_price / before_qty);
                                             }*/
											 
											//alert(product_price);
											if(product_price!= "undefined" ){
												var gross_total = after_qty * product_price;
											}                                             
                                             var b_count = (count - before_qty);
                                             var a_count = (b_count + after_qty);
                                             count = a_count;
                                             var b_total = (total - row_price);
                                             var a_total = (b_total + gross_total);
                                             total = a_total;
                                             gross_total = parseFloat(gross_total).toFixed(2);
                                             $(p).val(gross_total);
                                             current = parseFloat(total).toFixed(2);
<?php if (TAX1) { ?>
                                                 var pr_tax_id = $('#tax_rate-' + id_no).val();
                                                 $.each(tax_rates, function() {
                                                     if (this.id == pr_tax_id) {
                                                         new_tax_rate = parseFloat(this.rate);
                                                         new_tax_type = parseFloat(this.type);
                                                     }

                                                 });

                                                 if (new_tax_type == 2) {
                                                     new_tax_value = new_tax_rate;
                                                 }
                                                 if (new_tax_type == 1) {
                                                     new_tax_value = (product_price * new_tax_rate) / 100;
                                                 }
                                                 tax_value = tax_value - (new_tax_value * before_qty);
                                                 tax_value = tax_value + (new_tax_value * after_qty);
                                                 current_tax = parseFloat(tax_value).toFixed(2);
<?php } else { ?>
                                                 new_tax_value = 0;
<?php } ?>

<?php if (DISCOUNT_OPTION == 2) { ?>
                                                 var pr_ds_id = $('#discount-' + id_no).val();
                                                 $.each(discounts, function() {
                                                    if(this.id == pr_ds_id){
                                                            new_discount_rate = parseFloat(this.discount);
                                                            new_discount_type = parseFloat(this.type);
                                                    }
                                                  });  

    <?php if (DISCOUNT_METHOD == 1) { ?>
                                                     if (new_discount_type == 2) {
                                                         new_pr_discount = new_discount_rate;
                                                     }
                                                     if (new_discount_type == 1) {
                                                         new_pr_discount = (product_price * new_discount_rate) / 100;
                                                     }
    <?php } elseif (DISCOUNT_METHOD == 2) { ?>
                                                     if (new_discount_type == 2) {
                                                         new_pr_discount = new_discount_rate;
                                                     }
                                                     if (new_discount_type == 1) {
                                                         new_pr_discount = ((product_price + new_tax_value) * new_discount_rate) / 100;
                                                     }
													 
    <?php } ?>	
                                                 total_discount = total_discount - (new_pr_discount * before_qty);
                                                 total_discount = total_discount + (new_pr_discount * after_qty);
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } ?>

<?php if (TAX2) { ?>
                                                 if (tax_type2 == 2) {
                                                     tax_value2 = tax_rate2;
                                                 }
                                                 if (tax_type2 == 1) {
                                                     tax_value2 = (total * tax_rate2) / 100;
                                                 }
                                                 current_tax2 = parseFloat(tax_value2).toFixed(2);
<?php } ?>

<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                                 if (discount_type == 2) {
                                                     new_discount_value = discount;
                                                 }
                                                 if (discount_type == 1) {
                                                     new_discount_value = (total * discount) / 100;
                                                 }
                                                 total_discount = new_discount_value;
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                                 if (discount_type == 2) {
                                                     new_discount_value = discount;
                                                 }
                                                 if (discount_type == 1) {
                                                     new_discount_value = ((total + tax_value + tax_value2) * discount) / 100;
                                                 }
                                                 total_discount = new_discount_value;
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } ?>

                                             var g_total = (total + tax_value + tax_value2) - total_discount;
                                             grand_total = parseFloat(g_total).toFixed(2);

                                             $("#total-payable").empty();
                                             $("#total").empty();
                                             $("#count").empty();
<?php if (TAX1) { ?>$("#tax").empty();
                                                 $("#tax").append(current_tax);<?php } ?>
<?php if (TAX2) { ?>$("#tax2").empty(); $("#tax2").append(current_tax2);<?php } ?>
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>
                    $("#ds").empty(); $("#ds").append(current_discount);
<?php } ?>
                                             $("#total-payable").append(grand_total);
                                             $("#total").append(current);
                                             //$("#count").append(count_productos - 1);
                                             $("#count").append($('#saletbl tbody > tr').length);
											
                                         }
                                     });

                                 }

                                 $("#customer").autocomplete({
                                     source: function(request, response) {
                                         $.ajax({url: "<?php echo site_url('module=customers&view=suggestions'); ?>",
                                             data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", term: $("#customer").val()},
                                             dataType: "json",
                                             type: "get",
                                             success: function(data) {
                                                 response(data);
                                             }
                                         });
                                     },
                                     minLength: 2,
                                     error: function() {
                                         bootbox.alert('<?php echo $this->lang->line('ajax_error'); ?>');
                                         $('.ui-autocomplete-loading').removeClass("ui-autocomplete-loading");
                                     }
                                 });


                                 $('#scancode').keydown(function(e) {
								 
                                     if (e.keyCode == 13){

                                     if (count >= 1000) {
                                     bootbox.alert("<?php echo $this->lang->line('qty_limit'); ?>");
                                             return false;
                                     }
                                     if (an >= 51){
                                     bootbox.alert("<?php echo $this->lang->line('max_pro_reached'); ?>");
                                             $('#gmail_loading').hide();
                                             var divElement = document.getElementById('protbldiv');
                                             divElement.scrollTop = divElement.scrollHeight;
                                             return false;
                                     }



                                     $('#gmail_loading').show();
                                             var v = $(this).val();
                                             $.ajax({
                                             type: "get",
                                                     async: false,
                                                     url: "index.php?module=pos&view=scan_product",
                                                     data: { <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", code: v },
                                                     dataType: "json",
                                                     success: function(data) {
                                                         if (data != null) {
                                                             item_price = parseFloat(data.item_price).toFixed(2);
                                                             sproduct_name = data.product_name;
                                                             sproduct_code = data.product_code;
                                                            // sproduct_quantity = data.product_quantity;
                                                             sproduct_quantity = parseFloat(data.product_quantity).toFixed(3);
                                                             pr_tax = data.tax_rate;
                                                             slast = data.last;
															 item_price_total=sproduct_quantity*item_price;
                                                         } else {
                                                             item_price = null;
                                                         }
                                                     },
                                                     error: function() {
                                                         bootbox.alert('<?php echo $this->lang->line('code_error'); ?>');
                                                         item_price = false;
                                                     }

                                             });
                                             if (item_price == false) {$(this).val(''); $('#gmail_loading').hide(); return false; }
											
										if (item_price == null && $('.price').length == 0) { 
											$(this).val(''); 
											bootbox.alert('<?php echo $this->lang->line('code_error'); ?>');
											$('#gmail_loading').hide();
											return false; 
										}else{
											$('#gmail_loading').hide();
											enviar_pago();
											return false;
										}
									 
                                     var prod_tax = 0;
                                             $.each(tax_rates, function() {
                                                 if (pr_tax) {
                                                     if (this.id == pr_tax.id) {
                                                         prod_tax = this.id;
                                                     }
                                                 }
                                             });
                                             var pt = prod_tax ? prod_tax : DT;//alert(1285);
                                             var newTr = $('<tr id="row_' + count + slast + '"></tr>');
                                             newTr.html('<td id="satu" style="text-align:center; width: 27px;"><button type="button" class="del_row" id="del-' + count + slast + '" value="' + item_price + '"><i class="icon-trash"></i></button></td><td><input type="hidden" name="product' + count + '" value="' + sproduct_code + '" id="product-' + count + slast + '"><input type="hidden" name="serial' + count + '" value="" id="serial-' + count + slast + '"><input type="hidden" name="tax_rate' + count + '" value="' + pt + '" id="tax_rate-' + count + slast + '"><input type="hidden" name="discount' + count + '" value="<?php echo DEFAULT_DISCOUNT; ?>" id="discount-' + count + slast + '"><a href="#" id="model-' + count + slast + '" class="code">' + sproduct_name + '</a><input type="hidden" name="price' + count + '" value="' + parseFloat(item_price).toFixed(2) + '" id="oprice-' + count + slast + '"></td><td style="text-align:center;"><input class="keyboard" onClick="this.select();" name="quantity' + count + '" type="text" value="'+ sproduct_quantity +'" autocomplete="off" id="quantity-' + count + slast + '"></td><td style="padding-right: 10px; text-align:right;"><input type="text" class="price" name="unit_price' + count + '" value="' + parseFloat(item_price_total).toFixed(2) + '" id="price-' + count + slast + '"></td>');
                                             newTr.appendTo("#saletbl");
                                             total += parseFloat(item_price_total);
                                             current = parseFloat(total).toFixed(2);
<?php if (TAX1) { ?>
                                         if (pr_tax) {
                                         if (pr_tax.type == 2){ pr_tax_rate = parseFloat(pr_tax.rate); }
                                         if (pr_tax.type == 1){ pr_tax_rate = (item_price * parseFloat(pr_tax.rate)) / 100; }
                                         tax_value += pr_tax_rate;
                                         } else {
                                         if (tax_type == 2){ new_tax_value = tax_rate; }
                                         if (tax_type == 1){ new_tax_value = (item_price * tax_rate) / 100; }
                                         tax_value += new_tax_value
                                         }
                                         current_tax = parseFloat(tax_value).toFixed(2);
<?php } ?>
<?php if (TAX2) { ?>
                                         if (tax_type2 == 2){ tax_value2 = tax_rate2; }
                                         if (tax_type2 == 1){ tax_value2 = (total * tax_rate2) / 100; }
                                         current_tax2 = parseFloat(tax_value2).toFixed(2);
<?php } ?>

<?php if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) { ?>
                                         if (discount_type == 2){ new_discount_value = discount; }
                                         if (discount_type == 1){ new_discount_value = (total * discount) / 100; }
                                         total_discount = new_discount_value;
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) { ?>
                                         if (discount_type == 2){ new_discount_value = discount; }
                                         if (discount_type == 1){ new_discount_value = ((total + tax_value + tax_value2) * discount) / 100; }
                                         total_discount = new_discount_value;
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } ?>

<?php if (DISCOUNT_OPTION == 2 && DISCOUNT_METHOD == 1) { ?>
                                         if (discount_type2 == 2){ new_discount_value2 = discount2; }
                                         if (discount_type2 == 1){ new_discount_value2 = (parseFloat(item_price) * discount2) / 100; }
                                         total_discount += new_discount_value2;
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } elseif (DISCOUNT_OPTION == 2 && DISCOUNT_METHOD == 2) { ?>
                                         if (discount_type2 == 2){ new_discount_value2 = discount2; }
                                         if (discount_type2 == 1){ new_discount_value2 = ((parseFloat(item_price) + new_tax_value) * discount2) / 100; }
                                         total_discount += new_discount_value2;
                                                 current_discount = parseFloat(total_discount).toFixed(2);
<?php } ?>
                                     var g_total = total + tax_value + tax_value2 - total_discount;
                                             grand_total = parseFloat(g_total).toFixed(2);
                                             $("#total-payable").empty(); $("#total-payable").append(grand_total);
                                             $("#total").empty(); $("#total").append(current);	
											count_productos++;											 
                                            // $("#count").empty(); $("#count").append(count_productos);
                                             $("#count").empty(); $("#count").append($('#saletbl tbody > tr').length+1);
											 
<?php if (TAX1) { ?>$("#tax").empty(); $("#tax").append(current_tax);<?php } ?>
<?php if (TAX2) { ?>$("#tax2").empty(); $("#tax2").append(current_tax2);<?php } ?>
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?> $("#ds").empty(); $("#ds").append(current_discount);
<?php } ?>


                                     count++;
                                     an++;

                                     var divElement = document.getElementById('protbldiv');
                                     divElement.scrollTop = divElement.scrollHeight;

                                     $(this).val('');
                                     $('#gmail_loading').hide();
                                     e.preventDefault();
                                     return false;
                                 }


                                 });
								 
                                         $('#scancode').bind('keypress', function(e) {
                                     if (e.keyCode == 13) {
                                         e.preventDefault();
                                         return false;
                                     }
                                 });

                                 $("#cancel").click(function() {
                                     if (count <= 1) {
                                         bootbox.alert('<?php echo $this->lang->line('x_cancel'); ?>');
                                         return false;
                                     }

                                     bootbox.confirm("<?php echo $this->lang->line('sure_to_cancel_sale'); ?>", function(gotit) {
                                         if (gotit) {

                                         $("#saletbl").empty();
                                                 count = 1;
                                                 total = 0;
                                                 tax_value = 0;
                                                 tax_value2 = 0;
                                                 an = 1;
                                                 total_discount = 0;
                                                 current = parseFloat(total).toFixed(2);
                                                 current_tax = parseFloat(tax_value).toFixed(2);
                                                 var g_total = total + tax_value;
                                                 grand_total = parseFloat(g_total).toFixed(2);
                                                 $("#total-payable").empty();
                                                 $("#total").empty();
                                                 $("#count").empty();
<?php if (TAX1) { ?>$("#tax").empty(); $("#tax").append(current_tax);<?php } ?>
<?php if (TAX2) { ?>$("#tax2").empty(); $("#tax2").append(current_tax);<?php } ?>
<?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?> $("#ds").empty(); $("#ds").append(current_tax);
<?php } ?>
                                         $("#total-payable").append(grand_total);
                                         $("#total").append(current);
                                         //$("#count").append(count_productos - 1);
                                         $("#count").append($('#saletbl tbody > tr').length - 1);
											
                                     }

                                     });
                                 });
                                     $('#paymentModal').on('change', '#s_biller', function(){ $('#biller').val($(this).val()); });
                                     $('#paymentModal').on('change', '#s_warehouse', function(){ $('#warehouse').val($(this).val()); });
                                     $('#paymentModal').on('blur', '.pa', function(){ $('#paid_val').val($(this).val()); });
                                     $('#paymentModal').on('change', '#pcc', function(){ $('#cc_no_val').val($(this).val()); });
                                     $('#paymentModal').on('change', '#pcc_holder', function(){ $('#cc_holder_val').val($(this).val()); });
                                     $('#paymentModal').on('change', '#cheque_no', function(){ $('#cheque_no_val').val($(this).val()); });
                                 
                                 $("#payment").click(function() {
											
                                    enviar_pago();
                                 });
								 
								 function enviar_pago(){
								 
								  var twt = (total + tax_value + tax_value2) - total_discount;
                                     count = count - 1;
                                     if (isNaN(twt) || twt == 0 ) {
                                         bootbox.alert('<?php echo $this->lang->line('x_total'); ?>');
                                         return false;
                                     }
                                     twt = parseFloat(twt).toFixed(2);

                                     $('#twt').text(twt);
									 
                                     $('#item_count').text(count_productos);
                                     $('#paid-amount').change(function(){ $('#paid_val').val($(this).val()); });
                                     $('#ptclick').trigger('click');
                                     count = count + 1;
                                     
                                     $('#paymentModal').modal();
                                     
                                     $("#paid_by").change(function() {
                                         var p_val = $(this).val();
                                         $('#rpaidby').val(p_val);
                                         if(p_val == 'cash') {
                                            $('.pcheque').hide();
                                            $('.pcc').hide();
                                            $('.pcash').show();
                                             $('input[id^="paid-amount"]').keydown(function(e) {
                                                 paid = $(this).val();
                                                 if (e.keyCode == 13) {
                                                     if (paid < total) {
                                                         bootbox.alert('<?php echo $this->lang->line('paid_l_t_payable'); ?>');
                                                         return false;
                                                     }
                                                     $("#balance").empty();
                                                     var balance = paid - twt;
                                                     balance = parseFloat(balance).toFixed(2);
                                                     $("#balance").append(balance);

                                                     e.preventDefault();
                                                     return false;
                                                 }
                                             });
                                         } else if (p_val == 'CC') { 
                                                $('.pcheque').hide();
                                                $('.pcash').hide();
                                                $('.pcc').show();
                                        } else if (p_val == 'Cheque') { 
                                                $('.pcc').hide();
                                                $('.pcash').hide();
                                                $('.pcheque').show();
                                        } else {
                                                $('.pcheque').hide();
                                                $('.pcc').hide();
                                                $('.pcash').hide();
                                        }                                        
                                     });
                                     
                                     $('#paid-amount').keyboard({
                                         restrictInput: true,
                                         preventPaste: true,
                                         autoAccept: true,
                                         alwaysOpen: false,
                                         openOn: 'click',
                                         layout: 'costom',
                                         display: {
                                             'a': '\u2714:Accept (Shift-Enter)',
                                             'accept': 'Accept:Accept (Shift-Enter)',
                                             'b': '\u2190:Backspace',
                                             'bksp': 'Bksp:Backspace',
                                             'c': '\u2716:Cancel (Esc)',
                                             'cancel': 'Cancel:Cancel (Esc)',
                                             'clear': 'C:Clear'
                                         },
                                         position: {
                                             of: null,
                                             my: 'center top',
                                             at: 'center top',
                                             at2: 'center bottom'
                                         },
                                         usePreview: false,
                                         customLayout: {
                                             'default': [
                                                 '1 2 3 {clear}',
                                                 '4 5 6 .',
                                                 '7 8 9 0',
                                                 '{accept} {cancel}'
                                             ]
                                         },
                                         beforeClose: function(e, keyboard, el, accepted) {

                                             var paid = parseFloat(el.value);
                                             if (paid < twt) {
                                                 bootbox.alert('<?php echo $this->lang->line('paid_l_t_payable'); ?>');
                                                 $(this).val('');
                                                 return false;
                                             }
                                             $("#balance").empty();
                                             var balance = paid - twt;
                                             balance = parseFloat(balance).toFixed(2);
                                             if (balance != "NaN") {
                                                 $("#balance").append(balance);
                                             }
                                         }
                                     });
								 }

                                 $("#paymentModal").on("click", '#submit-sale', function() {
								 
<?php if ($sid) { ?>
                                         suspend = $('<span></span>');
                                         suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" />');
                                         suspend.appendTo("#hidesuspend");
<?php } ?>
                                     $('#total_item').val(count);
                                     bootbox.confirm("<?php echo $this->lang->line('sure_to_submit_sale'); ?>", function(gotit) {
                                         if (gotit) {
                                             $('#submit').trigger('click');
                                         }
                                     });
                                     $('#bootbox-modal').on('shown', function() {
                                         $('#paymentModal').css('opacity', .4);
                                     });
                                     $('#bootbox-modal').on('hidden', function() {
                                         $('#paymentModal').css('opacity', 1);
                                     });

                                 });


                                 $('#suspend').click(function() {
                                     if (count <= 1) {
                                         bootbox.alert('<?php echo $this->lang->line('x_suspend'); ?>');
                                         return false;
                                     }
                                     suspend = $('<span></span>');
<?php if ($sid) { ?>
                                         suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" /><input type="hidden" name="suspend" value="yes" />');
<?php } else { ?>
                                         suspend.html('<input type="hidden" name="suspend" value="yes" />');
<?php } ?>
                                     suspend.appendTo("#hidesuspend");
                                     $('#total_item').val(count_productos);
                                     bootbox.confirm("<?php echo $this->lang->line('sure_to_suspend_sale'); ?>", function(gotit) {
                                         if (gotit) {
                                             $('#submit').trigger('click');
                                         }
                                     });

                                 });
                                 
<?php if ($sid) { ?>

                                     $.ajax({
                                         type: "post",
                                         async: false,
                                         dataType: "json",
                                         url: "index.php?module=pos&view=load_suspended_bill",
                                         data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", id: <?php echo $sid; ?>},
                                         success: function(data) {
                                             if (data != null) {
                                                 if (data.sale_data != "undefined") {
                                                     sale_data = unescape(data.sale_data);
                                                 } else {
                                                     sale_data = "<tbody></tbody>";
                                                 }
                                                 if (data.count != null) {
                                                     sale_count = parseInt(data.count);
                                                 } else {
                                                     sale_count = 1;
                                                 }
                                                 if (data.tax1 != null) {
                                                     sale_tax1 = parseFloat(data.tax1);
                                                 } else {
                                                     sale_tax1 = 0;
                                                 }
                                                 if (data.tax2 != null) {
                                                     sale_tax2 = parseFloat(data.tax2);
                                                 } else {
                                                     sale_tax2 = 0;
                                                 }
                                                 if (data.discount != null) {
                                                     sale_discount = parseFloat(data.discount);
                                                 } else {
                                                     sale_discount = 0;
                                                 }
                                                 if (data.inv_total != null) {
                                                     sale_total = parseFloat(data.inv_total);
                                                 } else {
                                                     sale_total = 0;
                                                 }
                                                 if (data.g_total != null) {
                                                     g_total = parseFloat(data.g_total);
                                                 } else {
                                                     g_total = 0;
                                                 }
                                             } else {
                                                 sale_data = "<tbody></tbody>";
                                                 sale_count = 1;
                                                 sale_tax1 = 0;
                                                 sale_tax2 = 0;
                                                 sale_discount = 0;
                                                 sale_total = 0;
                                                 g_total = 0;
                                             }
                                         },
                                         error: function() {
                                             sale_data = "<tbody></tbody>";
                                             sale_count = 1;
                                             sale_tax1 = 0;
                                             sale_tax2 = 0;
                                             sale_discount = 0;
                                             sale_total = 0;
                                             g_total = 0;
                                         }

                                     });

                                     $("#saletbl").html(sale_data);
                                     count = sale_count;
                                     an = sale_count;
                                     total = sale_total;
                                     tax_value = sale_tax1;
                                     tax_value2 = sale_tax2;
                                     total_discount = sale_discount;
                                     current = parseFloat(total).toFixed(2);
                                     grand_total = parseFloat(g_total).toFixed(2);
                                     current_tax = parseFloat(tax_value).toFixed(2);
                                     current_tax2 = parseFloat(tax_value2).toFixed(2);
                                     current_discount = parseFloat(total_discount).toFixed(2);

                                     $("#total-payable").empty();
                                     $("#total-payable").append(grand_total);
                                     $("#total").empty();
                                     $("#total").append(current);
                                     $("#count").empty();
                                     //$("#count").append(count - 1);
                                     $("#count").append($('#saletbl tbody > tr').length -1 );

    <?php if (TAX1) { ?>$("#tax").empty();
                                $("#tax").append(current_tax);<?php } ?>
    <?php if (TAX2) { ?>$("#tax2").empty(); $("#tax2").append(current_tax2);<?php } ?>
    <?php if (DISCOUNT_OPTION == 1 || DISCOUNT_OPTION == 2) { ?>
            $("#ds").empty(); $("#ds").append(current_discount);
    <?php } ?>

<?php } ?>

                        $('a').each(function() {
                            $(this).click(function() {
                                if (($(this).attr("href") != '#' && an > 1) && $(this).attr("class") != 'external') {
                                    gotit = confirm('<?php echo $this->lang->line('leave_alert'); ?>');
                                    if (!gotit) {
                                        return false;
                                    }
                                }
                            });
                        });

                        $('#cats').carouFredSel({
                            auto: false,
                            prev: '#prev2',
                            next: '#next2',
                            pagination: "#pager2",
                            mousewheel: true,
                            swipe: {
                                onMouse: true,
                                onTouch: true
                            }
                        });
/******************************
****       Consulta     *******
******************************/	
					var auxdata;
	//Consulta por nombre o cod
					var auxidproduct="product-xxxx";
					$( "#nombreArticulo" ).autocomplete({						
						source: function( request, response ) {		  
							$.ajax({
								type: "post",
								async: false,
								dataType: "json",
								url: "index.php?module=pos&view=autocompletableProductos",
								data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>",term:$("#nombreArticulo").val()},
								success: function(data) {
									// almacenamos el valor de la respuesta en una variable auxiliar
									auxdata=data;
									//nos viene un array asociativo id(del prducto) y su descricion junto con el codigo
									
									var codNombreArticulo=[];
									  var i=0;
									  //cargamos product para la muestra en el combo
									  for(id in data){     
										for (articulo in data[id]){
										  codNombreArticulo[i++]=data[id][articulo];
										}
									  }
									$("#ui-id-2").zIndex('1050');
									response( codNombreArticulo );					
									//response( data );					
								}
							});	
						},
						select: function( event, ui ) {
							log(ui.item ?  ui.item.label :  "Selecciones un articulo ");
						}
					});
					// Busqueda por codigo de barras
					$('#codBarras').keydown(function(e) {						
						if(e.keyCode == 13){							
							$.ajax({
								type: "post",
								async: false,
								dataType: "json",
								url: "index.php?module=pos&view=autocompletableCodigo",
								data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>",code:$("#codBarras").val()},
								success: function(data) {
									// almacenamos el valor de la respuesta en una variable auxiliar
									log_2(data[0]);				
								}
							});	
						}			
					});
		function log( message ) {
			// ahora recorremos para recuperar el id del producto
			 // una ven seleccionado un valor lo comparamo y recuperamos su id para agregarlo
			for(articulo in message){     
				for (idarticulo in auxdata[articulo]){				  
				  if(message == auxdata[articulo][idarticulo]){
					prducID=idarticulo;
				  }
				}
			}
			articulo=message.split(' - ');
			$("#product").html("<button class=\"btn btn-primary\" type=\"button\"  value=\""+articulo[0]+"\"id=\"product-0001\">Agregar</button>");			
			add_row();
			$( ".respConsultaArticulo" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );			
		}
		
		function log_2( message ) {
			// ahora recorremos para recuperar el id del producto		
			articulo=message.split(' - ');
			$("#product").html("<button class=\"btn btn-primary\" type=\"button\"  value=\""+articulo[0]+"\"id=\"product-0001\">Agregar</button>");			
			add_row();
			$( ".respConsultaArticulo" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );			
		}			
						
						

                    });


                    $(function() {
                        setTimeout(function() {
                            $(".alert").hide('blind', {}, 500)
                        }, 5000);
                    });

<?php if (DTIME == "yes") { ?>
                        function sivamtime() {
                            now = new Date();
                            var month_names = new Array( );
                            month_names[month_names.length] = "January";
                            month_names[month_names.length] = "February";
                            month_names[month_names.length] = "March";
                            month_names[month_names.length] = "April";
                            month_names[month_names.length] = "May";
                            month_names[month_names.length] = "June";
                            month_names[month_names.length] = "July";
                            month_names[month_names.length] = "August";
                            month_names[month_names.length] = "September";
                            month_names[month_names.length] = "October";
                            month_names[month_names.length] = "November";
                            month_names[month_names.length] = "December";
                            var day_names = new Array( );
                            day_names[day_names.length] = "Sunday";
                            day_names[day_names.length] = "Monday";
                            day_names[day_names.length] = "Tuesday";
                            day_names[day_names.length] = "Wednesday";
                            day_names[day_names.length] = "Thursday";
                            day_names[day_names.length] = "Friday";
                            day_names[day_names.length] = "Saturday";
                            hour = now.getHours();
                            min = now.getMinutes();
                            sec = now.getSeconds();
                            if (min <= 9) {
                                min = "0" + min;
                            }
                            if (sec <= 9) {
                                sec = "0" + sec;
                            }
                            if (hour > 12) {
                                hour = hour - 12;
                                add = "PM";
                            }
                            else {
                                hour = hour;
                                add = "AM";
                            }
                            if (hour == 12) {
                                add = "PM";
                            }
                            time = day_names[now.getDay()] + ", " + now.getDate() + " " + month_names[now.getMonth()] + " " + now.getFullYear() + ", " + ((hour <= 9) ? "0" + hour : hour) + ":" + min + ":" + sec + " " + add;
                            if (document.getElementById) {
                                document.getElementById('theTime').innerHTML = time;
                            }
                            else if (document.layers) {
                                document.layers.theTime.document.write(time);
                                document.layers.theTime.document.close();
                            }
                            setTimeout("sivamtime()", 1000);
                        }
                        window.onload = sivamtime;
						
						/*
						enter para q envie directamente el 
						
						*/
						 $("#add_egresos").click(function() {						 
								$.ajax({
                                        type: "post",
                                        async: false,
                                        dataType: "json",
                                        url: "index.php?module=pos&view=add_egresos",
                                        data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", id_tipo: $("#egresos_id_tipo").val(),monto:$("#egresos_monto").val(),id_caja_turno:$("#id_caja_turno").val(),observaciones:$("#observaciones").val()},
                                        success: function(data) {
											//alert(data.confirmacion);
											//limpiamos los campos
											$("#egresos_id_tipo").val('');
											$("#egresos_monto").val('');
											//ocultamos la ventana modal
											$("#egresosModal").modal('hide');											
                                        },
                                        error: function() {
                                             
                                        }
                                     });
									 
									  /******/
						 
						 });
						 
						 
						/*
						enter para q envie directamente el 
						
						*/
						 $("#ini_turno").click(function() {							 
								$.ajax({
                                        type: "post",
                                        async: false,
                                        dataType: "json",
                                        url: "index.php?module=pos&view=ini_caja",
                                        data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", caja_inicial: $("#caja_inicio").val()},
                                        success: function(data) {											
											$("#id_caja_turno").val(data.id_caja_turno);
											//ocultamos la ventana modal
											$("#inicioModal").modal('hide');											
                                        },
                                        error: function() {
                                             
                                        }
                                     });
						 
						 });
						 
						 function get_rendicion_turno(){
							$.ajax({
                                        type: "post",
                                        async: false,
                                        dataType: "json",
                                        url: "index.php?module=pos&view=get_rendicion_turno",
                                        data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", id_caja_turno: $("#id_caja_turno").val()},
                                        success: function(data) {									
											$("#totalVentasTurno").html('$ '+data.total_ventas_turno[0].total);
											if(data.total_egresos_turno[0].total){
												$("#totalEgresosTurno").html('$ '+data.total_egresos_turno[0].total);
												var total_egresos_turno=parseFloat(data.total_egresos_turno[0].total);
											}else{
												$("#totalEgresosTurno").html('$0.00');
												var total_egresos_turno=0;
											}											
											if(data.total_ventas_turno[0].total){
												$("#totalVentasTurno").html('$ '+data.total_ventas_turno[0].total);
												var total_ventas_turno=parseFloat(data.total_ventas_turno[0].total);
											}else{
												$(totalVentasTurno).html('$0.00');
												var total_ventas_turno=0;
											}
											var caja_inicial=parseFloat(data.caja_inicial);
											var total_rendir=parseFloat((total_ventas_turno-total_egresos_turno)+caja_inicial);
											$("#totalRendirTurno").html('$ '+total_rendir.toFixed(2));																																	
											$("#cajaInicialTurno").html('$ '+caja_inicial.toFixed(2));																																	
											$("#retiroCaja").val('$ '+total_rendir.toFixed(2));	
                                        },
                                        error: function() {
                                             
                                        }
                                     }); 
							 
						 }
						
						//Cierre de turno
						
						 $("#cierre_turno").click(function() {						 
								$.ajax({
                                        type: "post",
                                        async: false,
                                        dataType: "json",
                                        url: "index.php?module=pos&view=cierre_turno",
                                        data: {<?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>",id_caja_turno:$("#id_caja_turno").val()},
                                        success: function(data) {
											//alert(data.confirmacion);											
											//limpiamos los campos
											$("#egresos_id_tipo").val('');
											$("#egresos_monto").val('');
											//ocultamos la ventana modal
											$("#egresosModal").modal('hide');	
											window.location.assign('<?='http://'.$_SERVER['SERVER_NAME'].'/sistema/index.php?module=pos'?>');											
                                        },
                                        error: function() {
                                             
                                        }
                                     });									 
									  /******/
						 });
						
		
<?php } ?>
        </script>
    </body>
</html>