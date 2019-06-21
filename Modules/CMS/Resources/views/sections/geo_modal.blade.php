<div class="modal alert select--country" id="selectCountry">
  <div class="modal__inner ps-container">
    <header class="modal__head">
      <h5 class="modal__title highlight">@lang('cms::geo_modal.title')</h5>
    </header>
    <div class="modal__body">
      <p>@lang('cms::geo_modal.text')</p>
      <p>
        <select name="country" id="">
          <option value="1" selected disabled>@lang('cms::geo_modal.country_placeholder')</option>
          <option value="2">Argentina</option>
          <option value="3">Bolivia</option>
          <option value="3">Brasil</option>
          <option value="3">Chile</option>
          <option value="3">Colombia</option>
          <option value="3">Costa Rica</option>
          <option value="3">Ecuador</option>
          <option value="3">El Salvador</option>
          <option value="3">EspaÃ±a</option>
          <option value="3">EUA/USA</option>
          <option value="3">Guatemala</option>
          <option value="3">Italia</option>
          <option value="3">MÃ©xico</option>
          <option value="3">Nicaragua</option>
          <option value="3">PanamÃ¡</option>
          <option value="3">Paraguay</option>
          <option value="3">PerÃº</option>
          <option value="3">RepÃºblica Dominicana</option>
          <option value="3">Rusia/Ð Ð¾ÑÑÐ¸Ñ</option>
          <option value="3">Uruguay</option>
        </select>
        <select name="language" id="">
          <option value="1" selected disabled>@lang('cms::geo_modal.country_placeholder')</option>
          <option value="2">EspaÃ±ol</option>
          <option value="3">InglÃ©s</option>
        </select>
        <label for="postalcode">
          <span>@lang('cms::geo_modal.zip.label'):</span>
          <input type="text" placeholder="@lang('cms::geo_modal.zip.placeholder')">
        </label>
      </p>
    </div>
    <footer class="modal__foot">
      <div class="buttons-container">
        <button class="button secondary country close" type="button">@lang('cms::geo_modal.go_button')</button>
      </div>
    </footer>
  </div>
</div>
