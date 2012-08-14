    
    
    
     
   
	
    <div class="right_content" >   
	   
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
    
<table id="rounded-corner" summary="Budget details">
    <thead>
    	<tr>
        	
            <th scope="col" class="rounded-company">PSID</th>
            <th scope="col" class="rounded">Name</th>
			<th scope="col" class="rounded">Proposed</th>
			<th scope="col" class="rounded">Actuals</th>
			<th scope="col" class="rounded">Fiscal Year</th>
			<th scope="col" class="rounded">Current expense</br> limit</th>
			<th scope="col" class="rounded-q4"></th>
		
            

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="6" style="width:835px;"class="rounded-foot-left"><em>Your have {$budgetUserCount} results.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody id="budgetContents" style="height: 262px;overflow-y: auto;width: 100%">
	
    {$budgetDetails}
    	
    </tbody>
</table>
     
        <div id="reportRecordsPaginationElement" class="pagination">
       
        </div> 
     
    
         
      
     
     </div><!-- end of right content-->
          
    