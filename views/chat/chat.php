<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>
    <div class="container mt-5">
        <h2>Chat con <span id="user-name"></span></h2>
        <div class="chat-box" id="chat-box">
            <!-- Aquí se mostrarán los mensajes -->
        </div>
        <div class="input-group mt-3">
            <input type="text" class="form-control" placeholder="Escribe un mensaje..." id="message-input">
            <button class="btn btn-primary" id="send-button">Enviar</button>
        </div>
    </div>

    <script>
        // Obtener el nombre del usuario desde la URL
        const urlParams = new URLSearchParams(window.location.search);
        const userName = urlParams.get('user');
        document.getElementById('user-name').innerText = userName;

        // Simular mensajes de chat
        const messages = [
            { text: "Hola, ¿cómo estás?", user: "john" },
            { text: "¡Hola! Todo bien, gracias. ¿Y tú?", user: "jane" },
            { text: "Estoy aquí, listo para chatear.", user: "mike" },
        ];

        // Función para cargar mensajes
        function loadMessages() {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${msg.user === userName ? 'user' : 'received'}`;
                messageDiv.innerText = msg.text;
                chatBox.appendChild(messageDiv);
            });
            chatBox.scrollTop = chatBox.scrollHeight; // Desplazar hacia abajo
        }

        // Enviar un mensaje
        document.getElementById('send-button').addEventListener('click', () => {
            const input = document.getElementById('message-input');
            const text = input.value;
            if (text) {
                messages.push({ text: text, user: userName });
                input.value = '';
                loadMessages();
            }
        });

        loadMessages(); // Cargar mensajes al inicio
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
