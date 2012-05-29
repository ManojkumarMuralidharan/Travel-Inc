<form action="" method="post" style="display:block;" id="Monthly" class="niceform"><!--Start of monthly form -->



                <fieldset>
                   
                    <dl>
                        <dt><label for="Year">Year:</label></dt>
                        <dd>
                            <select size="1" name="gender" id="monthlyReportsYear">
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

	<div id="backgroundPopup"></div>  	