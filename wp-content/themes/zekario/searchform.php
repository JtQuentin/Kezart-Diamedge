<!--<form role="search" method="get" id="searchform" action="<?php /*echo home_url( '/' ); */?>">
    <label for="s">
        <input type="text" value="" name="s" id="s" placeholder="<?php echo __('Search','zekario'); ?>" />
        <button type="submit" id="searchsubmit">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
    </label>
</form>-->

<div id="searchform">
    <label for="s">
        <input type="text" value="" name="s" id="s" placeholder="<?php echo __('Search','zekario'); ?>" />
        <a id="searchsubmit" href="<?php echo home_url( '/' ); ?>?">
            <i class="fa fa-search" aria-hidden="true"></i>
        </a>
    </label>
</div>