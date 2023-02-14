function evDetailsWidget_refresh() { 
    $('#evdetails_widget').load('events_on_day.php', {
	chosenDay: chosenDate.getDate(),
	chosenMonth: chosenDate.getMonth()+1,
	chosenYear: chosenDate.getFullYear()
    });
}

function event_delete(evId, evName) {
    if (confirm('Czy chcesz usunąć wydarzenie "'+evName+'"?')) {
	$.post('event_delete.php', {
	    id: evId
	}, function() {
	    calendar_printWidget(); // See "widget.js"
	    evDetailsWidget_refresh();
	});
    }
}