<h2>中奖列表</h2>
<div class="list">
  <table width="600">
  <tr class="thead"><td>ID编号</td>
  <td>奖品名称</td>
  <td>中奖者</td>
  <td>手机号码</td>
  <td>中奖时间</td>
  </tr>
  <tbody class="tbody">
  <?php foreach ($list as $key => $item) {
    echo '<tr><td>'.$item['id'].'</td>';
    echo '<td>'.$item['title'].'</td>';
    echo '<td>'.$item['username'].'</td>';
    echo '<td>'.$item['mobile'].'</td>';
    echo '<td>'.date('Y-m-d H:i', $item['addtime']).'</td>';
    echo '</tr>';
  }?>
  </tbody>
  </table>
</div>