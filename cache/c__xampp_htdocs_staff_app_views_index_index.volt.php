<h2>Log in  using this form</h2>
<?= $this->getContent() ?>

<?= $this->tag->form(['method' => 'post', 'class' => 'form-search']) ?>
<p>
    <?= $form->render('email') ?>
</p>
<p>
    <?= $form->render('password') ?>
</p>
<p>
    <?= $form->render('login') ?>
</p>
<?= $form->render('csrf', ['value' => $this->security->getToken()]) ?>
</form>