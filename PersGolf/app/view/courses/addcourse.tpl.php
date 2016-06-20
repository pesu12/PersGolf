<div class='comment-form'>
  <form method=post style="width: 80%">
    <fieldset>
      <?=$course=''; ?>
      <?=$information=''; ?>
      <?php //Fill in data for a new activity?>
      <legend>Ny Spelad bana</legend>
      <p><label>Spelad Bana:<br/><textarea name='course' style="width: 80%"><?=$course?></textarea></label></p>
      <p><label>Info:<br/><textarea name='information' style="width: 80%"><?=$information?></textarea></label></p>
      <?php //Buttons for leaving activity, clear fields.?>
      <p class=buttons>
        <input type='submit' name='doAddCourse' value='Ny spelad bana' onClick="this.form.action = '<?=$this->url->create('Course/add')?>'"/>
        <input type='reset' value='Rensa'/>
      </p>
    </fieldset>
  </form>
</div>
