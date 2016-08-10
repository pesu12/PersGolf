<i class="fa fa-calendar"></i>
<b><?=$title?></b>

<table style="width:80%">
  <?php foreach ($calenders as $calender) : ?>
    <tr>
      <td width="10%">
          <?= $calender->Id ?>
      </td>
      <td width="30%">
          <?= $calender->Date ?>
      </td>
      <td width="60%" align="left">
          <?= $calender->Activity ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
