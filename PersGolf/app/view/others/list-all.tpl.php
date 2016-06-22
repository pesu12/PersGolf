<i><h2><?=$title?></h2></i>

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
</br>
