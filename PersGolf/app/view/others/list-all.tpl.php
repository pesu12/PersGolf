<i><h2><?=$title?></h2></i>

<table style="width:80%">
  <?php foreach ($others as $other) : ?>
    <tr>
      <td width="10%">
          <?= $other->Id ?>
      </td>
      <td width="80%">
          <?= $other->Other ?>
      </td>
      <td width="10%" align="right">
          <b><a href="<?= $this->url->create('others/update/')?> "title="Ändra" class="id">Ändra</a></b>      
        </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
</br>
