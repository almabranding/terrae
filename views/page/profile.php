<? if ($this->bookings) { ?>
    <div id="signup-box">
        <h1><?=$this->lang['my bookings']?></h1>
        <div class="separator"></div>
        <ul id="booking-list">
            <? foreach ($this->bookings as $booking) { ?><li><div class="title"><a href="<?=URL?>accommodation/detail/<?=$booking['hotel_id']?>/<?=$booking['name']?>"><?= $booking['name'].(($booking['room_type'])?' - '.$booking['room_type']:'') ?></a></div><a class="more" href="<?= URL ?>user/booking/<?= $booking['booking_number'] ?>">+ <?=$this->lang['more info']?></a></li><? } ?>  
        </ul>
    </div>
<? } ?>

<div id="signup-box">
    <h1><?=$this->lang['sign up form']?></h1>
    <h3>*<?=$this->lang['all fields are required']?></h3>
    <div class="separator"></DIV>
    <h2><?=$this->lang['personal details']?></h2>
    <div class="separator"></DIV>
</div>
<?= $this->signupForm->render('views/templates/signup-template.php') ?>