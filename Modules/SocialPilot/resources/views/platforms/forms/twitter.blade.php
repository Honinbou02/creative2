
<input type="hidden" name="id" value="{{ $platform->id }}">
<div class="mb-3">
    <x-form.label for="credentials[api_key]" label="{{ localize('API Key') }}" isRequired=true />
    <x-form.input id="credentials[api_key]" name="credentials[api_key]" type="text" placeholder="{{ localize('API key') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->api_key ?? ''  : ''}}" showDiv=false required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[api_secret]" label="{{ localize('API Secret') }}" isRequired=true />
    <x-form.input id="credentials[api_secret]" name="credentials[api_secret]" type="text" placeholder="{{ localize('API secret') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->api_secret ?? ''  : ''}}" showDiv=false  required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[access_token]" label="{{ localize('Access Token') }}" isRequired=true />
    <x-form.input id="credentials[access_token]" name="credentials[access_token]" type="text" placeholder="{{ localize('Access token') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->access_token ?? ''  : ''}}" showDiv=false  required/>
</div>
<div class="mb-3">
    <x-form.label for="credentials[access_token_secret]" label="{{ localize('Access Token Secret') }}" isRequired=true />
    <x-form.input id="credentials[access_token_secret]" name="credentials[access_token_secret]" type="text" placeholder="{{ localize('Access token secret') }}" value="{{$platform->credentials ? json_decode($platform->credentials)->access_token_secret ?? ''  : ''}}" showDiv=false  required/>
</div>
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
    <x-form.label for="credentials[callback_url]" label="{{ localize('Callback Url') }}" />
    <x-form.input id="credentials[callback_url]" name="credentials[callback_url]" type="text" placeholder="{{ localize('Callback Url') }}" value="{{ route('social.accounts.callback', ['platform' => 'twitter']) }}" showDiv=false disabled/>
</div>