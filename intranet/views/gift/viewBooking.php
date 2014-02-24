<div id="sectionHeader">
    <a href=<?=URL?>gift/bookingList><div id="arrowBack">Back to gift</div></a>
    <h1>Edit/Create section</h1>
    
    <div class="clr"></div>
</div>
<div id="sectionContent">
    <?php $this->form->render(); ?>
    <table>
    <? foreach($this->data as $key=>$data){
        echo '<tr><td>'.$key.'</td><td>'.$data.'</td></tr>';
    }?>
    </table>
</div>
