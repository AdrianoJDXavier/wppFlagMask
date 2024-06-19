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
      padding: 10px 10px 10px 60px;

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
      const countrySelect = j(`
    <select>
      <option value="+55" data-mask="(00) 00000-0000" data-ddi="+55">🇧🇷</option>
      <option value="+1" data-mask="(000) 000-0000" data-ddi="+1">🇺🇸</option>
      <option value="+44" data-mask="0000 000 000" data-ddi="+44">🇬🇧</option>
      <option value="+61" data-mask="0000 000 000" data-ddi="+61">🇦🇺</option>
      <option value="+33" data-mask="00 00 00 00 00" data-ddi="+33">🇫🇷</option>
      <option value="+49" data-mask="000 00000000" data-ddi="+49">🇩🇪</option>
      <option value="+81" data-mask="00-0000-0000" data-ddi="+81">🇯🇵</option>
      <option value="+39" data-mask="000 000 0000" data-ddi="+39">🇮🇹</option>
      <option value="+34" data-mask="000 000 000" data-ddi="+34">🇪🇸</option>
      <option value="+86" data-mask="000 0000 0000" data-ddi="+86">🇨🇳</option>
      <option value="+91" data-mask="00000 00000" data-ddi="+91">🇮🇳</option>
      <option value="+7" data-mask="000 000-00-00" data-ddi="+7">🇷🇺</option>
      <option value="+62" data-mask="0000-0000-0000" data-ddi="+62">🇮🇩</option>
      <option value="+92" data-mask="0000-0000000" data-ddi="+92">🇵🇰</option>
      <option value="+63" data-mask="0000 000 0000" data-ddi="+63">🇵🇭</option>
      <option value="+90" data-mask="000 000 0000" data-ddi="+90">🇹🇷</option>
      <option value="+82" data-mask="00-000-0000" data-ddi="+82">🇰🇷</option>
      <option value="+31" data-mask="00 000 0000" data-ddi="+31">🇳🇱</option>
      <option value="+27" data-mask="000 000 0000" data-ddi="+27">🇿🇦</option>
      <option value="+46" data-mask="00-000 00 00" data-ddi="+46">🇸🇪</option>
      <option value="+47" data-mask="000 00 000" data-ddi="+47">🇳🇴</option>
      <option value="+48" data-mask="000 000 000" data-ddi="+48">🇵🇱</option>
      <option value="+51" data-mask="000 000 000" data-ddi="+51">🇵🇪</option>
      <option value="+52" data-mask="00 0000 0000" data-ddi="+52">🇲🇽</option>
      <option value="+54" data-mask="00 0000-0000" data-ddi="+54">🇦🇷</option>
      <option value="+56" data-mask="0 0000 0000" data-ddi="+56">🇨🇱</option>
      <option value="+58" data-mask="000-0000000" data-ddi="+58">🇻🇪</option>
      <option value="+60" data-mask="0-000 0000" data-ddi="+60">🇲🇾</option>
      <option value="+65" data-mask="0000 0000" data-ddi="+65">🇸🇬</option>
      <option value="+66" data-mask="00 000 0000" data-ddi="+66">🇹🇭</option>
      <option value="+20" data-mask="0 000 000 000" data-ddi="+20">🇪🇬</option>
    </select>
  `);

      selectContainer.append(countrySelect);
      campo.wrap('<div class="phone-mask-container-wpp-mask"></div>');
      campo.before(selectContainer);
      let isDDIPrefixed = false;
      setTimeout(function() {
        campo.trigger('focus');
      }, 100);
      campo.on('focus', function() {
        console.log(campo.val())
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
    }
  </script>
</body>

</html>