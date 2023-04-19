let dispDate = clearTime(new Date());
let chosenDate = clearTime(new Date());
let choiceMade = false;

if(typeof isSidebar === 'undefined') // set to false on main calendar page
    isSidebar = true; 
else 
    isSidebar = false;

function calendar_printWidget() {
    document.getElementById('calendar_js').innerHTML = calendar_widget(dispDate);
    setEventIndicators(dispDate);
    if(isSidebar) 
	showcalbutton();
}

function calendar_widget(dispDate) {
    let table_cols = 5;
    
    let output = '';
    output += '<div id="cal_showbutton" class="cal_dispbutton" onclick="showcalbutton()">Pokaż kalendarz</div>';
    output += '<div id="cal_hidebutton" class="cal_dispbutton" onclick="hidecalbutton()">Ukryj kalendarz</div>';
    
    output += '<table id="cal_wg_table" class="cal_wg_table">';

// Title row   
    output += '<tr>'
	    +'<th colspan='+table_cols+' class="cal_wg_title" id="thetitle"> '
	    + monthName(dispDate.getMonth(), "full") + " " + dispDate.getFullYear()
	    +'</th>'
	    +'</tr>';
    
// Calendar row
    output += '<tr>'
	    +'<td colspan='+table_cols+' class="cal_wg_calendar" id="the_calendar">'
	    + calendar(dispDate, chosenDate)
	    +'</td>'
	    +'</tr>';
    
// Buttons row
    output += '<tr class="cal_wg_buttonsrow">'
	    +'<td class="cal_wg_button" onclick="prevYear()">'
		+ '<<' + '</td>'
	    +'<td class="cal_wg_button" onclick="prevMonth()">'
		+ '<' + '</td>'
	    +'<td class="cal_wg_buttongap">' + '&nbsp' + '</td>'
	    +'<td class="cal_wg_button" onclick="nextMonth()">'
		+ '>' + '</td>'
	    +'<td class="cal_wg_button" onclick="nextYear()">'
		+ '>>' + '</td>'
	    
	    +'</tr>';
    
    output += "</table>";
    
    return output;
}

// Returns a string with HTML of calendar which is a table built by concatenation
function calendar(dispDate, chosenDate) {
    
    dispMonth = dispDate.getMonth();
    dispYear = dispDate.getFullYear();
//    if(isset(chosenDate))
//	chosenDay = chosenDate.getDate();
    
    let calendar = '<table class="calendar">';
    
    //--- Calendar heading ----------------------------------------------------
    calendar += '<thead class="cal_head"><tr>';
    
    const week_short = ['Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'S', 'N'];
    const week_full = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 
	'Sobota', 'Niedziela'];
    for(const wday of week_short) {
	calendar += '<th class="cal_headcell">' + wday + '</th>';
    }
    calendar += '</tr></thead>';
    
    //--- Calendar body -------------------------------------------------------
    //-/--- Variables  --------------------------------------------------------
    calendar += '<tbody class="cal_body">'; 
    
    const todayDate = clearTime(new Date());    
    
    // Variable necessary to get amount of days in month etc
    const dimDate = new Date(dispYear, dispMonth+1, 0);
    // Number of days in displayed month. Range: 28-31;
    const daysInMonth = dimDate.getDate();
    
    // Day of week on 1st day of month
    const wdo1Date = new Date(dispYear, dispMonth, 1);
    const weekDayOn1st = fixWeekDay(wdo1Date.getDay());
    
    //-/--- String construction -----------------------------------------------
    let weekDay = 0;
    let monthDay = 1;
    let iterated1stOfMonth = false;
    let weekCount = 0;
    
    while(monthDay<=daysInMonth) {
	
	// One week:
	calendar += '<tr class="cal_week">';
	while(weekDay<=6 && monthDay<=daysInMonth) {
	    
	    // One day:
	    if(iterated1stOfMonth) {
		dispDate.setDate(monthDay);
		calendar += printNormalDay(dispDate, todayDate, chosenDate);
		monthDay++;
	    } else {
		if(weekDay !== weekDayOn1st) {
		    calendar += printEmptyDay();
		} else {
		    iterated1stOfMonth = true;
		    dispDate.setDate(monthDay);
		    calendar += printNormalDay(dispDate, todayDate, chosenDate);
		    monthDay++;
		} 
	    }
	    weekDay++;
	    
	}
	calendar += '</tr>';
	weekCount++;
	weekDay = 0;
	
    }
    while(weekCount<=5) { // keeps equal height of calendar
	calendar += '<tr class="cal_week">' + printEmptyDay() + '</tr>';
	weekCount++;
    }
    
    dispDate.setDate(1); // fixes month
    
    calendar += '</tbody>';
    calendar += '</table>';
    
    return calendar;

}


//---Printers and print helpers-------------------------------------------------

function printEmptyDay() {
    let output = '<td class="cal_emptyday">&nbsp</td>';
    return output;
}

