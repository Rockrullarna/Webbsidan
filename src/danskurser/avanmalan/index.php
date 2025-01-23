<?php
  $header_title = "Avanmälan - Danskurser";
  $header_description = "Här kan du avboka dig från våra danskurser som du tidigare anmält dig till";

  $page_updated = "2022-12-29 22:05";
  $page_url = "/danskurser/avanmalan";
  $page_contact_name = "Kurser";
  $page_contact_email = "kurser@rockrullarna.se";

  include_once '../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../">Rockrullarna.se</a> / <a href="../">Danskurser</a> / <span>Avanmälan</span>
    </div>
    <h1>Avanmälan</h1>
    <p>
      På denna sida kan du avboka dig från en kurs du tidigare har anmält dig till.
    </p>
    <p>
      Efter att du avanmält dig kan det ta några dagar upp till en vecka innan du blivit borttagen. Det system för kursbokningar vi använder skickar annars automatiskt ut ett antal påminnelser om utebliven betalning.
    </p>
    <p>
      Observera att anmälan till föreningens aktiviteter är bindande inom 14 dagar före start (gäller ej nybörjarkurs med ”prova på”). <br />
      Vid sjukdom kan återbetalning endast genomföras vid uppvisande av läkarintyg.
    </p>
    <p>
      Skicka oss ett mail via: <a href="kurser@rockrullarna.se">kurser@rockrullarna.se</a> för att avanmäla dig från danskursen.<br />
      Uppge gärna ditt referensnummer för anmälan (ex. R1234567).
    </p> 
    <!--
    <table id="id_matrix">
      <tbody>
        <tr>
          <td valign="top">
            <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Kurs_som_arendet_galler">Ärende gäller:</label>
            <select id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Kurs_som_arendet_galler" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Kurs_som_arendet_galler">
              <option value="Bugg" selected="selected">Bugg</option>
              <option value="West Coast Swing">West Coast Swing</option>
              <option value="Fox">Fox</option>
              <option value="Annan">Annan (ange i text nedan)</option>
            </select>
          </td>
        </tr>
        <tr>
          <td valign="top">
            <fieldset>
              <legend>På nivå/nivåer:</legend>
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_1">
              <input type="checkbox" value="Steg 1" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_1" /> Steg 1</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_2">
              <input type="checkbox" value="Steg 2" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_2" /> Steg 2</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_3">
              <input type="checkbox" value="Steg 3" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_3" /> Steg 3</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_4">
              <input type="checkbox" value="Steg 4" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSteg_4" /> Steg 4</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaPar_M">
              <input type="checkbox" value="Par M" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaPar_M" /> Par M</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSocialdans">
              <input type="checkbox" value="Socialdans" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaSocialdans" /> Socialdans</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaTävlingsträning">
              <input type="checkbox" value="Tävlingsträning" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaTävlingsträning" /> Tävlingsträning</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaHelgkurs">
              <input type="checkbox" value="Helgkurs" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaHelgkurs" /> Helgkurs</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaAnnan">
              <input type="checkbox" value="Annan" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Pa_niva" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Pa_nivaAnnan" /> Annan (ange i text nedan)</label>
            </fieldset>
          </td>
        </tr>
        <tr>
          <td valign="top">
            <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_RefNr">Referensnummer (finns på ditt antagningsbesked):</label>
            <input type="text" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_RefNr" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$RefNr" size="50" title="R1234567" value="" />
          </td>
        </tr>
        <tr>
          <td valign="top">
            <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_From_Namn">Ditt namn:</label>
            <input type="text" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_From_Namn" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$From_Namn" size="50" title="Förnamn Efternamn" value="" />
            <span id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_From_Namnrequiredvalidator" class="xformvalidator" style="display:none;">Detta fält är tvingande</span>
          </td>
        </tr>
        <tr>
          <td valign="top">
            <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Partnerns_namn">Om du anmält dig med en partner, ange partnerns namn:</label>
            <input type="text" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Partnerns_namn" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Partnerns_namn" size="50" title="Partnerns Förnamn Efternamn" value="" />
          </td>
        </tr>
        <tr>
          <td valign="top">
            <fieldset>
              <legend>Gäller avanmälan även din partner?</legend>
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerJa">
              <input type="radio" value="Ja" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Galler_avanmalan_aven_din_partner" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerJa" /> Ja</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerNej">
              <input type="radio" value="Nej" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Galler_avanmalan_aven_din_partner" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerNej" /> Nej</label>
              <br />
              <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerIngen_partner">
              <input type="radio" value="Ingen partner" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Galler_avanmalan_aven_din_partner" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerIngen_partner" /> Ingen partner</label>
              <br />
            </fieldset>
            <span id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Galler_avanmalan_aven_din_partnerrequiredvalidator" class="xformvalidator" style="display:none;">Detta fält är tvingande</span>
          </td>
        </tr>
        <tr>
          <td valign="top">
            <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Anledning_till_avanmalan">Av vilken anledning vill du avanmäla dig?*</label>
            <select id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Anledning_till_avanmalan" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Anledning_till_avanmalan">
              <option value="Jag/Vi har fått förhinder" selected="selected">Jag/Vi har fått förhinder</option>
              <option value="Pga sjukdom">Pga sjukdom</option>
              <option value="Kursen passade inte mig/oss">Kursen passade inte mig/oss</option>
              <option value="Annat (ange i Övrigt)">Annat (ange i Övrigt)</option>
            </select>
            <span id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Anledning_till_avanmalanrequiredvalidator" class="xformvalidator" style="display:none;">Detta fält är tvingande</span>
          </td>
        </tr>
        <tr>
          <td valign="top">
          <span>*Vissa anledningar kräver styrelsebeslut för att kursavgiften ska återbetalas. Vid sjukdom krävs sjukintyg.</span>
          </td>
        </tr>
        <tr>
          <td valign="top">
          <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Svara_till_min_mail">Din mail (för bekräftelse på avanmälan):</label>
          <input type="text" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Svara_till_min_mail" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Svara_till_min_mail" size="50" title="namn@mail.com" value="" />
          <span id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Svara_till_min_mailrequiredvalidator" class="xformvalidator" style="display:none;">Detta fält är tvingande</span>
          </td>
        </tr>
        <tr>
          <td valign="top">
          <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Min_Partners_Mail_som_kopia">Din partners mail:</label>
          <input type="text" id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Min_Partners_Mail_som_kopia" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Min_Partners_Mail_som_kopia" size="50" title="partnerns.namn@mail.com" value="" />
          </td>
        </tr>
        <tr>
          <td valign="top">
          <label for="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Beskrivande_Text">Övrigt (om du vill framföra något mer):</label>
          <textarea id="ctl00_fullRegion_leftandmainRegion_startpageleftandmainRegion_mainWideRegion_mainRegion_ctl02_XFormControl_Beskrivande_Text" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$Beskrivande_Text" rows="10" cols="50" title="Skriv information om ditt ärende här">
          </textarea>
          </td>
        </tr>
        <tr>
          <td valign="top">
          <input type="submit" value="Skicka" name="ctl00$fullRegion$leftandmainRegion$startpageleftandmainRegion$mainWideRegion$mainRegion$ctl02$XFormControl$ctl12" />
          </td>
        </tr>
        <tr>
          <td valign="top">
          <span>Kopia kan tyvärr inte skickas till din mail p.g.a systembegränsningar.</span>
          </td>
        </tr>
      </tbody>
    </table>
    -->
<?php
  include_once '../../includes/footer.php'
?>