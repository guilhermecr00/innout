<div class="content-title mb-4">
    <?php if ($icon) { //se estiver setado, vai entrar e inserir o que está no $icon 
    ?>
    <i class="icon <?= $icon ?> mr-2"></i>
    <?php } ?>
    <div>
        <h1>
            <?= $title ?>
        </h1>
        <h2> <?= $subtitle ?></h2>
    </div>
</div>