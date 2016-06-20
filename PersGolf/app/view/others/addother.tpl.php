<div class='comment-form'>
  <form method=post style="width: 80%">
    <fieldset>
      <?=$other=''; ?>
      <?php //Fill in data for a new activity?>
      <legend>Ny övrig information</legend>
      <p><label>Övrigt:<br/><textarea name='other' style="width: 80%"><?=$other?></textarea></label></p>
      <?php //Buttons for leaving activity, clear fields.?>
      <p class=buttons>
        <input type='submit' name='doAddOther' value='Ny övrigt' onClick="this.form.action = '<?=$this->url->create('Other/add')?>'"/>
        <input type='reset' value='Rensa'/>
      </p>
    </fieldset>
  </form>
</div>
