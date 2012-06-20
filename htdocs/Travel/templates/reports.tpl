    
    
    
     
   
	
    <div class="right_content" >   
	    <div>
	{include file="reportsOption.tpl"}
    </div>	
	<div>
		<div class="form" id="reportsDisplay">
        
		 <div>
		 {include file="regularReports.tpl"}
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
        	<td colspan="8" style="width:835px;"class="rounded-foot-left"><em>Your have {$reportCount} results.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody id="reportsContents">
	
    
    	
    </tbody>
</table>
<table style="padding-left:180px;">
<tr><td>
<div style="align:center;">
	 <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Email</strong><span class="bt_red_r"></span></a>
	<a href="#"  id="generateMonthlyConsolidatedExcel" style="display:none" class="bt_green"><span class="bt_green_lft"></span><strong>Consolidated Excel</strong><span class="bt_green_r"></span></a> 
     <a href="#"  id="generateRegularExcel" style="display:block" class="bt_green"><span class="bt_green_lft"></span><strong>Export to Excel</strong><span class="bt_green_r"></span></a> 
	 <a href="#"  id="generateMonthlyExcel" style="display:none" class="bt_green"><span class="bt_green_lft"></span><strong>Export to Excel</strong><span class="bt_green_r"></span></a> 
</div>
</td></tr>
</table>
     
        <div id="reportRecordsPaginationElement" class="pagination">
       
        </div> 
     
    
         
      
     
     </div><!-- end of right content-->
          
    