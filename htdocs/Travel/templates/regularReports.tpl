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
                    
                    
                    
                    <dl>
                        <dt><label for="Users">Users:</label></dt>
                        <dd>
                            <select size="1" name="gender" id="">
                                <option value="">User1</option>
                                <option value="">User2</option>
                                <option value="">User3</option>
                                <option value="">User4</option>
                                <option value="">User5</option>
                            </select>
                        </dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="travelType">Travel Type</label></dt>
                        <dd>
                            <input type="radio" name="travelType" id="travelType1" value="1" /><label class="check_label">Domestic</label>
                            <input type="radio" name="travelType" id="travelType2" value="2" /><label class="check_label">International</label>
                            <input type="radio" name="travelType" id="travelType3" value="3" /><label class="check_label">Both</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="generate" id="generate" value="Generate" />
					 <input type="button" name="Clear" id="clear" value="Clear" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>