document.getElementById("eintragen").onclick = eintragen;

function eintragen() {
	var table = document.getElementById("Table_Songlist");

	var row = table.insertRow(2);

	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);

	var interpret = document.getElementById("interpret").value;
	var titel = document.getElementById("songtitel").value;
	
	cell1.className = "spalte1";
	cell2.className = "interpret"; cell2.innerHTML = interpret;
	cell3.className = "songtitel"; cell3.innerHTML = titel;
	cell4.className = "status";
	cell5.className = "utilbar";
	
//	toDB(interpret, titel);
	
}
function toDB(interpret, titel) {
    if (interpret.length == 0) { 
        document.getElementById("songtext").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "php/addSong.php?songtitel=" + songtitel + "&interpret="+ interpret, true);
        xmlhttp.send();
    }
}
function loeschen(id) {
	var table = document.getElementById("Table_Songlist");
	table.deleteRow(id);
}
