<?php

namespace Sean\CHL;
require_once __DIR__.'/../bootstrap.php';

$http = new \Staticflux\HTTP;

if (!isset($_GET['s']) || empty($short = $_GET['s'])) {
    $http
        ->addResponseCode(403)
        ->addRedirect(constant('SHORTLINK_PREFIX'));
    return;
}
elseif (($result = $GLOBALS['pdo']->get('SELECT * FROM records WHERE short = ?', [$_GET['s']])) === false) {
    $http
        ->addResponseCode(404)
        ->addRedirect(constant('SHORTLINK_PREFIX'));
    return;
}

$long = $result['long'];
$hits = $GLOBALS['pdo']->get('SELECT COUNT(*) as count FROM hits WHERE shortId = ?', [$result['id']])['count'];
$ts = $result['timestamp'];

$page = new Page(constant('SITE_NAME'));
$page->head(<<<HTML
<meta name="viewport" content="width=device-width, user-scalable=no" />
HTML);
$page->go();
?>
<?=menu()?>
<?php if($hits > 0): // at least 1 hit ?>
<div class="container my-4">
    <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
        <div class="h1 selectable mb-0"><?=constant('SHORTLINK_PREFIX').$short?></div>
        <div class="small text-muted mb-2">Click the link above to copy</div>
        <div class="h5">
            <svg style="vertical-align: -0.25em; height: 1em; font-size: 1.5em; line-height: .0416666682em;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor"><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
        </div>
        <div class="h3"><?=$long?></div>
        <hr/>
        <div class="h5 mt-3 mb-0"><?=number_format($hits)?> total hit<?=$hits == 1 ? '' : 's'?></div>
        <div class="h5">since <?=date('l, F j, Y @ H:i:s T', $ts)?></div>
    </div>
</div>
<?php else: // zero hits/new link ?>
<div class="container my-4">
    <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
        <div class="h1 selectable mb-0"><?=constant('SHORTLINK_PREFIX').$short?></div>
        <div class="small text-muted mb-2">Click the link above to copy</div>
        <div class="h5">
            <svg style="vertical-align: -0.25em; height: 1em; font-size: 1.5em; line-height: .0416666682em;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor"><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
        </div>
        <div class="h3"><?=$long?></div>
    </div>
</div>
<?php endif; ?>