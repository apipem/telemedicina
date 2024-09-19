<style>
    .chat-box {
        height: 400px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        background-color: #f8f9fa;
    }
    .message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        max-width: 70%;
    }
    .message.user {
        background-color: #6c757d;
        color: white;
        margin-left: auto; /* Alinear a la derecha */
        text-align: right;
    }
    .message.received {
        background-color: #e9ecef;
        color: black;
        margin-right: auto; /* Alinear a la izquierda */
        text-align: left;
    }
</style>

<?php if (Yii::$app->user->identity->rol == "Paciente") { ?>
    <input type="hidden" placeholder="" id="in" value="<?= $chat->id_paciente ?>">
    <input type="hidden" placeholder="" id="out" value="<?= $chat->id_medico ?>">
<?php } ?>
<?php if (Yii::$app->user->identity->rol == "Medico") { ?>
    <input type="hidden" placeholder="" id="out" value="<?= $chat->id_paciente ?>">
    <input type="hidden" placeholder="" id="in" value="<?= $chat->id_medico ?>">
<?php } ?>

<div class="container mt-5">
    <h2>Chat con <span id="user-name"></span></h2>
    <div class="chat-box" id="chat-box">
        <!-- Los mensajes aparecerán aquí -->
    </div>
    <div class="input-group mt-3">
        <input type="text" class="form-control" placeholder="Escribe un mensaje..." id="message-input">
        <button class="btn btn-primary" id="send-button">Enviar</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php $csrfToken = Yii::$app->request->csrfParam; ?>
<?php $csrfValue = Yii::$app->request->csrfToken; ?>
<script>
    const csrfParam = '<?= $csrfToken ?>';
    const csrfValue = '<?= $csrfValue ?>';
</script>

<script>
$(document).ready(function() {
    const userName = '<?= $persona->nombre_completo ?>';
    $('#user-name').text(userName);

    const envia = $('#in').val(); // Obtener el valor del id_paciente
    const recive = $('#out').val(); // Obtener el valor del id_medico

    const chatId = "<?= $chat->id; ?>";

    // Función para cargar mensajes
    function loadMessages() {
        $.ajax({
            url: '<?= Yii::$app->getUrlManager()->createUrl("chat/get") ?>',
            method: 'GET',
            data: { chatId: chatId },
            success: function(data) {
                const chatBox = $('#chat-box');
                chatBox.html(''); // Limpiar el chat antes de agregar nuevos mensajes

                data.messages.forEach(function(msg) {
                    let messageDiv;

                    // Usar el id del remitente para comparar
                    if (msg.id_remitente == envia) {
                        messageDiv = $('<div>').addClass('message user').text(msg.mensaje);
                    } else {
                        messageDiv = $('<div>').addClass('message received').text(msg.mensaje);
                    }

                    chatBox.append(messageDiv);
                });

                chatBox.scrollTop(chatBox[0].scrollHeight); // Desplazar hacia abajo
            }
        });
    }

    // Enviar un mensaje
    $('#send-button').on('click', function() {
        const messageText = $('#message-input').val();
        if (messageText) {
            $.ajax({
                url: '<?= Yii::$app->getUrlManager()->createUrl("chat/mensaje") ?>',
                method: 'POST',
                data: {
                    chatId: chatId,
                    message: messageText,
                    [csrfParam]: csrfValue // Agregar el token CSRF
                },
                success: function() {
                    $('#message-input').val(''); // Limpiar el input
                    loadMessages(); // Cargar mensajes después de enviar
                }
            });
        }
    });

    // Cargar mensajes cada 15 segundos
    setInterval(loadMessages, 15000);

    // Cargar mensajes al inicio
    loadMessages();
});
</script>
