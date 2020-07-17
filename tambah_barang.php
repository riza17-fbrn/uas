<?php
error_reporting(E_ALL);

$title = 'Data Barang';
include_once 'koneksi.php';

if (isset($_POST['submit'])) 
{
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

        if ($file_gambar['error'] == 0) 
        {
        $file_name = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/gambar/' . $file_name;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = 'gambar/' . $file_name;
        }
    }
    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, stok, gambar)';
    $sql .= "VALUE ('{$nama}', '{$kategori}', '{$harga_jual}', '{$stok}', '{$gambar}')";
    $result = mysqli_query($conn, $sql);

    header("location: tambah_barang.php");
}
include_once('header.php'); ?>

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
<nav>
    <ul>    
        
          <button class="coco"><a href="index.php" title="Dashboard"><i class="fa fa-mail-reply-all"> Back</i></a></button></li>

    </ul>
</nav>


<h2>Tambah Barang</h2>

<form action="tambah_barang.php" method="post" enctype="multipart/form-data">
    <div class="input">
        <label for="">Nama Barang</label>
        <input type="text" name="nama">
    </div>
    <div class="input">
        <label for="">Kategori</label>
        <select name="kategori">
            <option value="makeup">Make Up</option>
            <option value="Pakaian">Pakaian</option>
            <option value="Makanan">Makanan</option>
            
        </select>
    </div>
    <div class="input">
        <label for="">Harga Jual</label>
        <input type="text" name="harga_jual">
    </div>
   
    <div class="input">
        <label for="">Stok</label>
        <input type="text" name="stok">
    </div>
    <div class="input">
        <label for="">File gambar</label>
        <input type="file" name="file_gambar">
    </div>
    <div class="submit">
        <input type="submit" value="simpan" name="submit">
    </div>
</form>

<form action="" method="get">
    <input type="text" name="q" class="q" value="<?php echo $q?>" >
    <input type="submit" name="submit" class="cari" value="Search">
</form>

 <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
          
        </tr>
        <?php while ($row = mysqli_fetch_array($result)) : ?>
            <tr>
                <td><?php echo "<img src=\"{$row['gambar']}\" />"; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td>Rp. <?php echo $row['harga_jual']; ?></td>
                <td><?php echo $row['stok']; ?> </td>
                 <td>
                    <button class="co"><a href="edit_barang.php?id=<?php echo $row['id_barang']; ?>">Edit</a></button><br><br>
                   <button class="co">  <a href="hapus_barang.php?id=<?php echo $row['id_barang']; ?>">Delete</a></button>
                </td>

            </tr>

        <?php endwhile ?>
    </table>
<br>
<?php endif; include_once('footer.php'); ?>