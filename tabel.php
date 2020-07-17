<?php
include_once 'koneksi.php';
$q="";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = "SELECT * FROM data_barang  WHERE nama LIKE '%".$q."%'";
}
$title = 'Data Barang';

$sql = 'SELECT * FROM data_barang' ;
$sql_count ="SELECT COUNT(*)FROM data_barang";
if (isset($sql_where)) {
    $sql = $sql_where;
    $sql_count = $sql_where;
}
$result_count = mysqli_query($conn, $sql_count);
$count = 0;
if ($result_count) {
    $r_data = mysqli_fetch_row($result_count);
    $count=$r_data[0];
}
$per_page=1;
$num_page =  ceil($count / $per_page);
$limit = $per_page;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $offset = ($page  - 1) * $per_page;
}else{
    
    $offset = 0;
    $page=1;
}
 // $sql = " LIMIT {$offset}, {$limit}";
$result = mysqli_query($conn, $sql);

if (isset($sql_where)) {
    $sql = $sql_where;
}

$result = mysqli_query($conn, $sql);
include_once 'header.php';
if ($result) : 
?>
<center>
<form action="" method="get">
    <input type="text" name="q" class="q" value="<?php echo $q?>" autofocus>
    <input type="submit" name="submit" class="cari" value="Search">
</form>


    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Pesan Barang</th>
          
        </tr>
        <?php while ($row = mysqli_fetch_array($result)) : ?>
            <tr>
                <td><?php echo "<img src=\"{$row['gambar']}\" />"; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td>Rp. <?php echo $row['harga_jual']; ?></td>
                <td><?php echo $row['stok']; ?> </td>
                <td><button class="co"><a href="https://api.whatsapp.com/send?phone=6281519772403" class="coba">Pesan</a></button></td>

            </tr>
        <?php endwhile ?>
    </table>

<ul class="pagination">
    <li><a href="#">&laquo</a></li>
    <?php for ($i=1; $i <= $num_page ; $i++) { 
        $link   =   "?page={$i}";
        if (!empty($q)) $link = "&q={$q}";
        $class=($page == $i ? 'active': '');
        echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
        
    }?>
    <li><a href="#">&raquo</a></li>
</ul>
</center>
    <br>
<?php 
endif;

include_once 'footer.php';
?>