<i class="fa fa-book"></i>
<b><?=$title?></b>

<table style="width:80%">
  <?php foreach ($thoughts as $thouhgt) : ?>
    <tr>
      <td width="10%">
          <?= $thouhgt->Id ?>
      </td>
      <td width="30%">
          <?= $thouhgt->Date ?>
      </td>
      <td width="20%" align="left">
          <?= $thouhgt->Category ?>
      </td>
      <td width="40%">
          <?= $thouhgt->Activity ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
