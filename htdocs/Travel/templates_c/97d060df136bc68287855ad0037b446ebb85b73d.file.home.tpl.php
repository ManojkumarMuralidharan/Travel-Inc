<?php /* Smarty version Smarty-3.1.8, created on 2012-05-18 22:35:13
         compiled from ".\templates\home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:206224fb55589f273d8-72747964%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97d060df136bc68287855ad0037b446ebb85b73d' => 
    array (
      0 => '.\\templates\\home.tpl',
      1 => 1337373260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '206224fb55589f273d8-72747964',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb55589f304f7_52548359',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb55589f304f7_52548359')) {function content_4fb55589f304f7_52548359($_smarty_tpl) {?>    
    
    
     
    
    <div class="right_content">            
        
    <h2>My Requests</h2> 
                    
                    
<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company"></th>
            <th scope="col" class="rounded">ID</th>
            <th scope="col" class="rounded">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Source</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded">Cost</th>
			<th scope="col" class="rounded">Purpose</th>
			<th scope="col" class="rounded">Comments</th>
            <th scope="col" class="rounded-q4">Edit</th>

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="10" style="width:835px;"class="rounded-foot-left"><em>You have made 2 requests.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody>
    	<tr>
        	<td><input type="checkbox" name="" /></td>
            <td>#12345</td>
            <td>12/05/2010</td>
            <td>12/05/2010</td>
            <td>Mumbai,India</td>
			<td>Washington</td>
			<td>International</td>
            <td>1500$</td>
            <td>12/05/2010</td>
            <td><a href="#" class="commentsDisplay"><img src="images/request_comment.png" alt="" title="" border="0" /></a></td>
            <td><a href="#"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
           
        </tr>
        
    	<tr>
        	<td><input type="checkbox" name="" /></td>
            <td>#22342</td>
            <td>12/05/2010</td>
            <td>12/05/2010</td>
            <td>Seattle,CA</td>
			<td>TX</td>
			<td>Local</td>
            <td>2000$</td>
            <td>12/05/2010</td>
			<td><a href="#" class="commentsDisplay"><img src="images/request_comment.png" alt="" title="" border="0" /></a></td>
            <td><a href="#"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
           
        </tr> 
        
    	
    </tbody>
</table>
<table style="padding-left:280px;">
<tr><td>
<div style="align:center;">
	 <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Cancel request</strong><span class="bt_red_r"></span></a>
     <a href="#" id="createRequest" class="bt_green"><span class="bt_green_lft"></span><strong>New Request</strong><span class="bt_green_r"></span></a> 
</div>
</td></tr>
</table>
     
        <div class="pagination">
        <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>...<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
        </div> 
     
    
         
      
     
     </div><!-- end of right content-->
            
    <div class="right_content" style="display:block;">  <!-- start of Super visior content-->          
        
    <h2>Request pending for approval</h2> 
                    
                    
<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company"></th>
            <th scope="col" class="rounded">ID</th>
            <th scope="col" class="rounded">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Source</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded">Cost</th>
			<th scope="col" class="rounded">Purpose</th>
			<th scope="col" class="rounded">Comments</th>
            <th scope="col" class="rounded-q4">Decline/<br>On-Hold</th>

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="10" style="width:835px;" class="rounded-foot-left"><em>You have 3 pending requests.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody>
        
    	<tr>
        	<td><input type="checkbox" name="" /></td>
            <td>#72342</td>
            <td>12/05/2010</td>
            <td>12/05/2010</td>
			<td>JFK</td>
           
            <td>Phoenix,AZ</td>
			<td>Local</td>
            <td>5000$</td>
            <td>12/05/2010</td>
			<td><a href="#" class="commentsDisplay"><img src="images/request_comment.png" alt="" title="" border="0" /></a></td>
            <td><a href="#" class="del"><img src="images/trash.png" alt="" title="" border="0" /></a></td>
            
        </tr>  
    	<tr>
        	<td><input type="checkbox" name="" /></td>
            <td>#42642</td>
            <td>12/05/2010</td>
            <td>12/05/2010</td>
            <td>NYC</td>
			<td>TX</td>
			<td>Local</td>
            <td>300$</td>
            <td>12/05/2010</td>
			<td><a href="#" class="commentsDisplay"><img src="images/request_comment.png" alt="" title="" border="0" /></a></td>           
		    <td><a href="#" class="del"><img src="images/trash.png" alt="" title="" border="0" /></a></td>
           
        </tr>
        
    	<tr>
        	<td><input type="checkbox" name="" /></td>
            <td>#22342</td>
            <td>12/05/2010</td>
            <td>12/05/2010</td>
            <td>Florida</td>
			<td>Bulgaria</td>
			<td>International</td>
            <td>1200$</td>
            <td>12/05/2010</td>
			<td><a href="#" class="commentsDisplay"><img src="images/request_comment.png" alt="" title="" border="0" /></a></td>
            <td><a href="#" class="del"><img src="images/trash.png" alt="" title="" border="0" /></a></td>
          
        </tr>    
        
    </tbody>
</table>
<table style="padding-left:275px;">
<tr><td>
<div style="align:center;">
	 
     <a href="#" style="position:relative;" class="bt_blue"><span class="bt_blue_lft"></span><strong>OnHold</strong><span class="bt_blue_r"></span></a>
     <a href="#" style="position:relative;"  class="bt_red"><span class="bt_red_lft"></span><strong>Decline</strong><span class="bt_red_r"></span></a> 
	 <a href="#" style="position:relative;" id="createRequest" class="bt_green"><span class="bt_green_lft"></span><strong>Approve</strong><span class="bt_green_r"></span></a>
    
 </div> 
</td></tr>
</table> 
        <div class="pagination">
        <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>...<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
        </div> 
     
    
         
      
     
     </div><!-- end of Super visior content -->
	 
	 <?php }} ?>