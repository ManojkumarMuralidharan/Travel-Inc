<<<<<<< HEAD
<?php /* Smarty version Smarty-3.1.8, created on 2012-07-17 20:20:11
=======
<?php /* Smarty version Smarty-3.1.8, created on 2012-06-18 22:25:58
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
         compiled from ".\templates\budget.tpl" */ ?>
<?php /*%%SmartyHeaderCode:312574fdf7b40445a62-90434052%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f8e959f14b854ddf4a1d6fbf34e913935b3ad41' => 
    array (
      0 => '.\\templates\\budget.tpl',
<<<<<<< HEAD
      1 => 1342543577,
=======
      1 => 1340051153,
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
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
	   
<<<<<<< HEAD
	<table>
	<tr>
	<td>
	<span>Financial Year</span>
	</td>
	<td>
	<select id="financialYearSelect">
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2010-2011</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2011-2012</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2012-2013</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2013-2014</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2014-2015</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2015-2016</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2016-2017</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2017-2018</option>;
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2018-2019</option>
	<option value='2010-2011' onClick='budgetYear=$(this).text();'>2019-2020</option>;
	
	
	</select>
	</td>
	</tr>
	</table>
=======
	
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
    
<table id="rounded-corner" summary="Budget details">
    <thead>
    	<tr>
        	
            <th scope="col" class="rounded-company">PSID</th>
            <th scope="col" class="rounded">Name</th>
<<<<<<< HEAD
			<th scope="col" class="rounded">Proposed</th>
			<th scope="col" class="rounded">Actuals</th>
			<th scope="col" class="rounded">Fiscal Year</th>
			<th scope="col" class="rounded">Current expense</br> limit</th>
			<th scope="col" class="rounded-q4"></th>
=======
			<th scope="col" class="rounded">Propsed</br> Budget</th>
			<th scope="col" class="rounded-q4">Budget</th>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
		
            

        </tr>
    </thead>
        <tfoot>
    	<tr>
<<<<<<< HEAD
        	<td colspan="6" style="width:835px;"class="rounded-foot-left"><em>Your have <?php echo $_smarty_tpl->tpl_vars['budgetUserCount']->value;?>
=======
        	<td colspan="3" style="width:835px;"class="rounded-foot-left"><em>Your have <?php echo $_smarty_tpl->tpl_vars['budgetUserCount']->value;?>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
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