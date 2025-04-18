<?php
  $header_title = "Årsmöte - Möten och protokoll - Föreningen";
  $header_description = "Här finner du våra publika årsmötes-protokoll från olika möten vi genomfört";

  $page_updated = "2025-03-30 19:51";
  $page_url = "/foreningen/moten-och-protokoll/arsmote";
  $page_contact_name = "Styrelsen";
  $page_contact_email = "styrelsen@rockrullarna.se";

  include_once '../../../includes/header.php'
?>
    <div id="BreadCrumbsDiv">
      <a href="../../../">Rockrullarna.se</a> / <a href="../../">Föreningen</a> / <a href="../">Möten och protokoll</a> / <span>Årsmöte</span>
    </div>
    <h1>
      Årsmöte
    </h1>
    <p>Årsmötet är föreningens högsta beslutande organ som hålls före utgången av mars månad. På detta möte beslutas bland annat val av föreningens styrelsemedlemmar, genomgång av verksamhetsberättelse, revisorernas berättelse, verksamhetsplan samt ekonomisk genomgång. Efter mötet avnjuter vi mat tillsammans och kvällen avslutas med dans. Lokal och upplägg för medlemsmötet kan variera från år till år.</p>
    <p>Anmälan till årsmötet görs via sidan <a href="/danskurser/anmalan-danskurser/" title="Anmälan danskurser" target="_top">Anmälan danskurser</a> under kategorin "Årsmöte". </p>
    <p>Information gällande årsmötet kommer ut via sociala medier, hemsida samt via tränare. <br />Mer information gällande årsmötet hittats i <a href="/foreningen/styrande-dokument/verksamhetsbeskrivning/" title="Verksamhetsbeskrivningen">Verksamhetsbeskrivningen</a> - Annex A (<a href="/foreningen/styrande-dokument/stadgar/" title="Stadgarna">Stadgarna</a>).</p>
    <p>&nbsp;</p>
    <h2>Årsmötet 2025</h2>
    <p>Anmälan till årsmötet 2025 gör du här: <a href="https://dans.se/rockrullarna/shop/new?event=244368&info=1&lang=sv" title="Anmälningsformulär till årsmötet 2025 (öppnas i nytt fönster)" target="_blank">Anmälningsformulär till årsmötet 2025</a>.</p>
    <h3>Handlingar inför Årsmötet 2025 (2024 års verksamhet)</h3>
    <p>Här finns alla de handlingar som ska avhandlas inför årsmötet 2025, där vi går igenom verksamhetsåret 2024.</p>
    <?php
        $folderPath = './handlingar'; // Ange sökvägen till mappen relativt till denna fil

        // Kontrollera om mappen existerar
        if (is_dir($folderPath)) {
            echo '<table class="table">';
            echo '<tr><th>Filnamn</th><th>Länk</th></tr>';

            // Skapa en rekursiv iterator för att loopa igenom alla filer och undermappar
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $fileInfo) {
                // Kontrollera om det är en fil
                if ($fileInfo->isFile()) {
                    // Hämta den relativa sökvägen till filen
                    $relativePath = str_replace('\\', '/', $fileInfo->getPathname());

                    // Skapa en länk för varje fil
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($fileInfo->getFilename()) . '</td>';
                    echo '<td><a href="' . htmlspecialchars($relativePath) . '" target="_blank">Visa / Ladda ned</a></td>';
                    echo '</tr>';
                }
            }

            echo '</table>';
        } else {
            echo '<p>Mappen finns inte eller är inte tillgänglig.</p>';
        }
    ?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <h2>Arkiv för årsmötes protokoll och handlingar</h2>
    <p><a href="./2025/">Årsmöteshandlingar för 2025</a></p>
    <p><a href="./2024/">Årsmöteshandlingar för 2024</a></p>
    <p>Tidigare handlingar hittar du via vår SharePoint (Microsoft365), där det finns arkiverat protokoll och handlingar från våra tidigare årsmöten. Sidan visas enklast och bäst via en dator, då mobilen vill öppna länken via OneDrive/SharePoint appen...</p>
    <p>
      <a href="https://rockrullarna.sharepoint.com/:f:/s/Protokoll/Esnw21kgySVGhlMpoWoxRo4BpkWyddlH5bix5ssyM5MQVw?e=Hpg6gG" target="_blank" title="Rockrullarnas årsmötesprotokoll (öppnas i nytt fönster)">
        <span style="font-size: x-large;">Årsmötesprotokoll (Publik mapp på SharePoint)</span>
      </a>
    </p>
    <p class="word-wrap">
      <a href="https://rockrullarna.sharepoint.com/sites/Protokoll/Delade%20dokument/Årsmöten" target="_blank" title="Rockrullarnas protokoll-arkiv (öppnas i ny flik och kräver inloggning)">https://rockrullarna.sharepoint.com/sites/Protokoll/Delade%20dokument/Årsmöten</a> (kräver inloggning)
    </p>
<?php
  include_once '../../../includes/footer.php'
?>



