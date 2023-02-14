// AJAX lab 10/11
// kategorie: zaćmienia, koniunkcje, inne,  wydarzenia społeczności

// By default calendar displays current month and the chosen day is today
let dispDate = new Date();
let chosenDate = new Date();

function nextMonth() {
    dispDate.setMonth(dispDate.getMonth()+1);
    calendar_printWidget();
}
function prevMonth() {
    dispDate.setMonth(dispDate.getMonth()-1);
    calendar_printWidget();
}
function nextYear() {
    dispDate.setFullYear(dispDate.getFullYear()+1);
    calendar_printWidget();
}
function prevYear() {
    dispDate.setFullYear(dispDate.getFullYear()-1);
    calendar_printWidget();
}

function calendar_printWidget() {
    document.getElementById('calendar_js').innerHTML = calendar_widget(dispDate);
}

function calendar_widget(dispDate) {
    let table_cols = 5;
    
    let output = '<table class="cal_wg_table">';

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
    
    return "e";//output;
}

// Returns a string with HTML of calendar which is a table built by concatenation
// Argument: Date class object.
// Caution: "day" has range 1-31. "month" has range 0-11. "year" is four digit year
// Weekday has range 0-6
// A date of 2.02.2023 will be written as "2-1-2023"
function calendar(dispDate, chosenDate) {
    
    dispMonth = dispDate.getMonth();
    dispYear = dispDate.getFullYear();
    if(isset(chosenDate))
	chosenDay = chosenDate.getDay();
    
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
    
    const todayDate = new Date();
    const todayDay = todayDate.getDate(); // day of month
    
    // Checks if the month that is beeing built is the current one
    let isMonthCurrent = false;
    if( dispMonth === todayDate.getMonth() && dispYear === todayDate.getFullYear() ) 
	isMonthCurrent = true;
    
    
    // Variable necessary to get amount of days in month etc
    const dimDate = new Date(dispYear, dispMonth+1, 0);
    // Number of days in displayed month. Range: 28-31;
    const daysInMonth = dimDate.getDate();
    
    // Day of week on 1st day of month
    let wdo1Date = new Date(dispYear, dispMonth, 1);
    let weekDayOn1st = wdo1Date.getDay();
    weekDayOn1st = fixWeekDay(weekDayOn1st);
    
    //-/--- String construction -----------------------------------------------
    let weekDay = 0;
    let monthDay = 1;
    let iterated1stOfMonth = false;
    
    while(monthDay<=daysInMonth) {
	
	// One week:
	calendar += '<tr class="cal_week">';
	while(weekDay<=6 && monthDay<=daysInMonth) {
	    
	    // One day:
	    if(iterated1stOfMonth) {
		calendar += printNormalDay(dispDate, todayDate, chosenDate);
		monthDay++;
	    } else {
		if(weekDay !== weekDayOn1st) {
		    calendar += printEmptyDay(weekDay);
		} else {
		    iterated1stOfMonth = true;
		    calendar += printNormalDay(dispDate, todayDate, chosenDate);
		    monthDay++;
		} 
	    }
	    weekDay++;
	    
	}
	calendar += '</tr>';
	weekDay = 0;
	
    }
    
    calendar += '</tbody>';
    calendar += '</table>';
    
    return calendar;

}

function printEmptyDay(weekDay) {
    const output = '<td class="cal_emptyday"></td>';
    return output;
}

function printNormalDay(dispDate, todayDate, chosenDate) {
    let output;
    output = '<td class="cal_normalday';
    if(dispDate === todayDate)
    	output += ' cal_today';
    if(dispDate === chosenDate)
    	output += ' cal_chosen';
    output += '"'
	    + 'onclick="chosenDate=setChosenDate('+dispDate+')"' 
	    + '>' + dispDate.getDay() + '</td>'; // Displayed number
    return output;
}

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


/* Keep in mind that while PHP counts array elements from 1, JS starts from 0. 
 * However, when dealing with calendars and dates, one may encounter mostly 
 * counting starting from 1 (like January is 'first' month of year). 
 * 
 * If you find this confusing, this is the right moment to introduce date 
 * functions in PHP and JS. For example, in PHP function getDate() returns an 
 * associative array of date elements. Under the key of 'year' there is current 
 * year in four digit format, and 'mon' corresponds to month number in range 
 * 1-12. To get a month in JS developer can use Date.getMonth() function, which 
 * also returns month number, but this time in range 0-11. This means that if 
 * you want to use PHP generated month number in JS context, you may need to 
 * decrement it by 1.
 * 
 * The JS getMonth() method belongs to Date class. To create an object of this
 * class, you may need to use constructor with the right string. The format is
 * "yyyy-mm-dd", which seems logical. Day has range of 1-31, and month ranges 
 * from 1-12, which also seems logical. However, if you want to construct 
 * today's date with Date.getMonth(), you need to increment its output by 1, as
 * that function returns month number starting from 0. 
 * 
 * The example of above goes like this:
 *  let d = new Date("2018-03-27");
 *  let dy = d.getFullYear();
 *  let dm = d.getMonth();
 *  let dd = d.getDate();
 *  
 * Note that now m has value of 2, as March is 3rd month.
 *  
 *  let d2 new Date(dy, dm, dd);
 * 
 * Congratulations, you have created date of 2018-02-27.
*/
