    
    
    
     
    
    <div class="right_content">            
        <script>
		// justLogged=1;
		//alert(justLogged);
		 if(justLogged==1){
		 var contentText=$("#titleUserName").text();
		 var text=contentText.split(",",2);
		Notifier.info(text[0]);
		justLogged=0;
		 }
		</script>
    <h2>My Requests</h2> 
                    
<table class="rounded-corner" summary="2007 Major IT Companies' Profit">
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
			<th scope="col" class="rounded">Supervisor</br>Comments</th>
            <th scope="col" class="rounded-q4">Edit</th>

        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="10" style="width:835px;"class="rounded-foot-left"><em>You have made {$userRecordCount} requests.</em></td>
        	<td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
    <tbody>
        
    	{$userRecordContent}
		
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
            
			
			
{if {$smarty.session.profile} eq 'supervisor'}
			 <div class="right_content" style="display:block;">  <!-- start of Super visior content-->          
        
				<h2>Request pending for approval</h2> 
                    
                    
			<table class="rounded-corner" summary="2007 Major IT Companies' Profit">
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
					<th scope="col" class="rounded">Requestor</br>Reason</th>
					<th scope="col" class="rounded-q4">Decline/<br>On-Hold</th>

				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="10" style="width:835px;" class="rounded-foot-left"><em>You have {$supervisorRecordCount} pending requests.</em></td>
					<td class="rounded-foot-right">&nbsp;</td>

				</tr>
				</tfoot>
				<tbody>
					{$supervisorRecordContent}
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
{/if}
 
   
         <div id="popupDisplayComments">  
			<a id="popupDisplayCommentsClose">x</a>  
			<h1 id="popupCommentsTitle">Comments</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   
		   <tr>
		   
		   <td><textarea name="comments" id="supervisor_comments" rows="5" cols="36" readonly></textarea></td>
		   </tr>
		   </Table>
         </form>
		 
         </div> 
		</div>  

	<div id="popupComments">  
			<a id="popupCommentsClose">x</a>  
			<h1>Decline / On Hold</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   
		  
		   <tr>
		   <td>Reasons</td>
		   <td><textarea name="Reasons" id="reasonRequest" rows="5" cols="36" readonly></textarea></td>
		   </tr>
		   <tr>
		   <td>Comments</td>
		   <td><textarea name="comments" id="supervisor_comments_popup" rows="5" cols="36"></textarea></td>
		   </tr>
		   </Table>
		   <Table style="padding-left:70px"><tr><td>
		   <a href="#" id="popupOnHold" style="position:relative;" class="bt_blue"><span class="bt_blue_lft"></span><strong>OnHold</strong><span class="bt_blue_r"></span></a>
		   </td>
		   

		   <td>
		   <a href="#" id="popupOnDecline" style="position:relative;"  class="bt_red"><span class="bt_red_lft"></span><strong>Decline</strong><span class="bt_red_r"></span></a> 
		   </td>
		   </tr>
		   </Table>
         </form>
		 
         </div> 
		</div>  
		<div id="popupContact">  
			<a id="popupContactClose">x</a>  
			<h1>Create your Request</h1>  
			<div class="form">
         <form action="" id="RequestPopupform" method="post" class="niceform">
		   <Table>
		   <tr>
		   <td>Type of Travel</td>
		   <td>
		   
		   <div class="NewSelect" onClick="newSelect();"> 
		   <img src="img/0.png" class="NewSelectLeft">
		   <div class="NewSelectRight" id="travelTypeFormElement">Local</div>
			   <div class="NewSelectTarget" id="123" style="display: none; ">
				   <ul class="NewSelectOptions">
				   <li><a href="javascript:;" onClick="travelType='local';$('#travelTypeFormElement').text('Local');">Local</a></li>
				   <li><a href="javascript:;" onClick="travelType='international';$('#travelTypeFormElement').text('International');">International</a></li>
				   </ul>
			   </div>
		   </div>
		 
		  
		   
		   </td>   
		   </tr>
		   
		   <tr>
		   <td>Source</td>
		   <td><input type="text" id="newRequestSource"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Destination</td>
		   <td><input type="text" id="newRequestDestination" /></td>   
		   </tr>

		   <tr>
		   <td>From Date</td>
		   <td><p><input type="text" id="newRequestFromDate" /></p></td>   
		   </tr>
		   
		   <tr>
		   <td>To Date</td>
		   <td><p><input type="text" id="newRequestToDate"/></p></td>   
		   </tr>
		   
		   <tr>
		   <td>Purpose</td>
		   <td><input type="text" id="newRequestPurpose"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Cost</td>
		   <td><input type="text" id="newRequestCost"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Comments</td>
		   <td><textarea name="comments" id="newRequestComments" rows="5" cols="36"></textarea></td>
		   </tr>
		   
		   
		   </Table>
		   <Table style="padding-left:150px"><tr><td>
		   <input type="button" name="submit" id="createNewRequestButton" value="Submit" /></td>
		   </td></tr>
		   </Table>
         </form>
		 
         </div> 
		</div>  
		<!-- start of Edit Popup -->
		<div id="popupEditContact">  
			<a id="popupEditContactClose">x</a>  
			<h1>Update your Request</h1>  
			<div class="form">
         <form action="" id="RequestEditPopupform" method="post" class="niceform">
		   <Table>
		   <tr>
		   <td>ID</td>
		   <td><input type="text" id="editRequestid"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Type of Travel</td>
		   <td>
		   
		   <div class="NewSelect" onClick="newSelect();"> 
		   <img src="img/0.png" class="NewSelectLeft">
		   <div class="NewSelectRight" id="travelTypeEditFormElement">Local</div>
			   <div class="NewSelectTarget" id="editTravelTypeDiv" style="display: none; ">
				   <ul class="NewSelectOptions">
				   <li><a href="javascript:;" onClick="travelType='local';$('#travelTypeEditFormElement').text('Local');">Local</a></li>
				   <li><a href="javascript:;" onClick="travelType='international';$('#travelEditTypeFormElement').text('International');">International</a></li>
				   </ul>
			   </div>
		   </div>
		 
		  
		   
		   </td>   
		   </tr>
		   
	
		   
		   <tr>
		   <td>Source</td>
		   <td><input type="text" id="editRequestSource"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Destination</td>
		   <td><input type="text" id="editRequestDestination" /></td>   
		   </tr>

		   <tr>
		   <td>From Date</td>
		   <td><p><input type="text" id="editRequestFromDate" /></p></td>   
		   </tr>
		   
		   <tr>
		   <td>To Date</td>
		   <td><p><input type="text" id="editRequestToDate"/></p></td>   
		   </tr>
		   
		   <tr>
		   <td>Purpose</td>
		   <td><input type="text" id="editRequestPurpose"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Cost</td>
		   <td><input type="text" id="editRequestCost"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Comments</td>
		   <td><textarea name="comments" id="editRequestComments" rows="5" cols="36"></textarea></td>
		   </tr>
		   
		   
		   </Table>
		   <Table style="padding-left:150px"><tr><td>
		   <input type="button" name="submit" id="editRequestButton" value="Edit Request" /></td>
		   </td></tr>
		   </Table>
         </form>
		 
         </div> 
		</div> 
		
	<div id="backgroundPopup"></div>  
   <script>   
     
    
	   // M7();
	 </script>