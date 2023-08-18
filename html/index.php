<?php

namespace Sean\CHL;
require_once __DIR__.'/../bootstrap.php';

$page = new Page('chl');
$page->head(<<<HTML
<meta name="viewport" content="width=device-width, user-scalable=no" />
HTML);
$page->go();
?>
<div class="container h-100">
    <div class="d-flex" style="padding-top: 25vh;">
        <div class="col-10 col-md-8 col-lg-6 mx-auto d-inline-block">
            <form method="post" action="/create.php">
                <input type="email" name="username" class="d-none">
                <input type="password" name="password" class="d-none">
                <input type="text" name="url" id="urlInput" class="form-control" autofocus>
                <button role="button" id="button" class="btn btn-sm btn-outline-primary w-100 mt-1" >shorten!</button>
            </form>
        </div>
    </div>
</div>
<script src="/assets/js/custom.js"></script>