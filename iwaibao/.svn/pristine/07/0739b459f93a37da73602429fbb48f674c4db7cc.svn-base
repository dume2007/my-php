<form id="myForm" method="post" action="?m=mod&a=prize_add">
<table width="460" class="table1" cellpadding="1" cellspacing="1">
  <tr>
    <td width="110" align="right">类型：</td>
    <td><select name="type">
      <option value="<?php echo PRIZE_TYPE_VIRTUAL;?>">虚拟物品</option>
      <option value="<?php echo PRIZE_TYPE_MATERIAL;?>">实物</option></select></td>
  </tr>
  <tr>
    <td align="right">名称：</td>
    <td><input type="text" name="title" class="text"></td>
  </tr>
  <tr>
    <td align="right">链接：</td>
    <td><input type="text" name="link" class="text"></td>
  </tr>
  <tr>
    <td align="right">中奖概率：</td>
    <td><input type="text" name="rate"> 0-100的整数</td>
  </tr>
  <tr>
    <td align="right">奖品数量：</td>
    <td><input type="text" name="total_count"></td>
  </tr>
  <tr height="50">
    <td align="center" colspan="2"><input type="submit" value=" 确认添加 " class="submit"></td>
  </tr>
  
</table>
<div id="error"></div>
</form>

<script type="text/javascript">
$(document).ready(function() {
  $('#myForm').on('submit', function(e) {
      e.preventDefault(); // <-- important
      $(this).ajaxSubmit({
        dataType: 'json',
        success: function(data) {
          if (data.status == 0) {
              $('#error').html(data.info);
              $.colorbox.resize();
          } else {
              alert('添加成功');
              $.colorbox.close();                        
          }
        }
      });
  });
});  
</script>
