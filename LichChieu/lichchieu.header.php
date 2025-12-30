
<div class="header">
    <h2>LỊCH CHIẾU RẠP <?= htmlspecialchars($currentRapName) ?></h2>
    <div class="beta-rap-select">
        <div class="selected-rap" onclick="toggleRap()">
            <?= $currentRapName ?> ▼
        </div>
        <div class="rap-dropdown" id="rapMenu">
            <?php foreach ($raps as $r): ?>
                <a href="?rap=<?= $r['IDRap'] ?>">
                    <?= $r['TenRap'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="ngay-tab">
<?php while ($n = $ngay_rs->fetch_assoc()): ?>
    <a href="?rap=<?= $selectedRap ?>&ngay=<?= $n['NgayChieu'] ?>"
       class="<?= ($n['NgayChieu'] == $selectedNgay) ? 'active' : '' ?>">
        <div class="day"><?= date('d', strtotime($n['NgayChieu'])) ?></div>
        <div class="sub">
            <?= date('m', strtotime($n['NgayChieu'])) ?> -
            <?= date('D', strtotime($n['NgayChieu'])) ?>
        </div>
    </a>
<?php endwhile; ?>
</div>
