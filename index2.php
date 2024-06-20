<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Input</title>
    <!-- Inclua os estilos do Select2 e flag-icon-css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css">
    <style>
        .country-select {
            width: 200px;
            display: inline-block;
            vertical-align: top;
        }
        .phone-input {
            display: inline-block;
            vertical-align: top;
            margin-left: 10px;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            display: flex;
            align-items: center;
        }
        .select2-container .select2-selection--single .select2-selection__rendered img {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div id="input-container">
        <input type="text" id="phone-input" placeholder="Enter your phone number">
    </div>

    <!-- Inclua os scripts do Select2 e jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        const countries = [
            { name: "United States", code: "us", ddi: "+1" },
            { name: "Brazil", code: "br", ddi: "+55" },
            { name: "Canada", code: "ca", ddi: "+1" },
            // Adicione mais países conforme necessário
        ];

        function initWhatsAppInput(inputId) {
            const input = document.getElementById(inputId);
            const container = input.parentElement;

            // Criar o select com as bandeiras
            const select = document.createElement('select');
            select.classList.add('country-select');

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.ddi;
                option.innerHTML = `${country.name} (${country.ddi})`;
                option.setAttribute('data-code', country.code);
                select.appendChild(option);
            });

            // Criar o novo campo de entrada de telefone
            const phoneInput = document.createElement('input');
            phoneInput.type = 'text';
            phoneInput.classList.add('phone-input');
            phoneInput.placeholder = "Enter your phone number";

            // Adicionar o select e o campo de telefone ao container
            container.innerHTML = '';
            container.appendChild(select);
            container.appendChild(phoneInput);

            // Inicializar o Select2 no select de bandeiras
            $(select).select2({
                templateResult: formatCountry,
                templateSelection: formatCountry
            });

            // Atualizar o valor do campo de telefone conforme a seleção do país
            select.addEventListener('change', function() {
                phoneInput.value = this.value + ' ';
                phoneInput.focus();
            });

            // Formatar o número de telefone enquanto o usuário digita
            phoneInput.addEventListener('input', function() {
                let value = this.value.replace(/[^\d]/g, '');
                let formattedValue = formatPhoneNumber(value);
                this.value = formattedValue;
            });
        }

        function formatCountry(country) {
            if (!country.id) {
                return country.text;
            }
            const baseUrl = "https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/flags/4x3/";
            const $country = $(
                `<span><img src="${baseUrl}${country.element.dataset.code.toLowerCase()}.svg" class="img-flag" /> ${country.text}</span>`
            );
            return $country;
        }

        function formatPhoneNumber(value) {
            // Implementar a formatação do número de telefone conforme necessário
            // Esta função pode ser ajustada para formatar o número conforme o país selecionado
            return value.replace(/(\d{1,3})(\d{1,4})(\d{1,4})/, '$1 $2 $3').trim();
        }

        window.onload = function() {
            initWhatsAppInput('phone-input');
        };
    </script>
</body>
</html>
