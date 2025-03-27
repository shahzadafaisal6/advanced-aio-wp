class AIOFeedback {
    constructor() {
        this.initFeedbackTriggers();
    }

    initFeedbackTriggers() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.aio-feedback-btn')) {
                this.showFeedbackModal(e.target.dataset.responseId);
            }
        });
    }

    showFeedbackModal(responseId) {
        const modal = document.createElement('div');
        modal.className = 'aio-feedback-modal';
        modal.innerHTML = `
            <div class="aio-modal-content">
                <h3>How was this response?</h3>
                <div class="aio-rating-buttons">
                    <button data-rating="1">😞</button>
                    <button data-rating="3">😐</button>
                    <button data-rating="5">😊</button>
                </div>
                <textarea placeholder="Additional comments..."></textarea>
                <button class="aio-submit-feedback">Submit</button>
            </div>
        `;

        modal.querySelector('.aio-submit-feedback').addEventListener('click', () => {
            this.submitFeedback(responseId);
            modal.remove();
        });

        document.body.appendChild(modal);
    }

    async submitFeedback(responseId) {
        const rating = document.querySelector('.aio-rating-buttons button[aria-pressed="true"]')?.dataset.rating;
        const comments = document.querySelector('.aio-feedback-modal textarea').value;

        await jQuery.post(aio_public.ajax_url, {
            action: 'aio_submit_feedback',
            response_id: responseId,
            rating: rating,
            comments: comments,
            _ajax_nonce: aio_public.nonce
        });
    }
}

new AIOFeedback();
