<input type="hidden" name="id" class="id" value="{{ $quickText?->id ?? null }}">
<div class="mb-3">
    <x-form.label for="title" label="{{ localize('Title') }}" isRequired=true />
    <x-form.input id="title" name="title" type="text" placeholder="{{ localize('Title') }}" value="{{ $quickText?->title ?? '' }}" showDiv=false  required/>
</div>

<div class="mb-3">
    <x-form.label for="description" label="{{ localize('Description') }}" isRequired=true />
    <x-form.textarea id="description" name="description" type="text" placeholder="{{ localize('Description') }}" value="{{ $quickText?->description ?? '' }}" showDiv=false  required/>
</div>