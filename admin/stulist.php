<?php header("Content-Type:text/html; charset=utf-8"); ?>
<?php session_start();
if(!$_SESSION[A_Username]){
	  echo "<script language='javascript'>alert('请先登录！');window.location='../index.php'</script>";
}
?>
<?php
include("../Connections/myconn.php");
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$query_Recordset1 = "SELECT FS_ID, S_Username, S_Name, S_Academy FROM student order by FS_ID";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $myconn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生列表</title>
</head>
<style type="text/css">
body {
	background-color: #CCCCCC;
}
.di {
	background-color: #09F;
}
</style>
<div align="center">

  <table width="1040" border="0">
    <tr>
      <td><?php include("adminhead.php"); ?></td>
    </tr>
    <tr>
      <td height="32" align="center"><table width="306" border="0">
        <tr>
          <td width="100" height="31" class="di"><a href="tealist.php">管理教师信息</a></td>
          <td width="100" class="di"><a href="stulist.php">管理学生信息</a></td>
          <td width="100" class="di">设置主页显示</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center"><table width="522" border="0" >
        <tr>
          <td colspan="3" align="center">学生列表：</td>
        </tr>
        <tr>
          <td colspan="3"><div align="right">共有<?php echo $totalRows_Recordset1; ?>条记录</div></td>
        </tr>
        <tr>
          <td align="center" width="168">用户名</td>
          <td align="center" width="168">姓名</td>
          <td align="center" width="172">学院</td>
        </tr>
        <?php do { ?>
        <tr>
          <td class = "di" align="center" width="168"><a href="modifystu.php?fsid=<?php echo $row_Recordset1['FS_ID']; ?>"><?php echo $row_Recordset1['S_Username']; ?></a></td>
          <td height = "30" class = "di" align="center" width="168"><?php echo $row_Recordset1['S_Name']; ?></td>
          <td class = "di" align="center" width="172"><?php echo $row_Recordset1['S_Academy']; ?></td>
        </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table>
        <table width="350" border="0">
          <tr>
            <td width="65"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">[第一页]</a>
              <?php } // Show if not first page ?></td>
            <td width="65"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">[上一页]</a>
              <?php } // Show if not first page ?></td>
            <td width="65"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">[下一页]</a>
              <?php } // Show if not last page ?></td>
            <td width="137"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">[最后一页]</a>
              <?php } // Show if not last page ?></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
</html>