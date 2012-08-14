<?php /* Smarty version Smarty-3.1.8, created on 2012-07-20 15:25:50
         compiled from ".\templates\regularReports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:142284fb66d884c0930-46900572%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b783d588c7c8303150ee49a189be269a20c8f920' => 
    array (
      0 => '.\\templates\\regularReports.tpl',
      1 => 1342790174,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '142284fb66d884c0930-46900572',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb66d884c5c66_09735854',
  'variables' => 
  array (
    'subordinates' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb66d884c5c66_09735854')) {function content_4fb66d884c5c66_09735854($_smarty_tpl) {?> <form action="" method="post" style="display:block;" id="regular" class="niceform">
    <script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#datepicker1" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
	});
	</script>
                <fieldset>
                    <dl>
                        <dt><label for="dateFrom">Date From:</label></dt>
                        <dd><p><input type="text" id="datepicker"/></p></dd>
                    </dl>
                    <dl>
                        <dt><label for="dateTo">Date To:</label></dt>
                        <dd><p><input type="text" id="datepicker1" /></p></dd>
                    </dl>
                    
                    
                   <?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp1=='supervisor'||$_tmp2=='hr'||$_tmp3=='finance'||$_tmp4=='president'){?> 
                    <dl>
                        <dt><label for="Users">Users:</label></dt>
                        <dd>
   `	
                            <select size="1" name="gender" id="reportUserSelect">
							<option val="" onClick="Notifier.warning('Please select an option');"></option>
								<?php echo $_smarty_tpl->tpl_vars['subordinates']->value;?>

                            </select>
                        </dd>
                    </dl>
                    <?php }?>
                    
                    <dl>
                    <dt><label for="travelType">Travel Type</label></dt>
                    <dd>
					<table>	
					<tr>
					 <td><label class="check_label">Domestic</label></td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio NFh" id="travelTypeLocal" onclick="reportsTravelType='local';$('#travelTypeLocal').toggleClass('NFh');$('#travelTypeInternational').attr('Class','NFRadio');$('#travelTypeBoth').attr('Class','NFRadio');"></div></td>
					 
					 <td><label  style="padding-left:25px;" class="check_label">International</label></td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio" id="travelTypeInternational" onclick="reportsTravelType='international';$('#travelTypeLocal').attr('Class','NFRadio');$('#travelTypeInternational').toggleClass('NFh');$('#travelTypeBoth').attr('Class','NFRadio');"></div></td>
					 
					 <td><label style="padding-left:30px;" class="check_label">Both</label>	</td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio" id="travelTypeBoth" onclick="reportsTravelType='both';$('#travelTypeLocal').attr('Class','NFRadio');$('#travelTypeInternational').attr('Class','NFRadio');$('#travelTypeBoth').toggleClass('NFh');"></div></td>
					 </tr>
					 </table>
                    </dd>
                    </dl>
                    
                     <dl class="submit">
					 <dd>
                    <input type="button" name="generateReportsButton" id="generateReportsButton" value="Generate" />
					 <input type="button" name="Clear" id="99" value="Clear" />
                    <dd> </dl>
                     
                     
                    
                </fieldset>
                
         </form>
		   <div id="popupDisplayReportComments">  
			<a id="popupDisplayReportCommentsClose">x</a>  
			<h1 id="popupReportCommentsTitle">Comments</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   
		   <tr>
		   
		   <td><textarea name="comments" id="reports_comments" rows="5" cols="36" readonly></textarea></td>
		   </tr>
		   </Table>
         </form>
		 
         </div> 
		</div>  

	<div id="backgroundPopup"></div>  		<?php }} ?>