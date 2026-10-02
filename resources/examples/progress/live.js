// Stands in for a real import: five steps, one every 600ms.
document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-start-import]')) {
        return;
    }
    let done = 0;
    const timer = setInterval(() => {
        done++;
        progress.set('upload-progress', done * 20);
        progress.set('file-progress', done, { text: `${done} of 5 files` });
        if (done === 5) {
            clearInterval(timer);
        }
    }, 600);
});
