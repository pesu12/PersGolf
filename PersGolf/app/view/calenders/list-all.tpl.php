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
      <td width="60%">
          <?= $calender->Activity ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
</br>
