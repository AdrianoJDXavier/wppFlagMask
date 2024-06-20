<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Máscara de Telefone com Bandeiras</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

  <style>
    .phone-mask-container-wpp-mask {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      position: relative;
    }

    .rp_mask-wpp {
      padding: 10px 10px 10px 3%;

    }

    .select-container-wpp-mask {
      position: absolute;
      top: 10px;
      left: 10px;
      display: flex;
      align-items: center;
    }

    .select-container-wpp-mask select {
      border: none;
      background: transparent;
      font-size: 16px;
      appearance: none;
      padding-right: 20px;
      /* Espaço para o ícone */
      cursor: pointer;
    }

    .select-container-wpp-mask select:focus {
      outline: none;
    }

    input.rp-input:not(.bootstrap-select),
    select.rp-input:not(.bootstrap-select),
    .bootstrap-select.rp-input>button,
    .bootstrap-select.rp-input .bs-searchbox>input:first-child {
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

    .rp-input {
      transition: 0.2s;
    }
  </style>
</head>

<body>
  <form action="data.php" method='POST'>
    <div class="phone-mask-container">
      <input type="text" name='tel1' class="rp_mask-wpp rp-input" placeholder="Digite o número de telefone">

      <input type="text" name='tel2' class="rp_mask-wpp" placeholder="Digite o número de telefone">
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
        campo.css('padding-left', '3%')
      }
      const selectContainer = j('<div class="select-container-wpp-mask"></div>');
      const countrySelect = createCountrySelect();

      selectContainer.append(countrySelect);
      campo.wrap('<div class="phone-mask-container-wpp-mask"></div>');
      campo.before(selectContainer);
      let isDDIPrefixed = false;
      setTimeout(function() {
        campo.trigger('focus');
      }, 100);
      campo.on('focus', function() {
        const value = campo.val();
        let ddiFound = false;

        const fistOption = countrySelect.find('option')[0];
        fistOption.text = displayOnlyEmoji(fistOption.text)


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
          campo.val(value)
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
        console.log(selectedOption.html())
        selectedOption.text(displayOnlyEmoji(selectedOption.text()))
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

      function displayOnlyEmoji(text) {
        return text.replace(/[^\p{Emoji_Presentation}]/gu, '')
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
            value: "+62",
            mask: "0000-0000-0000",
            ddi: "+62",
            flag: "🇮🇩",
            name: "Indonesia"
          },
          {
            value: "+92",
            mask: "0000-0000000",
            ddi: "+92",
            flag: "🇵🇰",
            name: "Pakistan"
          },
          {
            value: "+63",
            mask: "0000 000 0000",
            ddi: "+63",
            flag: "🇵🇭",
            name: "Philippines"
          },
          {
            value: "+90",
            mask: "000 000 0000",
            ddi: "+90",
            flag: "🇹🇷",
            name: "Turkey"
          },
          {
            value: "+82",
            mask: "00-000-0000",
            ddi: "+82",
            flag: "🇰🇷",
            name: "South Korea"
          },
          {
            value: "+31",
            mask: "00 000 0000",
            ddi: "+31",
            flag: "🇳🇱",
            name: "Netherlands"
          },
          {
            value: "+27",
            mask: "000 000 0000",
            ddi: "+27",
            flag: "🇿🇦",
            name: "South Africa"
          },
          {
            value: "+46",
            mask: "00-000 00 00",
            ddi: "+46",
            flag: "🇸🇪",
            name: "Sweden"
          },
          {
            value: "+47",
            mask: "000 00 000",
            ddi: "+47",
            flag: "🇳🇴",
            name: "Norway"
          },
          {
            value: "+48",
            mask: "000 000 000",
            ddi: "+48",
            flag: "🇵🇱",
            name: "Poland"
          },
          {
            value: "+51",
            mask: "000 000 000",
            ddi: "+51",
            flag: "🇵🇪",
            name: "Peru"
          },
          {
            value: "+52",
            mask: "00 0000 0000",
            ddi: "+52",
            flag: "🇲🇽",
            name: "Mexico"
          },
          {
            value: "+54",
            mask: "00 0000-0000",
            ddi: "+54",
            flag: "🇦🇷",
            name: "Argentina"
          },
          {
            value: "+56",
            mask: "0 0000 0000",
            ddi: "+56",
            flag: "🇨🇱",
            name: "Chile"
          },
          {
            value: "+58",
            mask: "000-0000000",
            ddi: "+58",
            flag: "🇻🇪",
            name: "Venezuela"
          },
          {
            value: "+60",
            mask: "0-000 0000",
            ddi: "+60",
            flag: "🇲🇾",
            name: "Malaysia"
          },
          {
            value: "+65",
            mask: "0000 0000",
            ddi: "+65",
            flag: "🇸🇬",
            name: "Singapore"
          },
          {
            value: "+66",
            mask: "00 000 0000",
            ddi: "+66",
            flag: "🇹🇭",
            name: "Thailand"
          },
          {
            value: "+20",
            mask: "0 000 000 000",
            ddi: "+20",
            flag: "🇪🇬",
            name: "Egypt"
          }
        ];

        // Crie o elemento select
        const select = j('<select class="country-select"></select>');

        // Adicione cada opção ao select
        countries.forEach(country => {
          const option = j(`<option value="${country.value}" data-mask="${country.mask}" data-ddi="${country.ddi}">${country.flag} <span>${country.name}</span></option>`);
            option.html(option.html().split(' ')[0] + ' <span>' + country.name + '</span>');
          select.append(option);
        });

        return select;
      }
    }
  </script>
</body>

</html>