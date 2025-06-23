
<input type="hidden" name="id" value="{{ $platform->id }}">
<div class="mb-3">
    <x-form.label for="credentials[client_id]" label="{{ localize('Client Id') }}" isRequired=true />
    <x-form.input id="credentials[client_id]" name="credentials[client_id]" type="text" placeholder="{{ localize('Client Id') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->client_id ?? ''  : ''}}" showDiv=false required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[client_secret]" label="{{ localize('Client Secret') }}" isRequired=true />
    <x-form.input id="credentials[client_secret]" name="credentials[client_secret]" type="text" placeholder="{{ localize('Client secret') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->client_secret ?? ''  : ''}}" showDiv=false  required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[app_version]" label="{{ localize('App Version') }}" isRequired=true />
    <x-form.input id="credentials[app_version]" name="credentials[app_version]" type="text" placeholder="{{ localize('App version') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->app_version ?? ''  : ''}}" showDiv=false  required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[graph_api_url]" label="{{ localize('Graph API Url') }}" isRequired=true />
    <x-form.input id="credentials[graph_api_url]" name="credentials[graph_api_url]" type="text" placeholder="{{ localize('Graph API url') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->graph_api_url ?? '' : ''}}" showDiv=false  required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[callback_url]" label="{{ localize('Callback Url') }}" />
    <x-form.input id="credentials[callback_url]" name="credentials[callback_url]" type="text" placeholder="{{ localize('Callback Url') }}" value="{{ route('social.accounts.callback', ['platform' => 'instagram']) }}" showDiv=false disabled/>
</div>