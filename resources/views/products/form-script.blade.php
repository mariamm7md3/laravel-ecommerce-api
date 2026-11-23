<script>
    const previewBox = document.getElementById('image-preview');
    const input = document.getElementById('photo');
    const image = document.getElementById('preview-image');
    const placeholder = document.getElementById('placeholder');

    previewBox.addEventListener('click', () => {
        input.click();
    });

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            image.src = e.target.result;
            image.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    });
</script>
