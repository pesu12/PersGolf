<div class='comment-form'>
  <form method=post style="width: 60%">
    <fieldset>
      <?=$category=''; ?>
      <?=$activity=''; ?>
      <?php //Fill in data for a new activity?>
      <legend>Nya spontana tankar</legend>
      <p><label>Kategori:<br/><textarea name='category' style="width: 60%"><?=$category?></textarea></label></p>
      <p><label>Tanke:<br/><textarea name='activity' style="width: 60%"><?=$activity?></textarea></label></p>
      <?php //Buttons for leaving activity, clear fields.?>
      <p class=buttons>
        <input type='submit' name='doAddThought' value='Ny spontan tanke' onClick="this.form.action = '<?=$this->url->create('Thought/add')?>'"/>
        <input type='reset' value='Rensa'/>
      </p>
    </fieldset>
  </form>
</div>