function printNormalDay(dispDate, todayDate, chosenDate) {
    let output;
    output = '<td class="cal_normalday';
    if(choiceMade && dispDate.getTime() === chosenDate.getTime())
	output += ' cal_chosen';
    if(dispDate.getTime() === todayDate.getTime()) 
    	output += ' cal_today';
    output += '"onclick="dayOnclick('+dispDate.getDate()+')"' 
	    + '>';
    output += dispDate.getDate() + '<br>'; // day number
    output += '<i class="fas fa-circle" id="evindicator_' + dispDate.getDate() + '"'
	    + ' style="visibility:hidden"></i></td>';
    return output;
}

// Run after page is loaded
function setEventIndicators(dispDate) {
    let checkDate = new Date(dispDate.getFullYear(), dispDate.getMonth(), 1);
    
    while(checkDate.getMonth() === dispDate.getMonth()) {
	eventHappensOn(checkDate); 
	checkDate.setDate(checkDate.getDate()+1);
    }
}
function eventHappensOn(checkDate) {
    let output = false;
    let currentId = '#evindicator_'+checkDate.getDate();
    $.post('../calendar/eventHappensOn.php', {
	day: checkDate.getDate(),
	month: checkDate.getMonth()+1,
	year: checkDate.getFullYear()
    },function(data) {
	if(data === 'true') {
	    $(currentId).css("visibility", "visible");
	}
    });
    return output;
    
}


//---Buttons service-----------------------------------------------------

function dayOnclick(calDay) {
    if(isSidebar) {
	window.location.href = "http://localhost/space-r/calendar/page.php";
    } else {
	choiceMade = true;
	chosenDate.setDate(1);
	chosenDate.setFullYear(dispDate.getFullYear());
	chosenDate.setMonth(dispDate.getMonth());
	chosenDate.setDate(calDay);
	
	formInputValue = ''+chosenDate.getFullYear()
		+'-'+to2digit(chosenDate.getMonth()+1)
		+'-'+to2digit(chosenDate.getDate())
		+' '+to2digit(chosenDate.getHours())
		+':'+to2digit(chosenDate.getMinutes());
	
	if(typeof(moderator) !== 'undefined' && moderator === true) {
	    document.getElementById('form-eventdate-input').defaultValue
		    = formInputValue;
	}
	calendar_printWidget();
	
	evDetailsWidget_refresh(); // See: eventdetails.js
    } 
}

function nextMonth() {
    dispDate.setMonth(dispDate.getMonth()+1);
    calendar_printWidget();
    if(isSidebar) showcalbutton();
}
function prevMonth() {
    dispDate.setMonth(dispDate.getMonth()-1);
    calendar_printWidget();
    if(isSidebar) showcalbutton();
}
function nextYear() {
    dispDate.setFullYear(dispDate.getFullYear()+1);
    calendar_printWidget();
    if(isSidebar) showcalbutton();
}
function prevYear() {
    dispDate.setFullYear(dispDate.getFullYear()-1);
    calendar_printWidget();
    if(isSidebar) showcalbutton();
}

function showcalbutton() {
    document.getElementById('cal_wg_table').style.display = 'table';
    document.getElementById('cal_showbutton').style.display = 'none';
    document.getElementById('cal_hidebutton').style.display = 'block';
}
function hidecalbutton() {
    document.getElementById('cal_wg_table').style.display = 'none';
    document.getElementById('cal_showbutton').style.display = 'block';
    document.getElementById('cal_hidebutton').style.display = 'none';
}
function formDtUpdate() {
    console.log("formDtUpdate: ", document.getElementById("form-eventdate-input").value );
}


//---Data fixing and other------------------------------------------------------

// Date objects getDay() method behaves differently on various systems.
// This function ensures that Monday gets the 0 index (meaning 1st weekday).
function fixWeekDay(weekday) {
    let d = new Date("2023-01-01"); // This date is Sunday
    if (d.getDay() === 0)   // If js treats Sunday as 1st day of a week	
	weekday--;	    // Change Monday from 1 to 0, Tuesday from 2 to 1 etc
    if(weekday === -1)	    // Result is range [-1 - 5]
	weekday = 6;	    // Fixing Monday
    return weekday;
}

function monthName(month, length) {
    let monthnames;
    if(length === 'short') {
	monthnames = ['Sty', 'Luty', 'Mar', 'Kwie', 
	    'Maj', 'Cze', 'Lip', 'Sie', 
	    'Wrz', 'Paź', 'Lis', 'Gru'];
    } else {
	monthnames = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 
	    'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 
	    'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    } 
    return monthnames[month];
}

// Strips seconds and ms from Date object
function stripDate(date) {
    const dateS = [];
    dateS['year'] = date.getFullYear();
    dateS['month'] = date.getMonth();
    dateS['day'] = date.getDate();
    return dateS;
}
function clearTime(date) {
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    return date;
}

// Needed for newevent_form's datetime type input field's default value
function to2digit(num){
    if(num<10) 
	return "0"+num;
    else
	return ""+num;
}