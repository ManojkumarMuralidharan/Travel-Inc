<?php /* Smarty version Smarty-3.1.8, created on 2012-05-29 16:50:23
         compiled from ".\templates\reports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:293284fb555b96065a0-05138723%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b69c84c55ff66c12e36135cbb373dc36ea058547' => 
    array (
      0 => '.\\templates\\reports.tpl',
      1 => 1338303011,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '293284fb555b96065a0-05138723',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb555b960e767_38654841',
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
    
<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	
            <th scope="col" class="rounded-company">Transaction</th>
            <th scope="col" class="rounded">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Source</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded">Cost</th>
			<th scope="col" class="rounded">Purpose</th>
			<th scope="col" class="rounded-q4">Comments</th>
            

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="8" style="width:835px;"class="rounded-foot-left"><em>Your have 2 results.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody id="reportsContents">
	
    
    	
    </tbody>
</table>
<table style="padding-left:280px;">
<tr><td>
<div style="align:center;">
	 <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Email</strong><span class="bt_red_r"></span></a>
     <a href="#" id="generateExcel" class="bt_green"><span class="bt_green_lft"></span><strong>Export to Excel</strong><span class="bt_green_r"></span></a> 
</div>
</td></tr>
</table>
     
        <div class="pagination">
        <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>...<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
        </div> 
     
    
         
      
     
     </div><!-- end of right content-->
          
    <?php }} ?>