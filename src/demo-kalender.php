<?php
$header_title = "Demo: Aktivitetskalender";
$header_description = "Demo av ny aktivitetskalender";
$page_updated = "2026-04-01";
$page_url = "/demo-kalender";
$page_contact_name = "";
$page_contact_email = "";
include_once "includes/header.php"
?>
<div id="BreadCrumbsDiv"><a href="/">Rockrullarna.se</a> / <span>Demo kalender</span></div>
<h1>Demo: Kommande aktiviteter</h1>
<p>Nedan visas hur kalendern ser ut med aktiviteter från dans.se. Klicka på <strong>Anmäl dig »</strong> för att gå direkt till anmälningssidan.</p>
<?php
$months    = ["jan","feb","mar","apr","maj","jun","jul","aug","sep","okt","nov","dec"];
$weekdays  = ["sön","mån","tis","ons","tor","fre","lör"];
$rss_show_desc = true;
$rss_items = [
  ["title"=>"Bugg fortsättningskurs – Torsdagskväll","link"=>"https://dans.se/event/1001","description"=>"Fortsättningskurs i bugg för dig som dansat tidigare. Välkommen att ta steget vidare!","date"=>new DateTime("2026-04-09 19:00",new DateTimeZone("Europe/Stockholm"))],
  ["title"=>"Fox nybörjarkurs","link"=>"https://dans.se/event/1002","description"=>"Nybörjarkurs i foxtrott – perfekt om du aldrig dansat fox förut.","date"=>new DateTime("2026-04-14 18:30",new DateTimeZone("Europe/Stockholm"))],
  ["title"=>"West Coast Swing – intensivkurs","link"=>"https://dans.se/event/1003","description"=>"Intensivkurs i West Coast Swing under en heldag. Förkunskaper krävs.","date"=>new DateTime("2026-04-19 10:00",new DateTimeZone("Europe/Stockholm"))],
  ["title"=>"Bugg nybörjarkurs (ny omgång startar)","link"=>"https://dans.se/event/1004","description"=>"Ny omgång av nybörjarkursen i bugg startar nu! Anmäl dig snabbt.","date"=>new DateTime("2026-04-23 19:00",new DateTimeZone("Europe/Stockholm"))],
  ["title"=>"Danssocial – Öppen dansafton","link"=>"https://dans.se/event/1005","description"=>"Kom och dansa med oss på vår öppna dansafton. Alla välkomna!","date"=>new DateTime("2026-04-25 19:30",new DateTimeZone("Europe/Stockholm"))],
  ["title"=>"Fox fortsättning – Fredagskurs","link"=>"https://dans.se/event/1006","description"=>"Fortsättningskurs i fox för dig med tidigare erfarenhet av dans.","date"=>new DateTime("2026-05-01 18:00",new DateTimeZone("Europe/Stockholm"))],
  ["title"=>"Bugg barn och ungdom","link"=>"https://dans.se/event/1007","description"=>"Buggkurs speciellt anpassad för barn och ungdomar 8–16 år.","date"=>new DateTime("2026-05-05 17:00",new DateTimeZone("Europe/Stockholm"))],
];
?>
<div class="aktivitetskalender-scroll" role="list"
  style="max-height:500px; overflow-y:auto; border-radius:.5rem; display:flex; flex-direction:column; gap:.4rem;">
  <?php foreach ($rss_items as $rss_item): ?>
    <?php $item_url = htmlspecialchars($rss_item["link"],ENT_QUOTES,"UTF-8"); ?>
    <div class="aktivitetskalender-item" role="listitem"
      style="display:flex; flex-direction:row; align-items:stretch; border:1px solid rgba(0,171,214,.3); border-radius:.375rem; overflow:hidden; transition:border-color .15s, box-shadow .15s;">
      <div style="flex:0 0 3.8rem; width:3.8rem; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:.4rem .2rem; background:rgba(0,171,214,.15); border-right:1px solid rgba(0,171,214,.3); text-align:center;">
        <div style="font-weight:700; font-size:1.3rem; color:#00ABD6; line-height:1;"><?php echo $rss_item["date"]->format("d"); ?></div>
        <div style="font-size:.7rem; text-transform:uppercase; color:#00ABD6; opacity:.9; letter-spacing:.05em;"><?php echo $months[(int)$rss_item["date"]->format("n")-1]; ?></div>
        <div style="font-size:.65rem; opacity:.65; margin-top:.15rem;"><?php echo $weekdays[(int)$rss_item["date"]->format("w")]; ?></div>
        <div style="font-size:.7rem; opacity:.75; margin-top:.1rem;"><?php echo $rss_item["date"]->format("H:i"); ?></div>
      </div>
      <div style="flex:1 1 auto; min-width:0; display:flex; flex-direction:column; justify-content:center; padding:.45rem .6rem; overflow:hidden;">
        <div style="font-weight:600; color:#00ABD6; font-size:.9rem; line-height:1.2; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($rss_item["title"],ENT_QUOTES,"UTF-8"); ?></div>
        <div style="margin-top:.2rem; font-size:.75rem; opacity:.75; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; line-height:1.35;"><?php echo htmlspecialchars($rss_item["description"],ENT_QUOTES,"UTF-8"); ?></div>
      </div>
      <div style="flex:0 0 auto; display:flex; align-items:center; padding:.3rem .5rem;">
        <a href="<?php echo $item_url; ?>" target="_blank" rel="noopener"
          class="btn btn-primary btn-sm"
          style="font-size:.72rem; white-space:nowrap; padding:.3rem .55rem; font-weight:600;"
          title="<?php echo htmlspecialchars($rss_item["title"],ENT_QUOTES,"UTF-8"); ?> – öppna anmälningssidan på dans.se">
          Anmäl dig&nbsp;»
        </a>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<style>.aktivitetskalender-item:hover{border-color:#00ABD6!important;box-shadow:0 0 0 .15rem rgba(0,171,214,.25);}</style>
<p style="margin-top:.75rem; text-align:center;">
  <a class="btn btn-outline-secondary btn-sm" href="/aktivitetskalender">Visa hela kalendern</a>
</p>
<?php include_once "includes/footer.php" ?>
