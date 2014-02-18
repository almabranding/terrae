
<div id="wrapper"><div id="container" class="splash-head">
        <label id="navCheckLabel" onclick="" for="navCheck"></label>
        <input id="navCheck" type="checkbox">
        <div id="splash-login"><?= (!Session::get('loggedIn'))?'<label onclick="" for="menuCheck" class="uppercase">'.$this->lang['login'].'</label>':'<a href="'.URL.'user/profile">Welcome '.Session::get('username').'</a> | <a href="'.URL.'user/logout">Logout</a>'?>
            <input id="menuCheck" type="checkbox">
            <div id="splash-login-container">
                <div id="splash-login-box">
                    <div id="splash-login-pic"></div>
                    <div class="splash-login-left">
                        <h2 class="uppercase"><?=$this->lang['new user']?> ?</h2>
                        <a class="ford-arrow" href="/user/signup"><?=$this->lang['Create Account']?></a>
                        <h2 style="margin-top: 90px;"><?=$this->lang['FORGOT YOUR PASSWORD']?> ?</h2>
                        <a href="/user/remember" class="ford-arrow"><?=$this->lang['Send email']?></a>
                    </div>
                    <div class="splash-login-line"></div>
                    <div class="splash-login-right">
                        <h1 class="uppercase"><?=$this->lang['sign in']?></h1>
                        <?= $this->loginForm->render('views/templates/login-template.php') ?>
                    </div>
                </div>
            </div>
        </div>
 
        <div id="splash-logo">
            <a href="/experience/home/<?=Session::get('destination')?>"><img src="<?= URL ?>public/img/logo.png"></a>
            <div id="logoDestination"><?=$this->destination?></div>
            <div class="subline"></div>
            <ul id="logo-menu">
                <?  foreach ($this->sections as $key => $section) { ?><li><a href="/<?=($this->section)?$this->section:'experience'?>/home/<?= strtolower($section['name']) ?>"><?= $section['name'] ?></a></li><? } ?>
            </ul>
        </div>
        <div id="menuNav">
            <ul>  
                <?  foreach ($this->menu as $key => $menu) { ?><li><a href="<?= strtolower($menu['url']) ?>"><?= $menu['name'] ?></a></li><? } ?>
                <li class="desactivated"><a href="#">MARKET</a></li>
            </ul>
        </div>
        <div id="breadcrumb-container">
            <div id="breadcrumb"><?=$this->getBreadcrumb()?></div>
            <div id="support-container">
                <label id="directSupport" for="supportCheck" class="directSupport-more">DIRECT SUPPORT</label>
                <input id="supportCheck" name="supportCheck" type="checkbox">
                <div id="support-box">
                    <label for="supportCheck"></label>
                    <ul>
                        <table>
                            <tr>
                                <td class="support-label tel" rowspan="2">TEL.:</td><td>(0039) 321 456 789</td>
                            </tr>
                            <tr>
                                <td>(0039) 321 456 789</td>
                            </tr>
                            <tr>
                                <td class="support-label">SKYPE: </td><td>terrae-piacenza</td>
                            </tr>
                            <tr>
                                <td class="support-label">Facebook: </td><td><a target='_blank' href="http://www.facebook.com/terrae">www.facebook.com/terrae</a></td>
                            </tr>
                        </table>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="container" >

