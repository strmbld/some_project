window.onload = function() {
    let file0 = document.getElementById('record_form_attachments_0_file');
    let file1 = document.getElementById('record_form_attachments_1');
    let file2 = document.getElementById('record_form_attachments_2');
    let file3 = document.getElementById('record_form_attachments_3');

    file0.addEventListener('change', (event) => {
        file1.removeAttribute('hidden');
        file1.addEventListener('change', (event) => {
            file2.removeAttribute('hidden');
            file2.addEventListener('change', (event) => {
                file3.removeAttribute('hidden')
            })
        })
    });
}