<h2>奖品管理</h2>
<div class="buttons">
  <a href="?m=mod&a=prize_add">添加奖品</a>  
</div>

<div class="list">
  <table width="600">
  <tr class="thead"><td>ID编号</td>
  <td>类型</td><td>奖品名称</td>
  <td>剩余数/总数</td><td>中奖概率</td>
  </tr>
  <tbody class="tbody">
  <?php foreach ($prize_list as $key => $item) {
    echo '<tr><td>'.$item['id'].'</td>';
    echo '<td>'.$item['type_name'].'</td>';
    echo '<td>'.$item['title'].'</td>';
    echo '<td>'.$item['remain_count'].'/'.$item['total_count'].'</td>';
    echo '<td>'.$item['rate'].'</td>';
    echo '</tr>';
  }?>
  </tbody>
  </table>
</div>

<script>
$(function(){
  $('.buttons a').colorbox();
});
</script>