<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máscara de Telefone com Bandeiras</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <style>
        /* .phone-mask-container-wpp-mask {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
        } */
        /* 
        .rp_mask-wpp {
            padding: 10px 10px 10px 3%;
        } */

        /* .select-container-wpp-mask {
            position: absolute;
             top: 10px;
            left: 10px; 
        } */

        .rp-input {
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom-width: medium;
            border-bottom-style: none;
            border-bottom-color: currentcolor;
            border-bottom: 1px solid #ced4da;
            border-radius: 0px !important;
            padding: 2px;
            height: 30px;
            line-height: 30px;
            color: #555555;
        }

        /* .bootstrap-select .dropdown-toggle {
            padding: 0px;
            height: 30px;
            line-height: 30px;
            border-radius: 0px !important;
        }

        .bootstrap-select .dropdown-toggle:focus {
            outline: none;
            box-shadow: none;
        }

        .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
            display: flex;
            align-items: center;
        } */
    </style>
</head>

<body>
    <form action="data.php" method="POST">
        <div class="phone-mask-container">
            <input type="text" name="tel1" class="rp_mask-wpp rp-input" placeholder="Digite o número de telefone">
            <br>
            <input type="text" name="tel2" class="rp_mask-wpp" placeholder="Digite o número de telefone">
            <button type="submit">Enviar</button>
        </div>
    </form>

    <script>
        j = jQuery.noConflict();

        j(document).ready(function() {
            rp_mask();
        });

        function rp_mask() {
            var campos = j(".rp_mask-wpp");
            campos.each(function() {
                var campo = j(this);
                rp_mask_wpp(campo);
            });
        }

        function rp_mask_wpp(campo) {
            if (campo.hasClass('rp-input')) {
                campo.css('padding-left', '0%');
            }
            const selectContainer = j('<div class="select-container-wpp-mask"></div>');
            const countrySelect = createCountrySelect();

            selectContainer.append(countrySelect);
            campo.wrap('<div class="phone-mask-container-wpp-mask"></div>');
            campo.before(selectContainer);
            let isDDIPrefixed = false;
            setTimeout(function() {
                campo.trigger('focus');
                j('.rp_mask-wpp').css({
                    'padding': '10px 10px 10px 3%'
                });
                j('.select-container-wpp-mask').css({
                    'position': 'absolute',
                })
                j('.bootstrap-select, .dropdown-toggle').css({
                    'width': '55px',
                    'bottom': '5%',
                    'right': '10%',
                    'background-color': 'transparent',
                });
            }, 100);

            // Inicializar o Bootstrap Select com pesquisa dinâmica
            countrySelect.selectpicker({
                liveSearch: true
            });
            j('.country-select').siblings('.dropdown-toggle').css('width', '200px');


            campo.on('focus', function() {
                const value = campo.val();
                let ddiFound = false;
                for (let i = 1; i <= 3; i++) {
                    const firstDigits = value.replace(/\D/g, '').substring(0, i);
                    if (firstDigits) {
                        const selectedOption = countrySelect.find('option[data-ddi^="+' + firstDigits + '"]');
                        if (selectedOption.length > 0) {
                            ddi = firstDigits;
                            mask = countrySelect.attr('data-ddi');
                            countrySelect.val(selectedOption.val());
                            countrySelect.trigger('change');
                            ddiFound = true;
                            break;
                        }
                    }
                }
                if (ddiFound) {
                    campo.val(value);
                    const selectedOption2 = countrySelect.find('option:selected');
                    const ddi2 = selectedOption2.attr('data-ddi');
                    const mask2 = selectedOption2.attr('data-mask');
                    aplicarMascaraComDDI(ddi2, mask2);
                }
            });

            countrySelect.on('change', function() {
                const selectedOption = countrySelect.find('option:selected');
                const ddi = selectedOption.attr('data-ddi');
                const mask = selectedOption.attr('data-mask');
                aplicarMascaraComDDI(ddi, mask);
                campo.val('');
                isDDIPrefixed = false;
            });

            campo.on("input", function() {
                const selectedOption = countrySelect.find('option:selected');
                const ddi = selectedOption.attr('data-ddi');
                var cursorPos = campo.get(0).selectionStart + ddi.length + 2;
                const mask = selectedOption.attr('data-mask');
                aplicarMascaraComDDI(ddi, mask);

                // Reposicionar o cursor
                setTimeout(function() {
                    campo.get(0).setSelectionRange(cursorPos, cursorPos);
                }, 0);
            });

            function aplicarMascaraComDDI(ddi, mask) {
                campo.unmask();
                campo.mask(ddi + ' ' + mask);
            }

            function createCountrySelect() {
                // Array de objetos com dados dos países
                const countries = [{
                        value: "+55",
                        mask: "(00) 00000-0000",
                        ddi: "+55",
                        flag: "🇧🇷",
                        name: "Brazil"
                    },
                    {
                        value: "+1",
                        mask: "(000) 000-0000",
                        ddi: "+1",
                        flag: "🇺🇸",
                        name: "USA"
                    },
                    {
                        value: "+44",
                        mask: "0000 000 000",
                        ddi: "+44",
                        flag: "🇬🇧",
                        name: "UK"
                    },
                    {
                        value: "+61",
                        mask: "0000 000 000",
                        ddi: "+61",
                        flag: "🇦🇺",
                        name: "Australia"
                    },
                    {
                        value: "+33",
                        mask: "00 00 00 00 00",
                        ddi: "+33",
                        flag: "🇫🇷",
                        name: "France"
                    },
                    {
                        value: "+49",
                        mask: "000 00000000",
                        ddi: "+49",
                        flag: "🇩🇪",
                        name: "Germany"
                    },
                    {
                        value: "+81",
                        mask: "00-0000-0000",
                        ddi: "+81",
                        flag: "🇯🇵",
                        name: "Japan"
                    },
                    {
                        value: "+39",
                        mask: "000 000 0000",
                        ddi: "+39",
                        flag: "🇮🇹",
                        name: "Italy"
                    },
                    {
                        value: "+34",
                        mask: "000 000 000",
                        ddi: "+34",
                        flag: "🇪🇸",
                        name: "Spain"
                    },
                    {
                        value: "+86",
                        mask: "000 0000 0000",
                        ddi: "+86",
                        flag: "🇨🇳",
                        name: "China"
                    },
                    {
                        value: "+91",
                        mask: "00000 00000",
                        ddi: "+91",
                        flag: "🇮🇳",
                        name: "India"
                    },
                    {
                        value: "+7",
                        mask: "000 000-00-00",
                        ddi: "+7",
                        flag: "🇷🇺",
                        name: "Russia"
                    },
                    {
                        value: "+92",
                        mask: "000 0000000",
                        ddi: "+92",
                        flag: "🇵🇰",
                        name: "Pakistan"
                    }
                ];

                const select = j('<select class="country-select rp-input" data-live-search="true"></select>');

                // Adicionar países como opções
                countries.forEach(country => {
                    const option = j('<option></option>');
                    option.val(country.value);
                    option.text(country.flag + " " + country.name);
                    option.attr('data-mask', country.mask);
                    option.attr('data-ddi', country.ddi);
                    option.attr('data-name', country.name);
                    select.append(option);
                });

                return select;
            }
        }
    </script>
</body>

</html>
