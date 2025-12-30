<div class="phim-scroll-box">
<div class="phim-list">

<?php while ($p = $phim_rs->fetch_assoc()): ?>
<div class="phim-row">

    <div class="poster-box">
        <img src="../images/movie/<?= $p['Poster'] ?>" class="poster">
    </div>

    <div class="phim-info">
        <h2><?= $p['TenPhim'] ?></h2>
        <div class="meta">
            <?= $p['TheLoai'] ?> • <?= $p['ThoiLuong'] ?> phút • ⭐ <?= $p['Rate'] ?>
        </div>

        <div class="gio-grid">
        <?php
        $gid = $p['IDPhim'];
        $gio_rs = $conn->query("
            SELECT GioChieu
            FROM qllichchieu
            WHERE IDRap = $selectedRap
              AND IDPhim = $gid
              AND NgayChieu = '$selectedNgay'
            ORDER BY GioChieu
        ");
        while ($g = $gio_rs->fetch_assoc()):
            $ghe_rs = $conn->query("SELECT COUNT(*) AS c FROM qlghengoi WHERE TrangThai = 0");
            $soGhe = $ghe_rs->fetch_assoc()['c'];
        ?>
            <div class="gio-block">
                <a class="gio-btn" href="javascript:void(0)"
                   onclick="openModal(
                        '<?= $p['TenPhim'] ?>',
                        '<?= $p['Poster'] ?>',
                        '<?= $currentRapName ?>',
                        '<?= $selectedNgay ?>',
                        '<?= date('H:i', strtotime($g['GioChieu'])) ?>',
                        '<?= $soGhe ?>'
                   )">
                    <?= date('H:i', strtotime($g['GioChieu'])) ?>
                </a>
                <span><?= $soGhe ?> ghế trống</span>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endwhile; ?>

</div>
</div>