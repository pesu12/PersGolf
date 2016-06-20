<i><h2><?=$title?></h2></i>

<table style="width:80%">
  <?php foreach ($calenders as $calender) : ?>
    <tr>
      <td width="10%">
          <?= $calender->Id ?>
      </td>
      <td width="30%">
          <?= $calender->Date ?>
      </td>
      <td width="50%">
          <?= $calender->Activity ?>
      </td>
      <td width="10%" align="right">
        <td>
          <b><a href="<?= $this->url->create('calender/update/')?> "title="Ändra" class="id">Ändra</a></b>
        </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
</br>
