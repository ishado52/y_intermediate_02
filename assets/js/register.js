const form = document.getElementById('js-input_form');
const inputs = document.querySelectorAll('#js-input_name, #js-input_mail, #js-input_pass, #js-input_file');

form.onsubmit = (e) => {
    let valid = true;
    inputs.forEach(input => {
        const error = input.nextElementSibling;
        if (error && error.classList.contains('error')) {
            error.remove();
        }

        if (!input.value) {
            valid = false;
            const errorMessage = document.createElement('span');
            errorMessage.textContent = '入力してください';
            errorMessage.classList.add('error');
            input.parentNode.insertBefore(errorMessage, input.nextElementSibling);
        }
    });

    if (!valid) {
        alert('入力内容を確認してください');
        e.preventDefault();
    }
};