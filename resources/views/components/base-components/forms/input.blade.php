<div>

    @error($name)
        <div @class(["alert", "alert-danger"])>
            {{ $forError }}
        </div>
    @enderror

    <div class="form-outline mb-4">

        <label
            for="{{ $name }}"

            @class(["form-label", "d-flex", "justify-content-start"])
        >{{ $label }}</label>

        <input
            name="{{ $name }}"
            type="{{ $type }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"

            @class(["form-control", "form-control-lg", "formInputFieldBackground"])
            @required($isRequired)
        >

    </div>
</div>
