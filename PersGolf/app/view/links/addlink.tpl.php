<div class='comment-form'>
  <form method=post style="width: 80%">
    <fieldset>
      <?=$link=''; ?>
      <?=$description=''; ?>
      <?php //Fill in data for a new activity?>
      <legend>Ny länk</legend>
      <p><label>Länk:<br/><textarea name='link' style="width: 80%"><?=$link?></textarea></label></p>
      <p><label>Beskrivning:<br/><textarea name='description' style="width: 80%"><?=$description?></textarea></label></p>
      <?php //Buttons for leaving activity, clear fields.?>
      <p class=buttons>
        <input type='submit' name='doAddLink' value='Ny länk' onClick="this.form.action = '<?=$this->url->create('Link/add')?>'"/>
        <input type='reset' value='Rensa'/>
      </p>
    </fieldset>
  </form>
</div>
