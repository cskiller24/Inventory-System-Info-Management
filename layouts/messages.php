<?php foreach (get_all_messages() as $key => $message): ?>
    <p><?= flash_message($key) ?></p>
<?php endforeach ?>