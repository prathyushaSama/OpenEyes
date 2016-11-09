<style>
#historyTabs { 
    padding: 0px; 
    background: none; 
    border-width: 0px; 
} 
#historyTabs .ui-tabs-nav { 
    padding-left: 0px; 
    background: transparent; 
    border-width: 0px 0px 1px 0px; 
    -moz-border-radius: 0px; 
    -webkit-border-radius: 0px; 
    border-radius: 0px; 
} 
#historyTabs .ui-tabs-panel { 
    border-width: 0px 1px 1px 1px; 
}

#historyTabs .ui-tabs-anchor{
    font-size: 8pt;    
    
} 

#historyTabs .ui-tabs-nav li.ui-tabs-selected, 
#historyTabs .ui-tabs-nav li.ui-state-active {
    font-size: 8pt;    
    font-weight: bold;
}

</style>

<script>
    function loadTabsContents( version_id ){
        var element_type_id = '<?php echo $element_type_id ?>';
        var event_id = '<?php echo $event_id ?>';
		var options = {
			id: 'previous-modifications-dialog',
			title: 'Previous modifications'
		}    	
	    $.ajax({
			type: 'GET',
            cache: false,
			url: baseUrl + '../DisplayPreviousModifications',
			processData : false,
			data: "version_id="+version_id+"&event_id="+event_id+"&element_type_id="+element_type_id,
			'success': function(html) {
			    $('#tabs-'+version_id).html(html);
	        }
	    });
    }
        
    $( function() {
        $( "#historyTabs" ).tabs();
        
    } );

</script>


<?php
   $versions = $element -> getPreviousUsersFromEventIdByVersions($event_id);
   
?>

<div id="historyTabs">
  <ul>
    <?php foreach($versions as $key => $oneVersion) { ?>
        <li><a href="#tabs-<?php echo $oneVersion['version_id']; ?>"><?php echo $oneVersion['first_name'].' '.$oneVersion['last_name'].' '.$oneVersion['last_modified_date']  ?></a></li>
    <?php } ?>
  </ul>
  <?php foreach($versions as $key => $oneVersion) { ?>
      <div id="tabs-<?php echo $oneVersion['version_id']; ?>">
            
            <script>
                loadTabsContents("<?php echo $oneVersion['version_id']; ?>");
            </script>
      </div>
  <?php } ?>

</div>