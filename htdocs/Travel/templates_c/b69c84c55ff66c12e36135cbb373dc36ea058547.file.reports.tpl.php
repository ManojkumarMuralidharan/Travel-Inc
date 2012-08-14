<<<<<<< HEAD
<?php /* Smarty version Smarty-3.1.8, created on 2012-07-30 18:25:38
=======
<?php /* Smarty version Smarty-3.1.8, created on 2012-06-01 20:06:39
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
         compiled from ".\templates\reports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:293284fb555b96065a0-05138723%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b69c84c55ff66c12e36135cbb373dc36ea058547' => 
    array (
      0 => '.\\templates\\reports.tpl',
<<<<<<< HEAD
      1 => 1343665534,
=======
      1 => 1338573994,
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
      2 => 'file',
    ),
  ),
  'nocache_hash' => '293284fb555b96065a0-05138723',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb555b960e767_38654841',
  'variables' => 
  array (
    'reportCount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb555b960e767_38654841')) {function content_4fb555b960e767_38654841($_smarty_tpl) {?>    
    
    
     
   
	
    <div class="right_content" >   
	    <div>
	<?php echo $_smarty_tpl->getSubTemplate ("reportsOption.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </div>	
	<div>
		<div class="form" id="reportsDisplay">
        
		 <div>
		 <?php echo $_smarty_tpl->getSubTemplate ("regularReports.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		 </div>
         </div>  
     </div>
    



    <h2>Results</h2> 
    
<table id="rounded-corner" summary=" Travel Reports ">
    <thead>
    	<tr>
        	
            <th scope="col" class="rounded-company">Transaction</th>
            <th scope="col" class="rounded">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Origin</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded">Cost</th>
			<th scope="col" class="rounded">Purpose</th>
			<th scope="col" class="rounded-q4">Comments</th>
            

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="8" style="width:835px;"class="rounded-foot-left"><em id='reportCount'>Your have <?php echo $_smarty_tpl->tpl_vars['reportCount']->value;?>
 results.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody id="reportsContents">
	
    
    	
    </tbody>
</table>
<table style="padding-left:180px;">
<tr><td>
<div style="align:center;">
<<<<<<< HEAD
	 <a href="#" class="bt_red" id="emailRegularExcel"  style="display:block"><span class="bt_red_lft"></span><strong>Email</strong><span class="bt_red_r"></span></a>
	  <a href="#" class="bt_red" id="emailMonthlyExcel" style="display:none" ><span class="bt_red_lft"></span><strong>Email</strong><span class="bt_red_r"></span></a>
=======
	 <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Email</strong><span class="bt_red_r"></span></a>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
	<a href="#"  id="generateMonthlyConsolidatedExcel" style="display:none" class="bt_green"><span class="bt_green_lft"></span><strong>Consolidated Excel</strong><span class="bt_green_r"></span></a> 
     <a href="#"  id="generateRegularExcel" style="display:block" class="bt_green"><span class="bt_green_lft"></span><strong>Export to Excel</strong><span class="bt_green_r"></span></a> 
	 <a href="#"  id="generateMonthlyExcel" style="display:none" class="bt_green"><span class="bt_green_lft"></span><strong>Export to Excel</strong><span class="bt_green_r"></span></a> 
</div>
</td></tr>
</table>
     
        <div id="reportRecordsPaginationElement" class="pagination">
       
        </div> 
     
    
         
     
     </div><!-- end of right content-->
          
    <?php }} ?>