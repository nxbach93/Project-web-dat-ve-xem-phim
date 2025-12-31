<div class="phim-scroll-box">
<div class="phim-list">

<?php 

if ($phim_rs && $phim_rs->num_rows > 0) {
    $phim_rs->data_seek(0);

    while ($p = $phim_rs->fetch_assoc()): 
        $gid = $p['IDPhim'];
?>
    <div class="phim-row">
        <div class="poster-box">
            <img src="../images/movie/<?= $p['Poster'] ?>" class="poster" onerror="this.src='https://via.placeholder.com/150'">
        </div>

        <div class="phim-info">
            <h2><?= htmlspecialchars($p['TenPhim']) ?></h2>
            <div class="meta">
                <?= htmlspecialchars($p['TheLoai']) ?> • <?= $p['ThoiLuong'] ?> phút • ⭐ <?= $p['Rate'] ?>
            </div>

            <div class="gio-grid">
            <?php
            $sql_gio = "SELECT IDLichChieu, GioChieu 
                        FROM qllichchieu 
                        WHERE IDRap = $selectedRap 
                          AND IDPhim = $gid 
                          AND NgayChieu = '$selectedNgay' 
                        ORDER BY GioChieu";
            
            $gio_rs = $conn->query($sql_gio);

            if ($gio_rs):
                if ($gio_rs->num_rows == 0) {
                    echo "<p style='color:#999; font-size:0.9em;'>Không có suất chiếu</p>";
                }
                while ($g = $gio_rs->fetch_assoc()):
                    $ghe_rs = $conn->query("SELECT COUNT(*) AS c FROM qlghengoi WHERE TrangThai = 0");
                    $soGhe = ($ghe_rs) ? $ghe_rs->fetch_assoc()['c'] : 0;
                    
                    $gioChieuDep = date('H:i', strtotime($g['GioChieu']));
            ?>
                <div class="gio-block">
                    <a class="gio-btn btn-open-modal" href="javascript:void(0)"
                       data-ten="<?= htmlspecialchars($p['TenPhim']) ?>"
                       data-poster="<?= $p['Poster'] ?>"
                       data-rap="<?= htmlspecialchars($currentRapName) ?>"
                       data-ngay="<?= $selectedNgay ?>"
                       data-gio="<?= $gioChieuDep ?>"
                       data-ghe="<?= $soGhe ?>"
                       data-idlc="<?= $g['IDLichChieu'] ?>"> <?= $gioChieuDep ?>
                    </a>
                    <span><?= $soGhe ?> ghế trống</span>
                </div>
            <?php 
                endwhile; 
            endif;
            ?>
            </div>
        </div>
    </div>
<?php 
    endwhile; 
} else {
    echo "<p style='text-align:center; padding:20px;'>Không có phim nào chiếu vào ngày này.</p>";
}
?>

</div>
</div>