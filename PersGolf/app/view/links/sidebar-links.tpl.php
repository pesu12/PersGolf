<i class="fa fa-external-link"></i>
<b><?=$title?></b>

<table>
  <?php foreach ($links as $link) : ?>
    <tr>
      <td>
        <a href="http://<?= $link->Link ?>"><?= $link->Link ?></a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
