<div id="signup-box">
    <h1><?=$this->lang['sign up form']?></h1>
    <h3>*<?=$this->lang['all fields are required']?></h3>
    <div class="separator"></DIV>
    <h2><?=$this->lang['personal details']?></h2>
    <div class="separator"></DIV>
</div>
<?= $this->signupForm->render('views/templates/signup-template.php') ?>
<div id="errorMsg"><?=$this->error?></div>