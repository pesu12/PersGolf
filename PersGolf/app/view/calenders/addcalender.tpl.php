<div class='comment-form'>
  <form method=post style="width: 80%">
    <fieldset>
      <?=$activity=''; ?>
      <?php //Fill in data for a new activity?>
      <legend>Ny kalenderaktivitet</legend>
      <p><label>Kalenderaktivitet:<br/><textarea name='activity' style="width: 80%"><?=$activity?></textarea></label></p>
      <?php //Buttons for leaving activity, clear fields.?>
      <p class=buttons>
        <input type='submit' name='doAddCalender' value='Ny kalenderaktivitet' onClick="this.form.action = '<?=$this->url->create('Calender/add')?>'"/>
        <input type='reset' value='Rensa'/>
      </p>
    </fieldset>
  </form>
</div>
