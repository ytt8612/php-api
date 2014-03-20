<?php 
$local_url = 'http://127.0.0.1/api/YiBan/index_test.php?json=%7B%22sessID%22%3A%22vj32O9K74pXKigmM250UOCzX6vWYyewIwhDtUk6lCWMCJu9BEQEXC32al5hZ%252ByHBzALPb2NmLEw%253D%22%2C%22ct%22%3A%221%22%2C%22rv%22%3A%22AppStore%22%2C%22v%22%3A%222.2.0%22%2C%22apn%22%3A%22wifi%22%2C%22identify%22%3A%229fd3baae5d6d5f5d70fb0c44e57f8348%22%2C%22token%22%3A%2260f29cb5b621384fa900958f5c5f157e14d6347cc984e6192a293b54db63d594%22%2C%22device%22%3A%22iphon4s%22%2C%22sversion%22%3A%22ios6.0.2%22%2C%22data%22%3A%7B%22add_notice%22%3A%220%22%2C%22content%22%3A%22%5Cu9ad8%5Cu8003%5Cu52a0%5Cu6cb9%22%2C%22sync_tag%22%3A%220%22%2C%22at_eclass%22%3A%2226874%22%2C%22address%22%3A%22%5Cu4e0a%5Cu6d77%5Cu5e02%5Cu5f90%5Cu6c47%5Cu533a%5Cu4e0a%5Cu4e2d%5Cu8def%22%7D%2C%22do%22%3A%22status_add%22%7D&sig=2f1a786c9a7f250d2119f2fc4df42335';
$dev_url = 'http://10.21.118.243/api/YiBan/index_dev.php?json=%7B%22sessID%22%3A%22vj32O9K74pXKigmM250UOAPjjhcJ3nKRGeGHqTUBIpBbJDmyVWrh1uQ1aIw9Ytkh9ZH9f7Eswsk%253D%22%2C%22ct%22%3A%221%22%2C%22rv%22%3A%22AppStore%22%2C%22v%22%3A%222.2.0%22%2C%22apn%22%3A%22wifi%22%2C%22identify%22%3A%229fd3baae5d6d5f5d70fb0c44e57f8348%22%2C%22token%22%3A%2260f29cb5b621384fa900958f5c5f157e14d6347cc984e6192a293b54db63d594%22%2C%22device%22%3A%22iphon4s%22%2C%22sversion%22%3A%22ios6.0.2%22%2C%22data%22%3A%7B%22add_notice%22%3A%220%22%2C%22content%22%3A%22%5Cu9ad8%5Cu8003%5Cu52a0%5Cu6cb9%22%2C%22sync_tag%22%3A%220%22%2C%22at_eclass%22%3A%2226874%22%7D%2C%22do%22%3A%22status_add%22%7D&sig=3ff7b63def7329cd9684399076d44ff7';

$test_url = 'http://10.21.3.30:30080/api/YiBan/index_dev.php?json=%7B%22sessID%22%3A%22vj32O9K74pXKigmM250UODAWJrirB3IRYfX00SaPd5bF3In%252FPoc15O1QCOttu%252BO7fCEsAdUWL6U%253D%22%2C%22ct%22%3A%221%22%2C%22rv%22%3A%22AppStore%22%2C%22v%22%3A%222.2.0%22%2C%22apn%22%3A%22wifi%22%2C%22identify%22%3A%229fd3baae5d6d5f5d70fb0c44e57f8348%22%2C%22token%22%3A%2260f29cb5b621384fa900958f5c5f157e14d6347cc984e6192a293b54db63d594%22%2C%22device%22%3A%22iphon4s%22%2C%22sversion%22%3A%22ios6.0.2%22%2C%22data%22%3A%7B%22index%22%3A%221%22%7D%2C%22do%22%3A%22user_uploadavatar%22%7D&sig=8152ab413aa2bc72215e123695bcf5bd';
$beta_url = '';
$prd_url = 'http://mobile01.yiban.cn/api/YiBan/index.php?json=%7B%22sessID%22%3A%22vj32O9K74pXKigmM250UODAWJrirB3IRYfX00SaPd5YEWAXvhFqzP1txUm0H46KCu69%252B1%252BgEymI%253D%22%2C%22ct%22%3A%221%22%2C%22rv%22%3A%22AppStore%22%2C%22v%22%3A%222.2.0%22%2C%22apn%22%3A%22wifi%22%2C%22identify%22%3A%229fd3baae5d6d5f5d70fb0c44e57f8348%22%2C%22token%22%3A%2260f29cb5b621384fa900958f5c5f157e14d6347cc984e6192a293b54db63d594%22%2C%22device%22%3A%22iphon4s%22%2C%22sversion%22%3A%22ios6.0.2%22%2C%22data%22%3A%7B%22username%22%3A%22example3%22%2C%22password%22%3A%2221%40campus%22%7D%2C%22do%22%3A%22security_login%22%7D&sig=70fe1d1907fac58e23fbb59616e6cc9a';
$local_url='http://api.local/ApiTest/index_dev.php?json=%7B%22ct%22%3A%222%22%2C%22rv%22%3A%22AppStore%22%2C%22v%22%3A%223.1.0%22%2C%22apn%22%3A%22wifi%22%2C%22identify%22%3A%22r0dE7PP8fku%22%2C%22imei%22%3A%22r0dE7PP8fku%22%2C%22token%22%3A%22%22%2C%22device%22%3A%22iphon4s%22%2C%22sversion%22%3A%22ios6.0.2%22%2C%22sessID%22%3A%22vj32O9K74pWnXmB3Ysgj01ZYD9f6KAgKbJqvu%252F5KNO9VX49apePHOiVyjf3u8pv8%22%2C%22do%22%3A%22user_uploadavatar%22%7D&sig=ffdda55bec2804c33a48ae6cffc82994&debug=0';
?>
<html>
<head>
<script type="text/javascript">
// var tt = unescape('\u8bf7\u6c42\u6210\u529f');
// document.write(tt);
</script>
</head>
<body>
<form action="<?=$local_url ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="image[]" /><br />
    <input type="file" name="image[]" /><br />
    <input type="submit" name="submit" value="local" />
</form>
<form action="<?=$dev_url ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="image[]" /><br />
    <input type="file" name="image[]" /><br />
    <input type="submit" name="submit" value="dev" />
</form>
<form action="<?=$test_url ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="image[]" /><br />
    <input type="file" name="image[]" /><br />
    <input type="submit" name="submit" value="test" />
</form>
</body>
</html>

<?php 
echo urldecode($local_url);
?>
