class AIOVoiceInput {
    constructor(selector = '.aio-voice-btn') {
        this.buttons = document.querySelectorAll(selector);
        this.init();
    }

    init() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        this.recognition = new SpeechRecognition();
        this.recognition.continuous = false;
        this.recognition.interimResults = false;

        this.buttons.forEach(btn => {
            btn.addEventListener('click', () => this.toggleRecording(btn));
        });
    }

    toggleRecording(btn) {
        if (btn.classList.contains('recording')) {
            this.recognition.stop();
            btn.classList.remove('recording');
        } else {
            this.recognition.start();
            btn.classList.add('recording');
        }
    }
}

new AIOVoiceInput();
