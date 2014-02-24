<div id="home">
    <div id="home-search">
        <? $this->search->render('views/templates/search-template.php', false, $this->searchVar); ?>
    </div><div id="home-windows">
        <ul id="home-mosaic">
            <? foreach ($this->banners as $banner) { ?><li>
                    <a href="<?= $banner['url'] ?>">
                        <div class="cover">
                            <div class="label" id="">
                                <?= $banner['content'] ?>
                            </div>
                        </div>
                        <img src="<?= UPLOAD . Model::getRouteImg($banner['imgdate']) . $banner['file_name'] ?>">
                    </a>
                </li><? } ?>
        </ul>
    </div>
    <div id="home-types">
        <ul>
            <li class='<?= ($this->type == 1) ? 'selected' : '' ?>'>
                <a href="<?= URL ?>experience/home/<?= Session::get('destination') ?>">
                    <div class='home-types-box'>
                        <div id='experience-icons' class='home-types-icons'></div>
                        <h1>EXPERIENCES</h1>
                        <p>xperio. Exerundit que oditati </p>
                    </div>
                </a>
            </li><li  class='<?= ($this->type == 0) ? 'selected' : '' ?>'>
                <a href="<?= URL ?>accommodation/home/<?= Session::get('destination') ?>">
                    <div class='home-types-box'>
                        <div id='accommodation-icons' class='home-types-icons'></div>
                        <h1>ACCOMMODATION</h1>
                        <p>xperio. Exerundit que oditati </p>
                    </div>
                </a>
            </li><li  class='<?= ($this->section == 'gift') ? 'selected' : '' ?>'>
                <a href="<?= URL ?>gift">
                    <div class='home-types-box'>
                        <div id='gift-icons' class='home-types-icons'></div>
                        <h1>GIFT</h1>
                        <p>xperio. Exerundit que oditati </p>
                    </div>
                </a>
            </li><li class='desactivated <?= ($this->section == 'market') ? 'selected' : '' ?>'>
                <div id='comming-icons' class='home-types-icons'></div>
                <div class='home-types-box'>
                    <div id='market-icons' class='home-types-icons'></div>
                    <h1>MARKET</h1>
                    <p>xperio. Exerundit que oditati </p>
                </div>
            </li>
        </ul>
    </div>
    <div id="home-suggestions" class="royalSlider rsMinW">
        <? foreach ($this->suggestions as $key => $group) { ?><div id="home-suggestions-content" class="rsContent slide<?= $key ?>">
                <ul class="home-suggestions-box rsContent slide<?= $key ?>"><li id='home-suggestions-title'>
                        <div class='label'><?= $group['info']['content'] ?></div>
                    </li><? foreach ($group['suggestion'] as $key2=>$suggestion) { if($key2<3){ ?><li>
                            <div class='cover'>
                                <div class='label'>
                                    <?= $suggestion['content'] ?>
                                    <a href="<?= $suggestion['url'] ?>" class='more'><?=$this->lang['more']?></a>
                                </div>
                            </div>
                            <img src="<?= UPLOAD . Model::getRouteImg($suggestion['imgdate']) . $suggestion['file_name'] ?>">
                    </li><? }} ?>
                </ul></div><? } ?>
    </div>

</div>
</div>
