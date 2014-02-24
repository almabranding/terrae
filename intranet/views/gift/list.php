<div id="sectionHeader">
    <h1>Gift</h1>
    <div id="sectionNav">
        
        <div class="btn grey" onclick="location.href = '<?=URL; ?>gift/types'">Categories</div>
        <div class="btn grey" onclick="location.href = '<?=URL; ?>gift/bookingList'">Bookings</div>
        <div class="btn grey" onclick="location.href = '<?=URL; ?>gift/lista'">Gifts</div>
        <?if($this->section=='gift'){?>
        <div class="btn blue" onclick="location.href = '<?=URL; ?>gift/view'">New gift</div>
        <?}if($this->section=='category'){?>
        <div class="btn blue" onclick="location.href = '<?=URL; ?>gift/viewType'">New category</div>
        <?}if($this->section=='booking'){?>
        <?}?>
    </div>
    <div class="clr"></div>
</div>
<div id="sectionContent">
<? $this->getView('table');?>
</div>