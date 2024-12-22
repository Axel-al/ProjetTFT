<?php if (isset($message)): ?>
    <div id="notification" class="notification">
        <span><?= $this->e($message) ?></span>
        <button id="closeNotification" class="close-btn">&times;</button>
    </div>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const notification = document.getElementById('notification');
        const closeNotification = document.getElementById('closeNotification');

        if (notification) {
            if (notification.textContent.toLowerCase().includes('exception') || notification.textContent.toLowerCase().includes('error')) {
                notification.classList.add('error');
            } else {
                setTimeout(() => {
                    closeNotification.click();
                }, 3000);
            }

            closeNotification.addEventListener('click', () => {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 500);
            });
        }
    });
</script>