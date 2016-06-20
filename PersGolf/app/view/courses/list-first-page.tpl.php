<i><h2><?=$title?></h2></i>

<table style="width:80%">
  <?php foreach ($courses as $course) : ?>
    <tr>
      <td width="10%">
          <?= $course->Id ?>
      </td>
      <td width="30%">
          <?= $course->Date ?>
      </td>
      <td width="20%">
          <?= $course->Course ?>
      </td>
      <td width="40%">
          <?= $course->Information ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</br>
</br>
