<?php if(!empty($similaires)): ?>
<div style="margin-top: 40px; padding: 20px; background: #f9f9f9; border-radius: 15px;">
    <h3 style="color: #2E7D32; margin-bottom: 20px;">🍽️ Vous aimerez aussi</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
        <?php foreach($similaires as $s): ?>
        <div style="background: white; border-radius: 10px; padding: 15px; box-shadow: 0 1px 5px rgba(0,0,0,0.1);">
            <h4 style="color: #2E7D32; margin-bottom: 5px;"><?= htmlspecialchars($s['title']) ?></h4>
            <div style="display: flex; gap: 10px; font-size: 12px; color: #666; margin: 5px 0;">
                <span>⏱️ <?= $s['duree'] ?> min</span>
                <span><?= $s['difficulte'] ?></span>
            </div>
            <a href="../controller/index.php?controller=recette&action=show&id=<?= $s['id'] ?>" style="background: #4CAF50; color: white; padding: 5px 12px; text-decoration: none; border-radius: 5px; font-size: 12px; display: inline-block; margin-top: 10px;">Voir →</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>