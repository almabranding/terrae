<div id="booking-wrapper">
    <div id="signup-box" class="booking-page">
        <h1><?=$this->lang['congratulations'];?></h1>
        <h3><?=$this->lang['an email was sent'];?>...</h3>
        <div class="separator"></DIV>
        <h2><?=$this->lang['details of your reservation']?></h2>
        <div id="booking-detail-wrapper">
            <div id="splash-logo">
                <a href="/">
                    <img src="http://terrae.com.mialias.net/public/img/logo.png">
                </a>
                <div class="comefeel"><?=$this->lang['come & feel'];?></div>
                <div class="subline"></div>
            </div>
            <br>
            <ul id="booking-detail-user">
                <li class="label"><?=$this->lang['fullname'];?>:</li><li class="data"><?= $this->user['first_name'] ?></li>
                <li class="label"><?=$this->lang['surname'];?>:</li><li class="data"><?= $this->user['last_name'] ?></li>
                <li class="jump"></li>
                <li class="label"><?=$this->lang['email'];?>:</li><li class="data"><?= $this->user['email'] ?></li>
                <li class="label"><?=$this->lang['city'];?>:</li><li class="data"><?= $this->user['city'] ?></li>
                <li class="jump"></li> 
                <li class="label"><?=$this->lang['phone'];?>:</li><li class="data"><?= $this->user['phone'] ?></li>
                <li class="label"><?=$this->lang['country'];?>:</li><li class="data"><?= $this->user['country'] ?></li>
                <li class="jump"></li>
            </ul>
            <br>
            <ul id="booking-detail-amount">
                <li>
                    <ul class="title">
                        <li class="concept"><?=$this->lang['concept'];?></li><li class="checkin"><?=$this->lang['check in'];?></li><li class="checkout"><?=$this->lang['check out'];?></li><li class="places"><?=$this->lang['Nplaces'];?></li><li class="amount"><?=$this->lang['amount'];?></li>
                    </ul>
                </li>
                <li class="line"></li>
                <? $total = 0;
                foreach ($this->rooms as $booking) {
                    $total+=$booking['price']; ?>
                    <li>
                        <ul class="data">
                            <? if (!isset($_POST['giftType'])) { ?>
                            <li class="concept"><a href="<?=URL?>accommodation/detail/<?=$booking['hotel_id']?>/<?=$booking['name']?>"><?= $booking['name'] ?> - <?= $booking['room_type'] ?></a></li><li class="checkin"><?= $this->lang[date('l', strtotime($booking['checkin_date']))]; ?>, <?= Model::getTime($booking['checkin_date']) ?></li><li class="checkout"><?= $this->lang[date('l', strtotime($booking['checkout_date']))]; ?>, <?= Model::getTime($booking['checkout_date']) ?></li><li class="places"><?= $booking['max_adults'] ?> <?=$this->lang['adult']?>   <?= $booking['max_children'] ?> <?=$this->lang['children']?></li><li class="amount"><?= $booking['price'] ?> €</li>
                            <? } ?>
                            <? if (isset($_POST['giftType'])) { ?>
                                <li class="concept"><?= $booking['name'] ?></li><li class="checkin"><?= '-' ?></li><li class="checkout"><?='-'?></li><li class="places"><?='-' ?></li><li class="amount"><?= $booking['price'] ?> €</li>
                            <? } ?>
                        </ul>
                    </li><? } ?>
                <li class="total"><?=$this->lang['total amount']?>: <?= $total ?> €</li>
            </ul>
        </div>
        <div id="booking-detail-more">
            <div id="need-more"><?=$this->lang['need to feel more?'];?></div>
            <a href="<?= URL ?>experience/" class="booking-more-feel" id="experiences"></a>
            <a href="<?= URL ?>accommodation/"  class="booking-more-feel" id="accommodation"></a>
            <a href="<?= URL ?>gift/"  class="booking-more-feel" id="gift"></a>
            <a href="#"  class="booking-more-feel" id="market"></a>
        </div>
        <div id="booking-detail-print-box">
            <a href="#"  value="Print this page" onClick="window.print()" class="booking-more-feel" id="print"></a>
            <a href="<?= URL ?>user/bookingPDF/8MRGZ0P3LB"  class="booking-more-feel" id="pdf"></a>
        </div>
    </div>