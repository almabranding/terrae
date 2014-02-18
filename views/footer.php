</div>
</div>
<div id="footer">
    <div id="wrapper">
        <div id="container">
            <ul class="footer-list">
                <li>
                    <h1><?=$this->lang['about us']?></h1>
                    <p><?=$this->lang['about_text'];?></p>
                    <p><a href="<?=URL?>/page/view/about"><?=$this->lang['Read more']?></a></p>
                </li><li>
                    <h1><?=$this->lang['accommodations']?></h1>
                    <ul class="footer-list-a">
                        <li><a href='<?=URL?>accommodation/results?category=1'><?=$this->lang['rural']?></a></li>
                        <li><a href='<?=URL?>accommodation/results?category=3'><?=$this->lang['historical']?></a></li>
                        <li><a href='<?=URL?>accommodation/results?category=2'><?=$this->lang['agriculture']?></a></li>
                        <li><a href='<?=URL?>accommodation/results?category=4'><?=$this->lang['top']?></a></li>
                    </ul>
                </li><li>
                    <h1><?=$this->lang['gift']?></h1>
                    <a href="<?=URL?>gift/make-a-gift"><?=$this->lang['suggestion gif']?></a>
                </li><li>
                    <h1><?=$this->lang['newsletter']?></h1>
                    <a><?=$this->lang['signup for recive']?><br>
                        <?=$this->lang['our offers']?></a>
                </li><li class="footerlogo">
                    <p><span style="font-size: 36px;font-family: 'Gotham';font-weight: bold;color:#ffffff;">TERRAE</span><br>
                        C/ Miguel Grau 329, Piazenza. Italia ©</p>
                </li><li>
                    <h1><?=$this->lang['experiences']?></h1>
                    <ul class="footer-list-a">
                        <li><a href='<?=URL?>experience/results?category=2'><?=$this->lang['savor']?></a></li>
                        <li><a href='<?=URL?>experience/results?category=4'><?=$this->lang['create']?></a></li>
                        <li><a href='<?=URL?>experience/results?category=1'><?=$this->lang['remember']?></a></li>
                        <li><a href='<?=URL?>experience/results?category=3'><?=$this->lang['explore']?></a></li>
                    </ul>
                </li>
                <li>
                    <h1><?=$this->lang['contact']?></h1>
                    <ul class="footer-list-a">
                        <li><a href="<?=URL?>page/view/partners"><?=$this->lang['contact partners']?></a></li>
                    </ul>
                </li><li>
                    <h1><?=$this->lang['share']?></h1>
                    <ul class="socialIcons">
                        <li>
                            <a><div id="gp"></div></a>
                        </li>
                        <li>
                            <a><div id="tw"></div></a>
                        </li>
                        <li>
                            <a><div id="fb"></div></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>  
</div>  
<script>var lang=<?=json_encode($this->lang);?>;</script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?= URL; ?>public/js/custom.js"></script>
<script src="<?= URL; ?>public/js/mobile.js"></script>
<script src="<?= URL; ?>public/js/zebra_form.js"></script>
<script src="<?= URL; ?>public/js/html2canvas.js"></script>


<?php
if (isset($this->js))
    foreach ($this->js as $js)
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
?>
</body>
</html>