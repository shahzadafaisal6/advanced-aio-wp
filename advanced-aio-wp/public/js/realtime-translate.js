document.addEventListener('DOMContentLoaded', () => {
    const translateElements = document.querySelectorAll('[data-translate]');
    
    if (translateElements.length > 0) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1 && node.hasAttribute('data-translate')) {
                            translateContent(node);
                        }
                    });
                }
            });
        });

        translateElements.forEach((el) => {
            observer.observe(el, { childList: true, subtree: true });
            translateContent(el);
        });
    }

    async function translateContent(element) {
        const targetLang = element.getAttribute('data-translate') || 'en';
        const response = await fetch(aio_public.ajax_url, {
            method: 'POST',
            body: new URLSearchParams({
                action: 'aio_translate_content',
                content: element.innerText,
                target_lang: targetLang,
                _ajax_nonce: aio_public.nonce
            })
        });
        
        const data = await response.json();
        if (data.success) {
            element.innerText = data.data.translatedText;
        }
    }
});
