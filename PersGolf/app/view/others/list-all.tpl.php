<i class="fa fa-comment"></i>
<b><?=$title?></b>

<table style="width:80%">
  <?php foreach ($others as $other) : ?>
    <tr>
      <td width="10%">
          <?= $other->Id ?>
      </td>
      <td width="90%">
          <?= $other->Other ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
