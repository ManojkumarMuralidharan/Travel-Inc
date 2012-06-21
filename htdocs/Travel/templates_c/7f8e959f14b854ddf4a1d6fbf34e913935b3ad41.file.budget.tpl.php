<?php /* Smarty version Smarty-3.1.8, created on 2012-06-18 22:25:58
         compiled from ".\templates\budget.tpl" */ ?>
<?php /*%%SmartyHeaderCode:312574fdf7b40445a62-90434052%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f8e959f14b854ddf4a1d6fbf34e913935b3ad41' => 
    array (
      0 => '.\\templates\\budget.tpl',
      1 => 1340051153,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '312574fdf7b40445a62-90434052',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fdf7b40505fb1_30495414',
  'variables' => 
  array (
    'budgetUserCount' => 0,
    'budgetDetails' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fdf7b40505fb1_30495414')) {function content_4fdf7b40505fb1_30495414($_smarty_tpl) {?>    
    
    
     
   
	
    <div class="right_content" >   
	   
	
    
<table id="rounded-corner" summary="Budget details">
    <thead>
    	<tr>
        	
            <th scope="col" class="rounded-company">PSID</th>
            <th scope="col" class="rounded">Name</th>
			<th scope="col" class="rounded">Propsed</br> Budget</th>
			<th scope="col" class="rounded-q4">Budget</th>
		
            

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="3" style="width:835px;"class="rounded-foot-left"><em>Your have <?php echo $_smarty_tpl->tpl_vars['budgetUserCount']->value;?>
 results.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody id="budgetContents" style="height: 262px;overflow-y: auto;width: 100%">
	
    <?php echo $_smarty_tpl->tpl_vars['budgetDetails']->value;?>

    	
    </tbody>
</table>
     
        <div id="reportRecordsPaginationElement" class="pagination">
       
        </div> 
     
    
         
      
     
     </div><!-- end of right content-->
          
    <?php }} ?>