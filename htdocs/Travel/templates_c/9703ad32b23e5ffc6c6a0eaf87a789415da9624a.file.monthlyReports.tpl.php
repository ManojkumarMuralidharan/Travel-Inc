<?php /* Smarty version Smarty-3.1.8, created on 2012-06-06 16:09:29
         compiled from ".\templates\monthlyReports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:310854fb66d7f47d0d3-60868624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9703ad32b23e5ffc6c6a0eaf87a789415da9624a' => 
    array (
      0 => '.\\templates\\monthlyReports.tpl',
      1 => 1338991764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '310854fb66d7f47d0d3-60868624',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb66d7f483558_44698488',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb66d7f483558_44698488')) {function content_4fb66d7f483558_44698488($_smarty_tpl) {?><form action="" method="post" style="display:block;" id="Monthly" class="niceform"><!--Start of monthly form -->



                <fieldset>
                   
                    <dl>
                        <dt><label for="Year">Year:</label></dt>
                        <dd>
                            <select size="1" name="gender"  id="">
								<option value="" onClick="Notifier.warning('Select a year');"></option>
                                <option value="1999" onClick="monthlyReportsYear=this.text;">1999</option>
                                <option value="2000" onClick="monthlyReportsYear=this.text;">2000</option>
                                <option value="2001" onClick="monthlyReportsYear=this.text;">2001</option>
                                <option value="2002" onClick="monthlyReportsYear=this.text;">2002</option>
                                <option value="2003" onClick="monthlyReportsYear=this.text;">2003</option>
								<option value="2012" onClick="monthlyReportsYear=this.text;">2012</option>
                            </select>
                        </dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="month">Month:</label></dt>
                        <dd>
						    <input type="checkbox" name="interests[]" id="" value="all" /><label class="check_label">All</label>
                            <input type="checkbox" name="interests[]" id="" value="1" /><label class="check_label">Jan</label>
                            <input type="checkbox" name="interests[]" id="" value="2" /><label class="check_label">Feb</label>
                            <input type="checkbox" name="interests[]" id="" value="3" /><label class="check_label">Mar</label>
                            <input type="checkbox" name="interests[]" id="" value="4" /><label class="check_label">Apr</label>
							<input type="checkbox" name="interests[]" id="" value="5" /><label class="check_label">May</label>
                            <input type="checkbox" name="interests[]" id="" value="6" /><label class="check_label">Jun</label>
                            <input type="checkbox" name="interests[]" id="" value="7" /><label class="check_label">Jul</label>
                            <input type="checkbox" name="interests[]" id="" value="8" /><label class="check_label">Aug</label>
							<input type="checkbox" name="interests[]" id="" value="9" /><label class="check_label">Sep</label>
                            <input type="checkbox" name="interests[]" id="" value="10" /><label class="check_label">Oct</label>
                            <input type="checkbox" name="interests[]" id="" value="11" /><label class="check_label">Nov</label>
                            <input type="checkbox" name="interests[]" id="" value="12" /><label class="check_label">Dec</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="button" name="generateMonthlyReports" id="generateMonthlyReports" value="Generate" />
					 <input type="button" name="Clear" id="clear" value="Clear" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form><!--End of monthly form -->
		 
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

	<div id="backgroundPopup"></div>  	<?php }} ?>