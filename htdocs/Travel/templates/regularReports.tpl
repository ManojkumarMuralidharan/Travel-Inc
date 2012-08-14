 <form action="" method="post" style="display:block;" id="regular" class="niceform">
    <script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#datepicker1" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
	});
	</script>
                <fieldset>
                    <dl>
                        <dt><label for="dateFrom">Date From:</label></dt>
                        <dd><p><input type="text" id="datepicker"/></p></dd>
                    </dl>
                    <dl>
                        <dt><label for="dateTo">Date To:</label></dt>
                        <dd><p><input type="text" id="datepicker1" /></p></dd>
                    </dl>
                    
                    
                   {if {$smarty.session.profile} eq 'supervisor'||{$smarty.session.profile} eq 'hr'||{$smarty.session.profile} eq 'finance'||{$smarty.session.profile} eq 'president'} 
                    <dl>
                        <dt><label for="Users">Users:</label></dt>
                        <dd>
   `	
                            <select size="1" name="gender" id="reportUserSelect">
							<option val="" onClick="Notifier.warning('Please select an option');"></option>
								{$subordinates}
                            </select>
                        </dd>
                    </dl>
                    {/if}
                    
                    <dl>
                    <dt><label for="travelType">Travel Type</label></dt>
                    <dd>
					<table>	
					<tr>
					 <td><label class="check_label">Domestic</label></td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio NFh" id="travelTypeLocal" onclick="reportsTravelType='local';$('#travelTypeLocal').toggleClass('NFh');$('#travelTypeInternational').attr('Class','NFRadio');$('#travelTypeBoth').attr('Class','NFRadio');"></div></td>
					 
					 <td><label  style="padding-left:25px;" class="check_label">International</label></td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio" id="travelTypeInternational" onclick="reportsTravelType='international';$('#travelTypeLocal').attr('Class','NFRadio');$('#travelTypeInternational').toggleClass('NFh');$('#travelTypeBoth').attr('Class','NFRadio');"></div></td>
					 
					 <td><label style="padding-left:30px;" class="check_label">Both</label>	</td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio" id="travelTypeBoth" onclick="reportsTravelType='both';$('#travelTypeLocal').attr('Class','NFRadio');$('#travelTypeInternational').attr('Class','NFRadio');$('#travelTypeBoth').toggleClass('NFh');"></div></td>
					 </tr>
					 </table>
                    </dd>
                    </dl>
                    
                     <dl class="submit">
					 <dd>
                    <input type="button" name="generateReportsButton" id="generateReportsButton" value="Generate" />
					 <input type="button" name="Clear" id="99" value="Clear" />
                    <dd> </dl>
                     
                     
                    
                </fieldset>
                
         </form>
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

	<div id="backgroundPopup"></div>  		