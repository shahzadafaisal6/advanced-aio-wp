class AIOWidget {
    constructor() {
        this.widget = document.querySelector('.aio-chat-widget');
        this.initEventListeners();
    }

    initEventListeners() {
        this.widget.querySelector('.aio-send-btn').addEventListener('click', () => this.sendMessage());
        this.widget.querySelector('input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    }

    async sendMessage() {
        const input = this.widget.querySelector('input');
        const message = input.value.trim();
        
        if (!message) return;
        
        this.addMessage(message, 'user');
        input.value = '';
        
        try {
            const response = await jQuery.post(aio_public.ajax_url, {
                action: 'aio_process_chat',
                message: message,
                _ajax_nonce: aio_public.nonce
            });
            
            this.addMessage(response.data.reply, 'ai');
        } catch (error) {
            this.addMessage('Error connecting to AI service', 'error');
        }
    }

    addMessage(content, type) {
        const msgElement = document.createElement('div');
        msgElement.className = `aio-message aio-${type}-message`;
        msgElement.innerHTML = content;
        this.widget.querySelector('.aio-chat-messages').appendChild(msgElement);
    }
}

new AIOWidget();
