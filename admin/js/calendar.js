var ch_cal = 0;
m = location.href;
qs = m.indexOf("&day=");
if ( qs == -1 ) {
	selectday = new Date();
	dd = selectday.getDate();
	mm = selectday.getMonth() + 1;
	if ( navigator.appName.substring(0,3) == "Mic" )
		yy = selectday.getYear();
	else
		yy = selectday.getYear() + 1900;
	a = 0;
} else {
	dd = m.substr(qs+5, 2)-0;
	mm = m.substr(qs+7, 2)-0;
	yy = m.substr(qs+9, 4)-0;
	a = 1;
}

function form_calendar ( d, m, y ) {
	
	mnames = new Array( "Январь", "Февраль", "Маpт", "Апpель", "Май", "Июнь", "Июль", "Август", "Сентябpь", "Октябpь", "Ноябpь", "Декабpь" );
	
	if ( ( y % 4 ) == 0 )
		mdays  = new Array ( 31, 29, 31, 30, 31, 30,  31, 31, 30, 31, 30, 31 );
	else
		mdays  = new Array ( 31, 28, 31, 30, 31, 30,  31, 31, 30, 31, 30, 31 );
	
	t_s = "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#E5E5E5>" +
	 "<tr bgcolor=#D2D4D6 valign=middle height=20>" +
	 "<td width=15><img src=images/arrow_gl.gif width=10 height=9 border=0 onclick='change_calendar(-1);' style='cursor: pointer; cursor: hand;'></td>" +
	 "<td width=182 colspan=7 align=center><span><b>";
	 
	t_s2 = "</b></span></td>" +
	 "<td align=right width=15><img src=images/arrow_gr.gif width=10 height=9 border=0 onclick='change_calendar(1);' style='cursor: pointer; cursor: hand;'></td>" +
	 "</tr>";
	
	t_e	= "</table>"; 
	
	er = "<td width=20></td>";
	far_s = "<td width='18' style='padding: 0 4 0 4;'><a href='#' ";
	far_s1 = "<td width='18' class='href9today' style='padding: 0 4 0 4;'><a href='#' ";
	far_m = " class='href9'>";
	far_e = "</a></td>";
	
	fir_s = "<td width=18 class=href9text style='padding: 0 4 0 4;'>"; 
	fir_s1 = "<td width=18 class=href9select style='padding: 0 3 0 3;'>"; 
	fir_s2 = "<td width=18 class=href9selecttoday style='padding: 0 3 0 3;'>"; 
	fir_e = "</td>";
	
	r_s = "<tr align=center height=18><td></td>";
	r_e = "<td></td></tr>"
	r_e_s = "<tr><td colspan=9 bgcolor=#D2D4D6><img src={# $PATH_SKIN_IMAGES #}1x1.gif width=1 height=1></td></tr>";	
	
	today = new Date();
	
	if ( ch_cal == 0 ) {
		selectday = new Date();
		selectday.setYear(y);
		selectday.setMonth(m-1);
		selectday.setDate(d); 
	}
	
	if ( selectday > today )
		selectday = today;
	
	indexday = new Date();
	indexday.setDate(1); 
	indexday.setMonth(m-1);
	indexday.setYear(y);
	
	s = -indexday.getDay() + 2;
	if ( s > 1 )
		s-=7;
	
	td = mdays[m-1];
	str = t_s + mnames[m-1] + " " + yy + t_s2; 
	
	for ( i = s; i <= td; i += 7 ) {
		
		str += r_s;
		
		for ( j = i; j < i + 7; j++ ) {
			
			if ( j < 1 || j > td ) {
				str += er;
			} else {
				
				indexday.setDate(j); 
				
				if ( indexday.getDate() == selectday.getDate() && indexday.getMonth() == selectday.getMonth() && indexday.getYear() == selectday.getYear() && a != 0 ) {
					if ( indexday.getDate() == today.getDate() && indexday.getMonth() == today.getMonth() && indexday.getYear() == today.getYear() )
						str += fir_s2 + j + fir_e;
					else
						str += fir_s1 + j + fir_e;
				} else {
					if ( indexday < today || indexday > today ) {
						nm = Math.floor(j/10) + '' + (j%10) + '.' + Math.floor(m/10) + '' + (m%10) + '.' + y;
						nm = "onclick='Calendar_SelectDate(\""+nm+"\", this);return false;'";
						str += far_s + nm + far_m + j + far_e;
					}
					if ( indexday.getDate() == today.getDate() && indexday.getMonth() == today.getMonth() && indexday.getYear() == today.getYear() ) {
						nm = Math.floor(j/10) + '' + (j%10) + '.' + Math.floor(m/10) + '' + (m%10) + '.' + y;
						nm = "onclick='Calendar_SelectDate(\""+nm+"\", this);return false;'";
						str += far_s1 + nm + far_m + j + far_e;
					}
					/* 
					if ( indexday > today ) {
						str += fir_s + j + fir_e;
					}
					*/
				}
				
			}
			
		}
		
		str += r_e; 
		
		if ( i < td - 6 )
			str += r_e_s;
		
	}
	
	str += "<tr><td colspan='9' align='right' style='padding: 1 5 3 5;'><a href='#' class='href9' onclick='Calendar_Hide(this);'>Закрыть</a></td></tr>";
	str += t_e;
	
	return str;
	
}
function change_calendar ( where ) {
	
    if ( where > 0 ) {
		mm++;
		if ( mm > 12 ) {
			mm = 1;
			yy++;
		}
    } else {
		mm--;
		if ( mm < 1 ) {
			mm = 12;
			yy--;
		}
    }
    
	ch_cal = 1;
	
	$("#fieldCalendar").html( form_calendar ( 1, mm, yy ) );
	
	return true;
	
}
function Calendar_Locate ( e, id ) {

	var posx=0,posy=0;
	if(e==null) e=window.event;
	if(e.pageX || e.pageY){
		posx=e.pageX; posy=e.pageY;
		}
	else if(e.clientX || e.clientY){
		if(document.documentElement.scrollTop){
			posx=e.clientX+document.documentElement.scrollLeft;
			posy=e.clientY+document.documentElement.scrollTop;
			}
		else{
			posx=e.clientX+document.body.scrollLeft;
			posy=e.clientY+document.body.scrollTop;
			}
	}
	
	document.getElementById(id).style.top=(posy+10)+"px";
	document.getElementById(id).style.left=(posx-115)+"px";
	
}
function Calendar_Show ( e, id ) {
	
	var t = document.getElementById(id);
	
	if ( t.style.display == "none" || t.style.display == "" ) {
		
		$("#" + id).html( form_calendar ( dd, mm, yy ) );
		$("#" + id).show();
		
		if(e==null) e=window.event;
		Calendar_Locate(e, id);
		
	} else {
		
		$("#" + id).hide();
		
	}
	
}
function Calendar_Hide ( id ) {
	
	$(id).parents("div").hide();
	
}
function Calendar_SelectDate ( val, obj ) {
	
	t = $ ( "#calendVal > input" );
	t[0].value = val;
	$(obj).parents("div").hide();
	
}