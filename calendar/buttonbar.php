<button id="newev_showbtn" class="ctrlbtn" onclick="showNewEvBtn()">
  Nowe wydarzenie</button>
<button id="evdetails_showbtn" class="ctrlbtn" onclick="showEvDetailsBtn()">
  Pokaż szczegóły dnia</button>

  <script>
    function showNewEvBtn() {
	document.getElementById('evdetails_widget').style.display='none';
	document.getElementById('newev_form').style.display='block';
    }
    function showEvDetailsBtn() {
	document.getElementById('evdetails_widget').style.display='block';
	document.getElementById('newev_form').style.display='none';
    }
</script>