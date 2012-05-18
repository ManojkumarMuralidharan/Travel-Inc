<?php /* Smarty version Smarty-3.1.8, created on 2012-05-18 17:40:47
         compiled from ".\templates\monthlyReports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:310854fb66d7f47d0d3-60868624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9703ad32b23e5ffc6c6a0eaf87a789415da9624a' => 
    array (
      0 => '.\\templates\\monthlyReports.tpl',
      1 => 1337355619,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '310854fb66d7f47d0d3-60868624',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb66d7f483558_44698488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb66d7f483558_44698488')) {function content_4fb66d7f483558_44698488($_smarty_tpl) {?><form action="" method="post" style="display:block;" id="Monthly" class="niceform"><!--Start of monthly form -->
         
                <fieldset>
                   
                    <dl>
                        <dt><label for="Year">Year:</label></dt>
                        <dd>
                            <select size="1" name="gender" id="">
                                <option value="">1999</option>
                                <option value="">2000</option>
                                <option value="">2001</option>
                                <option value="">2002</option>
                                <option value="">2003</option>
                            </select>
                        </dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="month">Month:</label></dt>
                        <dd>
						    <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">All</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Jan</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Feb</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Mar</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Apr</label>
							<input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">May</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Jun</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Jul</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Aug</label>
							<input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Sep</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Oct</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Nov</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Dec</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="generate" id="generate" value="Generate" />
					 <input type="button" name="Clear" id="clear" value="Clear" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form><!--End of monthly form --><?php }} ?>