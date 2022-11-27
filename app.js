/**
 * Is triggered whenever a different tab gets active (is clicked on).
 * @param int tab The tab to change to.
 */
function changeSelection(tab)
{
	//get the mass of the tab before the tab change
	var mass = (tab == 1 ? Number($("input[name='weightEmp']").val()) : Number($("input[name='weight']").val()));
	var height = (tab == 1 ? Number($("input[name='heightFt']").val())*12 + Number($("input[name='heightInch']").val()) : Number($("input[name='height']").val()));
	
	 $.ajax({
        type: "POST",
        url: "api.php",
        data: {selectedTab:tab, mass:mass, height:height},
        success: function(data)
        {
            
        }
    });
}
