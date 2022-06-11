<style>
.center {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.message {
    display: flex;
    justify-content: center;
    border: 3px solid black;
    border-radius: 10px;
    padding: 12px 0px;
    width: 100%;
    background-color: yellow;
    font-size: larger;
}

.success {
    background-color: #90EE90;
    color: black;
}

.error {
    background-color: tomato;
    color: white;
    font-weight: bold;
}
</style>
<div class="center">
    <?php foreach (get_all_messages() as $key => $message): ?>
    <p class="message 
        <?= $key === 'success' ? 'success' : '' ?> 
        <?= $key === 'error' ? 'error' : '' ?> 
        "><?= flash_message($key) ?></p>
    <?php endforeach ?>
</div>