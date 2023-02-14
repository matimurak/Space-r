
<form id="newev_form" class="mainContent" action="newevent_create.php" method="post" style="display:none">
  <div id="form-eventdate" class="formctrl">
    <label>Data</label>
    <input id="form-eventdate-input" type="datetime-local" name="date" onclick="formDtUpdate()">
  </div>
  <div id="form-eventname" class="formctrl">
    <label>Nazwa wydarzenia</label>
    <input type="text" name="name" placeholder="Nazwa wydarzenia">
  </div>
  
  <div id="form-eventtype" class="formctrl">
    <label>Typ wydarzenia</label>
    <br>
    
    <input type="radio" id="social" name="type" value="Wydarzenie społeczności">
    <label for="social">Wydarzenie społeczności</label>
    <br>
    <input type="radio" id="sun" name="type" value="Wydarzenie Słońca">
    <label for="social">Wydarzenie Słońca</label>
    <br>
    <input type="radio" id="moon" name="type" value="Wydarzenie Księżyca">
    <label for="social">Wydarzenie Księżyca</label>
    <br>
    <input type="radio" id="eclipse" name="type" value="Zaćmienie">
    <label for="eclipse">Zaćmienie</label>
    <br>
    <input type="radio" id="conjunction" name="type" value="Koniunkcja">
    <label for="conjunction">Koniunkcja</label>
    <br>
    <input type="radio" id="comet" name="type" value="Kometa">
    <label for="social">Kometa</label>
    <br>
    <input type="radio" id="other" name="type" value="Inne">
    <label for="social">Inne</label>
  </div>
  
  <div id="form-eventdesc" class="formctrl">
    <label>Opis</label>
    <input type="text" name="desc" placeholder="Opis wydarzenia... (max 1000 znaków)">
    <input type="submit" value="Stwórz">
  </div>
</form>

